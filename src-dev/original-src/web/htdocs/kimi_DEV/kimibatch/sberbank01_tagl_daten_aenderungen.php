<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_tagl_daten_aenderungen</b><br><br>";


// Ermittlung und Ausgabe der Daten in CSV Datei

// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
$query_replace[PLACEHOLDER_SQL_DATUM] = "2021-10-22";

// Query absetzen
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank01_select_tagl_daten_aenderungen.sql", $query_replace);
if ($result !== false) {
	// Ausgabe automatisch durchführen lassen, Ausgabe als ANSI (letzter Parameter)
	$file = "SBERBANK_tagl_daten_AENDERUNGENtmp".date("YmdHis").".csv";
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
$result = executeSQLQuery($dbconn, $mandant_id, "sberbank01_select_tagl_daten_aenderungen.sql", $query_replace);
if ($result !== false) {
	$count = 0;		
	//20220228/ar von mysql_fetch_array auf dbFetchArray geändert
	while ($line = dbFetchArray($result)) {
		$count = $count + 1;
		//
		//
		if ($count > 1){ // Überschriftszeile nicht versenden

		// Aenderungen feststellen und für Ergebnisfeld aufgereiten
		$aenderung = '';
		// Anrede

		if ($line['anrede'] <> $line['anrede_hauptticket']){
			$aenderung = $aenderung.'Anrede neu '.$line['anrede'].' Anrede vorher: '.$line['anrede_hauptticket']." / ";
		}
		// name
		if ($line['name'] <> $line['name_hauptticket']){
			$aenderung = $aenderung.'Name neu '.$line['name'].' Name vorher: '.$line['name_hauptticket']."/ ";
		}
		// plz
		if ($line['plz'] <> $line['plz_hauptticket']){
			$aenderung = $aenderung.'PLZ neu '.$line['plz'].' PLZ vorher: '.$line['plz_hauptticket']." /";
		}		
		// ort
		if ($line['ort'] <> $line['ort_hauptticket']){
			$aenderung = $aenderung.'Ort neu '.$line['ort'].' Ort vorher: '.$line['Ort_hauptticket']." / ";
		}	
		// Strasse
		if ($line['strasse'] <> $line['strasse_hauptticket']){
			$aenderung = $aenderung.'Strasse neu: '.$line['strasse'].' Strasse vorher: '.$line['strasse_hauptticket']." / ";
		}	
		// Telefon
		if ($line['telefon'] <> $line['telefon_hauptticket']){
			$aenderung = $aenderung.'Telefon neu: '.$line['telefon'].' Telefon vorher: '.$line['telefon_hauptticket']." / ";
		}
		// Telefon2
		if ($line['telefon2'] <> $line['telefon2_hauptticket']){
			$aenderung = $aenderung.'Telefon2 neu: '.$line['telefon2'].' Telefon2 vorher: '.$line['telefon2_hauptticket']."/ ";
		}	
		// EMail
		if ($line['email'] <> $line['email_hauptticket']){
			$aenderung = $aenderung.'EMail neu: '.$line['email'].' EMail vorher: '.$line['email_hauptticket']." / ";
		}		
		// Alternative EMail
		if ($line['alternative_email'] <> $line['alternative_email_hauptticket']){
			$aenderung = $aenderung.'AlternativeEMail neu: '.$line['alternative_email'].' AlternativeEMail vorher: '.$line['alternative_email_hauptticket']." / ";
		}		
		// Maximaler PTP
		if ($line['maximaler_ptp'] <> $line['maximaler_ptp_hauptticket']){
			$aenderung = $aenderung.'Maximaler PTP neu: '.$line['maximaler_ptp'].' Maximaler PTP vorher: '.$line['maximaler_ptp_hauptticket']." / ";
		}		
		// überfaelliger Aussenstand_
		if ($line['ueberfaelliger_aussenstand'] <> $line['ueberfaelliger_aussenstand_hauptticket']){
			$aenderung = $aenderung.'Überfaelliger Aussenstand neu: '.$line['ueberfaelliger_aussenstand'].' Überfaelliger Aussenstand vorher: '.$line['ueberfaelliger_aussenstand_hauptticket']." / ";
		}				
		// aktueller Aussenstand gesamt
		if ($line['aktueller_aussenstand'] <> $line['aktueller_aussenstand_hauptticket']){
			$aenderung = $aenderung.'Aktueller Aussenstand Gesamt neu: '.$line['aktueller_aussenstand'].' Aktjueller Aussenstand Gesamt vorher: '.$line['aktueller_aussenstand_hauptticket']." / ";
		}		
		// CO-BORROWER
		if ($line['co_borrower'] <> $line['co_borrower_hauptticket']){
			$aenderung = $aenderung.'CO-Borrower neu: '.$line['co_borrower'].' CO_BORROWER vorher: '.$line['cco_borrower_hauptticket']." / ";
		}		
		//

		echo "Änderung: <br>".$aenderung."<br><br>";


		//
		// Hauptticket Updaten
		// ID über System, da dann für Ticket "000" ergänzt wird ....
	 	$hauptticket_upd = 
			"update ticket set ".
			"ticket.nachname = '".$line['nachname']."',".
			"ticket.plz = '".$line['plz']."',".
			"ticket.ort = '".$line['ort']."',".
			"ticket.strasse = '".$line['strasse']."',".
			"ticket.telefon = '".$line['telefon']."',".
			"ticket.telefon2 = '".$line['telefon2']."',".
			"ticket.email = '".$line['email']."',".
			"ticket.dummy_text7 = '".$line['alternative_email']."',".
			"ticket.dummy_date1 = '".$line['maximaler_ptp']."',".
			"ticket.dummy_number4 = '".$line['ueberfaelliger_aussenstand']."',".
			"ticket.dummy_number5 = '".$line['aktueller_aussenstand']."',".
			"ticket.markencode = ".$line['ticketnr'].",".
			"ticket.dummy_text11 = '".$line['co_borrower']."',".
			"ergebnis = concat(ifnull(ergebnis,''), char(13,10),'Masch. Änderung Daten am ',now()) ".
			"where mandant_id = 43 and hauptticketnr = ".$line['hauptticketnr']." and ticketnr = hauptticketnr";
			
        //  
		//	
		echo "<br><br>".convert2Utf8($hauptticket_upd)."<br>";

		if (!executeSQLCmdDML($dbconn, $mandant_id, 'SET NAMES utf8')) {
		echo getLastError();
		exit;
		}
	
		if (executeSQLCmdDML($dbconn, $mandant_id, $hauptticket_upd)) {
			echo "<br><br>Update Hauptticket  durchgef&uuml;hrt<br>";
		} else {
			echo "<br><br>Update Hauptticket database: ".getLastError();
			exit;
		}
		// Update Unterticket
		// Versorgen ders Platzhalter im SQL-Statement für Datumseingränzung (z.B. Beginn)
		// -- #  Status "erledigt" und Anruf_Status und Ergebnis ... setzen
		$query_replace[PLACEHOLDER_SQL_TICKETID] = $line['ticketid'];
		$query_replace[PLACEHOLDER_SQL_ERGEBNIS] = $ergebnis." ".$aenderung;
		$result2 = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_status_erledigt_aenderung.sql", $query_replace);		 
		if ($result2) {
			 echo "<br><br>UPDATE UNTERTICKET STATUS auf ERLEDIGT AENDERUNG durchgef&uuml;hrt"."<br>";
		} else {			 
			 echo "<br><br>UPDATE UNTERTICKET STATUS auf ERLEDIGT AENDERUNG: ".getLastError()."br>";
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