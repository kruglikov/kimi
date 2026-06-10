# Upgraded Source (`src/upgraded-src/`)

## Purpose

`src/upgraded-src/` is the target location for all modernization work on the KIMI Portal. It contains the PHP 8.5-compatible version of the application, produced by applying automated Rector transformations and manual fixes to the preserved legacy source in `src/original-src/`.

`src/original-src/` is the read-only reference baseline. `src/upgraded-src/` is where all upgrade, security, and refactoring work is applied.

## Folder Layout

```
src/upgraded-src/
├── docker-compose.yml                          ← Compose entry point for the upgraded stack
├── docker/
│   ├── php/
│   │   ├── Dockerfile                          ← php:8.5-apache + mysqli + mod_rewrite
│   │   ├── vhost.conf                          ← Apache virtual host
│   │   └── zz-mysqli-socket.ini                ← mysqli socket config for local MariaDB
│   └── mariadb/
│       └── init/
│           ├── 01-init.sql                     ← kimi_archiv DB + users
│           ├── 02-schema.sql                   ← schema (original + upgrade additions)
│           ├── 03-dev-seed.sql                 ← local dev seed data
│           ├── 05-batch-tables.sql             ← scratch tables for batch check scripts
│           └── 06-batch-stubs.sql              ← stub functions + campaign import tables
├── web/
│   ├── htdocs/kimi_ET/                         ← modernized PHP 8.5 application source
│   └── exchange/{campaign_id}/IN|OUT/          ← Elsbeth file exchange (same structure as original-src)
├── tests/                                      ← PHPUnit smoke test suite (see smoke-tests-upgraded-src.md)
│   ├── run-all.sh
│   ├── harness/                                ← session bootstrap harness for GUI/module tests
│   └── SmokeTest/                              ← 6 test suites (Batch, Gui, Initial, Menu, Router, TopLevel)
└── tooling/
    └── php-upgrade/
        ├── rector.php                          ← Rector config: PHP_81 through PHP_85 only
        ├── phpcs.xml.dist                      ← PHPCompatibility config
        └── scripts/
            ├── install-tools.sh
            ├── run-all-scans.sh
            ├── run-phpcompatibility.sh
            └── run-rector-dry-run.sh
```

## Local Development (Docker)

```bash
# Start upgraded stack
docker compose -f src/upgraded-src/docker-compose.yml up -d --build

# Stop
docker compose -f src/upgraded-src/docker-compose.yml down

# Logs
docker compose -f src/upgraded-src/docker-compose.yml logs -f web
docker compose -f src/upgraded-src/docker-compose.yml logs -f db
```

| URL                              | What                            |
|----------------------------------|---------------------------------|
| `http://localhost:8081/kimi_ET/` | Portal application (PHP 8.5)    |
| `http://localhost:8081/`         | Marketing landing page          |
| `localhost:3307`                 | MariaDB (for DBeaver / Adminer) |

Credentials are the same as `original-src`: portal user `admin` / `admin123`.

## Modification Policy

- `src/original-src/web/` — **read-only reference**. Do not apply PHP upgrade work here. Only narrow legacy hotfixes are allowed, and they must be explicitly documented.
- `src/upgraded-src/web/htdocs/` — **default target** for all upgrade work, security fixes, compatibility patches, and refactoring.
- `src/upgraded-src/docker/` — may be extended to support smoke tests, seed data, or DB schema additions needed for local validation.
- When a bug is found in `src/original-src/web/`, document it in the analysis task and carry the fix into `src/upgraded-src/`.

## Rector Tooling

Rector is the automated PHP compatibility upgrade tool. The config lives at:

`src/upgraded-src/tooling/php-upgrade/rector.php`

Key configuration decisions:
- Applies **only** `SetList::PHP_81` through `SetList::PHP_85` — scoped to PHP 8.0→8.5 migration, no pre-8.0 modernization rules.
- Explicitly **skips** `RemoveFuncCallRector` (not a compatibility rule; can remove runtime calls and introduce behavior changes).
- Explicitly **skips** `adminer-4.8.1.php`, `kimibatch/files/vendor/`, and `libs/addons/phpmail/` (third-party or legacy bundles not owned by this upgrade).

To run a dry run (no changes written):
```bash
docker compose -f src/upgraded-src/docker-compose.yml exec web \
  src/upgraded-src/tooling/php-upgrade/vendor/bin/rector process \
  --config src/upgraded-src/tooling/php-upgrade/rector.php --dry-run
```

To apply:
```bash
docker compose -f src/upgraded-src/docker-compose.yml exec web \
  src/upgraded-src/tooling/php-upgrade/vendor/bin/rector process \
  --config src/upgraded-src/tooling/php-upgrade/rector.php
```

## Current Upgrade Status

| Step                                     | Status                                               |
|------------------------------------------|------------------------------------------------------|
| Docker environment on PHP 8.5            | Done                                                 |
| Rector automated pass (PHP 8.0→8.5)      | Done — 51 files changed                              |
| Manual fixes for residual PHP 8.5 issues | Done                                                 |
| Smoke test baseline on PHP 8.5           | **Green: 216 tests, 0 failures**                     |
| Security review                          | Done — findings in `docs/04-results/Audit-report.md` |
| GDPR review                              | Done — findings in `docs/04-results/Audit-report.md` |

See `smoke-tests-upgraded-src.md` for the full smoke baseline detail.

## What Rector Changed (Summary)

The primary transformation applied by the safe Rector pass was `NullToStrictStringFuncCallArgRector`:

- Added explicit `(string)` casts to string function arguments that could receive `null`
- Example: `strlen($x)` → `strlen((string) $x)`
- Purpose: prevent PHP 8.1+ null-to-string deprecations and PHP 8.5 compatibility errors

51 files were changed by the automated pass.

## Known Open Items

- `ticketsuch_sich20150208.php` — legacy module using an older 2-argument `Ticket::count()` API; excluded from smoke baseline pending a separate migration task. See `smoke-tests-upgraded-src.md` for full explanation.
- `getticketurl.php` — depends on DB stored function `getCleanPhoneNoN` not present in the local smoke DB. Smoke-green via PHP-level suppression; full correctness requires the stored function in production.
- Security issues S1–S6 identified in the audit are not yet fixed. They are documented in `docs/04-results/Audit-report.md` and are the next planned work phase.