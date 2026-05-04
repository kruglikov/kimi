

This file provides guidance for AI Agent when working with code in this repository.

# Project Overview

Migration and modernisation of the **KIMI Portal** — a legacy PHP 8.0 / MariaDB 10.5 B2B SaaS portal for debt-collection call-centre agents.

Full system architecture is documented in `@memory-bank/ARCHITECTURE.md`.

# AI Agent instruction
- Change nothing in the codebase without an approve\confirmation!
- We implement Memory Bank pattern to handle the project information management:
  - See @memory-bank/ folder which consists of @memory-bank/index.md file - please read it to be able to navigate memory bank.

## Repository Layout

```
AGENTS.md                    ← symlink to `CLAUDE.md`
CLAUDE.md                    ← this file

docs/                        ← Incoming client'd docunmentation saved here  
  01-initial-request/        ← original client brief and our response
  02-Kimi-portal-innowise-archive/  ← client-supplied archive (PPTX, PDF originals)
  03-translated docs/        ← German→English translated documentation

memory-bank/
  index.md                   ← entry point for project knowledge and navigation

tasks/
  01-analyse-incoming-data/  ← analysis prompts, folder map, preliminary plan,
                               assessment report (04-asessment-report-v01.md)

src/
  original-src/
    web/                     ← original PHP source (Apache document root: web/htdocs/)
    docker/                  ← Docker support files (Dockerfile, vhost, DB init SQL)
  upgraded-src/              ← target location for upgraded / modernised code

scripts/up-original.sh       ← helper script for starting the original stack
src/original-src/docker-compose.yml  ← local dev entry point for the original stack
```

