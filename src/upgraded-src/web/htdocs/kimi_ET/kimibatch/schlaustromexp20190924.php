<html>
  <head>
     <title>KIMI-Plus - SCHLASTROM-Export V 2 20190923</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SCHLAUSTROM-Export</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select 	
'Rechnungsnr.' rg_nr, -- 1
'Rechnung Titel' rg_titel , -- 2	
'Kunde' kunde, --  3	
'Rechnungsdatum' rg_datum	, -- 4
'Kundennummer' kunden_nummer, -- 5
'Rechnung Total'  rg_total , -- 6
'Rueckleitungsentgelt Bank' rueckent_bank, -- 7
'Total inkl RLE+MSp+Bearbg'  total_inklusive, -- 8
'Kunde Gesamt offen' kd_gesamt_offen, -- 9
'Kunde Anzahl offen' kd_anzahl_offen, -- 10
'Ruecklastschrift' rg_ruecklastschrift, -- 11
'Datum Mahnung 1' rg_datum_mahn1, -- 12
'Datum Mahnung 2' rg_datum_mahn2, -- 13
'Telefoniestatus M1' rg_telefoniestatusM1 , -- 14
'Telefoniestatus M2' rg_telefoniestatusM2 , -- 15
'Ruecklast_erledigt' rg_ruecklast_erl, -- 16
'Rechnung keine SEPA Last- Gutschrift' rg_keine_sepaLG, -- 17
'Rechnung Forderungsstatus' rg_beschreibung, -- 18
'Kunden Name' kd_name, -- 19
'Kunden Vorname' kd_vorname, -- 20
'Kunden Titel' kd_titel , -- 21
'Kunden Geburtsdatum' kd_geburtsdatum, -- 22
'Kunden Telefon' kd_telefon, -- 23
'Kunden Handy' kd_handy, -- 24
'Kunden E-Mail'  kd_email, -- 25
'Kunden Ich bin Lyoness Mitglied' kd_lyoness, -- 26
'Kunden Ich bin etoxx Mitglied' kd_etoxx, -- 27
'Kunden Name Lieferadresse' kd_name_liefer, -- 28
'Kunden Strasse Lieferadresse' kd_str_liefer, -- 29
'Kunden Hausnr. Lieferadresse' kd_hnr_liefer , -- 30
'Kunden PLZ Lieferadresse' kd_plz_liefer, -- 31
'Kunden Ort Lieferadresse' kd_ort_liefer , -- 32
'Erreicht (ja/nein)' erreicht_ja_nein, -- 33
'manuelle Bearbeitung (ja/nein)' man_bearb_ja_nein, -- 34
'Daten korrekt (ja/nein)' daten_korr, -- 35
'Vorname Korrektur' vorname_korr, -- 36
'Nachname Korrektur' nachname_korr, -- 37
'Geburtsdatum Korrektur' gebdat_korr, -- 38
'Strasse Korrektur' strasse_korr, -- 39
'Hausnummer Korrektur' hnr_korr, -- 40
'PLZ Korrektur' plz_korr, -- 41
'Stadt Korrektur' ort_korr, -- 42
'E-Mail Korrektur' emailaend , -- 43
'aktive Nummer Telefon' kontakt_telefon, -- 44
'deaktive/falsche Nummer Telefon' kontakt_telefon_falsch, -- 45
'aktives Mobiltelefon' kontakt_mobil, -- 46
'deaktives/falsches Mobiltelefon' kontakt_mobil_falsch, -- 47
'Vereinbarung ' vereinbarung, -- 48
'Objektart' objektart , -- 49
'Betrag' betrag, -- 50
'zahlungsdatum'  zahlungsdatum, -- 51
'Freitext' freitext, -- 52
'Gespraechsdatum' gespraechsdatum, -- 53
'Gespraechszeit' gespraechszeit,  -- 54
'Status' anruf_status, -- 55
'AgentenAnrede' agentenanrede,  -- 56
'AgentenVorname' agentenvorname, -- 57
'AgentenNachname' agentennachname -- 58
      
		union
		select 
rg_nr, -- 1
concat('',rg_titel,''), -- 2
kimi_decrypt(kunde), -- 3
DATE_FORMAT(sst.rg_datum, '%d.%m.%Y') rg_datum, -- 4
kunden_nummer, -- 5
REPLACE(REPLACE(FORMAT(sst.rg_total, 2),',',''),'.',',') rg_total, -- 6<
REPLACE(REPLACE(FORMAT(sst.rueckent_bank, 2),',',''),'.',',') rueckent_bank , -- 7
REPLACE(REPLACE(FORMAT(sst.total_inklusive, 2),',',''),'.',',') total_inklusive , -- 8
REPLACE(REPLACE(FORMAT(sst.kd_gesamt_offen, 2),',',''),'.',',') kd_gesamt_offen  , -- 9
REPLACE(REPLACE(FORMAT(sst.kd_anzahl_offen, 0),',',''),'.',',') kd_anzahl_offen , -- 10
ruecklastschrift, -- 11
DATE_FORMAT(sst.rg_datum_mahn1, '%d.%m.%Y') rg_datum_mahn1, --  12
DATE_FORMAT(sst.rg_datum_mahn2, '%d.%m.%Y') rg_datum_mahn2, -- 13
rg_telefoniestatusM1, -- 14
rg_telefoniestatusM2, -- 15
rg_ruecklast_erl, -- 16
rg_keine_sepaLG	, -- 17
rg_beschreibung, -- 18
kimi_decrypt(kd_name), -- 19
kimi_decrypt(kd_vorname), -- 20
kd_titel, -- 21
DATE_FORMAT(kimi_decrypt(sst.kd_geburtsdatum), '%d.%m.%Y') kd_geburtsdatum, -- 22
kimi_decrypt(kd_telefon), -- 23
kimi_decrypt(kd_handy), -- 24
kimi_decrypt(kd_email), -- 25
kd_lyoness , -- 26
kd_etoxx, -- 27
kimi_decrypt(kd_name_liefer), -- 28
kimi_decrypt(kd_str_liefer), -- 29
kimi_decrypt(kd_hnr_liefer), -- 30
kimi_decrypt(kd_plz_liefer), -- 31
kimi_decrypt(kd_ort_liefer), -- 32
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 373 THEN  anruf_status.text
            ELSE anruf_status.text  END  erreicht_ja_nein, -- 33
janein3.text  man_bearb_ja_nein, -- 	'manuelle Bearbeitung (ja/nein)' man_bearb_ja_nein, 17.12.2018 IMMER LEER -- 34
janein1.text, -- 'Daten korrekt (ja/nein)' daten_korr, -- 35
 CASE
            WHEN IFNULL(kimi_decrypt(ticket.vorname),'') <> IFNULL(kimi_decrypt(sst.kd_vorname),'') THEN  kimi_decrypt(ticket.vorname)
            ELSE null
             END   vorname_korr, -- 'Vorname Korrektur'-- 36
     CASE
            WHEN IFNULL(kimi_decrypt(ticket.nachname),'') <> IFNULL(kimi_decrypt(sst.kd_name),'') THEN kimi_decrypt(ticket.nachname)
            ELSE null
             END  nachname_korr, -- 37
		CASE
            WHEN IFNULL(kimi_decrypt(ticket.geburtsdatum),null) <> IFNULL(kimi_decrypt(sst.kd_geburtsdatum),null) 
                 and IFNULL(kimi_decrypt(ticket.geburtsdatum),null) <= '2010-01-01'
            THEN  DATE_FORMAT(kimi_decrypt(ticket.geburtsdatum), '%Y.%m.%d') 
            ELSE null
             END gebdat_korr, -- 38
       CASE
            WHEN IFNULL(kimi_decrypt(ticket.strasse),'') <> IFNULL(kimi_decrypt(sst.kd_str_liefer),'') THEN  kimi_decrypt(ticket.strasse)
            ELSE null
             END strasse_korr, -- 39
		CASE
            WHEN IFNULL(kimi_decrypt(ticket.hausnummer_erw),'') <> IFNULL(kimi_decrypt(kd_hnr_liefer),'') THEN  kimi_decrypt(ticket.hausnummer_erw)
            ELSE null
             END hausnummer_erw , --  hausnummer_erw -- 40
       CASE
            WHEN IFNULL(kimi_decrypt(ticket.plz),'') <>  IFNULL(kimi_decrypt(sst.kd_plz_liefer),'') THEN kimi_decrypt(ticket.plz)
            ELSE null
             END plz_korr, -- 41
       CASE
            WHEN IFNULL(kimi_decrypt(ticket.ort),'') <>  IFNULL(kimi_decrypt(sst.kd_ort_liefer),'') THEN  kimi_decrypt(ticket.ort)
            ELSE null
             END  ort_korr, -- 42
       CASE
            WHEN IFNULL(TRIM(kimi_decrypt(ticket.email)),'') <> IFNULL(TRIM(kimi_decrypt(sst.kd_email)),'') THEN  kimi_decrypt(ticket.email)
            ELSE null
             END emailaenderung , --  emailaenderung -- 43
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0) in (372,373) THEN  dummy_text4
            ELSE null  END kontakt_telefon, -- 44
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 378 THEN  dummy_text4
            ELSE null  END  kontakt_telefon_falsch, -- 45
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0) IN (372,373) THEN  standort
            ELSE null  END kontakt_mobil, -- 46
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 378 THEN  standort
            ELSE null  END   kontakt_mobil_falsch, -- 47
        nummern2.text vereinbarung, -- 48
		nummern1.text objektart, -- 49
         REPLACE(REPLACE(FORMAT(ticket.dummy_number6, 2),',',''),'.',',') betrag, -- 50
		 DATE_FORMAT(ticket.dummy_date1, '%d.%m.%Y') , -- 51
        REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis, -- 52
         DATE_FORMAT(getLogStartGes(ticket.id, ''), '%d.%m.%Y') , -- 'Gespraechsdatum',
         TIME_FORMAT(getLogStartGes(ticket.id, ''), '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus', -- 55
		getLogAgentAnrede(ticket.id, '') anrede, 		-- sst_log.anrede , -- 'AgentenAnrede',
        getLogAgentVorname(ticket.id, '') vorname, 		-- sst_log.vorname , -- 'AgentenVorname',
        getLogAgentNachname(ticket.id, '') nachname 	-- sst_log.nachname , -- 'AgentenNachname',



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
   /*
   left outer join
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 27

 ) sst_log on sst_log.id  = ticket.id and ticket.mandant_id = sst_log.mandant_id
 */
join schlaustrom  sst on sst.id = ticket.ticketnr

	where ticket.mandant_id =27 
and ticket.status_id = 117 
";

$filename = "files/schlaustromexp".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;ifs-Sb-Name;ifs-Sb-Mail;ifs-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'ifs-Aktion;AdressNr;Anmerkung;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
// 
while ($line = dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['rg_nr'].";"."\"".$line['rg_titel']."\"".";".$line['kunde'].";".$line['rg_datum'].";".$line['kunden_nummer'].";".$line['rg_total'].";".$line['rueckent_bank'].";".$line['total_inklusive'].";".$line['kd_gesamt_offen'].";".$line['kd_anzahl_offen'].";".$line['rg_ruecklastschrift'].";".$line['rg_datum_mahn1'].";".$line['rg_datum_mahn2'].";"; 
		$string = $string.$line['rg_telefoniestatusM1'].";".$line['rg_telefoniestatusM2'].";".$line['rg_ruecklast_erl'].";".$line['rg_keine_sepaLG'].";".$line['rg_beschreibung'].";".$line['kd_name'].";".$line['kd_vorname'].";".$line['kd_titel'].";"; 
		$string = $string.$line['kd_geburtsdatum'].";".$line['kd_telefon'].";".$line['kd_handy'].";".$line['kd_email'].";".$line['kd_lyoness'].";".$line['kd_etoxx'].";".$line['kd_name_liefer'].";".$line['kd_str_liefer'].";"; 		
		$string = $string.$line['kd_hnr_liefer'].";".$line['kd_plz_liefer'].";".$line['kd_ort_liefer'].";".$line['erreicht_ja_nein'].";".$line['man_bearb_ja_nein'].";".$line['daten_korr'].";".$line['vorname_korr'].";".$line['nachname_korr'].";".$line['gebdat_korr'].";".$line['strasse_korr'].";"; 				
		$string = $string.$line['hnr_korr'].";".$line['plz_korr'].";".$line['ort_korr'].";".$line['emailaend'].";".$line['kontakt_telefon'].";".$line['kontakt_telefon_falsch'].";".$line['kontakt_mobil'].";".$line['kontakt_mobil_falsch'].";"; 				
		$string = $string.$line['vereinbarung'].";".$line['objektart'].";".$line['betrag'].";".$line['zahlungsdatum'].";".$line['freitext'].";".$line['gespraechsdatum'].";".$line['gespraechszeit'].";".$line['agentenanrede'].";"; 				
		$string = $string.$line['agentenvorname'].";".$line['agentennachname'].";"; 				

		$string = $string.";"."\n"; 
        //echo $string;
        // being transformed into a newline

		//20220531/TF Konvertierung auf ANSI
		$string = iconv("UTF-8", "WINDOWS-1252", $string);
	
        fwrite($fp, $string); // will proccess /n as newline ... 	
	
}
fclose($fp);
$file = $filename;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."SCHLAUSTROM -Export - Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
