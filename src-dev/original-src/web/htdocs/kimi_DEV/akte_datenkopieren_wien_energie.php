<?php
include ("./config/config.php");

function getDatabase($kdnr) {
	return CONF_MYSQL_DB;
}



function akt_datenkopieren($ticket_id, $kundennr ) {
	if (!isset($kundennr) | $kundennr==null) {
	echo "<br>Keine Kundennummer zum suchen<br>";
	
	return;
}
if (!isset($ticket_id) | $ticket_id==null) {
	echo "<br>Keine Ticketzurodnung für Update<br>";
	return;
}

//$kundennr = 18;
echo "Suche Vertragskonto ".$kundennr."<br>";
//exit;


mysql_connect(CONF_MYSQL_SERVER,CONF_MYSQL_USER,CONF_MYSQL_PASSWORD);
mysql_select_db(CONF_MYSQL_DB);
		
$update = "UPDATE akt_wienenergie
set 
akt_su_anrede = (select akt_su_anrede from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_nachname = (select akt_su_nachname from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_vorname = (select akt_su_vorname from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_gebdatum = (select akt_su_gebdatum from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_strhnr = (select akt_su_strhnr from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_plz = (select akt_su_plz from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != ''),
akt_su_ort = (select akt_su_ort from akt join ticket on akt.ticket_id = ticket.id
where ticket.mandant_id = 29 and ticket.kundennummer = '".$kundennr."' and akt_su_nachname != '')
";
mysql_query($update);

		echo "<br>";
		echo "Update akt_wienenergie ".$update."<br>";		


$update = "UPDATE akt
set 
akt_su_anrede = (select akt_su_anrede from akt_wienenergie),
akt_su_nachname = (select akt_su_nachname from akt_wienenergie),
akt_su_vorname = (select akt_su_vorname from akt_wienenergie),
akt_su_gebdatum = (select akt_su_gebdatum from akt_wienenergie),
akt_su_strhnr = (select akt_su_strhnr from akt_wienenergie),
akt_su_plz = (select akt_su_plz from akt_wienenergie),
akt_su_ort = (select akt_su_ort from akt_wienenergie)
where akt.ticket_id =  '".$ticket_id."'";

 echo "<br>";
		echo "Update: ".$update."<br>";	

mysql_query($update);

		echo "<br>";
		echo "Update AKT "."<br>";		
		
//		echo "<br>";
//		echo "Kunde nicht gefunden -> Eintrag von '".$text."' auf akt_hinweise"."<br>";
		
mysql_free_result($result);
mysql_close();
	
	return;
}



echo "<html>";
echo "<head>";
echo "<title>KIMI-Plus - Wien Energie Akte Daten kopieren</title>";
echo "</head>";
echo "<body>";
echo "<h1>KIMI-Plus -  Wien Energie Akte Daten kopieren</h1>";

$kundennr = $_GET['kundennummer'];
$ticket_id = $_GET['ticket_id'];

echo "<br>Vertragskontonummer: <br>".$kundennr;
echo "<br>TICKET_ID: <br>".$ticket_id."<br>";

akt_datenkopieren($ticket_id, $kundennr);

echo "</body>";    
echo "</html>";
?>