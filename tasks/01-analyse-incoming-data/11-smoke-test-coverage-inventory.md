# Smoke Test Coverage Inventory

## Purpose

This document inventories the executable PHP runtime surfaces in the legacy KIMI portal and maps the current smoke-test suite coverage to those surfaces.

The goal is to answer two separate questions clearly:

1. What runtime entrypoints exist in the current codebase?
2. Which of those entrypoints are currently covered by the smoke-test suite in `src/original-src/tests/`?

This document does **not** measure line or function code coverage. It measures runtime surface coverage.

## Inputs Reviewed

- `src/original-src/tests/SmokeTest/GuiSmokeTest.php`
- `src/original-src/tests/SmokeTest/BatchSmokeTest.php`
- `src/original-src/tests/harness/gui_runner.php`
- `src/original-src/web/htdocs/index.php`
- `src/original-src/web/htdocs/kimi_ET/index.php`
- `src/original-src/web/htdocs/kimi_ET/login.php`
- `src/original-src/web/htdocs/kimi_ET/libs/init.php`
- `src/original-src/web/htdocs/kimi_ET/libs/application.php`

## Current Smoke-Test Selection Logic

### GUI and AJAX

The current GUI smoke suite directly enumerates:

- `kimi_ET/modules/gui/*.php`
- `kimi_ET/ajax/*.php`

The test executes each file through `harness/gui_runner.php`, which bootstraps the app, seeds session state, optionally includes a same-name `modules/initial/*.php` pre-hook, and then directly includes the target file.

Important implication:

- this covers module/bootstrap execution
- this does **not** execute the real `kimi_ET/index.php` router flow
- this does **not** execute the real page shell and header/menu include path

### Batch

The current batch smoke suite enumerates:

- `kimi_ET/kimibatch/*.php`

but only includes files whose source contains:

- `kimi_general.php`

Important implication:

- this is a heuristic for executable batch jobs
- this is not yet a complete policy for all files in `kimibatch/`

## Inventory Matrix

| Surface                                | Files   | How app uses it | Current smoke coverage | Notes |
|----------------------------------------|--------:|---|---|---|
| `modules/gui/*.php`                    |      13 | Main routed GUI views via `index.php?site=...` | Direct | Covered by direct include, not through real router |
| `ajax/*.php`                           |       4 | AJAX via `index.php?ajax=true&site=...` | Direct | Covered by direct include, not through real router |
| `modules/initial/*.php`                |      30 | Pre-hook before GUI render | 10 indirect, 20 none | Only same-name hooks used by current GUI runner are hit |
| `modules/menu/*.php`                   |      25 | Header/menu rendering during real `index.php` page render | None | Current GUI runner bypasses the page shell/header path |
| Top-level `kimi_ET/*.php`              |       9 | Direct web entrypoints and integrations | Mostly none | Mixed bag: real endpoints, debug pages, third-party tool |
| `kimibatch/*.php`                      |     128 | Batch/CLI jobs and helpers | 115 direct, 13 none | Current selector is `contains kimi_general.php` |
| Public web root `web/htdocs/index.php` |       1 | Redirect entry | None | Redirects to `/kimi_ET/login.php` |

## Current Coverage Summary

| Category                        | Count   | Covered now   | Coverage type   |
|---------------------------------|--------:|--------------:|-----------------|
| GUI modules                     |      13 |            13 | Direct          |
| AJAX handlers                   |       4 |             4 | Direct          |
| Initial hooks                   |      30 |            10 | Indirect        |
| Menu modules                    |      25 |             0 | None            |
| Top-level `kimi_ET` entry files |       9 |             0 | None            |
| Batch scripts                   |     128 |           115 | Direct          |
| Public root index               |       1 |             0 | None            |

## Detailed Current Coverage

### Directly Covered GUI Modules

- `404.php`
- `akt.php`
- `kampauswahl.php`
- `logout.php`
- `menu_verw.php`
- `np.php`
- `portal.php`
- `pwgen.php`
- `ticket.php`
- `ticket2.php`
- `ticket_sich.php`
- `ticketsuch.php`
- `ticketsuch2.php`

### Directly Covered AJAX Handlers

- `add_log.php`
- `callInntelco.php`
- `check-login.php`
- `write_file.php`

### Indirectly Covered `modules/initial/*.php`

These are covered only because the current GUI runner includes a same-name pre-hook before including the GUI module:

- `akt.php`
- `kampauswahl.php`
- `logout.php`
- `menu_verw.php`
- `portal.php`
- `pwgen.php`
- `ticket.php`
- `ticket2.php`
- `ticketsuch.php`
- `ticketsuch2.php`

### Not Covered `modules/initial/*.php`

- `bankleitzahl.php`
- `buchungen.php`
- `inkassoinformation.php`
- `kunde.php`
- `kunde_details.php`
- `kundenhistorie.php`
- `lastschrift.php`
- `ratenrechner.php`
- `schadensfall.php`
- `schadensfall_art.php`
- `stammdaten.php`
- `stammsuche.php`
- `status_schadensfall.php`
- `subdetail.php`
- `subsuche.php`
- `subuebersicht.php`
- `subverwalt.php`
- `ticket_sich20150208.php`
- `ticketsuch_sich20150208.php`
- `versicherung.php`

### `modules/menu/*.php` Status

No `modules/menu/*.php` file is currently executed by the smoke harness.

This is an important distinction:

- some menu filenames align with currently covered GUI routes
- but the menu files themselves are only included by the real `kimi_ET/index.php` page shell
- the current `gui_runner.php` bypasses that shell

Menu files aligned with currently covered GUI routes but still not executed today:

- `menu_verw.php`
- `portal.php`
- `ticket.php`
- `ticket2.php`
- `ticketsuch.php`
- `ticketsuch2.php`

Remaining menu files not covered:

- `bankleitzahl.php`
- `buchungen.php`
- `inkassoinformation.php`
- `kunde.php`
- `kunde_details.php`
- `kundenhistorie.php`
- `lastschrift.php`
- `ratenrechner.php`
- `schadensfall.php`
- `schadensfall_art.php`
- `stammdaten.php`
- `stammsuche.php`
- `status_schadensfall.php`
- `subdetail.php`
- `subsuche.php`
- `subuebersicht.php`
- `subverwalt.php`
- `ticketsuch_sich20150208.php`
- `versicherung.php`

### Top-Level `kimi_ET/*.php` Inventory

| File                    | Observed role                           | Current smoke status | Comment |
|-------------------------|-----------------------------------------|---|---|
| `index.php`             | Main router entrypoint                  | None | Real portal dispatch path is not currently smoked as an entrypoint |
| `login.php`             | Login and mandant selection page        | None | Separate top-level web entrypoint |
| `getticketurl.php`      | Telephony/integration-style endpoint    | None | Likely should be evaluated for smoke coverage |
| `setticketcallinfo.php` | JSON/webhook-style integration endpoint | None | Likely should be evaluated for smoke coverage |
| `xhangup.php`           | Telephony/integration-style endpoint    | None | Likely should be evaluated for smoke coverage |
| `validphone.php`        | External HTTP lookup script             | None | Unsuitable for default smoke without isolation or mocking |
| `testpost.php`          | Test/debug script                       | None | Likely non-production utility |
| `phpinfo.php`           | Debug/diagnostic page                   | None | Usually exclude from default smoke scope |
| `adminer-4.8.1.php`     | Bundled third-party admin tool          | None | Usually exclude from default smoke scope |

### Public Web Root Entry

`src/original-src/web/htdocs/index.php` is only a redirect entrypoint:

- redirects to `/kimi_ET/login.php`

It is not covered by current smoke tests.

### Batch Coverage

Current direct batch coverage:

- 115 files in `kimi_ET/kimibatch/`

Current excluded files from the `contains kimi_general.php` rule:

- `db.php`
- `inkodeexp_new.php`
- `kimi_general.php`
- `kimibatchtree.php`
- `kimiphpinfo.php`
- `oko_inA_outbound_elsbeth.php`
- `okoexpzwb.php`
- `phpinfo.php`
- `pwgen.php`
- `substr.php`
- `telematica_import_callmanager_log.php`
- `wl.php`
- `zeichenersetzen.php`

These excluded files need explicit classification later:

- helper/support-only
- obsolete/manual
- real executable batch entrypoint
- separate integration smoke candidate

## Interpretation

The current smoke suite is a useful baseline for the PHP 8.5 upgrade, but the exact strength of that baseline must be stated precisely.

The current suite supports this statement:

- most GUI module files, all AJAX handler files, and most batch-job entry scripts are executed at least once with parse/fatal/runtime-startup checks

The current suite does **not** yet support this stronger statement:

- the real portal entrypoints and routing shell are smoke-covered end to end

The largest current blind spots are:

- real `kimi_ET/index.php` routing as an entrypoint
- `login.php`
- all `modules/menu/*.php`
- 20 of 30 `modules/initial/*.php`
- top-level telephony/integration endpoints
- the 13 batch-area files excluded by heuristic rather than explicit policy

## Recommended Labels For Follow-Up

For the next iteration, each runtime surface should be labeled as one of:

- `must-smoke-now`
- `optional-or-isolated`
- `exclude-from-default-smoke`

Initial suggested direction:

### Must Smoke Now

- `kimi_ET/index.php` routed GUI flows
- `kimi_ET/index.php` routed AJAX flows
- `kimi_ET/login.php`
- production-used `kimibatch/*.php`
- `getticketurl.php`
- `setticketcallinfo.php`
- `xhangup.php`

### Optional or Isolated

- `validphone.php`
- manual/debug test utilities

### Exclude From Default Smoke

- `adminer-4.8.1.php`
- `phpinfo.php`
- helper-only batch files such as `kimi_general.php`
- likely `kimibatch/db.php` if confirmed helper-only

## Conclusion

The current smoke suite is a strong first-pass compatibility net for selected runtime surfaces, but it is not yet a complete runtime entrypoint smoke net for the portal.

The next practical step is not line coverage first. The next practical step is:

1. accept this inventory as the baseline runtime-surface map
2. classify each uncovered entrypoint as must-smoke, optional, or excluded
3. expand smoke harnesses around the real router and top-level integration endpoints

---

# Not covered files list (groupped by groups) and plan what to do with them

This section lists the files that are currently not covered by the smoke suite and proposes a concrete treatment for each file.

The proposal categories used below are:

- `Cover via router smoke`
- `Cover via dedicated endpoint smoke`
- `Cover via dedicated batch smoke`
- `Exclude from default smoke`
- `Review manually before deciding`

## Group 1: Top-level web entrypoints in `kimi_ET/`

These files are directly web-accessible and are not currently covered by the smoke suite.

| File                    | Proposed treatment                 | Reasoning |
|-------------------------|------------------------------------|---|
| `index.php`             | Cover via router smoke             | This is the real main application entrypoint and should be exercised directly, not only through direct module includes. |
| `login.php`             | Cover via dedicated endpoint smoke | Separate top-level login/mandant-selection page; should be smoked with anonymous and seeded-session scenarios. |
| `getticketurl.php`      | Cover via dedicated endpoint smoke | Looks like a real telephony/integration endpoint and should be tested with synthetic request input. |
| `setticketcallinfo.php` | Cover via dedicated endpoint smoke | JSON/webhook-style integration endpoint; needs a request-body harness rather than GUI include logic. |
| `xhangup.php`           | Cover via dedicated endpoint smoke | Telephony/integration-style endpoint; should be run with representative synthetic parameters. |
| `validphone.php`        | Exclude from default smoke         | Makes live outbound HTTP calls; should not be part of the default smoke gate until isolated or mocked. |
| `testpost.php`          | Cover                              | Appears to be a debug/test utility and may not be production-relevant. Confirm whether it has any real operational use. |
| `phpinfo.php`           | Exclude from default smoke         | Diagnostic/debug page, not a business runtime path. |
| `adminer-4.8.1.php`     | Exclude from default smoke         | Bundled third-party database tool; should not be part of application smoke coverage. |

## Group 2: `modules/initial/*.php` files not currently covered

These pre-hook files are not currently exercised by the GUI smoke runner because there is no same-name covered GUI route in the current suite, or because the module family itself is not yet covered through the real router.

| File                          | Proposed treatment     | Reasoning |
|-------------------------------|------------------------|---|
| `bankleitzahl.php`            | Cover via router smoke | Should become covered when the real `index.php?site=bankleitzahl` path is smoked, if that route is still used. |
| `buchungen.php`               | Cover via router smoke | Same treatment: cover through real routed page load. |
| `inkassoinformation.php`      | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `kunde.php`                   | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `kunde_details.php`           | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `kundenhistorie.php`          | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `lastschrift.php`             | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `ratenrechner.php`            | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `schadensfall.php`            | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `schadensfall_art.php`        | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `stammdaten.php`              | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `stammsuche.php`              | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `status_schadensfall.php`     | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `subdetail.php`               | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `subsuche.php`                | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `subuebersicht.php`           | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `subverwalt.php`              | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |
| `ticket_sich20150208.php`     | Cover                  | Historical/suffixed variant. Confirm whether still routable and business-relevant before adding it to smoke. |
| `ticketsuch_sich20150208.php` | Cover                  | Historical/suffixed variant. Confirm whether still routable and business-relevant before adding it to smoke. |
| `versicherung.php`            | Cover via router smoke | Same treatment: route-level smoke is the correct boundary. |

## Group 3: `modules/menu/*.php` files not currently covered

These files are included by the real page shell during `kimi_ET/index.php` rendering and are currently bypassed by the GUI runner.

The right long-term treatment for almost all of them is the same:

- do not create a separate menu-only harness
- instead cover them by exercising the real routed page through `kimi_ET/index.php`

| File                          | Proposed treatment     | Reasoning |
|-------------------------------|------------------------|---|
| `bankleitzahl.php`            | Cover via router smoke | Menu include should be covered when the real page route is rendered. |
| `buchungen.php`               | Cover via router smoke | Same treatment. |
| `inkassoinformation.php`      | Cover via router smoke | Same treatment. |
| `kunde.php`                   | Cover via router smoke | Same treatment. |
| `kunde_details.php`           | Cover via router smoke | Same treatment. |
| `kundenhistorie.php`          | Cover via router smoke | Same treatment. |
| `lastschrift.php`             | Cover via router smoke | Same treatment. |
| `menu_verw.php`               | Cover via router smoke | Currently aligned to an already GUI-smoked module, but still not executed because the header shell is bypassed. |
| `portal.php`                  | Cover via router smoke | Same treatment. |
| `ratenrechner.php`            | Cover via router smoke | Same treatment. |
| `schadensfall.php`            | Cover via router smoke | Same treatment. |
| `schadensfall_art.php`        | Cover via router smoke | Same treatment. |
| `stammdaten.php`              | Cover via router smoke | Same treatment. |
| `stammsuche.php`              | Cover via router smoke | Same treatment. |
| `status_schadensfall.php`     | Cover via router smoke | Same treatment. |
| `subdetail.php`               | Cover via router smoke | Same treatment. |
| `subsuche.php`                | Cover via router smoke | Same treatment. |
| `subuebersicht.php`           | Cover via router smoke | Same treatment. |
| `subverwalt.php`              | Cover via router smoke | Same treatment. |
| `ticket.php`                  | Cover via router smoke | Same treatment. |
| `ticket2.php`                 | Cover via router smoke | Same treatment. |
| `ticketsuch.php`              | Cover via router smoke | Same treatment. |
| `ticketsuch2.php`             | Cover via router smoke | Same treatment. |
| `ticketsuch_sich20150208.php` | Cover                  | Historical/suffixed variant. Confirm whether still reachable in current UI before adding. |
| `versicherung.php`            | Cover via router smoke | Same treatment. |

## Group 4: `kimibatch/*.php` files excluded by the current batch selector

These files are not covered because the current suite only includes files whose source contains `kimi_general.php`.

| File                                    | Proposed treatment              | Reasoning |
|-----------------------------------------|---------------------------------|---|
| `db.php`                                | Exclude from default smoke      | Looks like shared support/bootstrap, not a standalone business batch entrypoint. |
| `inkodeexp_new.php`                     | Review manually before deciding | Name suggests a real batch/export variant; decide whether it is active or obsolete. |
| `kimi_general.php`                      | Exclude from default smoke      | Shared support/bootstrap file, not a standalone batch job. |
| `kimibatchtree.php`                     | Review manually before deciding | Name is not enough to determine whether it is utility or executable. Needs quick review. |
| `kimiphpinfo.php`                       | Exclude from default smoke      | Diagnostic/debug script, not a business batch flow. |
| `oko_inA_outbound_elsbeth.php`          | Review manually before deciding | Name suggests a real business-specific batch or integration path and may need dedicated smoke. |
| `okoexpzwb.php`                         | Review manually before deciding | Name suggests a real business-specific batch or export path and may need dedicated smoke. |
| `phpinfo.php`                           | Exclude from default smoke      | Diagnostic/debug script. |
| `pwgen.php`                             | Review manually before deciding | Could be utility-only; verify whether it is a real operational batch entrypoint. |
| `substr.php`                            | Exclude from default smoke      | Utility/helper-style script name, likely not a standalone batch flow. |
| `telematica_import_callmanager_log.php` | Review manually before deciding | Name suggests a real integration/import job and may deserve dedicated smoke. |
| `wl.php`                                | Review manually before deciding | Too ambiguous to classify from name alone; needs quick review. |
| `zeichenersetzen.php`                   | Review manually before deciding | Utility-like name; confirm whether it is support-only or an executable operational script. |

## Group 5: Public web root entrypoint not covered

| File                                    | Proposed treatment         | Reasoning |
|-----------------------------------------|----------------------------|---|
| `src/original-src/web/htdocs/index.php` | Exclude from default smoke | Only a redirect wrapper to `/kimi_ET/login.php`; testing `kimi_ET/login.php` covers the meaningful application path. |

## Proposed execution plan for the next step

After review and approval of this classification, the covering step should proceed in this order:

1. Add router-based smoke coverage for `kimi_ET/index.php` and use it to cover real GUI, `modules/initial`, and `modules/menu` execution paths together.
2. Add a dedicated smoke harness for `kimi_ET/login.php`.
3. Add dedicated endpoint smoke harnesses for `getticketurl.php`, `setticketcallinfo.php`, and `xhangup.php`.
4. Review the historical `*_sich20150208.php` files and decide whether they are active, obsolete, or intentionally excluded.
5. Review the 13 currently excluded batch-area files one by one and classify them as real batch entrypoints, support files, or debug utilities.
6. Keep `validphone.php`, `phpinfo.php`, `adminer-4.8.1.php`, and obvious helper/bootstrap files outside the default smoke gate unless there is a specific reason to include them.

# Current smoke coverage status after implementation

This section reflects the state after the approved smoke-test expansion was implemented in `src/original-src/tests/` and the suite was executed with:

- `./src/original-src/tests/run-all.sh`

Important distinction:

- "covered" means the file or route is now exercised by an automated smoke test
- "passing" means the smoke test currently completes without parse/fatal error
- some files are covered but currently failing, which is still useful because the purpose of the smoke suite is to expose these runtime problems

## Coverage summary by surface

| Surface | Coverage status now | Notes |
|---|---|---|
| `modules/gui/*.php` | Covered | Direct include smoke still exists, and real-router smoke was added for GUI routes. |
| `ajax/*.php` | Covered | Covered by the existing GUI smoke suite. |
| `modules/initial/*.php` | Covered | Covered by the new direct initial-hook smoke suite. |
| `modules/menu/*.php` | Covered | Covered by the new direct menu smoke suite together with the paired initial-hook bootstrap. |
| Top-level approved web entrypoints | Covered | `login.php`, `getticketurl.php`, `setticketcallinfo.php`, `xhangup.php`, `testpost.php` are now smoked. |
| `kimibatch/*.php` selected by current batch rule | Covered | 115 files selected by the existing `contains kimi_general.php` rule remain covered. |
| Public root `web/htdocs/index.php` | Not covered | Still intentionally excluded because it is only a redirect wrapper to `kimi_ET/login.php`. |
| Top-level excluded web entrypoints | Not covered | `validphone.php`, `phpinfo.php`, `adminer-4.8.1.php` remain outside default smoke scope. |
| Batch files excluded by current batch rule | Not covered | The 13 files outside the current selector remain not covered. |

## What is covered now

### 1. GUI routes

Covered by smoke tests:

- all files in `src/original-src/web/htdocs/kimi_ET/modules/gui/*.php`

Coverage type:

- direct module include smoke
- real router smoke through `kimi_ET/index.php?site=<route>`

Result:

- currently covered
- currently passing in both the direct GUI suite and the router suite

### 2. AJAX handlers

Covered by smoke tests:

- all files in `src/original-src/web/htdocs/kimi_ET/ajax/*.php`

Coverage type:

- existing direct include smoke through the GUI harness

Result:

- currently covered
- currently passing

### 3. Initial hooks

Covered by smoke tests:

- all files in `src/original-src/web/htdocs/kimi_ET/modules/initial/*.php`

Coverage type:

- dedicated direct include smoke via the new initial-hook harness

Result:

- currently covered
- some are passing
- some are failing and exposing runtime issues

Currently failing initial-hook files:

- `bankleitzahl.php`
- `buchungen.php`
- `inkassoinformation.php`
- `lastschrift.php`
- `schadensfall.php`
- `status_schadensfall.php`
- `subdetail.php`
- `ticketsuch_sich20150208.php`

### 4. Menu includes

Covered by smoke tests:

- all files in `src/original-src/web/htdocs/kimi_ET/modules/menu/*.php`

Coverage type:

- dedicated direct include smoke via the new menu harness
- the harness first includes the same-name initial file if present, because the menu files depend on route bootstrap context

Result:

- currently covered
- some are passing
- some are failing, mostly because their paired initial hook fails first

Currently failing menu files:

- `bankleitzahl.php`
- `buchungen.php`
- `inkassoinformation.php`
- `lastschrift.php`
- `schadensfall.php`
- `status_schadensfall.php`
- `subdetail.php`
- `ticketsuch_sich20150208.php`

### 5. Top-level approved web entrypoints

Covered by smoke tests:

- `login.php`
- `getticketurl.php`
- `setticketcallinfo.php`
- `xhangup.php`
- `testpost.php`

Coverage type:

- dedicated top-level entrypoint harness

Current result:

- passing:
  - `login.php`
  - `setticketcallinfo.php`
  - `xhangup.php`
  - `testpost.php`
- failing:
  - `getticketurl.php`

### 6. Batch entrypoints currently selected by the batch suite

Covered by smoke tests:

- 115 files in `src/original-src/web/htdocs/kimi_ET/kimibatch/`
- selection rule remains: source contains `kimi_general.php`

Current failing covered batch files:

- `coeochdeexptest.php`
- `inko201604_status_offen_auf_inA_setzen.php`
- `inkode04_status_offen_auf_inA_setzen.php`
- `inkodeimp2x.php`
- `oko04_status_offen_auf_inA_setzen.php`
- `oko04_status_offen_vortage_auf_inA_setzen.php`

## What is not covered yet

### 1. Top-level web files intentionally still outside default smoke scope

Not covered:

- `validphone.php`
- `phpinfo.php`
- `adminer-4.8.1.php`

Reason:

- they were explicitly kept outside the default smoke gate
- `validphone.php` performs live outbound HTTP requests
- `phpinfo.php` and `adminer-4.8.1.php` are debug/diagnostic/admin tooling paths rather than business runtime routes

### 2. Public root redirect wrapper

Not covered:

- `src/original-src/web/htdocs/index.php`

Reason:

- this file only redirects to `/kimi_ET/login.php`
- the meaningful application path is already covered via `kimi_ET/login.php`

### 3. Batch-area files excluded by the current batch selector

Still not covered:

- `db.php`
- `inkodeexp_new.php`
- `kimi_general.php`
- `kimibatchtree.php`
- `kimiphpinfo.php`
- `oko_inA_outbound_elsbeth.php`
- `okoexpzwb.php`
- `phpinfo.php`
- `pwgen.php`
- `substr.php`
- `telematica_import_callmanager_log.php`
- `wl.php`
- `zeichenersetzen.php`

Reason:

- the current batch suite still uses the old selection rule:
  - include only files whose source contains `kimi_general.php`
- these files therefore remain outside automated smoke coverage until they are explicitly classified and either:
  - added to smoke
  - intentionally excluded
  - moved to a separate dedicated suite

## Important caveats about current coverage

### Router coverage is complete only for real GUI routes

The new router smoke exercises real `kimi_ET/index.php?site=<route>` loads for the GUI routes that actually exist in `modules/gui/`.

This does **not** mean every `modules/initial/*.php` or `modules/menu/*.php` file has a real router path today.

Some files, especially historical or auxiliary variants such as:

- `ticket_sich20150208.php`
- `ticketsuch_sich20150208.php`

do not have matching `modules/gui/*.php` files and therefore cannot be honestly covered through the router alone. They are covered only through the direct initial/menu harnesses.

### Some menu coverage depends on the paired initial hook

For `modules/menu/*.php`, the direct menu harness first includes the same-name `modules/initial/*.php` file when it exists.

This means:

- the menu file is covered
- but if the initial hook fails first, the menu test fails before the menu code can be meaningfully exercised

This is still useful, because the real app also depends on that pre-hook chain.

## Current practical position

At this point the smoke suite now covers:

- all GUI files
- all AJAX files
- all initial-hook files
- all menu files
- the approved top-level web entrypoints
- the previously selected 115 batch entrypoints

At this point the smoke suite still does **not** cover:

- intentionally excluded top-level utility/admin/debug files
- the public redirect wrapper
- the 13 batch-area files outside the current batch selector

This means the remaining decision space is now much narrower:

1. decide whether any of the still-uncovered excluded files should be brought into smoke
2. decide how to classify the 13 currently unselected batch-area files
3. fix the currently failing covered files, if the goal is to make the expanded smoke suite green

# Not covered files list (groupped by groups) and plan what to do with them
