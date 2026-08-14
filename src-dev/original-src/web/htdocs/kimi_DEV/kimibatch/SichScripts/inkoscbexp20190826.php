<html>
  <head>
     <title>KIMI-Plus - INKOSCB2019826-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKOSCB20190826-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKOSCB-Export - Start: ".$heute;


$query = "select 
    	'IndexA',
		'IndexB',
		'IndexC',
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
        'Inko-Aktion',
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
		'kundennummer',
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
		'Inko-Sb-Name',
		'Inko-Sb-Mail',
		'Inko-Sb-TelNr',
		'neuetel_vw2',
        'neuetel_hw2',
        'gebdatum_neu',
		'TelNr-Apl',
		'Arb.Platz',
		'neuetel_vwa',
		'neuetel_hwa',
		'telefon_apl_falsch'
		union
		select 
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		inkoscb.name,
		inkoscb.vorname,
		inkoscb.strasse,
		inkoscb.plz,
		inkoscb.ort,
		inkoscb.telnr, -- telefon ORIG
		inkoscb.telnr2, -- telefon2  ORIG
		DATE_FORMAT(inkoscb.gebdatum, '%d.%m.%Y') , -- geburtsdatum
        inkoscb.bemerkung , -- beschreibung_detail,  -- Bemerkung
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        inkoscb.iban , -- null , -- dummy_text1, -- IBAN
        inkoscb.bic  ,-- null, -- dummy_text2, -- BIC
		inkoscb.verzinsen  ,-- replace(dummy_text8,'.',','), -- Verzzinsen 
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
		null , -- 'AdressNR',
		null , -- 'Anmerkung',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
		inko_log.anrede , -- 'AgentenAnrede',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
        'x',
	    ticketnr,
		null, -- inkoscb.kundennummer,
		anruf_status.text,
		janein1.text antwort_frage1_loesung,
		produkt.text antwort_frage1_telefonnummer,
		nummern2.text antwort_frage2_loesungsvorschlag,
		grund.text antwort_frage2_hintergrund,
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') , 
		REPLACE( ergebnis, CHAR(13,10), ' ' ),
        status.text,
        sec_to_time(inko_log.dauerinsec) zeit,
        DATE_FORMAT(beginn, '%d.%m.%Y') , -- = Datum der Einspielung/Tag der Schnittstelle,
		DATE_FORMAT(beginn, '%M') , -- = Datum der Einspielung/Tag der Schnittstelle,
		case when DATE_FORMAT(inko_log.start_ges, '%H') between 00 and 11 then 'VM'
              when DATE_FORMAT(inko_log.start_ges, '%H') between 12 and 16 then 'NM'
              when DATE_FORMAT(inko_log.start_ges, '%H') between 17 and 23 then 'AB'
               else  'UD' end ,
        -- TIME_FORMAT(inko_log.dauer, '%H:%i:%s')
		sec_to_time(inko_log.dauerinsec),
        'y',
        inkoscb.email, -- email
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
         case  
            WHEN ticket.nachname <> inkoscb.name or 
                 ticket.vorname <> inkoscb.vorname or 
                 ticket.ort <> inkoscb.ort or 
                 ticket.plz <> inkoscb.plz or 
                 ticket.strasse <> inkoscb.strasse 
                  THEN 'JA' 
            ELSE null
             END adraend, -- Adressaenderung
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(inkoscb.name,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(inkoscb.vorname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(inkoscb.plz,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  ortaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(inkoscb.ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(inkoscb.strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(TRIM(ticket.email),'') <> IFNULL(TRIM(inkoscb.email),'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
        'SantanderConsumberBank', -- aus INKO-Schnittstelle INKO2016
        'Wien', -- aus INKO-Schnittstelle INKO2016
		inkoscb.inkosbname, -- aus INKO-Schnittstelle INKO2016
		inkoscb.inkosbmail, -- aus INKO-Schnittstelle INKO2016
		inkoscb.inkosbtelnr, -- aus INKO-Schnittstelle INKO2016
		null, -- NEUEtelefonnr_vorwahl2,
        null, -- NEUEtelefonnr_haupt2,
		CASE
            WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(inkoscb.gebdatum,null) 
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdatum_neu,  --  geburtsdatumaenderung
		inkoscb.telnrapl, -- Telefonnummer Arbeitsplatz
		inkoscb.arbplatz, -- Arbeitsplatz
		dummy_text13, -- neueTel APL VWA
		dummy_text14, -- neueTel APL HWA
		dummy_text15 --  neueTel APL falsch
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
where mandant_id = 21

 ) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id
join inkoscb20190826dat inkoscb on inkoscb.id+3000 = ticket.ticketnr

 where ticket.mandant_id =21
	and ticket.status_id = 82 --  erledigt



";

$filename = "files/inkoscbexp".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;Inko-Sb-Name;Inko-Sb-Mail;Inko-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'Inko-Aktion;AdressNr;Anmerkung;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
       $string = $line['IndexA'].";".$line['IndexB'].";".$line['IndexC'].";".$line['Name'].";".$line['Vorname'].";".$line['Strasse'].";".$line['Plz'].";".$line['Ort'].";".$line['TelNr'].";"; 
		$string = $string.$line['TelNr2'].";".$line['TelNr-Apl'].";".$line['Arb.Platz'].";".$line['E-Mail'].";".$line['GebDatum'].";".$line['Saldo'].";".$line['IBAN'].";".$line['BIC'].";".$line['Gl.Name'].";".$line['Gl.Ort'].";"; 
		$string = $string.$line['Bemerkung'].";".$line['Verzzinsen'].";".$line['Inko-Sb-Name'].";".$line['Inko-Sb-Mail'].";".$line['Inko-Sb-TelNr'].";".$line['CONNECT'].";".$line['RPC'].";".$line['PTP'].";"; 		
		$string = $string.$line['Inko-Aktion'].";".$line['AdressNr'].";".$line['Anmerkung'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenAnrede'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";"; 				
		$string = $string.$line['kontakttel_vw'].";".$line['kontkattel_hw'].";".$line['Email_neu'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";"; 				
		$string = $string.$line['neuetel_vw1'].";".$line['neuetel_hw1'].";".$line['neuetel_vw2'].";".$line['neuetel_hw2'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu'].";"; 	
		$string = $string.$line['neuetel_vwa'].";".$line['neuetel_hwa'].";".$line['telefon_apl_falsch']; 						
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
echo "<br><br>"."INKOSCB20170612-Export - Ende: ".$heute;

?>
</body>    
</html>
