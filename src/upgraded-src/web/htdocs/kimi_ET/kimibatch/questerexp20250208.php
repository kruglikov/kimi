<html>
  <head>
     <title>KIMI-Plus - SCHLASTROM-Export V 3 20220703</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SCHLAUSTROM-Export</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select 	
'Kundennummer' kunden_nummer, -- 1
'Kunde' kunde, --  2
'BetragOffen0-30'  rg_total , -- 3
'Erreicht (ja/nein)' erreicht_ja_nein, -- 4
'aktive Nummer Telefon' kontakt_telefon, -- 15
'deaktive/falsche Nummer Telefon' kontakt_telefon_falsch, -- 15
'aktives Mobiltelefon' kontakt_mobil, -- 17
'deaktives/falsches Mobiltelefon' kontakt_mobil_falsch, -- 18
'Vereinbarung ' vereinbarung, -- 19
'Grund' objektart , -- 20
'Betrag' betrag, -- 21
'zahlungsdatum'  zahlungsdatum, -- 22
'Freitext' freitext, -- 23
'Email' email,
'Gespraechsdatum' gespraechsdatum, -- 24
'Gespraechszeit' gespraechszeit,  -- 25
'Status' anruf_status, -- 26
'AgentenAnrede' agentenanrede,  -- 27
'AgentenVorname' agentenvorname, -- 28
'AgentenNachname' agentennachname -- 29
      
		union
		select 
kunden_nummer, -- 1
kimi_decrypt(kunde), -- 2
REPLACE(REPLACE(FORMAT(sst.rg_total, 2),',',''),'.',',') rg_total, -- 3
CASE
            WHEN  IFNULL(TRIM(ticket.anruf_status_id),0)= 373 THEN  anruf_status.text
            ELSE anruf_status.text  END  erreicht_ja_nein, -- 33
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
		kimi_decrypt(ticket.email), -- 
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
join quester  sst on sst.id = ticket.ticketnr

	where ticket.mandant_id =27 
and ticket.status_id = 117 
";

$filename = "files/questerexp".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;ifs-Sb-Name;ifs-Sb-Mail;ifs-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'ifs-Aktion;AdressNr;Anmerkung;email;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
// 
while ($line = dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kunde'].";".$line['kunden_nummer'].";".$line['kunden_nummer'].";".$line['rg_total'].";"; 
		$string = $string.$line['erreicht_ja_nein'].";"; 				
		$string = $string.$line['kontakt_telefon'].";".$line['kontakt_telefon_falsch'].";".$line['kontakt_mobil'].";".$line['kontakt_mobil_falsch'].";"; 				
		$string = $string.$line['vereinbarung'].";".$line['objektart'].";".$line['betrag'].";".$line['zahlungsdatum'].";".$line['freitext'].";".$line['email'].";".$line['gespraechsdatum'].";".$line['gespraechszeit'].";".$line['agentenanrede'].";"; 				
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
