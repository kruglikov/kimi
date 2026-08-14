<html>
  <head>
     <title>KIMI-Plus - INFOSCORE-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INFOSCORE-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select 	
'ClientNo',
'RefNo',
'ClientCustomerRefNo',
'AcceptanceDate',
'UDF_Mahnkette',
'Stage',
'WVDatum',
'WVBearbeiter',
'UebernHF',
'RestHF',
'RestGF',
'Summe ZE GlHF',
'Summe ZE',
'FirstName',
'Name1',
'Birthdate',
'Street',
'PostalCode',
'City',
'Bundesland',
'CountryCode',
'Telefon hinterlegt',
'Mobiltelefon hinterlegt',
'Telefon',
'E-Mail hinterlegt',
'FirstNameN',
'Name1N',
'BirthdateN',
'StreetN',
'PostalCodeN',
'CityN',
'BundeslandN',
'CountryCodeN',
'TelefonN',
'MobiltelefonN',
'Text',
'manuelle Bearbeitung (ja/nein)',	
'Ratenvereinbarung (ja/nein)',	
'Ratenhöhe',
'Ratenstart',
'Abschlagszahlung (ja/nein)',
'Abschlagshöhe',
'Zahlungsdatum',

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
ifs.clientno,
ifs.refno,
ifs.client_customer_refno,
ifs.acceptancedate,
ifs.udf_mahnkette,
ifs.stage,
ifs.wv_datum,
ifs.wv_bearbeiter,
REPLACE(REPLACE(FORMAT(ifs.uebern_hf, 2),',',''),'.',','),
REPLACE(REPLACE(FORMAT(ifs.rest_hf, 2),',',''),'.',','),
REPLACE(REPLACE(FORMAT(ifs.rest_gf, 2),',',''),'.',','),
REPLACE(REPLACE(FORMAT(ifs.summe_ze_gihf, 2),',',''),'.',','),
REPLACE(REPLACE(FORMAT(ifs.summe_ze, 2),',',''),'.',','),
ifs.firstname,
ifs.name1,
ifs.birthdate,
ifs.street,
ifs.postal_code,
ifs.city,
ifs.bundesland,
ifs.country_code,
ifs.telefon_hinterlegt,
ifs.mobiltelefon_hinterlegt,
ifs.telefon,
ifs.email_hinterlegt,
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(ifs.firstname,'') THEN  ticket.vorname
            ELSE null
             END firstname, --  'Firstname'
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(ifs.name1,'') THEN ticket.nachname
            ELSE null
             END name1, --  'Name1'
		CASE
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(ifs.birthdate,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END birthdate,  --  'Birthdate',
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(ifs.street,'') THEN  ticket.strasse
            ELSE null
             END street , -- 'Street',
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(ifs.postal_code,'') THEN ticket.plz
            ELSE null
             END postalcode, --  'PostalCode'
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(ifs.city,'') THEN  ticket.ort
            ELSE null
             END city, --  'City',
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(ifs.postal_code,'') THEN 
					(CASE 	WHEN ticket.plz BETWEEN '1000' AND '1299' THEN 'Wien' 
							WHEN ticket.plz BETWEEN '2000' AND '3999' THEN 'Niederösterreich' 
							WHEN ticket.plz BETWEEN '7000' AND '7599' THEN 'Burgenland' 
							WHEN ticket.plz BETWEEN '4000' AND '4999' OR ticket.plz BETWEEN '5100' AND '5299' THEN 'Oberösterreich' 
							WHEN ticket.plz BETWEEN '5000' AND '5099' OR ticket.plz BETWEEN '5300' AND '5799' THEN 'Salzburg' 
							WHEN ticket.plz BETWEEN '8000' AND '8999' THEN 'Steiermark' 
							WHEN ticket.plz BETWEEN '9000' AND '9999' THEN 'Kärnten' 
							WHEN ticket.plz BETWEEN '6000' AND '6699' THEN 'Tirol' 
							WHEN ticket.plz BETWEEN '6700' AND '6999' THEN 'Vorarlberg' 
            ELSE 'anderes' END)
            ELSE null
             END  bundesland, --  'Bundesland',
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(ifs.city,'') THEN  'A'
            ELSE null
             END countrycode, --  'CountryCode',
        CASE
            WHEN IFNULL(ticket.dummy_text4,'') <> IFNULL('','') THEN ticket.dummy_text4
            ELSE null
             END telefon, --  'Telefon',
        CASE
            WHEN IFNULL(ticket.standort,'') <> IFNULL('','') THEN ticket.standort
            ELSE null
             END mobiltelefon, --  'Mobiltelefon',
REPLACE(REPLACE( 
CONCAT(anruf_status.text,' ',ergebnis 
, 
		CASE
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(ifs.birthdate,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN CONCAT(' GeburtsdatumNEU: ', DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d'),' ' )
            ELSE ' '
             END
,     ifs_log.anrede ,' ', -- 'AgentenAnrede',
        ifs_log.vorname,' ' , -- 'AgentenVorname',
        ifs_log.nachname,' ' ,
        DATE_FORMAT(ifs_log.start_ges, '%d.%m.%Y') ,' ' , -- 'Gespraechsdatum',
        TIME_FORMAT(ifs_log.start_ges, '%H:%i:%s')  -- 'Gespraechszeit',
), 
CHAR(13,10), ' ' ),';',','), -- 'Text', = ifs_aktion
janein3.text, -- 'manuelle Bearbeitung (ja/nein)',	
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag'  THEN 'Ja'
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN 'Ja'
            ELSE 'Nein'
             END ratenvereinbarung, --  ,'Ratenvereinbarung (ja/nein)',	
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag'  THEN REPLACE(REPLACE(FORMAT(ticket.dummy_number6, 2),',',''),'.',',')
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN REPLACE(REPLACE(FORMAT(ticket.dummy_number6, 2),',',''),'.',',')
            ELSE null
             END ratenhoehe, --  ,,	'Ratenhöhe',
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag'  THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Kontakt' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')

            ELSE null
             END ratenstart, --  ,,	,'Ratenstart',
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN 'Ja'
            WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN 'Ja'
            ELSE 'Nein'
             END abschlagszahlung, -- 'Abschlagszahlung (ja/nein)',
        CASE
            WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN REPLACE(REPLACE(FORMAT(IFNULL(ticket.dummy_number6,CAST((rest_gf/2) AS DECIMAL(8,2))), 2),',',''),'.',',')		
			WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN REPLACE(REPLACE(FORMAT(CAST(((ifs.rest_gf/100)*60) AS DECIMAL(8,2)), 2),',',''),'.',',')		
			ELSE null
             END abschlagshoehe, -- 'Abschlagshöhe',
        CASE
				WHEN IFNULL(nummern2.text ,'') ='JA-Einmal-Abschlag' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')
				WHEN IFNULL(nummern2.text ,'') ='JA-Raten-Abschlag' THEN DATE_FORMAT(ticket.dummy_date1, '%Y.%m.%d')
				ELSE null
				 END zahlungsdatum, -- 'Zahlungsdatum',
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
            WHEN IFNULL(TRIM(IFNULL(ticket.email,'')),'') <> IFNULL(TRIM(IFNULL(ifs.email_hinterlegt,'')),'') THEN CONCAT('', IFNULL(ticket.email,''), '')
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
join ifs2 ifs on ifs.id = ticket.ticketnr

	where ticket.mandant_id =27 
-- and ticket.status_id = 117 
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
        $string = $line['ClientNo'].";".$line['RefNo'].";".$line['ClientCustomerRefNo'].";".$line['AcceptanceDate'].";".$line['UDF_Mahnkette'].";".$line['Stage'].";".$line['WVDatum'].";".$line['WVBearbeiter'].";".$line['UebernHF'].";"; 
		$string = $string.$line['RestHF'].";".$line['RestGF'].";".$line['Summe ZE GlHF'].";".$line['Summe ZE'].";".$line['FirstName'].";".$line['Name1'].";".$line['Birthdate'].";".$line['Street'].";"; 
		$string = $string.$line['PostalCode'].";".$line['City'].";".$line['Bundesland'].";".$line['CountryCode'].";".$line['Telefon hinterlegt'].";".$line['Mobiltelefon hinterlegt'].";".$line['Telefon'].";".$line['E-Mail hinterlegt'].";"; 		
		$string = $string.$line['FirstNameN'].";".$line['Name1N'].";".$line['BirthdateN'].";".$line['StreetN'].";".$line['PostalCodeN'].";".$line['CityN'].";".$line['BundeslandN'].";".$line['CountryCodeN'].";".$line['TelefonN'].";"; 				
		$string = $string.$line['MobiltelefonN'].";".$line['Text'].";".$line['manuelle Bearbeitung (ja/nein)'].";".$line['Ratenvereinbarung (ja/nein)'].";".$line['Ratenhöhe'].";".$line['Ratenstart'].";".$line['Abschlagszahlung (ja/nein)'].";".$line['Abschlagshöhe'].";".$line['Zahlungsdatum'].";"; 				
		$string = $string.$line['email_neu'].";"; 				
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
