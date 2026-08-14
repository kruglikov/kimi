# Email: AW: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

**Forwarded by:** Darya Nestserava <darya.nestserava@innowise.com>
**Forwarded date:** Mon, Jun 15, 2026 at 08:18 UTC
**Original from:** Franz Tausch <franz.tausch@kimi-plus.at>
**Original date:** Mon, Jun 15, 2026 at 4:52 AM
**To:** Darya Nestserava <darya.nestserava@innowise.com>
**Cc:** Michael Bortnik <michael.bortnik@innowise.com>, Lizaveta Akulenka <lizaveta.akulenka@innowise.com>
**Subject:** AW: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

---

## Attachments

- `attachments/image001.png` — inline screenshot (Zielpfad / target path for CSV)
- `attachments/image002.png` — inline screenshot
- `attachments/image003.png` — inline screenshot
- `attachments/INKO2016.CSV` — batch test data file
- `attachments/ticket.php` — PHP source file

---

## Franz Tausch's Email (exact text)

Guten Morgen Frau Nestserava,

danke für den Update.

Zu den Fragen / Hinweisen:

#1 Eine Frage zu den Test Cases: Beim letzten Szenario „Batch – Übersicht /kimidev_ET/kimibatch/kimibatchtree.php" – brauchen wir dafür eine separate CSV-Datei, oder ist das nicht nötig?

Testdaten INKO2016.CSV in der Anlage

Zielpfad:

[image001.png — screenshot of target path]

#2 Wird Anexia die aktuellen Produktionsserver-Einstellungen inklusive Projektordner übernehmen, oder bekommen wir einen leeren Server und müssen alles neu aufsetzen?

Der Server wird nicht leer sein, sondern wir sollen genau definieren was ist benötigen und Anexia wird die Versionen installieren. Dann müssen wir nur mehr prüfen bzw. notwendigen Einstellungen konfigurieren.

Das ist der Plan. Daher wäre es gut zu wissen welche Versionen wir genau installieren müssen.

#3 Es gibt eine rot markierte Bugfixing-Aufgabe. Wir rechnen nicht mit größeren Problemen, möchten aber darauf hinweisen, dass ein gewisses Risiko bleibt – vor allem bei der Batch-Verarbeitung könnten zusätzliche Aufwände entstehen.

Danke für den Hinweis. Das ist in Ordnung.

Ich weiß momentan nicht wie ich die Testcases beschreiben soll, bzw. wie ich die ganzen Testdaten bereitstelle.

Mir wäre es recht, das wie die Tests dann schon in der KIMI-Testumgebung machen.

Bitte dazu um Ihre Meinung.

Ich habe noch eine Information bzw. eine Frage/Bitte/kleine Erweiterung:

Wie gehen wir mit zwischenzeitlichen Änderungen um ?

Und zwar bei OKO :

Wir benötigen eine Erweiterung der Telefonfelder in der Maske, damit die Telefonnummer 4 bis 10 auch einfach und schnell telefoniert werden können.

Es soll bei jeden Feld Telefon 4 bis 10 ein Telefonsymbol sein.

Beispiel neu:

```html
            </td>

            <td bgcolor=#FFFF00><?php echo "Telefon 4" ?></td>

            <td>

                <input style="width: 170px" placeholder="<?php echo "Telefon 4" ?>" name="dummy_text6" class="column" type="text" value="<?php echo $ticket->get_dummy_text6() ?>" />

                                                               <img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco4" name="callTelco4" onClick="callTelco3()" width="16" height="16" alt="dummy_text6" />

            </td>
```

Es geht jetzt um onClick="callTelco3()" bzw. wie man diese richtig macht.

So wie es aussieht müssen für jedes Telefonsymbol eigene Cklick-Functions gemacht werden.

Im HTML- Code sieht es so aus.

Die Frage ist, wo bzw. wie diese generiert werden bzw. welche Änderungen notwendig sind.

Es wäre super wenn wir diese Frage unabhängig von der Migration klären könnten, weil die Änderung ein große Arbeitserleichterung für die Agenten ist.

Können Sie sich das zusätzlich ansehen?

```javascript
      $("#callTelco3").click(function(e) {

            $this = $(this);

            e.preventDefault();

            $("#btnStart").click();

            $('#telefon_status').val('senden...');

            kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;

            kampagne_iptel_auto_vorwahl = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;

            benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;

            telNr = document.getElementsByName(e.target.alt)[0].value;

            clientIp = document.getElementsByName("client_ip")[0].value;

            nebenstelle = document.getElementsByName("nebenstelle")[0].value;

            $.ajax({

                url: "./index.php?site=callInntelco&ajax=true",

                type: "POST",

                data: {

                    'objekt': 'callTelNo',
                    'user': 'tauschfranz',
                    'iptel_durchwahl': benutzer_iptel_durchwahl,
                    'kampagne_iptel_destclid': kampagne_iptel_destclid,
                    'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
                    'dest': telNr,
                    'client_ip': clientIp,
                    'nebenstelle': nebenstelle

                },

                success: function(data) {

                    var data = $.parseJSON(data);

                    if (data.retcode != "0") {
                        alert(data.msg);
                        $('#telefon_status').val('Fehler');
                    } else {
                        $('#telefon_status').val('Fertig');
                    }

                },

                error: function(error) {
                    alert(error);
                    $('#telefon_status').val('Fehler');
                }

            });

        });
```

DB-Änderung:

```sql
ALTER TABLE oko
ADD COLUMN telnr5 VARCHAR(45),
ADD COLUMN telnr6 VARCHAR(45),
ADD COLUMN telnr7 VARCHAR(45),
ADD COLUMN telnr8 VARCHAR(45),
ADD COLUMN telnr9 VARCHAR(45),
ADD COLUMN telnr10 VARCHAR(45);
```

Ich freue mich auf Ihre Rückmeldung.

Einen schönen Tag,

herzliche Grüße

Franz Tausch

---

## Previous message in thread: Darya → Franz (Jun 10, 2026)

Von: Darya Nestserava <darya.nestserava@innowise.com>
Gesendet: Mittwoch, 10. Juni 2026 17:53
An: Franz Tausch <franz.tausch@kimi-plus.at>
Cc: Michael Bortnik <michael.bortnik@innowise.com>; Lizaveta Akulenka <lizaveta.akulenka@innowise.com>
Betreff: Re: Follow-up on the Innowise x KIMI-Plus Meeting (26.05.2026)

Guten Abend Herr Tausch,

die Test Cases sind gut und klar – herzlichen Dank! Viktor hat sich alles angeschaut. Eine Frage zu den Test Cases: Beim letzten Szenario „Batch – Übersicht /kimidev_ET/kimibatch/kimibatchtree.php" – brauchen wir dafür eine separate CSV-Datei, oder ist das nicht nötig?

Den Dump haben wir erfolgreich heruntergeladen und decoded – danke!

> Einen VPN-Zugang zur Anexia fordere ich gerade an.

Wir freuen uns auf den Zugang. Wird Anexia die aktuellen Produktionsserver-Einstellungen inklusive Projektordner übernehmen, oder bekommen wir einen leeren Server und müssen alles neu aufsetzen?

Wir haben ein Estimate für das finale Testing, Bugfixing und Deployment vorbereitet – die Tabelle ist im Anhang und auch per Link verfügbar.

Das Estimate umfasst zwei große Teile:

1. Test & lokales Debugging – Dump einspielen, lokal testen und mögliche Bugs beheben.
2. Deployment auf den Testserver – finales Deployment.

Es gibt eine rot markierte Bugfixing-Aufgabe. Wir rechnen nicht mit größeren Problemen, möchten aber darauf hinweisen, dass ein gewisses Risiko bleibt – vor allem bei der Batch-Verarbeitung könnten zusätzliche Aufwände entstehen.

Beste Grüße

---

## Previous message in thread: Darya → Franz (Jun 8, 2026)

Guten Tag Franz, herzlichen Dank für die Updates!

Wir melden uns bald mit unserem Feedback.

Beste Grüße

---

## Previous message in thread: Franz → Darya (Jun 7, 2026)

Liebe Frau Nestserava,

anbei sende ich Ihnen eine Testbeschreibung der wichtigsten Dialogschritte und der wichtigsten Prozess-Schritte im Batch anhand Mandant INKO2016 – siehe Anlage-

Den DB-dump werde ich über WE-Transfer an Sie übermitteln – Passwort der ZIP-Datei: $Kimi$Innowise2026

Der VPN Zugang ist in Arbeit.

Bitte um Rückmeldung ob die Tests bzw. der DB-dump soweit in Ordnung sind.

Danke und herzliche Grüße

Franz Tausch

---

## Previous message in thread: Franz → Darya (Jun 2, 2026)

Liebe Frau Nestserava,

kurzer Update:

- Der DB-dump ist von Aneia in Arbeit – sobald er vorliegt melde ich mich bzgl. Bereitstelllung
- Für die Testbeschreibung werde ich ein Muster erstellen
- Einen VPN-Zugang zur Anexia fordere ich gerade an.

Nächster Status auf jeden Fall Anfang kommender Woche.

Einen schönen Tag,

herzliche Grüße

Fran Tausch

---

## Previous message in thread: Franz → Darya (May 28, 2026)

Liebe Frau Nestserava,

auch von meiner Seite Danke für das angenehme und konstruktive Meeting.

Ich habe das Dokument von Viktor soweit ich es jetzt beantworten kann bearbeitet und meine Hinweise eingetragen.

Bei mir als nächsten Schritt ist jetzt die Abstimmung mit Anexia.

Ich halte sie gerne am Laufenden.

Einen schönen Tag, herzliche Grüße

FranZ

---

## Previous message in thread: Darya → Franz (May 27, 2026)

Guten Tag Herr Tausch, nochmals herzlichen Dank für das produktive und offene Gespräch!

Wir schätzen Ihre Zeit und die hilfreichen Einblicke, die Sie mit uns geteilt haben, wirklich sehr. Wie besprochen, sehen die nächsten Schritte folgendermaßen aus:

1. Setup new test environment
2. Deploy the updated PHP 8.5 code base and test database
3. Test & bugfix
4. Final deploy to production
5. Auto-login issue

Viktor hat ein Dokument vorbereitet, in dem er die Ideen beschrieben hat. Schauen Sie es sich bitte kurz an, um zu prüfen, ob alles stimmt – Ihre Antworten und Kommentare zu den offenen Fragen können Sie gerne direkt im Dokument hinterlassen.

Bei Fragen oder Anregungen zu diesen Schritten melden Sie sich einfach – wir besprechen alles gerne nochmal. Wir freuen uns immer über Ihr Feedback und unterstützen Sie gerne bei jedem Schritt!

Einen schönen Tag noch!

--

Darya Nestserava
Service Delivery Specialist (DACH)
INNOWISE
darya.nestserava@innowise.com
https://innowise.com/
