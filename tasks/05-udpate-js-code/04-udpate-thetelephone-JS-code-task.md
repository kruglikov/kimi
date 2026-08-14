See the description of the problem\task in this email: @docs/09-franz-email-2026-06-15/
The translated email text is stored here: @docs/09-franz-email-2026-06-15/email-en.md

Here is what Franz replied: @docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md#L30-65

I want you to investigate more about this topic that Franz raised:

> At the moment, database changes are being made directly in the production environment. We currently have no deployment process. Suggestions for improvement are very welcome. We also don’t use any development tools; we just edit the files manually. Here too, we’d appreciate any recommendations or suggestions on how to improve this.
 
Current aapproach: Franz manaully change files on the production.  
Better approach: 
- Use Git for code versioning and code propagation to the environments (will Franz be able to commit and see changes history?),
- Use some IDE like phpStorm (will Franz be able to use IDE..)
- Use Docker for server environment (will Franz be able to install it locally and will he need it for himself? )  
- Use AI Tool like Codex and Claude for minor fixes\adjustements.
  Please analyze and provide possible options\directioins 

# Analysis

## Current Situation

Franz is editing PHP files and SQL directly on the production server — no version history, no rollback, no local testing environment. This is high-risk for a live SaaS portal with paying clients.

## Proposed Options — Practical Assessment

### 1. Git for Version Control and Deployment

**What it gives:**
- Full history of every file change (who, what, when)
- Ability to roll back a broken change in seconds
- Structured deployment: push to `main` → deploy to test → deploy to production
- Collaboration: multiple people can work on the same codebase safely

**Will Franz be able to use it?**

The learning curve is real but manageable. The minimal workflow Franz needs is only ~5 commands:

```bash
git pull          # get latest
# ... edit files ...
git add .
git commit -m "Added telnr5-10 columns and ticket.php rows"
git push
```

A hosted Git platform (GitHub or GitLab) provides a web UI where Franz can see full change history without the command line.

**Deployment integration:** A simple approach — a `git pull` on the production server triggered by a webhook or run manually by Franz. This replaces "FTP/edit in production" with "commit locally → pull on server."

**Verdict:** Highly recommended. Even using only `git pull` on the server side already gives rollback capability.

---

### 2. IDE — PhpStorm

**What it gives:**
- Syntax highlighting, error detection before running the code
- Find all usages of a function across all files
- Refactoring tools (safe rename, extract method)
- Built-in Git integration (visual diff, commit, history)
- PHP-specific: auto-complete, type checking, Xdebug integration

**Will Franz be able to use it?**

PhpStorm has a steeper learning curve than a simple text editor, but the key benefit is **immediate**: syntax errors and undefined variables are highlighted before saving. For someone editing PHP files manually today, this alone prevents a class of production bugs.

A free alternative: **VS Code** with the PHP Intelephense extension — nearly the same PHP features, simpler UI, free.

**Verdict:** Recommended (VS Code as a low-friction entry point, PhpStorm for full power). Even a basic IDE removes "I introduced a syntax error into production" incidents entirely.

---

### 3. Docker for Local Environment

**What it gives:**
- Exact replica of the production server on Franz's laptop
- Test changes locally before touching production
- Database changes (ALTER TABLE) can be tested on a local DB dump first
- Developers on the team all use identical environments

**Will Franz be able to install it and will he need it personally?**

Docker Desktop on Windows/Mac is straightforward to install (installer wizard). The complexity is in writing the `docker-compose.yml` — but **that work has already been done** in this project (`src/original-src/docker-compose.yml`).

For Franz's specific issue — testing `ALTER TABLE oko ADD COLUMN telnr5...` before running it on production — Docker with a DB dump is the safest path. He loads the 2022 dump locally, runs the migration SQL, confirms it works, then runs it on production.

**Will Franz need it personally?** Only if he wants to test changes locally. If Innowise handles all future development, Franz may not need Docker himself. However, for SQL migrations it is strongly recommended he (or someone on his team) has a local environment.

**Verdict:** Highly recommended for SQL migrations. Moderate learning curve; the existing `src/original-src/docker-compose.yml` in the project reduces setup effort significantly.

---

### 4. AI Tools (Claude Code / Codex)

**What it gives:**
- Franz describes what he wants in plain language ("add 4 more phone number columns to the ticket view")
- AI generates the SQL, PHP, and HTML changes
- AI can explain existing code to Franz ("what does this function do?")
- Reduces dependency on external developers for minor adjustments

**Will Franz be able to use it?**

Claude Code (the CLI) requires some comfort with a terminal. The web-based Claude (claude.ai) requires no installation — Franz can paste a file, describe the change, and receive the modified file back. This is very accessible.

For the specific issue Franz described — the ONCLICK JS functions not working in `ticket.php` — this is exactly the kind of "I need a specific code snippet explained and fixed" task that Claude handles well.

**Verdict:** Highly recommended, especially via web interface. Zero installation, immediate productivity gain for isolated PHP/JS/SQL edits.

---

## Recommended Adoption Path (Graduated)

| Phase     | Action | Effort | Risk Reduction |
|-----------|--------|--------|---------------|
| **Now**   | Set up a GitHub/GitLab repo, push current production code | 1–2 days | Baseline history from today |
| **Now**   | Franz uses `git pull` on server to deploy instead of editing in place | 1 day | Rollback capability |
| **Now**   | Franz uses Claude (web) for PHP/JS/SQL questions | 0 days | Faster fixes, fewer errors |
| **Soon**  | Franz installs VS Code + PHP Intelephense | 2 hours | Syntax errors caught before deploy |
| **Later** | Docker local environment for testing DB migrations | 1–2 days | Zero production DB surprises |
| **Later** | CI/CD: auto-deploy `main` branch to test server on push | 2–3 days | Full test-before-production gate |

---

## Specific Note on Franz's Current Problem

The immediate issue Franz raised — **ONCLICK functions in `ticket.php` not working** — is a JavaScript/PHP integration question, not a tooling question. This should be investigated as a separate task.

The deployment concern (not losing changes during migration) is solved by:
1. **Git:** migrate from a branch that includes Franz's changes
2. The existing `src/upgraded-src/` already contains the PHP 8.5 upgraded code — Franz's `ticket.php` and `okoimp.php` edits need to be applied on top of the upgraded code before migration

---

## Summary

The most impactful, lowest-friction improvements for Franz are:
1. **Git + GitHub** (immediate rollback + change history)
2. **Claude web interface** (immediate help with PHP/JS/SQL questions, no install)
3. **VS Code** (syntax errors caught before deploy)
4. **Docker** (for DB migration testing — critical given the `ALTER TABLE` risk)

These four together transform Franz from "editing production files blind" to a safe, auditable development workflow — without requiring deep technical expertise.

---

# Database Migrations

## Current State in the Codebase

The `oko` table is defined in two places (one per stack):

- `src/original-src/docker/mariadb/init/06-batch-stubs.sql:138` — PHP 8.0 stack
- `src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql:156` — PHP 8.5 stack

Both currently declare four phone number columns:

```sql
telnr1    TEXT,
telnr2    TEXT,
telnr3    TEXT,
telnr4    TEXT,
```

Franz needs `telnr5`–`telnr10` added.

---

## The Migration Required

### Step 1 — Production database (one-time, run on the live server)

```sql
ALTER TABLE oko
  ADD COLUMN telnr5  VARCHAR(45) NULL,
  ADD COLUMN telnr6  VARCHAR(45) NULL,
  ADD COLUMN telnr7  VARCHAR(45) NULL,
  ADD COLUMN telnr8  VARCHAR(45) NULL,
  ADD COLUMN telnr9  VARCHAR(45) NULL,
  ADD COLUMN telnr10 VARCHAR(45) NULL;
```

This is safe to run on a live MariaDB: `ADD COLUMN` with no default value and `NULL` allowed is a metadata-only operation in InnoDB — it does not lock the table or touch existing rows.

### Step 2 — Update both schema init files (keeps Docker environment in sync)

In `src/original-src/docker/mariadb/init/06-batch-stubs.sql` and  
`src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql`, after `telnr4`:

**Before:**
```sql
    telnr4               TEXT,
    iban                 VARCHAR(50),
```

**After:**
```sql
    telnr4               TEXT,
    telnr5               VARCHAR(45),
    telnr6               VARCHAR(45),
    telnr7               VARCHAR(45),
    telnr8               VARCHAR(45),
    telnr9               VARCHAR(45),
    telnr10              VARCHAR(45),
    iban                 VARCHAR(50),
```

---

## Recommended Migration Workflow (Safe, Repeatable)

The core problem with Franz's current approach is there is no record of what SQL was run on production and when. The standard fix is a **migrations folder** — versioned SQL files that are applied in order and never edited after the fact.

### Proposed folder structure

```
db/
  migrations/
    001_initial_schema.sql        ← current full schema (baseline)
    002_oko_add_telnr5_10.sql     ← the new migration
  README.md                       ← how to apply migrations
```

### `db/migrations/002_oko_add_telnr5_10.sql`

```sql
-- Migration 002: add telnr5–telnr10 to oko table
-- Author: Franz / Date: 2026-06-16
-- Safe to run on live MariaDB (InnoDB metadata-only ADD COLUMN)

ALTER TABLE oko
  ADD COLUMN IF NOT EXISTS telnr5  VARCHAR(45) NULL,
  ADD COLUMN IF NOT EXISTS telnr6  VARCHAR(45) NULL,
  ADD COLUMN IF NOT EXISTS telnr7  VARCHAR(45) NULL,
  ADD COLUMN IF NOT EXISTS telnr8  VARCHAR(45) NULL,
  ADD COLUMN IF NOT EXISTS telnr9  VARCHAR(45) NULL,
  ADD COLUMN IF NOT EXISTS telnr10 VARCHAR(45) NULL;
```

`ADD COLUMN IF NOT EXISTS` (MariaDB 10.0+) makes the script **idempotent** — running it twice is safe, it simply skips columns that already exist.

### How Franz applies it

1. Test locally first (Docker):
   ```bash
   docker exec -i kimi_mariadb mysql -u root -proot kimi_et < db/migrations/002_oko_add_telnr5_10.sql
   ```
2. Verify the result:
   ```bash
   docker exec -i kimi_mariadb mysql -u root -proot kimi_et -e "DESCRIBE oko;"
   ```
3. When confirmed — run the same command against the production DB, or paste the SQL into phpMyAdmin if that is available on the server.
4. Commit `db/migrations/002_oko_add_telnr5_10.sql` to Git — this becomes the permanent audit trail of what was run and when.

---

## Why Not Use a Migration Framework (Phinx, Doctrine Migrations)?

Tools like **Phinx** or **Doctrine Migrations** automate the tracking of which migrations have been applied and in what order. They are the right choice for teams running multiple deployments per week.

For KIMI Portal the trade-off is:

| Factor | Numbered SQL files | Phinx / Doctrine |
|--------|--------------------|------------------|
| Franz can understand and edit | Yes | Requires PHP knowledge |
| Zero extra dependencies | Yes | Composer + config file |
| Suitable for current change rate (rare schema changes) | Yes | Overkill |
| Automated "was this already applied?" tracking | Manual (filename convention) | Built-in |
| Rollback support | Manual (`DOWN` SQL file) | Built-in |

**Recommendation:** Start with numbered SQL files in `db/migrations/`. If the change rate grows, migrate to Phinx — it can import the existing numbered files as its baseline.

---

## Files That Need to Change for This Specific Migration

| File | Change |
|------|--------|
| `src/original-src/docker/mariadb/init/06-batch-stubs.sql:155` | Add `telnr5`–`telnr10` after `telnr4` |
| `src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql:173` | Same |
| `db/migrations/002_oko_add_telnr5_10.sql` | **New file** — the production migration script |
| Production MariaDB | Run `002_oko_add_telnr5_10.sql` once |
