# KIMI Portal — System Architecture

## Purpose of This Document

This document describes the complete architecture of the KIMI Portal system as it exists in `src/original-src/web/`. It is intended both as human-readable documentation and as an AI-agent context file for migration, analysis, and refactoring tasks.

---

## Business Context

**KIMI Plus GmbH** (kimi-plus.at) is an Austrian consulting company that acts as a professional intermediary in payment management — helping businesses communicate with customers about late payments and debt collection, while preserving customer relationships.

**The KIMI Portal** (`kimiportal.at`) is a multi-tenant, browser-based B2B SaaS portal used by call-center agents to manage debt collection campaigns. Call-center agents log in, select a client (Mandant), and work through tickets (Akt/Ticket) — each representing a customer case within a campaign. Agents can view case data, record interactions, make outbound phone calls, and process payments/bookings.

---

## Technology Stack

| Component    | Version / Detail                                           |
|--------------|------------------------------------------------------------|
| Language     | PHP 8.0.30                                                 |
| Web server   | Apache (config not in archive; document root: `src/original-src/web/htdocs/`) |
| Database     | MariaDB 10.5.21 (`kimi_et` schema)                         |
| Archive DB   | MariaDB, separate `kimi_archiv` schema (same server)       |
| Frontend     | jQuery 1.x + jQuery UI 1.10.3 (no modern SPA framework)    |
| Mailer       | PHPMailer v2.0.4 (legacy) at `src/original-src/web/htdocs/kimi_ET/libs/addons/phpmail/`; Composer PHPMailer 6.x also present at `src/original-src/web/htdocs/vendor/` |
| Telephony    | Telematica VoIP REST API + Elsbeth dialing system (file-based) |
| Deployment   | Docker Compose for local dev (see `docker-compose.yml`); originally direct file deployment on production |
| Composer     | Present at `src/original-src/web/htdocs/vendor/` (main app, PHPMailer 6.x) and `src/original-src/web/htdocs/kimi_ET/kimibatch/files/vendor/` (batch, separate context) |

---

## Local Development (Docker)

```
docker compose up --build   # first run
docker compose up -d        # subsequent runs
```

| URL | What |
|-----|------|
| `http://localhost:8080/kimi_ET/` | Portal application |
| `http://localhost:8080/` | Marketing landing page |
| `localhost:3306` | MariaDB (for DBeaver / Adminer) |

**File layout:**

```
docker-compose.yml                              ← Compose entry point (project root)
src/original-src/
├── web/                                        ← PHP source (mounted as /var/www/html)
└── docker/
    ├── php/
    │   ├── Dockerfile                          ← php:8.0-apache + mysqli + mod_rewrite
    │   └── vhost.conf                          ← Apache virtual host
    └── mariadb/
        └── init/
            ├── 01-init.sql                     ← creates kimi_archiv DB + kimi user
            └── 02-schema.sql                   ← reverse-engineered draft schema + seed data
```

`02-schema.sql` is a reverse-engineered draft. Column names are based on the PHP codebase, but data types, lengths, nullability, and defaults still need verification against a production dump; see the file header for current status and caveats.

**Credentials (local only):**

| What | Value |
|------|-------|
| MariaDB root password | `password` |
| `sql_kimi_et` password | `password` |
| `kimi` (archive) password | `password` |

The DB host in `src/original-src/web/htdocs/kimi_ET/config/config.php` is set to `db` (the Compose service name) rather than `localhost`.

---

## High-Level Architecture

```
Browser
  │
  ├── src/original-src/web/htdocs/index.php            (public marketing landing page)
  │
  └── src/original-src/web/htdocs/kimi_ET/             (the portal application)
        ├── login.php                              (login UI)
        ├── index.php                              (single entry point — routing hub)
        ├── ajax/*.php                             (AJAX endpoints: auth, telephony, file write)
        │
        ├── libs/                                  (core framework: DB, App singleton, 44 entity classes)
        ├── config/                                (DB credentials, feature flags, constants)
        ├── modules/gui/                           (page content controllers — active)
        ├── modules/menu/                          (per-page nav menu definitions)
        ├── modules/initial/                       (⚠ legacy pre-hooks, no longer active)
        ├── modules/gui/templates/tickets/{id}/    (per-campaign UI templates)
        │
        └── kimibatch/                             (batch processing scripts — run standalone, not via web)

src/original-src/web/exchange/{campaign_id}/IN|OUT/   (file exchange with Elsbeth dialing system)
```

---

## Routing

The application has **one entry point**: `src/original-src/web/htdocs/kimi_ET/index.php`.

All pages are accessed via:
```
index.php?site=<module_name>
```

Routing logic in `src/original-src/web/htdocs/kimi_ET/index.php`:
1. Bootstrap: `src/original-src/web/htdocs/kimi_ET/libs/init.php` (config → session → language → DB → App singleton)
2. If unauthenticated → redirect to `src/original-src/web/htdocs/kimi_ET/login.php`
3. If no mandant selected → redirect to `src/original-src/web/htdocs/kimi_ET/login.php`
4. Permission check: `App::has_permission($module, "*")`
5. Pre-hook (legacy): `src/original-src/web/htdocs/kimi_ET/modules/initial/{site}.php` if it exists
6. Content: `src/original-src/web/htdocs/kimi_ET/modules/gui/{site}.php`
7. Nav menu: `src/original-src/web/htdocs/kimi_ET/modules/menu/{site}.php`

AJAX requests are routed via:
```
index.php?ajax=true&site=<module_name>
```
→ loads `src/original-src/web/htdocs/kimi_ET/ajax/{module_name}.php` and exits immediately.

---

## Authentication & Session

### Login Flow
1. `src/original-src/web/htdocs/kimi_ET/login.php` renders the login form (jQuery UI, German UI language).
2. User submits credentials via AJAX POST to `index.php?ajax=true&site=check-login`.
3. `src/original-src/web/htdocs/kimi_ET/ajax/check-login.php` calls `User::login($username, $password)`.
4. On success: `$_SESSION["user"]` is set; mandant list is returned as JSON.
5. User selects a mandant (client) from a dropdown on the same login page.
6. Mandant selection POSTs to `index.php?mandant={id}` → `$_SESSION["mandant"]` is set.

### Password Hashing
Passwords are stored/compared as:
```php
hash("sha256", "kimiplus" . $password)  // truncated to 64 chars
```
Static salt "kimiplus" — no per-user salt, no bcrypt/argon2.

### Session Security Issues
- Session name: `kimi_ET-P` (set in `src/original-src/web/htdocs/kimi_ET/libs/init.php`) / `kimiET-P` (set in `src/original-src/web/htdocs/kimi_ET/login.php` and `src/original-src/web/htdocs/kimi_ET/index.php`) — **inconsistency between files** (hyphen vs no hyphen).
- `session_start()` has no `cookie_secure`, `cookie_httponly`, or `cookie_samesite` options.
- No CSRF protection.

### Auto-Login
`src/original-src/web/htdocs/kimi_ET/index.php` supports a URL-based auto-login (`?autologin=true&loginuser=X&mandant=Y&kId=Z`) — bypasses password authentication. This is a significant security risk if the application is accessible from outside the intranet.

---

## Multi-Tenancy (Mandant)

The system is multi-tenant. A **Mandant** (client/tenant) is a company that uses KIMI Plus services.

- Table: `mandant`
- Users are linked to mandants via: `mandant_benutzer` (junction table)
- `mandant_benutzer` stores `mandant_id`, `benutzer_id`, and `rolle_id` (the user's role within that mandant)
- One user can belong to multiple mandants (selects at login)
- The active `$_SESSION["mandant"]` controls all data scoping throughout a session
- Per-mandant features: optional field-level encryption (`encryption_aktiv`, `encryption_columns_ticket`)

---

## Permissions (RBAC)

Role-based access control is implemented via these tables:
- `benutzer` — users
- `rolle` — roles (entity class: `Role`; file: `role.php`)
- `berechtigung` — permission entries (entity class: `Permission`; file: `permission.php`)
- `rolle_berechtigung` — junction: maps (`rolle_id`, `berechtigung_id`)

Permission check:
```php
App::$CURRENT->has_permission($site, "*")
// → Role::get_role($user, $mandant)
// → Permission::get_permissions($role_id, "$site.php", $permission)
```

The flag `CONF_USER_PERMISSION = true` in `src/original-src/web/htdocs/kimi_ET/config/config.php` enables permission enforcement. If set to `false`, all users can access all pages.

---

## Core Framework (`src/original-src/web/htdocs/kimi_ET/libs/`)

### `src/original-src/web/htdocs/kimi_ET/libs/init.php`
Bootstrap file included by every page. In order:
1. Loads `src/original-src/web/htdocs/kimi_ET/config/config.php` (defines all `CONF_*` constants)
2. Sets session name and starts session
3. Loads the active language file (`src/original-src/web/htdocs/kimi_ET/config/lang/de.php` by default)
4. Loads `src/original-src/web/htdocs/kimi_ET/libs/database.php` and `src/original-src/web/htdocs/kimi_ET/libs/application.php`

### `src/original-src/web/htdocs/kimi_ET/libs/database.php` — `DB` class
Thin wrapper around PHP `mysqli_*` procedural functions. Key characteristics:
- **Opens and closes a new MySQL connection on every query** (`mysqli_connect()` / `mysqli_close()` per call) — no persistent connection pooling.
- Two query modes: `query()` (returns array of objects) and `manualOpen()`/`manualClose()` (manual transaction control).
- `DBConnection` helper class wraps a manual transaction lifecycle.
- **No prepared statements** — all queries use string concatenation.
- `escape_string()` is available but inconsistently used.
- **Known PHP 8.2+ breaking issue**: `mysqli_error()` called without connection argument in `query_insert_return_id()` and `query()`.

### `src/original-src/web/htdocs/kimi_ET/libs/application.php` — `App` class
Global singleton (`App::$CURRENT`). Set up at the end of `src/original-src/web/htdocs/kimi_ET/libs/application.php`.
- `$APP->DB` — reference to the `DB` instance
- `$APP->USER` — the authenticated `User` object (from session)
- `$APP->MANDANT` — the active `Mandant` object (from session)
- `$APP->ERRORS` / `$APP->INFORMATION` — flash messages rendered in the layout
- `has_permission($site, $type)` — RBAC check
- `isEncryptionEnabled()` — checks per-mandant encryption flag
- `getTicketDecryptionColumn()` / `getTicketEncryptionValue()` — SQL fragment builders for transparent field encryption

Also loads all 44 entity classes via `require_once` at the top of the file.

### `src/original-src/web/htdocs/kimi_ET/libs/entities/` — Entity Classes
44 PHP classes, one per database table. Each class:
- Wraps a single DB row as a plain PHP object
- Provides getter methods
- Has static factory methods (`get()`, `get_all()`, etc.) that build and run raw SQL queries
- No ORM, no query builder — raw SQL strings

Key entities:

| Class | File | Table | Purpose |
|---|---|---|---|
| `User` | `src/original-src/web/htdocs/kimi_ET/libs/entities/user.php` | `benutzer` | Portal user (call-center agent) |
| `Mandant` | `src/original-src/web/htdocs/kimi_ET/libs/entities/mandant.php` | `mandant` | Client/tenant company |
| `Kampagne` | `src/original-src/web/htdocs/kimi_ET/libs/entities/kampagne.php` | `kampagne` | A debt collection campaign |
| `Ticket` | `src/original-src/web/htdocs/kimi_ET/libs/entities/ticket.php` | `ticket` | Main work item (a customer case) |
| `Ticket_Historie` | `src/original-src/web/htdocs/kimi_ET/libs/entities/ticket_historie.php` | `ticket_historie` | Ticket change history |
| `Stammdaten` | `src/original-src/web/htdocs/kimi_ET/libs/entities/stammdaten.php` | `stammdaten` | Customer master data (name, address, PII) |
| `Subkonto` | `src/original-src/web/htdocs/kimi_ET/libs/entities/subkonto.php` | `subkonto` | Customer sub-account (financial) |
| `Buchungen` | `src/original-src/web/htdocs/kimi_ET/libs/entities/buchungen.php` | `buchungen` | Financial bookings/transactions |
| `InkassoInformation` | `src/original-src/web/htdocs/kimi_ET/libs/entities/inkassoinformation.php` | `inkassoinformation` | Debt collection details |
| `Akt` | `src/original-src/web/htdocs/kimi_ET/libs/entities/akt.php` | `akt` | Legal case/act document |
| `Log` | `src/original-src/web/htdocs/kimi_ET/libs/entities/log.php` | `log` | Interaction / activity log |
| `Role` | `src/original-src/web/htdocs/kimi_ET/libs/entities/role.php` | `rolle` | RBAC role |
| `Permission` | `src/original-src/web/htdocs/kimi_ET/libs/entities/permission.php` | `berechtigung` | RBAC permission entry |
| `Benutzer` | `src/original-src/web/htdocs/kimi_ET/libs/entities/benutzer.php` | `benutzer` | Agent user profile (overlaps with `User`) |
| `Anrufzeiten` | `src/original-src/web/htdocs/kimi_ET/libs/entities/anrufzeiten.php` | `anrufzeiten` | Call time slots |
| `Kundenhistorie` | `src/original-src/web/htdocs/kimi_ET/libs/entities/kundenhistorie.php` | `kundenhistorie` | Customer history |

### `src/original-src/web/htdocs/kimi_ET/libs/addons/phpmail/`
Legacy PHPMailer **v2.0.4** (circa 2010). Entry point: `src/original-src/web/htdocs/kimi_ET/libs/addons/phpmail/class.phpmailer.php`. Incompatible with PHP 8.x. Used by the main app for sending emails from GUI actions (e.g. ticket notifications).

---

## Module System (`src/original-src/web/htdocs/kimi_ET/modules/`)

### `src/original-src/web/htdocs/kimi_ET/modules/gui/` — Active Page Controllers
Each `.php` file renders the HTML content for one page. The file is `include`-d inside the main layout in `src/original-src/web/htdocs/kimi_ET/index.php`. Common modules:

| File | Purpose |
|---|---|
| `src/original-src/web/htdocs/kimi_ET/modules/gui/portal.php` | Dashboard / campaign selection view |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/kampauswahl.php` | Campaign selection |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php` | Ticket detail view (loads campaign-specific template) |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket2.php` | Alternate ticket view |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket_sich.php` | Ticket security/validation view |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/ticketsuch.php` | Ticket search |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/ticketsuch2.php` | Alternate ticket search |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/akt.php` | Legal case/act view |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/menu_verw.php` | Menu management |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/logout.php` | Session destroy + redirect |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/np.php` | "No permission" page |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/404.php` | Not found page |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/pwgen.php` | Password generator utility |

### `src/original-src/web/htdocs/kimi_ET/modules/menu/` — Nav Menu Definitions
Each file corresponds to a GUI module. When `src/original-src/web/htdocs/kimi_ET/index.php` renders a page, it includes the matching `src/original-src/web/htdocs/kimi_ET/modules/menu/{site}.php` to build the contextual navigation breadcrumb.

### `src/original-src/web/htdocs/kimi_ET/modules/initial/` — Legacy Pre-Hooks (⚠ No Longer Active)
Per slide 21 of the system documentation, these scripts are **no longer active**. They are an older copy of most `src/original-src/web/htdocs/kimi_ET/modules/menu/` pages from a prior architecture iteration. Still present in the codebase but not in the routing flow. 29 files — effectively dead code.

### `src/original-src/web/htdocs/kimi_ET/modules/gui/old_delete/` — Superseded Files
18 PHP files from an even older GUI iteration. Kept for reference, not included in any routing.

---

## Campaign Ticket Templates (`src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/{campaign_id}/`)

Each campaign has a custom ticket UI. The template folder per campaign contains:

| File | Purpose |
|---|---|
| `ticket.php` | Custom ticket detail form (fields vary per campaign) |
| `ticketsuch.php` | Custom search results layout |
| `ticketuebersicht.php` | Custom ticket overview/list |
| `ticketoptimize.js` | Client-side field interaction logic |
| `ticketvalidate.js` | Client-side form validation |
| `knpdoku.pdf` (optional) | Campaign documentation |

**Active campaign template folders:**
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/1/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/2/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/3/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/8/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/10/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/16/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/19/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/34/`
- `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/35/`

---

## AJAX Endpoints (`src/original-src/web/htdocs/kimi_ET/ajax/`)

| File | Purpose |
|---|---|
| `src/original-src/web/htdocs/kimi_ET/ajax/check-login.php` | Authenticates user; stores in session; returns mandant list as JSON |
| `src/original-src/web/htdocs/kimi_ET/ajax/callInntelco.php` | Initiates outbound call via **Telematica VoIP REST API** |
| `src/original-src/web/htdocs/kimi_ET/ajax/add_log.php` | Writes a log entry for a ticket interaction |
| `src/original-src/web/htdocs/kimi_ET/ajax/write_file.php` | Writes iCalendar (`.ics`) event files to `src/original-src/web/htdocs/kimi_ET/ical/` |

---

## Telephony Integration

The portal integrates with **Telematica** (Austrian VoIP provider) for outbound call management.

**Telematica REST API** (`src/original-src/web/htdocs/kimi_ET/ajax/callInntelco.php`):
- Called when an agent clicks "Call" on a ticket
- Parameters: `agent_reference` (extension), `source_number` (caller ID from campaign), `target_number` (customer phone)
- Makes a server-side `file_get_contents(TELEMATICA_URL)` request to initiate the call
- Returns JSON with `retcode`, `status`, `msg`
- Logs to `src/original-src/web/htdocs/kimi_ET/ajax/log/callTelematica.log`

Additional telephony endpoints:
- `src/original-src/web/htdocs/kimi_ET/xhangup.php` — hang-up current call
- `src/original-src/web/htdocs/kimi_ET/setticketcallinfo.php` — records call result/notes back to ticket
- `src/original-src/web/htdocs/kimi_ET/validphone.php` — phone number format validation
- `src/original-src/web/htdocs/kimi_ET/getticketurl.php` — returns ticket URL (used by CTI integrations)

**Elsbeth Dialing System** (batch/file-based):
- Elsbeth is a separate predictive dialing system used for outbound campaigns
- Data exchange happens via CSV files in `src/original-src/web/exchange/{campaign_id}/IN/` (import to Elsbeth) and `src/original-src/web/exchange/{campaign_id}/OUT/` (results from Elsbeth)
- Batch scripts in `src/original-src/web/htdocs/kimi_ET/kimibatch/` generate the IN files and process the OUT files

---

## Batch Processing System (`src/original-src/web/htdocs/kimi_ET/kimibatch/`)

The batch system is a **completely separate subsystem** from the web application. Scripts in `src/original-src/web/htdocs/kimi_ET/kimibatch/` are standalone PHP files intended to be run via command line or cron jobs, not through the web server routing.

### Shared batch utilities
- `src/original-src/web/htdocs/kimi_ET/kimibatch/db.php` — standalone DB connection helper (does NOT use `src/original-src/web/htdocs/kimi_ET/libs/database.php`)
- `src/original-src/web/htdocs/kimi_ET/kimibatch/kimi_general.php` / `src/original-src/web/htdocs/kimi_ET/kimibatch/kimi_general_sql.php` — shared utility functions
- `src/original-src/web/htdocs/kimi_ET/kimibatch/kimibatchtree.php` — web-accessible browser/overview of available batch scripts
- `src/original-src/web/htdocs/kimi_ET/kimibatch/files/vendor/` — independent Composer setup (PHPMailer 6.x) used by batch scripts that send email

### Campaign batch scripts
Each client/campaign has a set of scripts following a numbered naming pattern:
- `{campaign}01_` — import telephony data / phone number optimization
- `{campaign}02_` — prepare data for Elsbeth (generate outbound CSV files)
- `{campaign}03_` — process Elsbeth output files (import call results)
- `{campaign}04_` — status updates (mark open tickets as "in progress")
- `{campaign}05_` — email data preparation
- `{campaign}check.php` — status/sanity check dashboard
- `{campaign}report.php` — reporting
- `{campaign}schnupd.php` — "Schnellupdate" (quick status update)
- `{campaign}exp.php` — export scripts
- `{campaign}imp.php` — import scripts

### Campaigns implemented
| Prefix | Client/Campaign |
|---|---|
| `coeo` | COEO (main) |
| `coeoch` | COEO Switzerland |
| `coeochde` | COEO CH-DE |
| `coeodrei` | COEO DREI (Drei Austria) |
| `inko2016` | INKO 2016 |
| `inkode` | INKO Germany |
| `inkoSepa` | INKO SEPA export |
| `knp1` | KNP1 |
| `kpis` | KPI reporting (cross-campaign) |
| `oko` | OKO |
| `schlaustrom` | Schlaustrom (energy provider) |
| `quester` | Quester (one-off export) |

### Per-campaign data files (`src/original-src/web/htdocs/kimi_ET/kimibatch/files/{campaign_id}/`)
- `Scripts/` — SQL scripts for data maintenance, schema patches, one-off migrations
- `Services/` (campaign 43 only) — service definition text files
- `Templates/` (campaign 43 only) — email and SMS templates (`.html`, `.txt`)

---

## Data Exchange with Elsbeth (`src/original-src/web/exchange/`)

```
src/original-src/web/exchange/
└── {campaign_id}/
    ├── IN/     ← CSV files generated by batch scripts → consumed by Elsbeth
    └── OUT/    ← CSV files produced by Elsbeth → processed by batch scripts
```

One folder exists per active campaign: 1, 2, 3, 16, 18, 24, 27, 40, 41, 43.

---

## Personal Data Encryption

The system supports per-mandant **column-level encryption** for ticket data using MySQL stored functions:
- `kimi_encrypt($value)` — encrypts a value at DB level
- `kimi_decrypt($column)` — decrypts a column at DB level

Controlled by `mandant.encryption_aktiv = "J"` and `mandant.encryption_columns_ticket` (comma-separated list of column names).

SQL fragments are built by `App::getTicketDecryptionColumn()` and `App::getTicketEncryptionValue()` in `src/original-src/web/htdocs/kimi_ET/libs/application.php`.

---

## Configuration (`src/original-src/web/htdocs/kimi_ET/config/config.php`)

All runtime configuration is defined as PHP constants:

| Constant | Value | Purpose |
|---|---|---|
| `CONF_MYSQL_SERVER` | `localhost` | DB host |
| `CONF_MYSQL_USER` | `sql_kimi_et` | DB username |
| `CONF_MYSQL_PASSWORD` | `NS889Hs4bhL1aub7HyEH6AjdYpYAlx` | DB password (⚠ hardcoded) |
| `CONF_MYSQL_DB` | `kimi_et` | Main database name |
| `CONF_MYSQL_DB_ARCHIV` | `kimi_archiv` | Archive database name |
| `CONF_USER_PERMISSION` | `true` | Enable RBAC permission checks |
| `CONF_PORTAL_LINE_PER_SITE` | `20` | Pagination page size |
| `CONF_PORTAL_MAX_PAGES` | `20` | Max pagination pages |
| `CONF_TGZ_ZINSSATZ` | `1.55` | Daily interest rate (Tageszins) |
| `CONF_TICKETTELABFRAGE_KAMPID` | `",8,10,16,19,"` | Campaign IDs with telephone query enabled |
| `CONF_KAMPAGNE_AKT` | `".14..21."` | Campaign IDs with Akt (legal case) module |

Language files at `src/original-src/web/htdocs/kimi_ET/config/lang/de.php` define all `TXT_LBL_*` and `MSG_*` constants for UI text.

For local development, `src/original-src/docker/mariadb/init/01-init.sql` creates an empty `kimi_archiv` database and grants the `kimi` user access to both `kimi_archiv` and `kimi_et`. No `kimi_archiv` schema has been reconstructed; basic web portal functionality does not appear to query it directly, but archive batch scripts may fail until the archive schema is available.

---

## Frontend

- **jQuery 1.x** + **jQuery UI 1.10.3** — loaded from `src/original-src/web/htdocs/kimi_ET/js/` and `src/original-src/web/htdocs/lib/`
- **Themes**: jQuery UI themes in `src/original-src/web/htdocs/css/kimi-blue-modern/` (active), `src/original-src/web/htdocs/css/kimi-blue/`, `src/original-src/web/htdocs/css/kimi-green/`
- **Layout**: Custom CSS in `src/original-src/web/htdocs/css/theme-modern.css`
- **JavaScript validation**: Per-campaign `ticketvalidate.js` in `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/{campaign_id}/`
- **JavaScript field logic**: Per-campaign `ticketoptimize.js` in `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/{campaign_id}/`
- **iCalendar**: `src/original-src/web/htdocs/kimi_ET/ical/` directory stores generated `.ics` event files written via `src/original-src/web/htdocs/kimi_ET/ajax/write_file.php`
- **Nivo Slider**: Used on the public marketing landing page `src/original-src/web/htdocs/index.php`

---

## Public Website (`src/original-src/web/htdocs/`)

Separate from the application. `src/original-src/web/htdocs/index.php` and `src/original-src/web/htdocs/adminer-4.8.1.php` are the only files at this level.

`src/original-src/web/htdocs/index.php` is a jQuery Nivo Slider marketing page for kimi-plus.at. It does not share any code with the portal application.

`src/original-src/web/htdocs/adminer-4.8.1.php` is a database management web tool — should not be publicly accessible in production. A duplicate also exists at `src/original-src/web/htdocs/kimi_ET/adminer-4.8.1.php`.

---

## Known Architectural Issues

### PHP Compatibility (target: PHP 8.5)

| Severity | Location | Issue |
|---|---|---|
| **Critical** | `src/original-src/web/htdocs/kimi_ET/libs/addons/phpmail/class.phpmailer.php` | PHPMailer v2.0.4 — incompatible with PHP 8.x. Must be replaced with v6.9+ |
| **High** | `src/original-src/web/htdocs/kimi_ET/libs/database.php:22,36` | `mysqli_error()` called without connection argument — deprecated PHP 8.1, fatal PHP 8.2 |
| **Medium** | All entity and batch files | Implicitly nullable parameters (`function f(T $x = null)`) — deprecated PHP 8.4 |
| **Medium** | `src/original-src/web/htdocs/kimi_ET/libs/init.php:107` | `session_start()` has no secure cookie flags |
| **Low** | Whole codebase | `utf8_encode()` / `utf8_decode()` — deprecated PHP 8.2 |
| **Low** | Whole codebase | `"${var}"` string interpolation syntax — deprecated PHP 8.2 |

### Security Issues (GDPR-relevant)

| Severity | Location | Issue |
|---|---|---|
| **Critical** | `src/original-src/web/htdocs/kimi_ET/libs/entities/user.php:137` | SQL injection in login query — raw string concatenation: `WHERE (name = '$name' OR email = '$name')` |
| **High** | `src/original-src/web/htdocs/kimi_ET/libs/database.php` | No prepared statements anywhere — all queries use string concatenation |
| **High** | `src/original-src/web/htdocs/kimi_ET/config/config.php` | Database credentials hardcoded in plain text |
| **High** | `src/original-src/web/htdocs/kimi_ET/libs/init.php` | Session cookies lack `Secure`, `HttpOnly`, `SameSite` flags |
| **Medium** | `src/original-src/web/htdocs/kimi_ET/index.php` | Auto-login via URL parameters (`?autologin=true`) bypasses authentication |
| **Medium** | `src/original-src/web/htdocs/kimi_ET/libs/entities/user.php` | Password hashing: SHA-256 with static salt "kimiplus" — no per-user salt, no bcrypt/argon2 |
| **Low** | `src/original-src/web/htdocs/adminer-4.8.1.php` and `src/original-src/web/htdocs/kimi_ET/adminer-4.8.1.php` | DB admin tool accessible via web |

### Structural Issues

| Issue | Impact |
|---|---|
| **95% copy-paste codebase** (per system documentation slide 19) | Any fix must be applied to all copies; grep after each manual fix |
| **`src/original-src/web/htdocs/kimi_ET/modules/initial/` dead code** | 29 files never executed; add to PHP scan ignore list or delete |
| **`src/original-src/web/htdocs/kimi_ET/modules/gui/old_delete/` dead code** | 18 files never executed |
| **No Composer autoload in main app** | PHPMailer upgrade requires `require_once vendor/autoload.php` in every bootstrap and mail-sending file |
| **Two independent Composer contexts** | `src/original-src/web/htdocs/vendor/` (main app) vs `src/original-src/web/htdocs/kimi_ET/kimibatch/files/vendor/` (batch) — upgrades must be done in both |
| **Per-query DB connections** | `DB::query()` in `src/original-src/web/htdocs/kimi_ET/libs/database.php` opens and closes a new `mysqli_connect()` per call |
| **Session name inconsistency** | `src/original-src/web/htdocs/kimi_ET/libs/init.php` sets `kimi_ET-P`, but `src/original-src/web/htdocs/kimi_ET/login.php` and `src/original-src/web/htdocs/kimi_ET/index.php` both call `session_name('kimiET-P')` |

---

## File Locations Quick Reference

| What | Where |
|---|---|
| Application entry point | `src/original-src/web/htdocs/kimi_ET/index.php` |
| Login page | `src/original-src/web/htdocs/kimi_ET/login.php` |
| Bootstrap | `src/original-src/web/htdocs/kimi_ET/libs/init.php` |
| Database wrapper | `src/original-src/web/htdocs/kimi_ET/libs/database.php` |
| App singleton | `src/original-src/web/htdocs/kimi_ET/libs/application.php` |
| Configuration | `src/original-src/web/htdocs/kimi_ET/config/config.php` |
| Language (German) | `src/original-src/web/htdocs/kimi_ET/config/lang/de.php` |
| Entity classes | `src/original-src/web/htdocs/kimi_ET/libs/entities/*.php` |
| Page controllers | `src/original-src/web/htdocs/kimi_ET/modules/gui/*.php` |
| Nav menu definitions | `src/original-src/web/htdocs/kimi_ET/modules/menu/*.php` |
| Legacy dead code | `src/original-src/web/htdocs/kimi_ET/modules/initial/*.php` |
| Campaign ticket templates | `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/{id}/` |
| AJAX handlers | `src/original-src/web/htdocs/kimi_ET/ajax/*.php` |
| Telephony call handler | `src/original-src/web/htdocs/kimi_ET/ajax/callInntelco.php` |
| Telephony call logs | `src/original-src/web/htdocs/kimi_ET/ajax/log/` |
| Legacy mailer (v2) | `src/original-src/web/htdocs/kimi_ET/libs/addons/phpmail/class.phpmailer.php` |
| Composer vendor (main app) | `src/original-src/web/htdocs/vendor/` |
| Batch scripts | `src/original-src/web/htdocs/kimi_ET/kimibatch/*.php` |
| Batch vendor (PHPMailer 6) | `src/original-src/web/htdocs/kimi_ET/kimibatch/files/vendor/` |
| Elsbeth file exchange | `src/original-src/web/exchange/{campaign_id}/IN/` and `src/original-src/web/exchange/{campaign_id}/OUT/` |
| Per-campaign SQL scripts | `src/original-src/web/htdocs/kimi_ET/kimibatch/files/{campaign_id}/Scripts/` |
| Public landing page | `src/original-src/web/htdocs/index.php` |
| DB admin tool | `src/original-src/web/htdocs/adminer-4.8.1.php` and `src/original-src/web/htdocs/kimi_ET/adminer-4.8.1.php` |
