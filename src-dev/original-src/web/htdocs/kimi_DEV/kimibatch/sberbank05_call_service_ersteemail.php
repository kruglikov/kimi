<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_call_service_ersteemail</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";


// Ausgabe als FILE - als Sicherung 
// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank05_select_service_erste_email.sql", $query_replace);
if ($result !== false) {
	// Ausgabe automatisch durchführen lassen, Ausgabe als ANSI (letzter Parameter)
	$file = "SBERBANK_SERVICE_ERSTE_EMAILtmp".date("YmdHis").".csv";
	$count = exportQueryToCSV($result, $mandant_id, $file, true );
	if ($count === false ) {
		echo getLastError()."<br>";
		exit;
	}
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT).$file;
	/* ******** hier wäre die Variante um die Ausgabe selbst zu machen
	$file = getFilePath($mandant_id, CONF_SUBDIR_OUTPUT )."SBERBANK_OUTBOUND_ELSBETH_ERSTEEMAILexp".date("Ymdm")."csv";
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

// EMAIL-SERVICE ausführen
// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank05_select_service_erste_email.sql", $query_replace);
if ($result !== false) {
	$count = 0;		
	while ($line = dbFetchArray($result)) {
		$count = $count + 1;
		//
		if ($count > 1){ // Überschriftszeile nicht versenden
					
		echo "<br"."Nachname: ".$line['nachname']." KONTONUMMER: ".$line['aktnr']."<br>" ;
		

		// TICKET_SERVICE EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = $line['aktnr'];
		$param[PARAM_BETRAG] = $line['ueberfaelligeraussenstand']; 
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		if ( $line['anrede']=='Herr') 
		{
			$param[PARAM_ANREDE_SGH] = "r"; 
		} else {
			if ( $line['anrede']=='Frau') 
			{
				$param[PARAM_ANREDE_SGH] = ""; 
			} else {				
				$param[PARAM_ANREDE_SGH] = "(r)"; 			
			}			

		}

		$param[PARAM_ANREDE] = $line['anrede'];		
		$param[PARAM_NACHNAME] = $line['nachname'];		
		$param[PARAM_NAME] = $line['nachname'];				

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		// $template = "EMAIL_ERSTE_EMAIL.html";
		$template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CCNAME] = "Ronald Aberl";
		$email_from = 'Franz Tausch';
		



		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt,$email_from ) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}

		echo "<br>NACH callServiceForTicket<br>";

		$ergebnis = "callServiceForTicket: ".$retCallServiceForTicket." RetCode= ".$retCode." RetMessage= ".$retMessage; 

		// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
		// -- #  Status "erledigt" und Anruf_Status und Ergebnis ... setzen
		$query_replace[PLACEHOLDER_SQL_TICKETID] = $line['kontaktid'];
		$query_replace[PLACEHOLDER_SQL_ERGEBNIS] = $ergebnis." gesendet an: ".$line[email];
		$result2 = executeSQLDML($dbconn, $mandant_id, "sberbank05_update_status_erledigt_ersteemail.sql", $query_replace);		 
		if ($result2) {
			 echo "<br><br>UPDATE TICKET STATUS auf ERLEDIGT ERSTE EMAIL durchgef&uuml;hrt"."<br>";
		} else {			 
			 echo "<br><br>UPDATE TICKET STATUS auf ERLEDIGT ERSTE EMAIL: ".getLastError()."<br>";
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