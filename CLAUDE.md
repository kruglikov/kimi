

This file provides guidance for AI Agent when working with code in this repository.

# Project Overview

Migration and modernisation of the **KIMI Portal** — a legacy PHP 8.0 / MariaDB 10.5 B2B SaaS portal for debt-collection call-centre agents.

Full system architecture is documented in `@ARCHITECTURE.md`.

# AI Agent instruction
- Once you finished the task, and did significant changes, please review @AGENTS.md file and @ARCHITECTURE.md  file and update it.

## Repository Layout

```
ARCHITECTURE.md              ← full system architecture (read this first)
CLAUDE.md                    ← this file

docs/                        ← Incoming client'd docunmentation saved here  
  01-initial-request/        ← original client brief and our response
  02-Kimi-portal-innowise-archive/  ← client-supplied archive (PPTX, PDF originals)
  03-translated docs/        ← German→English translated documentation

tasks/
  01-analyse-incoming-data/  ← analysis prompts, folder map, preliminary plan,
                               assessment report (04-asessment-report-v01.md)

src/
  original-src/
    web/                     ← original PHP source (Apache document root: web/htdocs/)
    docker/                  ← Docker support files (Dockerfile, vhost, DB init SQL)

scripts/up-original.sh       ← helper script for starting the original stack
src/original-src/docker-compose.yml  ← local dev entry point for the original stack
```

## Local Development

```bash
./scripts/up-original.sh --build    # first run — builds PHP+Apache image
./scripts/up-original.sh -d         # subsequent runs
docker compose -f src/original-src/docker-compose.yml down
docker compose -f src/original-src/docker-compose.yml logs -f web   # PHP/Apache logs
docker compose -f src/original-src/docker-compose.yml logs -f db    # MariaDB logs
```

- Portal: `http://localhost:8080/kimi_ET/`
- Marketing page: `http://localhost:8080/`
- MariaDB: `localhost:3306` — user `sql_kimi_et` / `password`, db `kimi_et`
- Local portal login: `admin` / `admin123` (created by `src/original-src/docker/mariadb/init/03-dev-seed.sql`)

There is no build step and no test suite — PHP files are served directly from `src/original-src/web/htdocs/`.

The DB init files live in `src/original-src/docker/mariadb/init/`: `02-schema.sql` contains the reverse-engineered draft schema and `03-dev-seed.sql` contains local-only login/smoke-test data. They must be in place before the first `./scripts/up-original.sh --build` or `docker compose -f src/original-src/docker-compose.yml up` for a fresh DB volume.

## Running Batch Scripts

Batch/cron scripts are standalone CLI PHP, never web-routed. Run them inside the container:

```bash
docker compose exec web php /var/www/html/kimi_ET/kimibatch/<script>.php
```
