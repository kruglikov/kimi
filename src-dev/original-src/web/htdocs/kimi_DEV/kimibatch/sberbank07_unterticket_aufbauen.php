<?php

//include ("kimi_general.php");
include ("db.php");
// Zuordnung der Mandanten-ID (muss dadurch nur einmal angepasst werden)
$mandant_id = 43;

echo "<b>sberbank_UNTERTICKET_ANLEGEN</b><br><br>";



echo 'Hallo ' . htmlspecialchars($_GET["name"]) . '!'."<br>";

$hauptticketnr = htmlspecialchars($_GET["hauptticketnr"]);

echo 'hauptticketnr: '.$hauptticketnr."<br>";

if($hauptticketnr == "XXXXXXX") 
   {
   echo "Bitte als Parameter die Haupticketnr übergeben<br>";
   } else {
   echo "UNTERTICKET AUFBAUEN<br>";
   // Versorgen ders Platzhalter im SQL-Statement für TICKETID - in diesem Fall wir die Ticketnr mitgegben !!
  // $query_replace[PLACEHOLDER_SQL_TICKETID] = $hauptticketnr;   
   
   //
   /*
	// # Aufbau UNTERTICKET
	// INSERT IN TICKET-Tabelle
	$result = executeSQLDML($dbconn, $mandant_id, "sberbank07_insert_unterticket.sql",$query_replace);
	if ($result) {
		echo "<br><br>Insert in UNTERTTICKET ANLEGEN durchgef&uuml;hrt";
	} else {
		echo "<br><br>Error insert UNTERTTICKET ANLEGEN in database: ".getLastError();
		exit;
	}
	//
	*/
	$insert_unterticket = "INSERT INTO ticket".	
		"(ticketnr,mandant_id,hauptticketnr,aktnummer,kunde_id,benutzer_id, beschreibung_detail,".
		"kundennummer,anrede,titel,nachname,vorname,plz,land_id,".
		"ort,strasse,hausnummer,telefon,telefon2,".
        "geburtsdatum,dummy_number5,".
        "dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_number6,dummy_date1,dummy_text8,".
	    "dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,".
		"geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,email,kenner,fahrgestellnummer,".
		"textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12,grund_id) ".
		"SELECT ".
		"(select max(ticketnr)+1  from ticket where mandant_id = 43 and ticketnr between concat(SUBSTR('".$hauptticketnr."', 1, length('".$hauptticketnr."')-3 ),'000') and concat(SUBSTR('".$hauptticketnr."', 1, length('".$hauptticketnr."')-3 ),'999')),".
		"mandant_id,hauptticketnr,aktnummer,kunde_id,benutzer_id, beschreibung_detail,".
		"kundennummer,anrede,titel,nachname,vorname,plz,land_id,".
		"ort,strasse,hausnummer,telefon,telefon2,".
        "geburtsdatum,dummy_number5,".
        "dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_number6,dummy_date1,dummy_text8,".
	    "dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,".
		"geaendert_am,geaendert_von,status_id,beginn,ende,224,kampagne_id,email,kenner,fahrgestellnummer,".
		"textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12,grund_id ".
        "from ticket ".
        "where mandant_id = 43 and id = (select id from ticket where mandant_id = 43 and ticketnr = '".$hauptticketnr."' and ticketnr = hauptticketnr)";
	echo $insert_unterticket;
	if (mysqli_query($dbconn, $insert_unterticket))
	{
	echo "<br>Update Status UNTERTICKET ANLEGEN durchgef&uuml;hrt<br>";
	} else {
	echo "<br>Error creating UNTERTICKET ANLEGEN : " . mysqli_error($dbconn)."<br>";
	}	
	//
   }

echo "<br><br>"."UNTERTICKET ANLEGEN ENDE : ".$heute;

mysqli_close($dbconn);

?>