<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 18;

echo "<b>inko2016_update_ratenhinweise</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

$result = executeSQLDML($dbconn, $mandant_id, "inko201605_update_ratenhinweise.sql");
if ($result) {
	echo "<br><br>UPDATE RATENHINWEISE  durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE RATENHINWEISE  knp1duplet: ".getLastError();
	exit;
}

echo $count." Datensätze nach ".$file." umgestellt<br>";

echo "<br><b>FERTIG</b><br><br>"

?>