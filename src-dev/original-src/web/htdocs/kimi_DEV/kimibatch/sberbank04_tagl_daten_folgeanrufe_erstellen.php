<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_tagl_daten_folgeanrufe_erstellen</b><br><br>";


//
//-- #  aus den unerreichten erste Anrufen FOLGE ANRUFE machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank04_select_ticket_folge_anruf.sql");
if ($result) {
	echo "<br><br>SELECT FOLGE ANRUFE durchgef&uuml;hrt";
} else {
	echo "<br><br>SELECT FOLGE ANRUFE : ".getLastError();
//	exit;
}

//-- #  aus den unerreichten erste Anrufen FOLGE ANRUFE machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank04_insert_ticket_folge_anruf.sql");
if ($result) {
	echo "<br><br>INSERT FOLGE ANRUFE durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT FOLGE ANRUFE : ".getLastError();
//	exit;
}

//-- #  aus den unerreichten erste Anrufen FOLGE ANRUFE machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank04_drop_work_folge_anruf.sql");
if ($result) {
	echo "<br><br>DROP WORKTABELLE FOLGE ANRUFE durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP WORKTABELLE ANRUFE : ".getLastError();
//	exit;
}



echo "<br><b>FERTIG</b><br><br>";

dbClose($dbconn);

?>