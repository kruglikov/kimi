<html>
  <head>
     <title>KIMI-Plus - INFOSCORE-Export V 2 20181128</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INFOSCORE-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select 	
'Aktenzeichen' aktnr,  -- 1
'Uebergebene HF' uebern_hf, -- 2
'Offene HF 26.11.18' rest_hf, -- 3
'offene GF 26.11.18' rest_gf, -- 4
'WVL' wvl, -- 5
'WVL_datum' wvl_datum, -- 6
'Vorname' firstname, -- 7
'Nachname' name1, -- 8
'Geburtsdatum' birthdate, -- 9
'Adresse' street, -- 10
'PLZ' postal_code, -- 11
'Stadt' city, -- 12
'Bundesland' bundesland, -- 13
'Telefon' telefon_hinterlegt, -- 14
'Mobiltelefon' mobiltelefon_hinterlegt, -- 14
'Email' email_hinterlegt, -- 16
'SU erreicht ja/nein' su_erreicht, -- 17
'NO000 Ergebnis(04/2018 Kimi)' no000_ergebnis, -- 18
'Kommunikationseintraege ab 16.4.18 (Kimi)' kommunikationseintraege, -- 19
'Erreicht (ja/nein)' erreicht_ja_nein, -- 20
'Rueckruf von SU (ja/nein)' rueckruf_ja_nein, -- Erreicht_später/Rückruf --- 21
'manuelle Bearbeitung (ja/nein)' man_bearb_ja_nein, -- 22
'Daten korrekt (ja/nein)' daten_korr, -- 23
'Vorname Korrektur' vorname_korr, -- 24
'Nachname Korrektur' nachname_korr, -- 25
'Geburtsdatum Korrektur' gebdat_korr, -- 26
'Adresse Korrektur' strasse_korr, -- 27
'PLZ Korrektur' plz_korr, -- 28
'Stadt Korrektur' ort_korr, -- 29
'aktive Nummer Telefon' kontakt_telefon, -- 30
'deaktive/falsche Nummer Telefon' kontakt_telefon_falsch, -- 31
'aktives Mobiltelefon' kontakt_mobil, -- 32
'deaktives/falsches Mobiltelefon' kontakt_mobil_falsch, -- 33
'Ratenvereinbarung auf GF (ja/nein)' ratenvereinbarung_auf_gf_ja_nein, -- 34
'Ratenbetrag' ratenhoehe, -- 35
'Ratenstart Datum'  ratenstart, -- 36
'Abschlagszahlung (ja/nein)' abschlagszahlung_ja_nein, -- Abschlagszahlung (ja/nein) -- 37
'Abschlagsbetrag (zu bezahlender Betrag)' abschlagsbetrag, --  Abschlagshöhe -- 38
'Zahlungsfrist (Datum)' zahlungsfrist, -- Zahlungsdatum -- 39
'Abschlag in Raten (ja/nein)' abschlag_in_raten, -- 40
'Ratenbetrag zu Abschlag' ratenbetrag_zu_abschlag, -- 41
'Freitext' freitext, -- 42
'E-Mail NEU' emailaend, -- 43
'xxx',
		'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'GebDatum',
		'Bemerkung',
		'Saldo',
        'IBAN',
        'BIC',
        'Verzzinsen',
		'CONNECT',
		'RPC',
		'PTP',
        'ifs-Aktion',
		'AdressNR',
		'Anmerkung',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
		'AgentenAnrede',
        'AgentenVorname',
        'AgentenNachname',
		'X',
	    'ticketnr',
		'ClientNox',
		'anruf_status',
		'antwort_frage1_loesung',
		'antwort_frage1_telefonnummer',
		'antwort_frage2_loesungsvorschlag',
		'antwort_frage2_hintergrund',
		'wiedervorlage',
		'ergebnis',
        'status',
		'zeit',
		'beginn',
		'monat',
        'tageszeit',
        'dauergesamt',
		'Y', -- neu ab 18.1.2016
        'E-Mail',
		'kontakttel_vw',
        'kontkattel_hw',
        'adraend',
		'name_neu',
		'vorname_neu',
		'plz_neu', 
        'ort_neu',
        'strasse_neu',
		'Email_neu',
        'neuetel_vw1',
        'neuetel_hw1',
        'telefon1falsch',
        'telefon2falsch',
        'Gl.Name',
        'Gl.Ort',
		'ifs-Sb-Name',
		'ifs-Sb-Mail',
		'ifs-Sb-TelNr',
		'neuetel_vw2',
        'neuetel_hw2',
        'gebdatum_neu',
		'email_neu'
		union
		select 
ifs.aktnr, -- 1
REPLACE(REPLACE(FORMAT(ifs.uebern_hf, 2),',',''),'.',',') uebern_hf, -- 2
REPLACE(REPLACE(FORMAT(ifs.rest_hf, 2),',',''),'.',',') rest_hf, -- 3
REPLACE(REPLACE(FORMAT(ifs.rest_gf, 2),',',''),'.',',') rest_gf, -- 4
ifs.wvl wvl,  -- 5
DATE_FORMAT(ifs.wvl_datum, '%Y.%m.%d') wvl_datum, -- 6
ifs.firstname, -- 7
ifs.name1, -- 8
ifs.birthdate, -- 9
ifs.street, -- 10
ifs.postal_code, -- 11
ifs.city, -- 12
ifs.bundesland, -- 13
ifs.telefon_hinterlegt, -- 14
ifs.mobiltelefon_hinterlegt, -- 15
ifs.email_hinterlegt, -- 16
ifs.su_erreicht, -- 17
ifs.no000_ergebnis, -- 18
ifs.kommunikationseintraege, -- 19
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 373 THEN  'ja'
            ELSE 'nein'  END  erreicht_ja_nein, -- 20
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 374 THEN  'ja'
            ELSE 'nein'  END rueckruf_ja_nein, -- Erreicht_später/Rückruf --- 21
 /*CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(ifs.firstname,'') THEN  'ja'
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(ifs.name1,'') THEN 'ja'
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(ifs.birthdate,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  'ja'
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(ifs.street,'') THEN  'ja'
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(ifs.postal_code,'') THEN 'ja'
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(ifs.city,'') THEN  'ja'
            WHEN IFNULL(TRIM(IFNULL(ticket.email,'')),'') <> TRIM(SUBSTRING(email_hinterlegt, 1, (CASE WHEN (LOCATE (',', email_hinterlegt ) -1)=-1 THEN 99 ELSE LOCATE (',', email_hinterlegt ) end )-1) ) THEN 'ja'
            ELSE janein3.text END man_bearb_ja_nein, -- 	'manuelle Bearbeitung (ja/nein)' man_bearb_ja_nein, -- 22
*/
''  man_bearb_ja_nein, -- 	'manuelle Bearbeitung (ja/nein)' man_bearb_ja_nein, 17.12.2018 IMMER LEER -- 22
janein1.text, -- 'Daten korrekt (ja/nein)' daten_korr, -- 23
 CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(ifs.firstname,'') THEN  ticket.vorname
            ELSE null
             END   vorname_korr, -- 'Vorname Korrektur'-- 24
     CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(ifs.name1,'') THEN ticket.nachname
            ELSE null
             END  nachname_korr, -- 25
		CASE
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(ifs.birthdate,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdat_korr, -- 26
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(ifs.street,'') THEN  ticket.strasse
            ELSE null
             END strasse_korr, -- 27
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(ifs.postal_code,'') THEN ticket.plz
            ELSE null
             END plz_korr, -- 28
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(ifs.city,'') THEN  ticket.ort
            ELSE null
             END  ort_korr, -- 29
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 373 THEN  dummy_text4
            ELSE null  END kontakt_telefon, -- 30
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 378 THEN  dummy_text4
            ELSE null  END  kontakt_telefon_falsch, -- 31
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 373 THEN  standort
            ELSE null  END kontakt_mobil, -- 32
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 378 THEN  standort
            ELSE null  END   kontakt_mobil_falsch, -- 33
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN 'Ja'
            ELSE 'Nein'
             END  ratenvereinbarung_auf_gf_ja_nein, -- 34
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN REPLACE(REPLACE(FORMAT(ticket.dummy_number6, 2),',',''),'.',',')
            ELSE null
             END ratenhoehe, -- 35
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')

            ELSE null
             END  ratenstart, -- 36
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN 'Ja'
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN 'Ja'

            ELSE 'Nein'
             END abschlagszahlung_ja_nein, -- Abschlagszahlung (ja/nein) -- 37
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN REPLACE(REPLACE(FORMAT(IFNULL(ticket.dummy_number6,CAST((rest_gf/2) AS DECIMAL(8,2))), 2),',',''),'.',',')		
			WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN REPLACE(REPLACE(FORMAT(CAST(((ifs.rest_gf/100)*60) AS DECIMAL(8,2)), 2),',',''),'.',',')		
			ELSE null
             END abschlagsbetrag, --  Abschlagshöhe -- 38
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')
			WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')
            ELSE null
             END zahlungsfrist, -- Zahlungsdatum -- 39
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag'  THEN 'Ja'
            ELSE 'Nein'
             END  abschlag_in_raten, -- 40
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag'  THEN REPLACE(REPLACE(FORMAT(ticket.dummy_number6, 2),',',''),'.',',')
            ELSE null
             END ratenbetrag_zu_abschlag, -- 41
CONCAT(REPLACE( ergebnis, CHAR(13,10), ' ' ),' ' , IFNULL(ifs_log.anrede,''),' ' ,IFNULL(ifs_log.vorname,''),' ' ,IFNULL(ifs_log.nachname,''), ' ' ,DATE_FORMAT(IFNULL(ifs_log.start_ges,''), '%d.%m.%Y'),' ' ,TIME_FORMAT(IFNULL(ifs_log.start_ges,''), '%H:%i:%s')), -- 42
CASE
            WHEN IFNULL(TRIM(IFNULL(ticket.email,'')),'') <> TRIM(SUBSTRING(email_hinterlegt, 1, (CASE WHEN (LOCATE (',', email_hinterlegt ) -1)=-1 THEN 99 ELSE LOCATE (',', email_hinterlegt ) end )-1) ) THEN CONCAT('', IFNULL(ticket.email,''), '')
            ELSE ' '
             END email_neu, -- 43
'xxx',
		ifs.name1,
		ifs.firstname,
		ifs.street,
		ifs.postal_code,
		ifs.city,
		ifs.telefon_hinterlegt, -- telefon ORIG
		ifs.mobiltelefon_hinterlegt, -- telefon2  ORIG
		DATE_FORMAT(ifs.birthdate, '%d.%m.%Y') , -- geburtsdatum
        beschreibung_detail,  -- Bemerkung
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        'ifs.iban' , -- dummy_text1, -- IBAN
        'ifs.bic', -- dummy_text2, -- BIC
		replace(dummy_text8,'.',','), -- Verzzinsen 
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'ifs-Aktion',
		null , -- 'AdressNR',
		null , -- 'Anmerkung',
        DATE_FORMAT(ifs_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(ifs_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
		ifs_log.anrede , -- 'AgentenAnrede',
        ifs_log.vorname , -- 'AgentenVorname',
        ifs_log.nachname , -- 'AgentenNachname',
        'x',
	    ticketnr,
		kundennummer,
		anruf_status.text,
		janein1.text antwort_frage1_loesung,
		produkt.text antwort_frage1_telefonnummer,
		nummern2.text antwort_frage2_loesungsvorschlag,
		grund.text antwort_frage2_hintergrund,
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') , 
		REPLACE( ergebnis, CHAR(13,10), ' ' ),
        status.text,
        sec_to_time(ifs_log.dauerinsec) zeit,
        DATE_FORMAT(beginn, '%d.%m.%Y') , -- = Datum der Einspielung/Tag der Schnittstelle,
		DATE_FORMAT(beginn, '%M') , -- = Datum der Einspielung/Tag der Schnittstelle,
		case when DATE_FORMAT(ifs_log.start_ges, '%H') between 00 and 11 then 'VM'
              when DATE_FORMAT(ifs_log.start_ges, '%H') between 12 and 16 then 'NM'
              when DATE_FORMAT(ifs_log.start_ges, '%H') between 17 and 23 then 'AB'
               else  'UD' end ,
        -- TIME_FORMAT(ifs_log.dauer, '%H:%i:%s')
		sec_to_time(ifs_log.dauerinsec),
        'y',
        ifs.email_hinterlegt,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
         case  
            WHEN ticket.nachname <> ifs.name1 or 
                 ticket.vorname <> ifs.firstname or 
                 ticket.ort <> ifs.city or 
                 ticket.plz <> ifs.postal_code or 
                 ticket.strasse <> ifs.street
                  THEN 'JA' 
            ELSE null
             END adraend, -- Adressaenderung
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(ifs.name1,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(ifs.firstname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(ifs.postal_code,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  plzaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(ifs.city,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(ifs.street,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(TRIM(ticket.email),'') <> IFNULL(TRIM(ifs.email_hinterlegt),'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        replace(ticket.modell,' ','') modell, -- Telefon1_falsch,
        replace(ticket.amtliches_kennzeichen,' ','') amtliches_kennzeichen, -- Telefon2_falsch
        null, -- aus ifs-Schnittstelle ifs
        null, -- aus ifs-Schnittstelle ifs
		null, -- aus ifs-Schnittstelle ifs
		null, -- aus ifs-Schnittstelle ifs
		null, -- aus ifs-Schnittstelle ifs
		null, -- NEUEtelefonnr_vorwahl2,
        null, -- NEUEtelefonnr_haupt2,
		CASE
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(ifs.birthdate,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdatum_neu,  --  geburtsdatumaenderung
			 CASE
            WHEN IFNULL(TRIM(IFNULL(ticket.email,'')),'') <> TRIM(SUBSTRING(email_hinterlegt, 1, (CASE WHEN (LOCATE (',', email_hinterlegt ) -1)=-1 THEN 99 ELSE LOCATE (',', email_hinterlegt ) end )-1) ) THEN CONCAT('', IFNULL(ticket.email,''), '')
            ELSE ' '
             END email_neu
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

 ) ifs_log on ifs_log.id  = ticket.id and ticket.mandant_id = ifs_log.mandant_id
join ifs3 ifs on ifs.id = ticket.ticketnr

	where ticket.mandant_id =27 
and ticket.status_id = 117 
";

$filename = "files/ifsexp".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;ifs-Sb-Name;ifs-Sb-Mail;ifs-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'ifs-Aktion;AdressNr;Anmerkung;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['aktnr'].";".$line['uebern_hf'].";".$line['rest_hf'].";".$line['rest_gf'].";".$line['wvl'].";".$line['wvl_datum'].";".$line['firstname'].";".$line['name1'].";".$line['birthdate'].";"; 
		$string = $string.$line['street'].";".$line['postal_code'].";".$line['city'].";".$line['bundesland'].";".$line['telefon_hinterlegt'].";".$line['mobiltelefon_hinterlegt'].";".$line['email_hinterlegt'].";".$line['su_erreicht'].";"; 
		$string = $string.$line['no000_ergebnis'].";".$line['kommunikationseintraege'].";".$line['erreicht_ja_nein'].";".$line['rueckruf_ja_nein'].";".$line['man_bearb_ja_nein'].";".$line['daten_korr'].";".$line['vorname_korr'].";".$line['nachname_korr'].";"; 		
		$string = $string.$line['gebdat_korr'].";".$line['strasse_korr'].";".$line['plz_korr'].";".$line['ort_korr'].";".$line['kontakt_telefon'].";".$line['kontakt_telefon_falsch'].";".$line['kontakt_mobil'].";".$line['kontakt_mobil_falsch'].";".$line['emailaend'].";".$line['ratenvereinbarung_auf_gf_ja_nein'].";"; 				
		$string = $string.$line['ratenhoehe'].";".$line['ratenstart'].";".$line['abschlagszahlung_ja_nein'].";".$line['abschlagsbetrag'].";".$line['zahlungsfrist'].";".$line['abschlag_in_raten'].";".$line['ratenbetrag_zu_abschlag'].";".$line['freitext'].";"; 				
		$string = $string.";"."\n"; 
        //echo $string;
        // being transformed into a newline
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
echo "<br><br>"."INFOSCORE -Export - Ende: ".$heute;

?>
</body>    
</html>
