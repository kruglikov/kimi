<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 16;

echo "<b>oko_mehrfach_tickets_anzeigen</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "oko04_select_mehrfach_tickets.sql", $query_replace);
if ($result !== false) {
		$count = 0;		
		while ($line = dbFetchArray($result)) {
			$count = $count + 1;
			$lineFile = getCSVLineFromArray( $line )."\n";
			
			if ($lineFile !== false) {
				//echo $lineFile."<br>";
				echo $line['nachname']." / ".$line['ticketnr']." / ".$line['aktnr']."\n"."<BR>";
			}
		}
	
} else {
	echo getLastError()."<br>";
	exit;
}

echo $count." Datensätze nach ".$file." exportiert<br>";

echo "<br><b>FERTIG</b><br><br>"

?>