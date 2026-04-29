# Handoff: Schema Completion + ARCHITECTURE.md Update

## Context

This document picks up a task that was partially completed. Goal: finish three sub-tasks triggered by the user after the initial `docker/mariadb/init/02-schema.sql` was generated.

---

## Sub-task 1: Fix schema file location (BLOCKING)

**Problem discovered:** `docker-compose.yml` mounts init SQL from:
```
./src/original-src/docker/mariadb/init:/docker-entrypoint-initdb.d
```

The schema file was written to `docker/mariadb/init/02-schema.sql` (project root `docker/`), but it **must** be at:
```
src/original-src/docker/mariadb/init/02-schema.sql
```

**Action required:** Move (or copy) the file:
```bash
mkdir -p src/original-src/docker/mariadb/init
mv docker/mariadb/init/02-schema.sql src/original-src/docker/mariadb/init/02-schema.sql
rmdir -p docker/mariadb/init docker/mariadb docker 2>/dev/null || true
```

`01-init.sql` already exists at `src/original-src/docker/mariadb/init/01-init.sql` — do not touch it.

---

## Sub-task 2: Update ARCHITECTURE.md

### Corrections required (errors found during schema reverse-engineering)

The ARCHITECTURE.md currently contains wrong table names for RBAC. The following changes are needed:

**In "Permissions (RBAC)" section — before:**
```
- `benutzer` — users
- `role` — roles
- `permission` — maps (role_id, site_filename, permission_type) → access granted
```

**After:**
```
- `benutzer` — users
- `rolle` — roles  (entity class: Role; file: role.php)
- `berechtigung` — permission entries  (entity class: Permission; file: permission.php)
- `rolle_berechtigung` — junction: maps (rolle_id, berechtigung_id)
```

**In the Entity Classes table — correct two rows:**

| Was | Fix |
|-----|-----|
| `Role` → table `role` | `Role` → table `rolle` |
| `Permission` → table `permission` | `Permission` → table `berechtigung` |

**In Multi-Tenancy section — add `rolle_id` note:**
The `mandant_benutzer` junction table has three columns: `mandant_id`, `benutzer_id`, **and `rolle_id`** (the user's role within that mandant). This is not documented.

### Additions required (new facts discovered)

1. **`kimi_archiv` local dev**: `01-init.sql` already creates an empty `kimi_archiv` database and grants the `kimi` user access to both databases. No schema exists for `kimi_archiv` — the DB is created empty and does not need a schema for basic portal functionality. Batch scripts that archive data will fail if they write to `kimi_archiv`, but the web portal itself does not appear to query it directly.

2. **Schema file created**: Add a note in the Local Development section that `02-schema.sql` is a reverse-engineered draft (see status/caveats in the file header).

---

## Sub-task 3: Risk analysis of schema gaps + additional investigation

### Investigation findings so far (partial)

Before the session was interrupted, the following was found:

**`grund`, `produkt`, `mwst` tables:**
- No `JOIN` or `FROM` queries against these tables were found anywhere in entity files or GUI modules.
- They are only stored as FK integer IDs in `ticket` (`grund_id`, `produkt_id`) and `buchungen` (`mwst_id`).
- This means they are likely admin-managed lookup tables that get loaded via SELECT * in dropdowns.
- **Risk:** LOW for basic ticket display. When a ticket detail page loads a `<select>` dropdown for Grund or Produkt, the query `SELECT * FROM grund` (or similar) will fail if the table doesn't exist.
- **Investigation needed:** grep all campaign template PHP files for `grund` and `produkt` to confirm the SELECT queries:
  ```bash
  grep -rh "FROM grund\|FROM produkt\|FROM mwst" \
    src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/ \
    src/original-src/web/htdocs/kimi_ET/modules/gui/ \
    src/original-src/web/htdocs/kimi_ET/libs/
  ```

**`subkonto_neu` columns:**
- Entity file `subkonto.php` contains `INSERT INTO subkonto_neu` — full column list not yet extracted.
- **Action:** Run:
  ```bash
  grep -A 80 "INSERT INTO \`subkonto_neu\`" \
    src/original-src/web/htdocs/kimi_ET/libs/entities/subkonto.php | head -90
  ```
  Then compare with `subkonto` columns in `02-schema.sql` and update `subkonto_neu` table definition.

**`bua_bgr_man` full columns:**
- Only `id`, `mandant_id`, `bugru_id` confirmed so far.
- Alias-based grep only returned `bbm.id`.
- **Action:** Read the `buchungen.php` and `subkonto.php` entity files for SELECT queries that reference `bbm.*` fields:
  ```bash
  grep -h "bbm\.\|bgr\." \
    src/original-src/web/htdocs/kimi_ET/libs/entities/buchungen.php \
    src/original-src/web/htdocs/kimi_ET/libs/entities/subkonto.php \
    | grep -v "JOIN\|ON\b\|WHERE" | head -30
  ```

**Tables in GUI modules not in entity files:**
- Not yet checked. Run:
  ```bash
  grep -roh "FROM [a-z_]\+" \
    src/original-src/web/htdocs/kimi_ET/modules/gui/*.php \
    | sed 's/FROM //' | sort -u
  ```

### Full risk table for all uncertainties

| Uncertainty | Risk level | What breaks | How to verify |
|---|---|---|---|
| VARCHAR lengths (50/100/255 all guessed) | Medium | Truncation on INSERT if real data exceeds length | Import a real data row; check MySQL truncation warnings |
| NULL/NOT NULL on many columns | Medium | INSERTs may fail if production has NOT NULL without DEFAULT | Run the app; watch PHP error log for SQL errors |
| `grund` table — stub only (id, text) | Medium | Ticket detail dropdown for Grund field will fail on load | Grep GUI templates for FROM grund; run app and open ticket |
| `produkt` table — stub only (id, text) | Medium | Same as above for Produkt field | Same approach |
| `mwst` table — not created at all | Low-Medium | Buchungen financial reporting; VAT display | Grep for FROM mwst; check if buchungen.php queries it |
| `bua_bgr_man` missing columns | Medium | Buchungsart/Buchungsgrund management pages will fail | Read buchungen.php SELECT queries |
| `subkonto_neu` columns incomplete | High | Stammdaten/Subkonto financial view will fail | Extract from subkonto.php INSERT |
| `subkonto_s` / `subkonto_1` created as LIKE subkonto | Medium | May have different columns than subkonto in production | Check batch scripts for INSERT INTO subkonto_s/subkonto_1 |
| `kimi_encrypt`/`kimi_decrypt` are stubs | Low (local dev only) | Encrypted data is stored/retrieved as plain text; fine for dev | Verify stub functions load without error; test login with encryption_aktiv = 'N' mandant |
| `kimi_archiv` schema missing | Low | Batch archive scripts fail; web portal unaffected | Check config.php for CONF_MYSQL_DB_ARCHIV usage in PHP |
| `dummy_number` typed as DECIMAL | Low | If any campaign stores text in a dummy_number field | Check campaign templates for dummy_number usage |
| `ticket_historie` dummy columns (10 vs 20) | Medium | History INSERT will fail if more than 10 dummy_text exist | Extract ticket_historie INSERT from ticket_historie.php |

### Additional investigation steps recommended (in priority order)

1. **Extract `subkonto_neu` INSERT columns** (HIGH — likely to break stammdaten view):
   ```bash
   grep -A 80 "INSERT INTO \`subkonto_neu\`" \
     src/original-src/web/htdocs/kimi_ET/libs/entities/subkonto.php
   ```

2. **Extract `ticket_historie` INSERT columns** (HIGH — ticket save will fail):
   ```bash
   grep -A 150 "INSERT INTO \`ticket_historie\`" \
     src/original-src/web/htdocs/kimi_ET/libs/entities/ticket_historie.php
   ```

3. **Find `grund`, `produkt`, `mwst` SELECT queries** (MEDIUM — ticket detail page):
   ```bash
   grep -rh "FROM grund\|FROM produkt\|FROM mwst" \
     src/original-src/web/htdocs/kimi_ET/
   ```

4. **Find all tables used in GUI modules** (MEDIUM — may reveal unscaffolded tables):
   ```bash
   grep -roh "FROM \`\?[a-z_][a-z_]*\`\?" \
     src/original-src/web/htdocs/kimi_ET/modules/gui/*.php \
     | sed 's/:FROM //;s/`//g' | sort -u
   ```

5. **Check `bua_bgr_man` SELECT columns** (MEDIUM — buchungsart/buchungsgrund management):
   ```bash
   grep -A 5 "FROM bua_bgr_man\|SELECT.*bua_bgr_man" \
     src/original-src/web/htdocs/kimi_ET/libs/entities/buchungen.php \
     src/original-src/web/htdocs/kimi_ET/libs/entities/subkonto.php
   ```

6. **Check `subkonto_s` and `subkonto_1` INSERT statements** in batch scripts:
   ```bash
   grep -rh "INSERT INTO.*subkonto_s\|INSERT INTO.*subkonto_1" \
     src/original-src/web/htdocs/kimi_ET/kimibatch/
   ```

---

## Completion checklist

- [ ] Move `02-schema.sql` to `src/original-src/docker/mariadb/init/02-schema.sql`
- [ ] Update `subkonto_neu` table definition after extracting INSERT columns
- [ ] Update `ticket_historie` dummy column count after extracting INSERT columns
- [ ] Add `grund`, `produkt`, `mwst` tables with correct structure (or confirm stubs are sufficient)
- [ ] Update `bua_bgr_man` with full column list
- [ ] Update ARCHITECTURE.md (RBAC section, entity table, mandant_benutzer note, kimi_archiv note)
- [ ] Run `docker compose up --build` and verify container starts without SQL errors
- [ ] Open `http://localhost:8080/kimi_ET/` and verify login page loads (PHP/Apache stack working)
- [ ] Write completion summary per project convention
