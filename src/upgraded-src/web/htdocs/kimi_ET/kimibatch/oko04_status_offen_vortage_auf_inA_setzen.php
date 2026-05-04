<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 16;

echo "<b>inkode_status_offen_Vortage_inA_setzen</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "oko04_select_status_offen_vortage.sql", $query_replace);
if ($result !== false) {
		$count = 0;		
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$count = $count + 1;
			$lineFile = getCSVLineFromArray( $line )."\n";
			echo $lineFile;
		}
		echo "Anzahl: ".$count." Datensätze gefunden\n\n<BR>";
} else {
	echo getLastError()."<br>";
	exit;
}


$result = executeSQLDML($dbconn, $mandant_id, "oko04_update_status_offen_vortage_in_arbeit.sql");
if ($result) {
	echo "<br><br>UPDATE STATUS durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE STATUS knp1duplet: ".getLastError();
	exit;
}

echo $count." Datensätze nach ".$file." umgestellt<br>";

echo "<br><b>FERTIG</b><br><br>"

?>