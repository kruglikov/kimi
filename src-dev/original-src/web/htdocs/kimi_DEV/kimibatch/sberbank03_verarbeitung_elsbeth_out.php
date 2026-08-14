<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>knp_verarbeitung_elsbeth_out</b><br><br>";

// Prüfe Übergabeparameter für Abschluss
if (!isset($_GET['abschluss'])) {
	$abschluss = "N";
} else {
	//sollte J sein
	$abschluss = $_GET['abschluss'];
}

// 1. aktuelle Daten laden

$result = executeSQLLoader($dbconn, $mandant_id, "sberbank03_1_lade_daten_elsbeth.sql");

if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Laden der Daten OK<br>";
}

// 2. Vermerk Ergebnisse der Anrufe in Ticket
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_2_vermerk_ergebnisse_anrufe.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Vermerk Ergebnisse der Anrufe OK<br>";
}

// 3. erreichte auf Erledigt und erreicht setzen 
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_3_erreichte_auf_erledigt.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Erreichte auf erledigt und ereicht setzten OK<br>";
}

// 4. falsche Telefonnummern setzen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_4_falsche_telefonnummern_setzen.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Falsche Telefonnummern setzen OK<br>";
}


// 4. unerreichreichte auf erledigt unterreicht setzen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_4_nichterreichte_auf_unerreichterledigt.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "unerreichte auf Erledigt unerreicht setzen OK<br>";
}

// 4.1 LOG Eintrag für TELEFONAT-Gesprächszeitpunkt - MAN_START ANRUF
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_log_telefonat_start.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "LOG Telefonat START OK<br>";
}

// 4.2 LOG Eintrag für TELEFONAT-Gesprächszeitpunkt - MAN_START ANRUF
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_log_telefonat_ende.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "LOG Telefonat ENDE OK<br>";
}

// 5. Aktuelle KNP-Logs auf verarbeitet setzen 
$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_5_update_sberbank_log.sql");
if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Aktuelle SBERBANK-Logs auf verarbeitet setzen OK<br>";
}


// Prüfe Abschluss
if ($abschluss==="J") {
	$result = executeSQLDML($dbconn, $mandant_id, "");
	// 6. Abschluss
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank03_6_tagesabschluss.sql");
	if (!$result) {
		echo getLastError();
		exit;
	} else {
		echo "Tagesabschluss OK<br>";
	}

}

echo "<br><b>FERTIG</b><br><br>";

//20220228/ar
dbClose($dbconn);
?>