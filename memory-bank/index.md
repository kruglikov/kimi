# Memory bank

`@memory-bank/` consists of the following files. Each entry is `filename — description`
so AI agents can navigate the project knowledge base at a high level.

- `index.md` — the current file; lists every memory-bank file so AI agents can navigate the knowledge base.
- `stakeholders.md` — people involved in the project and their roles (Innowise delivery side, client KIMI Plus GmbH, hosting ANEXIA).
- `ARCHITECTURE.md` — project technical architecture: both `src/original-src/` (PHP 8.0) and `src/upgraded-src/` (PHP 8.5) stacks, routing, auth, entities, modules, AJAX, telephony, batch system.
- `upgraded-src.md` — layout, Docker setup, Rector tooling, modification policy, and current upgrade status for `src/upgraded-src/`.
- `batch-processing-subsystem.md` — what the `kimibatch/` subsystem is: utilities, campaign scripts, campaigns list, per-campaign data file layout.
- `batch-docker-compatibility.md` — environment-only strategy for making legacy `kimibatch/` scripts run inside the current Docker stack without changing `src/original-src/web/`.
- `smoke-tests-original-src.md` — PHP runtime smoke-test safety net for `src/original-src/` (PHP 8.0 baseline, 223 tests / 27 known failures).
- `smoke-tests-upgraded-src.md` — PHP runtime smoke-test safety net for `src/upgraded-src/` (PHP 8.5, 216 tests / 0 failures — green baseline).
