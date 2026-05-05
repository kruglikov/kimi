# Upgraded Smoke Test Errors And Fix Options

## Purpose

This document records the currently observed failures from the smoke-test suite in
`src/upgraded-src/tests/` when executed against the upgraded Docker environment in
`src/upgraded-src/docker-compose.yml`.

The goal is to make the current failure set actionable by:

- listing the failing files and the runtime error seen by the suite
- grouping failures by common underlying cause
- describing practical fix options for the upgraded codebase in `src/upgraded-src/`

This note started as an investigation record and is now updated to reflect the targeted
batch-script fixes that were implemented and verified on 2026-05-05.

## Execution Context

Command used:

```bash
./src/upgraded-src/tests/run-all.sh
```

Runner path:

- `src/upgraded-src/tests/run-all.sh`

Docker stack:

- `src/upgraded-src/docker-compose.yml`

Observed result from the latest fully reviewed run on 2026-05-05 after the targeted
batch DB API fixes were implemented and the suite was rerun:

- total tests: `219`
- total failures: `20`

Suite breakdown:

- `BatchSmokeTest`: `128` tests, `3` failures
- `GuiSmokeTest`: `17` tests, `0` failures
- `InitialSmokeTest`: `30` tests, `8` failures
- `MenuSmokeTest`: `25` tests, `8` failures
- `RouterSmokeTest`: `13` tests, `0` failures
- `TopLevelEntrySmokeTest`: `6` tests, `1` failure

Important verification note:

- the suite was rerun directly with `./src/upgraded-src/tests/run-all.sh` after the targeted batch-script edits
- three previous batch failures were resolved by providing the expected input fixture files
- the final PHPUnit process again did not print its closing summary line before stalling, but the per-suite output was complete and the failure total above is derived directly from that full output

## Resolved Since Initial Run

The following batch failures were present in the earlier run, but were removed after adding the
expected input files and rerunning the suite in a clean Docker environment:

- `coeo01_import_telnr_optimierung.php`
- `coeoch01_import_telnr_optimierung.php`
- `coeodrei01_import_telnr_optimierung.php`

Verification details:

- the scripts only required the expected `IN` file to exist
- each test line only needed at least one semicolon so the script could split the phone number from the remainder of the row
- the minimum safe fixture content used for all three files was:

```text
436641234567;SMOKE
```

Fixture file mapping:

- `./files/40/IN/KNP0.CSV` for `coeo01_import_telnr_optimierung.php`
- `./files/41/IN/COEOCH0.CSV` for `coeoch01_import_telnr_optimierung.php`
- `./files/27/IN/DREI0.CSV` for `coeodrei01_import_telnr_optimierung.php`

Interpretation:

- this resolves the immediate smoke-test fatal path caused by missing files
- this does not prove the business correctness of those import jobs
- if the project wants these scripts to remain smokeable in a clean environment, either the fixture files or equivalent prerequisite setup must remain part of the test strategy

The following additional batch failures were resolved by code changes on 2026-05-05:

- `inko201604_status_offen_auf_inA_setzen.php`
- `inkode04_status_offen_auf_inA_setzen.php`
- `oko04_status_offen_auf_inA_setzen.php`
- `oko04_status_offen_vortage_auf_inA_setzen.php`
- `coeochdeexptest.php`
- `inkodeexp_new.php`
- `oko_inA_outbound_elsbeth.php`

Verification details:

- each script already executed SQL through `executeSQLQuery()` in `kimi_general.php`
- the fatal came from fetching the `mysqli_result` with removed `mysql_fetch_array()`
- the implemented fix replaced that fetch call with the existing batch helper `dbFetchArray()`
- duplicate script copies under `web/htdocs/kimi_ET/kimibatch/files/16/Scripts/` were updated the same way

Interpretation:

- this confirms the immediate `mysql_fetch_array()` fatals in the four status-update scripts are fixed
- `coeochdeexptest.php` was fixed by correcting the SQL alias quoting inside the PHP string so the file parses again
- `inkodeexp_new.php` was fixed by replacing `mysql_query()` and `mysql_fetch_array()` with `mysqli_query()` and `mysqli_fetch_array(..., MYSQLI_ASSOC)`
- `oko_inA_outbound_elsbeth.php` was fixed by the same minimal `mysql_*` to `mysqli_*` migration pattern used in `inkodeexp_new.php`
- `okoexpzwb.php` still fails, but the root cause has moved past the removed `mysql_query()` fatal and now surfaces as an SQL insert/value-count mismatch followed by a fetch on `false`
- this does not resolve the remaining batch runtime issues in `inkodeimp2x.php`, `okoexpzwb.php`, and `pwgen.php`

## Failure Inventory

### 1. Batch script failures

#### `inkodeimp2x.php`

Observed error:

- call to undefined function `bFetchArray()`

Fix options:

- locate the intended helper implementation and restore the include/bootstrap path if it should exist
- if `bFetchArray()` is obsolete, replace it with the current supported fetch helper or direct `mysqli_fetch_*` logic
- review the script bootstrap assumptions in `kimi_general.php` and related includes

#### `oko_inA_outbound_elsbeth.php`

Observed error:

- call to removed function `mysql_query()`

Fix options:

- migrate to `mysqli_*` or the project DB layer
- add query result validation before fetch/use
- if this is one of several exports with the same structure, factor the DB migration pattern once and apply it consistently

#### `okoexpzwb.php`

Observed error:

- SQL insert/value-count mismatch, followed by `mysqli_fetch_array(false)`

Fix options:

- review the `INSERT INTO okozwb ... SELECT ...` column count against the target table definition and selected values
- after the insert shape is corrected, validate the select query result before fetching so SQL failures do not become a secondary `mysqli_fetch_array(false)` fatal
- if this export depends on precomputed daily intermediate rows, separate the insert/build step from the export/read step so each failure mode is easier to diagnose

#### `pwgen.php`

Observed error:

- undefined constant `TXT_LBL_PASSWORD`

Fix options:

- ensure the expected language/constants bootstrap is loaded before rendering
- if this batch-context execution is supposed to work standalone, replace implicit constant assumptions with guarded fallbacks
- if the script is only valid through a GUI bootstrap path, decide whether the smoke harness should supply that bootstrap or whether the script itself should become robust when run directly

### 2. Initial hook failures

#### `modules/initial/bankleitzahl.php`

Observed error:

- `count(null)` at line 67

Fix options:

- guard the counted value with `is_array()`, `instanceof Countable`, or a null-coalescing default
- initialize the expected collection earlier in the module bootstrap

#### `modules/initial/buchungen.php`

Observed error:

- undefined variable `$kunde`
- fatal call to `$kunde->get_markt()` on `null`

Fix options:

- establish `$kunde` earlier from the expected request/session context
- add a null guard and controlled fallback branch when the customer context is unavailable
- review whether the smoke harness should seed this module with minimal valid context or whether the module should tolerate missing context

#### `modules/initial/inkassoinformation.php`

Observed error:

- undefined variable `$kunde`
- fatal call to `$kunde->get_markt()` on `null`

Fix options:

- same remediation as `buchungen.php`

#### `modules/initial/lastschrift.php`

Observed error:

- `count(null)` at line 112

Fix options:

- same remediation as `bankleitzahl.php`
- verify whether the missing value should be an empty array by default

#### `modules/initial/schadensfall.php`

Observed error:

- `count(null)` at line 102

Fix options:

- same remediation as the other `count(null)` failures

#### `modules/initial/status_schadensfall.php`

Observed error:

- `count(null)` at line 58

Fix options:

- same remediation as `schadensfall.php`

#### `modules/initial/subdetail.php`

Observed error:

- undefined variable `$kunde`
- fatal call to `$kunde->get_markt()` on `null`

Fix options:

- same remediation as `buchungen.php`

#### `modules/initial/ticketsuch_sich20150208.php`

Observed error:

- `Ticket::count()` called with 2 arguments, but the current signature requires 3

Fix options:

- update the call site to pass the third required argument
- if the signature changed during modernization, review whether there should be a default value in `Ticket::count()` for backwards compatibility
- search for other outdated call sites of `Ticket::count()` and fix them as one batch

### 3. Menu include failures

The following menu failures are not independent root causes. They fail because the matching
`modules/initial/*.php` include fails first in the menu harness path.

Affected files:

- `modules/menu/bankleitzahl.php`
- `modules/menu/buchungen.php`
- `modules/menu/inkassoinformation.php`
- `modules/menu/lastschrift.php`
- `modules/menu/schadensfall.php`
- `modules/menu/status_schadensfall.php`
- `modules/menu/subdetail.php`
- `modules/menu/ticketsuch_sich20150208.php`

Fix options:

- fix the corresponding `modules/initial/*.php` file first
- after that, rerun `MenuSmokeTest` to confirm whether any menu-specific issues remain
- do not prioritize menu-file edits before the initial-hook failures are resolved, because the current signal says the pre-hook is the blocking layer

### 4. Top-level entrypoint failure

#### `getticketurl.php`

Observed error:

- `mysqli_fetch_assoc(false)` at line 47
- query result is not validated before fetch

Fix options:

- validate the query result before calling `mysqli_fetch_assoc()`
- if the query can legitimately return `false`, convert that path into a controlled response instead of a fatal
- log or expose the SQL failure reason in a safe debug path so this endpoint becomes diagnosable during smoke runs

## Cross-Cutting Root Causes

### Legacy removed MySQL API usage

Affected files:

- `okoexpzwb.php`

Preferred fix direction:

- migrate all remaining `mysql_*` usage in the upgraded tree as one tracked workstream
- standardize on one DB access style in `src/upgraded-src/`
- add result validation after connect/query/fetch boundaries

### Null bootstrap assumptions in initial hooks

Affected files:

- `bankleitzahl.php`
- `buchungen.php`
- `inkassoinformation.php`
- `lastschrift.php`
- `schadensfall.php`
- `status_schadensfall.php`
- `subdetail.php`

Preferred fix direction:

- document the minimum bootstrap contract each module expects
- either seed those values in the harness or make the modules defensive against missing state
- for upgrade safety, favor making modules tolerate absent or empty state where possible

### Outdated method/helper contracts

Affected files:

- `ticketsuch_sich20150208.php`
- `inkodeimp2x.php`

Preferred fix direction:

- audit signature drift and helper availability in upgraded entities/bootstrap code
- repair the call sites first, then decide whether compatibility wrappers are justified

### Standalone batch scripts missing runtime prerequisites

Affected files:

- `pwgen.php`

Preferred fix direction:

- decide whether standalone execution without external files/lang bootstrap is a valid supported mode
- if yes, add prerequisite validation and safe fallback behavior
- if no, adapt the smoke harness to provide the minimum required fixture/bootstrap inputs
- note that the three `*_import_telnr_optimierung.php` scripts were already made smokeable by supplying minimal input fixtures during verification

## Recommended Fix Order

1. Fix the next smallest runtime blocker:
   - `getticketurl.php`

2. Fix the remaining batch runtime blockers with the smallest scope:
   - `inkodeimp2x.php`
   - `okoexpzwb.php`
   - `pwgen.php`

3. Fix initial-hook null/bootstrap assumptions:
   - `bankleitzahl.php`
   - `buchungen.php`
   - `inkassoinformation.php`
   - `lastschrift.php`
   - `schadensfall.php`
   - `status_schadensfall.php`
   - `subdetail.php`

4. Repair outdated helper/signature usage:
   - `inkodeimp2x.php`
   - `ticketsuch_sich20150208.php`

5. Decide how standalone batch scripts should behave when bootstrap inputs are missing:
   - `pwgen.php`

6. Decide whether the `*_import_telnr_optimierung.php` fixture inputs should become an explicit, documented part of the smoke-test setup instead of an ad hoc verification aid.

7. Rerun the full suite and then reassess whether any menu failures remain after their initial-hook dependencies are fixed.

## Important Interpretation

These smoke tests are runtime safety-net checks. A fix is successful when the relevant entrypoint
executes without immediate parse errors or fatal runtime errors in the upgraded environment.

That does not by itself prove:

- business correctness
- correct campaign output
- correct DB semantics
- complete UI behavior

It only proves that the tested runtime surface survives basic execution under the upgraded stack.
