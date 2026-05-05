<html>
  <head>
     <title>KIMI-Plus - OKO-Export ZwischenBericht Santander</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO-Export ZwischenBericht Santander</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "OKO-Export Zwischenbericht - Start: ".$heute;


$query = "select aktnr ,92 vorlage, 
case  
when anzahl = 1 and text = 'Keine Telefonnummer eruierbar' then concat('SA10' ,' ', 'Keine Telefonnummer eruierbar')
when anzahl = 1 and text = 'Kein Kontakt, kein Telefon' then concat('SA10' ,' ', 'Keine Telefonnummer eruierbar')
when anzahl = 1 and text = 'Kein Kontakt' then  concat('SA14' ,' ', 'Kein Kontakt')
when anzahl = 1 and text = 'Anrufbeantworter' then  concat('SA20' ,' ', 'Anrufbeantworter')
when anzahl = 1 and text = 'Keine Antwort, Kunde legt auf' then  concat('SA30' ,' ', 'Keine Antwort, Kunde legt auf')
when anzahl = 1 and text = 'Besetzt' then  concat('SA40' ,' ', 'Besetzt')
when anzahl = 1 and text = 'Kontakt hergestellt, andere Person' then  concat('SA50' ,' ', 'Kontakt hergestellt, andere Person')
when anzahl = 1 and text = 'Kontakt hergestellt, keine Zahlungsvereinbarung' then  concat('SA60' ,' ', 'Kontakt hergestellt, keine Zahlungsvereinbarung')
when anzahl = 1 and text = 'Kontakt hergestellt, Zahlungsvereinbarung' then  concat('SA70' ,' ', 'Kontakt hergestellt, Zahlungsvereinbarung')
when anzahl > 1 and text = 'Keine Telefonnummer eruierbar' then concat('SA80' ,' ', 'Kein Kontakt, kein Telefon')
when anzahl > 1 and text = 'Kein Kontakt, kein Telefon' then  concat('SA80' ,' ', 'Kein Kontakt, kein Telefon')
when anzahl > 1 and text = 'Kein Kontakt' then  concat('SA80' ,' ', 'Kein Kontakt')
when anzahl > 1 and text = 'Anrufbeantworter' then  concat('SA90' ,' ', 'Anrufbeantworter')
when anzahl > 1 and text = 'Keine Antwort, Kunde legt auf' then  concat('SA11' ,' ', 'Keine Antwort, Kunde legt auf')
when anzahl > 1 and text = 'Besetzt' then  concat('SA12' ,' ', 'Besetzt')
when anzahl > 1 and text = 'Kontakt hergestellt, andere Person' then  concat('SA13' ,' ', 'Kontakt hergestellt, andere Person')
when anzahl > 1 and text = 'Kontakt hergestellt, keine Zahlungsvereinbarung' then  concat('SA14' ,' ', 'Kontakt hergestellt, keine Zahlungsvereinbarung')
when anzahl > 1 and text = 'Kontakt hergestellt, Zahlungsvereinbarung' then  concat('SA15' ,' ', 'Kontakt hergestellt, Zahlungsvereinbarung')
else '????'
end  korrezeichen
from okozwb where tagesdatum = curdate()
";
//
$insert_okozwb = "
insert into okozwb
select  ticket.mandant_id mandant,
		ticket.ticketnr,

        count(distinct concat(okozwb.mandant,okozwb.ticketnr,okozwb.tagesdatum) )+1, -- sum(count(*)+1), -- zaehler
        curdate() tagesdatum,
        ticket.prioritaet_id,
		prioritaet.text,
        REPLACE( dummy_text9, '/', '' ) aktnr, -- aktnr
        dummy_text3 glaeubiger, -- glaeubiger
        ticket.nachname,		 -- schuldner
        ticket.strasse,        
        ticket.ort, 
        ticket.status_id,
        status.text status,
		ticket.anruf_status_id,
        anruf_status.text anruf_status,
		now()
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
        left outer join okozwb on okozwb.mandant = ticket.mandant_id and okozwb.ticketnr = ticket.ticketnr
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
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz

 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
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
where mandant_id = 16 ) oko_log on oko_log.id  = ticket.id and ticket.mandant_id = oko_log.mandant_id
left outer join oko on oko.id = ticket.ticketnr -- INKOOEEB für Originaldaten 

	where ticket.mandant_id =16 
and ticket.status_id in (55,57) -- nicht offen und gemeldet
and dummy_text3 like '%Santander Consumer Bank GmbH%'

group by ticket.mandant_id,
		ticket.ticketnr,
        curdate(),
        ticket.prioritaet_id,
		prioritaet.text,
        REPLACE( dummy_text9, '/', '' ),
        dummy_text3,
        ticket.nachname,
        ticket.strasse,
        ticket.ort, 
        ticket.status_id,
        status.text,
		ticket.anruf_status_id,
        anruf_status.text
 ";
//


// Zwischenberichtsdatei ausgeben ...
$filename = "files/okoexpzwb".date("Ymdm").".txt";
$fp = fopen($filename, 'w');
// Tagesdaten in Zwischenberichtsdatei einspielen
if (mysqli_query($dbconn, $insert_okozwb ))
  {
  echo "<br><br>INSERT oko_scb_zwischenberichtsdatei  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT oko_scb_zwischenberichtsdatei: " . mysqli_error($dbconn);
  }
// �berschriftszeile
/*
$string = 'kundennummer;anrede;titel;vorname;nachname;gebdat;geschlecht;praemie;buchungsdatum'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 
        //fputcsv($fp, array_keys($line));
        $aktnr = $line['aktnr']; 
		$vorlage = $line['vorlage']; 
		$korrezeichen = $line['korrezeichen']; 
                	

	// being transformed into a newline
	$textzeile1 = $korrezeichen.' ';
	$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
	$textzeile2 = str_pad($textzeile2, 70, ' ');   /* mit blank auffüllen */
	$textzeile3 = str_pad($textzeile3, 70, ' ');   /* mit blank auffüllen */
	$string= $aktnr.$vorlage.$textzeile1.$textzeile2.$textzeile3.'00000000 '."\n";
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
echo "<br><br>"."OKO-Export Zwischenbericht- Ende: ".$heute;

?>
</body>    
</html>
