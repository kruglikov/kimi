<?php

include ("kimi_general.php");

//$header="IndexA;IndexB-Indiv;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;TelNr-Apl;Arb.Platz;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;nächster Schritt;VerzZinsen;Inko-Sb-Name;Inko-Sb-Mail;Inko-Sb-TelNr;Ratenhöhe;Raten-Fälligkeit;Dat.le.Zahlung;Betrag le.Zahlung";
// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

$mandant_id = 16;

//echo $_GET('abschluss');

if (!isset($_GET['abschluss'])) {
	$abschluss = "N";
} else {
	//sollte J sein
	$abschluss = $_GET['abschluss'];
}

// Test exportTicketToService($dbconn, $service, $mandantId, $ticketId, $param, $convertToAnsi=false )

// zum Test
$mandant_id = 43;
$ticket_id = 986113;
$ticket_id = 1;

// Parameter festlegen
$param[PARAM_VERTRAGSNUMMER] = "12345";
$param[PARAM_BETRAG] = "100,20";

// Parameter für Textersatz festlegen
$param[PARAM_VERTRAGSNUMMER] = "4711";
$param[PARAM_BETRAG] = "100,90"; 
$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 

$param[PARAM_KONTAKT_TELNR] = "0732/12345"; 
$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT";

$param[PARAM_EMAIL_FROM] = "kundenservice@kimi-plus.at";
$param[PARAM_EMAIL_FROM_NAME] = "Kundenservice";

$template = "SMS_ERSTE_SMS.txt";
$template = "Muster-E-Mail-SBERBANK.html";

$retCode = "";
$retMessage = "";
// Test Mail
if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage, "office@aberl.at", "Ronald Aberl" ) ) {
	echo "Retcode=".$retCode."\n";
	echo "RetMsg=".$retMessage."\n";
} else {
	echo getLastError();
}
exit;

// Test SMS
$template = "SMS_ERSTE_SMS.txt";
//exit;
if (callServiceForTicket($dbconn, TICKET_SERVICE_SMS, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage, "+436606590009"  ) ) {
	echo "Retcode=".$retCode."\n";
	echo "RetMsg=".$retMessage."\n";
} else {
	echo getLastError();
}
exit;

//echo "RetCode=".$retCode."\n";
//echo "RetMsg=".$retMessage."\n";

//echo "\ndir".CONF_SUBDIR_INPUT;
//exit;

/*
$out = loadCSVData(1,"INKO2016.CSV", ";", true, true, true, $headerCSV);

if ($out===null) {
	echo getLastError();
	exit;
}


foreach($out as $x => $row ) {
	//&echo "row=".$row[1]."\n";
	// do anything with row
	echo($row[1]."\n" );
}

*/
// test SQL-Statement


// 1. aktuelle Daten laden


$result = executeSQLLoader($dbconn, $mandant_id, "1_lade_daten_elsbeth.sql");

if (!$result) {
	echo getLastError();
	exit;
} else {
	echo "Laden ok<br>";
} 
exit;

// Test SQL-Query

//mysql_set_charset('utf8');

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_TICKETID] = "12345";
$query_replace[PLACEHOLDER_SQL_MANDANT] = "16";
$result = executeSQLDML($dbconn, $mandant_id, "testdml2.sql", $query_replace);
echo getLastError();
exit;
// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "testschlaustrom.sql", $query_replace);
if ($result !== false) {
	// Ausgabe automatisch durchführen lassen
	$count = exportQueryToCSV($result, $mandant_id, "schlau2".date("Ymdm")."csv", true);
	if ($count === false ) {
		echo getLastError()."\n";
		exit;
	}
	/* ******** hier wäre die Variante um die Ausgabe selbst zu machen
	$file = getFilePath(40, CONF_SUBDIR_OUTPUT )."COEO_OUTBOUND_ELSBETHexp".date("Ymdm")."csv";
	$fh = fopen($file, "w");
	if ($fh !== false) {
		$count = -1;		// wegen Header-Zeile
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
	echo getLastError()."\n<br>";
	exit;
}
echo "Anzahl: ".$count." Datensätze exportiert\n\n";

// 3. 

// Prüfe Abschluss
if ($abschluss==="J") {
	$result = executeSQLDML($dbconn, $mandant_id, "");
}


?>