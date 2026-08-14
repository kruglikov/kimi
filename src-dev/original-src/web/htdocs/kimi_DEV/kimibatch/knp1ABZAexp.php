<html>
  <head>
     <title>KIMI-Plus - KNP1-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KNP1-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KNP1-Export - Start: ".$heute;


$query = "select 
    'aktkz1',
    'aktkz2',
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
    'telefonisch_erreicht',
    'schuldner_erreicht',
    'vereinbarung_bezahlung',
    'ergebnis_telefonat',
    'AdressNR',
    'Anmerkung',
    'gespraechsdatum',
    'gespraechszeit',
    'anruf_status',
    'agent',
    'AgentenAnrede',
    'AgentenVorname',
    'AgentenNachname',
    'X',
    'ticketnr',
    'kundennummer',
    'kontaktstatus',
    'loeschungsbereitschaft',
    'vorlage',
    'vereinbarung_zahlart',
    'beschaeftigungsstatus',
    'wiedervorlage',
    'ergebnis',
    'status',
    'zeit',
    'beginn',
    'monat',
    'tageszeit',
    'dauergesamt',
    'Y',
    'E-Mail',
    'kontakt_telefonnummer',
    'kontkattel_hw',
    'adraend',
    'name_neu',
    'vorname_neu',
    'plz_neu',
    'ort_neu',
    'strasse_neu',
    'Email_neu',
    'neue_telefonnummer',
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
    'betrag_hoehe',
    'datum_zahlung',
	'ratenanzahl',
	'erklaerung'


union select 
    KNP1.indexa,
    KNP1.indexb,
    null,
    KNP1.name,
    KNP1.vorname,
    KNP1.strasse,
    KNP1.plz,
    KNP1.ort,
    KNP1.telnr,
    KNP1.telnr2,
    DATE_FORMAT(KNP1.gebdatum, '%d.%m.%Y'),
    beschreibung_detail,
    REPLACE(REPLACE(FORMAT(dummy_number4, 2),
            ',',
            ''),
        '.',
        ','),
    KNP1.iban,
    KNP1.bic,
    replace(dummy_text8, '.', ','),
    dummy_text3,
    dummy_text4,
    dummy_text5,
    REPLACE(REPLACE(ergebnis, CHAR(13, 10), ' '),
        ';',
        ','),
    null,
    null,
    DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y'),
    TIME_FORMAT(inko_log.start_ges, '%H:%i:%s'),
    anruf_status.text,
    CONCAT(inko_log.anrede, ' ',inko_log.vorname, ' ',inko_log.nachname ),
    inko_log.anrede,
    inko_log.vorname,
    inko_log.nachname,
    'x',
    ticketnr,
    kundennummer,
	CASE WHEN anruf_status_id = 536 THEN TRIM(SUBSTR(prioritaet.text,1,5))
		ELSE anruf_status.text
	END  kontaktstatus , --  anruf_status.text,
    janein1.text antwort_frage1_loesung,
    produkt.text vorlage,
    nummern2.text antwort_frage2_loesungsvorschlag,
    grund.text antwort_frage2_hintergrund,
    DATE_FORMAT(wiedervorlage, '%Y-%c-%d'),
    REPLACE(ergebnis, CHAR(13, 10), ' '),
    status.text,
    sec_to_time(inko_log.dauerinsec) zeit,
    DATE_FORMAT(beginn, '%d.%m.%Y'),
    DATE_FORMAT(beginn, '%M'),
    case
        when DATE_FORMAT(inko_log.start_ges, '%H') between 00 and 11 then 'VM'
        when DATE_FORMAT(inko_log.start_ges, '%H') between 12 and 16 then 'NM'
        when DATE_FORMAT(inko_log.start_ges, '%H') between 17 and 23 then 'AB'
        else 'UD'
    end,
    sec_to_time(inko_log.dauerinsec),
    'y',
    KNP1.email,
    ticket.verkaeufercode,
    ticket.standort,
    case
        WHEN
            ticket.nachname <> KNP1.name
                or ticket.vorname <> KNP1.vorname
                or ticket.ort <> KNP1.ort
                or ticket.plz <> KNP1.plz
                or ticket.strasse <> KNP1.strasse
        THEN
            'JA'
        ELSE null
    END adraend,
    CASE
        WHEN IFNULL(ticket.nachname, '') <> IFNULL(KNP1.name, '') THEN ticket.nachname
        ELSE null
    END nameaenderung,
    CASE
        WHEN IFNULL(ticket.vorname, '') <> IFNULL(KNP1.vorname, '') THEN ticket.vorname
        ELSE null
    END vornamensaenderung,
    CASE
        WHEN IFNULL(ticket.plz, '') <> IFNULL(KNP1.plz, '') THEN ticket.plz
        ELSE null
    END ortaenderung,
    CASE
        WHEN IFNULL(ticket.ort, '') <> IFNULL(KNP1.ort, '') THEN ticket.ort
        ELSE null
    END ortaenderung,
    CASE
        WHEN IFNULL(ticket.strasse, '') <> IFNULL(KNP1.strasse, '') THEN ticket.strasse
        ELSE null
    END strassenaenderung,
    CASE
        WHEN IFNULL(TRIM(ticket.email), '') <> IFNULL(TRIM(KNP1.email), '') THEN ticket.email
        ELSE null
    END emailaenderung,
    ticket.verkaeufername,
    ticket.markencode,
    ticket.modell,
    ticket.amtliches_kennzeichen,
    KNP1.glname,
    KNP1.glort,
    KNP1.sbname,
    KNP1.sbemail,
    KNP1.sbtelnr,
    null,
    null,
    CASE
        WHEN
            IFNULL(ticket.geburtsdatum, null) <> IFNULL(KNP1.gebdatum, null)
                and IFNULL(ticket.geburtsdatum, null) <= '2010-01-01'
        THEN
            DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d')
        ELSE null
    END gebdatum_neu,
    REPLACE(REPLACE(FORMAT(dummy_number6, 2),
            ',',
            ''),
        '.',
        ','), -- 'betrag_hoehe' = Zahlbetrag,
    DATE_FORMAT(dummy_date1, '%d.%m.%Y'), -- 'datum_zahlung',
	dummy_text11 ratenanzahl, -- mögliche Raten
	    CASE
        WHEN prioritaet_id = 192 THEN prioritaet.text
		WHEN prioritaet_id = 193 THEN prioritaet.text
        ELSE null
    END erklaerung
from
    ticket
        left outer join
    status status ON status.id = ticket.status_id
        left outer join
    prioritaet prioritaet ON prioritaet.id = ticket.prioritaet_id
        left outer join
    benutzer ON benutzer.id = ticket.benutzer_id
        left outer join
    anruf_status ON anruf_status.id = ticket.anruf_status_id
        left outer join
    grund ON grund.id = ticket.grund_id
        left outer join
    firma ON firma.id = ticket.firma_id
        left outer join
    produkt ON produkt.id = ticket.produkt_id
        left outer join
    janein janein1 ON janein1.id = ticket.textant11_janein_id
        left outer join
    janein janein2 ON janein2.id = ticket.textant21_janein_id
        left outer join
    janein janein3 ON janein3.id = ticket.textant31_janein_id
        left outer join
    janein janein4 ON janein4.id = ticket.textant41_janein_id
        left outer join
    nummern nummern1 ON nummern1.id = ticket.textant12_nummern_id
        left outer join
    nummern nummern2 ON nummern2.id = ticket.textant22_nummern_id
        left outer join
    (select 
        letzt_log . *, ben.vorname, ben.nachname, ben.anrede
    from
        (select 
        log.start_objekt_id id,
            avg(ticketnr),
            max(start_timestamp) start_ges,
            max(end_timestamp) end_ges,
            count(*) anz_bearbeitungen,
            TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
            min(lastuser) benutzer,
            min(mandant_id) mandant_id,
            SUBSTRING(max(lastuser_franz), 20, 99) lastuser_franz,
            sum(dauer1) dauer,
            sum(dauerinsec) dauerinsec
    from
        (select 
        start.id start_id,
            start.objekt start_objekt,
            start.objekt_id start_objekt_id,
            start.logart start_logart,
            start.timestamp start_timestamp,
            start.benutzer start_benutzer,
            start.start_id start_start_id,
            end.id end_id,
            end.objekt end_objekt,
            end.objekt_id end_objekt_id,
            end.logart end_logart,
            end.timestamp end_timestamp,
            end.benutzer end_benutzer,
            end.start_id end_start_id,
            end.timestamp - start.timestamp dauer2,
            TIMEDIFF(end.timestamp, start.timestamp) dauer1,
            time_to_sec(TIMEDIFF(end.timestamp, start.timestamp)) dauerinsec,
            t.ticketnr,
            t.mandant_id mandant_id,
            get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
            concat(start.timestamp, start.benutzer) lastuser_franz
    from
        log start
    left outer JOIN (select 
        *
    from
        log
    where
        logart in ('MAN_END' , 'MAN_END_A')) end ON start.id = end.start_id
    join ticket t ON t.id = start.objekt_id
    where
        start.logart in ('MAN_START')) log
    group by log.start_objekt_id) letzt_log
    left outer join benutzer ben ON ben.name = letzt_log.benutzer
    where
        mandant_id = 40) inko_log ON inko_log.id = ticket.id
        and ticket.mandant_id = inko_log.mandant_id
        join
    knp1 KNP1 ON KNP1.id = ticket.ticketnr
where
    ticket.mandant_id = 40
        and ticket.status_id = 187 
and (  (ticket.anruf_status_id in (536,537) and ticket.prioritaet_id != 176)
 ) -- und erreicht bzw- erreicht anderer Person und  Abschlussgründe
";

$filename = "files/KNP1_ABZA_exp_auto_".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;Inko-Sb-Name;Inko-Sb-Mail;Inko-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'Inko-Aktion;AdressNr;Anmerkung;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
// 
if ($result) {
    while ($line = mysqli_fetch_array($result)) { 
            //fputcsv($fp, array_keys($line));
            /*
            $string = $line['IndexA'].";".$line['IndexB'].";".$line['IndexC'].";".$line['Name'].";".$line['Vorname'].";".$line['Strasse'].";".$line['Plz'].";".$line['Ort'].";".$line['TelNr'].";"; 
            $string = $string.$line['TelNr2'].";".$line['TelNr-Apl'].";".$line['Arb.Platz'].";".$line['E-Mail'].";".$line['GebDatum'].";".$line['Saldo'].";".$line['IBAN'].";".$line['BIC'].";".$line['Gl.Name'].";".$line['Gl.Ort'].";"; 
            $string = $string.$line['Bemerkung'].";".$line['Verzzinsen'].";".$line['Inko-Sb-Name'].";".$line['Inko-Sb-Mail'].";".$line['Inko-Sb-TelNr'].";".$line['CONNECT'].";".$line['RPC'].";".$line['PTP'].";"; 		
            $string = $string.$line['Inko-Aktion'].";".$line['AdressNr'].";".$line['Anmerkung'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenAnrede'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";"; 				
            $string = $string.$line['kontakttel_vw'].";".$line['kontkattel_hw'].";".$line['Email_neu'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";"; 				
            $string = $string.$line['neuetel_vw1'].";".$line['neuetel_hw1'].";".$line['neuetel_vw2'].";".$line['neuetel_hw2'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu'].";";  				
            $string = $string.$line['neuetel_vwa'].";".$line['neuetel_hwa'].";".$line['telefon_apl_falsch']; 						
            $string = $string.";"."\n"; 
            */
            //2020-06-02
            $string = $line['aktkz1'].";".$line['aktkz2'].";".$line['IndexC'].";"; 
            $string = $string.$line['telefonisch_erreicht'].";".$line['schuldner_erreicht'].";".$line['vereinbarung_bezahlung'].";"; 		
            $string = $string.$line['ergebnis_telefonat'].";".$line['gespraechsdatum'].";".$line['gespraechszeit'].";".$line['kontaktstatus'].";".$line['agent'].";"; 				
            $string = $string.$line['kontakt_telefonnummer'].";".$line['Email_neu'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";"; 				
            $string = $string.$line['neue_telefonnummer'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu'].";";  				
            $string = $string.$line['vorlage'].";".$line['vereinbarung_zahlart'].";".$line['betrag_hoehe'].";".$line['ratenanzahl'].";".$line['erklaerung'].";".$line['datum_zahlung'].";".$line['beschaeftigungsstatus']; 						
            $string = $string.";"."\n"; 
            
            //echo $string;
            // being transformed into a newline
            //fwrite($fp, $string); // will proccess /n as newline ... 	
            if ($convert_export_csvUtf82Ansi) {
                fwrite($fp, convert2ANSI($string)); // will proccess /n as newline ... 	
            } else {
                fwrite($fp, $string); // will proccess /n as newline ... 	
            }
    }
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
    if (ob_get_length() > 0) {
        ob_clean();
    }
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."KNP1-Export - Ende: ".$heute;
mysqli_close($dbconn);
?>
</body>    
</html>
