<html>
  <head>
     <title>OKO-Export KIMI-Plus</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO-Export</h1>
<?PHP

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "OKO-Export - Start: ".$heute;

/* ORIGINAL DEVIS-Selektion
CREATE OR REPLACE VIEW V_KRSV_PRAEMIEN_STAT AS
SELECT kusu.kundennummer,
			 an1.an1_anrede_text anrede,
			 pers.titel,
			 pers.vorname,
			 pers.nachname,
			 pers.gebdat,
			 an1.sex_kz geschlecht,
			 CASE
				 WHEN tdbg.kz_berechnung = 'P' --Lastschrift
					THEN
			      CASE WHEN nvl(buch.buchungskennzeichen,0) IN (0, 2) THEN
              NVL(buch.betrag, 0) * -1
            ELSE --Storno
              NVL(buch.betrag, 0)
            END
				 ELSE
					CASE
				 WHEN NVL(buch.buchungskennzeichen, 0) IN (0, 2) THEN
					NVL(buch.betrag, 0)
				 ELSE --Storno
					NVL(buch.betrag, 0) * -1
			 END END praemie,
			 buch.buchungsdatum
	FROM buchungen buch
  JOIN t_buchgrund_markt tbgm ON tbgm.id = buch.t_buchgrund_markt_oid
	JOIN t_db_buchgrund tdbg ON tdbg.id = tbgm.t_db_buchgrund_oid
	JOIN t_db_buchart tdba ON tdba.id = tdbg.t_db_buchart_oid
	JOIN kundensuche kusu ON kusu.kunde_oid = buch.adr_id
	JOIN person pers ON pers.ID = kusu.person_oid
	JOIN t_anrede an1 ON an1.ID = pers.t_anrede_oid
 WHERE tdba.buchungsart IN (40 --Lastschrift Pr�mie
			 , 50 -- Gutschrift Pr�mie
			 )
	 AND tdbg.buchungsgrund = 30 --Pr�mienbuchung
*/

$query = "select 
		ticket.ticketnr,
        REPLACE( dummy_text9, '/', '' ) aktnr, -- aktnr
        dummy_text5 sachbearbeiter, -- sachbearabeiter
        dummy_text3 glaeubiger, -- glaeubiger
        kimi_decrypt(ticket.nachname),		 -- schuldner
        kimi_decrypt(ticket.strasse),        
		kimi_decrypt(ticket.ort), 
        kimi_decrypt(dummy_text8), -- mitschuldner
        REPLACE( beschreibung_detail, CHAR(13,10), ' ' ) beschreibung_detail, 
        ticket.dummy_number4 saldo,
        kimi_decrypt(ticket.telefon)  telnr1,
		kimi_decrypt(ticket.telefon2) telnr2,
        ticket.dummy_text4 kontakttelefonnr,
	  	ticket.dummy_text1 iban,
        ticket.dummy_text2 bic,
	    ticket.dummy_text10 bemerkung,
	    kimi_decrypt(ticket.geburtsdatum) geburtsdatum,
	    ticket.dummy_number1 ratenanzahl,
	    REPLACE(CAST(IFNULL(ticket.dummy_number2,0) AS CHAR), '.', ',') ratenhoehe,
	    ticket.dummy_number3 gesamtzahlung,
        CASE 
            WHEN kimi_decrypt(ticket.nachname) <> kimi_decrypt(oko.schuldner) or 
                 kimi_decrypt(ticket.ort) <> kimi_decrypt(oko.schuldner_ort) or 
                 kimi_decrypt(ticket.strasse) <> kimi_decrypt(oko.schuldner_strasse) 
                  THEN 'JA' 
            ELSE null
             END adraend, -- Adressaenderung
        CASE
            WHEN kimi_decrypt(ticket.nachname) <> kimi_decrypt(oko.schuldner) THEN CONCAT('NAME: ', kimi_decrypt(ticket.nachname))
            ELSE null
             END namensaenderung, --  ortaenderung
        CASE
            WHEN kimi_decrypt(ticket.ort) <>  kimi_decrypt(oko.schuldner_ort) THEN CONCAT('ORT: ', kimi_decrypt(ticket.ort))
            ELSE null
             END ortaenderung, --  ortaenderung
        CASE
            WHEN kimi_decrypt(ticket.strasse) <> kimi_decrypt(oko.schuldner_strasse) THEN CONCAT('STR: ', kimi_decrypt(ticket.strasse))
            ELSE null
             END strassenaenderung , --  strassenaenderung
        status.text status,
        anruf_status.text anruf_status, 
		janein2.text adresscheck,
		janein3.text vorlage,
		janein4.text emailcheck,
		janein1.text arbeitgeberdaten,
		IFNULL(nummern2.text,'k.A.') loesungsvorschlag,
		grund.text ratenbriefhinweis,
        REPLACE(CAST(IFNULL(dummy_number6,0) AS CHAR), '.', ',') ratenhoehe_verein,
        DATE_FORMAT(dummy_date1, '%d-%m-%Y') ratenzahlung_am, 		
		ticket.kenner stadiumbewertung,
        CASE
            WHEN IFNULL(kimi_decrypt(ticket.email),'') <> IFNULL(kimi_decrypt(oko.email01),'') THEN  kimi_decrypt(ticket.email)
            ELSE null
             END email,
        kimi_decrypt(ticket.geburtsdatum) geburtsdatum,
        standort neuetelnr, 
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') wiedervorlage , 
		REPLACE( CONCAT(ergebnis, ' Identifikation: ',
        case when janein3.text = 'Ja' and anruf_status.text = 'Unerreichbar' then ifnull(janein2.text,'') else janein2.text end), 
        CHAR(13,10), ' ' ) ergebnis,
        status.text status_text,
		anruf_status.text anruf_status_text,
      --  getLogZeit(ticket.id, '') zeit, -- sec_to_time(inko_log.dauerinsec) zeit,
         DATE_FORMAT(getLogStartGes(ticket.id, ''), '%d.%m.%Y') gespraechsdatum, -- 'Gespraechsdatum',
         TIME_FORMAT(getLogStartGes(ticket.id, ''), '%H:%i:%s') gespraechszeit, -- 'Gespraechszeit',
		getLogAgentAnrede(ticket.id, '') ag_anrede, 		-- knp1_log.anrede , -- 'AgentenAnrede',
        getLogAgentVorname(ticket.id, '') ag_vorname, 		-- knp1_log.vorname , -- 'AgentenVorname',
        getLogAgentNachname(ticket.id, '') ag_nachname, 	-- knp1_log.nachname , -- 'AgentenNachname',

/*		
case  
when okozwb.anzahl = 1 and okozwb.text = 'Keine Telefonnummer eruierbar' then concat('SA10' ,' ', 'Keine Telefonnummer eruierbar')
when okozwb.anzahl = 1 and okozwb.text = 'Kein Kontakt, kein Telefon' then concat('SA10' ,' ', 'Keine Telefonnummer eruierbar')
when okozwb.anzahl = 1 and okozwb.text = 'Kein Kontakt' then  concat('SA14' ,' ', 'Kein Kontakt')
when okozwb.anzahl = 1 and okozwb.text = 'Anrufbeantworter' then  concat('SA20' ,' ', 'Anrufbeantworter')
when okozwb.anzahl = 1 and okozwb.text = 'Keine Antwort, Kunde legt auf' then  concat('SA30' ,' ', 'Keine Antwort, Kunde legt auf')
when okozwb.anzahl = 1 and okozwb.text = 'Besetzt' then  concat('SA40' ,' ', 'Besetzt')
when okozwb.anzahl = 1 and okozwb.text = 'Kontakt hergestellt, andere Person' then  concat('SA50' ,' ', 'Kontakt hergestellt, andere Person')
when okozwb.anzahl = 1 and okozwb.text = 'Kontakt hergestellt, keine Zahlungsvereinbarung' then  concat('SA60' ,' ', 'Kontakt hergestellt,keine Zahlungsvereinbarung')
when okozwb.anzahl = 1 and okozwb.text = 'Kontakt hergestellt, Zahlungsvereinbarung' then  concat('SA70' ,' ', 'Kontakt hergestellt,Zahlungsvereinbarung')
when okozwb.anzahl > 1 and okozwb.text = 'Keine Telefonnummer eruierbar' then concat('SA80' ,' ', 'Kein Kontakt, kein Telefon')
when okozwb.anzahl > 1 and okozwb.text = 'Kein Kontakt, kein Telefon' then  concat('SA80' ,' ', 'Kein Kontakt, kein Telefon')
when okozwb.anzahl > 1 and okozwb.text = 'Kein Kontakt' then  concat('SA80' ,' ', 'Kein Kontakt')
when okozwb.anzahl > 1 and okozwb.text = 'Anrufbeantworter' then  concat('SA90' ,' ', 'Anrufbeantworter')
when okozwb.anzahl > 1 and okozwb.text = 'Keine Antwort, Kunde legt auf' then  concat('SA11' ,' ', 'Keine Antwort, Kunde legt auf')
when okozwb.anzahl > 1 and okozwb.text = 'Besetzt' then  concat('SA12' ,' ', 'Besetzt')
when okozwb.anzahl > 1 and okozwb.text = 'Kontakt hergestellt, andere Person' then  concat('SA13' ,' ', 'Kontakt hergestellt, andere Person')
when okozwb.anzahl > 1 and okozwb.text = 'Kontakt hergestellt, keine Zahlungsvereinbarung' then  concat('SA14' ,' ', 'Kontakt hergestellt,keine Zahlungsvereinbarung')
when okozwb.anzahl > 1 and okozwb.text = 'Kontakt hergestellt, Zahlungsvereinbarung' then  concat('SA15' ,' ', 'Kontakt hergestellt,Zahlungsvereinbarung')
else ''
end 
*/
'' korrezeichen
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
	   left outer join okozwb okozwb on ticket.mandant_id = okozwb.mandant and  ticket.ticketnr = okozwb.ticketnr and okozwb.tagesdatum = curdate()
    
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
*/
left outer join oko on oko.id = ticket.ticketnr -- INKOOEEB für Originaldaten 

	where ticket.mandant_id =16 
and ticket.status_id = 55

";

$filename = "files/okoexp".date("Ymdm").".txt";
$fp = fopen($filename, 'w');
// �berschriftszeile
/*
$string = 'kundennummer;anrede;titel;vorname;nachname;gebdat;geschlecht;praemie;buchungsdatum'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
while ($line = dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));
		echo "xx";
        $aktnr = $line['aktnr']; 
		$vorlage = $line['vorlage']; 
		$korrezeichen = $line['korrezeichen']; 
        if ($vorlage == 'Ja' ) {
            $vorlage = 91;
            }
             else
			{
           $vorlage = 90;
        }
		$anruf_status_text = $line['anruf_status_text']; 
		if ($anruf_status_text == 'Telefonnummer falsch' ) {
	 	  $vorlage = 91; /* Vorlage automatisch setzen */
        }
     	$loesungsvorschlag = $line['loesungsvorschlag']; 
		if ($loesungsvorschlag == 'JA-Einmal' ) {
			$ratenzahlung_am = $line['ratenzahlung_am']; 
	 	    $loesungsvorschlag = $loesungsvorschlag.' AM: '.$ratenzahlung_am; 
		  /*
		  if (strlen($ratenzahlung_am)>0 ) {
		    $ratenzahlung_am = $line['ratenzahlung_am']; 
	 	    $loesungsvorschlag = $loesungsvorschlag.' AM: '.$ratenzahlung_am; 
		  }
			*/
        }
		// Ratenhöhe geringer als erlaubt
		$ratenhoehe_verein = $line['ratenhoehe_verein']; 
		$ratenhoehe = $line['ratenhoehe']; 
        $ratenhoehe_int = (int)$ratenhoehe;
        $ratenhoehe_verein_int = (int)$ratenhoehe_verein;		
		if ($ratenhoehe_verein_int > 0  and $ratenhoehe_verein_int < $ratenhoehe_int ) {
	 	   $ratenhoehehinweis = 'RH pruefen('.$ratenhoehe_int.') ';
		   $vorlage = 91; /* Vorlage automatisch setzen */
		   }  else {
            $ratenhoehehinweis = '';
        }
		// Ratenzahlung am ist auch bei EINMAL gueltig
		$ratenzahlung_am = $line['ratenzahlung_am']; 
		//
		if ($ratenhoehe_verein > '0,00' ) {
	 	   $ratenhoehe_verein = 'RH: '.$ratenhoehe_verein;
		   $ratenzahlung_am = $line['ratenzahlung_am']; 
		   $ratenzahlung_am = 'AM: '.$ratenzahlung_am;
		}  else {
           $ratenhoehe_verein = '';
		   $ratenzahlung_am = '';
		   }
		$ergebnis = $line['ergebnis']; 
	    // Adressänderungen
		$adraend = $line['adraend']; 
		$namensaenderung = $line['namensaenderung']; 
		$ortaenderung = $line['ortaenderung']; 
		$strassenaenderung = $line['strassenaenderung']; 
		if ($adraend == 'JA' ) {
	 	   $adraend = 'ADRAEND: Ja';
		   $vorlage = 91; /* Vorlage automatisch setzen */
		   $namensaenderung = $namensaenderung;
		   $ortaenderung = $ortaenderung;
		   $strassenaenderung = $strassenaenderung;
		   }  else {
           $adraend = '';
		   $namensaenderung = '';
		   $ortaenderung = '';
		   $strassenaenderung = '';
        }
		// Kontakttelefonnummer
		$kontakttelefonnr = ' KontaktTelNr: '.$line['kontakttelefonnr']; 
		$kontakttelefonnr = str_replace( '**33', '', $kontakttelefonnr );
		//
        $adr = $adraend.' '.$namensaenderung.' '.$ortaenderung.' '.$strassenaenderung.$kontakttelefonnr;	
		//
		// Änderung Kontaktdaten
		$email = $line['email']; 
		$neuetelnr = $line['neuetelnr']; 
		
		if (strlen((string) $email)>0 OR strlen((string) $neuetelnr)>0) {
	 	   $contactdata = '';
		   if (strlen((string) $email)>0) {
			 // $contactdata = $contactdata.' email :'.$email;
			 $vorlage = 91; /* Vorlage automatisch setzen */
			 // ausgabe in eigener Zeile
		   }
		   if (strlen((string) $neuetelnr)>0) {
			 $contactdata = $contactdata.' Telnr :'.$neuetelnr;
			 $vorlage = 91; /* Vorlage automatisch setzen */
		   }
		   }  else {
          $contactdata = '';
        }	
		// Call-Daten
		$gespraechsdatum = $line['gespraechsdatum']; 
		$gespraechszeit = $line['gespraechszeit']; 
		$ag_anrede = $line['ag_anrede']; 
		$ag_vorname = $line['ag_vorname']; 		
		$ag_nachname = $line['ag_nachname']; 	
        $calldata = 'GesprDat: '.$gespraechsdatum.' GesprZeit: '.$gespraechszeit.' Agent: '.$ag_vorname.' '.$ag_nachname  ;		
		// email 20170328
		if (strlen((string) $email)>0 ) {
	 	   $email01 = '';
		   if (strlen((string) $email)>0) {
			 $email01 = $email01.'Mail: '.$email;
		   }
		   }  else {
          $email01 = 'Mail:';
        }	
        	
	// being transformed into a newline
	$textzeile1 = 'KIMI: '.$anruf_status_text.' ZV: '.$loesungsvorschlag.' '.$korrezeichen;
	$textzeile1 = substr($textzeile1,0,70); // max. 70 Zeichen
	$textzeile1 = str_pad($textzeile1, 70, ' ');   /* mit blank auffüllen */
	$textzeile2 = $ratenhoehe_verein.' '.$ratenhoehehinweis.' '.$ratenzahlung_am;
	$textzeile2 = str_pad($textzeile2, 70, ' ');   /* mit blank auffüllen */

    $ergebnis = iconv("UTF-8", "WINDOWS-1252", $ergebnis);

	$textzeile3 = substr($ergebnis,0,70);
	$textzeile3 = str_pad($textzeile3, 70, ' ');   /* mit blank auffüllen */

    $ergebnis = iconv("WINDOWS-1252", "UTF-8", $ergebnis);
    $textzeile3 = iconv("WINDOWS-1252", "UTF-8", $textzeile3);


	$string= $aktnr.$vorlage.$textzeile1.$textzeile2.$textzeile3.'00000000 '."\n";

	//20220613/TF Konvertierung auf ANSI
	$string = iconv("UTF-8", "WINDOWS-1252", $string);
	

    fwrite($fp, $string); // will proccess /n as newline ... 
	// immer 4 Zeilen - Zeile 1 

    $ergebnis = iconv("UTF-8", "WINDOWS-1252", $ergebnis);
	
	$textzeile4 = substr($ergebnis,70,70);
	$textzeile4 = str_pad($textzeile4, 70, ' ');   /* mit blank auffüllen */
	$textzeile5 = substr($ergebnis,140,70);
	$textzeile5 = str_pad($textzeile5, 70, ' ');   /* mit blank auffüllen */
	$textzeile6 = substr($ergebnis,210,70);
	$textzeile6 = str_pad($textzeile6, 70, ' ');   /* mit blank auffüllen */

    $ergebnis = iconv("WINDOWS-1252", "UTF-8", $ergebnis);
    $textzeile4 = iconv("WINDOWS-1252", "UTF-8", $textzeile4);
    $textzeile5 = iconv("WINDOWS-1252", "UTF-8", $textzeile5);
    $textzeile6 = iconv("WINDOWS-1252", "UTF-8", $textzeile6);
	
	
	$string= $aktnr.$vorlage.$textzeile4.$textzeile5.$textzeile6.'00000000 '."\n"; 


    // immer 4 Zeilen - Zeile 2

	//20220613/TF Konvertierung auf ANSI
	$string = iconv("UTF-8", "WINDOWS-1252", $string);
	
	
	fwrite($fp, $string); // will proccess /n as newline ... 
    // immer 4 Zeilen - Zeile 3

    $ergebnis = iconv("UTF-8", "WINDOWS-1252", $ergebnis);

	
	$textzeile7 = substr($ergebnis,280,70);
	$textzeile7 = str_pad($textzeile7, 70, ' ');   /* mit blank auffüllen */
	$textzeile8 = substr($ergebnis,350,70);
	$textzeile8 = str_pad($textzeile8, 70, ' ');   /* mit blank auffüllen */

    $ergebnis = iconv("WINDOWS-1252", "UTF-8", $ergebnis);
    $textzeile7 = iconv("WINDOWS-1252", "UTF-8", $textzeile7);
    $textzeile8 = iconv("WINDOWS-1252", "UTF-8", $textzeile8);	
	
	// Textzeile 9 für Änderung Kontaktdaten eMail, neue Telefonnummer
	$textzeile9 = substr($contactdata,0,70);
	$textzeile9 = str_pad($textzeile9, 70, ' ');   /* mit blank auffüllen */
	
	$string= $aktnr.$vorlage.$textzeile7.$textzeile8.$textzeile9.'00000000 '."\n";

	//20220613/TF Konvertierung auf ANSI
	$string = iconv("UTF-8", "WINDOWS-1252", $string);


    fwrite($fp, $string); // will proccess /n as newline ... 
    // immer 4 Zeilen - Zeile 4


    $adr = iconv("UTF-8", "WINDOWS-1252", $adr);

	$textzeile10 = substr($adr,0,70);
	$textzeile10 = str_pad($textzeile10, 70, ' ');   /* mit blank auffüllen */
	$textzeile11 = substr($adr,70,70);
	$textzeile11 = str_pad($textzeile11, 70, ' ');   /* mit blank auffüllen */
	
	$adr = iconv("WINDOWS-1252", "UTF-8", $adr);
	$textzeile10 = iconv("WINDOWS-1252", "UTF-8", $textzeile10);	
	$textzeile11 = iconv("WINDOWS-1252", "UTF-8", $textzeile11);

    $calldata = iconv("UTF-8", "WINDOWS-1252", $calldata);

	$textzeile12 = substr($calldata,0,70);
	$textzeile12 = str_pad($textzeile12, 70, ' ');   /* mit blank auffüllen */
	
	$calldata = iconv("WINDOWS-1252", "UTF-8", $calldata);
    $textzeile12 = iconv("WINDOWS-1252", "UTF-8", $textzeile12);
	
	$string= $aktnr.$vorlage.$textzeile10.$textzeile11.$textzeile12.'00000000 '."\n";

	//20220613/TF Konvertierung auf ANSI
	$string = iconv("UTF-8", "WINDOWS-1252", $string);

	fwrite($fp, $string); // will proccess /n as newline ... 

	 // immer 4 Zeilen - Zeile 5
	

	$textzeile13 = substr($email01,0,70);
	$textzeile13 = str_pad($textzeile13, 70, ' ');   /* mit blank auffüllen */
	$textzeile14 = substr('',71,70);
	$textzeile14 = str_pad($textzeile14, 70, ' ');   /* mit blank auffüllen */
	$textzeile15 = substr('',0,70);
	$textzeile15 = str_pad($textzeile15, 70, ' ');   /* mit blank auffüllen */
	
	$string= $aktnr.$vorlage.$textzeile13.$textzeile14.$textzeile15.'00000000 '."\n";
	
	//20220522/TF Konvertierung auf ANSI
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
echo "<br><br>"."OKO-Export - Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
