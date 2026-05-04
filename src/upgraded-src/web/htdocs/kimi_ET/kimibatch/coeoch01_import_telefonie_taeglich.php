<?php

include ("kimi_general.php");

// Hier evtl. eigene Header bei CSV-Import definieren
//$headerCSV = "telefon;prioritaet;aktenstadium;schuldner;aktenzeichen;kampagneid;vorgangid;mandant;schuldner_vorname;geburtsdatum;anlagedatum;strasse;plz;ort;email;zahlungen;gesamtkapitalhf;gesamtkapitalnf;offenes_kapitalhf;offenes_kapitalnf;zinsen;gesamtrueckstand;inkassokosten;kampagne;anwalt";
// 13.1.2026 - Schuldner_vorname entfaellt - bleibt als Spalte aber leer
$headerCSV = "telefon;prioritaet;aktenstadium;schuldner;aktenzeichen;kampagneid;vorgangid;mandant;geburtsdatum;anlagedatum;strasse;plz;ort;email;zahlungen;gesamtkapitalhf;gesamtkapitalnf;offenes_kapitalhf;offenes_kapitalnf;zinsen;gesamtrueckstand;inkassokosten;kampagne;anwalt";

// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 41;

$heute = date("d.m.Y H:i:s");    
echo "COEOCH 1 IMPORT - Start: ".$heute;
echo "<br><b>knp_import_telefonie_taeglich</b><br><br>";

// wird dies wirklich benötigt, $id wird auf 0 gesetzt?????
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =41 and kampagne_id <>99";

$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query_id);

if (!$result){
	echo getLastError();
	exit;
}

$id = $result['id'];

// 1. Lese Daten aus File

$data = loadCSVData($mandant_id, "COEOCH2.CSV", ";", true, false, true, $headerCSV);

if ($data===null) {
	echo getLastError();
	exit;
}

foreach($data as $x => $row ) {
	//&echo "row=".$row[1]."\n";
	// do anything with row

	echo "Line #<b>{$x}</b> : " . htmlspecialchars(implode(";", $row)) . "<br />\n";
	//$indexc = $index3arr;
	// #2 Daten Prüfen oder Umformatieren
	$row['geburtsdatum'] = substr($row['geburtsdatum'],0,4)."-".str_pad(substr($row['geburtsdatum'],5,2),2,'0',STR_PAD_LEFT)."-".str_pad(substr($row['geburtsdatum'],8,2),2,'0',STR_PAD_LEFT);

    // #2.1 Daten ausgeben zum Prüfen

    echo "<br>Aktenzeichen: ".$row['aktenzeichen'];
	echo "<br>Prioritaet: ".$row['prioritaet'];
	echo "<br>Aktenstadium: ".$row['aktenstadium'];
    echo "<br>Name: ".$row['schuldner'];	
	echo "<br>Kampagneid: ".$row['kampagneid'];
	echo "<br>Vorgangid: ".$row['vorgangid'];	
    echo "<br>Vorname: ".$row['schuldner_vorname'];		
    echo "<br>Strasse: ".$row['strasse'];				
    echo "<br>Plz: ".$row['plz'];	
    echo "<br>ort: ".$row['ort'];	
    echo "<br>Telefon: ".$row['telefon'];
    echo "<br>EMail: ".$row['email'];			
	$gebdatum= $row['geburtsdatum'];
	$gebdatumX= substr($gebdatum,0,4)."-".str_pad(substr($geburtsdatum,5,2),2,'0',STR_PAD_LEFT)."-".str_pad(substr($geburtsdatum,8,2),2,'0',STR_PAD_LEFT);
	$gebdatum= $gebdatumX;
    echo "<br>GebDatum: ".$gebdatum;	
echo "<br>GebDatum2: ".$row['geburtsdatum'];	
    echo "<br>Saldo: ".$row['gesamtrueckstand'];	
	echo "<br>Kampagne: ".$row['kampagne'];	
    echo "<br>Anwalt: ".$row['anwalt'];		
	$bemerkung = "Hinweis: ".$row['kampagne']." Gesamtkapitalhf: ".$row['gesamtkapitalhf']." gesamtkapitalnf: ".$row['gesamtkapitalnf']." Offenes_kapitalhf: ".$row['offenes_kapitalhf']." Offenes_kapitalnf: ".$row['offenes_kapitalnf']." Zinsen: ".$row['zinsen']." Gesamtrueckstand: ".$row['gesamtrueckstand']." Inkassokosten: ".$row['inkassokosten'];
	echo "<br>Bemerkung: ".$bemerkung;		
	echo "<br>";
	// Insert-Statement
	$id = 0;

	// 20220420
	$coeoch_ins = "INSERT INTO knp3 (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,".
		"telnr,telnr2,email,gebdatum,saldo,iban,bic,glname,glort,bemerkung,statusforderung,naechsterschritt,".
		"sbname,sbemail,sbtelnr,verzzinsen,ratenhoehe,faelligkeit,datlzahl,betrlzahl,satzkennzeichen,zahlungenx,import,kampagne,anwalt,".
		"zahlungen,gesamtkapitalhf,gesamtkapitalnf,offenes_kapitalhf,offenes_kapitalnf,zinsen,gesamtrueckstand,inkassokosten,anlagedatum,prioritaet,aktenstadium,kampagneid,vorgangid)".
		" values ("."'".$id."'".",'".$row['aktenzeichen']."'".",'','',kimi_encrypt('".$row['schuldner']."'),kimi_encrypt('".$row['schuldner_vorname']."'),kimi_encrypt('".$row['strasse']."'),kimi_encrypt('".$row['plz']."'),kimi_encrypt('".$row['ort'].
		"'),kimi_encrypt(TRIM(LEADING '0' FROM '".$row['telefon']."')),TRIM(LEADING '0' FROM ''),kimi_encrypt('".$row['email']."'),kimi_encrypt('".$row['geburtsdatum']."'),REPLACE('".$row['gesamtrueckstand']."', ',', '.'),'','','','','".$bemerkung."','','','',''".
		",'',REPLACE('0', ',', '.'),REPLACE('0', ',', '.'),null,null,REPLACE('0', ',', '.'),'','',now(),'".$row['kampagne']."','".$row['anwalt']."',".
		"REPLACE('".$row['zahlungen']."', ',', '.'),REPLACE('".$row['gesamtkapitalhf']."', ',', '.'),REPLACE('".$row['gesamtkapitalnf']."', ',', '.'),REPLACE('".$row['offenes_kapitalhf']."', ',', '.'),REPLACE('".$row['offenes_kapitalnf']."', ',', '.'),REPLACE('".$row['zinsen']."', ',', '.'),REPLACE('".$row['gesamtrueckstand']."', ',', '.'),REPLACE('".$row['inkassokosten']."', ',', '.'),'".$row['anlagedatum']."','".$row['prioritaet']."','".$row['aktenstadium']."','".$row['kampagneid']."','".$row['vorgangid']."'".")";

	echo "<br>".convert2Utf8($coeoch_ins)."<br>";


	if (!executeSQLCmdDML($dbconn, $mandant_id, 'SET NAMES utf8')) {
		echo getLastError();
		exit;
	}
	
	if (executeSQLCmdDML($dbconn, $mandant_id, $coeoch_ins)) {
		echo "<br><br>Insert in KNP3 durchgef&uuml;hrt<br>";
	} else {
		echo "<br><br>Error insert KNP3 in database: ".getLastError();
		exit;
	}
}

$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - INSERT IN TICKET-Tabelle   : ".$heute;
//

// #4  nach EOF der Datei Datensatz mit Insert in der Tickettabelle aufbauen 
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_insert_ticket_from_knp3.sql");
	if ($result) {
		echo "<br><br>Insert in TICKET durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert TICKET in database: ".getLastError();
		exit;
	}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - TRUNCATE knp3_duplet   : ".$heute;
//

// #5  TRUNCATE knp3_duplet – ist jetzt ein Drop table geworden
	$mehrfach_trunc = "drop table knp3_duplet"; //2017-01-06 umbau wegen hanging on copying to tmp table
	
	if (executeSQLCmdDML($dbconn, $mandant_id, $mehrfach_trunc)) {
		echo "<br><br>TRUNCATE knp3_duplet  durchgef&uuml;hrt";
	} else {
		echo "<br><br>TRUNCATE knp3_duplet: ".getLastError();
		exit;
	}
	// 


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - DOUBLETTE AUFBAUEN   : ".$heute;
//

// #6 DOUBLETTE AUFBAUEN	
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_create_table_duplet.sql");
if ($result) {
	echo "<br><br>INSERT knp3_duplet  durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT knp3_duplet: ".getLastError();
	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - DOUBLETTE in TICKET im Feld Erbnis eintragen : ".$heute;
//

// #7 DOUBLETTE in TICKET im Feld Erbnis eintragen

$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_update_ticket_schuldner_mehrfach.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET Dupletten  durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET Dupletten: ".getLastError();
	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Urgenztext aufbauen – Basistabelle leeren  : ".$heute;
//


// -- #8 Urgenztext aufbauen – Basistabelle leeren 


$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_truncate_knp3urgenz.sql");
if ($result) {
	echo "<br><br>TRUNCATE KNP3URGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>TRUNCATE KNP3URGENZ : ". getLastError();
//	exit;
}



$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH IMPORT - Urgenzen ermitteln   : ".$heute;
//



// -- #9  Urgenzen ermitteln 


$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_insert_knp3urgenz.sql");
if ($result) {
	echo "<br><br>INSERT KNP3URGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>INSERT KNP3URGENZ : ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Urgenzen in Ticket eintragen  : ".$heute;
//



//-- #10  Urgenzen in Ticket eintragen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_update_ticket_urgenzen.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET URGENZ: ".getLastError();
//	exit;
}



$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Zwischentabelle für MEHRFACHEN Tickets #1 löschen  : ".$heute;
//


// -- wenn mehrfach dann die Aktenzeichen im Feld Ergebnis eintragen
//-- #10.1  Zwischentabelle für MEHRFACHEN Tickets #1 löschen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_drop_table_knp3mehrfach.sql");
if ($result) {
	echo "<br><br>DROP TABLE KNP3 MEHRFACH  durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP TABLE KNP3 MEHRFACH: ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Zwischentabelle mit den MEHRFACHEN Tickets #1 NEU erstellen  : ".$heute;
//


//-- #10.2  Zwischentabelle mit den MEHRFACHEN Tickets #1 NEU erstellen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_create_table_knp3mehrfach.sql");
if ($result) {
	echo "<br><br>CREATE TABLE KNP3 MEHRFACH  durchgef&uuml;hrt";
} else {
	echo "<br><br>CREATE TABLE KNP3 MEHRFACH: ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Zwischentabelle für MEHRFACHEN Tickets #2 löschen  : ".$heute;
//


//-- #10.3  Zwischentabelle für MEHRFACHEN Tickets #2 löschen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_drop_table_knp3mehrfach2.sql");
if ($result) {
	echo "<br><br>DROP TABLE KNP3 MEHRFACH2 durchgef&uuml;hrt";
} else {
	echo "<br><br>DROP TABLE KNP3 MEHRFACH2: ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Zwischentabelle mit den MEHRFACHEN Tickets #2 NEU erstellen  : ".$heute;
//



//-- #10.4  Zwischentabelle mit den MEHRFACHEN Tickets #2 NEU erstellen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_create_table_knp3mehrfach2.sql");
if ($result) {
	echo "<br><br>CREATE TABLE KNP3 MEHRFACH2 durchgef&uuml;hrt";
} else {
	echo "<br><br>CREATE TABLE KNP3 MEHRFACH2: ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Ergebnis MIN  = 1tes AZ / 2tes Ticket in Ergebnisfeld schhreiben  : ".$heute;
//


//-- #10.5  Ergebnis MIN  = 1tes AZ / 2tes Ticket in Ergebnisfeld schhreiben
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_update_ticket_ergebnis_min.sql");
if ($result) {
	echo "<br><br>UPDATE UPDATE TICKET ERGEBNIS MIN durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE UPDATE TICKET ERGEBNIS MIN: ".getLastError();
//	exit;
}



$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Ergebnis MAX  = 2tes AZ / 2tes Ticket in Ergebnisfeld schhreiben  : ".$heute;
//



//-- #10.6  Ergebnis MAX  = 2tes AZ / 2tes Ticket in Ergebnisfeld schhreiben
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_update_ticket_ergebnis_max.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET ERGEBNIS MAX durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET ERGEBNIS MAX: ".getLastError();
//	exit;
}


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Anzahl Urgenzen ermitteln  : ".$heute;
//



//-- #11  Anzahl Urgenzen ermitteln
//select count(*) anzahl_n_urgenz From knp1urgenz
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s"); 
$query = "select count(*) anzahl_n_urgenz From knp1urgenz";
$result = executeSQLCmdQuerySingle($dbconn, $mandant_id, $query );
if (!$result) {
	echo getLastError();
	exit;
}

//-- #12  Anzahl Urgenzen ausgeben

$heute = date("d.m.Y H:i:s");    
echo "<br>COEO CH  IMPORT - Anzahl Urgenzen ausgeben : ".$heute;
//


// -- #13  Anzahl Offene Tickets ermitteln


$heute = date("d.m.Y H:i:s");    
echo "<br>COEOCH  IMPORT - Anzahl Urgenzen ausgeben : ".$heute;
//


echo "<br><br><b>Pr&uuml;fung OFFENE  EINGESPIELT:<br></b>";
echo "Start: ".date("d.m.Y H:i:s"); 
$query = "select count(*) anzahl_n_offen from ticket where mandant_id = 41 and status_id = 194 and kampagne_id <>99  and datediff(beginn, curdate()) < 1";
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

//-- #14.1  Status "in Bearbeitung" und Anruf_Status auf "in Elsbeth - Powerdialing" setzen
$result = executeSQLDML($dbconn, $mandant_id, "coeoch01_update_status_in_Arbeit.sql");
if ($result) {
	echo "<br><br>UPDATE TICKET STATUS in Arbeit durchgef&uuml;hrt";
} else {
	echo "<br><br>UPDATE TICKET STATUS in Arbeit: ".getLastError();
//	exit;
}

echo "<br><br>"."COEOCH IMPORT - Ende: ".$heute;

dbClose($dbconn);

?>