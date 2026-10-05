# Values that differ between the dev and production instances of the KIMI Portal

## Why this document exists

Since 2026-10-03 the environment configuration files are tracked in the app repository `git@github.com:viktarkruhlikau/kimi.git` — see `git-tracking-policy-kimidev-et.md` for why. That decision closed one hole and opened another: a deployment made from this repository now carries whatever values are committed on `main`, and the values committed on `main` are the **dev** values. A production cutover performed as a plain `git pull` would therefore point the production portal at the dev database. Every value below has to be swapped deliberately, by hand, as part of any such cutover.

The values are listed as they are actually written in the code, with the file and line they occur in, so that none of them has to be remembered or guessed.

## The values

| What | Dev instance | Production instance |
|---|---|---|
| Host | `10.196.69.21` | `10.196.69.11` |
| Document root directory | `kimidev_ET` | `kimi_ET` |
| Portal database | `kimidev_et` | `kimi_et` |
| Portal database user | `sql_kimidev_et` | `sql_kimi_et` |
| PHP session name | `kimiET-A` | `kimiET-P` |

**Portal database and user** are defined at `src-dev/original-src/web/htdocs/kimidev_ET/config/config.php:3` (`CONF_MYSQL_USER`) and `src-dev/original-src/web/htdocs/kimidev_ET/config/config.php:4` (`CONF_MYSQL_DB`). The production values are not guesswork: they survive as commented-out lines in the untouched reference tree, at `src/original-src/web/htdocs/kimi_ET/config/config.php:3` (`//define("CONF_MYSQL_USER", "sql_kimi_et");`) and `src/original-src/web/htdocs/kimi_ET/config/config.php:5` (`//define("CONF_MYSQL_DB", "kimi_et");`) — which also means that the archive the client originally delivered was already switched to the dev database, with the production values commented out above the active ones.

**The PHP session name** is set twice in each tree and both occurrences must be changed together, because a mismatch between them logs the user out on every page change: `src-dev/original-src/web/htdocs/kimidev_ET/index.php:6` and `src-dev/original-src/web/htdocs/kimidev_ET/login.php:5` carry `session_name('kimiET-A')`, while `src/original-src/web/htdocs/kimi_ET/index.php:6` and `src/original-src/web/htdocs/kimi_ET/login.php:5` carry `session_name('kimiET-P')`. The distinct names are what allow both instances to be open in one browser without the two sessions overwriting each other.

**A second, separate database** is configured for the AJAX layer and is not the portal database: `src-dev/original-src/web/htdocs/kimidev_ET/ajax/config/config.php:3` and `src-dev/original-src/web/htdocs/kimidev_ET/ajax/config/config.php:5` define the user `sql_kimiportaldev` and the database `kimiportaldev`, and `src-dev/original-src/web/htdocs/kimidev_ET/ajax/config/config.php:37` and `src-dev/original-src/web/htdocs/kimidev_ET/ajax/config/config.php:39` define the user `kimi` and the archive database `kimi_archiv`. These have their own production counterparts and must be checked separately; the client reported in `docs/14-update-from-Franz-about-the-database/01-update-from-Franz-about-the-database.md` that the database `kimiportal` was empty on production.

## The hard-coded production references in the deployed tree

The two instances are not separated by configuration alone. The deployed tree `src-dev/original-src/web/htdocs/kimidev_ET/` contains the production host `10.196.69.11` **29 times across 9 PHP files**, and the production document root name `/kimi_ET/` **42 times**. On the dev server every one of those links leads to production. They fall into three groups:

- **Document links.** `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/templates/tickets/8/ticket.php:33` and `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/templates/tickets/8/ticket.php:35` link to `https://10.196.69.11/kimi_ET/modules/gui/templates/tickets/8/OKO_Sachbearbeiter.pdf` and `https://10.196.69.11/kimi_ET/modules/gui/templates/tickets/8/OKO_Leitfaden.pdf`; `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/templates/tickets/34/ticket.php:124` and `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/templates/tickets/35/ticket.php:129` link to `https://10.196.69.11/kimi_ET/kimibatch/COEO_NeueMandanten20230523.pdf`.
- **A deep link built by an interface.** `src-dev/original-src/web/htdocs/kimidev_ET/getticketurl.php:272` returns the absolute URL `https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=userReferenz&mandant=…&kId=…&ticket_id=…`, so an external system calling the dev server is handed a link into **production**.
- **The password-less autologin itself.** The query string above is accepted by `src-dev/original-src/web/htdocs/kimidev_ET/index.php`, which signs a user in from the `loginuser` parameter **without checking a password**. The mechanism exists unchanged in production code and was not introduced by the PHP 8.5 upgrade; it is recorded for the client as a decision item and has deliberately not been changed.

## Related documents

- `git-tracking-policy-kimidev-et.md` — why the environment `config.php` files are tracked, and what that means for a pull
- `deploy-and-rollback-runbook.md` — the deployment procedure these values have to be swapped within
- `ARCHITECTURE.md` — the two source trees and how they relate
