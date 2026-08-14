<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_tagl_daten_ptp</b><br><br>";


//
//-- #  aus an einem am Unterticket vermerkten PTP Zahlungserinnerungen etc. & mehr machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_select_ticket_ptp.sql");
if ($result) {
	echo "<br><br>SELECT Tickets mit PTP durchgef&uuml;hrt";
} else {
	echo "<br><br>SELECT Tickets mit PTP : ".getLastError();
//	exit;
}

//-- #  Die Daten der PTP auf das Hauptticket schreiben
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_update_ptp_hauptticket.sql");
if ($result) {
	echo "<br><br>UPDATE Hauptticket PTP durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE Hauptticket PTP : ".getLastError();
//	exit;
}


//-- #  Update Unterticket - z.B. das Feld Feld Leistungsanstoß auf ".. gesetzt" setzen 
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_update_ptp_unterticket.sql");
if ($result) {
	echo "<br><br>Update Unterticket PTP durchgef&uuml;hrt";
} else {
	echo "<br><br>Update Unterticket  PTP : ".getLastError();
//	exit;
}

//-- #  aus den PTP's Ticket für Bestaetiguns-Email machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_insert_ticket_ptp_bestaetigung_email.sql");
if ($result) {
	echo "<br><br>INSERT PTP Bestaetigung EMail durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT Bestaetigung EMail : ".getLastError();
//	exit;
}

//-- #  aus den PTP's Ticket für Erinnerung-Email machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_insert_ticket_ptp_erinnerung_email.sql");
if ($result) {
	echo "<br><br>INSERT PTP Erinnerung EMail durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT Erinnerung EMail : ".getLastError();
//	exit;
}

//-- #  aus den PTP's Ticket für Erinnerung-SMS machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_insert_ticket_ptp_erinnerung_sms.sql");
if ($result) {
	echo "<br><br>INSERT PTP Erinnerung SMS durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT Erinnerung SMS : ".getLastError();
//	exit;
}


//-- #  aus den PTP's Ticket für Erinnerung-SMS machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_insert_ticket_ptp_erinnerung_outbound.sql");
if ($result) {
	echo "<br><br>INSERT PTP Erinnerung OUTBOUND durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT Erinnerung OUTBOUND : ".getLastError();
//	exit;
}


//-- #  aus den PTP's Ticket für Erinnerung-SMS machen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_insert_ticket_ptp_pruefung_ptp.sql");
if ($result) {
	echo "<br><br>INSERT PTP Prüfung PTP durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT PTP Prüfung PTP: ".getLastError();
//	exit;
}

//-- #  Zwischentabelle wieder droppen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank08_drop_work_ptp.sql");
if ($result) {
	echo "<br><br>DROP WORKTABELLE PTP durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP WORKTABELLE PTP : ".getLastError();
//	exit;
}



echo "<br><b>FERTIG</b><br><br>";

dbClose($dbconn);

?>