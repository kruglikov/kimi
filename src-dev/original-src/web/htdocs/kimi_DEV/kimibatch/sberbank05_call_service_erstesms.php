<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_call_service_erstesms</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank05_select_service_erste_sms.sql", $query_replace);
if ($result !== false) {
	// Ausgabe automatisch durchführen lassen, Ausgabe als ANSI (letzter Parameter)
	$file = "SBERBANK_SERVICE_ERSTE_SMStmp".date("YmdHis").".csv";
	$count = exportQueryToCSV($result, $mandant_id, $file, true );
	if ($count === false ) {
		echo getLastError()."<br>";
		exit;
	}
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT).$file;
	/* ******** hier wäre die Variante um die Ausgabe selbst zu machen
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT )."SBERBANK_OUTBOUND_ELSBETH_ERSTESMSexp".date("Ymdm")."csv";
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


// SMS-SERVICE ausführen
// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank05_select_service_erste_sms.sql", $query_replace);
if ($result !== false) {
	$count = 0;		
	while ($line = dbFetchArray($result)) {
		$count = $count + 1;
		//
		if ($count > 1){ // Überschriftszeile nicht versenden
			
		echo "Nachname: ".$line['nachname']." KONTONUMMER: ".$line['aktnr']."<br>" ;
		
		// TICKET_SERVICE SMS
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = $line['aktnr'];
		$param[PARAM_BETRAG] = $line['ueberfaelligeraussenstand']; 
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "SMS_ERSTE_SMS.txt";
		$smstext = "";
		$http_sms = "";
		$serviceKontakt = "0043676845222500";

		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_SMS, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}

		echo "<br>NACH callServiceForTicket<br>";
		$smstext = "Bitte kontaktieren Sie uns zu Ihrer Verbindlichkeit zum KK:".$line['aktnr']." - zahlungshilfe@sberbank-collections.de";
    
		echo "AKTNR: ".$line['aktnr'];
		echo "<br>SMSTEXT: ".$smstext;

		$http_sms = "https://sms.inntelco.at/httpgateway.php?IDmandant=109&mandant=KIMIPLUS&smstext=".$smstext."&rufnummer=".$line['telefon1']."&optsend=12";

		
		echo $http_sms."<br><br>";


		$ergebnis = "callServiceForTicket: ".$retCallServiceForTicket." RetCode= ".$retCode." RetMessage= ".$retMessage; 

		// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
		// -- #  Status "erledigt" und Anruf_Status und Ergebnis ... setzen
		$query_replace[PLACEHOLDER_SQL_TICKETID] = $line['kontaktid'];
		$query_replace[PLACEHOLDER_SQL_ERGEBNIS] = $ergebnis." ".$http_sms;
		$result2 = executeSQLDML($dbconn, $mandant_id, "sberbank05_update_status_erledigt_erstesms.sql", $query_replace);		 
		if ($result2) {
			 echo "<br><br>UPDATE TICKET STATUS auf ERLEDIGT ERSTE SMS durchgef&uuml;hrt"."<br>";
		} else {			 
			 echo "<br><br>UPDATE TICKET STATUS auf ERLEDIGT ERSTE SMS: ".getLastError()."br>";
		}

		}
	}
} else {
	echo getLastError()."<br>";
	exit;
}

echo "<br><b>FERTIG</b><br><br>";

dbClose($dbconn);

?>