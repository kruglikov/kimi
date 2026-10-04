# Email from Darya Nestserava — 2026-09-09 (ANEXIA updated the `kimibatch` directory)

## Message metadata

| Field                                      | Value |
|--------------------------------------------|---|
| Gmail message ID                           | `1a08581ed40ec28c` |
| Gmail thread ID                            | `19eca5c926572156` |
| From                                       | Darya Nestserava `<darya.nestserava@innowise.com>` |
| To                                         | Viktar Kruhlikau `<viktar.kruhlikau@innowise.com>` |
| Subject                                    | `Fwd: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)` |
| Date                                       | Wed, 9 Sep 2026 11:31:00 +0200 |
| Inline images in the whole forwarded chain | 30 (`image030.png` … `image059.png`); only `image030.png` belongs to Franz Tausch's new 2026-09-09 message |

Darya Nestserava forwarded, without adding any text of her own, Franz Tausch's message of Wed, 9 Sep 2026 11:27 (Franz Tausch `<franz.tausch@kimi-plus.at>` → Darya Nestserava, Cc Michael Bortnik `<michael.bortnik@innowise.com>`, Lizaveta Akulenka `<lizaveta.akulenka@innowise.com>`). Everything below Franz Tausch's new paragraphs is the already-archived quoted history of the same thread (the 2026-08-23 / 2026-08-19 batch-test feedback is stored in `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/`); the complete plain-text body as delivered is kept verbatim in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/02-email-full-plaintext.txt`.

## Franz Tausch's new message — German original (verbatim)

> Guten Tag liebe Frau Nestserava
>
> gestern Abend hat ANEXIA das Verzeichnis upgedated.
>
> Etwas spät aber doch.
>
> Bitte um Info an Viktar.
>
> Danke und noch einen schönen Tag,
>
> herzliche Grüße
> FranZ

Followed in Franz Tausch's message by the screenshot `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/attachments/image030-kimibatch-directory-updated-2026-09-08.png`.

## English translation

> Good day, dear Ms Nestserava,
>
> yesterday evening ANEXIA updated the directory.
>
> A bit late, but done at last.
>
> Please pass the information on to Viktar.
>
> Thank you and have a nice day,
>
> kind regards
> FranZ

## The screenshot

`/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/attachments/image030-kimibatch-directory-updated-2026-09-08.png` — original inline name `image030.png`, Content-ID `ii_1a085813b0555d718d1`, PNG, 63 267 bytes.

What the screenshot shows:

- An SFTP file-manager session (tabs `sftp://Kimi@104.40.248.135:1111`, `ANEXIA PROD - sftp://kimiportal.at@10.196.69.11`, `ANEXIA DEV …`), with the remote path field reading `/home/kimiportaldev.at/web/htdocs/kimidev_ET/kimibatch`.
- The remote directory tree `web/` → `.deploy`, `files`, `htdocs/` → `css`, `images`, `kimi_DEV`, `kimidev_ET/` → `.git`, `ajax`, `config`, `css`, `ical`, `js`, **`kimibatch`** (selected/highlighted), `libs`, `log`, `modules`.
- The file listing of `kimibatch` with every entry stamped `08.09.2026 21:34:39` — e.g. `zeichenersetzen.php` (372 bytes), `wl.php` (203), `telematica_import_callmanager_log.php` (11 630), `substr.php` (3 364), `schlaustromschnupd.php` (3 110), `schlaustromreport.php` (1 042), `schlaustromexp20220703.php` (14 030), `schlaustromexp20190924.php` (14 015), `schlaustromcheck.php` (23 760), `SCHLAUSTROM_LEITFADEN.pdf` (709 509), `schlaustrom03_verarbeitung_elsbeth_out.php` (1 555), `schlaustrom02_daten_off_fuer_elsbeth_import.php` (1 732), `schlaustrom01SONDER_daten_inA_fuer_elsbeth_import.php` (1 746).
- Status line: `158 Dateien und 3 Verzeichnisse. Gesamtgröße: 10 642 834 Bytes`.

The uniform `08.09.2026 21:34:39` timestamp on all 158 files is the evidence for Franz Tausch's statement that ANEXIA refreshed the directory on the evening of 2026-09-08, and the path `/home/kimiportaldev.at/web/htdocs/kimidev_ET/kimibatch` is the *correct* batch directory — as opposed to the stale `/home/kimiportaldev.at/web/kimidev_ET_backup_20260813/kimibatch/files/` copy that was identified as the root cause of the import record-count mismatches reported on 2026-08-23 (see `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/franz-reported-problems-2026-08-23.md`).
