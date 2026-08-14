<html>
  <head>
     <title>KIMI-Plus - KNP 1 IMPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KNP 1 IMPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KNP 1 IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =40 and kampagne_id <>99";
//

$insert_ticket = "
INSERT INTO ticket
		(ticketnr,mandant_id,kunde_id,benutzer_id, beschreibung_detail,
		kundennummer,anrede,titel,nachname,vorname,plz,land_id,
		ort,strasse,hausnummer,telefon,telefon2,
        geburtsdatum,dummy_number5,
        dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_text8,
	    dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,
		geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,email,kenner,fahrgestellnummer,
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12)
		SELECT
		 id, -- ticketnr
		40, -- mandant_id
		0, -- kunde_id
		1, -- benutzer_id
		CONCAT( replace(satzkennzeichen, CHAR(13,10),' '),REPLACE(TRIM(REPLACE(replace(replace(replace(replace(replace(replace(bemerkung,'Rechnungsdatum',CONCAT('\r\n','Rechnungsdatum')),'}',''),'{',''),']',''),'\"\"',' '),'[',''),'\r\n',CHAR(13,10))),'\"',''), CHAR(13,10), ' / FAELLIGKEIT: ', IFNULL(faelligkeit,''), ' / DAT L. ZAHL: ', IFNULL(datlzahl,''),' / BETR L. ZAHL: ', IFNULL(betrlzahl,''),CHAR(13,10),CHAR(13,10),'Zahlungen:', IFNULL(zahlungen,'') ), -- beschreibung_detail
		0, --  kundennummer
		null, -- anrede
		null, -- titel
		name, -- nachname
		vorname, -- vorname
		plz, -- plz
		1, -- land_id
		ort, -- ort
		strasse, -- strasse
		null, -- hausnummer,
		CONCAT('00',TRIM(telnr)), -- telefon
		TRIM(telnr2), -- telefon2
        gebdatum, -- geburtsdatum
		year(NOW())- year(gebdatum) , -- dummy_number5
		indexa, -- dummy_number1
		indexb, -- dummy_number2
		indexc, -- dummy_number3
		saldo, -- dummy_number4
		verzzinsen, -- dummy_text8
        IFNULL(REPLACE(iban,' ',null),iban), -- dummy_text1
		IFNULL(REPLACE(bic,' ',null),bic), -- dummy_text2
		0, -- connect, -- dummy_text3
		0, -- rpc, -- dummy_text4
		0, -- ptp, -- dummy_text5
		concat('+43',telnr,'**27'), -- dummy_text6
		concat('+43',telnr2,'**27'), -- dummy_text7
		NOW(), -- geaendert_am
'FranZ', -- geaendert_von
190, -- status_id
CURDATE(), -- beginn
DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END 
		DAY), -- ende
null, --  prioritaet_id -- > = Abschlussgrund
34, -- kampagne_id
TRIM(email), -- email
 CONCAT(RTRIM(sbname),' / E-Mail: ',RTRIM(sbemail),' / ',RTRIM(sbtelnr)), -- kenner
CONCAT(glname, ' / ' , glort), -- fahrgestellnummer
        CONCAT(statusforderung ,' - ', naechsterschritt), -- textinfo5,
         'Zeigen Sie Loesungsbereitschaft? Welche Möglichkeiten gibt es?',--  textinfo1
         'Wie sieht Ihr Loesungsvorschlag aus ? Hintergrund?', --  textinfo2
         CONCAT ( 
'- Pilot 27', CHAR(13,10),
'- Sprachband oder Begrüßung immer Vor und Nachname verwenden', CHAR(13,10),
'- Änderungen/neue Informationen - wenn  Felder vorhanden - eintragen: Adresse, E-Mail, Name, Telefonnummer des Kontaktes! Zusätzliche Informationen ohne vorgegebene Felder - im Ergebnisfeld kurz und aussagekräftig festhalten.', CHAR(13,10),
'- Daueraufträge – muss Schuldner machen, Abbucher/Einziehungsaufträge sind durch KNP möglich', CHAR(13,10),
'- 2-3 Tage nach telefonischer Vereinbarung erhält diese Schuldner per E-Mail oder SMS', CHAR(13,10),
'- Bei Ratenzahlung erhält Schuldner monatlich Zahlschein, Ratenvertrag kann nochmals zugesandt werden', CHAR(13,10),
'- ZUR FORDERUNG:', CHAR(13,10),
 TRIM(REPLACE(replace(replace(replace(replace(replace(replace(bemerkung,'Rechnungsdatum',CONCAT('\r\n','Rechnungsdatum')),'}',''),'{',''),']',''),'\"\"',' '),'[',''),'\r\n',CHAR(13,10))) ), -- dummy_text10
       
CONCAT(indexa,'-', indexb), -- dummy_text9,wiedervorlage_automatik, anzahl_anrufe
1,-- wiedervorlage_automatik
0,-- anzahl_anrufe
null, -- dummy_text11,
null -- dummy_text12 
        from knp1 where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
";

//
$result = mysqli_query($dbconn, $query_id);
if ($result) {
    while ($line = mysqli_fetch_array($result)) { 
        $id= $line['id'];
        echo "<br>".$id;
    }
}

//
// INKO-Santander-Datei

$lines = file('files/KNP1.CSV');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
		$id = 0;
foreach ($lines as $line_num => $line) {
	//20170127 AR: wenn nicht UTF-8 dann konvertieren
	$line = convert2Utf8($line);
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
	list($index1arr,$index2arr,$index3arr,$namearr,$vornamearr,$strassearr,$plzarr,$ortarr,$telnrarr,$tenr2arr,$emailarr,$gebdatumarr,$saldoarr,$ibanarr,$bicarr,$glnamearr,$glortarr,$bemerkungarr,$statusforderungarr,$naechsterschrittarr,$verzzinsenarr,$sbnamearr,$sbemailarr,$sbtelnrarr,$ratenhoehearr,$faelligkeitarr,$datlezahlungarr,$betraglezahlungarr,$satzkennzeichenarr,$zahlungenarr) = explode(';', $line);
		$indexa = $index1arr;
        echo "<br>Index A: ".$indexa;
		$indexb = $index2arr;
        echo "<br>Index B: ".$indexb;
		$indexc = $index3arr;
        //echo "<br>Index C: ".$indexc;		
		$name = $namearr;
        echo "<br>Name: ".$name;	
		$vorname = $vornamearr;
        echo "<br>Vorname: ".$vorname;			
		$strasse= $strassearr;
        //echo "<br>Strasse: ".$strasse;			
		$plz= $plzarr;
        echo "<br>Plz: ".$plz;	
		$ort= $ortarr;
        echo "<br>ort: ".$ort;	
		$telnr= $telnrarr;
        echo "<br>Telnr: ".$telnr;	
		$telnr2= $tenr2arr;
        echo "<br>TelNr2: ".$telnr2;	
		$email= $emailarr;
        echo "<br>EMail: ".$email;			
		$gebdatum= $gebdatumarr;
		$gebdatumX= substr($gebdatumarr,0,4)."-".str_pad(substr($gebdatumarr,5,2),2,'0',STR_PAD_LEFT)."-".str_pad(substr($gebdatumarr,8,2),2,'0',STR_PAD_LEFT);
		//$gebdatumX = '1964-09-06';
		$gebdatum= $gebdatumX;
        echo "<br>GebDatum: ".$gebdatum;		
		$saldo= $saldoarr;
        echo "<br>Saldo: ".$saldo;	
        $iban= $ibanarr;
        //echo "<br>IBAN: ".$iban;		
		$bic= $bicarr;
        //echo "<br>BIC: ".$bic;			
		$glname= $glnamearr;
        //echo "<br>GLNAME: ".$glname;		
		$glort= $glortarr;
        //echo "<br>GLORT: ".$glort;		
		$bemerkung= $bemerkungarr;
        //echo "<br>Bemerkung: ".$bemerkung;
        $statusforderung= $statusforderungarr;
        //echo "<br>Statusderforderung: ".$statusderforderung;	
        $naechsterschritt= $naechsterschrittarr;
        //echo "<br>Nächster Schritt: ".$naechster_schritt;			
		$verzzinsen= $verzzinsenarr;
        //echo "<br>VerzZinsen: ".$verzzinsen;		
		$sbname= $sbnamearr;
        //echo "<br>SB-Name: ".$sbname;		
        $sbemail= $sbemailarr;
        //echo "<br>SB-EMail: ".$sbemail;		
		$sbtelnr= $sbtelnrarr;
        //echo "<br>SB-Telnr: ".$sbtelnr;		
		$ratenhoehe= $ratenhoehearr;
        //echo "<br>Ratenhoehearr: ".$ratenhoehe;		
		$faelligkeit = $faelligkeitarr;
        //echo "<br>Fälligkeit: ".$faelligkeit;		
		$datlezahlung= $datlezahlungarr;
        //echo "<br>DatLeZahlung: ".$datlezahlung;		
		$betraglezahlung = $betraglezahlungarr;
        //echo "<br>Betrag: ".$betraglezahlung;		
		$satzkennzeichen= $satzkennzeichenarr;
        //echo "<br>Betrag L. ZAHLUNG: ".$satzkennzeichenarr;		
		$zahlungen= $zahlungenarr;
        //echo "<br>Zahlungen: ".$zahlungen;		
		echo "<br>";	
		
	  // Insert in KNP1
	  
        // ACHTUNG - Beträge und Datumsfelder dürfen nicht '' sein, darum getReplaceBlank2Null bzw. für Beträge getReplaceCheckNull verwenden
	  $knp1_ins = "INSERT INTO knp1 (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,telnr,telnr2,email,gebdatum,saldo,iban,bic,glname,glort,bemerkung,statusforderung,naechsterschritt,sbname,sbemail,sbtelnr,verzzinsen,ratenhoehe,faelligkeit,datlzahl,betrlzahl,satzkennzeichen,zahlungen,import) 
	    values ("."'".$id."'".",'".$indexa."'".",'".$indexb."','".$indexc."','".$name."','".$vorname."','".$strasse."','".$plz."','".$ort."',TRIM(LEADING '0' FROM '".$telnr."'),TRIM(LEADING '0' FROM '".$telnr2."'),'".$email."',".
        getReplaceBlank2Null($gebdatum, "'").",".
        getReplaceCheckNull($saldo, ',', '.').",'".$iban."','".$bic."','".$glname."','".$glort."','".$bemerkung."','".$statusforderung."','".$naechsterschritt."','".$sbname."','".$sbemail."','".$sbtelnr."',".
        getReplaceCheckNull($verzzinsen, ',', '.').",".
        getReplaceCheckNull($ratenhoehe, ',', '.').",".
        getReplaceBlank2Null($faelligkeit, "'").",".
        getReplaceBlank2Null($datlezahlung, "'").",".
        getReplaceCheckNull($betraglezahlung, ',', '.').",'".
        $satzkennzeichen."','".$zahlungen."',now())";


      //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>".convert2Utf8($knp1_ins)."<br>";
	  
	  mysqli_query($dbconn, 'SET NAMES utf8');
	   
	  if (mysqli_query($dbconn, $knp1_ins)) {
        echo "<br>Insert in KNP1 durchgef&uuml;hrt<br><br>";
      } else{
        echo "<br><br>Error insert KNP1 in database: " . mysqli_error($dbconn);
      }
}

// INSERT IN TICKET-Tabelle

if (mysqli_query($dbconn, $insert_ticket)) {
    echo "<br><br>Insert in TICKET durchgef&uuml;hrt";
} else {
    echo "<br><br>Error insert TICKET in database: " . mysqli_error($dbconn);
}

//

// Dupletten TRUNCATE
$mehrfach_trunc = "drop table knp1_duplet"; //2017-01-06 umbau wegen hanging on copying to tmp table
// 
if (mysqli_query($dbconn, $mehrfach_trunc )) {
  echo "<br><br>TRUNCATE knp1_duplet  durchgef&uuml;hrt";
} else   {
  echo "<br><br>TRUNCATE knp1_duplet: " . mysqli_error($dbconn);
  }
//
// Dupletten INSERT
//2017-01-06 umbau wegen hanging on copying to tmp table von insert auf create_function
$insert_dup = "
create table knp1_duplet
select id From ticket where mandant_id = 40 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 40 and kampagne_id <> 99 and datediff(beginn, curdate()) < 1
-- and ticketnr in (400,401)
group by nachname,vorname,plz,ort,geburtsdatum
having count(*) >1)
 and anruf_status_id is null";
// 
if (mysqli_query($dbconn, $insert_dup )) {
  echo "<br><br>INSERT knp1_duplet  durchgef&uuml;hrt";
} else {
  echo "<br><br>INSERT knp1duplet: " . mysqli_error($dbconn);
}
// Dupletten UPDATE
$update_dup = "
update ticket set 
ergebnis = 'Schuldner mehrfach vorhanden' -- ergebnisfeld ist beim Einspielen leer !
where mandant_id = 40 and kampagne_id <> 99
and id in (
select * from  knp1_duplet
)";
// 
if (mysqli_query($dbconn, $update_dup )) {
  echo "<br><br>UPDATE TICKET Dupletten  durchgef&uuml;hrt";
} else {
  echo "<br><br>UPDATE TICKET Dupletten: " . mysqli_error($dbconn);
}
//
// truncate table urgenz
$trunc_urgenz = "
truncate table knp1urgenz
";
// 
if (mysqli_query($dbconn, $trunc_urgenz )) {
  echo "<br><br>TRUNCATE KNP1URGENZ  durchgef&uuml;hrt";
} else {
  echo "<br><br>TRUNCATE KNP1URGENZ : " . mysqli_error($dbconn);
}
//
// insert into knp1urgenz 
$ins_urgenz = "
insert into knp1urgenz 
select 40 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt order by urgenztxt desc)  urgenztext from (
select ticketnr,nachname,vorname,geburtsdatum,plz,strasse,dummy_text9,
CONCAT('Beginn: ', beginn , 'Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 40 and concat(nachname,vorname) in (
select concat(nachname,vorname) from ticket where id in (select * from knp1_duplet )
and  mandant_id = 40 and kampagne_id <> 99 
) order by nachname, ticketnr desc
) x
group by concat(nachname,vorname,geburtsdatum)
";
// 
if (mysqli_query($dbconn, $ins_urgenz )) {
  echo "<br><br>INSERT KNP1URGENZ  durchgef&uuml;hrt";
} else {
  echo "<br><br>INSERT KNP1URGENZ : " . mysqli_error($dbconn);
}
//
// update ticket  join inkourgenz 
$update_urgenz = "
update ticket  join knp1urgenz
on ticket.ticketnr = knp1urgenz.ticketnr and ticket.mandant_id = knp1urgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 40 and ticket.ticketnr = knp1urgenz.ticketnr
";
// 
if (mysqli_query($dbconn, $update_urgenz )) {
  echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
} else {
  echo "<br><br>UPDATE TICKET URGENZ: " . mysqli_error($dbconn);
} 
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From knp1urgenz
"; 
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_urgenz);
if ($result) {
    while ($line = mysqli_fetch_array($result)) { 
        echo "<br>";
        if ($line['anzahl_n_urgenz'] > 0) {
            echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | URGENZ : ".$line['anzahl_n_urgenz']."<br>";
        }
    }	  
}
//
$query_offene = "
select count(*) anzahl_n_offen from ticket where mandant_id = 40 and status_id = 190 and kampagne_id <>99  and datediff(beginn, curdate()) < 1
"; 
//
echo "<br><br><b>Pr&uuml;fung OFFENE  EINGESPIELT:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_offene);
if ($result) {
    while ($line = mysqli_fetch_array($result)) { 
        echo "<br>";
        if ($line['anzahl_n_offen'] > 0) {
        echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | OFFEN EINGESPIELT: ".$line['anzahl_n_offen']."<br>";
        }
    }
}
//
	$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."KNP 1 IMPORT - Ende: ".$heute;
//
if ($result) {
    mysqli_free_result($result);
}
mysqli_close($dbconn);
?>
</body>    
</html>
