---
name: kimi-run-smoke-tests
description: Run the PHPUnit runtime smoke-test safety net for the KIMI Portal (checks that entrypoints load without PHP fatal/parse errors). Use when asked to "run the tests", "run smoke tests", "check nothing is broken on 8.5", verify an upgrade change, or before merging upgrade work. Green baseline for upgraded-src is 216 tests / 0 failures.
---

# Run the smoke-test safety net

The suite answers one narrow question: do the runtime entrypoints
(`kimibatch/*`, `modules/gui`, `ajax`, router, top-level scripts) execute without PHP
fatal or parse errors? It is **not** a business-logic suite. Full details:
`memory-bank/smoke-tests-upgraded-src.md` (upgraded) and
`memory-bank/smoke-tests-original-src.md` (baseline).

| Suite | Baseline | Meaning |
|-------|----------|---------|
| `src/upgraded-src/tests/` | 216 tests / **0 failures** (green) | PHP 8.5 target |
| `src/original-src/tests/` | 223 tests / 27 known failures | PHP 8.0 reference |

## Workflow

1. Ensure the target stack is up, then run all suites:
   ```bash
   src/upgraded-src/tests/run-all.sh
   ```
   (Runs PHPUnit `--testdox` in the `web` container. `run-batch.sh` / `run-gui.sh` run
   subsets.) Original baseline: `src/original-src/tests/run-all.sh`.
2. Suites use `glob()`/`grep` discovery, so new files are picked up automatically — no
   test list to maintain.

## Verification

Upgraded-src must stay **0 failures**. If a change introduces a failure, treat it as a
regression: capture the failing testdox line and the PHP error, then hand off to the
`kimi-test-engineer` (to reproduce/extend coverage) or `kimi-code-reviewer` (to judge the
change). Do not edit the green baseline count to hide a failure.
