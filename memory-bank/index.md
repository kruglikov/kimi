# Memory bank

`@memory-bank/` consists of the following files. Each entry is `filename — description`
so AI agents can navigate the project knowledge base at a high level.

- `index.md` — the current file; lists every memory-bank file so AI agents can navigate the knowledge base.
- `stakeholders.md` — people involved in the project and their roles (Innowise delivery side, client KIMI Plus GmbH, hosting ANEXIA).
- `ARCHITECTURE.md` — project technical architecture: both `src/original-src/` (PHP 8.0) and `src/upgraded-src/` (PHP 8.5) stacks, routing, auth, entities, modules, AJAX, telephony, batch system.
- `upgraded-src.md` — layout, Docker setup, Rector tooling, modification policy, and current upgrade status for `src/upgraded-src/`.
- `batch-processing-subsystem.md` — what the `kimibatch/` subsystem is: utilities, campaign scripts, campaigns list, per-campaign data file layout, and the client-approved removals applied to `src-dev/`.
- `batch-docker-compatibility.md` — environment-only strategy for making legacy `kimibatch/` scripts run inside the current Docker stack without changing `src/original-src/web/`.
- `smoke-tests-original-src.md` — PHP runtime smoke-test safety net for `src/original-src/` (PHP 8.0 baseline, 223 tests / 27 known failures).
- `smoke-tests-upgraded-src.md` — PHP runtime smoke-test safety net for `src/upgraded-src/` (PHP 8.5, 216 tests / 0 failures — green baseline).
- `smoke-tests-src-dev.md` — PHP runtime smoke-test safety net for `src-dev/`, the tree deployed to the ANEXIA dev server (580 tests / 0 failures / 60 skipped — green baseline), plus what is quarantined and why.
- `git-tracking-policy-kimidev-et.md` — what the deployed tree `kimidev_ET` tracks in git and why (everything except `ajax/log/`), why the environment `config.php` files are tracked, how the local Docker stack relates to them, and why the local mirror's untracked test artifacts must never be committed.
- `deploy-and-rollback-runbook.md` — the order of operations for deploying to the ANEXIA dev server and for rolling a deployment back, plus what a rollback does not undo.
- `environment-value-differences.md` — every value that differs between the dev and production instances (host, document root, databases, session name) and the production references hard-coded in the deployed tree.
