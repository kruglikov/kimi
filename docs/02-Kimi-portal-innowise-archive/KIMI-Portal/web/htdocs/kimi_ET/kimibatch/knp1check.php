<html>
  <head>
     <title>KIMI-Plus - KNP1-check</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KNP1-check</h1>
<?PHP 
//include ("db.php");
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "KNP1-Check - Start: ".$heute;
// Abfrage Status "erledigt" - Anrufstatus nicht "erreicht","unerreichbar" oder "telefonnummer falsch" oder "erreichbarap"
$query_status_anruf_status = "select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
IFNULL(anruf_status_id,0) not in (536,544,545,537)";

// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch" oder "erreichbar"
$query_status_anruf_status_pos_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 anruf_status_id  in (536,544,545,537) ";

 // Abfrage Status "erledigt" - Anrufstatus NICHT  "erreicht","unerreichbar" oder "telefonnummer falsch" oder "erreichbarap"
$query_status_anruf_status_err_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 IFNULL(anruf_status_id,0) NOT in (536,544,545,537) ";
// Abfrage Status "CONNECT oder RPC oder PTP LEER"
$query_connect_rpc_ptp = "select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 anruf_status_id in (536,544,545,537) and (dummy_text3 is null or  dummy_text4 is null or dummy_text5 is null)";

// Abfrage Status "CONNECT oder RPC oder PTP LEER"
$query_connect_rpc_ptp_data = "
select 'id', 'ticketnr', 'status_text','anruf_status_text','connect','rpc','ptp'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text,
IFNULL(dummy_text3,' ') connect, IFNULL(dummy_text4,' ') rpc ,IFNULL(dummy_text5,' ') ptp
 from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 anruf_status_id in (536,544,545,537) and (dummy_text3 is null or  dummy_text4 is null or dummy_text5 is null)"; 

// Check_Connect1
$query_check_connect1 = "
select count(*) anzahl_n_verarbeitet from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and 
 anruf_status_id in (536) and IFNULL(dummy_text3,0) != 1"; 
$query_check_connect1_data = "
select 'ticketnr'
UNION
select ticketnr from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and 
 anruf_status_id in (536) and IFNULL(dummy_text3,0) != 1"; 
$query_check_connect2 = "
select count(*) anzahl_n_verarbeitet from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 anruf_status_id in (544,545,537) and IFNULL(dummy_text3,0) = 1";  
$query_check_connect2_data = "
select 'ticketnr'
UNION
select ticketnr  from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and
 anruf_status_id in (544,545,537) and IFNULL(dummy_text3,0) = 1";  

 
// Tables für Stati-Check truncaten
$trunc_knp1erledigt = "truncate table knp1erledigt";
$trunc_knp1erreicht = "truncate table knp1erreicht";
$trunc_knp1unerreichbar = "truncate table knp1unerreichbar";
$trunc_knp1telefonnummerfalsch = "truncate table knp1telefonnummerfalsch";
$trunc_knp1erreichtap = "truncate table knp1erreichtap";
// Tables für Stati-Check INSERT
$ins_knp1erledigt = "insert into knp1erledigt
select ticket.ticketnr from ticket
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187";
$ins_knp1erreicht = "insert into knp1erreicht
select ticket.ticketnr from ticket
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and anruf_status_id = 536";
$ins_knp1erreichtap = "insert into knp1erreichtap
select ticket.ticketnr from ticket
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and anruf_status_id = 537";
$ins_knp1unerreichbar = "insert into knp1unerreichbar
select ticket.ticketnr from ticket
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and anruf_status_id = 545";
$ins_knp1telefonnummerfalsch = "insert into knp1telefonnummerfalsch
select ticket.ticketnr from ticket
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187 and anruf_status_id = 544";
// 
// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_upd_check_data = "select count(erl.ticketnr) erledigt,count(err.ticketnr) erreicht,count(unerr.ticketnr) unerreichbar,
count(telfa.ticketnr) telefonnummerfalsch,
count(err.ticketnr)+count(unerr.ticketnr)+count(telfa.ticketnr)+count(errap.ticketnr) summe ,
count(errap.ticketnr) erreichtap
from knp1erledigt erl
left outer join knp1erreicht err on erl.ticketnr = err.ticketnr
left outer join knp1unerreichbar unerr on erl.ticketnr = unerr.ticketnr
left outer join knp1telefonnummerfalsch telfa on erl.ticketnr = telfa.ticketnr
left outer join knp1erreichtap errap on erl.ticketnr = errap.ticketnr";
//
// Abfrage ob ""Gesprächszeit/Anrufer" gesetzt
$query_status_telefonat = "select count(*) anzahl_n_verarbeitet 
		from ticket 
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

where mandant_id = 40
 ) knp1_log on knp1_log.id  = ticket.id and ticket.mandant_id = knp1_log.mandant_id
*/
	where ticket.mandant_id =40 and kampagne_id <>99 and status_id <> 66 -- wenn status nicht offen
-- and  knp1_log.start_ges is null
and getLogAnrufVorhanden(ticket.id) = 0 and beginn >= DATE_SUB(curdate(), INTERVAL 1 DAY);
";
$query_status_telefonat_data = "select 
	    'ticketnr','beginn'
		union
		select 
		ticketnr,beginn
		from ticket 
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
where mandant_id = 40
 ) knp1_log on knp1_log.id  = ticket.id and ticket.mandant_id = knp1_log.mandant_id
 */
	where ticket.mandant_id =40 and kampagne_id <>99 -- and ticketnr = 48
-- and  knp1_log.start_ges is null
and getLogAnrufVorhanden(ticket.id) = 0 and beginn >= DATE_SUB(curdate(), INTERVAL 1 DAY);
";
// Select für Schnittstellen_Daten und Reporting Daten
$query_schnitt_data = "
select 
    	'IndexA',
		'IndexB',
		'ÎndexC',
		'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'GebDatum',
		'Bemerkung',
		'saldo',
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
		'zeit'
		union
		select 
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		ticket.nachname,
		ticket.vorname,
		strasse,
		plz,
		ort,
		ticket.telefon,
		ticket.telefon2,
		DATE_FORMAT(geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        beschreibung_detail,  -- Bemerkung
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        dummy_text1, -- IBAN
        dummy_text2, -- BIC#
		replace(dummy_text8,'.',','), -- Verzzinsen 
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE( ergebnis, CHAR(13,10), ' ' ), -- 'Inko-Aktion',
		null , -- 'AdressNR',
		null , -- 'Anmerkung',
        DATE_FORMAT(knp1_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(knp1_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
		knp1_log.anrede , -- 'AgentenAnrede',
        knp1_log.vorname , -- 'AgentenVorname',
        knp1_log.nachname , -- 'AgentenNachname',
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
        zeit
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
where mandant_id = 40
 ) knp1_log on knp1_log.id  = ticket.id and ticket.mandant_id = knp1_log.mandant_id
	where ticket.mandant_id =40 and kampagne_id <>99 -- and ticketnr = 48
";

//
echo "<br><br><b>Pr&uuml;fung Abfrage Status 'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_status_anruf_status);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | Anruf_Status: ".$line['anzahl_n_verarbeitet']."<br>";
//
echo "<br><br><b>Status ERLEDIGT und NICHT ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";
$result = mysqli_query($dbconn, $query_status_anruf_status_err_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
	   //	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
echo "<br><br><b>Pr&uuml;fung CONNECT oder RPC oder PTP LEER':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_connect_rpc_ptp);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;CONNECT | RPC | PTP: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_connect_rpc_ptp_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
//$drucksatz= $line['text'].";".$line['markt'].";".$line['kdnr'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['ba'].";".$line['bg'].";".$line['betrag'].";".$line['mwst_key'].";".$line['mwst_proz'].";".$line['mwst_20'].";".$line['mwst_0'].";".$line['mwst_10'].";".$line['buchungskennzeichen'].";".$line['kz_berechnung'].";".$line['lastschrift'].";".$line['gutschrift'].";".$line['text'].";".$line['herkunft'].";".$line['geaendert_von'].";";
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";".$line['connect'].";".$line['rpc'].";".$line['ptp'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}

echo "<br><b>Status ERLEDIGT und ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";
$result = mysqli_query($dbconn, $query_status_anruf_status_pos_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}

echo "<br><br><b>Truncate Tabellen für Status-Check :<br></b>";
if (mysqli_query($dbconn, $trunc_knp1erledigt))
  {
  echo "TRUNCATE TABLE KNP1ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $trunc_knp1erreicht))
  {
  echo "TRUNCATE TABLE KNP1ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $trunc_knp1erreichtap))
  {
  echo "TRUNCATE TABLE KNP1ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }  
if (mysqli_query($dbconn, $trunc_knp1unerreichbar))
  {
  echo "TRUNCATE TABLE KNP1UNERRECHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $trunc_knp1telefonnummerfalsch))
  {
  echo "TRUNCATE TABLE KNP1TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

  echo "<br><b>INSERT Tabellen für Status-Check :<br></b>";
if (mysqli_query($dbconn, $ins_knp1erledigt))
  {
  echo "INSERT TABLE KNP1ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $ins_knp1erreicht))
  {
  echo "INSERT TABLE KNP1ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $ins_knp1erreichtap))
  {
  echo "INSERT TABLE KNP1ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }  
if (mysqli_query($dbconn, $ins_knp1unerreichbar))
  {
  echo "INSERT TABLE KNP1UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $ins_knp1telefonnummerfalsch))
  {
  echo "INSERT TABLE KNP1TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

echo "<br><b>Pr&uuml;fung VOR UPATE - Status  'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

$result = mysqli_query($dbconn, $query_status_upd_check_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['erledigt'] <> $line['summe'])
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Update Status - ungleich erledigt zu erreichbar/unerreichbar/telefonnummer falsch: Erledigt: ".$line['erledigt'].$line['summe']."<br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." ErreichtAP: ".$line['erreichtap']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;

    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." ErreichtAP: ".$line['erreichtap']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;
	   }

 ?>
 
 <?PHP 
 
}

//

echo "<br><b>Pr&uuml;fung ob Telefonat im Logfile vorhanden':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_status_telefonat);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Check Telefonat im Logfile vorhanden: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_status_telefonat_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr']." ; ".$line['beginn'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
  //
  
echo "<br><br><b>Pr&uuml;fung ANRUF_STATUS ERREICHT und CONNECT NICHT = 1:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_check_connect1);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | ANRUF_STATUS ERREICHT und CONNECT NICHT = 1: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_check_connect1_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}  
  //
  
echo "<br><br><b>Pr&uuml;fung ANRUF_STATUS UNERREICHT und TELEFONNUMMERFALSCH und CONNECT = 1:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_check_connect2);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | ANRUF_STATUS UNERREICHT und TELEFONNUMMERFALSCH und CONNECT = 1: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_check_connect2_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
} 

dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>KNP1-Check - Ende: ".$heute;

?>
</body>    
</html>
