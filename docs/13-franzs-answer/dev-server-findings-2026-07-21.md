# Dev server findings — what is actually deployed (2026-07-21)

Investigation triggered by Daniel Brunner's status mail (see
`franz-answer-2026-07-16.md`), which asked us to *"confirm whether everything is
working as expected and when the production environment can be migrated."*

We connected to the ANEXIA test system over the FortiClient VPN + SSH and inspected
the live installation.

## Headline

- **The runtime was upgraded, but our upgraded application code was NOT deployed.**
- The dev server is running the **old / original site code on a PHP 8.5 interpreter** —
  the un-upgraded codebase, i.e. exactly the risk the migration project exists to prevent.
- The PHP 8.5 compatibility work in `src/upgraded-src/` (75 changed files, Rector +
  manual fixes, 0-failure smoke baseline) is **absent** on the server.

## Server facts (verified on host `2281845-0402`, `10.196.69.21`)

| Item                 | Value |
|----------------------|-------|
| OS                   | Debian GNU/Linux 13 (trixie), kernel `6.12.95+deb13-amd64` |
| PHP                  | **8.5.8** — CLI + PHP-FPM `php8.5-fpm` (only 8.5 installed; no other PHP version) |
| MariaDB client       | 12.3.2 |
| Web server           | nginx (80/443), PHP-FPM pools `127.0.0.1:9001` (app), `127.0.0.1:9002` (kimibatch) |
| Panel                | Plesk |
| Document root        | `/var/www/vhosts/kimiportaldev.at/htdocs` |
| **Live application** | **`/var/www/vhosts/kimiportaldev.at/htdocs/kimidev_ET/`** (26 MB) |
| Entry point          | root `index.php` → redirect to `/kimidev_ET/login.php` |
| Database             | MariaDB local, DB `kimidev_et`, user `sql_kimidev_et` |

Other folders in the docroot: `kimi_DEV/` (older variant incl. batch framework),
`kimi/` (only `index.php` + `phpinfo.php`), plus `css/`, `images/`, `vendor/`, `lib/`,
`adminer-4.8.1.php`, `validphone.php`.

## How we determined old vs upgraded

1. Located the live app dir `kimidev_ET`.
2. Locally found **75 files that differ** between `src/original-src/web/htdocs/kimi_ET`
   and `src/upgraded-src/web/htdocs/kimi_ET` — these serve as fingerprints.
3. Fetched sample fingerprint files from the server and diffed each against **both**
   local trees. Also checked file modification timestamps.

| Deployed file | vs `original-src` | vs `upgraded-src` | Matches |
|---|---|---|---|
| `ajax/callInntelco.php` | **0 differing lines** (exact) | 2 differing lines | **Original** |
| `getticketurl.php` | 12 differing lines | 80 differing lines | **Original** (far closer) |

- `callInntelco.php` is **byte-identical** to the original; the upgraded version is not
  present.
- `getticketurl.php` is much closer to original; its 12-line delta is a local production
  edit (it is the one file dated 2023-04-12).
- **Timestamps:** all other files are dated **2022** (`login.php` 2022-08-08,
  `libs/` 2022-04-20, newest batch file 2022-11-21). Our upgrade work is from
  **2025–2026**, so the deployed code predates the upgrade entirely.

## Caveats

- The live folder is `kimidev_ET`; our repo trees use `kimi_ET`. Same application
  lineage, but the dev deployment is an **older snapshot** — not a 1:1 checkout of the
  repo's `original-src` either (e.g. the 2023 `getticketurl.php` edit exists only on the
  server).
- We sampled 2 of 75 fingerprint files. Both agree and timestamps corroborate, so the
  conclusion is confident; a full file-by-file comparison can be run if certainty across
  the whole tree is required.

## Security note

`kimidev_ET/config/config.php` stores the MariaDB credentials in **plaintext**. Recommend
rotating that DB password. (Consistent with findings in `docs/04-results/Audit-report.md`.)

## Implication for the migration question

The **runtime** (OS / PHP 8.5 / MariaDB) is ready, but the **application code still needs
the PHP 8.5-compatible version deployed and validated** (run the smoke suite against it)
**before** any production cutover. Migrating PROD while the un-upgraded code runs on
PHP 8.5 would carry the compatibility risks the upgrade was meant to remove.
