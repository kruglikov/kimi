<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_export_outbound_elsbeth_ersterAnruf</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank02_select_elsbeth_import_ersteranruf.sql", $query_replace);

if ($result !== false) {
	// Ausgabe automatisch durchführen lassen, Ausgabe als ANSI (letzter Parameter)
	$file = "SBERBANK_OUTBOUND_ELSBETH_ERSTERANRUFexp".date("YmdHis").".csv";
	
	$count = exportQueryToCSV($result, $mandant_id, $file, true );
	//echo "file=".$file. ", count=".$count;
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



//-- #  Status "in Bearbeitung" und Anruf_Status auf "in Elsbeth - Powerdialing" setzen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank02_update_status_in_Arbeit_ersteranruf.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET STATUS auf in Arbeit ERSTER ANRUF durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET STATUS auf in Arbeit  ERSTER ANRUF: ".getLastError();
//	exit;
}


echo "<br><b>FERTIG</b><br><br>";

dbClose($dbconn);
?>