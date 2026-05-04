<?php

include ("kimi_general.php");

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 27;

$heute = date("d.m.Y H:i:s");    
echo "SCHLAUSTROM1 IMPORT - Start: ".$heute;
echo "<br><b>schlaustrom_import_telefonie_taeglich</b><br><br>";

// wird dies wirklich benötigt, $id wird auf 0 gesetzt?????
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =27 and kampagne_id <>99";

$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query_id);

if (!$result){
	echo getLastError();
	exit;
}

$id = $result['id'];

// IMPORT-Datei laden

if (executeSQLLoader($dbconn, $mandant_id, "schlaustrom01_load_schlaustrom.sql")) {
	echo "<br><br>LOAD Schlaustrom durchgef&uuml;hrt<br>";
} else {
	echo "<br><br>LOAD Schlaustrom in database: ".getLastError();
	exit;
}

// Query absetzen - Daten nochmals ausgeben zur Kontrolle
$result = executeSQLQuery($dbconn, $mandant_id, "schlaustrom01_select_import_schlaustrom.sql", $query_replace);
if ($result !== false) {
		while ($line = dbFetchArray($result)) {
			$count = $count + 1;
			$lineFile = getCSVLineFromArray( $line )."\n";
			
			echo "Satz ".$count." :".$lineFile."<br>";
		}
		echo "Anzahl: ".$count." Datensätze importiert\n\n"."<br>";

} else {
	echo getLastError()."<br>";
	exit;
}
$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Update Telefon 1    : ".$heute;
//
// #1 Update Telefon 1 - setzen führende "00" --> "0043..:"
	// Update Telefon 1   - Table Schlaustrom
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_update_telefon1_schlaustrom.sql");
	if ($result) {
		echo "<br><br>UPDATE TELEFON 1 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error UPDATE TELEFON 2 in database: ".getLastError();
		exit;
	}


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Update Telefon 2    : ".$heute;
//
	
// #2 Update Telefon 2 - HANDY - setzen führende "00" --> "0043..:"
	// Update Telefon 2   - Table Schlaustrom
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_update_telefon2_schlaustrom.sql");
	if ($result) {
		echo "<br><br>UPDATE TELEFON 2 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error UPDATE TELEFON 2 in database: ".getLastError();
		exit;
	}

$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Insert neue Schlaustrom-Datensätze in Ticket-Tabelle   : ".$heute;
//
		
// #3 Insert neue Schlaustrom-Datensätze in Ticket-Tabelle
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_insert_schlaustrom_in_ticket.sql");
	if ($result) {
		echo "<br><br>INSERT SCHLAUSTROM IN TICKET durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error INSERT SCHLAUSTROM IN TICKET in database: ".getLastError();
		exit;
	}


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Belieferungsstatus in TICKET.ERGEBNIS eintragen   : ".$heute;
//
	
// #4 Belieferungsstatus in TICKET.ERGEBNIS eintragen
	// Update Ergebnis mit Belieferungsstatus IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_update_ergebnis_mit_belieferungstatus.sql");
	if ($result) {
		echo "<br><br>UPDATE ERGEBNIS mit Belieferungstatus durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error UPDATE ERGEBNIS mit Belieferungstatus in database: ".getLastError();
		exit;
	}


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Dupletten #1  drop table schlaustrom_duplet  : ".$heute;
//
		
// #5 Dupletten #1 
	// drop table schlaustrom_duplet
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_drop_table schlaustrom_duplet#1.sql");
	if ($result) {
		echo "<br><br>drop table schlaustrom_duplet #1 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error drop table schlaustrom_duplet #1 in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Dupletten #1   create table schlaustrom_duplet  : ".$heute;
//


// #6 Dupletten #1 
	// create table schlaustrom_duplet
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_create_table_schlaustrom_duplet#1.sql");
	if ($result) {
		echo "<br><br>create table schlaustrom_duplet#1 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error create table schlaustrom_duplet #1  in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Dupletten #2   drop table schlaustrom_duplet  : ".$heute;
//

// #7 Dupletten #2 
	// drop table schlaustrom_duplet
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_drop_table schlaustrom_duplet#2.sql");
	if ($result) {
		echo "<br><br>drop table schlaustrom_duplet #2 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error drop table schlaustrom_duplet #2 in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Dupletten #2   create table schlaustrom_duplet : ".$heute;
//


// #8 Dupletten #2 
	// create table schlaustrom_duplet
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_create_table_schlaustrom_duplet#2.sql");
	if ($result) {
		echo "<br><br>create table schlaustrom_duplet#2 durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error create table schlaustrom_duplet #2  in database: ".getLastError();
		exit;
	}	



$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - Update Schuldner mehrfach : ".$heute;
//



// #9 Update Schuldner mehrfach
	// Update Schuldner mehrfach
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_update_schuldner_mehrfach.sql");
	if ($result) {
		echo "<br><br>Update Schuldner mehrfach durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error Update Schuldner mehrfach  in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - truncate schlaustromurgenz : ".$heute;
//



// #10 truncate schlaustromurgenz
	// truncate schlaustromurgenz
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_truncate_schlaustromurgenz.sql");
	if ($result) {
		echo "<br><br>truncate schlaustromurgenz durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error truncate schlaustromurgenz  in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - truncate schlaustromurgenz : ".$heute;
//



// #11 insert schlaustromurgenz 
	// insert into schlaustromurgenz
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_insert_schlaustromurgenz.sql");
	if ($result) {
		echo "<br><br>insert into schlaustromurgenz  durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert into schlaustromurgenz in database: ".getLastError();
		exit;
	}	


$heute = date("d.m.Y H:i:s");    
echo "<br>SCHLAUSTROM  IMPORT - update ticket schlaustromurgenz : ".$heute;
//



// #12 update ticket schlaustromurgenz
	// update ticket schlaustromurgenz
	$result = executeSQLDML($dbconn, $mandant_id, "schlaustrom01_update_ticket_schlaustromurgenz.sql");
	if ($result) {
		echo "<br><br>update ticket schlaustromurgenz durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error update ticket schlaustromurgenz in database: ".getLastError();
		exit;
	}	

echo "<br><br>"."SCHLAUSTROM IMPORT - Ende: ".$heute;

// mysql_close();

dbClose($dbconn);

?>