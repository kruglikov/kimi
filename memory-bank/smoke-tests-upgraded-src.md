# PHP Smoke Test Safety Net — `src/upgraded-src/`

## Purpose

This note describes the runtime smoke-test safety net for the **PHP 8.5 upgraded** KIMI Portal codebase.

The suite answers one narrow question:
- do the selected runtime entrypoints execute without PHP fatal or parse errors on PHP 8.5?

It is not a business-logic verification suite.

For the equivalent documentation of the original PHP 8.0 codebase, see `smoke-tests-original-src.md`.

## Where the tests live

```
src/upgraded-src/tests/
├── composer.json
├── phpunit.xml
├── run-all.sh
├── run-batch.sh
├── run-gui.sh
├── harness/
│   ├── bootstrap.php
│   ├── gui_runner.php
│   ├── module_runner.php
│   ├── router_runner.php
│   └── top_level_runner.php
└── SmokeTest/
    ├── BatchSmokeTest.php
    ├── GuiSmokeTest.php
    ├── InitialSmokeTest.php
    ├── MenuSmokeTest.php
    ├── RouterSmokeTest.php
    └── TopLevelEntrySmokeTest.php
```

## What is covered

| Suite                    | Surface covered |
|--------------------------|---|
| `BatchSmokeTest`         | All `kimibatch/*.php` files that `include kimi_general.php` |
| `GuiSmokeTest`           | All `modules/gui/*.php` + `ajax/*.php` |
| `InitialSmokeTest`       | All `modules/initial/*.php` (except excluded legacy file — see below) |
| `MenuSmokeTest`          | All `modules/menu/*.php` (except excluded legacy file — see below) |
| `RouterSmokeTest`        | Router/dispatcher layer |
| `TopLevelEntrySmokeTest` | 6 top-level entrypoints: `login.php`, `getticketurl.php`, `setticketcallinfo.php`, `xhangup.php`, `testpost.php`, `validphone.php` |

All suites use discovery-based file enumeration (`glob()` / `grep`) — new files are automatically picked up on the next run.

## How to run

```bash
# 1. Start the upgraded Docker stack
docker compose -f src/upgraded-src/docker-compose.yml up -d --build

# 2. Run all smoke tests
docker compose -f src/upgraded-src/docker-compose.yml exec web \
  bash /var/www/tests/run-all.sh
```

Runtime inside the container: **PHP 8.5.5**

## Current baseline result

Latest recorded full-suite execution (2026-05-06):

| Suite                    | Tests   | Failures |
|--------------------------|---------|----------|
| `BatchSmokeTest`         | 127     | 0        |
| `GuiSmokeTest`           | 17      | 0        |
| `InitialSmokeTest`       | 29      | 0        |
| `MenuSmokeTest`          | 24      | 0        |
| `RouterSmokeTest`        | 13      | 0        |
| `TopLevelEntrySmokeTest` | 6       | 0        |
| **Total**                | **216** | **0**    |

The suite is **green** on PHP 8.5.5.

## Intentional exclusion: `ticketsuch_sich20150208.php`

Two files are deliberately excluded from the baseline:

- `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
- `src/upgraded-src/web/htdocs/kimi_ET/modules/menu/ticketsuch_sich20150208.php`

Reason: this module uses the older 2-argument `Ticket::count($mandant_id, $filter)` signature, but the active bootstrap loads `libs/entities/ticket.php` which defines a 3-argument `Ticket::count($mandant_id, $filter, $kId)`. Because both files define the class `Ticket`, a runtime swap is not safely achievable without a larger refactor. The exclusion is implemented inside `InitialSmokeTest.php` and `MenuSmokeTest.php`.

If this module path must be supported in the future, it should be handled as a separate task: either migrate it to the active `Ticket` API or introduce explicit legacy class naming.

## What was done to reach a green baseline

The following fixes were applied in `src/upgraded-src/` to achieve 216/0:

### Rector automated pass

Rector was run with `src/upgraded-src/tooling/php-upgrade/rector.php` targeting only PHP 8.0→8.5 rules (`SetList::PHP_81` through `SetList::PHP_85`). It changed 51 files, primarily adding `(string)` casts to string function arguments that could receive `null` (`NullToStrictStringFuncCallArgRector`).

### Manual application fixes

| File                                                                    | Fix |
|-------------------------------------------------------------------------|---|
| `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`             | Fixed invalid SQL generation from empty unquoted fields |
| `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php` | Added defensive null guards for missing `$stammdaten` before `get_stichtag()` |
| `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`        | Added `(string)` normalization in setter paths triggering PHP 8.5 null-to-string deprecations |
| `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`         | Fixed invalid `GROUP BY` scope by grouping on subquery aliases |

### DB / fixture layer additions

The upgraded-src MariaDB init scripts were extended with:
- Added columns: `mandant.clid_name`, `ticket.search_telnr1`, `ticket.search_telnr2`
- Added scratch tables: `inkode_duplet`, `inko2016_duplet`, `okomehrfach`
- Seeded smoke queue and demo ticket lookup values
- Widened `okozwb` smoke stub for the legacy insert-select shape
- Added missing batch import fixture files so `LOAD DATA LOCAL INFILE` paths resolve

## Known open items (not smoke failures, but documented)

- `src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php` — depends on DB stored function `getCleanPhoneNoN` which is not present in the local smoke DB. The script is currently smoke-green because the failure is suppressed at the PHP level, but full runtime correctness requires the stored function.
- `ticketsuch_sich20150208.php` — excluded from baseline (see above).