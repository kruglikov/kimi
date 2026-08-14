<?php
// Definition
define("validphone_uid", "02-17-001-17-0007");
define("validphone_upw", "WtJW7M5f0yehy5CF");
define("validphone_url", "https://validphone.validdata.eu/hlr/hlrlookup.php");

// Ergebniscodes
$status_ok = array(
	"100"=>"Nummer OK",
	"102"=>"temporärer Fehler",
	"104"=>"SMS-Seitig nicht erreichbar",
	"105"=>"Status wird nicht bekanntgegeben",
	"109"=>"Nummer OK",
	"112"=>"Service nicht erreichbar",
	"103"=>"Nummer nicht (mehr) aktiv"
);
$status_fehler = array(
	"101"=>"SS7 Fehler",
	"106"=>"CUG (closed user group) abgelehnt",
	"107"=>"nicht unterstützt",
	"108"=>"SS7 Fehler",
	"110"=>"SS7 Fehler",
	"111"=>"SS7 Fehler",
);

// includes
include ("./config/config.php");
//include_once './libs/init.php';

// Ermittlung Statustext
function getStatustext($status) {
	$text = $status_ok[$status];
	if ($text = "") {
		$text = $status_fehler[$status];
	}
	if ($text=="") {
		$text = "Nicht definierter Fehler";
	}
	return $text;
}


// get parameters for where clause
$mandant_id = $_POST["mandant_id"];
$kampagne_id = $_POST["kampagne_id"];
$status = $_POST["status"];

if ($status=="") {
	$status = 0;
}

// define where clause
$where = " where status=".$status;
if ($mandant_id != "") {
	$where .= " and mandant_id=".$mandant_id;
}
if ($kampagne_id != "") {
	$where .= " and kampagne_id=".$kampagne_id;
}
$where.=" order by zeitpunkt_erstellung ";

// connect to database
mysql_connect(CONF_MYSQL_SERVER,CONF_MYSQL_USER,CONF_MYSQL_PASSWORD);
mysql_select_db(CONF_MYSQL_DB);

// main query
$query = "SELECT * FROM validphone_batch ".$where;

//echo "Query=".$query."<br>";

$request = "uid=".validphone_uid."&upw=".validphone_upw."&msisdn=???"."&responsetype=json";

$result = mysql_query($query);
$count = 0;
echo "VALIDPHONE-Abfragen starten (".$query." )<br><br>";

	while ($erg = mysql_fetch_array($result)) {
//		echo "ID=".$erg['id']."<br>";
		$count = $count + 1;
		$msisdn = $erg['telefon_nr'];
		// Check telefon number_format
		// Prüfe ob erste stellt ein 0 und keine Länderkennung
		if ( substr($msisdn,0,1) =="0" && substr($msisdn, 1, 1) != "0"  )  {
			// statt führender 0 Länderkennung voranstellen (evtl. nach Mandant/Kampagne)
			$msisdn = "0043".substr($msisdn,1,strlen($msisdn)-1);
		}
		// 
		$call = validphone_url."?".$request;
		$call  = str_replace("???", $msisdn, $call);
		echo $call;
		// update Status
		mysql_query("update validphone_batch set status = 1, zeitpunkt_uebermittlung=now() where id = ".$erg['id']);
		$return=file_get_contents($call);
		//echo "   Return=".$return."<br>";
		$ergebnis = "";
		if ($return!="") {

			$json = json_decode($return);
//			var_dump($json);
//			echo "Json=".$json->statuscode."<br>";
//			echo "done<br>";

			$ergebnis = $json->statuscode." ".$json->statusmsg;
			// Über Funktion könnten die Meldungen angepasst werden!?
			//$ergebnis = getStatustext($json->statuscode);
	
			mysql_query("update validphone_batch set status = 2, zeitpunkt_rueckmeldung=now(), ergebnis='".substr($return,0,500)."', ergebnis_code='".$json->statuscode."', ergebnis_text='".$ergebnis."'  where id = ".$erg['id']);
		} else {
			mysql_query("update validphone_batch set status = 9, zeitpunkt_rueckmeldung=now(), ergebnis='".$call."', ergebnis_code='9', ergebnis_text='Aufruf Validphone fehlgeschlagen!'  where id = ".$erg['id']);
			$ergebnis = "Prüfung fehlgeschlagen";
		}
		echo " -> ".$ergebnis."<br>";
		// Prüfe ob ticket-id vorhanden, wenn ja dann Eintrag des Ergebnisses
		if ($erg['ticket_id'] != null && $erg['ticket_id'] != "") {
			$ursprung=$erg['telefon_nr_ursprung'];
			if ($ursprung=="") {
				$ursprung = "Tel";
			}
			$datum = date("d.m.Y H:i:s");
			$telUrsprung = $erg['telefon_nr_ursprung'];
			if ($telUrsprung=="" | $telUrsprung==null) {
				$telUrsprung = "Tel";
			}
			//echo "Update Ticket: "."update ticket set ergebnis = trim(concat(ergebnis, ' Validphone ".$telUrsprung." ".$msisdn." ".$ergebnis."')) where id = ".$erg['ticket_id']."<br>";
			mysql_query("update ticket set ergebnis = trim(concat(ifnull(ergebnis,''), ' Validphone ".$telUrsprung." ".$msisdn." ".$datum." ".$ergebnis."')) where id = ".$erg['ticket_id']);
		}

	}
	mysql_free_result($result);	
 	echo "<br>".$count." Abfragen durchgeführt<br>";
exit;

?>