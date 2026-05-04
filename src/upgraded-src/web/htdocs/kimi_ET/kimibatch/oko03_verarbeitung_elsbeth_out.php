<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 16;

echo "<b>OKO_verarbeitung_elsbeth_out</b><br><br>";

// Prüfe Übergabeparameter für Abschluss
if (!isset($_GET['abschluss'])) {
	$abschluss = "N";
} else {
	//sollte J sein
	$abschluss = $_GET['abschluss'];
}

// 1. aktuelle Daten laden

$result = executeSQLLoader($dbconn, $mandant_id, "oko03_lade_daten_elsbeth.sql");

if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Laden der Daten OK<br>";
}
// 2. falsche Telefonnummern setzen
$result = executeSQLDML($dbconn, $mandant_id, "oko03_falsche_telefonnummern_setzen.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Falsche Telefonnummern setzen OK<br>";
}
// 2.1 LOG Eintrag für TELEFONAT-Gesprächszeitpunkt - MAN_START ANRUF
$result = executeSQLDML($dbconn, $mandant_id, "oko03_log_telefonat_start.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "LOG Telefonat START OK<br>";
}

// 2.2 LOG Eintrag für TELEFONAT-Gesprächszeitpunkt - MAN_ENDE ANRUF
$result = executeSQLDML($dbconn, $mandant_id, "oko03_log_telefonat_ende.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "LOG Telefonat ENDE OK<br>";
}
// 3. Aktuelle OKO-Logs auf verarbeitet setzen 
$result = executeSQLDML($dbconn, $mandant_id, "oko03_update_oko_log.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Aktuelle OKO-Logs auf verarbeitet setzen OK<br>";
}

/* dzt. nicht aktiv
// Prüfe Abschluss
if ($abschluss==="J") {
	$result = executeSQLDML($dbconn, $mandant_id, "");
	// 6. Abschluss
	$result = executeSQLDML($dbconn, $mandant_id, "oko03_6_tagesabschluss.sql");
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