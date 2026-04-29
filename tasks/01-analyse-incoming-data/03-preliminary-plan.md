
# Preliminary plan

# PHP 8.0.30 → 8.5 Upgrade: Tools and Strategy

---

## Prerequisites (Blockers)

### For upgrade work (Phase 1–3)
None. Static analysis and all code edits can be done without a running environment.

Optional but recommended:
- PHP 8.5 binary on dev machine (`php -l` syntax lint on all 300 files, ~15 min setup on Ubuntu via `ondrej/php` PPA)

### For runtime/visual verification (Phase 4)
The archive contains **no database dump** — only batch-operation SQL scripts and temp-table scripts. The app crashes fatally on the first DB connection without a schema + data. Client must provide one of:

- A `mysqldump` of the `kimi_et` database (anonymized data is sufficient), **or**
- Access to a staging environment with MySQL already running

Without this, end-to-end smoke testing cannot be performed on our side. The upgrade deliverable will be the corrected codebase + PHPCompatibility report showing 0 errors; runtime validation is the client's responsibility unless the dump is provided.

### Docker
No Docker setup exists in the archive. A `docker-compose.yml` (PHP 8.5 + Apache + MySQL) would need to be written from scratch. This is only worth doing if the client provides the DB dump (Option D below); without it, Docker only proves PHP parses correctly — which `php -l` covers more cheaply.

**Testing environment options (least → most effort):**

| Step                                                                  | What it proves                         | DB needed?                       | Effort                         |
|-----------------------------------------------------------------------|----------------------------------------|----------------------------------|--------------------------------|
| 1 — Static analysis (PHPCompatibility + Rector, see Phase 1–2 below) | No compatibility errors in code        | No                               | ~0 setup                       |
| 2 — `php -l` lint locally (PHP 8.5 binary)                           | No parse/syntax errors                 | No                               | 15 min                         |
| 3 — Docker PHP 8.0 + Apache + MySQL + client dump                    | Baseline: app works before our changes | **Yes — confirmed prerequisite** | ~1 h                           |
| 4 — Docker PHP 8.5 + Apache + MySQL + client dump                    | Post-upgrade smoke test                | **Yes — confirmed prerequisite** | ~30 min (Docker image swap)    |

**Plan:** Steps 1 and 2 run before any code changes. Step 3 establishes a working baseline on PHP 8.0. After all code changes, Step 4 confirms compatibility on PHP 8.5.

---


## Migration Approach: One Leap (8.0 → 8.5 directly)

The target is PHP 8.5 — intermediate versions (8.1, 8.2, 8.3) will never run in production, so gradual stepping adds no value. All breaking changes are cumulative: to reach 8.5 you must fix every 8.1+8.2+8.3+8.4+8.5 issue regardless of path. PHPCompatibility handles the full range in a single pass with `--runtime-set testVersion 8.1-8.5` and labels each finding with the version that introduced it, giving the same segmented view without needing four separate environments.

---

## Phase 1: Static Analysis (Audit — no code changes)

### Tool 1: PHP_CodeSniffer + PHPCompatibility ruleset (primary tool)

```bash
composer require --dev squizlabs/php_codesniffer \
    dealerdirect/phpcodesniffer-composer-installer \
    phpcompatibility/php-compatibility

./vendor/bin/phpcs \
    --standard=PHPCompatibility \
    --runtime-set testVersion 8.1-8.5 \
    --extensions=php \
    web/htdocs/kimi_ET/
```

Flags every deprecated/removed function, changed signature, and behavior change between 8.1–8.5 across all ~300 PHP files. Output is per-file/line, each finding tagged with the PHP version that introduced it.

### Tool 2: Rector (dry-run only — no writes during audit)

```bash
composer require --dev rector/rector

# rector.php config targeting PHP 8.5
./vendor/bin/rector process --dry-run web/htdocs/kimi_ET/
```

Shows which changes *can* be automated. Useful for estimating the automation percentage and reducing manual effort estimate.

---

## Phase 2: Known Issues From Code Reading

Before running the tools, issues already identified by reading the source:

| Severity   | File                                        | Issue |
|------------|---------------------------------------------|---|
| **High**   | `libs/addons/phpmail/class.phpmailer.php:4` | PHPMailer **v2.0.4** — incompatible with PHP 8.x. Must replace with v6.9+ |
| **High**   | `libs/database.php:22,36`                   | `mysqli_error()` called without argument — deprecated PHP 8.1, fatal PHP 8.2 |
| **Medium** | `libs/init.php:107`                         | `session_start()` has no `secure`/`httponly`/`samesite` options — GDPR/security |
| **Medium** | All entity/batch files                      | Scan for implicitly nullable params (`function foo(T $x = null)` → `?T`) — deprecated PHP 8.5 |
| **Medium** | `libs/database.php`                         | Every query opens+closes a new `mysqli_connect()` — regression risk under 8.5 |
| **Low**    | Whole codebase                              | Scan for `utf8_encode()`/`utf8_decode()` — deprecated PHP 8.2 |
| **Low**    | Whole codebase                              | Scan for `"${var}"` string interpolation — deprecated PHP 8.2 |

---

## Phase 3: Quick Grep Audit (targeted checks)

```bash
# Deprecated in PHP 8.1: mysqli_* functions now require explicit connection argument
grep -rn "mysqli_error()" web/htdocs/kimi_ET/
grep -rn "mysqli_errno()" web/htdocs/kimi_ET/
grep -rn "mysqli_affected_rows()" web/htdocs/kimi_ET/

# Deprecated in PHP 8.2
grep -rn "utf8_encode\|utf8_decode" web/htdocs/kimi_ET/
grep -rn '\${\|"${' web/htdocs/kimi_ET/

# Implicitly nullable (PHP 8.5 deprecation pattern)
grep -rn "function.*=\s*null" web/htdocs/kimi_ET/libs/

# PHPMailer version
grep -rn "Version:" web/htdocs/kimi_ET/libs/addons/phpmail/class.phpmailer.php
```

Note: PHPStan is excluded from this plan. The codebase has no type annotations, so PHPStan at any meaningful level generates mostly noise rather than migration-relevant findings. PHPCompatibility already catches the concrete compatibility issues (including the `mysqli_*` argument changes), and Rector dry-run covers what can be automated. If type-safety analysis is needed in a future refactoring phase, PHPStan can be introduced then.

---

## Phase 4: Migration Execution Strategy

**Step 0 — Establish baseline (before any code changes):**
- Stand up Docker with PHP 8.0 + Apache + MySQL using the client-provided `mysqldump`
- Verify the app boots, login works, and core flows are functional
- Document any pre-existing errors in PHP error log — these are not regressions, they are the client's current state
- This baseline is the rollback reference: if PHP 8.5 breaks something unexpected, revert to this Docker image

**Step 1 — Dependency replacement (highest risk, do first):**
- Replace `libs/addons/phpmail/` (PHPMailer 2.0.4) with Composer-managed `phpmailer/phpmailer:^6.9`
- A vendor/composer setup already exists in `kimibatch/files/vendor/` — extend it to cover the main app

**Step 2 — Automated fixes via Rector:**
```bash
./vendor/bin/rector process web/htdocs/kimi_ET/
```
Handles: implicitly nullable params, deprecated string interpolation, null coalescing patterns.

**Step 3 — Manual fixes:**
- Fix `mysqli_error()` calls: replace `or die(mysqli_error())` → `or die(mysqli_connect_error())` on connection failures, `or die(mysqli_error($identifier))` on query failures
- Fix `session_start()` to include `['cookie_secure' => true, 'cookie_httponly' => true, 'cookie_samesite' => 'Strict']`

**Step 4 — Test in Docker with PHP 8.5:**
```dockerfile
FROM php:8.5-apache
RUN docker-php-ext-install mysqli
# mount the kimi_ET directory
```
Run the app and check PHP error logs for any remaining `E_DEPRECATED` notices.

---

## Effort Estimate Basis

| Area                                 | Files      | Complexity                                               |
|--------------------------------------|------------|----------------------------------------------------------|
| Core libs (`libs/`)                  | ~50 files  | Medium — mysqli_error, session, PHPMailer                |
| Entity files (`libs/entities/`)      | ~45 files  | Low — mostly data wrappers                               |
| Module GUI/menu/initial (`modules/`) | ~70 files  | Low-Medium — mostly templates                            |
| Batch scripts (`kimibatch/`)         | ~140 files | Medium — many standalone scripts with own DB connections |
| AJAX handlers (`ajax/`)              | ~4 files   | Low                                                      |

The PHPMailer replacement and `mysqli_error()` fixes are the two critical path items for PHP 8.5 compatibility.

---

## Scope Boundary Note

**In scope:**
- PHP compatibility issues (all items above)
- Session security (GDPR-relevant: missing secure cookie flags)
- PHPMailer upgrade necessity

**Out of scope but worth noting in the report:**
- SQL injection vulnerabilities in `libs/entities/user.php:137` (raw string concatenation in login query) — GDPR relevance since it involves personal data access
- No prepared statements throughout the DB layer (`libs/database.php`)

---

## Risks and Open Questions

### Risks requiring investigation during Phase 1–2 scan

| Risk | PHP version | Where to look | Severity |
|------|-------------|---------------|----------|
| Dynamic properties on entity classes — setting undeclared object properties; deprecated PHP 8.2, fatal PHP 9 | 8.2 | `libs/entities/*.php` | Medium |
| `FILTER_SANITIZE_STRING` removed — not in grep audit list but commonly used for input sanitization | 8.1 | All form-handling files | Medium |
| Personal data encryption (Slide 11) — unknown crypto library/functions; if `openssl_*` usage is non-standard it may behave differently under 8.5 | 8.x | `libs/` — need to identify which files handle encryption | Medium |
| `FILTER_SANITIZE_STRING` — add to Phase 3 grep audit | 8.1 | All files | Medium |

### Structural gaps

**Composer autoload wiring (Step 1 risk):**
The main app has no Composer integration today. Adding PHPMailer via Composer requires `require_once __DIR__ . '/vendor/autoload.php'` in every bootstrap entry point — not just `libs/init.php`, but any standalone file that sends mail directly. If missed, PHPMailer class will not be found at runtime.

**95% copy-paste codebase (Slide 19):**
Manual fixes (`mysqli_error`, `session_start`) must propagate to all copies, not just the first occurrence found. After each manual fix step, run the corresponding grep again to confirm zero remaining matches.

**Batch scripts' separate Composer context:**
`kimibatch/files/vendor/` is an independent Composer setup from the main app. If any batch script uses PHPMailer (needs verification via grep), it requires a separate `composer require` in that context — not covered by the main app Composer setup.

**`initial/` scripts (Slide 21 — "no longer active"):**
These scripts are dead code but still present. Decision needed before scanning: either exclude them from PHPCompatibility scope (add to `--ignore` list) or delete them. If left in scope, any errors they produce are noise.

### Docker setup unknowns

**PHP extensions:** The archive contains no `php.ini` or extension list. The Docker image must declare all required extensions. Known requirement: `mysqli`. Likely also needed: `mbstring` (German text), `openssl` (encryption, Slide 11). Possibly: `gd`, `intl`. Missing extension = runtime crash not visible in static analysis. Need to grep for `extension_loaded()` calls and review `php.ini` with the client.

**Apache vhost config not in archive:** URL routing, `mod_rewrite` rules, document root path, upload size limits, and PHP runtime settings (memory limit, max execution time for batch scripts) are absent. The Docker Apache config will be a best-guess reconstruction. Some URL paths or file upload flows may break silently without the original config.

### Rollback
The PHP 8.0 Docker baseline (Step 0 of Phase 4) serves as the rollback reference. If PHP 8.5 produces unexpected runtime failures not caught by static analysis, the PHP 8.0 container + original code is the revert target. No production rollback strategy is defined here — that is outside project scope and on the client.
