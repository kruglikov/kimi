<html>
  <head>
     <title>KIMI-Plus - Inkassorechnungen drucken</title>
  </head>
  <body>
  <h1>KIMI-Plus - Inkassorechnungen drucken</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Inkassorechnungen drucken - Start: ".$heute;

$query = "
";


echo "<table border='1' cellspacing='1' cellpadding='5'";
echo "<tr><td><b>Report:<b> </td><td>Inkassorechnungen drucken</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>:\Kundenservice\Korrespondenz\Rechnungen\CdrgsuchAuto.xls</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>auf Anforderung</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>Infoscore Wien</td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>

Makroname: :\Kundenservice\Korrespondenz\Rechnungen\CdrgsuchAuto.xls
Verwendung: Monatlich und bei Bedarf
<br><br>
In der Arbeitsmappe Kunden werden in Spalte A (ab Zelle A2) durchgehend die Kundennummern angeführt, zu denen in weiterer Folge die zugehörigen Rechnungen gestellt werden sollen. Die Spalte PNF ist ohne Bedeutung. Das Makro zur Rechnungsergänzung wird mit der Schaltfläche [START] gestartet.
<br><br>
Daraufhin wird eine SQL-Abfrage gestartet (siehe Arbeitsmappe SQL) und folgende Daten für diese Kundennummern in Arbeitsmappe Rechnungen gestellt:
Kdnr., Rechnungsnr., Datum, RA
Die Spalte PNF ist wiederum ohne Bedeutung.
<br><br>
Nun wird die eingentliche Rechnungssuche über die Schaltfläche [Rechnungssuche] gestartet. Dafür muss vorher die Kodak-Rechnungsrecherchesoftware aus dem Windows-Menü Start – Programme – Versand-RG gestartet werden (C:\FULTEMP\RETRIEVE.EXE). Es darf keine Sammlung geöffnet sein und Programme, die Fenster automatisch öffnen (z.B. Outlook) müssen geschlossen werden. Im Dialogfeld Rchungssuche über CD die Option „in Datei“ anwählen und mit OK bestätigen.
<br><br>
Nach dem Betätigen der Schaltfläche [Rechnungssuche] beginnt das Makro Tastatureingaben über die Kodak-Recherchesoftware zu simulieren und die gewünschten Rechnungen aus den archivierten Rechnungs-CD´s zu suchen. Die Rechnungsdaten werden dabei in txt-Dateien in das Verzeichnis G:\Kundenservice\Korrespondenz\Rechnungen\Archiv je Inkassopartner geschrieben. Ist kein Inkassopartner vorhanden (z. B. bei Ncht-IK-Kunden) wird der Dateiname ra00_01.txt vergeben. 01 steht für die fortlaufende Nummer. Bei einem weiteren Programmstart wird diese um 1 erhöht.
<br><br>
Programmstartzeitpunkt und –endezeitpunkt sowie die Anzahl der Rechnung und nicht gefundene Rechnungen werden in der Arbeitsmappe Protokoll protokolliert und können von dort ausgedruckt bzw. manuell weiterverarbeitet werden. Gleichzeitig wird das fortlaufende Protokoll unter G:\Kundenservice\Korrespondenz\Rechnungen\prot.txt um diese Daten ergänzt.
</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Inkassorechnungen drucken - Ende: ".$heute;

?>
</body>    
</html>
