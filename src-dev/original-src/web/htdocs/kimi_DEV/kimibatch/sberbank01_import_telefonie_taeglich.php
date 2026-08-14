<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
$headerCSV = "kontonummer;kundennummer;gender;kundenname;ueberfaelliger_aussenstand;aktueller_aussenstand_gesamt;tag_der_einziehung;offene_Raten;iban;dpd_basel;dpd_collections;collection_counter;maximaler_ptp;dpd_eba;monatliche_rate;rest_laufzeit_monate;genehmigter_betrag;erste_faelligkeit;auszahlungstag;ende_der_laufzeit;notleidend;telefonnummer;stadt;strasse;plz;email_address;anzahl_anrufe_attempts;datum_uhrzeit_letzter_anruf;bezahlt;erreicht_right_party_connect;unter_welcher_nummer_erreicht;outbound_inbound;antwort_des_kunden;richtige_falsche_nummer;grund_der_nichtbezahlung;grund_der_nichtbezahlung_sonstige;ergebnis_des_anrufes;versprochener_betrag_promise_to_pay;versprochenes Datum;weiterer_anruf_erforderlich_datum;weitere_kontakte;weitere_kontakt_details;kunde_wuenscht_restrukturierung;zusatzkommentar;prio_faelle;borrower_name;borrower_gender;borrower_date_of_birth;borrower_email;borrower_phone;co_borrower_name;co_borrower_gender;co_borrower_date_of_birth;co_borrower_phone;co_borrower_email;co_borrower_street;co_borrower_zip;co_borrower_city;kontonummer_druck";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

$heute = date("d.m.Y H:i:s");    
echo "SBERBANK IMPORT - Start: ".$heute;
echo "<br><b>SBERBANK_import_telefonie_taeglich</b><br><br>";

// wird dies wirklich benötigt, $id wird auf 0 gesetzt?????
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =43 and kampagne_id <>99";

$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query_id);

if (!$result){
	echo getLastError();
	exit;
}

$id = $result['id'];

// 1. Lese Daten aus File

echo "<br>1. Lese Daten aus File<br><br>";

$data = loadCSVData($mandant_id, "SBERBANK.CSV", ";", true, false, true, $headerCSV);

echo "<br>loadCSVData<br><br>";

if ($data===null) {
	echo getLastError();
	exit;
}

foreach($data as $x => $row ) {
	// echo "row=".$row[1]."\n";
	// do anything with row

	echo "Line #<b>{$x}</b> : " . htmlspecialchars(implode(";", $row)) . "<br />\n";
	//$indexc = $index3arr;
	// #2 Daten Prüfen oder Umformatieren
	$row['geburtsdatum'] = substr($row['geburtsdatum'],0,4)."-".str_pad(substr($row['geburtsdatum'],5,2),2,'0',STR_PAD_LEFT)."-".str_pad(substr($row['geburtsdatum'],8,2),2,'0',STR_PAD_LEFT);

    // #2.1 Daten ausgeben zum Prüfen

    echo "<br>kontonummer: ".$row['kontonummer'];
    echo "<br>kundennummer: ".$row['kundennummer'];	
    echo "<br>gender: ".$row['gender'];		
    echo "<br>kundenname: ".$row['kundenname'];				
    echo "<br>ueberfaelliger_aussenstand: ".$row['ueberfaelliger_aussenstand'];	
    echo "<br>aktueller_aussenstand_gesamt: ".$row['aktueller_aussenstand_gesamt'];	
    echo "<br>offene_Raten: ".$row['offene_Raten'];
    echo "<br>tag_der_einziehung: ".$row['tag_der_einziehung'];			
	$maximaler_ptp= $row['maximaler_ptp'];
	$maximaler_ptpX= substr($maximaler_ptp,6,4)."-".str_pad(substr($maximaler_ptp,4,2),2,'0',STR_PAD_LEFT)."-".str_pad(substr($maximaler_ptp,0,2),2,'0',STR_PAD_LEFT);
	$maximaler_ptp= $maximaler_ptpX;
    echo "<br>maximaler_ptp: ".$maximaler_ptp;		
    echo "<br>iban: ".$row['iban'];	
	echo "<br>dpd_basel: ".$row['dpd_basel'];	
	echo "<br>dpd_collections: ".$row['dpd_collections'];	
	echo "<br>collection_counter: ".$row['collection_counter'];	
	echo "<br>maximaler_ptp: ".$row['maximaler_ptp'];		
	echo "<br>dpd_eba: ".$row['dpd_eba'];	
	echo "<br>monatliche_rate: ".$row['monatliche_rate'];	
	echo "<br>rest_laufzeit_monate: ".$row['rest_laufzeit_monate'];	
	echo "<br>genehmigter_betrag: ".$row['genehmigter_betrag'];		
	echo "<br>erste_faelligkeit: ".$row['erste_faelligkeit'];		
	echo "<br>auszahlungstag: ".$row['auszahlungstag'];		
	echo "<br>ende_der_laufzeit: ".$row['ende_der_laufzeit'];	
	echo "<br>notleidend: ".$row['notleidend'];	
	echo "<br>telefonnummer: ".$row['telefonnummer'];	
	echo "<br>stadt: ".$row['stadt'];	
	echo "<br>strasse: ".$row['strasse'];	
	echo "<br>plz: ".$row['plz'];	
	echo "<br>email_address: ".$row['email_address'];		
	echo "<br>borrower_email: ".$row['borrower_email'];		
	echo "<br>borrower_phone: ".$row['borrower_phone'];		
	echo "<br>co_borrower_phone: ".$row['co_borrower_phone'];		
	echo "<br>co_borrower_email: ".$row['co_borrower_email'];		
	echo "<br>";	
	$telefonnummer = $row['telefonnummer'];
	if ( substr($telefonnummer,0,4) == "+ 49") {
		$telefonnummer = "0049".substr($telefonnumer,4, strlen($telefonnummer)) ;
	}
	if ( $telefonnummer[0] == "0") {
		$telefonnummer = "0049".substr($telefonnummer,1, strlen($telefonnummer)) ;
	}
	echo "<br>telefonnummer: ".$telefonnummer;	
	$borrower_phone = $row['borrower_phone'];
	if ( substr($borrower_phone,0,4) == "+ 49") {
		$borrower_phone = "0049".substr($borrower_phone,4, strlen($borrower_phone)) ;
	} elseif ( $borrower_phone[0] == "0")  {
		$borrower_phone = "0049".substr($borrower_phone,1, strlen($borrower_phone)) ;
	}
	echo "<br>borrower_phone: ".$borrower_phone;	
	$co_borrower_phone = $row['co_borrower_phone'];
	if ( substr($co_borrower_phone,0,4) == "+ 49") {
		$co_borrower_phone = "0049".substr($co_borrower_phone,4, strlen($co_borrower_phone)) ;
	} elseif ( $co_borrower_phone[0] == "0")  {
		$co_borrower_phone = "0049".substr($co_borrower_phone,1, strlen($co_borrower_phone)) ;
	}
	echo "<br>co_borrower_phone: ".$co_borrower_phone;		
	//exit;
	// Insert-Statement
	$id = 0;
	
    //		$knp1_ins = "INSERT INTO knp1 (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,".
	//	"telnr,telnr2,email,gebdatum,saldo,iban,bic,glname,glort,bemerkung,statusforderung,naechsterschritt,".
	//	"sbname,sbemail,sbtelnr,verzzinsen,ratenhoehe,faelligkeit,datlzahl,betrlzahl,satzkennzeichen,zahlungen,import) ".
	//	" values ("."'".$id."'".",'".$row['aktenzeichen']."'".",'','','".$row['schuldner']."','".$row['schuldner_vorname']."','".$row['strasse']."','".$row['plz']."','".$row['ort'].
	//	"',TRIM(LEADING '0' FROM '".$row['telefon']."'),TRIM(LEADING '0' FROM ''),'".$row['email']."','".$row['geburtsdatum']."',REPLACE('".$row['gesamtrueckstand']."', ',', '.'),'','','','','','','','',''".
	//	",'',REPLACE('0', ',', '.'),REPLACE('0', ',', '.'),null,null,REPLACE('0', ',', '.'),'','',now())";
/*
	$sberbank_ins = "INSERT INTO sberbank ( id,kontonummer,kundennummer,gender,kundenname,ueberfaelliger_aussenstand,aktueller_aussenstand_gesamt,	tag_der_einziehung,	offene_Raten,iban,".
		"dpd_basel,dpd_collections,spalte_l,maximaler_ptp,dpd_eba,monatliche_rate,rest_laufzeit_monate,genehmigter_betrag,erste_faelligkeit, auszahlungstag,ende_der_laufzeit,".
		"notleidend,telefonnummer,stadt,strasse,plz,email_address".
		",import) ".
		" values ("."'".$id."'".",'".$row['kontonummer']."'".",'".$row['kundennummer']."','".$row['gender']."','".$row['kundenname']."',REPLACE('".$row['ueberfaelliger_aussenstand']."', ',', '.'),REPLACE(REPLACE('".$row['aktueller_aussenstand_gesamt']."', ',', '.'),' ','')".
		",1,2,'".$row['iban']."',".$row['dpd_basel'].",".$row['dpd_collections'].",".$row['spalte_l'].",STR_TO_DATE('".$row['maximaler_ptp']."','%d.%m.%Y'),".$row['dpd_collections'].",REPLACE('".$row['monatliche_rate']."', ',', '.'),".$row['rest_laufzeit_monate'].",REPLACE(REPLACE('".$row['genehmigter_betrag']."', ',', '.'),' ',''),STR_TO_DATE('".$row['erste_faelligkeit']."','%d.%m.%Y'),STR_TO_DATE('".$row['auszahlungstag']."','%d.%m.%Y'),STR_TO_DATE('".$row['ende_der_laufzeit']."','%d.%m.%Y')".
	    ",'".$row['notleidend']."',concat('0043','".$row['telefonnummer']."'),'".$row['stadt']."','".$row['strasse']."','".$row['plz']."','".$row['email_address']."'".
		",now())";
  */   
  // ID über System, da dann für Ticket "000" ergänzt wird ....
	// 20220228/ar -> kimi_encrypt hinzugefügt
	 	$sberbank_ins = "INSERT INTO sberbank ( kontonummer,kundennummer,gender,kundenname,ueberfaelliger_aussenstand,aktueller_aussenstand_gesamt,	tag_der_einziehung,	offene_Raten,iban,".
		"dpd_basel,dpd_collections,collection_counter,maximaler_ptp,dpd_eba,monatliche_rate,rest_laufzeit_monate,genehmigter_betrag,erste_faelligkeit, auszahlungstag,ende_der_laufzeit,".
		"notleidend,telefonnummer,stadt,strasse,plz,email_address,".
		"borrower_name,borrower_gender,borrower_date_of_birth,borrower_email,borrower_phone,co_borrower_name,co_borrower_gender,co_borrower_date_of_birth,co_borrower_phone,co_borrower_email,co_borrower_street,co_borrower_zip,co_borrower_city,kontonummer_druck".
		",import) ".
		" values ('".$row['kontonummer']."'".",'".$row['kundennummer']."',kimi_encrypt('".$row['gender']."'),kimi_encrypt('".$row['kundenname']."'),REPLACE('".$row['ueberfaelliger_aussenstand']."', ',', '.'),REPLACE(REPLACE('".$row['aktueller_aussenstand_gesamt']."', ',', '.'),' ','')".
		",".$row['tag_der_einziehung'].",".$row['offene_Raten'].",'".$row['iban']."',".$row['dpd_basel'].",".$row['dpd_collections'].",".$row['collection_counter'].",STR_TO_DATE('".$row['maximaler_ptp']."','%d.%m.%Y'),".$row['dpd_collections'].",REPLACE('".$row['monatliche_rate']."', ',', '.'),".$row['rest_laufzeit_monate'].",REPLACE(REPLACE('".$row['genehmigter_betrag']."', ',', '.'),' ',''),STR_TO_DATE('".$row['erste_faelligkeit']."','%d.%m.%Y'),STR_TO_DATE('".$row['auszahlungstag']."','%d.%m.%Y'),STR_TO_DATE('".$row['ende_der_laufzeit']."','%d.%m.%Y')".
	    ",'".$row['notleidend']."',kimi_encrypt(concat('','".$telefonnummer."')),kimi_encrypt('".$row['stadt']."'),kimi_encrypt('".$row['strasse']."'),kimi_encrypt('".$row['plz']."'),kimi_encrypt('".$row['email_address']."')".
		",kimi_encrypt('".$row['borrower_name']."'),kimi_encrypt('".$row['borrower_gender']."'),kimi_encrypt(STR_TO_DATE('".$row['borrower_date_of_birth']."','%d.%m.%Y')),kimi_encrypt('".$row['borrower_email']."'),kimi_encrypt('".$borrower_phone."'),kimi_encrypt('".$row['co_borrower_name']."'),kimi_encrypt('".$row['co_borrower_gender']."'),kimi_encrypt(STR_TO_DATE('".$row['co_borrower_date_of_birth']."','%d.%m.%Y')),kimi_encrypt('".$co_borrower_phone."'),kimi_encrypt('".$row['co_borrower_email']."'),kimi_encrypt('".$row['co_borrower_street']."'),kimi_encrypt('".$row['co_borrower_zip']."'),kimi_encrypt('".$row['co_borrower_city']."'),'".$row['kontonummer_druck']."'".
		",now())";
     
    //  



    //	

	echo "<br>".convert2Utf8($sberbank_ins)."<br>";


	if (!executeSQLCmdDML($dbconn, $mandant_id, 'SET NAMES utf8')) {
		echo getLastError();
		exit;
	}
	
	if (executeSQLCmdDML($dbconn, $mandant_id, $sberbank_ins)) {
		echo "<br><br>Insert in SBERBANK durchgef&uuml;hrt<br>";
	} else {
		echo "<br><br>Error insert SBERBANK in database: ".getLastError();
		exit;
	}
}

	// Setzen Änderung_KZ
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_sberbank_aendkz.sql");
	if ($result) {
		echo "<br><br>Update SBERBANK Aenderungskennzeichen durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error Update SBERBANK Aenderungskennzeichenin database: ".getLastError();
		exit;
	}


// #4  nach EOF der Datei Datensatz mit Insert in der Tickettabelle aufbauen  NEUE TICKETS
	// INSERT IN TICKET-Tabelle 
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_ticket_from_sberbank.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET NEUE durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET NEUE in database: ".getLastError();
		exit;
	}

// #4  nach EOF der Datei Datensatz mit Insert in der Tickettabelle aufbauen  AENDERUNGSTICKETS
	// INSERT IN TICKET-Tabelle 
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_ticket_from_sberbank_aend.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET AENDERUNG durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET AENDERUNG in database: ".getLastError();
		exit;
	}


// #5  sbergank_duplet – Drop table
	$mehrfach_trunc = "drop table sberbank_duplet"; //2017-01-06 umbau wegen hanging on copying to tmp table
	
	if (executeSQLCmdDML($dbconn, $mandant_id, $mehrfach_trunc)) {
		echo "<br><br>TRUNCATE sberbank_duplet  durchgef&uuml;hrt";
	} else {
		echo "<br><br>TRUNCATE sberbank_duplet: ".getLastError();
		exit;
	}
	// 


// #6 DOUBLETTE AUFBAUEN	
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_create_table_duplet.sql");
if ($result) {
	echo "<br><br>INSERT sberbank_duplet  durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT sberbank_duplet: ".getLastError();
	exit;
}


// #7 DOUBLETTE in TICKET im Feld Erbnis eintragen

$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_ticket_schuldner_mehrfach.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET Dupletten  durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET Dupletten: ".getLastError();
	exit;
}


// -- #8 Urgenztext aufbauen – Basistabelle leeren 


$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_truncate_sberbankurgenz.sql");
if ($result) {
	echo "<br><br>TRUNCATE SBERBANKURGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>TRUNCATE SBERBANKURGENZ : ". getLastError();
//	exit;
}


// -- #9  Urgenzen ermitteln 


$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_sberbankurgenz.sql");
if ($result) {
	echo "<br><br>INSERT SBERBANKURGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT SBERBANKURGENZ : ".getLastError();
//	exit;
}


//-- #10  Urgenzen in Ticket eintragen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_ticket_urgenzen.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET URGENZ: ".getLastError();
//	exit;
}

// -- wenn mehrfach dann die Aktenzheichen im Feld Ergebnis eintragen
//-- #10.1  Zwischentabelle für MEHRFACHEN Tickets #1 löschen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_drop_table_sberbankmehrfach.sql");
if ($result) {
	echo "<br><br>DROP TABLE SBERBANK MEHRFACH  durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP TABLE SBERBANK MEHRFACH: ".getLastError();
//	exit;
}


//-- #10.2  Zwischentabelle mit den MEHRFACHEN Tickets #1 NEU erstellen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_create_table_sberbankmehrfach.sql");
if ($result) {
	echo "<br><br>CREATE TABLE SBERBANK MEHRFACH  durchgef&uuml;hrt";
} else {
	echo "<br><br>CREATE TABLE SBERBANK MEHRFACH: ".getLastError();
//	exit;
}

//-- #10.3  Zwischentabelle für MEHRFACHEN Tickets #2 löschen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_drop_table_sberbankmehrfach2.sql");
if ($result) {
	echo "<br><br>DROP TABLE SBERBANK MEHRFACH2 durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP TABLE SBERBANK MEHRFACH2: ".getLastError();
//	exit;
}


//-- #10.4  Zwischentabelle mit den MEHRFACHEN Tickets #2 NEU erstellen
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_create_table_sberbankmehrfach2.sql");
if ($result) {
	echo "<br><br>CREATE TABLE SBERBANK MEHRFACH2 durchgef&uuml;hrt";
} else {
	echo "<br><br>CREATE TABLE SBERBANK MEHRFACH2: ".getLastError();
//	exit;
}

//-- #10.5  Ergebnis MIN  = 1tes AZ / 2tes Ticket in Ergebnisfeld schhreiben
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_ticket_ergebnis_min.sql");
if ($result) {
	echo "<br><br>UPDATE UPDATE TICKET ERGEBNIS MIN durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE UPDATE TICKET ERGEBNIS MIN: ".getLastError();
//	exit;
}


//-- #10.6  Ergebnis MAX  = 2tes AZ / 2tes Ticket in Ergebnisfeld schhreiben
$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_update_ticket_ergebnis_max.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET ERGEBNIS MAX durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET ERGEBNIS MAX: ".getLastError();
//	exit;
}



//-- #11  Anzahl Urgenzen ermitteln
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s"); 
$query = "select count(*) anzahl_n_urgenz From sberbankurgenz";
$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query );
if (!$result) {
	echo getLastError();
	exit;
}

//-- #12  Anzahl Urgenzen ausgeben

echo "<br>";
if ($result['anzahl_n_urgenz'] > 0) {
	echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | URGENZ : ".$result['anzahl_n_urgenz']."<br>";
}  


// -- #13  Anzahl Offene Tickets ermitteln

echo "<br><br><b>Pr&uuml;fung OFFENE  EINGESPIELT:<br></b>";
echo "Start: ".date("d.m.Y H:i:s"); 
$query = "select count(*) anzahl_n_offen from ticket where mandant_id = 43 and status_id = 211 and kampagne_id <>99  and datediff(beginn, curdate()) < 1";
$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query );
if (!$result) {
	echo getLastError();
	exit;
}

// -- #14 Anzahl offene Tickets ausgeben

if ($result['anzahl_n_offen'] > 0) {
	echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | OFFEN EINGESPIELT: ".$result['anzahl_n_offen']."<br>";
} else {
	echo "<b><font color='#FF0000'>ACHTUNG !!!!   Anzahl</font></b>&nbsp;Status | OFFEN EINGESPIELT IST NULL: ".$result['anzahl_n_offen']."<br>";
}

/*
// VORERST NICHT AUTOMATISCH SETZEN 2022-02-10 --> wahrscheinlich beim EXPORT der ersten Anrufe 
//-- #14.1  Status "in Bearbeitung" und Anruf_Status auf "in Elsbeth - Powerdialing" setzen
$result = executeSQLDML($dbconn, $mandant_id, "coeo01_update_status_in_Arbeit.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET STATUS in Arbeit durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET STATUS in Arbeit: ".getLastError();
//	exit;
}
*/ 

// # Aufbau der ersten Leistungen - ERSTE SMS
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_ticket_erste_sms.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET ERSTE SMS durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET ERSTE SMS in database: ".getLastError();
		exit;
	}

// # Aufbau der ersten Leistungen - ERSTE EMAIL
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_ticket_erste_email.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET ERSTE EMAIL durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET ERSTE EMAIL in database: ".getLastError();
		exit;
	}



// # Aufbau der ersten Leistungen - ERSTE SMS
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank01_insert_ticket_erster_anruf.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET ERSTER ANRUF durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET ERSTER ANRUF in database: ".getLastError();
		exit;
	}



echo "<br><br>"."SBERBANK IMPORT - Ende: ".$heute;

//20220228/ar
dbClose($dbconn);

?>