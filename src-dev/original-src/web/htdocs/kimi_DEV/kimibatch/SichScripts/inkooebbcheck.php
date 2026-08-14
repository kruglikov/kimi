<html>
  <head>
     <title>KIMI-Plus - INKO-OEBB-check</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-OEBB-check</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INKO-Santander-Check - Start: ".$heute;
// Abfrage Status "erledigt" - Anrufstatus nicht "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status = "select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =13 and status_id = 43 and
IFNULL(anruf_status_id,0) not in (151,157,158)";

// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status_pos_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =13 and status_id = 43 and
 anruf_status_id in (151,157,158) ";

 // Abfrage Status "erledigt" - Anrufstatus NICHT  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status_err_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =13 and status_id = 43 and
 IFNULL(anruf_status_id,0) NOT in (151,157,158) ";
// Abfrage Status "VERZOGEN oder VERSTORBEN oder INSOLVENT" gesetzt bei anruf_status erreicht
$query_check = "select count(*) anzahl_n_verarbeitet from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
		left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
		left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
		left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
where ticket.mandant_id =13 and status_id = 43 and
 anruf_status_id in  (151,157,158) and (janein2.text is null or  janein3.text is null or janein4.text is null)
 and anruf_status_id = 151";

// Abfrage Status "VERZOGEN oder VERSTORBEN oder INSOLVENT LEER" bei anruf_status erreicht
$query_check_data = "
select 'id', 'ticketnr', 'status_text','anruf_status_text','verzogen','verstorben','insolvent'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text,
IFNULL(janein2.text,' ') verzogen, IFNULL(janein3.text,' ') verstorben ,IFNULL(janein3.text,' ') insolvent
 from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
		left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
		left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
		left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
where ticket.mandant_id =13 and status_id = 43 and
 anruf_status_id in (151,157,158) and (janein2.text is null or  janein3.text is null or janein4.text is null)
 and anruf_status_id = 151"; 

// Tables für Stati-Check truncaten
$trunc_inkooebberledigt = "truncate table inkooebberledigt";
$trunc_inkooebberreicht = "truncate table inkooebberreicht";
$trunc_inkooebbunerreichbar = "truncate table inkooebbunerreichbar";
$trunc_inkooebbtelefonnummerfalsch = "truncate table inkooebbtelefonnummerfalsch";
// Tables für Stati-Check INSERT
$ins_inkooebberledigt = "insert into inkooebberledigt
select ticket.ticketnr from ticket
where ticket.mandant_id =13 and status_id = 43";
$ins_inkooebberreicht = "insert into inkooebberreicht
select ticket.ticketnr from ticket
where ticket.mandant_id =13 and status_id = 43 and anruf_status_id = 151";
$ins_inkooebbunerreichbar = "insert into inkooebbunerreichbar
select ticket.ticketnr from ticket
where ticket.mandant_id =13 and  status_id = 43 and anruf_status_id = 158";
$ins_inkooebbtelefonnummerfalsch = "insert into inkooebbtelefonnummerfalsch
select ticket.ticketnr from ticket
where ticket.mandant_id =13 and status_id = 43 and anruf_status_id = 157";
// 
// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_upd_check_data = "select count(erl.ticketnr) erledigt,count(err.ticketnr) erreicht,count(unerr.ticketnr) unerreichbar,
count(telfa.ticketnr) telefonnummerfalsch,
count(err.ticketnr)+count(unerr.ticketnr)+count(telfa.ticketnr) summe 
from inkooebberledigt erl
left outer join inkooebberreicht err on erl.ticketnr = err.ticketnr
left outer join inkooebbunerreichbar unerr on erl.ticketnr = unerr.ticketnr
left outer join inkooebbtelefonnummerfalsch telfa on erl.ticketnr = telfa.ticketnr";
//
// Abfrage ob ""Gesprächszeit/Anrufer" gesetzt
$query_status_telefonat = "select count(*) anzahl_n_verarbeitet 
		from ticket 
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
where mandant_id = 13
 ) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id
	where ticket.mandant_id =13 and status_id <> 45 -- wenn status nicht offen
and  inko_log.start_ges is null
";
$query_status_telefonat_data = "select 
	    'ticketnr'
		union
		select 
		ticketnr
		from ticket 
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
where mandant_id = 13
 ) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id
	where ticket.mandant_id =13 and status_id <> 45 -- wenn status nicht offen
and  inko_log.start_ges is null
";
// Select für Schnittstellen_Daten und Reporting Daten
$query_schnitt_data = "
select 
    	'IndexA',
		'IndexB',
		'IndexC',
		'GL-Name',
		'Übergabedatum',
        'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'GebDatum',
		'saldo',
        'IBAN',
        'BIC',
		'Bemerkung',
        'Verzzinsen',
		'Tel.Nr.falsch',
        'verzogen',
		'verstorben',
		'insolvent',
		'Email',
        'Tel1.',
		'Tel2.',
        'Geb.Dat.',
		'Name',
        'Adr.',
        'Inko-Aktion',
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
		'FreisFeld',
	    'status',
		'zeit'
		union
		select 
		inkooebb.indexa,
        inkooebb.indexb,
        inkooebb.indexc,
        inkooebb.glname,
        DATE_FORMAT(inkooebb.uebergabedatum, '%d.%m.%Y') , -- uebergabedatum
		inkooebb.name,
		inkooebb.vorname,
		inkooebb.strasse,
		inkooebb.plz,
		inkooebb.ort,
		inkooebb.telnr,
		inkooebb.telnr2,
		DATE_FORMAT(inkooebb.gebdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(inkooebb.saldo, 2),',',''),'.',',') , -- Saldo
        inkooebb.iban, -- IBAN
        inkooebb.bic, -- BIC#
        inkooebb.bemerkung,  -- Bemerkung
		replace(inkooebb.verzzinsen,'.',','), -- Verzzinsen 
        CASE 
            WHEN ticket.dummy_text4 is not null THEN 'Ja' 
            ELSE null
             END , -- Tel.Nr.falsch
        janein2.text, -- 'verzogen',
		janein3.text, -- 'verstorben',
		janein4.text, -- 'insolvent',
        ticket.email, -- Email
        CASE 
            WHEN ticket.telefon <> inkooebb.telnr THEN ticket.telefon
            ELSE null
             END , --  Tel1.
       CASE 
            WHEN ticket.telefon2 <> inkooebb.telnr THEN ticket.telefon2
            ELSE null
             END , --  Tel2.
	   CASE 
            WHEN ticket.geburtsdatum <> inkooebb.gebdatum THEN DATE_FORMAT(geburtsdatum, '%d.%m.%Y')
            ELSE null
             END , -- Geb.Dat.
        CASE 
            WHEN ticket.nachname <> inkooebb.name
				or ticket.vorname <> inkooebb.vorname THEN CONCAT(ticket.vorname,' ',ticket.nachname) 
            ELSE null
             END , -- Name
        CASE 
            WHEN ticket.plz <> inkooebb.plz or 
                 ticket.ort <> inkooebb.ort or 
                 ticket.strasse <> inkooebb.strasse 
                  THEN CONCAT(ticket.plz,',',TRIM(ticket.ort),',',TRIM(ticket.strasse),' ',ticket.hausnummer,' ',ticket.hausnummer_erw) 
            ELSE null
             END , -- Adr.	
		REPLACE( ergebnis, CHAR(13,10), ' ' ), -- 'Inko-Aktion',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
		inko_log.anrede , -- 'AgentenAnrede',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
        'X', 
		ticketnr,
		kundennummer,
		anruf_status.text,
		janein1.text antwort_frage1_loesung,
		produkt.text antwort_frage1_telefonnummer,
		nummern2.text antwort_frage2_loesungsvorschlag,
		grund.text antwort_frage2_hintergrund,
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') , 
		REPLACE( ergebnis, CHAR(13,10), ' ' ),
        dummy_text5, -- FreiesFeld
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
where mandant_id = 13 ) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id
left outer join inkooebb on inkooebb.id = ticket.ticketnr -- INKOOEEB für Originaldaten 
	where ticket.mandant_id =13 
";
//
echo "<br><br><b>Pr&uuml;fung Abfrage Status 'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_status_anruf_status);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | Anruf_Status: ".$line['anzahl_n_verarbeitet']."<br>";
//
echo "<br><br><b>Status ERLEDIGT und NICHT ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";
$result = mysql_query($query_status_anruf_status_err_data);
while ($line = mysql_fetch_array($result)) { ?>
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
echo "<br><br><b>Pr&uuml;fung VERZOGEN oder VERSTORBEN oder INSOLVENT LEER bei anruf_status erreicht?':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_check);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;VERZOGEN | VERSTORBEN | INSOLVENT bei anruf_status erreicht?: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysql_query($query_check_data);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
//$drucksatz= $line['text'].";".$line['markt'].";".$line['kdnr'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['ba'].";".$line['bg'].";".$line['betrag'].";".$line['mwst_key'].";".$line['mwst_proz'].";".$line['mwst_20'].";".$line['mwst_0'].";".$line['mwst_10'].";".$line['buchungskennzeichen'].";".$line['kz_berechnung'].";".$line['lastschrift'].";".$line['gutschrift'].";".$line['text'].";".$line['herkunft'].";".$line['geaendert_von'].";";
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";".$line['verzogen'].";".$line['verstorben'].";".$line['insolvent'].";";
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
$result = mysql_query($query_status_anruf_status_pos_data);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}

echo "<br><br><b>Truncate Tabellen für Status-Check :<br></b>";
if (mysql_query($trunc_inkooebberledigt))
  {
  echo "TRUNCATE TABLE INKOOEBBERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($trunc_inkooebberreicht))
  {
  echo "TRUNCATE TABLE INKOOEBBERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($trunc_inkooebbunerreichbar))
  {
  echo "TRUNCATE TABLE INKOOEBBUNERERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($trunc_inkooebbtelefonnummerfalsch))
  {
  echo "TRUNCATE TABLE INKOOEBBTELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

  echo "<br><b>INSERT Tabellen für Status-Check :<br></b>";
if (mysql_query($ins_inkooebberledigt))
  {
  echo "INSERT TABLE INKOEBBERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($ins_inkooebberreicht))
  {
  echo "INSERT TABLE INKOOEBBERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($ins_inkooebbunerreichbar))
  {
  echo "INSERT TABLE INKOOEBBUNERERCIHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($ins_inkooebbtelefonnummerfalsch))
  {
  echo "INSERT TABLE INKOOEBBTELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

echo "<br><b>Pr&uuml;fung VOR UPATE - Status  'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

$result = mysql_query($query_status_upd_check_data);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['erledigt'] <> $line['summe'])
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Update Status - ungleich erledigt zu erreichbar/unerreichbar/telefonnummer falsch: Erledigt: ".$line['erledigt']." - ".$line['summe']."<br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;

    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;
	   }

 ?>
 
 <?PHP 
 
}

//

echo "<br><b>Pr&uuml;fung ob Telefonat im Logfile vorhanden':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_status_telefonat);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Check Telefonat im Logfile vorhanden: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysql_query($query_status_telefonat_data);
while ($line = mysql_fetch_array($result)) { ?>
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

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>INKO-Santander-Check - Ende: ".$heute;

?>
</body>    
</html>
