<html>
  <head>
     <title>KIMI-Plus - Verwaltungsatz planen</title>
  </head>
  <body>
  <h1>KIMI-Plus - Verwaltungsatz planen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Verwaltungsatz planen - Start: ".$heute;

$query = "
";

echo "<br><br><b><font color='#FF0000'>ACHTUNG:</font><br></b>";
echo "<br><br><b><font color='#FF0000'>F&uuml;r den ersten Verwaltungssatz muss der Anfangssaldo SALDO_GESAMT neu gesetzt werden</font></b><br>";


echo "<table border='1' cellspacing='1' cellpadding='5'>";
echo "<tr><td><b>Report:<b> </td><td>Verwaltungssatz aufbauen</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>Script</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>einmal w&ouml;chentlich</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>KIMI-Plus</td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>
<br>
neuen Verwaltungssatz aufbauen 1 x w&ouml;chentlich planen<br>
Planung und Abstimmung am Freitag JF<br>
<br>
Verwaltungssatz ist auch gleich Planung f&uuml;r die Abl&auml;ufe - max. 5 Stichtage pro Buchungstag, Tage k&ouml;nnen im Vorfeld aufgebaut werden.<br>
Kennzeichnungen KZ_AKUTELL: P = Plan, J=Aktuell X=Neuer , naechster Verwaltungssatz<br>
INSERT INTO `verwaltungssatz` ( `mandant_id`, `markt`, `kz_aktuell`, `buchungsdatum`, `saldo_gesamt`, `saldo_tag`, `geaendert_am`, `geaendert_von`) VALUES<br>
( 1, 10, 'X', '2013-10-31', NULL, NULL, NOW(), 'System'),<br>
( 1, 21, 'X', '2013-10-31', NULL, NULL, NOW(), 'System');<br>
<br><br>
INSERT INTO `verwaltungssatz` ( `mandant_id`, `markt`, `kz_aktuell`, `buchungsdatum`, `saldo_gesamt`, `saldo_tag`, `geaendert_am`, `geaendert_von`) VALUES<br>
( 1, 10, 'P', '2013-11-01', NULL, NULL, NOW(), 'System'),<br>
( 1, 21, 'P', '2013-11-01', NULL, NULL, NOW(), 'System');<br>
<br><br>
INSERT INTO `verwaltungssatz` ( `mandant_id`, `markt`, `kz_aktuell`, `buchungsdatum`, `saldo_gesamt`, `saldo_tag`, `geaendert_am`, `geaendert_von`) VALUES<br>
( 1, 10, 'P', '2013-11-04', NULL, NULL, NOW(), 'System'),<br>
( 1, 21, 'P', '2013-11-04', NULL, NULL, NOW(), 'System');<br>
<br><br>
</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Verwaltungsatz planen - Ende: ".$heute;

?>
</body>    
</html>
