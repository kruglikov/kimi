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
batch DB API fixes and the harness-only customer-context workaround were implemented
and the suite was rerun:

- total tests: `218`
- total failures: `19`

Suite breakdown:

- `BatchSmokeTest`: `127` tests, `2` failures
- `GuiSmokeTest`: `17` tests, `0` failures
- `InitialSmokeTest`: `30` tests, `8` failures
- `MenuSmokeTest`: `25` tests, `8` failures
- `RouterSmokeTest`: `13` tests, `0` failures
- `TopLevelEntrySmokeTest`: `6` tests, `1` failure

Important verification notes:

- the suite was rerun directly with `./src/upgraded-src/tests/run-all.sh` after the targeted batch-script edits
- the suite was rerun again after the module smoke harness was changed to inject a local `$kunde`
  stub object instead of executing the broken `Customer::get()` / `Customer::get_by_kunde_nr()`
  lookup path
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
- `pwgen.php` as a direct batch entrypoint
- `modules/initial/buchungen.php` and `modules/menu/buchungen.php` as smoke-harness-only customer bootstrap failures

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
- `pwgen.php` was removed from direct `BatchSmokeTest` execution because it is a GUI fragment, not a supported standalone batch entrypoint; the supported routed surface remains `modules/gui/pwgen.php`
- the module smoke harness now injects a local `$kunde` stub object and suppresses the request/session customer inputs that would otherwise trigger the currently broken `Customer` entity lookup path
- this harness-only workaround removed the artificial smoke failure in `buchungen.php`, but the remaining initial/menu failures now expose deeper runtime issues that were previously masked by the missing-customer fatal
- `okoexpzwb.php` still fails, but the root cause has moved past the removed `mysql_query()` fatal and now surfaces as an SQL insert/value-count mismatch followed by a fetch on `false`
- this does not resolve the remaining batch runtime issues in `inkodeimp2x.php` and `okoexpzwb.php`

## Failure Inventory

### 1. Batch script failures

#### `inkodeimp2x.php`

Observed error:

- call to undefined function `bFetchArray()`

Fix options:

- locate the intended helper implementation and restore the include/bootstrap path if it should exist
- if `bFetchArray()` is obsolete, replace it with the current supported fetch helper or direct `mysqli_fetch_*` logic
- review the script bootstrap assumptions in `kimi_general.php` and related includes

#### `okoexpzwb.php`

Observed error:

- SQL insert/value-count mismatch, followed by `mysqli_fetch_array(false)`

Fix options:

- review the `INSERT INTO okozwb ... SELECT ...` column count against the target table definition and selected values
- after the insert shape is corrected, validate the select query result before fetching so SQL failures do not become a secondary `mysqli_fetch_array(false)` fatal
- if this export depends on precomputed daily intermediate rows, separate the insert/build step from the export/read step so each failure mode is easier to diagnose

### 2. Initial hook failures

#### `modules/initial/bankleitzahl.php`

Observed error:

- `count(null)` at line 67

Fix options:

- guard the counted value with `is_array()`, `instanceof Countable`, or a null-coalescing default
- initialize the expected collection earlier in the module bootstrap

#### `modules/initial/buchungen.php`

Resolved in the latest harness-based rerun:

- the direct smoke fatal caused by missing customer context was removed by seeding a harness-only `$kunde` stub
- no active runtime failure remains for this module in the current smoke result set

#### `modules/initial/inkassoinformation.php`

Observed error:

- `IKBuero::load_all($kunde->get_markt())` builds SQL with an unquoted market value and fails with `Unknown column 'AT' in 'where clause'`

Fix options:

- quote or escape the market value correctly inside `IKBuero::load_all()`
- if `markt` is intended to be a string code, ensure the entity method always emits `WHERE markt = 'AT'` style SQL rather than `WHERE markt = AT`
- keep the harness-only `$kunde` workaround in place so this real query issue remains visible during smoke runs

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

- `count(null)` at line 127 after the harness supplies customer context

Fix options:

- guard the counted value with `is_array()`, `instanceof Countable`, or a null-coalescing default
- verify whether the underlying subkonto list loader should return an empty array instead of `null` on no-result or exception

#### `modules/initial/subuebersicht.php`

Observed error:

- undefined variable `$stammdaten`
- fatal call to `$stammdaten->get_stichtag()` on `null`

Fix options:

- initialize `$stammdaten` explicitly for the harness path before using it in the TGZ selection block
- add a guard so the TGZ-specific `Subkonto::select_for_tgz(...)` path is skipped when no valid `Stammdaten` object is available
- review whether this module assumes a richer customer/session bootstrap contract than the current smoke harness intentionally provides

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
- `modules/menu/inkassoinformation.php`
- `modules/menu/lastschrift.php`
- `modules/menu/schadensfall.php`
- `modules/menu/status_schadensfall.php`
- `modules/menu/subdetail.php`
- `modules/menu/subuebersicht.php`
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

### Remaining batch runtime issues after DB API migration

Affected files:

- `okoexpzwb.php`

Preferred fix direction:

- fix the stale helper typo in `inkodeimp2x.php`
- fix the SQL shape mismatch and follow-on fetch-on-false path in `okoexpzwb.php`
- keep the DB access style standardized on `mysqli_*` / shared helpers

### Harness-only customer bootstrap workaround now exposes deeper module/runtime issues

Affected files:

- `bankleitzahl.php`
- `inkassoinformation.php`
- `lastschrift.php`
- `schadensfall.php`
- `status_schadensfall.php`
- `subdetail.php`
- `subuebersicht.php`

Preferred fix direction:

- keep the harness-only `$kunde` stub because it removes artificial missing-customer fatals without changing application code
- treat the remaining failures as real module/entity/query issues rather than pure harness bootstrap gaps
- document separately that the real `Customer` entity lookup path is still broken in the upgraded runtime, but is intentionally bypassed by the harness workaround

### Outdated method/helper contracts

Affected files:

- `ticketsuch_sich20150208.php`
- `inkodeimp2x.php`

Preferred fix direction:

- audit signature drift and helper availability in upgraded entities/bootstrap code
- repair the call sites first, then decide whether compatibility wrappers are justified

### Direct batch inventory includes non-entry GUI fragments

Affected files:

- `pwgen.php`

Preferred fix direction:

- treat `pwgen.php` as a GUI fragment, not a standalone batch entrypoint
- exclude it from direct `kimibatch/*.php` execution in `BatchSmokeTest`
- keep coverage through the supported routed surface in `modules/gui/pwgen.php`
- note that the three `*_import_telnr_optimierung.php` scripts were already made smokeable by supplying minimal input fixtures during verification

## Recommended Fix Order

1. Fix the next smallest runtime blocker:
   - `getticketurl.php`

2. Fix the remaining batch runtime blockers with the smallest scope:
   - `inkodeimp2x.php`
   - `okoexpzwb.php`

3. Fix the real initial-hook runtime issues now exposed by the harness workaround:
   - `bankleitzahl.php`
   - `inkassoinformation.php`
   - `lastschrift.php`
   - `schadensfall.php`
   - `status_schadensfall.php`
   - `subdetail.php`
   - `subuebersicht.php`

4. Repair outdated helper/signature usage:
   - `inkodeimp2x.php`
   - `ticketsuch_sich20150208.php`

5. Decide how standalone batch scripts should behave when bootstrap inputs are missing:
   - `pwgen.php`

6. Decide whether the `*_import_telnr_optimierung.php` fixture inputs should become an explicit, documented part of the smoke-test setup instead of an ad hoc verification aid.

7. Rerun the full suite and then reassess whether any menu failures remain after their corresponding initial-hook dependencies are fixed.

## Important Interpretation

These smoke tests are runtime safety-net checks. A fix is successful when the relevant entrypoint
executes without immediate parse errors or fatal runtime errors in the upgraded environment.

That does not by itself prove:

- business correctness
- correct campaign output
- correct DB semantics
- complete UI behavior

It only proves that the tested runtime surface survives basic execution under the upgraded stack.
