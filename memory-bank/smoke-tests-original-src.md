# PHP Smoke Test Safety Net — `src/original-src/`

## Purpose

This note describes the runtime smoke-test safety net for the **preserved legacy PHP 8.0** KIMI Portal codebase in `src/original-src/`.

The suite serves as the reference baseline before the PHP 8.5 upgrade and as a regression detector for the legacy stack.

For the upgraded PHP 8.5 suite, see `smoke-tests-upgraded-src.md`.

The smoke suite is meant to answer a narrow but important question:

- do the selected runtime entrypoints and module surfaces execute without immediate parse errors or fatal runtime errors?

It is not a business-logic verification suite and it is not line-coverage documentation.

## Where the tests live

Primary test location:

- `src/original-src/tests/`

Key smoke suites:

- `src/original-src/tests/SmokeTest/GuiSmokeTest.php`
- `src/original-src/tests/SmokeTest/BatchSmokeTest.php`
- `src/original-src/tests/SmokeTest/RouterSmokeTest.php`
- `src/original-src/tests/SmokeTest/InitialSmokeTest.php`
- `src/original-src/tests/SmokeTest/MenuSmokeTest.php`
- `src/original-src/tests/SmokeTest/TopLevelEntrySmokeTest.php`

Key harness files:

- `src/original-src/tests/harness/bootstrap.php`
- `src/original-src/tests/harness/gui_runner.php`
- `src/original-src/tests/harness/router_runner.php`
- `src/original-src/tests/harness/module_runner.php`
- `src/original-src/tests/harness/top_level_runner.php`

Runner scripts:

- `src/original-src/tests/run-all.sh`
- `src/original-src/tests/run-gui.sh`
- `src/original-src/tests/run-batch.sh`

## What is covered

At the current stage, the smoke safety net covers:

- GUI module files in `src/original-src/web/htdocs/kimi_ET/modules/gui/`
- AJAX handlers in `src/original-src/web/htdocs/kimi_ET/ajax/`
- `modules/initial/*.php`
- `modules/menu/*.php`
- selected top-level web entrypoints in `src/original-src/web/htdocs/kimi_ET/`
- batch scripts in `src/original-src/web/htdocs/kimi_ET/kimibatch/`

The exact current coverage inventory and the still-uncovered scope are tracked in:

- `tasks/01-analyse-incoming-data/11-smoke-test-coverage-inventory.md`

## Covered and not covered scope

This section is the concise current scope view.

### Covered surfaces and file groups

Covered now:

- all files in `src/original-src/web/htdocs/kimi_ET/modules/gui/*.php`
- all files in `src/original-src/web/htdocs/kimi_ET/ajax/*.php`
- all files in `src/original-src/web/htdocs/kimi_ET/modules/initial/*.php`
- all files in `src/original-src/web/htdocs/kimi_ET/modules/menu/*.php`
- all files in `src/original-src/web/htdocs/kimi_ET/kimibatch/*.php`

Covered top-level web entrypoints:

- `src/original-src/web/htdocs/kimi_ET/login.php`
- `src/original-src/web/htdocs/kimi_ET/getticketurl.php`
- `src/original-src/web/htdocs/kimi_ET/setticketcallinfo.php`
- `src/original-src/web/htdocs/kimi_ET/xhangup.php`
- `src/original-src/web/htdocs/kimi_ET/testpost.php`
- `src/original-src/web/htdocs/kimi_ET/validphone.php`
- `src/original-src/web/htdocs/kimi_ET/phpinfo.php`
- `src/original-src/web/htdocs/kimi_ET/adminer-4.8.1.php`
- `src/original-src/web/htdocs/index.php`

### Not covered scope

At the current moment, there is no intentionally tracked uncovered runtime surface left in the application inventory that was used for the smoke-safety-net expansion.

In practical terms, this means:

- all currently inventoried application module surfaces are covered
- all currently inventoried batch scripts are covered
- all currently discussed top-level web entrypoints are covered

### Important interpretation note

Covered does not mean green.

Some covered files currently fail smoke execution, which is expected behavior for a safety net. The suite is meant to surface those failures so they can be reviewed during the PHP upgrade work.

Examples of covered-but-currently-failing areas include:

- some legacy batch scripts using removed `mysql_*` APIs
- some `modules/initial/*.php` files that hit `count(null)` or null bootstrap assumptions
- `src/original-src/web/htdocs/kimi_ET/getticketurl.php`

## How it is executed

The standard command is:

```bash
./src/original-src/tests/run-all.sh
```

The tests run through the Dockerized original stack defined in:

- `src/original-src/docker-compose.yml`

This gives a consistent runtime context with the legacy web container and MariaDB container.

## What signal the suite is meant to provide

The suite is intended to catch issues such as:

- parse errors
- removed legacy PHP APIs
- fatal type mismatches surfaced by newer PHP versions
- missing bootstrap variables in route/module loading
- immediate DB/API call failures in batch or top-level entry scripts

Examples already surfaced by the suite include:

- `mysql_*` usage in batch scripts
- `count(null)` failures in legacy modules under PHP 8
- route/bootstrap assumptions causing null dereferences

## Known limitations

The suite is intentionally a smoke safety net, so it has important limits:

- passing smoke does not prove business correctness
- some direct module tests do not reflect the exact real user navigation flow
- some `modules/menu/*.php` tests depend on paired `modules/initial/*.php` bootstrap
- some top-level scripts may depend on external services or special operator context
- third-party utilities such as Adminer are covered only as entrypoint execution checks, not as feature-complete behavioral tests

## Current test results and known failures

Latest recorded full-suite execution:

- command: `./src/original-src/tests/run-all.sh`
- result: `223` tests, `27` failures

The smoke safety net is therefore active and useful, but not green yet.

### Current failing areas

#### 1. Batch-script failures

Current failing covered batch scripts:

- `kimibatch/coeochdeexptest.php`
- `kimibatch/inko201604_status_offen_auf_inA_setzen.php`
- `kimibatch/inkode04_status_offen_auf_inA_setzen.php`
- `kimibatch/inkodeexp_new.php`
- `kimibatch/inkodeimp2x.php`
- `kimibatch/oko04_status_offen_auf_inA_setzen.php`
- `kimibatch/oko04_status_offen_vortage_auf_inA_setzen.php`
- `kimibatch/oko_inA_outbound_elsbeth.php`
- `kimibatch/okoexpzwb.php`
- `kimibatch/pwgen.php`

Observed failure patterns:

- direct parse error
- removed legacy `mysql_*` API usage
- undefined helper/function usage such as `bFetchArray()`
- missing UI/lang constants in scripts that are not robust when executed standalone

#### 2. Initial-hook failures

Current failing covered initial hooks:

- `modules/initial/bankleitzahl.php`
- `modules/initial/buchungen.php`
- `modules/initial/inkassoinformation.php`
- `modules/initial/lastschrift.php`
- `modules/initial/schadensfall.php`
- `modules/initial/status_schadensfall.php`
- `modules/initial/subdetail.php`
- `modules/initial/ticketsuch_sich20150208.php`

Observed failure patterns:

- `count(null)` / non-countable TypeErrors under PHP 8
- null bootstrap/context assumptions such as `$kunde` being missing
- wrong method call arity against current entity method signatures

#### 3. Menu failures

Current failing covered menu entries:

- `modules/menu/bankleitzahl.php`
- `modules/menu/buchungen.php`
- `modules/menu/inkassoinformation.php`
- `modules/menu/lastschrift.php`
- `modules/menu/schadensfall.php`
- `modules/menu/status_schadensfall.php`
- `modules/menu/subdetail.php`
- `modules/menu/ticketsuch_sich20150208.php`

Observed failure pattern:

- these mostly fail because the paired `modules/initial/*.php` hook fails first

#### 4. Top-level entrypoint failure

Current failing covered top-level entrypoint:

- `src/original-src/web/htdocs/kimi_ET/getticketurl.php`

Observed failure pattern:

- `mysqli_fetch_assoc(false)` caused by missing result validation before fetch

## Remediation direction

These failures are expected upgrade findings from the legacy source tree in:

- `src/original-src/`

They should be treated as migration-safety-net findings and addressed in the upgraded codebase in:

- `src/upgraded-src/`

In other words:

- the smoke suite remains the detection mechanism
- the fixes should be implemented in `src/upgraded-src`
- the legacy original source should continue to serve as the reference baseline unless there is a deliberate reason to patch it directly
