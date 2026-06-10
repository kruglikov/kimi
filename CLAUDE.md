

This file provides guidance for AI Agent when working with code in this repository.

# Project Overview

Migration and modernisation of the **KIMI Portal** — a legacy PHP 8.0 / MariaDB 10.5 B2B SaaS portal for debt-collection call-centre agents.

## Business Context

**KIMI Plus GmbH** (kimi-plus.at) is an Austrian consulting company that acts as a professional intermediary in payment management — helping businesses communicate with customers about late payments and debt collection, while preserving customer relationships.

**The KIMI Portal** (`kimiportal.at`) is a multi-tenant, browser-based B2B SaaS portal used by call-center agents to manage debt collection campaigns. Call-center agents log in, select a client (Mandant), and work through tickets (Akt/Ticket) — each representing a customer case within a campaign. Agents can view case data, record interactions, make outbound phone calls, and process payments/bookings.


# AI Agent instruction
- Change nothing in the codebase without an approve\confirmation!
- We implement Memory Bank pattern to handle the project information management:
  - See @memory-bank/ folder which consists of @memory-bank/index.md file - please read it to be able to navigate memory bank.
- when you finish some task or investigation and present the results be descriptive. I.e.: 
  - Please in your final answer provide steps that you have taken to find out the final answer\solution and justify all changes in code
  - clear explanation of underlying entities that are included into the final explanation
- When you mention any file or method, please provide **full path** to the file or method!!!

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
  01-analyse-incoming-data/  ← [DONE] PHP 8.0→8.5 upgrade analysis and execution;
                               security (S1–S6) and GDPR review (GDPR1–8).
                               Task results\deliverables: @docs/04-results/Audit-report.md,
                               @docs/htdocs-folder-updated-to-php85.zip,
                               @docs/upgraded-code-with-safety-net-test-updated-to-php85(optional-archive).zip

src/
  original-src/
    web/                     ← original PHP source (Apache document root: web/htdocs/)
    docker/                  ← Docker support files (Dockerfile, vhost, DB init SQL)
  upgraded-src/              ← target location for upgraded / modernised code

scripts/up-original.sh       ← helper script for starting the original stack
src/original-src/docker-compose.yml  ← local dev entry point for the original stack
```

