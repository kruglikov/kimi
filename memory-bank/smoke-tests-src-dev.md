# PHP Smoke Test Safety Net — `src-dev/`

## Purpose

This note describes the runtime smoke-test safety net for **`src-dev/`** — the tree that is actually deployed to the ANEXIA dev/test server. It is the third safety net in the project, alongside `smoke-tests-original-src.md` (for `src/original-src/`, PHP 8.0) and `smoke-tests-upgraded-src.md` (for `src/upgraded-src/`, PHP 8.5).

Like the other two, the suite answers one narrow question: do the selected runtime entrypoints execute without PHP fatal or parse errors? It is not a business-logic verification suite.

## What `src-dev/` is

`src-dev/original-src/web/htdocs/kimidev_ET/` is the working copy of the **app repo** `git@github.com:viktarkruhlikau/kimi.git` (branch `main`), and the repo root is the app directory, so it maps 1:1 onto the document root on the dev server at `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`. Deploys are `git pull` on the server; rollback is git. See `.claude/skills/kimi-connect-dev-server/SKILL.md` for the connection and deploy mechanics, and `ssh-connection-to-dev-server.md` for the VPN/SSH procedure.

This is the tree that changes; `src/original-src/` stays byte-for-byte as the client delivered it and is the reference we diff against.

## Where the tests live and how to run them

```
src-dev/tests/
├── composer.json
├── phpunit.xml
├── README.md
├── run-all.sh
├── run-batch.sh
├── run-gui.sh
├── harness/
└── SmokeTest/
    ├── BatchSmokeTest.php
    ├── GuiSmokeTest.php
    ├── InitialSmokeTest.php
    ├── MenuSmokeTest.php
    ├── ParseSmokeTest.php
    ├── Quarantine.php
    ├── RouterSmokeTest.php
    └── TopLevelEntrySmokeTest.php
```

The whole suite is run with `src-dev-scripts/run-safety-net.sh` from the repository root; it executes against the local Docker stack defined by `src-dev/docker-compose.yml`.

`BatchSmokeTest` deliberately verifies batch scripts with a syntax check (`php -l`) rather than executing them, because batch scripts are data-import/mutating jobs that would run `INSERT`/`UPDATE` against the database.

`ParseSmokeTest` discovers PHP files recursively across the whole document root rather than from a fixed list of directories, and asserts that each one parses. It exists because the directory-specific providers of the other test classes only cover the directories they were written for, so a file in a directory nobody listed was never checked at all. The recursive discovery excludes `.git/`, the two vendored PHPMailer copies `kimibatch/vendor/` and `kimibatch/files/vendor/`, and `libs/addons/phpmail/`, because third-party code is not ours to fix.

## Baseline

**580 tests, 667 assertions, 60 skipped, 0 failures** (verified 2026-10-05, after the PHP 8.5 upgrade was re-applied on the production code ANEXIA delivered on 2026-09-08).

The two earlier baselines were 202 tests / 291 assertions / 61 skipped / 0 failures (2026-08-26) and, before that, 214 tests / 292 assertions / 72 skipped / 0 failures. The step from 202 to 580 has two causes and no regression in it: `ParseSmokeTest` was added and checks every PHP file in the document root recursively instead of only the listed directories, and the 2026-09-08 production delivery brought 80 PHP files that had never been part of this tree, 65 of them under `kimibatch/`.

A red suite means a real regression. Anything that cannot pass for reasons unrelated to PHP 8.5 is quarantined explicitly rather than left failing.

## What is quarantined (`src-dev/tests/SmokeTest/Quarantine.php`)

| Constant | What it holds |
|---|---|
| `ABSENT_FEATURE_MODULES` | insurance/claims modules querying tables absent from `kimidev_et` (verified absent locally **and** on the dev server). The client confirmed these modules are obsolete. One basename covers the `gui`/`initial`/`menu` copies |
| `DEAD_BACKUP_MODULES` | dated backup copies that error on load. Kept for `ticket_sich20150208.php` and `ticketsuch_sich20150208.php` because copies survive in module sets the client's deletion approval did not cover |
| `NON_APP_TOPLEVEL` | bundled tool plus telephony/outbound endpoints, not load-testable offline |
| `CONTEXT_DEPENDENT_MODULES` | modules needing a full case/customer (`$akt`/`$kunde`) context the direct-include runners do not build; covered via `RouterSmokeTest` through the real `index.php` |

`InitialSmokeTest` and `MenuSmokeTest` do not consult `DEAD_BACKUP_MODULES`; `MenuSmokeTest` excludes `ticketsuch_sich20150208.php` in its provider instead, because a copy of that file still exists under `modules/menu/`.

## Related documents

- `smoke-tests-original-src.md` — the PHP 8.0 baseline for `src/original-src/`
- `smoke-tests-upgraded-src.md` — the PHP 8.5 baseline for `src/upgraded-src/`
- `batch-processing-subsystem.md` — what the `kimibatch/` subsystem is, and which scripts the client approved for removal
- `ssh-connection-to-dev-server.md` — reaching the dev server over the FortiClient VPN
