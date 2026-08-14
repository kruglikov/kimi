<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_call_service_test_sms</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei


echo $count." Datensätze nach ".$file." exportiert<br>";


// SMS-SERVICE ausführen
		
		// TICKET_SERVICE SMS - ERSTE SMS
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = "49-9-1644426480-550";
		$param[PARAM_BETRAG] = "599,81";
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
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
    
		echo "<br>SMSTEXT: ".$smstext;


		
		// TICKET_SERVICE SMS - FOLGE SMS
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = "49-9-1644426480-550";
		$param[PARAM_BETRAG] = "599,81";
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "SMS_FOLGE_SMS.txt";
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
		$smstext = "Wir konnten Sie nicht erreichen-bitte kontaktieren Sie uns zu Ihrer Verbindlichkeit KK: 49-9-1644426480-550 - zahlungshilfe@sberbank-collections.de, Tel. NR: +49 69 50958953";
    
		echo "<br>SMSTEXT: ".$smstext;


		// TICKET_SERVICE SMS - ABSCHLUSS SMS
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = "49-9-1644426480-550";
		$param[PARAM_BETRAG] = "599,81";
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "SMS_ABSCHLUSS_SMS.txt";
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
		$smstext = "Ihre Kreditrate ist überfällig! Bitte bezahlen Sie Ihre Rate sofort ein, oder rufen Sie uns an: "."+49 69 50958953".". Ihr Kredit wird sonst gesamt fällig gestellt!";
    
		echo "<br>SMSTEXT: ".$smstext;

		// TICKET_SERVICE SMS - PTP ERINNERUNG SMS
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = "49-9-1644426480-550";
		$param[PARAM_BETRAG] = "599,81";
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "SMS_PTP_ERINNERUNG_SMS.txt";
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
		$smstext = "Die vereinbarte Kreditrate ist heute fällig. Bitte zahlen Sie die überfällige Rate sofort ein oder Tel.NR: "."+49 69 50958953".". Vermeiden Sie weitere Schritte.";
    
		echo "<br>SMSTEXT: ".$smstext;



echo "<br><b>FERTIG</b><br><br>";
dbClose($dbconn);

?>