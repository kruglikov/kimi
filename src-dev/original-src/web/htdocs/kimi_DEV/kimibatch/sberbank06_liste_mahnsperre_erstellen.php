<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_Liste_Mahnsperre_erstellen</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank06_select_liste_mahnsperre.sql", $query_replace);
if ($result !== false) {
	// Ausgabe automatisch durchführen lassen, Ausgabe als ANSI (letzter Parameter)
	$file = "SBERBANK_LISTE_MAHNSPERREexp".date("YmdHis").".csv";
	$count = exportQueryToCSV($result, $mandant_id, $file, true );
	if ($count === false ) {
		echo getLastError()."<br>";
		exit;
	}
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT).$file;
	/* ******** hier wäre die Variante um die Ausgabe selbst zu machen
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT )."SBERBANK_OUTBOUND_ELSBETH_ERSTERANRUFexp".date("Ymdm")."csv";
	$fh = fopen($file, "w");
	if ($fh !== false) {
		$count = 0;		
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$count = $count + 1;
			$lineFile = getCSVLineFromArray( $line )."\n";
			
			if ($lineFile !== false) {
				fwrite($fh, $lineFile);
			}
		}
		fclose($fh);
		echo "Anzahl: ".$count." Datensätze exportiert\n\n";
	} else {
		echo "Fehler beim Erstellen der Datei ".$file;;
		exit;
	}
*/
} else {
	echo getLastError()."<br>";
	exit;
}

echo $count." Datensätze nach ".$file." exportiert<br>";



echo "<br><b>FERTIG</b><br><br>"

?>