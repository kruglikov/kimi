<?php
include ("./config/config.php");

function getDatabase($kdnr) {
	return CONF_MYSQL_DB;
}

function updateKunde($database, $ticket_id, $daten,$aktnr,$akt_hinweise) {
	if ($database=="kimi_ET") {
		$herkunft = "P";
	} else {
		$herkunft = "A";
	}
	$strhnr=$daten['kunde_strasse'].' '.$daten['kunde_hausnummer'].' '.$daten['kunde_hausnummer_erw'];
	echo "Übernehme AKTNR=".$aktnr."<br><br><br><br><br><br>";
	
	$updateKunde="UPDATE kimi_ET.akt SET
		herkunft='".$herkunft."',

		kunde_id =".$daten['kunde_id'].",
		kunde_kdnr ='".$daten['kunde_kdnr']."',
		kunde_anrede_id =".$daten['kunde_anrede_id'].",
		kunde_anrede_text ='".$daten['kunde_anrede_text']."',
		kunde_titel_id =".$daten['kunde_titel_id'].",
		kunde_titel_text ='".$daten['titel_text']."',
		kunde_nachname ='".$daten['kunde_nachname']."',
		kunde_vorname ='".$daten['kunde_vorname']."',
		kunde_land ='".$daten['land_kurzzeichen']."',
		kunde_plz ='".$daten['kunde_plz']."',
		kunde_ort ='".$daten['kunde_ort']."',
		kunde_strasse ='".$daten['kunde_strasse']."',
		kunde_hausnummer =".$daten['kunde_hausnummer'].",
		kunde_hausnummer_erw ='".$daten['kunde_hausnummer_erw']."',
		kunde_telefon ='".$daten['kunde_telefon']."',
		kunde_email ='".$daten['kunde_email']."',
		kunde_geburtsdatum ='".$daten['kunde_geburtsdatum']."',
		kunde_kenner ='".$daten['kunde_kenner']."',
		kunde_titel ='".$daten['kunde_titel']."',
		kunde_markt =".$daten['kunde_markt'].",
		kunde_vorname2 ='".$daten['kunde_vorname2']."',
		kunde_geburtsdatum2 ='".$daten['kunde_geburtsdatum2']."',
		kunde_ortsteil ='".$daten['kunde_ortsteil']."',
		kunde_hausnr_zusatz ='".$daten['kunde_hausnr_zusatz']."',
		kunde_adresszusatz ='".$daten['kunde_adresszusatz']."',
		kunde_primaerkdnr ='".$daten['kunde_primaerkdnr']."',
		kunde_kundenart ='".$daten['kunde_kundenart']."',
		kunde_kundenartbeschreibung ='".$daten['kunde_kundenartbeschreibung']."',
		kunde_kz_betreut ='".$daten['kunde_kz_betreut']."',
		kunde_anlagedatum ='".$daten['kunde_anlagedatum']."',
		kunde_anrede2_id =".$daten['kunde_anrede2_id'].",
		kunde_geschlecht1 ='".$daten['kunde_geschlecht1']."',
		kunde_geschlecht2 ='".$daten['kunde_geschlecht2']."',
		kunde_titel2 ='".$daten['kunde_titel2']."',
		kunde_nachname2 ='".$daten['kunde_nachname2']."',
		akt_su_anrede ='".$daten['kunde_anrede_text']."',
		akt_su_nachname ='".$daten['kunde_nachname']."',
		akt_su_vorname ='".$daten['kunde_vorname']."',
		akt_su_gebdatum ='".$daten['kunde_geburtsdatum']."',
		akt_su_strhnr ='".$strhnr."',
		akt_su_plz ='".$daten['kunde_plz']."',
		akt_su_ort ='".$daten['kunde_ort']."',
		akt_forderungsgrund12 ='".$aktnr."',
		akt_hinweise ='".$akt_hinweise."',
		akt_update = current_timestamp
	WHERE ticket_id=".$ticket_id;

	echo "UPDATE=".$updateKunde."<br><br><br><br><br><br>";
	
	return (mysql_query($updateKunde));

}

function updateStammdaten( $ticket_id, $daten) {
	$updateStammdaten="UPDATE kimi_ET.akt SET
		stammdaten_id =".$daten['stammdaten_id'].",
		stammdaten_ktonr ='".$daten['stammdaten_ktonr']."',
		stammdaten_datum_anlage ='".$daten['stammdaten_datum_anlage']."',
		stammdaten_stichtag ='".$daten['stammdaten_stichtag']."',
		stammdaten_zahltag ='".$daten['stammdaten_zahltag']."',
		stammdaten_mahnsperre ='".$daten['stammdaten_mahnsperre']."',
		stammdaten_mahnsperre_datum ='".$daten['stammdaten_mahnsperre_datum']."',
		stammdaten_geaendert_am ='".$daten['stammdaten_geaendert_am']."',
		stammdaten_geaendert_von ='".$daten['stammdaten_geaendert_von']."',
		stammdaten_kto_kenner ='".$daten['stammdaten_kto_kenner']."',
		stammdaten_mahnstufe =".$daten['stammdaten_mahnstufe'].",
		stammdaten_ratenanzahl =".$daten['stammdaten_ratenanzahl'].",
		stammdaten_ratenhoehe =".$daten['stammdaten_ratenhoehe'].",
		stammdaten_max_einzbetrag =".$daten['stammdaten_max_einzbetrag'].",
		stammdaten_dat_einzbetrag ='".$daten['stammdaten_dat_einzbetrag']."',
		stammdaten_gesamtsaldo =".$daten['stammdaten_gesamtsaldo'].",
		stammdaten_gesamtsaldo_1x =".$daten['stammdaten_gesamtsaldo_1x'].",
		stammdaten_gesamtsaldo_rvc =".$daten['stammdaten_gesamtsaldo_rvc'].",
		stammdaten_inkassostatus_id =".$daten['stammdaten_inkassostatus_id'].",
		stammdaten_inkassostatus =".$daten['inkassostatus'].",
		stammdaten_inkassostatus_text ='".$daten['inkassostatus_text']."',
		stammdaten_inkassostatus_bezeichnung ='".$daten['stammdaten_inkassostatus_bezeichnung']."',
		stammdaten_ra_ikbuero_id =".$daten['stammdaten_ra_ikbuero_id'].",
		stammdaten_ra_ikbuero =".$daten['ra_buero'].",
		stammdaten_ra_ikbuero_text ='".$daten['ra_buero_text']."',
		stammdaten_status_dat ='".$daten['stammdaten_status_dat']."',
		stammdaten_dat_ltzt_buchung ='".$daten['stammdaten_dat_ltzt_buchung']."',
		stammdaten_dat_l_mahnlauf ='".$daten['stammdaten_dat_l_mahnlauf']."',
		stammdaten_dat_l_kontoauszug ='".$daten['stammdaten_dat_l_kontoauszug']."',
		stammdaten_betrag_l_kontoauszug =".$daten['stammdaten_betrag_l_kontoauszug'].",
		stammdaten_dat_l_auslagerung ='".$daten['stammdaten_dat_l_auslagerung']."',
		stammdaten_betrag_l_auslagerung =".$daten['stammdaten_betrag_l_auslagerung'].",
		stammdaten_dat_l_zahlung ='".$daten['stammdaten_dat_l_zahlung']."',
		stammdaten_betrag_l_zahlung =".$daten['stammdaten_betrag_l_zahlung'].",
		stammdaten_dat_erster_kauf ='".$daten['stammdaten_dat_erster_kauf']."',
		stammdaten_dat_l_retoure ='".$daten['stammdaten_dat_l_retoure']."',
		stammdaten_betrag_l_retoure =".$daten['stammdaten_betrag_l_retoure'].",
		stammdaten_mahnstat_mst1_2013 =".$daten['stammdaten_mahnstat_mst1_2013'].",
		stammdaten_mahnstat_mst2_2013 =".$daten['stammdaten_mahnstat_mst2_2013'].",
		stammdaten_mahnstat_mst3_2013 =".$daten['stammdaten_mahnstat_mst3_2013'].",
		stammdaten_mahnstat_mst4_2013 =".$daten['stammdaten_mahnstat_mst4_2013'].",
		stammdaten_offene_raten =".$daten['stammdaten_offene_raten'].",
		stammdaten_krsv =".$daten['stammdaten_krsv'].",
		stammdaten_lastschrift ='".$daten['stammdaten_lastschrift']."',
		stammdaten_letzter_stichtag ='".$daten['stammdaten_letzter_stichtag']."',
		stammdaten_letzter_zahltag ='".$daten['stammdaten_letzter_zahltag']."',
		stammdaten_dat_ende_sonderzins ='".$daten['stammdaten_dat_ende_sonderzins']."',
		stammdaten_stichtagtagdesmonats =".$daten['stammdaten_stichtagtagdesmonats']."
	WHERE ticket_id=".$ticket_id;
//echo $updateStammdaten;
	return (mysql_query($updateStammdaten));
}

function updateInkasso( $ticket_id, $daten) {
	$akt_hinweise2= ' IKS: '.$daten['inkasso_inkassostatus'].'-'.$daten['inkasso_inkassostatus_text'].' / ERL: '.$daten['inkasso_erled_qual_text'].' / ABG: '.$daten['inkasso_ausbuchungsgrund_text'].' / UEI: '.$daten['inkasso_uneinbringlich'];

	//20161017/ar
	$select = "SELECT akt_hinweise, inkasso_dubiosenink FROM kimi_ET.akt WHERE ticket_id=$ticket_id";
	$result = mysql_query($select);
	$row = mysql_fetch_assoc($result);
	$akt_hinweise = $row['akt_hinweise'];
	$inkasso_dubiosenink = $daten['inkasso_dubiosenink'];

	$akt_hinweise.=" / QD:".$akt_hinweise2." / Bemerkung: ";
	if ($inkasso_dubiosenink != "" & $inkasso_dubiosenink != null & $inkasso_dubiosenink != "null" ) {
		$dubiosentext = ' / $Dubioseninkasso$';
		if (strpos($akt_hinweise, $dubiosentext) == false) {
			$akt_hinweise.=$dubiosentext;
		}	
	}
	

	$updateInkasso="UPDATE kimi_ET.akt SET
		inkasso_id =".$daten['inkasso_id'].",
		inkasso_kundennummer ='".$daten['inkasso_kundennummer']."',
		inkasso_inkassostatus =".$daten['inkasso_inkassostatus'].",
		inkasso_inkassostatus_text ='".$daten['inkasso_inkassostatus_text']."',
		inkasso_inkassostatus_bezeichnung ='".$daten['inkasso_inkassostatus_bezeichnung']."',
		inkasso_status_dat ='".$daten['inkasso_status_dat']."',
		inkasso_ra_ikbuero_id =".$daten['inkasso_ra_ikbuero_id'].",
		inkasso_ra_ikbuero =".$daten['inkasso_ra_ikbuero'].",
		inkasso_ra_ikbuero_text ='".$daten['inkasso_ra_ikbuero_text']."',
		inkasso_anz_uebergab =".$daten['inkasso_anz_uebergab'].",
		inkasso_letzte_aenderung ='".$daten['inkasso_letzte_aenderung']."',
		inkasso_uebergabe_betrag =".$daten['inkasso_uebergabe_betrag'].",
		inkasso_uneinbringlich =".$daten['inkasso_uneinbringlich'].",
		inkasso_uebergabe_dat ='".$daten['inkasso_uebergabe_dat']."',
		inkasso_uebetr_du =".$daten['inkasso_uebetr_du'].",
		inkasso_dubiosenink =".$daten['inkasso_dubiosenink'].",
		inkasso_erl_du_dat ='".$daten['inkasso_erl_du_dat']."',
		inkasso_erled_qual_id =".$daten['inkasso_erled_qual_id'].",
		inkasso_erled_qual ='".$daten['inkasso_erled_qual']."',
		inkasso_erled_qual_text ='".$daten['inkasso_erled_qual_text']."',
		inkasso_erl_dat ='".$daten['inkasso_erl_dat']."',
		inkasso_ausbuchungsgrund_id =".$daten['inkasso_ausbuchungsgrund_id'].",
		inkasso_ausbuchungsgrund =".$daten['inkasso_ausbuchungsgrund'].",
		inkasso_ausbuchungsgrund_text ='".$daten['inkasso_ausbuchungsgrund_text']."',
		inkasso_geaendert_am ='".$daten['inkasso_geaendert_am']."',
		inkasso_geaendert_von ='".$daten['inkasso_geaendert_von']."',
		inkasso_verwendungszweck ='".$daten['inkasso_verwendungszweck']."',
		akt_hinweise = '".$akt_hinweise."'
		
	WHERE ticket_id=".$ticket_id;
	//echo "<br>".$updateInkasso."<br>";
	return (mysql_query($updateInkasso));

}


function akt_ermitteln($ticket_id, $kundennr ) {
	if (!isset($kundennr) | $kundennr==null) {
	echo "<br>Keine Kundennummer zum suchen<br>";
	
	return;
}
if (!isset($ticket_id) | $ticket_id==null) {
	echo "<br>Keine Ticketzurodnung für Update<br>";
	return;
}

//$kundennr = 18;
echo "Suche Kundennummer ".$kundennr."<br>";
//exit;
$database = getDatabase($kundennr);
echo "Database=".$database;
echo "<br>";
if ($database=="NOTFOUND") {
	echo "<br>NOTFOUND<br>";
	// 20161016/ar
	
		mysql_connect(CONF_MYSQL_SERVER,CONF_MYSQL_USER,CONF_MYSQL_PASSWORD);
		mysql_select_db(CONF_MYSQL_DB);

		$text = "Suche Kundennummer ".$kundennr." Database= NOTFOUND - keine Daten";

		// Lese aktuelle Daten aus Ticket
		$select = "SELECT t.id, g.text Ausbuchungsgrund, p.text Erledigungsgrund, dummy_text10 ".
			" FROM kimi_ET.ticket t ".
			" left join kimi_ET.grund g on g.id = t.grund_id ".
			" left join kimi_ET.produkt p on p.id = t.produkt_id ".
			" WHERE t.id=$ticket_id";
		$result = mysql_query($select);
		$row = mysql_fetch_assoc($result);
		$dummy_text10 = $row['dummy_text10'];
		if (strpos($dummy_text10, $text)!=false) {
			$dummy_text10 = $dummy_text10."/".$text;
		} else {
			$dummy_text10 = $text;
		}
		if ($row['Ausbuchungsgrund'] != "") {
			$text.=" / Ausbuchungsgrund: ".$row['Ausbuchungsgrund'];
		}
		if ($row['Erledigungsgrund'] != "") {
			$text.=" / Erledigungsgrund: ".$row['Erledigungsgrund'];
		}

		$update = "UPDATE kimi_ET.akt set akt_hinweise = '".$text."' where ticket_id = $ticket_id";
		mysql_query($update);
		
		$update = "UPDATE kimi_ET.ticket set dummy_text10 = '".$dummy_text10."' where id = $ticket_id";
		mysql_query($update);
		
		
//		echo "<br>";
//		echo "Kunde nicht gefunden -> Eintrag von '".$text."' auf akt_hinweise"."<br>";
		
		mysql_free_result($result);
		mysql_close();
	
	return;
}

mysql_connect(CONF_MYSQL_SERVER,CONF_MYSQL_USER,CONF_MYSQL_PASSWORD);
mysql_select_db(CONF_MYSQL_DB);

// Lese AKTNR
echo "TICKET AKTENNUMMER und mehr ermitteln<br><br>";
$query_aktnr = "SELECT concat(kundennummer,'-',dummy_text9,'-',ticketnr) aktnr,
produkt.text erledigungsgrund,grund.text ausbuchungsgrund,dummy_text10 info
 from ticket
left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
 where ticket.mandant_id = 29 and ticket.id = ".$ticket_id;

$result = mysql_query($query_aktnr);

while ($line = mysql_fetch_array($result)) {
   	echo "Übernehme AKTNR und mehr=".$line['aktnr']."<br><br><br><br><br><br>";
	$aktnr = $line['aktnr'];
	$akt_hinweise = 'AKT: Erledigungsgrund: '.$line['erledigungsgrund'].' / Ausbuchungsgrund: '.$line['ausbuchungsgrund'].' / Info: '.$line['info'];
		
}
    
echo "Quelle Akte zuordnen<br><br>";
// SQL-Statements
// Lese Kundendaten
$query_kunde = "SELECT k.id kunde_id, k.mandant_id kunde_mandant_id, k.kdnr kunde_kdnr, 
ifnull(k.anrede_id, 'null') kunde_anrede_id, ifnull(k.titel_id, 'null') kunde_titel_id,
k.nachname kunde_nachname, k.vorname kunde_vorname, k.land_id kunde_land_id, k.plz kunde_plz, k.ort kunde_ort, k.strasse kunde_strasse,
ifnull(k.hausnummer, 'null') kunde_hausnummer, k.hausnummer_erw kunde_hausnummer_erw, k.telefon kunde_telefon, k.email kunde_email,
k.geburtsdatum kunde_geburtsdatum, k.kenner kunde_kenner, k.geaendert_am kunde_geaendert_am, k.geaendert_von kunde_geaendert_von,
k.titel kunde_titel, ifnull(k.markt, 'null') kunde_markt, k.vorname2 kunde_vorname2, k.geburtsdatum2 kunde_geburtsdatum2, k.ortsteil kunde_ortsteil,
k.hausnr_zusatz kunde_hausnr_zusatz, k.adresszusatz kunde_adresszusatz, k.primaerkdnr kunde_primaerkdnr,
k.kundenart kunde_kundenart, k.kundenartbeschreibung kunde_kundenartbeschreibung, k.kz_betreut kunde_kz_betreut,
k.anlagedatum kunde_anlagedatum, k.anrede2_id kunde_anrede2_id, k.geschlecht1 kunde_geschlecht1, k.geschlecht2 kunde_geschlecht2,
k.titel2 kunde_titel2, k.nachname2 kunde_nachname2,
l.kurzzeichen land_kurzzeichen,
a.text kunde_anrede_text, t.text titel_text, a2.text anrede2_text
FROM ".$database.".kunde k
LEFT JOIN ".$database.".land l on l.id = k.land_id
LEFT JOIN ".$database.".anrede a on a.id = k.anrede_id
LEFT JOIN ".$database.".anrede a2 on a2.id = k.anrede2_id
LEFT JOIN ".$database.".titel t on t.id = k.titel_id

WHERE mandant_id = 29 AND kdnr = ".$kundennr;

$result = mysql_query($query_kunde);

while ($line = mysql_fetch_array($result)) {
    echo "<br>";
	echo "Übernehme Kunde ID=".$line['kunde_id']."<br>";
	$kunde_id = $line['kunde_id'];
	$ok=updateKunde($database, $ticket_id, $line,$aktnr,$akt_hinweise);
	echo "Update=".$ok."<br>"; 
}



// Lese Stammdaten
$query_stammdaten = "SELECT 
s.id stammdaten_id,
s.ktonr stammdaten_ktonr,
ifnull(s.mandant_id, 'null') stammdaten_mandant_id,
s.kunde_id stammdaten_kunde_id,
s.datum_anlage stammdaten_datum_anlage,
s.stichtag stammdaten_stichtag,
s.zahltag stammdaten_zahltag,
s.mahnsperre stammdaten_mahnsperre,
s.mahnsperre_datum stammdaten_mahnsperre_datum,
s.geaendert_am stammdaten_geaendert_am,
s.geaendert_von stammdaten_geaendert_von,
s.kto_kenner stammdaten_kto_kenner,
ifnull(s.mahnstufe, 'null') stammdaten_mahnstufe,
ifnull(s.ratenanzahl, 'null') stammdaten_ratenanzahl,
ifnull(s.ratenhoehe, 'null') stammdaten_ratenhoehe,
ifnull(s.max_einzbetrag, 'null') stammdaten_max_einzbetrag,
s.dat_einzbetrag stammdaten_dat_einzbetrag,
ifnull(s.gesamtsaldo, 'null') stammdaten_gesamtsaldo,
ifnull(s.gesamtsaldo_1x, 'null') stammdaten_gesamtsaldo_1x,
ifnull(s.gesamtsaldo_rvc, 'null') stammdaten_gesamtsaldo_rvc,
ifnull(s.inkassostatus_id, 'null') stammdaten_inkassostatus_id,
ifnull(s.ra_ikbuero_id, 'null') stammdaten_ra_ikbuero_id,
s.status_dat stammdaten_status_dat,
s.dat_ltzt_buchung stammdaten_dat_ltzt_buchung,
s.dat_l_mahnlauf stammdaten_dat_l_mahnlauf,
s.dat_l_kontoauszug stammdaten_dat_l_kontoauszug,
ifnull(s.betrag_l_kontoauszug, 'null') stammdaten_betrag_l_kontoauszug,
s.dat_l_auslagerung stammdaten_dat_l_auslagerung,
ifnull(s.betrag_l_auslagerung, 'null') stammdaten_betrag_l_auslagerung,
s.dat_l_zahlung stammdaten_dat_l_zahlung,
ifnull(s.betrag_l_zahlung, 'null') stammdaten_betrag_l_zahlung,
s.dat_erster_kauf stammdaten_dat_erster_kauf,
s.dat_l_retoure stammdaten_dat_l_retoure,
ifnull(s.betrag_l_retoure, 'null') stammdaten_betrag_l_retoure,
ifnull(s.mahnstat_mst1_2013, 'null') stammdaten_mahnstat_mst1_2013,
ifnull(s.mahnstat_mst2_2013, 'null') stammdaten_mahnstat_mst2_2013,
ifnull(s.mahnstat_mst3_2013, 'null') stammdaten_mahnstat_mst3_2013,
ifnull(s.mahnstat_mst4_2013, 'null') stammdaten_mahnstat_mst4_2013,
ifnull(s.offene_raten, 'null') stammdaten_offene_raten,
ifnull(s.krsv, 'null') stammdaten_krsv,
s.lastschrift stammdaten_lastschrift,
s.letzter_stichtag stammdaten_letzter_stichtag,
s.letzter_zahltag stammdaten_letzter_zahltag,
s.dat_ende_sonderzins stammdaten_dat_ende_sonderzins,";
if ($database=="kimi_archiv") {
	$query_stammdaten.="'null' stammdaten_stichtagtagdesmonats,";
} else {
	$query_stammdaten.="ifnull(s.stichtagtagdesmonats, 'null') stammdaten_stichtagtagdesmonats,";	
}
$query_stammdaten.="
r.ra_buero, r.text ra_buero_text,
i.inkassostatus, i.text inkassostatus_text
FROM ".$database.".stammdaten s
LEFT JOIN ".$database.".ra_ikbuero r on r.id = s.ra_ikbuero_id
LEFT JOIN ".$database.".inkassostatus i on i.id = s.inkassostatus_id

where mandant_id = 29 AND kunde_id = ".$kunde_id;
echo "<br>Lese Stammdaten für kunde_id=".$kunde_id;

$result = mysql_query($query_stammdaten);


while ($line = mysql_fetch_array($result)) {
    echo "<br>";
	echo "Übernehme Stammdaten für Kunde ID=".$kunde_id."<br>";
	$ok=updateStammdaten($ticket_id, $line);
	echo "UpdateStammdaten=".$ok."<br>"; 
}


// Lese Inkassoinformation
$query_inkasso = "SELECT 
i.id inkasso_id,
i.kundennummer inkasso_kundennummer,
ifnull(i.inkassostatus_id, 'null') inkasso_inkassostatus_id,
i.status_dat inkasso_status_dat,
ifnull(i.ra_ikbuero_id, 'null') inkasso_ra_ikbuero_id,
ifnull(i.anz_uebergab, 'null') inkasso_anz_uebergab,
i.letzte_aenderung inkasso_letzte_aenderung,
ifnull(i.uebergabe_betrag, 'null') inkasso_uebergabe_betrag,
ifnull(i.uneinbringlich, 'null') inkasso_uneinbringlich,
i.uebergabe_dat inkasso_uebergabe_dat,
ifnull(i.uebetr_du, 'null') inkasso_uebetr_du,
ifnull(i.dubiosenink, 'null') inkasso_dubiosenink,
i.erl_du_dat inkasso_erl_du_dat,
ifnull(i.erled_qual_id, 'null') inkasso_erled_qual_id,
i.erl_dat inkasso_erl_dat,
ifnull(i.ausbuchungsgrund_id, 'null') inkasso_ausbuchungsgrund_id,
i.geaendert_am inkasso_geaendert_am,
i.geaendert_von inkasso_geaendert_von,
ifnull(i.kunde_id, 'null') inkasso_kunde_id,
i.verwendungszweck inkasso_verwendungszweck,
ifnull(s.inkassostatus, 'null') inkasso_inkassostatus, s.bezeichnung inkasso_inkassostatus_bezeichnung, 
s.text inkasso_inkassostatus_text,
ifnull(b.ra_buero, 'null') inkasso_ra_ikbuero, b.text inkasso_ra_ikbuero_text,
e.erled_qual inkasso_erled_qual, e.text inkasso_erled_qual_text,
ifnull(g.ausbuch_grund, 'null') inkasso_ausbuchungsgrund, g.text inkasso_ausbuchungsgrund_text
FROM ".$database.".inkassoinformation i
LEFT JOIN ".$database.".inkassostatus s on s.id = i.inkassostatus_id
LEFT JOIN ".$database.".ra_ikbuero b on b.id = i.ra_ikbuero_id
LEFT JOIN ".$database.".erled_qual e on e.id = i.erled_qual_id
LEFT JOIN ".$database.".ausbuchungsgrund g on g.id = i.ausbuchungsgrund_id 
WHERE kunde_id  =".$kunde_id."  order by i.id desc";

echo "<br>Lese Inkassoinformation für kunde_id=".$kunde_id;

$result = mysql_query($query_inkasso);

$done = false;
while ($done==false && $line = mysql_fetch_array($result)) {
	$done=true;
    echo "<br>";
	echo "Übernehme Inkassoinformation für Kunde ID=".$kunde_id."<br>";
	$ok=updateInkasso($ticket_id, $line);
	echo "UpdateInkasso=".$ok."<br>"; 
}
echo "<br><br>done.<br>";
//
mysql_free_result($result);
mysql_close();
	
}

echo "<html>";
echo "<head>";
echo "<title>KIMI-Plus - Wien Energie Akte zuordnen</title>";
echo "</head>";
echo "<body>";
echo "<h1>KIMI-Plus -  Wien Energie Akte zuordnen</h1>";

$kundennr = $_GET['kundennummer'];
$ticket_id = $_GET['ticket_id'];

akt_ermitteln($ticket_id, $kundennr);

echo "</body>";    
echo "</html>";
?>