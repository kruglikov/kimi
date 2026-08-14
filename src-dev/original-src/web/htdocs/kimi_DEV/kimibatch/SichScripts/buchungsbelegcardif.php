<html>
  <head>
     <title>KIMI-Plus - Buchungsbeleg Cardif</title>
  </head>
  <body>
  <h1>KIMI-Plus - Buchungsbeleg Cardif</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Buchungsbeleg Cardif - Start: ".$heute;

$query = "
";


echo "<table border='1' cellspacing='1' cellpadding='5'";
echo "<tr><td><b>Report:<b> </td><td>Buchungsbeleg Pr&auml;mie Cardif</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>Buchungsbeleg Cardif 201307.pdf</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>monatlich</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>Paula K&uuml;hn, Katrin Rudolph, Livia Lorkowski</td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>

<b>Cardif-Pr&auml;mienlauf </b><br>
(wird von der Abteilung BH gefahren)
Kunden, welche den Kenner SP (Sorglospaket) gesetzt haben, wird zum Stichtag eine prozentuelle Versicherungspr&auml;mie mit BA 40/30 am Kundenkonto belastet.
<br><br>
<b>Pr&auml;miendatei kontrollieren</b><br>
Beim Monatswechsel wird von der IT eine Datei erzeugt, die alle diese Buchungen beinhaltet.
<br>
Diese Datei wird im Verzeichnis G / Kundenservice / FTRANS_GT unter dem Namen krsv_pr&auml;mienJJJJMMTThh.csv (z.B.: krvs_praemien201202119.csv) bereitgestellt.
<br>
Datei &ouml;ffnen &uuml;ber Spalte H (Pr&auml;mie) die Summe aller Buchungen bilden.

Diese Summe muss exakt mit dem nach Deutschland &uuml;bermittelten Wert aus dem Monatsbeleg (MDK03.xls) v. FIBU-Konto 13751090–087740 VERSICHERUNGSPR&auml;MIE &uuml;bereinstimmen.
Falls Differenzen auftreten, sind diese zu kl&auml;ren.
<br><br>

<b>Pr&auml;miendatei zippen und versenden</b><br>
Die Pr&auml;miendate (csv-Datei) zippen und mit Passwort 	&quot;Linz&quot; (Gro&szlig;-/ Kleinschreibung beachten) versehen
<br>
mit rechter Maustaste auf die Datei klicken
<br>
im Kontextmen&uuml; 7-zip – Add to archive …… ausw&auml;hlen
<br>
im darauf erscheinenden Dialogfeld Passwort 2x eingeben und mit OK best&auml;tigen
<br>
Die soeben erstellte ZIP-Datei wird zu Cardif gemailt
(datenmeldungen@cardif.com)
<br><br>
<b>Cardif-R&uuml;ckantwort abwarten</b><br>
Von Cardif wird die Provision (47,5% des o.a. Gesamtpr&auml;mienbetrags) ermittelt
(Dieser weicht aufgrund anderer Berechnungslogikleicht ab und ist immer im Cent-/Eutobereich niedriger als 47,5% vom Gesamtbetrag)
<br>
&uuml;ber diese Pr&auml;mienzahlung an Cardif ist ein Buchungsbeleg zu erstellen.
(kann durch Kopie einers alten Buchungsbeleges und Anpassen der Buchungsbeleg-Nummer, der &uuml;berweisungsbetr&auml;ge, des Gesamtbetrages und der Monatsbezeichnung erstellt werden)
<br>
Die Buchungsbelege befinden sich im Verzeichnis G / Kundenservice / Buchhaltung / Cardif (z.B. Buchungsbeleg Cardif201201.doc)
<br>

Der Ausdruck des Buchungsbeleges ist vom Aussteller und Hrn. Dr. Kocher zu unterschreiben.
<br>
Die oben erw&auml;hnte csv_Datei muss von G / Kundenservice/ FTRANS_GT im Verzeichnis G / Kundenservice / Buchhaltung / Cardif abgelegt werden.
<br><br><br>
<b>Anweisung an Cardif durchf&uuml;hren</b><br>
Wird &uuml;ber ELBA durchgef&uuml;hrt
<br>
Men&uuml; Zahlungsverkehr – Einzelauftrag
<br>
Im Dialogfeld Einzelauftrag kann &uuml;ber Button [Aus Vorlage laden] die dazu erstellte Vorlage aufgerufen werden.
(Damit m&uuml;ssen nicht alle Eingaben erneut durchgef&uuml;hrt werden)
<br>
Aus der Vorlageliste durch Doppelklick die Cardif-Vorlage &ouml;ffnen
<br>
Betrag und Monat/Jahr im Verwendungszweck anpassen und mit Button [Auftrag speichern] abschlie&szlig;en.
<br>
Auftrag befindet sich danach so wie ev. Bereits erfasste Einziehungserm&auml;chtigungen unter f&auml;llige Auftr&auml;ge.
<br>
Die Anweisung wird durch Eingabe der TAN f&uuml;r alle f&auml;lligen Auftr&auml;ge freigegeben.

Buchung ist am n&auml;chsten Tag in der Umsatz&uuml;bersicht als Buchungszeile ersichtlich.
<br><br>
<b>Buchungsbeleg nach Deutschland senden</b><br>
Unterschriebenen Buchungsbeleg einscannen und an folgenden Verteiler senden:
<br>
Lorkowski Livia, arvato infoscore <br>
Rudolph Katrin, arvato infoscore<br>
Paula Kuehn@Bertelsmann.de<br>
<br>
<b>Pr&auml;miensumme an Fr. Burgholzer &uuml;bermitteln</b><br>
Mitteilung an Fr. Burgholzer &uuml;ber den Gesamt-Monatsbeleg der gebuchten Versicherungspr&auml;mie
<br>


</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Buchungsbeleg Cardif - Ende: ".$heute;

?>
</body>    
</html>
