# Smoke Test Infrastructure Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Create a runtime smoke test suite in `src/original-src/tests/` that verifies all PHP files (GUI modules, AJAX handlers, batch scripts) load and execute without PHP fatal or parse errors — fully decoupled from the app codebase, zero changes to `src/original-src/` existing files.

**Architecture:** PHPUnit 9.6 with two test classes. `GuiSmokeTest` runs each GUI/AJAX module via a bootstrap harness subprocess. `BatchSmokeTest` runs each batch script directly via CLI subprocess. Both discover files at runtime via `glob()` so new files are picked up automatically. Tests run inside the existing Docker network via `docker compose run --rm -v` (no docker-compose.yml changes needed).

**Tech Stack:** PHP 8.0, PHPUnit ^9.6, Docker Compose, MariaDB 10.5

---

## IMPORTANT: Deviations from original design (discovered during execution)

These are non-obvious issues encountered during implementation that the plan must reflect:

1. **`composer install` must run on host, not inside Docker** — `composer` is not installed in the Docker image. Run on host machine (requires PHP + Composer installed). Tested with Composer 2.8.12 / PHP 8.4 on host.

2. **`"config": {"platform": {"php": "8.0"}}` is mandatory in `composer.json`** — Without it, host PHP 8.4 resolves `doctrine/instantiator` 2.x which uses PHP 8.1+ syntax (`enum`-like constants). This causes a `ParseError` fatal inside Docker PHP 8.0. The platform config forces Composer to resolve packages compatible with PHP 8.0.

3. **`--working-dir` is a Composer flag, NOT a PHPUnit flag** — All Docker run commands must use `-w /var/www/tests` on the `docker compose run` command to set the working directory. Do NOT pass `--working-dir=/var/www/tests` to phpunit — it will be ignored/error.

4. **Docker path mismatch**: Inside Docker, tests are at `/var/www/tests` but app is at `/var/www/html`. Relative path `realpath(__DIR__ . '/../../web/htdocs/kimi_ET')` resolves correctly on host but fails inside Docker (would resolve to `/var/www/web/htdocs/kimi_ET` which doesn't exist). Fix pattern used everywhere:
   ```php
   $base = file_exists('/var/www/html/kimi_ET')
       ? '/var/www/html/kimi_ET'
       : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
   ```

5. **`modules/initial/*.php` pre-hooks ARE active** — `index.php` includes `./modules/initial/$module.php` if it exists before including the GUI module. These hooks set module-level variables (`$ticket`, `$kamp`, `$kampId`, `$akt`) that GUI modules depend on. ARCHITECTURE.md incorrectly says "no longer active". The harness must replicate this behavior.

6. **Seed `$_GET` params needed**: Many modules read `$_GET['ticket_id']`, `$_GET['mode']`, `$_GET['kId']`. Set `$_GET = ['ticket_id' => 1, 'mode' => 'SEL', 'kId' => 1]` in the harness using seed data from `03-dev-seed.sql`.

7. **`$_SESSION['kampId']` must be set separately** — Some modules read `$_SESSION['kampId']` directly (not via `App::$CURRENT`). Set it explicitly.

8. **`BatchSmokeTest::batchProvider()` needs same Docker/host path fix** — The original plan used only `realpath()` which fails inside Docker. Must use same detection pattern.

---

## File Map

All files are **new**. Nothing in existing `src/original-src/` files is modified.

| File | Purpose | Status |
|---|---|---|
| `src/original-src/tests/composer.json` | PHPUnit dev dependency | ✅ Done |
| `src/original-src/tests/phpunit.xml` | PHPUnit config | ✅ Done |
| `src/original-src/tests/harness/gui_runner.php` | Bootstraps portal app and includes GUI/AJAX module under test | ✅ Done |
| `src/original-src/tests/SmokeTest/GuiSmokeTest.php` | Data-driven: GUI + AJAX smoke tests | ✅ Done |
| `src/original-src/tests/SmokeTest/BatchSmokeTest.php` | Data-driven: batch script smoke tests | ✅ Done |
| `src/original-src/tests/README.md` | How to run | ✅ Done |

---

## How tests reach the database

**GUI tests** run inside Docker via `docker compose run`. The Docker network resolves `db` (the MariaDB service name), which is exactly what `config.php` sets as `CONF_MYSQL_SERVER`. GUI tests connect to the DB correctly.

**Batch tests** also run inside Docker. `kimibatch/db.php` hardcodes `$dbhost="localhost"`, which does not resolve to the DB service from inside the container. In practice, the batch layer does **not** exit cleanly: `mysqli_connect()` returns `false`, then `mysqli_set_charset(false, 'utf8')` throws a `TypeError` in `kimibatch/db.php`. This is a **real baseline failure** surfaced by the smoke tests, not a harness problem.

---

## Task 1: Scaffold test directory ✅ COMPLETE

**Files:**
- `src/original-src/tests/composer.json` — created
- `src/original-src/tests/phpunit.xml` — created
- `src/original-src/tests/vendor/` — installed

- [x] **Step 1: Create `src/original-src/tests/composer.json`**

```json
{
    "name": "kimi/smoke-tests",
    "description": "PHP smoke tests for KIMI Portal",
    "require-dev": {
        "phpunit/phpunit": "^9.6"
    },
    "autoload-dev": {
        "psr-4": {
            "KimiTest\\": "SmokeTest/"
        }
    },
    "config": {
        "platform": {
            "php": "8.0"
        }
    }
}
```

**CRITICAL**: The `"config": {"platform": {"php": "8.0"}}` section is mandatory. Without it, Composer (running on host PHP 8.4) installs `doctrine/instantiator` 2.x which is PHP 8.1+ and causes a ParseError inside Docker PHP 8.0.

- [x] **Step 2: Create `src/original-src/tests/phpunit.xml`**

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         colors="true">
    <testsuites>
        <testsuite name="Smoke">
            <directory>SmokeTest</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

- [x] **Step 3: Install PHPUnit (one-time, runs on host)**

`composer` is not available inside the Docker image. Run on host from the repository root:

```bash
composer install --working-dir=src/original-src/tests
```

Expected: `vendor/` directory appears inside `src/original-src/tests/`. Output ends with `Generating autoload files`.

- [x] **Step 4: Verify PHPUnit is available**

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --version
```

Expected: `PHPUnit 9.6.x by Sebastian Bergmann and contributors.`

---

## Task 2: GUI bootstrap harness ✅ COMPLETE

**Files:**
- `src/original-src/tests/harness/gui_runner.php` — created

- [x] **Step 1: Create `src/original-src/tests/harness/gui_runner.php`**

```php
<?php
// Launched as a subprocess by GuiSmokeTest.
// Usage: php gui_runner.php <absolute-path-to-module.php>

$modulePath = $argv[1] ?? '';
if (!$modulePath || !file_exists($modulePath)) {
    fwrite(STDERR, "gui_runner: file not found: $modulePath\n");
    exit(1);
}

// Inside Docker: tests → /var/www/tests, app → /var/www/html
// On host: tests → src/original-src/tests, app → src/original-src/web/htdocs
$appDir = file_exists('/var/www/html/kimi_ET')
    ? '/var/www/html/kimi_ET'
    : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
chdir($appDir);

$_SERVER['HTTP_USER_AGENT'] = 'SmokeTest/1.0';
$_SERVER['HTTP_HOST']       = 'localhost';
$_SERVER['REQUEST_URI']     = '/kimi_ET/';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_GET  = [
    'ticket_id' => 1,   // seed ticket from 03-dev-seed.sql
    'mode'      => 'SEL',
    'kId'       => 1,   // seed campaign
];
$_POST = [];

include './libs/init.php';

// Seed session with the dev admin user (created by 03-dev-seed.sql).
$user = User::getFromName('admin');
if (!$user) {
    fwrite(STDERR, "gui_runner: 'admin' user not found. Is 03-dev-seed.sql applied and the DB running?\n");
    exit(2);
}

$_SESSION['user']          = $user;
$_SESSION['mandant']       = Mandant::get(1);
$_SESSION['portal-kampId'] = 1;
$_SESSION['kampId']        = 1;
App::$CURRENT->USER        = $_SESSION['user'];
App::$CURRENT->MANDANT     = $_SESSION['mandant'];

// Replicate index.php routing: include the initial/ pre-hook if it exists.
// These hooks set module-level variables ($ticket, $kamp, $kampId, $akt, etc.)
// that the GUI module expects to already be defined.
$moduleName  = basename($modulePath, '.php');
$initialHook = "./modules/initial/$moduleName.php";
if (file_exists($initialHook)) {
    include $initialHook;
}

// Generic fallbacks for context variables that initial hooks may not have set.
// Modules that already got these from their initial hook are unaffected.
if (!isset($ticket))  { $ticket  = Ticket::get(1); }
if (!isset($kampId))  { $kampId  = 1; }
if (!isset($kamp))    { $kamp    = Kampagne::load_for_id(1); }
if (!isset($kampPath)){ $kampPath = "./modules/gui/templates/tickets/$kampId"; }

// Run the module; discard HTML output (we only care about errors).
ob_start();
include $modulePath;
ob_end_clean();
```

- [x] **Step 2: Verify the harness works for one module**

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  web php /var/www/tests/harness/gui_runner.php \
       /var/www/html/kimi_ET/modules/gui/portal.php; echo "Exit: $?"
```

Expected: `Exit: 0` with no `Fatal error` or `Parse error` on stdout/stderr.

---

## Task 3: GUI smoke test ✅ COMPLETE

**Files:**
- `src/original-src/tests/SmokeTest/GuiSmokeTest.php` — created

**Checkpoint status**: GUI suite was re-run on 2026-05-04 after the last `gui_runner.php` edit. Result: `17/17` passing.

- [x] **Step 1: Create `src/original-src/tests/SmokeTest/GuiSmokeTest.php`**

```php
<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

class GuiSmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/gui_runner.php';
    }

    /**
     * @dataProvider moduleProvider
     */
    public function testModuleLoadWithoutFatal(string $name, string $path): void
    {
        exec('php ' . escapeshellarg($this->runner) . ' ' . escapeshellarg($path) . ' 2>&1', $lines, $code);
        $out = implode("\n", $lines);

        $this->assertSame(0, $code,   "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function moduleProvider(): array
    {
        $base = file_exists('/var/www/html/kimi_ET')
            ? '/var/www/html/kimi_ET'
            : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
        $files = array_merge(
            glob($base . '/modules/gui/*.php') ?: [],
            glob($base . '/ajax/*.php')        ?: []
        );
        return array_map(fn($f) => [basename($f), $f], $files);
    }
}
```

- [x] **Step 2: Run GUI tests (re-verify after last harness fix)**

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox --filter GuiSmokeTest
```

Observed on 2026-05-04: `17` GUI/AJAX tests ran, `17` passed.

---

## Task 4: Batch script smoke test ✅ COMPLETE

**Files:**
- `src/original-src/tests/SmokeTest/BatchSmokeTest.php` — created

- [x] **Step 1: Create `src/original-src/tests/SmokeTest/BatchSmokeTest.php`**

**IMPORTANT**: Use Docker/host path detection (same pattern as GuiSmokeTest) — `realpath()` alone fails inside Docker.

```php
<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

class BatchSmokeTest extends TestCase
{
    /**
     * @dataProvider batchProvider
     */
    public function testBatchScriptRunsWithoutFatal(string $name, string $path): void
    {
        // timeout 60: prevents any script waiting on an external resource from blocking the suite.
        $command = sprintf(
            'cd %s && timeout 60 php %s 2>&1',
            escapeshellarg(dirname($path)),
            escapeshellarg(basename($path))
        );
        exec($command, $lines, $code);
        $out = implode("\n", $lines);

        $this->assertNotSame(124, $code, "$name: timed out after 60s");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function batchProvider(): array
    {
        // Docker/host path detection — same pattern as GuiSmokeTest
        $dir = file_exists('/var/www/html/kimi_ET/kimibatch')
            ? '/var/www/html/kimi_ET/kimibatch'
            : realpath(__DIR__ . '/../../web/htdocs/kimi_ET/kimibatch');
        $scripts = [];
        foreach (glob($dir . '/*.php') ?: [] as $file) {
            if (str_contains(file_get_contents($file), 'kimi_general.php')) {
                $scripts[] = [basename($file), $file];
            }
        }
        return $scripts;
    }
}
```

- [x] **Step 2: Run batch tests**

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox --filter BatchSmokeTest
```

Observed on 2026-05-04: `115` batch tests ran, `114` failed.

Baseline findings:
- The dominant failure is a real runtime fatal in [`db.php`](/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/db.php:84): `mysqli_connect()` fails against `localhost`, then [`mysqli_set_charset()`](/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/db.php:86) throws `TypeError` because the connection is `false`.
- At least one script has a direct parse error: [`coeochdeexptest.php`](/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/coeochdeexptest.php:24).
- One batch script passed.

---

## Task 5: README ✅ COMPLETE

**Files:**
- `src/original-src/tests/README.md` — created

- [x] **Step 1: Create `src/original-src/tests/README.md`**

````markdown
# KIMI Portal Smoke Tests

Runtime PHP smoke tests. Verifies all PHP modules and batch scripts execute without PHP fatal or parse errors.
This is the baseline safety net for the PHP 8.5 compatibility upgrade.

## Requirements

Docker stack must be running and fully initialized (schema + dev seed applied):
```bash
docker compose up -d
```

## Install PHPUnit (one-time, runs on host)

`composer` is not in the Docker image — run on host from the repository root:
```bash
composer install --working-dir=src/original-src/tests
```

## Run all tests

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox
```

## Run by suite

```bash
# GUI modules + AJAX handlers
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox --filter GuiSmokeTest

# Batch scripts (~117 files)
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox --filter BatchSmokeTest
```

## What is covered

| Category | Count | Method |
|---|---|---|
| GUI modules (`modules/gui/*.php`) | 13 | Bootstrap harness (`harness/gui_runner.php`) → direct include |
| AJAX handlers (`ajax/*.php`) | 4 | Bootstrap harness (`harness/gui_runner.php`) → direct include |
| Batch scripts (contain `kimi_general.php`) | ~117 | Direct CLI exec |
| **Total directly tested** | **~134** | |

## Notes on batch test output

Batch scripts connect to the DB using `$dbhost="localhost"`. Inside Docker, `localhost` refers to
the container itself (not the MariaDB service). In the current baseline, most batch scripts do not
exit cleanly: `kimibatch/db.php` calls `mysqli_set_charset()` after a failed `mysqli_connect()`,
which causes a fatal `TypeError`. This is a **real baseline failure**, not a harness bug.

## Adding new files

No list to maintain. Files are discovered at runtime — any new `.php` file added to `modules/gui/`,
`ajax/`, or `kimibatch/` (that contains `include kimi_general.php`) is automatically included in the
next test run.
````

- [x] **Step 2: Run the full suite as the baseline**

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$(pwd)/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox
```

Observed on 2026-05-04:
- `GuiSmokeTest`: `17/17` passing
- `BatchSmokeTest`: `115` tests, `114` failures
- Full suite: `132` tests, `114` failures

This is the **PHP 8.0 baseline** — the number that should improve (more passes, fewer failures) as PHP 8.5 compatibility fixes are applied in `src/upgraded-src/`.
