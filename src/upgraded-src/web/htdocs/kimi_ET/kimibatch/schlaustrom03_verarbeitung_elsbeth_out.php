<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 27;

echo "<b>SCHLAUSTROM_verarbeitung_elsbeth_out</b><br><br>";

// Prüfe Übergabeparameter für Abschluss
if (!isset($_GET['abschluss'])) {
	$abschluss = "N";
} else {
	//sollte J sein
	$abschluss = $_GET['abschluss'];
}

// 1. aktuelle Daten laden

$result = executeSQLLoader($dbconn, $mandant_id, "schlaustrom03_lade_daten_elsbeth.sql");

if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Laden der Daten OK<br>";
}
// 2. falsche Telefonnummern setzen
$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom03_falsche_telefonnummern_setzen.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Falsche Telefonnummern setzen OK<br>";
}
// 3. Aktuelle SCHLAUSTROM-Logs auf verarbeitet setzen 
$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom03_update_schlaustrom_log.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Aktuelle SCHLAUSTROM-Logs auf verarbeitet setzen OK<br>";
}

/* dzt. nicht aktiv
// Prüfe Abschluss
if ($abschluss==="J") {
	$result = executeSQLDML($dbconn, $mandant_id, "");
	// 6. Abschluss
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom03_6_tagesabschluss.sql");
	if (!$result) {
		echo getLastError();
		exit;
	} else {
		echo "Tagesabschluss OK<br>";
	}

}

*/
echo "<br><b>FERTIG</b><br><br>"

?>