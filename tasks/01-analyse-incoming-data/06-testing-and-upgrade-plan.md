# Testing Strategy & PHP 8.5 Upgrade Approach

Date: 2026-05-04

---

## Part 1 — Runtime Smoke Tests

### Goal

Verify that all PHP files (GUI pages, AJAX handlers, batch scripts) run without PHP fatal/parse errors.  
This is the baseline safety net for the PHP 8.5 upgrade.

### Scope

| Category | Count | Test method |
|---|---|---|
| GUI modules (`modules/gui/*.php`) | 13 | PHP subprocess via session bootstrap harness |
| AJAX handlers (`ajax/*.php`) | 4 | PHP subprocess via session bootstrap harness |
| Batch scripts (contain `include kimi_general.php`) | 117 | PHP subprocess, direct CLI |
| Campaign templates (`modules/gui/templates/**/*.php`) | 28 | Covered indirectly via `ticket.php` in GUI modules |
| **Total directly tested** | **134** | |

Entity classes (45 files in `libs/entities/`) are library code — they are covered indirectly when GUI modules and batch scripts load and call them.

Files are **discovered at runtime via `glob()` / `grep`** — no hardcoded list.  
New files added to the codebase are automatically picked up on the next test run.

### Folder Structure

```
src/original-src/tests/
├── composer.json              ← PHPUnit as the only dev dependency
├── phpunit.xml                ← points test suite at SmokeTest/
├── README.md                  ← how to run (see below)
├── harness/
│   ├── gui_runner.php         ← bootstraps app (chdir → init.php → session seed), then includes $argv[1]
│   └── fixtures/
│       └── csv/               ← 1-line stub CSVs placed at expected exchange/ paths
└── SmokeTest/
    ├── GuiSmokeTest.php       ← data-driven: iterates 13 GUI + 4 AJAX modules
    └── BatchSmokeTest.php     ← data-driven: iterates 117 batch scripts
```

### Design Details

#### `harness/gui_runner.php`

A small standalone PHP file. Bootstraps the portal without touching any app code:

1. `chdir()` to `web/htdocs/kimi_ET/`
2. Sets `$_SERVER['HTTP_USER_AGENT']`, `$_SERVER['HTTP_HOST']`, `$_SERVER['REQUEST_URI']`
3. `include './libs/init.php'` — loads config, session, DB, App singleton
4. Seeds `$_SESSION['user']` with the dev `admin` user and `$_SESSION['mandant']` with mandant ID 1
5. Sets `App::$CURRENT->USER` and `App::$CURRENT->MANDANT`
6. `include $argv[1]` — the module under test; output is captured by the caller

No changes to any app file are required.

#### `GuiSmokeTest.php`

```
foreach (glob('modules/gui/*.php')) as $module:
    exec("php harness/gui_runner.php $module", $output, $exitCode)
    assert exitCode == 0
    assert output does not contain "Fatal error:" or "Parse error:"
```

AJAX handlers use the same harness.

#### `BatchSmokeTest.php`

```
scripts = grep -rl 'include.*kimi_general.php' kimibatch/
foreach script:
    exec("php $script", $output, $exitCode)
    assert exitCode == 0
    assert output does not contain "Fatal error:" or "Parse error:"
```

#### CSV Fixtures

Batch scripts read from `web/exchange/{campaign_id}/IN/` (and write to `OUT/`).  
We place **1-line stub CSV files** (header row only) at those paths before running tests.  
Scripts find the file, see 0 data rows, exit cleanly — no real data is mutated.

Fixture CSVs live in `tests/harness/fixtures/csv/` and are symlinked or copied to the exchange paths as part of test setup.

### How to Run

```bash
# 1. Start the Docker stack
./scripts/up-original.sh -d

# 2. Install PHPUnit inside container (one-time)
docker compose -f src/original-src/docker-compose.yml exec web \
  composer install --working-dir=/var/www/tests

# 3. Run all smoke tests
docker compose -f src/original-src/docker-compose.yml exec web \
  php /var/www/tests/vendor/bin/phpunit --testdox

# 4. Run just GUI tests
docker compose -f src/original-src/docker-compose.yml exec web \
  php /var/www/tests/vendor/bin/phpunit --testdox --filter GuiSmokeTest

# 5. Run just batch tests
docker compose -f src/original-src/docker-compose.yml exec web \
  php /var/www/tests/vendor/bin/phpunit --testdox --filter BatchSmokeTest
```

A passing run means every tested file loads and executes without a PHP fatal or parse error on the current PHP version. A failing run names the exact file that crashed.

---

## Part 2 — PHP 8.5 Upgrade Strategy: Canonical-First Approach

### Principle

The codebase is ~95% copy-pasted (per system documentation slide 19).  
Rather than fixing every file independently, we:

1. **Identify canonical ("source") files** — the originals that were copied to create the rest
2. **Fix the canonical file** — apply PHP 8.5 compatibility fixes, review carefully
3. **Record in the memory bank** — document what changed, which family it belongs to, where all copies are
4. **Propagate to copies** — use Rector (automated) or targeted `sed`/`grep` to apply the same transforms to the copy family

This preserves the client's established copy-paste workflow while making the upgrade systematic and auditable.

### Tool: Rector

Rector (PHP automated refactoring tool) will be used to apply known PHP 8.2–8.5 migration rules.  
Known issues in this codebase covered by Rector rulesets:

| Issue | PHP version | Rector rule |
|---|---|---|
| `mysqli_error()` without connection argument | Fatal on 8.2 | `MysqliQueryWithoutConnectionRector` |
| Implicitly nullable parameters (`?T = null`) | Deprecated 8.4 | `AddArgsToImplicitlyNullableParamRector` |
| `utf8_encode()` / `utf8_decode()` | Deprecated 8.2 | `Utf8EncodeDecodeToMbStringRector` |
| `"${var}"` string interpolation | Deprecated 8.2 | `StringInterpolationToVariableRector` |

### Batch Script Families

The canonical source files and their copy families are documented in:  
**`memory-bank/batch-script-families.md`** (to be created)

Known families (to be verified by diff analysis):

| Canonical | Copy family | Notes |
|---|---|---|
| `coeo*.php` | `coeoch`, `coeochde`, `coeodrei` | COEO is the original; CH/DE variants are adaptations |
| `inko2016*.php` | `inkode`, `inkoSepa` | INKO 2016 appears to be the base |
| `knp1*.php` | — | Standalone campaign |
| `oko*.php` | — | Standalone campaign |
| `schlaustrom*.php` | — | Standalone campaign |
| `quester*.php` | — | One-off export, likely derived |
| `kpis*.php` | — | Cross-campaign KPI reporting |

### Memory Bank Record per Fix

For each PHP 8.5 compatibility fix applied to a canonical file, record in the memory bank:

```
Fix: <description>
Canonical file: <path>
Before: <code snippet>
After: <code snippet>
Copies affected: <list of file paths>
Status: [ ] pending propagation / [x] propagated
```

### Workflow

```
1. Run smoke tests on original-src → baseline (some may already fail on PHP 8.5)
2. For each canonical file family:
   a. Run Rector on canonical file
   b. Review Rector output (before/after diff)
   c. Record fix in memory bank
   d. Run Rector on copy family files
   e. Re-run smoke tests for that family
3. All 134 smoke tests pass → upgrade complete for this layer
```
