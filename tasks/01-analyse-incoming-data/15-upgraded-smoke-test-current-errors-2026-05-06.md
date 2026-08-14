# Upgraded Smoke Test - Current Errors Only - 2026-05-06

## Purpose

This document records only the currently active smoke-test failures in:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/`

It intentionally excludes already fixed historical error groups.

## Execution Context

Command used:

```bash
/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/run-all.sh
```

Execution date:

- `2026-05-06`

Relevant runner:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/run-all.sh`

Important note:

- the terminal output again printed the failing inventory before the process stopped producing new output
- the active failure counts below are derived from that printed inventory

## Suite Size

Current upgraded suite inventory:

- batch entrypoints: `128`
- GUI modules/AJAX: `17`
- initial hooks: `30`
- menu includes: `25`
- router checks: `13`
- top-level entrypoints: `10`
- total smoke checks: `223`

## Current Result Summary

Observed active failing entrypoints:

- batch: `11`
- initial: `2`
- menu: `2`
- top-level: `2`
- total active failures: `17`

Observed passing categories:

- GUI/AJAX: `17 / 17`
- router: `13 / 13`

## Active Current Failures

Every group below is still active and therefore marked:

- status: `[not fixed]`

## 1. Missing batch input/export fixture files [not fixed]

Exists in original smoke baseline:

- `No` as the current visible failure mode
- the older missing-table staging failures for these scripts were already removed in the upgraded smoke DB

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeo03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeoch03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodrei03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko201603_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkode03_verarbeitung_elsbeth_out.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/oko03_verarbeitung_elsbeth_out.php`

Observed current errors:

- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/40/IN/COEO_ExportResult.csv'`
- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/41/IN/COEO_CH_DE_ExportResult.csv'`
- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/27/IN/DREI_ExportResult.csv'`
- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/18/IN/INKO2016_ExportResult.csv'`
- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/24/IN/INKODE_ExportResult.csv'`
- `Can't find file '/var/www/html/kimi_ET/kimibatch/files/16/IN/OKO_ExportResult.csv'`

Evidence:

- all six scripts fail in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/kimi_general.php:226`
- each script reaches `executeSQLLoader(...)`
- the active failure is now the missing CSV file in the expected `files/<mandant>/IN/` directory

Root cause:

- the upgraded smoke environment now has the required staging tables for these scripts
- execution proceeds far enough to hit the next dependency: campaign-specific input files are absent
- these entrypoints are not smoke-safe when the expected inbound export file is missing

Fix directions:

- decide whether these scripts should be part of smoke without fixture files
- if yes, add smoke fixture CSVs with minimal valid headers under the expected `files/<mandant>/IN/` paths
- if no, add explicit preflight guards in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/kimi_general.php` or in each `*_verarbeitung_elsbeth_out.php` script so a missing import file becomes a controlled non-fatal outcome

## 2. Missing helper tables in import scripts after input-file handling [not fixed]

Exists in original smoke baseline:

- `Yes` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`, but previously with a different visible error
- `No` for the exact current error shapes in the other scripts

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko2016imp3.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoimp.php`

Observed current errors:

- missing table `inko2016_duplet`
- missing table `inkode_duplet`
- missing table `okomehrfach`

Companion warnings before the fatal:

- missing input file warnings in:
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko2016imp3.php`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoimp.php`

Evidence:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko2016imp3.php:231` drops `inko2016_duplet`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2.php:239` drops `inkode_duplet`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkodeimp2x.php:216` drops `inkode_duplet`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoimp.php:399` drops `okomehrfach`

Root cause:

- these scripts assume helper/deduplication tables already exist
- the upgraded smoke DB currently does not provision those helper tables
- the scripts also assume the import input files exist, but even after those warnings they continue into the helper-table phase and then fail fatally on missing schema objects

Fix directions:

- add smoke-safe definitions for `inko2016_duplet`, `inkode_duplet`, and `okomehrfach` in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/`
- review whether these tables are intended to be temporary runtime artifacts or durable helper tables
- if they are temporary artifacts, replace direct `DROP TABLE <name>` assumptions with `DROP TABLE IF EXISTS <name>` or equivalent guarded logic in the importing scripts
- separately decide whether the missing source files in these import scripts should be handled as controlled smoke skips instead of warnings plus later fatal execution

## 3. Genuine SQL-shape bug in `okoexpzwb.php` [not fixed]

Exists in original smoke baseline:

- `Yes`, but the original visible failure stopped earlier on removed legacy `mysql_query()`

Affected upgraded file:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`

Observed current error:

- `Column count doesn't match value count at row 1`

Evidence:

- the fatal occurs in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php:130`
- the failure happens during `insert into okozwb ...`

Root cause:

- this is a real SQL mismatch between the target table shape and the inserted projection
- the smoke environment is no longer failing earlier on driver/API compatibility, so the script now exposes its actual SQL defect

Fix directions:

- compare the `INSERT INTO okozwb` target columns with the `SELECT` projection count and order
- make the insert explicit by naming target columns instead of relying on positional matching
- after fixing the insert, also guard the later read path so a failed query cannot cascade into a second-order fatal

## 4. Application-context bug in `subuebersicht.php` plus PHP 8.5 deprecation noise [not fixed]

Exists in original smoke baseline:

- `No` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- `No` for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/subuebersicht.php`

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/subuebersicht.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`

Observed current errors:

- deprecated `str_replace(..., null)` calls in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`
- undefined variable `$stammdaten`
- fatal call to `$stammdaten->get_stichtag()`

Evidence:

- the smoke run reports deprecations in:
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:634`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:657`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:707`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:730`
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php:803`
- the fatal occurs in:
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php:159`

Root cause:

- the module assumes `$stammdaten` is available in the current bootstrap context
- the current smoke harness does not provide that variable for this module path
- PHP 8.5 also exposes nullable-string deprecations in `Subkonto` that add noise but are not the primary fatal

Fix directions:

- initialize `$stammdaten` before the TGZ path is reached
- or skip the TGZ branch when `$stammdaten` is not available
- decide whether `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/harness/module_runner.php` should seed a minimal `$stammdaten` object for this module family
- normalize nullable subjects before the `str_replace()` calls in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/subkonto.php`

## 5. Existing arity mismatch in `ticketsuch_sich20150208.php` [not fixed]

Exists in original smoke baseline:

- `Yes`

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/menu/ticketsuch_sich20150208.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/ticket.php`

Observed current error:

- `Too few arguments to function Ticket::count(), 2 passed ... and exactly 3 expected`

Evidence:

- call site:
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php:92`
- active signature:
  - `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/ticket.php:2591`

Root cause:

- the module still calls `Ticket::count()` with an outdated argument list
- this is not a newly introduced upgraded-only bug; it remains an unfixed application defect

Fix directions:

- update the call site to pass the missing campaign id argument
- or add a backward-compatible default for the third parameter in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/libs/entities/ticket.php` if that matches the intended contract
- search for other `Ticket::count(` usages and normalize them consistently

## 6. `getticketurl.php` now fails on a deeper schema mismatch [not fixed]

Exists in original smoke baseline:

- `Yes`, but previously with a different visible error

Affected upgraded file:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`

Observed current error:

- `Unknown column 'clid_name' in 'where clause'`

Evidence:

- the fatal occurs in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php:54`
- the query is:

```sql
select id, text, getCleanPhoneNoN('$phoneNo', '', false) phoneNo
from mandant
where clid_name = '$queueName';
```

Root cause:

- the earlier missing-function blocker `getCleanPhoneNoN(...)` is now removed in the smoke DB
- execution proceeds to the next real schema mismatch: the local `mandant` table does not provide `clid_name`
- this is either a missing column in the smoke schema or a query that no longer matches the active schema contract

Fix directions:

- inspect `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/docker/mariadb/init/02-schema.sql` and the original runtime schema to determine whether `mandant.clid_name` should exist
- if the column belongs to the intended local schema, add it to the smoke DB and seed a value for the smoke `mandant`
- if not, update `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php` to use the actual queue-mapping field that exists in the current schema
- keep the existing fetch guard, but also handle query failure itself so schema mismatch does not abort the whole request

## 7. `setticketcallinfo.php` currently fails on input/harness contract before useful business validation [not fixed]

Exists in original smoke baseline:

- `No` as a smoke failure

Affected upgraded files:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/ajax/log/callinfo.log`
- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/harness/top_level_runner.php`

Observed current error:

- top-level smoke reports only `non-zero exit`

Additional evidence from the application log:

- `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/ajax/log/callinfo.log` now contains:
  - `FEHLER -> Received content contained invalid JSON!`

Inference from the current evidence:

- the smoke harness invokes `setticketcallinfo.php` in the `setticketcallinfo` scenario without a JSON request body
- the entrypoint appears to reject the request before reaching any stable business-level response path

Root cause:

- the current smoke scenario and the endpoint input contract do not match
- after the earlier `callmanager_log` schema blocker was removed, the request now gets far enough to fail on malformed or missing JSON payload handling
- there is also still a likely second-order SQL risk in `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`, because `Request::insert_callmanager()` builds raw SQL with unquoted numeric-looking values that may be empty under smoke input

Fix directions:

- update `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/tests/harness/top_level_runner.php` so the `setticketcallinfo` scenario sends the minimal valid JSON body that the endpoint expects
- or harden `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php` so invalid or empty JSON returns a controlled JSON error response with exit code `0` instead of a non-zero smoke failure
- after the input contract is fixed, retest the endpoint to see whether the next blocker is the SQL construction inside `Request::insert_callmanager()`

## Recommended Next Fix Order

## 1. Batch fixture and helper-table hygiene first [not fixed]

- decide whether the `*_verarbeitung_elsbeth_out.php` scripts should receive smoke fixture files or explicit no-file guards
- add smoke-safe helper tables `inko2016_duplet`, `inkode_duplet`, and `okomehrfach`

## 2. Top-level contract/schema blockers next [not fixed]

- fix the schema contract for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
- align the smoke harness and endpoint contract for `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

## 3. Application/module defects next [not fixed]

- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/subuebersicht.php`
- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/modules/initial/ticketsuch_sich20150208.php`

## 4. Genuine SQL bug cleanup [not fixed]

- fix `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`

## Bottom Line

The currently active upgraded smoke failures are no longer dominated by the already fixed missing-function, missing-staging-table, or non-insertable-report-target problems.

The current remaining failures are concentrated in:

- missing batch input fixtures
- missing helper tables in import flows
- one real SQL-shape bug
- one module-context bug with PHP 8.5 deprecation residue
- one persistent method-arity mismatch
- one top-level schema mismatch
- one top-level request-contract mismatch
