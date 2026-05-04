# Batch Docker Compatibility

Date: 2026-05-04

## Problem Summary

Legacy batch scripts under `src/original-src/web/htdocs/kimi_ET/kimibatch/` do not use the normal app DB config.
Instead, `kimibatch/db.php` hardcodes:

- host: `localhost`
- user: `sql_kimi_et`
- password: `NS889Hs4bhL1aub7HyEH6AjdYpYAlx`

In the current Docker stack:

- the main app uses DB host `db`
- the DB user `sql_kimi_et` is created with password `password`
- PHP `mysqli_connect('localhost', ...)` in the `web` container behaves as local-socket access, not Docker DNS to `db`

Result: batch scripts fail in Docker before any business logic runs.

## Verified Findings

### 1. Batch host assumption differs from the web app

`src/original-src/web/htdocs/kimi_ET/config/config.php` uses:

- `CONF_MYSQL_SERVER = "db"`
- `CONF_MYSQL_PASSWORD = "password"`

But `src/original-src/web/htdocs/kimi_ET/kimibatch/db.php` uses:

- `$dbhost = "localhost"`
- `$dbpass = "NS889Hs4bhL1aub7HyEH6AjdYpYAlx"`

### 2. The current DB user does not match the batch password

The current Compose stack creates `sql_kimi_et` via `MYSQL_USER / MYSQL_PASSWORD`, using password `password`.
Live DB inspection confirmed the stored password hash matches `password`, not the batch hardcoded password.

### 3. The failure is not just hostname resolution

Observed batch error:

```text
Warning: mysqli_connect(): (HY000/2002): No such file or directory
Fatal error: Uncaught TypeError: mysqli_set_charset(): Argument #1 ($mysql) must be of type mysqli, bool given
```

This means PHP is attempting local MySQL socket access for `localhost`, and no usable socket exists inside the `web` container at the expected path.

### 4. MariaDB exposes a usable socket inside the `db` container

Verified socket path in the DB container:

- `/var/run/mysqld/mysqld.sock`

## Recommended Direction

Support legacy batch scripts in the **current `web` container** by adapting the Docker/DB environment, not the PHP code.

This keeps:

- GUI/web app behavior unchanged
- batch scripts runnable from the existing container
- `src/original-src/web/` untouched

## Recommended Environment-Only Design

### A. Share the MariaDB socket into the `web` container

Add a named volume mounted at `/var/run/mysqld` in both `db` and `web`.

Purpose:

- allow `mysqli_connect('localhost', ...)` from the `web` container to reach a real local socket

### B. Add a localhost-specific DB login for the batch password

Create:

```sql
CREATE USER IF NOT EXISTS 'sql_kimi_et'@'localhost'
  IDENTIFIED BY 'NS889Hs4bhL1aub7HyEH6AjdYpYAlx';

GRANT ALL PRIVILEGES ON kimi_et.* TO 'sql_kimi_et'@'localhost';
```

Purpose:

- preserve the existing GUI login path (`sql_kimi_et` with password `password`)
- satisfy the legacy batch login path (`sql_kimi_et@localhost` with password `NS...`)

This avoids changing the existing `%` user created by Compose.

## Exact Proposed Changes

### 1. `src/original-src/docker-compose.yml`

Add a shared named volume for the MySQL socket and mount it into both services.

Proposed diff:

```yaml
services:
  db:
    image: mariadb:10.5
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: kimi_et
      MYSQL_USER: sql_kimi_et
      MYSQL_PASSWORD: password
    volumes:
      - db_data:/var/lib/mysql
      - db_socket:/var/run/mysqld
      - ./docker/mariadb/init:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
      interval: 10s
      timeout: 5s
      retries: 5

  web:
    build: ./docker/php
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - ./web/htdocs:/var/www/html
      - ./tests2:/opt/tests2
      - db_socket:/var/run/mysqld
    depends_on:
      db:
        condition: service_healthy

volumes:
  db_data:
  db_socket:
```

### 2. `src/original-src/docker/mariadb/init/01-init.sql`

Append a localhost-specific batch user entry:

```sql
CREATE USER IF NOT EXISTS 'sql_kimi_et'@'localhost'
    IDENTIFIED BY 'NS889Hs4bhL1aub7HyEH6AjdYpYAlx';

GRANT ALL PRIVILEGES ON kimi_et.* TO 'sql_kimi_et'@'localhost';
```

Keep the existing archive user statements as-is.

## Why this approach is preferred

Compared with changing the global `sql_kimi_et` password to the batch hardcoded value:

- it does not risk breaking the main app config that currently expects `password`
- it preserves both legacy access patterns simultaneously
- it documents the real historical inconsistency instead of flattening it

Compared with a dedicated batch-only runner container:

- it keeps batch execution available in the normal `web` environment
- it reduces divergence between “test container” and “normal container”

## Risks and Checks

### Risks

1. Socket sharing is a local-dev compatibility technique

It is suitable for reconstructing the legacy environment, but it should not automatically be treated as a production design recommendation.

2. MariaDB user matching must be verified

When both `sql_kimi_et@localhost` and `sql_kimi_et@'%'` exist, MariaDB should choose the more specific localhost account for socket/local access. This must be confirmed after startup.

3. Existing DB volume may hide init changes

If `db_data` already exists, adding SQL to `docker-entrypoint-initdb.d` will not re-run automatically. A rebuild/reset flow or manual SQL application will be required.

4. File permissions on the socket mount must be verified

The `web` container process must be able to access `/var/run/mysqld/mysqld.sock`.

5. Batch may fail later for other reasons

This change only addresses the current bootstrap failure. Once DB access works, other runtime or PHP compatibility issues may surface.

### Checks after implementation

1. Confirm socket exists in `web`:

```bash
docker compose -f src/original-src/docker-compose.yml exec -T web \
  sh -lc 'ls -l /var/run/mysqld/mysqld.sock'
```

2. Confirm localhost batch login works:

```bash
docker compose -f src/original-src/docker-compose.yml exec -T web \
  php -r '$c=mysqli_connect("localhost","sql_kimi_et","NS889Hs4bhL1aub7HyEH6AjdYpYAlx","kimi_et"); var_dump((bool)$c);'
```

Expected: `bool(true)`

3. Confirm normal GUI DB path still works:

```bash
docker compose -f src/original-src/docker-compose.yml exec -T web \
  php -r '$c=mysqli_connect("db","sql_kimi_et","password","kimi_et"); var_dump((bool)$c);'
```

Expected: `bool(true)`

4. Re-run smoke tests:

```bash
src/original-src/tests/run-batch.sh
src/original-src/tests/run-all.sh
```

## Decision

If the goal is to make legacy batch processing runnable in the **current Docker web container** without changing preserved PHP source, the preferred path is:

1. shared MySQL socket volume
2. localhost-specific `sql_kimi_et` user with the batch hardcoded password

This is the smallest environment-only change set that addresses both observed incompatibilities.

## Verification Result

Verified on 2026-05-04 with a clean rebuild:

```bash
docker compose -f src/original-src/docker-compose.yml down -v
docker compose -f src/original-src/docker-compose.yml up -d --build
```

### Confirmed fixed

Both DB access paths work in the rebuilt `web` container:

- GUI path: `mysqli_connect("db", "sql_kimi_et", "password", "kimi_et")`
- batch path: `mysqli_connect("localhost", "sql_kimi_et", "NS889Hs4bhL1aub7HyEH6AjdYpYAlx", "kimi_et")`

So the original batch failure in `kimibatch/db.php` is resolved by the environment-only changes.

### New blocker exposed after DB fix

Batch smoke tests now fail later in `kimibatch/kimi_general.php` because it requires:

```php
./vendor/phpmailer/phpmailer/src/PHPMailer.php
```

from the `kimibatch/` working directory, and that path does not exist in the current local reconstruction.

Observed failure pattern:

```text
Warning: require(./vendor/phpmailer/phpmailer/src/PHPMailer.php): Failed to open stream
Fatal error: Uncaught Error: Failed opening required './vendor/phpmailer/phpmailer/src/PHPMailer.php'
```

This means the DB/bootstrap issue is fixed, but the local Docker/dev environment still does not fully reconstruct the batch dependency layout expected by `kimibatch/`.

### Smoke-test baseline after the environment fix

- `GuiSmokeTest`: 17/17 passing
- `BatchSmokeTest`: 115 tests, 114 failures
- Full suite: 132 tests, 114 failures

The remaining failures are no longer dominated by `localhost` DB access. They are now dominated by the missing batch PHPMailer dependency path, plus at least one independent parse error in `coeochdeexptest.php`.
