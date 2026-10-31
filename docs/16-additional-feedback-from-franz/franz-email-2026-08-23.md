# Franz Tausch — Batch-Tests & Antworten im GoogleDoc (23.08.2026)

**Quelle:** Gmail-Thread `Fwd: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)`, von Darya Nestserava am 24.08.2026 an Viktar Kruhlikau weitergeleitet.

**Von:** Franz Tausch <franz.tausch@kimi-plus.at>
**Datum:** Sonntag, 23. August 2026, 22:22
**An:** Darya Nestserava <darya.nestserava@innowise.com>
**Cc:** Michael Bortnik, Lizaveta Akulenka, Susanne Lauer <susanne.lauer@kimi-plus.at>
**Betreff:** AW: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

> Anhänge (Screenshots): siehe `attachments/` — `image001.png` … `image028.png`.
> Ältere Teile desselben Threads sind bereits abgelegt unter `docs/13-franzs-answer/` und `docs/14-update-from-Franz-about-the-database/`.

---

## 1. Neue Nachricht von Franz (23.08.2026)

Liebe Frau Nestserava,

ich habe meine Antworten zu den Frage im GoogleDocs eingetragen.

Beispiel.

![Beispiel einer beantworteten Frage im GoogleDoc (Insurance/Claims-Module sind obsolet und können ignoriert/entfernt werden)](attachments/image009.png)

Meine ersten Batch-Tests:

Die Programme laufen ganz gut, nur habe ich den verdacht das etwas nicht mit dem Fileverzeichnis stimmt bzw. Ich die Importdateien auf das falschen Verzeichnis gelegte haben??"!

Bitte um Prüfung und Rückmeldung und auch ob es einen Abstimmtermin geben kann.

Danke und herzliche Grüße

FranZ

### 1.1. Batch-Test-Protokoll (Screenshots mit Franz' Kommentaren)

![SFTP-Ansicht des Verzeichnisses /home/kimiportaldev.at/web/kimidev_ET_backup_20260813/kimibatch/files mit INKO2016.CSV, INKODE.CSV, pos30cc.txt](attachments/image028.png)

**NOK** – Datensätze passen nicht mit der Eingabedatei zusammen 29 zu 32 – welches File wird da wirklich verwendetn

![](attachments/image001.png)

![](attachments/image018.png)

**OK** – Anzeige der wirklich eingespielten …

![](attachments/image002.png)

**OK**

![](attachments/image003.png)

**OK**

![](attachments/image004.png)

**OK**

![](attachments/image005.png)

**OK**

![](attachments/image006.png)

**OK**

![](attachments/image008.png)

![](attachments/image007.png)

**NOK** – Import 4 Datensätze anstelle 46

![INKO2016 IMPORT-Lauf vom 23.08.2026 19:50:05 auf 10.196.69.21/kimidev_ET/kimibatch/inko2016imp3.php](attachments/image019.png)

Eingabedatei

![](attachments/image020.png)

**OK**

![](attachments/image021.png)

**OK**

![](attachments/image022.png)

**OK**

![](attachments/image023.png)

**OK**

![](attachments/image024.png)

**OKO** auch hier stimmt der tatsächliche Import nicht mit der Eingabedatei zusammen?!? IST: 28 zu SOLL 16?!?

![OKO IMPORT-Lauf vom 23.08.2026 20:11:57](attachments/image025.png)

![](attachments/image026.png)

![](attachments/image027.png)

---

## 2. Vorherige Nachricht von Franz (19.08.2026 13:56)

**Von:** Franz Tausch
**Gesendet:** Mittwoch, 19. August 2026 13:56
**An:** Darya Nestserava
**Cc:** Michael Bortnik, Lizaveta Akulenka
**Betreff:** AW: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

Liebe Frau Nestserava,

danke für Ihre Nachricht. Bei mir ist alles ok, ich hoffe bei Ihnen auch.

Ich habe die ersten 2 Schritte Test gemacht. Das Ziel war die Testumgebung und die Daten zu prüfen.

Unter Firefox komme ich nicht – das Session-Cookie Problem scheint hier noch vorhanden zu sein. Dann habe ich mit Alternative Cliq getestet

Daher wäre es mir wichtig das wir vor dem Start der Test vielleicht gemeinsam mit Viktor die Testumgebung abklären. Auch weil die Frage wegen des Datenbankstandes waren und das die Liste im google-Doc sehr lange ist wäre es besser wenn wir uns abstimmen.

Ich bitte daher um einen Terminvorschlag. Bitte immer Nachmittags- DANKE:

Bis dahin werden ich die Fragen in GoogleDocs durcharbeiten und die Test fortführen

Danke im Voraus.

Ich freue mich auf eure Rückmeldung.

Herzliche Grüße

FranZ

**#1 Session-Cookie?!? Komme in Firefox nicht über in die Suchmaske.**

IST in Firefox – komme nicht in Kampagnenauswahl

![](attachments/image010.png)

Soll

![](attachments/image011.png)

![](attachments/image012.png)

![](attachments/image013.png)

![](attachments/image014.png)

---

## 3. Zitierter Kontext: Nachricht von Darya (18.08.2026 12:34)

**Von:** Darya Nestserava
**Gesendet:** Dienstag, 18. August 2026 12:34
**An:** Franz Tausch
**Cc:** Michael Bortnik, Lizaveta Akulenka

Guten Tag, Herr Tausch!

Ich hoffe, Ihre Woche verläuft bisher wunderbar! Viktor hat mir ein Update geschickt, das ich Ihnen hiermit weiterleite:

---

Good afternoon, Franz!

I updated the code on the test site, and when over the test scenarios that you provided.

It appeared that the code that was deployed to test server significantly diverged from the original code you sent us before. And I was have to run PHP8.0 -> PHP 8.5 upgrade again which took additional efforst. But I stayed within initial estimate.

Also, it seems that the dump migration was done without the migration of database functions\procedured - I recredaed them on the test server from the previous dump.

I created list of problems in the code that I found. Some of them are pre-existing issues and some of them are fixed my me. Here is the report: https://docs.google.com/document/d/1ZvnoYLuQxBI8MtmPjtA5KHgd7YK4sGJuU2OMGXZDZHg/edit?usp=sharing

**1.** Please could you go over the test scrnarios from your side (and test if anything is wrong.) I went over the test scearios (and fixed bugs that I found), but since the database if different, i'm not 100% sure that I catched all the issues.

**2.** If you find any issues, please let us know. If all works fine - please let us know either.

See the curreltly spent time for the task vs estimated efforst in the estimate file: https://docs.google.com/spreadsheets/d/1pGXd2-RhUVA6CnJoXNFUrTcEF6-Cjz_s/edit?usp=sharing&ouid=102104514313633945938&rtpof=true&sd=true

---

Ich wünsche Ihnen einen wunderschönen Tag!

---

## 4. Zitierter Kontext: Franz (14.08.2026 08:55)

Guten Tag liebe Frau Nestserava,

danke für den Update. Natürlich ih werde keine Änderungen durchführen.

Ich drücke die Daumen für einen problemlosen und erfolgreiche Umsetzung.

Wir freuen uns auf die ersten Test.

Herzlichhe Grüße

FranZ

## 5. Zitierter Kontext: Darya (13.08.2026 14:30)

Guten Tag Herr Tausch,

Ich habe Feedback von Viktor erhalten:

Die Arbeiten sind derzeit auf dem Testserver In Progress.

Wir bitten Sie, bis auf Weiteres keine Änderungen am Systemcode vorzunehmen, damit keine Abweichungen zwischen dem Code auf dem Testserver und dem Code auf dem Produktionsserver entstehen.

Wir werden Ihnen Bescheid geben, sobald das Testen der aktualisierten Systemfunktionen auf dem Testserver seitens Kimi möglich ist.

Mit freundlichen Grüßen, Darya

---

> Der ältere Thread-Verlauf (04.08.2026 Datenbank-Import von Anexia, 28.07.2026, 20.07.2026 ANEXIA-Status vom 16.07.2026) ist bereits abgelegt unter `docs/14-update-from-Franz-about-the-database/01-update-from-Franz-about-the-database.md` und `docs/13-franzs-answer/franz-answer-2026-07-16.md`.
