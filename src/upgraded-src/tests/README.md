# KIMI Portal Smoke Tests

Runtime PHP smoke tests. Verifies all PHP modules and batch scripts execute without PHP fatal or parse errors.
This is the baseline safety net for the PHP 8.5 compatibility upgrade.

## Requirements

Docker stack must be running and fully initialized (schema + dev seed applied):

```bash
docker compose up -d
```

## Install PHPUnit (one-time, runs on host)

`composer` is not in the Docker image. Run on host from the repository root:

```bash
composer install --working-dir=src/upgraded-src/tests
```

## Run all tests

```bash
./src/upgraded-src/tests/run-all.sh
```

## Run by suite

```bash
# GUI modules + AJAX handlers
./src/upgraded-src/tests/run-gui.sh

# Batch scripts (~117 files)
./src/upgraded-src/tests/run-batch.sh
```

## Script details

All runner scripts resolve the repository root automatically, so they can be launched from any
working directory:

```bash
src/upgraded-src/tests/run-all.sh
src/upgraded-src/tests/run-gui.sh
src/upgraded-src/tests/run-batch.sh
```

## What is covered

| Category | Count | Method |
|---|---|---|
| GUI modules (`modules/gui/*.php`) | 13 | Bootstrap harness (`harness/gui_runner.php`) -> direct include |
| AJAX handlers (`ajax/*.php`) | 4 | Bootstrap harness (`harness/gui_runner.php`) -> direct include |
| Batch scripts (contain `kimi_general.php`) | ~117 | Direct CLI exec |
| **Total directly tested** | **~134** | |

## Notes on batch test output

Batch scripts connect to the DB using `$dbhost="localhost"`. Inside Docker, `localhost` refers to
the container itself (not the MariaDB service). In the current PHP 8.0 baseline, most batch scripts
do not exit cleanly: `kimibatch/db.php` calls `mysqli_set_charset()` even when `mysqli_connect()`
returns `false`, which produces a fatal `TypeError`.

This is useful baseline signal, not a test-harness bug. The smoke tests are showing a real runtime
failure path in the batch layer. As of 2026-05-04 the observed baseline is:

- `GuiSmokeTest`: 17/17 passing
- `BatchSmokeTest`: 115 tests, 114 failures
- Full suite: 132 tests, 114 failures

There is also at least one direct parse error in `kimibatch/coeochdeexptest.php`. A passing batch
test confirms PHP compatibility, not business logic.

## Adding new files

No list to maintain. Files are discovered at runtime. Any new `.php` file added to `modules/gui/`,
`ajax/`, or `kimibatch/` (that contains `include kimi_general.php`) is automatically included in the
next test run.
