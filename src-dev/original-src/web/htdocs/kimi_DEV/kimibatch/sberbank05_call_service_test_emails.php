<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_call_service_test_emails</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

		
		// TICKET_SERVICE EMAIL  - ERSTE EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = '49-9-1644426480-550';;
		$param[PARAM_BETRAG] = '599,81'; 
		$param[PARAM_VEREINBARTER_PTP] = '22.02.2022'; 		
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$param[PARAM_ANREDE_SGH] = "r"; 

		$param[PARAM_ANREDE] = 'Herr';
		$param[PARAM_NACHNAME] = 'Franz Tausch';		
		$param[PARAM_NAME] = 'Tausch';				
		$param[PARAM_MANDANT_IBAN ] = 'DE12300200001234567890';				
		$param[PARAM_MANDANT_BIC] = 'SEZDDEF1XXX';				


		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "EMAIL_ERSTE_EMAIL.html";
		// $template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT ERSTE EMAIL";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CC_NAME] = "Ronald Aberl";
		$email_from = 'Franz Tausch';
		



		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt,$email_from ) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}
		
		// TICKET_SERVICE EMAIL  - FOLGE EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = '49-9-1644426480-550';;
		$param[PARAM_BETRAG] = '599,81'; 
		$param[PARAM_VEREINBARTER_PTP] = '22.02.2022'; 		
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$param[PARAM_ANREDE_SGH] = "r"; 

		$param[PARAM_ANREDE] = 'Herr';
		$param[PARAM_NACHNAME] = 'Franz Tausch';		
		$param[PARAM_NAME] = 'Tausch';			
		$param[PARAM_MANDANT_IBAN ] = 'DE12300200001234567890';				
		$param[PARAM_MANDANT_BIC] = 'SEZDDEF1XXX';				

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "EMAIL_FOLGE_EMAIL.html";
		// $template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT FOLGE EMAIL";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CC_NAME] = "Ronald Aberl";
		$email_from = 'Franz Tausch';
		



		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt,$email_from ) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}
		
		// TICKET_SERVICE EMAIL  - ABSCHLUSS EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = '49-9-1644426480-550';;
		$param[PARAM_BETRAG] = '599,81'; 
		$param[PARAM_VEREINBARTER_PTP] = '22.02.2022'; 		
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$param[PARAM_ANREDE_SGH] = "r"; 

		$param[PARAM_ANREDE] = 'Herr';
		$param[PARAM_NACHNAME] = 'Franz Tausch';		
		$param[PARAM_NAME] = 'Tausch';		
		$param[PARAM_MANDANT_IBAN ] = 'DE12300200001234567890';				
		$param[PARAM_MANDANT_BIC] = 'SEZDDEF1XXX';			

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "EMAIL_ABSCHLUSS_EMAIL.html";
		// $template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT ABSCHLUSS EMAIL";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CC_NAME] = "Ronald Aberl";
		$email_from = 'Franz Tausch';
		



		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt,$email_from ) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}
		
		// TICKET_SERVICE EMAIL  - PTP_VEREINBARUNG_EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = '49-9-1644426480-550';;
		$param[PARAM_BETRAG] = '599,81'; 
		$param[PARAM_VEREINBARTER_PTP] = '22.02.2022'; 		
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$param[PARAM_ANREDE_SGH] = "r"; 

		$param[PARAM_ANREDE] = 'Herr';
		$param[PARAM_NACHNAME] = 'Franz Tausch';		
		$param[PARAM_NAME] = 'Tausch';			
		$param[PARAM_MANDANT_IBAN ] = 'DE12300200001234567890';				
		$param[PARAM_MANDANT_BIC] = 'SEZDDEF1XXX';			

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "EMAIL_PTP_VEREINBARUNG_EMAIL.html";
		// $template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT PTP_VEREINBARUNG_EMAIL";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CC_NAME] = "Ronald Aberl";
		$email_from = 'Franz Tausch';
		



		echo "<br>VOR callServiceForTicket<br>";
		if (callServiceForTicket($dbconn, TICKET_SERVICE_EMAIL, $mandant_id, $ticket_id, $template, $param, $retCode, $retMessage ,$serviceKontakt,$email_from ) ) {
                echo "<br>OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage."<br>";
				$retCallServiceForTicket = "OK";
		} else {
                echo "<br>NOT OK"." / RETCODE: ".$retCode." / RETMESSAGE: ".$retMessage." / GetLastError: ".getLastError()."<br>";
				$retCallServiceForTicket = "FEHLER - NICHT OK ";
		}


		// TICKET_SERVICE EMAIL  - PTP_ERINNERUNG_EMAIL
		$mandant_id = 43;
		$ticket_id = $line['kontaktid'];

		// Parameter für Textersatz festlegen
		$param[PARAM_VERTRAGSNUMMER] = '49-9-1644426480-550';;
		$param[PARAM_BETRAG] = '599,81'; 
		$param[PARAM_VEREINBARTER_PTP] = '22.02.2022'; 		
		$param[PARAM_KONTAKT_EMAIL] = "zahlungshilfe@sberbank-collections.de"; 
		$param[PARAM_KONTAKT_TELNR] = "+49 69 50958953";
		$param[PARAM_ANREDE_SGH] = "r"; 

		$param[PARAM_ANREDE] = 'Herr';
		$param[PARAM_NACHNAME] = 'Franz Tausch';		
		$param[PARAM_NAME] = 'Tausch';		
		$param[PARAM_MANDANT_IBAN ] = 'DE12300200001234567890';				
		$param[PARAM_MANDANT_BIC] = 'SEZDDEF1XXX';			

		$retCallServiceForTicket = "";
		$retCode = "";
		$retMessage = "";
		$template = "EMAIL_PTP_ERINNERUNG_EMAIL.html";
		// $template = "Muster-E-Mail-SBERBANK.html";
		$serviceKontakt = "franz.tausch@kimi-plus.at";
	
		// Sonstige Parameter für EMail-Steuerung
		$param[PARAM_EMAIL_SUBJECT] = "TESTNACHRICHT PTP_ERINNERUNG_EMAIL";
		$param[PARAM_EMAIL_FROM] = "franz.tausch@kimi-plus.at";
		// $param[PARAM_EMAIL_CC] = "ronald.aberl@aberl.at";
		$param[PARAM_EMAIL_CC_NAME] = "Ronald Aberl";
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


echo "<br><b>FERTIG</b><br><br>";
dbClose($dbconn);

?>