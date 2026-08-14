<?php
//echo "test";
//exit;
include ("db.php");
include("kimi_general_sql.php");
//require_once '../libs/addons/phpmail/class.phpmailer.php';
//require_once '../libs/addons/phpmail/class.smtp.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$srcDir = "./vendor/phpmailer/phpmailer/src";
require "$srcDir/PHPMailer.php";
require "$srcDir/SMTP.php";
require "$srcDir/Exception.php";


// Unterverzeichnisse
define("CONF_SUBDIR_INPUT", "IN");
define("CONF_SUBDIR_OUTPUT", "OUT");
define("CONF_SUBDIR_SCRIPTS", "Scripts");
define("CONF_SUBDIR_SERVICES", "Services");
define("CONF_SUBDIR_TEMPLATES", "Templates");

// Platzhalter für Verzeichnisse
define("PLACEHOLDER_PATH_SCRIPTS", "#scripts#");
define("PLACEHOLDER_PATH_INPUT", "#input#");
define("PLACEHOLDER_PATH_OUTPUT", "#output#");
define("PLACEHOLDER_PATH_TEMPLATES", "#templates#");

// Platzhalter in SQL-Statements
define("PLACEHOLDER_SQL_DATUM", "#datum#");
define("PLACEHOLDER_SQL_MANDANT", "#mandant#");
define("PLACEHOLDER_SQL_TICKETID", "#ticketid#");
define("PLACEHOLDER_SQL_TICKETNR", "#ticketnr#");
define("PLACEHOLDER_SQL_HAUPTTICKETID", "#hauptticketid#");
define("PLACEHOLDER_SQL_HAUPTTICKETNR", "#hauptticketnr#");
define("PLACEHOLDER_SQL_ERGEBNIS", "#ergebnis#");
define("PLACEHOLDER_SQL_EMAIL", "#email#");
define("PLACEHOLDER_SQL_TELNR", "#telnr#");

// Konstanten für Services
define("TICKET_SERVICE_SMS", "SMS");
define("TICKET_SERVICE_EMAIL", "EMAIL");
define("TICKET_SERVICE_OUTBOUND", "OUTB");
define("TICKET_SERVICE_WIEDERVORLAGE", "WVORL");
//define("TICKET_SERVICE_BRIEF", "BRIEF");

// Konstanten für Service-Parameter
define("PARAM_ANREDE", "#ANREDE#");
define("PARAM_ANREDE_SGH", "#ANREDE_SGH#");
define("PARAM_VORNAME", "#VORNAME#");
define("PARAM_NACHNAME", "#NACHNAME#");
define("PARAM_NAME", "#NAME#");
define("PARAM_VERTRAGSNUMMER", "#VTRNR#");
define("PARAM_ZAHLUNGSREF", "#ZAHLREF#");
define("PARAM_BETRAG", "#BETRAG#");
define("PARAM_VEREINBARTER_PTP", "#VEREINBARTER_PTP#");
define("PARAM_BETRAG_OFFEN", "#BETRAGOFFEN#");
define("PARAM_KONTAKT_EMAIL", "#KONTAKT_EMAIL#");
define("PARAM_KONTAKT_TELNR", "#KONTAKT_TELNR#");
define("PARAM_MANDANT_IBAN", "#MANDANT_IBAN#");
define("PARAM_MANDANT_BIC", "#MANDANT_BIC#");
define("PARAM_EMAIL_SUBJECT", "#SUBJECT#");
define("PARAM_EMAIL_FROM", "#EMAIL_FROM#");
define("PARAM_EMAIL_FROM_NAME", "#EMAIL_FROM_NAME#");
define("PARAM_EMAIL_CC", "#EMAIL_CC#");
define("PARAM_EMAIL_CC_NAME", "#EMAIL_CC_NAME#");
define("PARAM_EMAIL_BCC", "#EMAIL_BCC#");
define("PARAM_EMAIL_BCC_NAME", "#EMAIL_BCC_NAME#");




$query_replace = array (PLACEHOLDER_SQL_DATUM => "",PLACEHOLDER_SQL_MANDANT => "" );

$lastError = "";

//20220206/ar default characterset to utf8
mysqli_set_charset($dbconn, 'utf8');


function getFilePath($mandantId, $subdir, $no_root = false ) {
	if ($no_root === true) {
		$file = "/files";
	} else {
		$file = "./files";
	}
	
	if ($mandantId != null && $mandantId != "") {
		$file = $file."/".$mandantId;
	}
	if ($subdir != null && $subdir != "") {
		$file = $file."/".$subdir;
	}
	
	if (!file_exists($file)) {
		mkdir($file, 0777, true);
	}

	return $file."/";
}

// Funktionen für Dateiverwaltung
// Laden CSV-Dateien
function loadCSVData($mandantId, $file, $delm=";", $ansi2Utf8=true, $trim = true, $head  = false, $headIndivKeys="") {
	/*
		$mandantId		... Mandant-ID für Verzeichnisermittlung
		$file 			... Dateiname (ohne Pfad)
		$delm			... Delimiter, default ;
		$ansi2Utf8 		... true = Konvertierung, false = Keine Konvertierung
		$trim 			... true = Trim auf Feldinhalte 
		$head 			... true = erste Zeile Überschrift, false = nur Daten
		$headIndivKey 	... Individuelle Bezeichner für Spalten-Array

	*/

	$file = getFilePath($mandantId, CONF_SUBDIR_INPUT).$file;
	
	if (!file_exists($file)) {
		setLastError("Datei ". $file. " nicht gefunden!");
		return null;
	}
	
    $csvxrow = file($file);   // ---- csv rows to array ----

    $csvxrow[0] = chop($csvxrow[0]);

	if ($ansi2Utf8) {
		$csvxrow[0] = convert2Utf8($csvxrow[0]);
	}
	if ($headIndivKeys != "") {
		$keydata = explode($delm,$headIndivKeys);
		if ($head === true) {
			$start = 1;
		} else 
		{ 
			$start = 0;
		}
		$head = true;
	} else {
		$keydata = explode($delm,$csvxrow[0]);
	}
    $keynumb = count($keydata);
   
    if ($head === true) {
		$anzdata = count($csvxrow);
		$z=0;
		for($x=$start; $x<$anzdata; $x++) {
			if ($ansi2Utf8) {
				$csvxrow[$x] = convert2Utf8($csvxrow[$x]);
			}
			$csvxrow[$x] = chop($csvxrow[$x]);
			//$csvxrow[$x] = str_replace($encl,'',$csvxrow[$x]);
			$csv_data[$x] = explode($delm,$csvxrow[$x]);
			$i=0;
			foreach($keydata as $key) {
				if ($trim) {
					$csv_data[$x][$i] = trim($csv_data[$x][$i]);
				}

				$out[$z][$key] = $csv_data[$x][$i];
				$i++;
			}   
			$z++;
		}
    }
    else {
        $i=0;
        foreach($csvxrow as $item) {
			if ($ansi2Utf8) {
				$item = convert2Utf8($item);
			}
            $item = chop($item);
            //$item = str_replace($encl,'',$item);
            $csv_data = explode($delm,$item);
            for ($y=0; $y<$keynumb; $y++) {
				if ($trim) {
					$csv_data[$y] = trim($csv_data[$y]);
				}
               $out[$i][$y] = $csv_data[$y];
            }
        $i++;
        }
    }
	return $out;
	
}

// Rückgabe letzten Fehler
function getLastError() {
	return $GLOBALS['lastError']."<br>";
}

function setLastError($value) {
	 $GLOBALS['lastError'] = $value;
	 return true;
}


function executeSQLLoader($dbconn, $mandantId, $file, $replaceArray=[]) {

	$file = getFilePath($mandantId, CONF_SUBDIR_SCRIPTS ).$file;

	$return = true;

	if (!file_exists($file)) {
		setLastError("Datei ". $file. " nicht gefunden!");
		return false;
	}

	if ($dbconn===false) {
		setLastError("Keine Datenbankverbindung!");
		return false;
	}
	$sql = loadSqlStatement($mandantId, $file, true);
	if ($sql === "") {
		return false;
	}
		// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {
		return false;
	}

	$result = mysqli_query($dbconn, $sql);

	if ($result === false) {
		setLastError("Fehler in SQL-Script ". $file. " :\n     " . mysqli_error($dbconn));
		$return = false;
	}
	return $return;

}

function executeSQLDML($dbconn, $mandantId, $file, $replaceArray=[]) {

	$return = true;

	$file = getFilePath($mandantId, CONF_SUBDIR_SCRIPTS ).$file;

	if (!file_exists($file)) {
		setLastError("Datei ". $file. " nicht gefunden!");
		return false;
	}
	if ($dbconn===false) {
		setLastError("Keine Datenbankverbindung!");
		return false;
	}
	$sql = loadSqlStatement($mandantId, $file, false);
	if ($sql === "") {
		return false;
	}

	// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {
		return false;
	}
	

	$result = mysqli_query($dbconn, $sql);

	if ($result === false) {
		setLastError("Fehler in SQL-Script ". $file. " :\n     " . mysqli_error($dbconn));
		$return = false;
	}
	return $return;

}

function executeSQLQuery($dbconn, $mandantId, $file, $replaceArray=[]) {

	$file = getFilePath($mandantId, CONF_SUBDIR_SCRIPTS ).$file;

	$return = true;

	if (!file_exists($file)) {
		setLastError("Datei ". $file. " nicht gefunden!");
		return false;
	}

	if ($dbconn===false) {
		setLastError("Keine Datenbankverbindung!");
		return false;
	}
	$sql = loadSqlStatement($mandantId, $file, false);
	if ($sql === "") {
		return false;
	}

	// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {
		return false;
	}
	
	// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {
		return false;
	}

	$result = mysqli_query($dbconn, $sql);

	if ($result === false) {
		setLastError("Fehler in SQL-Script ". $file. " :\n     " . mysqli_error($dbconn));
		$return = false;
	}
	return $result;
}

function executeSQLCmdQuerySingle($dbconn, $mandantId, $sql, $replaceArray=[]) {

	$return = true;

	if ($dbconn===false) {
		setLastError("Keine Datenbankverbindung!");
		return false;
	}
	// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {
		return false;
	}
	$result = mysqli_query($dbconn, $sql);

	if ($result === false) {
		setLastError("Fehler in SQL-Script ". $sql. " :\n     " . mysqli_error($dbconn));
		//$return = false;
		return false;
	}

	$fetch = mysqli_fetch_array($result, MYSQLI_ASSOC);

	return $fetch;
}

function executeSQLCmdDML($dbconn, $mandantId, $sql, $replaceArray=[]) {

	$return = true;

	if ($dbconn===false) {
		setLastError("Keine Datenbankverbindung!");
		return false;
	}
	// Prüfe und ersetze Platzhalter 
	if (replaceFromArray( $sql, $replaceArray ) === false ) {

		return false;
	}
	
	$result = mysqli_query($dbconn, $sql);

	if ($result === false) {
		setLastError("Fehler in SQL-Script ". $file. " :\n     " . mysqli_error($dbconn));
		$return = false;
	}

	return $result;
}

function replaceFromArray(&$value, &$replaceArray, $checkEmpty=true) {

	foreach($replaceArray as $key => $replValue ) {
		if ($replValue==="" && (strpos($value, $key) !== false) && $checkEmpty ) {
			setLastError("Platzhalter für ".$key ." vorhanden, Wert zum Ersetzen nicht definiert!");
			return false;
		}
		$value = str_replace( $key, $replValue, $value);
	}
	return true;
}

function loadSqlStatement($mandantId, $file, $hasPlaceholder = false) {
	
	$sql = "";
	$fh = fopen($file, 'r');

	if ($fh) {
		while (($line = fgets($fh)) !== false) {
			$line = trim ($line);

			$check = substr($line, 0, 2);
			$valid = true;
			if ($check === "//" | $check === "--" | $check ==='#') {
				$valid = false;
			}

			if ($valid) {
				$sql = $sql.$line."\n";
			}
		}
		fclose($fh);
		// replace Direktory 
		if ($hasPlaceholder === true) {
			$path = getFullPath()."/".getFilePath($mandantId, CONF_SUBDIR_INPUT, true );
			$sql = str_replace( PLACEHOLDER_PATH_INPUT, $path, $sql);
			$sql = str_replace("//", "/", $sql);
		}

	} else {
		setLastError("Fehler beim Lesen der Datei  ". $file);
	}
	return $sql;
}

function loadFileContent($file) {
	
	$content = file_get_contents($file, TRUE);
	if ($content === false) {
		setLastError("Fehler beim Lesen der Datei  "). $file;
		return false;
	}
	return $content;
}

function getCSVLineFromArray($array, $delm = ";") {
	$return = "";

	foreach($array as $value) {
		if ($return !== "") {
			$return = $return.$delm;
		}
		$return = $return.$value;
	}
	unset($array);

	return $return;
}

function getFullPath() {
	return __DIR__;
}

function utf8ToAnsi($value) {
	return iconv("UTF-8", "WINDOWS-1252", $value);
	$retval = $value;

	if (!mb_check_encoding($retval, 'CP1252')) {
		$retval = mb_convert_encoding($retval, 'CP1252');
	}
	return $retval;

}


function exportQueryToCSV($sqlResult, $mandantId, $fileName, $convertToAnsi=false ) {

	if ($sqlResult === false) {
		return false;
	}
	$count = 0;
	$fileName = getFilePath($mandantId, CONF_SUBDIR_OUTPUT).$fileName;
	$fh = fopen($fileName, "w");

	if ($fh !== false) {
		
		while ($line = mysqli_fetch_array($sqlResult, MYSQLI_ASSOC)) {

			$count = $count + 1;
			$lineFile = getCSVLineFromArray( $line )."\n";
	
			if ($convertToAnsi) {
				$lineFile = utf8ToAnsi($lineFile);
			}

			if ($lineFile !== false) {
				fwrite($fh, $lineFile);
			}
		}
					
		fclose($fh);
	} else {
		setLastError("Fehler beim Erstellen der Datei  ". $fileName);
		return false;
	}
	
	return $count;

}

function dbClose($dbconn) {
	mysqli_close($dbconn);
	return true;
}

function dbFetchArray($result) {
	return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

// Funktion ruft  Service für Ticket auf
function callServiceForTicket($dbconn, $service, $mandantId, $ticketId, $templateName, $param, &$retCode, &$retMessage, $serviceKontakt="", $serviceKontaktName="", $convertToAnsi=false ) {

	if ($service === "") {
		return false;
	}
	$result = true;

	$retCode = "OK";
	$retMessage = "";
	
	$fileName = $service.date("Ymd").".txt";


	$fileName = getFilePath($mandantId, CONF_SUBDIR_SERVICES).$fileName;
	
	// Prüfe ob gültiges Service
	if (!($service === TICKET_SERVICE_SMS || $service === TICKET_SERVICE_EMAIL)) {
			setLastError("Ungültiges Service: ".$service );
			$retCode = "ERROR";
			$retMessage = getLastError();
			return false;
	}

	// load Template
	if ($templateName !== "") {
		$fileTemplate  = getFilePath($mandantId, CONF_SUBDIR_TEMPLATES).$templateName;
		$templateContent = loadFileContent($fileTemplate);
		if ($templateContent === false) {
			$retCode = "ERROR";
			$retMessage = getLastError();
			return false;
		}
	}

	// validate Services
	if (($service === TICKET_SERVICE_SMS || $service === TICKET_SERVICE_EMAIL) && $serviceKontakt ==="") {
		$retCode = "ERROR";
		$retMessage = "Für Service ".$service." muss serviceKontakt übergeben werden!";
		setLastError($retMessage);
		return false;
	}

	// validate EMail-Parameter 
	if ($service === TICKET_SERVICE_EMAIL) {
		if (!validateEMailParam($param, $serviceKontakt, $retCode, $retMessage)) {
			return false;
		}
		// TESTWEISE übersteuern
		$serviceKontakt = "franz.tausch@kimi-plus.at";
		//$serviceKontakt = "office@aberl.at";
		$param[PARAM_EMAIL_FROM] = "kundenservice@kimi-plus.at";
		$param[PARAM_EMAIL_FROM] = "office@aberl.at";
		
	}

	$aktTicket = array();
	$hauptTicket = array();

	$ret = getTicketInfo($dbconn, $mandantId, $ticketId, true, $aktTicket, $hauptTicket);
	
	// Wenn Name nicht versorgt dann aus Hauptticket
	$fromHauptTicket = true;
	if (( array_key_exists(PARAM_NACHNAME, $param) && $param[PARAM_NACHNAME] !== "") || 
		(array_key_exists(PARAM_NAME, $param) && $param[PARAM_NAME] !== "")){
			$fromHauptTicket = false;
	} else {
		$fromHauptTicket = true; 
	}

	if ( $fromHauptTicket) {
		$param[PARAM_ANREDE_SGH] = "";
		$param[PARAM_ANREDE] = trim($hauptTicket['anrede']);

		if (substr($param[PARAM_ANREDE], -1, 1) === "r") {
			$param[PARAM_ANREDE_SGH] = "r";
		}
		
		$param[PARAM_NAME] = "";
		$param[PARAM_VORNAME] = trim($hauptTicket['vorname']);
		$param[PARAM_NACHNAME] = trim($hauptTicket['nachname']);
		if ($hauptTicket['vorname'] !== "") {
			$param[PARAM_NAME] = trim($hauptTicket['vorname']);
		}
		if (trim($hauptTicket['nachname']) !== "") {
			if ($param[PARAM_NAME] !== ""){
				$param[PARAM_NAME].=" ";
			}
			$param[PARAM_NAME].= trim($hauptTicket['nachname']);
		}
	}
	
	$fh = fopen($fileName, "a");
	if ($fh !== false) {
		$line = $service." ".date("YmdHis").": Ticket-ID=".$ticketId.", TicketNr=".$aktTicket['ticketnr'].", HauptticketNr=".$hauptTicket['ticketnr'].", Service-Kontakt=".$serviceKontakt.
			", Parameter=".implode(';', $param) ;

		fwrite($fh, $line."\n");
		if ($templateName !== "" && $templateContent !== "" ) {

			if (!replaceFromArray($templateContent, $param, false)) {
				$retcode = "ERROR";
				$retMessage = getLastError();
				return false;
			}

			$line = "   Templateinhalt: \n".$templateContent."\n";
			if ($service === TICKET_SERVICE_SMS ) {
				$line = "   Templateinhalt: \n".$templateContent."\n";
				fwrite($fh, $line."\n");
			} 
		}


		fclose($fh);
		$retMessage = $service." in Datei ".$service.date("Ymd").".txt eingetragen";
		$retCode = "OK";
		//chmod($fileName, 0766);

		// Sende SMS
		if ($service === TICKET_SERVICE_SMS ) {
			$result = sendSMS($mandantId, $serviceKontakt, $templateContent, $retCode, $retMessage);
		}

		// Sende EMail
		if ($service === TICKET_SERVICE_EMAIL) {
			$mail = new PHPMailer(true);
			//$mail->mail_to = $serviceKontakt;
			//$mail->mail_to_name = $serviceKontaktName;
			$mail->AddAddress($serviceKontakt, $serviceKontaktName);

			$subject = $param[PARAM_EMAIL_SUBJECT];

			if (!replaceFromArray($subject, $param, false)) {
				$retcode = "ERROR";
				$retMessage = getLastError();
				return false;
			}
			$mail->Subject = $subject;
			
			if (array_key_exists(PARAM_EMAIL_FROM, $param)) {
				$mail->From = $param[PARAM_EMAIL_FROM];
				$mail->Reply = $param[PARAM_EMAIL_FROM];
			}
			if (array_key_exists(PARAM_EMAIL_FROM_NAME, $param)) {
				$mail->FromName = $param[PARAM_EMAIL_FROM_NAME];
			}
			if (array_key_exists(PARAM_EMAIL_CC, $param)) {
				$cc = $param[PARAM_EMAIL_CC];
				$ccName = "";
				if (array_key_exists(PARAM_EMAIL_CC_NAME, $param)) {
					$ccName = $param[PARAM_EMAIL_CC_NAME];
				}
				$mail->AddCC($cc, $ccName);
	
			}
			if (array_key_exists(PARAM_EMAIL_BCC, $param)) {
				$cc = $param[PARAM_EMAIL_BCC];
				$ccName = "";
				if (array_key_exists(PARAM_EMAIL_BCC_NAME, $param)) {
					$ccName = $param[PARAM_EMAIL_BCC_NAME];
				}
				$mail->AddBCC($cc, $ccName);
	
			}


			$mail->MsgHTML( $templateContent);

			//$mail->MsgHTML( "test");
	$fh = fopen($fileName, "a");
	fwrite($fh, "vor send\n");
			$result = sendEMail($mandantId, $mail, $templateContent, $retCode, $retMessage);
			
			fwrite($fh, "result=".$retCode.", ".$retMessage."\n");
			fclose($fh);
		}

	} else {
		setLastError("Fehler beim Erstellen der Datei ". $fileName);
		$retCode = "ERROR";
		$retMessage = "Fehler beim Erstellen der Datei ". $service.date("Ymd").".txt";
		 
		return false;
	}
	return $result;

}


function validateEMailParam(&$param, $mailTo, &$retCode, &$retMessage) {

	$retCode = "OK";
	$retMessage = "";
	if (!array_key_exists(PARAM_EMAIL_SUBJECT, $param) || $param[PARAM_EMAIL_SUBJECT] === "" ){
		$retCode = "ERROR";
		$retMessage = "PARAM_EMAIL_SUBJECT nicht definiert!";
		setLastError($retMessage);
		return false;
	}
	if (!array_key_exists(PARAM_EMAIL_FROM, $param) || $param[PARAM_EMAIL_FROM] === "" ){
		$retCode = "ERROR";
		$retMessage = "PARAM_EMAIL_FROM nicht definiert!";
		setLastError($retMessage);
		return false;
	}
	if ($mailTo==="") {
		$retCode = "ERROR";
		$retMessage = "Kein EMail-Empfänger übergeben!";
		setLastError($retMessage);
		return false;
	}
	return true;
}

function sendEMail($mandantId, &$mail, &$retCode, &$retMessage) {

	$return = true;
	$retCode = "OK";
	$retMessage = "";

	// General Settings
	$mail->SMTPAuth = false;
	$mail->Username = 'KSmtp';  //$_POST['from'];
	$mail->Password = '$k4020$s$ptms$';     //$_POST['pwd'];

	//$subject = $_POST['subject'];

/*	$body = '<html>
	<body>'.html_entity_decode($_POST['body']).'
	</body>
	</html>';
	*/
	//$mail_to = $_POST['mail_to'];
	//$mail_to_name = $_POST['mail_to_name'];
	//$mail_bcc = 'kundenservice@kimi-plus.at';
	//$mail_cc = 'ronald.aberl@aberl.at';

	//$body = $message;

	$mail->IsSMTP();

	try {
		$mail->Host = "83.65.86.204"; // SMTP server
		$mail->Port = "25"; //SMTP Port
		

		$mail->SMTPDebug = 4;                     // enables SMTP debug information (for testing)

		$mail->CharSet = 'utf-8';


		$mail->Send();
		//echo "Nachricht wurde an ".$mail_to." gesendet!";
		//echo "Click <a href=\"index.php\">here</a> to send another email";
	} catch (phpmailerException $e) {
		$return = false;
		$retCode = "ERROR";
		$retMessage = "Error sendMail ".$e->errorMessage();
		setLastError($retMessage);
	} catch (Exception $e) {
		$return = false;
		$retCode = "ERROR";
		$retMessage = "Error sendMail ".$e->getMessage();
		setLastError($retMessage);
	}
return $return;

}

function sendSMS($mandantId, $sendTo, $message, &$retCode, &$retMessage) {

	// change encoding
	$return = true;
	$retMsg = "";
	$text = encodeSMSText($message);

	$url= "https://sms.inntelco.at/httpgateway.php?IDmandant=109&mandant=KIMIPLUS&smstext=$text&rufnummer=$sendTo&optsend=12";

	$url = str_replace(" ", "%20", $url);

	try {
		$retMsg=@file_get_contents($url);
		if ($retMsg===false) {
			$return = false;
			$error = error_get_last();
			setLastError("Fehler SMS-Versand: ".$error['message']);
			$retCode = "ERROR";
			$retMessage = "Fehler beim SMS-Versand: ".$error['message'];
			}
	}
	catch (Exception $e) {
		$return = false;
		setLastError("Fehler SMS-Versand: ".$e->getMessage());
		$retCode = "ERROR";
		$retMessage = "Fehler beim SMS-Versand: ".$e->getMessage();
	}
	
	if ($return) {
		$retMessage = json_encode($retMsg);
		$retCode = "OK";
	}

	return $return;
}

function encodeSMSText($content) {
	return $content;

	/*
	$return = utf8_decode($content);
	echo "\n1:".$return."\n";
	return $return;
	$return = iconv('UTF-8', 'ISO-8859-1', $content);
	echo "\n2:".$return."\n";
	$return = mb_convert_encoding($return, 'ISO-8859-1', 'UTF-8');
	
	echo "\n3:".$return."\n";
	return $return;
	*/
}

?>