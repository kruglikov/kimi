# Is the code ANEXIA uploaded on 2026-09-08 really the latest production version?

Investigation date: 2026-09-09. Trigger: Franz Tausch's message of 2026-09-09 (`/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/01-email-from-darya-2026-09-09.md`) — *"gestern Abend hat ANEXIA das Verzeichnis upgedated"*.

## Verdict in one paragraph

**Yes for the lower bound, unproven for the upper bound.** The code ANEXIA placed on the dev server is genuine production code that is **newer than the March 2026 production snapshot we already hold**, and the changes it adds are exactly the ones Franz Tausch announced in June 2026 (the `telnr5`–`telnr10` / ONCLICK-call feature and the new COEO CH DE/FR/IT batch scripts). The newest change marker found anywhere in the uploaded code is **2026-06-14**. Nothing in the uploaded tree is newer than that, and nothing contradicts it being current production. What we still cannot prove from the dev server alone is that production has not changed between 2026-06-14 and 2026-09-08 — that requires a checksum manifest taken on the production host `kimiportal.at` (10.196.69.11), which only ANEXIA can produce.

## What was copied locally

The remote directory `/home/kimiportaldev.at/web/kimidev_ET_backup_20260909/` was copied with `rsync` into `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/updated-code-snapshot/` — 2 944 files, 126.5 MB. The only exclusion is `ajax/log/` (116 MB of runtime call logs, no code value). `.git/`, `kimibatch/files/` and everything else were copied in full.

## What `kimidev_ET_backup_20260909` actually is (it is NOT the pristine ANEXIA upload)

This matters, because the directory name suggests a backup of the *previous* state, and it is not that either.

| Directory | Total files in `kimibatch/` (top level) | PHP files in `kimibatch/` | Content of the marker file `kimibatch/telematica_import_callmanager_log.php` |
|---|---|---|---|
| `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/` (our deployed, PHP 8.5-adjusted code) | 79 | — | 11 125 B |
| `/home/kimiportaldev.at/web/kimidev_ET_backup_20260909/` (the copied snapshot) | 80 | 69 | **11 630 B** |
| `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` (the live dev docroot after ANEXIA's update) | 158 | 142 | **11 630 B** |
| `/home/viktar/Projects/kimi-plus.at/docs/02-Kimi-portal-innowise-archive/KIMI-Portal/web/htdocs/kimi_ET/` (production snapshot, 29 Mar 2026) | 139 | — | 11 630 B |

So `kimidev_ET_backup_20260909` holds **production file contents on our deployed file set**: every file that existed in our deployment was overwritten with the production version, but the ~78 production scripts that our deployment never had are missing. The live docroot `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` has both. Running `git status` inside the copied snapshot confirms the shape: **89 modified tracked files and 1 untracked file** (`kimibatch/COEO_NeueMandanten20230523.pdf`), against `HEAD = 6f7a8d0`.

The most consistent explanation is that `kimidev_ET_backup_20260909` is a **partial copy of the live docroot taken after the overwrite**, restricted to the files the `kimiportaldev.at` user could read at that moment — see the ownership section below. It is therefore useful as evidence of *content*, but it is **not** a complete copy of what ANEXIA uploaded, and it must not be used as a restore source.

Confirmation that the copied snapshot carries production code and not ours: `login.php` in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/updated-code-snapshot/login.php:13` and `:22` contains `session_unset()` again — the very call removed by commit `823fda7` ("Preserve selected Mandant/campaign across login.php reloads"). Our session-reset fix has been reverted by ANEXIA's copy.

## The decisive evidence: only 4 files differ from the March 2026 production snapshot, and all 4 are the June 2026 production changes

Comparing `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/updated-code-snapshot/` against `/home/viktar/Projects/kimi-plus.at/docs/02-Kimi-portal-innowise-archive/KIMI-Portal/web/htdocs/kimi_ET/` over their common file set yields exactly **four** differing files. Each one carries a change dated June 2026.

### 1. `kimibatch/okoimp.php` — 18 001 B → 20 243 B

Before (March 2026 production, `/home/viktar/Projects/kimi-plus.at/docs/02-Kimi-portal-innowise-archive/KIMI-Portal/web/htdocs/kimi_ET/kimibatch/okoimp.php`):

```
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,dummy_date2,dummy_text8,wiedervorlage_automatik, anzahl_anrufe,ergebnis)
...
        concat(aktnr1,'/',aktnr2),faelligbis,mitschuldner,1,0,telefon3plus
```

After (uploaded code, `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/updated-code-snapshot/kimibatch/okoimp.php`):

```
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,dummy_date2,dummy_text8,wiedervorlage_automatik, anzahl_anrufe,ergebnis,
		dummy_text11,dummy_text12,dummy_text13,dummy_text14,dummy_text15,dummy_text16) -- 2026-06-14
...
        concat(aktnr1,'/',aktnr2),faelligbis,mitschuldner,1,0,telefon3plus,
		telnr5,telnr6,telnr7,telnr8,telnr9,telnr10 -- 2026-06-14
```

plus six new variables `$telefon5` … `$telefon10` marked `/* 20260614 */`. The columns `oko.telnr5` … `oko.telnr10` are precisely the six columns Franz Tausch listed in `/home/viktar/Projects/kimi-plus.at/docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md:38-45`, and point 2 of that same email (`/home/viktar/Projects/kimi-plus.at/docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md:47`) asks for exactly this: *"update /kimi_ET/kimibatch/okoimp.php batch script to store the data in the new fields telnr5–telnr10"*.

### 2. `modules/gui/ticket.php` — 26 413 B → 38 185 B

The uploaded version adds a ~300-line block starting with `$("#callTelco4").click(function(e) {`, which POSTs to `./index.php?site=callInntelco&ajax=true` with `objekt: 'callTelNo'`. This is the ONCLICK outbound-call JavaScript that Franz Tausch describes at `/home/viktar/Projects/kimi-plus.at/docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md:61`: *"The changes to ticket.php and okoimp.php have already been made. The ONCLICK functions (see HTML) aren't working."*

### 3. `modules/gui/templates/tickets/8/ticket.php` — 28 242 B → 32 846 B

UI edits in the same family: the `Copy` buttons on the `Ort` and `Straße` labels were removed and a block of extra telephone-number rows was commented out.

### 4. `kimibatch/kimibatchtree.php` — 21 146 B → 23 043 B

Twelve new menu entries added for the COEO CH DE / CH FR / CH IT P1–P3 batch scripts (`coeochde02_tagl_daten_fuer_elsbeth_import_alleP1.php` … `coeochit02_tagl_daten_fuer_elsbeth_import_alleP3.php`). The corresponding script files are present in the live docroot as untracked files, confirming the menu and the scripts arrived together.

### Independent corroboration from file names

Two dated backup copies exist in the live docroot that do **not** exist in the March 2026 production snapshot: `kimibatch/okoimp_save_20260614.php` and `modules/gui/templates/tickets/8/ticket_save20260614.php`. These are the legacy author's own "save before editing" convention, and they name the same date, 14 June 2026, as the inline code comments.

### Upper bound on how current the code is

Scanning every PHP and JS file in the uploaded tree for embedded date markers of the form `2026-MM-DD` / `2026MMDD` returns only **20260614**. Scanning every file *name* in the live docroot returns `20260614` as the newest stamp (previous ones: 20250208, 20230523, 20220703, 20220627, 20190924, 20181128, 20150414). There is therefore no trace of any production change after 14 June 2026 — which is consistent both with "ANEXIA copied current production" and with "production genuinely has not changed since June".

## What this does NOT prove

The comparison above is against *our* March 2026 production snapshot, not against production as it stands today. A copy taken from a stale intermediate source — for example the older on-server backup `/home/kimiportaldev.at/web/kimidev_ET_backup_20260813/` — would look identical in every test performed here, because that directory also predates our deployment and also derives from production. The only test that separates the two is a checksum comparison against the production host itself.

**The check to request from ANEXIA.** On the production host `kimiportal.at` (10.196.69.11):

```
cd /var/www/vhosts/kimiportal.at/htdocs/kimi_ET
find . -type f \( -name '*.php' -o -name '*.js' \) -not -path './kimibatch/files/*' -not -path './vendor/*' \
  | sort | xargs md5sum > /tmp/prod-manifest.txt
```

and the same command on the dev host `kimiportaldev.at` (10.196.69.21) in `/home/kimiportaldev.at/web/htdocs/kimidev_ET`, then `diff` the two manifests. An empty diff proves the uploaded code is byte-identical to current production. **Note:** on the dev host this command must be run as `root` or after the ownership fix below, otherwise 85 files are silently skipped because the `kimiportaldev.at` user cannot read them.

## A blocking side effect of the upload: 87 files and 10 directories are root-owned and unreadable

ANEXIA performed the copy as `root` without resetting ownership. Current state of `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` (excluding `.git/` and `kimibatch/files/`):

| Owner:group | Files |
|---|---|
| `kimiportaldev.at:kimiportaldev.at` | 430 |
| `root:root` | **87** |

Of those 87, **85 are unreadable** to the `kimiportaldev.at` user (mode 0640 or 0600). Ten directories are also unreadable:

```
./modules/gui/templates/tickets/1
./modules/gui/templates/tickets/2
./modules/gui/templates/tickets/3
./modules/gui/templates/tickets/35
./kimibatch/files/20240606
./kimibatch/files/save
./kimibatch/files/vendor
./kimibatch/files/43/Templates
./kimibatch/files/43/Scripts
./kimibatch/files/43/Services
```

Consequences:

1. The four `warning: could not open directory 'modules/gui/templates/tickets/N/': Permission denied` messages seen in `git status`.
2. Any file under those paths is invisible to `git`, so `git status` under-reports what actually changed.
3. **PHP-FPM will very likely fail to read the same files**, so the newly uploaded batch scripts and ticket templates may error at runtime even though they are present on disk. This must be fixed before Franz Tausch's next test round.

Fix to request (note: `chown`, not `chmod` — `chmod` changes permission bits, `chown` changes owner and group, and only `chown` addresses this):

```
chown -R kimiportaldev.at:kimiportaldev.at /home/kimiportaldev.at/web/htdocs/kimidev_ET/
```

## Consequences for our deployment that still need a decision

The upload overwrote 89 tracked files in the git working copy at `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`, spread over `kimibatch/` (34 files), `modules/` (29), `libs/` (20), the docroot root (5) and `ajax/` (1). Effects:

- Every PHP 8.5 adjustment deployed to the dev server has been reverted to the PHP 8.0 original.
- The session-reset fix (commit `823fda7`) has been reverted — expect Franz Tausch's Firefox campaign-selection problem (P5 in `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/franz-reported-problems-2026-08-23.md`) to reappear.
- The client-approved file removals (commit `6f7a8d0`) have been undone — the 7 `mysql_*` batch scripts and the dated backup/variant files are back.
- New untracked files now sit in the docroot that are security-relevant regardless of the rest: `adminer-4.8.1.php` (a full database admin tool), `kimibatch/phpinfo.php` and `kimibatch/kimiphpinfo.php`.
- A `git pull` on the dev server will now refuse or conflict until the working copy is cleaned.

No change has been made to the dev server or to the repository as part of this investigation. The restore procedure is a separate decision and is not proposed here.
