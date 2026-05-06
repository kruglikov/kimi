# PHP 8.5 Smoke Result After Stub And Seed Fixes - 2026-05-06

## Scope

This note records the valid smoke-test baseline after:

- adding smoke-only DB schema/stub fixes
- adding missing batch input fixture files
- fixing the clear SQL quoting issue in `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

## What Was Changed Before This Rerun

### Schema and seed updates

Updated:

- `src/upgraded-src/docker/mariadb/init/02-schema.sql`
- `src/upgraded-src/docker/mariadb/init/03-dev-seed.sql`
- `src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql`

Main smoke-environment fixes:

1. added `mandant.clid_name` and seeded it as `SMOKE-GROUP`
2. added `ticket.search_telnr1` and `ticket.search_telnr2`
3. seeded the demo ticket with `search_telnr1 = '+43123456789'`
4. expanded the `okozwb` stub so it matches the legacy `INSERT ... SELECT` projection shape used by `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`
5. added missing scratch tables:
   - `inkode_duplet`
   - `inko2016_duplet`
   - `okomehrfach`
6. loosened the smoke-only `callmanager_log.call_id` stub from integer to string-compatible storage so the empty `setticketcallinfo.php` smoke case no longer dies on strict integer conversion

### Code update

Updated:

- `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

Fix applied:

- quoted `ticket_reference` and `id` inside the generated `INSERT` SQL so empty values no longer produce invalid bare `, ,` SQL fragments

### Batch input fixture files

Added smoke-only import files for the batch scripts that previously failed on missing `LOAD DATA LOCAL INFILE` inputs and missing root import files.

Examples:

- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/40/IN/COEO_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/41/IN/COEO_CH_DE_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/27/IN/DREI_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/18/IN/INKO2016_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/24/IN/INKODE_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/16/IN/OKO_ExportResult.csv`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/INKO2016.CSV`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/INKODE.CSV`
- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/pos30cc.txt`

## Verification Run

Runtime confirmed:

- `PHP 8.5.5`

Smoke suite run:

- `./src/upgraded-src/tests/run-all.sh`

Important note:

- one earlier rerun was invalid because the DB reset overlapped the test run
- the result below is from the subsequent clean rerun after a full fresh volume reset

## Valid Current Result

Observed current baseline:

- `218` tests
- `5` failures

Breakdown:

- `BatchSmokeTest`: `1` failure
- `InitialSmokeTest`: `2` failures
- `MenuSmokeTest`: `2` failures
- `GuiSmokeTest`: `0` failures
- `RouterSmokeTest`: `0` failures
- `TopLevelEntrySmokeTest`: `0` failures

## What Was Successfully Fixed

### Batch failures removed

The following previously surfaced PHP 8.5 batch problems are no longer failing in the smoke suite:

- missing `LOAD DATA LOCAL INFILE` files for:
  - `coeo03_verarbeitung_elsbeth_out.php`
  - `coeoch03_verarbeitung_elsbeth_out.php`
  - `coeodrei03_verarbeitung_elsbeth_out.php`
  - `inko201603_verarbeitung_elsbeth_out.php`
  - `inkode03_verarbeitung_elsbeth_out.php`
  - `oko03_verarbeitung_elsbeth_out.php`
- missing root import files for:
  - `inko2016imp3.php`
  - `inkodeimp2.php`
  - `okoimp.php`
- missing scratch tables:
  - `inko2016_duplet`
  - `inkode_duplet`
  - `okomehrfach`
- `okoexpzwb.php` now passes with the adjusted smoke stub shape

### Top-level failures removed

These top-level PHP 8.5 smoke failures are now clean:

- `src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
- `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

## Remaining Failures

### 1. Batch smoke

Remaining batch failure:

- `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`

Current failure:

- `Unknown column 'nachname' in 'group statement'`
- location:
  - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php:292`

Assessment:

- this no longer looks like a missing-file or missing-stub-table problem
- it looks like a genuine SQL/query issue inside the script

### 2. Initial smoke

Remaining initial failures:

1. `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
   - still fails because `$stammdaten` is missing/null before `get_stichtag()` is called
   - fatal location:
     - `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php:159`
   - also still emits PHP 8.5 deprecations from:
     - `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:634`
     - `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:657`
     - `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:707`
     - `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:730`
     - `src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:803`

2. `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
   - still fails because `Ticket::count()` is called with 2 arguments while the active signature requires 3
   - fatal location:
     - `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php:92`

### 3. Menu smoke

Remaining menu failures are still the direct downstream duplicates of the initial-layer failures:

1. `src/upgraded-src/web/htdocs/kimi_ET/modules/menu/subuebersicht.php`
   - downstream of `modules/initial/subuebersicht.php`

2. `src/upgraded-src/web/htdocs/kimi_ET/modules/menu/ticketsuch_sich20150208.php`
   - downstream of `modules/initial/ticketsuch_sich20150208.php`

## Interpretation

These smoke-environment fixes were effective:

- they removed the new PHP 8.5 top-level failures
- they removed nearly all of the batch failures that were caused by missing fixture files or missing local DB support objects

The remaining failures are now much more focused:

1. one real batch SQL issue in `inkodeimp2x.php`
2. one real legacy module bug in `subuebersicht.php`
3. one real legacy API mismatch in `ticketsuch_sich20150208.php`
4. two derived menu duplicates of those initial failures

## Recommended Next Fix Order

1. `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
2. `src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
3. `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`

