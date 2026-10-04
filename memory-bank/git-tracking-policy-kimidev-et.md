# Git tracking policy for the deployed tree `kimidev_ET`

Applies to the application repository `git@github.com:viktarkruhlikau/kimi.git` (branch `main`), which has two working copies: the live document root on the ANEXIA dev server, `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`, and the local mirror `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/`. Established 2026-10-03.

## The policy: track everything except the runtime log directory

This is a migration and upgrade project, not regular feature development, so the value of git here is a complete record of what the tree contained at each point — not a tidy history of hand-written changes. Everything in the document root is therefore tracked, including the batch data directory `kimibatch/files/` (2 700 files, 110 MB), the batch Composer install `kimibatch/vendor/` (76 files), and the environment configuration files `config/config.php` and `ajax/config/config.php`.

The complete `.gitignore` of the deployed tree is now:

```gitignore
# Runtime logs and dumps — never tracked (ajax/log/ alone holds a 109 MB file)
log/
*.sql.gz
```

`log/` matches any directory of that name at any depth, which is what keeps `ajax/log/` out. `*.sql.gz` is a guard against committing a database dump; no such file exists in the tree.

## Why `ajax/log/` must stay ignored — a hard limit, not a preference

`ajax/log/` holds 116 MB in four files, the largest being `ajax/log/callTelematica.log` at **108.8 MB**. GitHub rejects any push containing a single file over 100 MB, so tracking that directory would make every push fail. The other three files (`callinfo.log`, `callInntelco.log`, `telematica_import_callmanager_log_error.log`) are runtime output that the application rewrites continuously, so tracking them would add a large diff to every batch run for no upgrade value.

## Why the configuration files are tracked — the incident that caused the change

Until 2026-10-03 the rule `**/config.php` kept `config/config.php` and `ajax/config/config.php` out of git, on the reasoning that environment-specific database settings should be preserved per environment and never overwritten by a deploy. The hosting provider's file copy of 2026-09-08 showed the cost of that reasoning: the copy replaced both configuration files and `kimibatch/db.php` with the production values, and because only `kimibatch/db.php` was tracked, `git status` reported a single modified file while the portal silently pointed at the database `kimi_et`, which does not exist on the dev host. Every login then failed for three weeks, because `libs/database.php:23`, `libs/database.php:38` and `libs/database.php:64` each call `mysqli_select_db` with that name. Tracking the configuration files makes any future overwrite appear in `git status` instead of passing unnoticed. The trade-off accepted knowingly: the repository now carries the dev database credentials, which is acceptable because this repository serves the dev and test environment only.

## The local Docker stack and the dev server share the same configuration file

Verified on 2026-10-03 by checksum: `config/config.php` is byte-identical in the local mirror and on the dev server (`md5 c7b395d359bfca22072e490533751b0e`), and so is `ajax/config/config.php` (`md5 7863fd89c4d5265f6eeea0a6f7675e2c`). Both descend from the same original dev configuration of 2022-04-20, which is why the dev server could be repaired simply by restoring the file from the backup `/home/kimiportaldev.at/web/kimidev_ET_backup_20260813/`. The local Docker stack therefore needs no private version, and a `git pull` into the local mirror is safe today.

**If the two ever do need to diverge**, do not re-add an ignore rule — that would re-create the blind spot described above. Instead keep the file tracked and tell the local checkout to disregard local edits to it:

```
git update-index --skip-worktree config/config.php
```

and reverse it with `--no-skip-worktree` when the file genuinely has to change in the repository. Note that `git pull` overwrites an *ignored* file without warning, which is exactly what happened to the local `config/config.php` during the 2026-10-03 pull — it was backed up first and turned out to be identical, so nothing was lost.

## Local-only test artifacts must never be committed

Since `kimibatch/files/` stopped being ignored, the local mirror `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/` reports **439 untracked files** that the earlier ignore rule used to hide. Almost all of them are export CSVs written by our own Docker batch runs on 2026-08-14, under paths such as `kimibatch/files/16/OUT/OKO_OUTBOUND_ELSBETH_inA20260814103643.csv`. They are local test output, they exist on no other machine, and they are not part of any delivery.

**Never run `git add -A` in the local mirror.** Stage files by explicit path instead. Anything committed from `kimibatch/files/` should come from the dev server's working copy, where that directory holds the data the hosting provider actually delivered.
