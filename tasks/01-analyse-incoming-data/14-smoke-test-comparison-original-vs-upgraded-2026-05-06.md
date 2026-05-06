# Smoke Test Comparison - Original vs Upgraded - 2026-05-06

## Purpose

This document compares the current smoke-test results of:

- `/home/viktar/Projects/kimi-plus.at/src/original-src/`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/`

The main goal is to answer:

- which failures already existed in the original stack
- which failures are newly added as smoke failures in the upgraded stack
- which failures changed root cause in the upgraded stack
- what the likely root cause is for each active failure group
- what the practical fix directions are

## Execution Context

Commands used:

```bash
docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$REPO_ROOT/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox

docker compose -f src/upgraded-src/docker-compose.yml run --rm \
  -v "$REPO_ROOT/src/upgraded-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox
```

Relevant runner scripts:

- `/home/viktar/Projects/kimi-plus.at/src/original-src/tests/run-all.sh`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/run-all.sh`

Important note:

- both runs printed the full failing-entry inventory that was needed for comparison
- the terminal session did not print a clean final PHPUnit summary line before the process stopped responding
- the failure counts below are therefore derived from the printed failing cases plus the current suite inventory

## Suite Size

Current suite inventory per stack:

- batch entrypoints: `128`
- GUI modules/AJAX: `17`
- initial hooks: `30`
- menu includes: `25`
- router checks: `13`
- top-level entrypoints: `10`
- total smoke checks: `223`

## Result Summary

### Original stack

- active failing entrypoints: `27`
- breakdown:
- batch: `10`
- initial: `8`
- menu: `8`
- top-level: `1`

### Upgraded stack

- active failing entrypoints: `23`
- breakdown:
- batch: `17`
- initial: `2`
- menu: `2`
- top-level: `2`

### Net comparison

- total failing entrypoints decreased from `27` to `23`
- `22` original failing entrypoints are no longer failing in the upgraded stack
- `5` original failing entrypoints still fail in the upgraded stack
- `18` upgraded failing entrypoints are new as smoke failures

Interpretation:

- the upgraded stack is better on the original PHP-level and harness/bootstrap issues
- the upgraded stack is worse on database/runtime strictness because more SQL/schema gaps now surface as fatal failures

## Active Upgraded Failures

This section is grouped by root cause. Every group is marked with:

- status: `[fixed]` or `[not fixed]`
- whether the same smoke failure existed in the original stack

## 1. Missing batch staging tables and loader-target schema mismatches [not fixed]

Exists in original smoke baseline:

- `No` for these exact smoke failures
- however, the underlying DB provisioning gap is not new; the upgraded DB init scripts still do not create these staging tables

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeo03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeoch03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodrei03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko201603_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkode03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/oko03_verarbeitung_elsbeth_out.php`

Observed upgraded errors:

- missing table `knp_out`
- unknown column `nachname` during COEOCH load
- missing table `knpdrei_out`
- missing table `inko2016_out`
- missing table `inkode_out`
- missing table `oko_out`

Evidence:

- the upgraded DB init directory `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/` does not define these staging tables
- the load SQL files under `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/files/` still load into those table names

Root cause:

- the upgraded local DB schema is incomplete for the export/import batch pipelines
- earlier original-stack failures in other scripts masked these downstream schema gaps
- under the upgraded runtime, these missing objects now surface directly as `mysqli_sql_exception`

Fix directions:

- add smoke-safe definitions for `knp_out`, `knpdrei_out`, `inko2016_out`, `inkode_out`, and `oko_out` in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/`
- for `coeoch03_verarbeitung_elsbeth_out.php`, align the loader SQL and target-table columns so the expected `nachname` field actually exists or is removed from the load mapping
- if these are only intermediate import tables, create minimal smoke-test versions with the exact columns referenced by the import/update SQL rather than trying to reconstruct full production schema immediately

## 2. Report scripts inserting into non-insertable or missing report targets [not fixed]

Exists in original smoke baseline:

- `No` as smoke failures
- `Yes` as underlying environment problem, because the original and upgraded local schema both provision report targets inconsistently for these scripts

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeochreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodreireport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko2016report.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodereport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkoinboundreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/knp1report.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/schlaustromreport.php`

Representative evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeochreport.php` performs `insert into ticket_knp3 select ticket.*, now() from ticket ...`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql` defines `ticket_knp3`, `ticket_inko2016`, `ticket_inkode`, `ticket_inkoinbound`, `ticket_knp1`, `ticket_oko`, and `ticket_schlaustrom` as empty `VIEW`s over `ticket`
- `ticket_knpdrei` is not provisioned at all in that stub file

Observed upgraded errors:

- target table is not insertable-into
- missing table `ticket_knpdrei`

Root cause:

- the smoke environment uses read-only stub views for multiple `ticket_*` report targets
- the report scripts treat those objects as writable tables
- in the original stack, `mysqli_query()` failure only produced a non-fatal branch in many scripts
- in the upgraded stack, PHP 8.5 / mysqli exception behavior turns the same SQL failure into a smoke failure

Fix directions:

- replace the report-target views in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql` with writable smoke tables when the batch scripts need `INSERT INTO`
- alternatively, keep the views and add environment-aware guards in the scripts so smoke runs skip the insert step and only test export formatting
- add a stub object for `ticket_knpdrei` as well, using the same schema contract as the report script expects

## 3. Missing stored DB functions and missing logging table now fatal under upgraded mysqli behavior [not fixed]

Exists in original smoke baseline:

- `Yes` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php` as a failing smoke entrypoint, but with a different surface error
- `Yes` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`, but the original failure stopped earlier on `bFetchArray()`
- `No` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php`
- `No` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`

Observed upgraded errors:

- missing DB function `getCleanPhoneNoN`
- missing DB function `getvwhw`
- missing table `callmanager_log`

Evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php` executes `select id, text, getCleanPhoneNoN(...) ...`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php` inserts into `callmanager_log`
- `SHOW FUNCTION STATUS` in the upgraded `kimi_et` DB returned no entries for `getCleanPhoneNoN` or `getvwhw`
- `SHOW CREATE TABLE callmanager_log` in the upgraded `kimi_et` DB returned `ERROR 1146: Table 'kimi_et.callmanager_log' doesn't exist`
- the same `callmanager_log` table is also absent in the original local DB, which explains why this is a newly fatal upgraded error rather than a brand-new missing object

Root cause:

- the local smoke schema does not provide all stored functions and support tables that these entrypoints assume
- original PHP 8.0 behavior often allowed the script to continue after `mysqli_query()` returned `false`
- upgraded PHP 8.5 surfaces the missing object immediately as `mysqli_sql_exception`

Fix directions:

- add smoke-safe stub implementations for `getCleanPhoneNoN` and `getvwhw` in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/`
- add a minimal `callmanager_log` table definition in the upgraded DB init scripts
- for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`, keep the existing fetch-result guard and also handle the query failure itself so missing functions do not abort the request
- for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`, catch `mysqli_sql_exception` or explicitly handle `mysqli_query()` failure if the desired smoke contract is “no fatal even when optional logging infra is absent”

## 4. Remaining application-level module bugs [not fixed]

Exists in original smoke baseline:

- `Yes` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
- `No` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/subuebersicht.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/ticketsuch_sich20150208.php`

### 4.1 `subuebersicht.php`

Observed upgraded error:

- deprecated `str_replace(..., null)` calls inside `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`
- undefined variable `$stammdaten`
- fatal call to `$stammdaten->get_stichtag()`

Evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php` calls:

```php
$sk_tgz = Subkonto::select_for_tgz(
    $kunde->get_kdnr(),
    App::$CURRENT->MANDANT->get_id(),
    $kunde->get_markt(),
    CONF_TGZ_BUABUGRUMAN_ID_KAPITALISIERT,
    date("d.m.Y"),
    $stammdaten->get_stichtag()
);
```

Root cause:

- the module assumes `$stammdaten` is always available in the current bootstrap context
- the current upgraded smoke harness seeds `$kunde`, but not `$stammdaten`
- PHP 8.5 also exposes additional null-to-string deprecations in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`

Fix directions:

- initialize `$stammdaten` before the TGZ query path or skip the TGZ branch when it is absent
- decide whether `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/harness/module_runner.php` should provide a minimal `$stammdaten` stub for this module family
- harden the affected `str_replace()` calls in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php` by normalizing nullable inputs before string operations

### 4.2 `ticketsuch_sich20150208.php`

Observed upgraded error:

- `Ticket::count()` called with `2` arguments while the active signature requires `3`

Evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php` currently calls:

```php
$entry_count = Ticket::count(App::$CURRENT->MANDANT->get_id(), $filter);
```

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/ticket.php` defines:

```php
function count($mandant_id, $filter, $kId)
```

Root cause:

- this is an existing application-level arity mismatch, not a new upgraded-only bug
- the same module also failed in the original smoke baseline

Fix directions:

- update the call site to pass the missing campaign id argument
- or add a backward-compatible default for `$kId` in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/ticket.php` if that is consistent with the real calling contract
- search the upgraded tree for other `Ticket::count(` call sites and normalize them in one pass

## 5. Remaining SQL bug in `okoexpzwb.php` [not fixed]

Exists in original smoke baseline:

- `Yes`, but the original failure stopped earlier on removed `mysql_query()`

Affected upgraded file:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`

Observed upgraded error:

- `Column count doesn't match value count at row 1`

Evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php` builds an `INSERT INTO okozwb SELECT ...` statement and then reads from that table immediately afterward

Root cause:

- this is a genuine SQL-shape problem in the script itself
- the upgraded stack has already moved past the legacy `mysql_query()` API failure and now exposes the next real defect

Fix directions:

- compare the `INSERT INTO okozwb` target column count with the `SELECT` projection count and order
- make the insert explicit by naming the target columns instead of relying on positional order
- after fixing the insert, also guard the later `mysqli_query($dbconn, $query)` / `mysqli_fetch_array(...)` path so a failed select does not produce a second-order fatal

## Which Errors Were Added In The Upgraded Stack

The following failing entrypoints are new as smoke failures in the upgraded stack.

They were not failing in the original smoke baseline, even though some of their underlying schema gaps already existed.

### New batch smoke failures

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeo03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeoch03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeochreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodrei03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodreireport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko201603_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko2016report.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkode03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodereport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkoinboundreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/knp1report.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/oko03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoreport.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/schlaustromreport.php`

### New module smoke failures

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/subuebersicht.php`

### New top-level smoke failure

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

## Failures That Still Exist From The Original Baseline

These failures were present in the original smoke baseline and are still active in the upgraded stack.

### Persistent and still not fixed [not fixed]

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/ticketsuch_sich20150208.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`

Important nuance:

- three of those five are not failing for the same immediate reason anymore
- the upgraded stack removed the earlier blocking error and exposed a deeper remaining problem

Examples:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
  - original smoke failure: `mysqli_fetch_assoc(false)`
  - upgraded smoke failure: missing DB function `getCleanPhoneNoN`

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`
  - original smoke failure: undefined helper `bFetchArray()`
  - upgraded smoke failure: missing DB function `getvwhw`

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`
  - original smoke failure: removed legacy `mysql_query()`
  - upgraded smoke failure: insert/select column-count mismatch

## Original Failures That Are Fixed In The Upgraded Stack

These original smoke failures are no longer failing in the upgraded stack.

Status:

- `[fixed]`

### Fixed batch failures

- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/coeochdeexptest.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/inko201604_status_offen_auf_inA_setzen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/inkode04_status_offen_auf_inA_setzen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/inkodeexp_new.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/oko04_status_offen_auf_inA_setzen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/oko04_status_offen_vortage_auf_inA_setzen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/oko_inA_outbound_elsbeth.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/kimibatch/pwgen.php`

### Fixed initial/menu failures

- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/bankleitzahl.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/bankleitzahl.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/buchungen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/buchungen.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/inkassoinformation.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/inkassoinformation.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/lastschrift.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/lastschrift.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/schadensfall.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/schadensfall.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/status_schadensfall.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/status_schadensfall.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/initial/subdetail.php`
- `/home/viktar/Projects/kimi-plus.at/src/original-src/web/htdocs/kimi_ET/modules/menu/subdetail.php`

## Recommended Fix Order

## 1. Environment/schema blockers first [not fixed]

Recommended first because they create the largest number of upgraded-only failures:

- add missing stored functions `getCleanPhoneNoN` and `getvwhw`
- add missing support table `callmanager_log`
- add missing staging tables `knp_out`, `knpdrei_out`, `inko2016_out`, `inkode_out`, `oko_out`
- replace non-insertable `ticket_*` smoke views with writable smoke tables where report scripts perform `INSERT INTO`

## 2. Application-level module blockers next [not fixed]

- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`

## 3. Genuine SQL bug cleanup [not fixed]

- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`

## Bottom Line

The upgraded stack did not simply add random new PHP regressions.

What actually happened is more specific:

- many original PHP-level failures are fixed
- the upgraded runtime is stricter and now turns latent schema/runtime gaps into fatal smoke failures
- only one clearly new application-level module root cause was added to the active set: `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- most of the newly added upgraded smoke failures are environment/schema completeness problems in the upgraded local DB, not broad code regressions
