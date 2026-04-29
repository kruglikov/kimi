# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Migration and modernisation of the **KIMI Portal** — a legacy PHP 8.0 / MariaDB 10.5 B2B SaaS portal for debt-collection call-centre agents.

Full system architecture is documented in `ARCHITECTURE.md`.

## Repository Layout

```
ARCHITECTURE.md              ← full system architecture (read this first)
CLAUDE.md                    ← this file

docs/
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

docker-compose.yml           ← local dev entry point
```
k
## Local Development

```bash
docker compose up --build    # first run — builds PHP+Apache image
docker compose up -d         # subsequent runs
docker compose down
docker compose logs -f web   # PHP/Apache logs
docker compose logs -f db    # MariaDB logs
```

- Portal: `http://localhost:8080/kimi_ET/`
- Marketing page: `http://localhost:8080/`
- MariaDB: `localhost:3306` — user `sql_kimi_et` / `password`, db `kimi_et`

There is no build step and no test suite — PHP files are served directly from `src/original-src/web/htdocs/`.

The DB schema + seed data must be placed at `src/original-src/docker/mariadb/init/02-schema.sql` before the first `docker compose up`.

## Running Batch Scripts

Batch/cron scripts are standalone CLI PHP, never web-routed. Run them inside the container:

```bash
docker compose exec web php /var/www/html/kimi_ET/kimibatch/<script>.php
```