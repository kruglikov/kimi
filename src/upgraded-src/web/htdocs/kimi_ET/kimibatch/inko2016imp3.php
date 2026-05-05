<html>
  <head>
     <title>KIMI-Plus - INKO2016 IMPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO2016 IMPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INKO2016 IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =18 and kampagne_id <>99";
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
		 id,18,0,1,CONCAT( TRIM(bemerkung), ' / RH:', IFNULL(rh,''), ' / FAELL: ', IFNULL(faell,''), ' / DAT L. ZAHL: ', IFNULL(datlzahl,''),' / BETR L ZAHL: ', IFNULL(betrlzahl,'') ),
		0,null,null,name,vorname,plz,1,
		ort,strasse,null,
		kimi_encrypt(TRIM(kimi_decrypt(telnr))), 
		kimi_encrypt(TRIM(kimi_decrypt(telnr2))),
        gebdatum,year(NOW())- year(kimi_decrypt(gebdatum)) ,
		indexa, indexb,indexc,saldo,verzzinsen,
        IFNULL(REPLACE(iban,' ',null),'AT58 3422 6000 0003 9222'),IFNULL(REPLACE(bic,' ',null),'RZOOAT2L226'),connect,rpc,ptp,concat('+43',telnr,'**32'),concat('+43',telnr2,'**32'),
		NOW(),'FranZ',66,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END 
		DAY),50,10,kimi_encrypt(TRIM(kimi_decrypt(email))), CONCAT(RTRIM(sbname),' / E-Mail: ',RTRIM(sbemail),' / ',RTRIM(sbtelnr)),CONCAT(glname, ' / ' , glort),
        CONCAT('naechster Schritt: ' , naechsterschritt), -- textinfo5,
         'Zeigen Sie lösungsbereitschaft? Unter welcher Telefonnummer?',
         'Wie sieht Ihr Lösungsvorschlag aus ? Hintergrund?',
         CONCAT ( 
'- Pilot 32', CHAR(13,10),
'- Sprachband oder Begrüßung immer Vor und Nachname verwenden', CHAR(13,10),
'- Änderungen/neue Informationen - wenn  Felder vorhanden - eintragen: Adresse, E-Mail, Name, Telefonnummer des Kontaktes! Zusätzliche Informationen ohne vorgegebene Felder - im Ergebnisfeld kurz und aussagekräftig festhalten.', CHAR(13,10),
'- Daueraufträge – muss Schuldner machen, Abbucher/Einziehungsaufträge sind durch INKO möglich', CHAR(13,10),
'- 2-3 Tage nach telefonischer Vereinbarung erhält diese Schuldner per E-Mail oder SMS', CHAR(13,10),
'- Bei Ratenzahlung erhält Schuldner monatlich Zahlschein, Ratenvertrag kann nochmals zugesandt werden', CHAR(13,10),
 '- IBAN: AT58 3422 60000003922, BIC: RZOOAT2L226', CHAR(13,10) ),
        CONCAT(ROUND(indexa),'-', ROUND(indexb),'-',ROUND(indexc)),1,0,TRIM(telnrapl),arbplatz
        from inko2016 where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
";

//
$result = mysqli_query($dbconn, $query_id);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$id= $line['id'];
echo "<br>".$id;

 ?>
 <?PHP 
 
}

//
// INKO-Santander-Datei

$lines = file('files/INKO2016.CSV');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	//20170127 AR: wenn nicht UTF-8 dann konvertieren
	$line = convert2Utf8($line);

    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars((string) $line) . "<br />\n";
	
}
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	//
	if (substr($line, 0,6) == 'IndexA' ) {
      $spaltenueberschrift = substr($line, 0,123);

	  //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>1ter Satz: ".convert2Utf8($spaltenueberschrift);
    } else {
		$id = $id + 1;
		// 2023-11-24 Sonderzeichen "'" oder "*" 
        echo "<br>"."kein Stern * -> wird ersetzt und auch EIN Hochkomma '.chr(39).' darf sind sein ";
		//  ohne Stern
		$line = str_replace('*', ' ', $line);
		// echo  "<br>".$line;
		// ohne Hochkomma
		$line = str_replace(chr(39), ' ', $line);
		echo  "<br>".$line;
		// 2023-11-24		
		//
		$indexa = substr($line, 0,5);
        //echo "<br>Index A: ".$indexa;
		$indexb = substr($line, 6,10);
        //echo "<br>Index B: ".$indexb;
		$indexc = substr($line, 17,4);
        //echo "<br>Index C: ".$indexc;		
		$name = substr($line, 22,27);
        //echo "<br>Name: ".$name;	
		$vorname = substr($line, 50,20);
        //echo "<br>Vorname: ".$vorname;			
		$strasse= substr($line, 71,30);
        //echo "<br>Strasse: ".$strasse;			
		$plz= substr($line, 102,5);
        //echo "<br>Plz: ".$plz;	
		$ort= substr($line, 108,30);
        //echo "<br>ort: ".$ort;	
		$telnr= substr($line, 139,20);
        //echo "<br>Telnr: ".$telnr;	
		$telnr2= substr($line, 160,20);
        //echo "<br>TelNr2: ".$telnr2;		
		//
		$telnrapl= substr($line, 181,20);
        echo "<br>telnrapl: ".$telnrapl;	
		$arbplatz= substr($line, 202,30);
        echo "<br>arbplatz: ".$arbplatz;	
		//
		$email= substr($line, 233,50);
        //echo "<br>EMAil: ".$email;		
		$gebdatum= substr($line, 284,10);
        //echo "<br>GebDatum: ".$gebdatum;		
		$saldo= substr($line, 295,10);
        //echo "<br>Saldo: ".$saldo;	
        $iban= substr($line, 306,30);
        //echo "<br>IBAN: ".$iban;		
		$bic= substr($line, 337,11);
        //echo "<br>BIC: ".$bic;			
		$glname= substr($line, 349,27);
        //echo "<br>GLNAME: ".$glname;		
		$glort= substr($line, 377,17);
        //echo "<br>GLORT: ".$glort;		
		$bemerkung= substr($line, 395,200);
        //echo "<br>Bemerkung: ".$bemerkung;	
        $naechster_schritt= substr($line, 596,20);
        //echo "<br>Nächster Schritt: ".$naechster_schritt;			
		$verzzinsen= substr($line, 617,6);
        //echo "<br>VerzZinsen: ".$verzzinsen;		
		$sbname= substr($line, 624,30);
        //echo "<br>SB-Name: ".$sbname;		
        $sbemail= substr($line, 655,60);
        //echo "<br>SB-EMail: ".$sbemail;		
		$sbtelnr= substr($line, 716,30);
        //echo "<br>SB-Telnr: ".$sbtelnr;		
		$connect= substr($line, 747,0);
        //echo "<br>CONENCT: ".$connect;		
		$rpc= substr($line, 747,0);
        //echo "<br>RPC: ".$rpc;		
		$ptp= substr($line, 747,0);
        //echo "<br>PTP: ".$ptp;		
		$rh= substr($line, 747,10);
        //echo "<br>RATENHOEHE: ".$rh;		
		$faell= substr($line, 758,10);
        //echo "<br>FAELLIGKEIT: ".$faell;		
		$datlzahl= substr($line, 769,10);
        //echo "<br>DATUM L. ZAHLUNG: ".$datlzahl;		
		$betrlzahl= substr($line, 780,10);
        echo "<br>BETR L. ZAHLUNG: ".$betrlzahl;		
//		
		//echo "<br> ";		
	  // Insert in INKOSANTANDER
	  $inko2016_ins = "INSERT INTO inko2016 (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,telnr,telnr2,gebdatum,saldo,iban,bic,bemerkung,verzzinsen,connect,rpc,ptp,import,email,glname,glort,sbname,sbemail,sbtelnr,naechsterschritt,telnrapl,arbplatz,rh,faell,datlzahl,betrlzahl  ) 
	  values ("."'".$id."'".",'".$indexa."'".",'".$indexb."','".$indexc."',
	  kimi_encrypt('".$name."'),
	  kimi_encrypt('".$vorname."'),
	  kimi_encrypt('".$strasse."'),
	  kimi_encrypt('".$plz."'),
	  kimi_encrypt('".$ort."'),
	  kimi_encrypt(TRIM(LEADING '0' FROM '".$telnr."')),
	  kimi_encrypt(TRIM(LEADING '0' FROM '".$telnr2."')),
	  kimi_encrypt(str_to_date(IF('".$gebdatum."' = '   0.00.00', NULL, '".$gebdatum."'), '%Y.%m.%d')),
	  REPLACE('".$saldo."', ',', '.'),'".$iban."','".$bic."','".$bemerkung."',REPLACE('".$verzzinsen."', ',', '.'),'".$connect."','".$rpc."','".$ptp."',NOW(),
	  kimi_encrypt('".$email."'),
	  '".$glname."','".$glort."','".$sbname."','".$sbemail."','".$sbtelnr."',SUBSTRING('".$naechster_schritt."',1,15),TRIM(LEADING '0' FROM '".$telnrapl."'),'".$arbplatz."',REPLACE('".$rh."', ',', '.'),'".$faell."','".$datlzahl."',REPLACE('".$betrlzahl."', ',', '.'))";
      //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>INSERT: ".$inko2016_ins;	
	  echo "<br>".convert2Utf8($inko2016_ins)."<br>";
	   
		if (!executeSQLCmdDML($dbconn, $mandant_id, 'SET NAMES utf8')) {
			echo getLastError();
			exit;
		}
	
		if (executeSQLCmdDML($dbconn, $mandant_id, convert2Utf8($inko2016_ins))) {
			echo "<br><br>Insert in INKO2016 durchgef&uuml;hrt<br>";
		} else {
			echo "<br><br>Error insert INKO2016 in database: ".getLastError();
			exit;
		}	
	  
	
		
    }
}
// INSERT IN TICKET-Tabelle
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - INSERT IN TICKET-Tabelle  : ".$heute;
//
if (mysqli_query($dbconn, $insert_ticket))
{
echo "<br><br>Insert in TICKET durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert TICKET in database: " . mysqli_error($dbconn);
}

//

// Dupletten TRUNCATE
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - Dupletten TRUNCATE  : ".$heute;
//
// $mehrfach_trunc = "truncate table inko2016_duplet";
$mehrfach_trunc = "drop table inko2016_duplet"; //2017-01-06 umbau wegen hanging on copying to tmp table
// 
if (mysqli_query($dbconn, $mehrfach_trunc ))
  {
  echo "<br><br>TRUNCATE inko2016_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE inko2016_duplet: " . mysqli_error($dbconn);
  }
//
// Dupletten INSERT
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - Dupletten INSERT  : ".$heute;
//
//2017-01-06 umbau wegen hanging on copying to tmp table von insert auf create_function
$insert_dup = "
create table inko2016_duplet
select id From ticket where mandant_id = 18 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 18 and kampagne_id <> 99 and datediff(beginn, curdate()) < 1
-- and ticketnr in (400,401)
group by nachname,vorname,plz,ort,geburtsdatum
having count(*) >1)
 and anruf_status_id is null";
// 
if (mysqli_query($dbconn, $insert_dup ))
  {
  echo "<br><br>INSERT inko2016_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT inko2016duplet: " . mysqli_error($dbconn);
  }
// Dupletten UPDATE
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - Dupletten UPDATE  : ".$heute;
//
$update_dup = "
update ticket set 
ergebnis = '' -- ergebnisfeld ist beim Einspielen leer ! -- 2022-0428: Text 'Schuldner mehrfach vorhanden' nicht mehr schreiben da nicht immer gelöscht, daher mit leer = ''
where mandant_id = 18 and kampagne_id <> 99
and id in (
select * from  inko2016_duplet
)";
// 
if (mysqli_query($dbconn, $update_dup ))
  {
  echo "<br><br>UPDATE TICKET Dupletten  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET Dupletten: " . mysqli_error($dbconn);
  }
//
// truncate table inkourgenz
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - truncate table inkourgenz  : ".$heute;
//
$trunc_urgenz = "
truncate table inko2016urgenz
";
// 
if (mysqli_query($dbconn, $trunc_urgenz ))
  {
  echo "<br><br>TRUNCATE INKO2016URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE INKO2016URGENZ : " . mysqli_error($dbconn);
  }
//
// insert into inko2016urgenz 
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - insert into inko2016urgenz   : ".$heute;
//
$ins_urgenz = "
insert into inko2016urgenz 
select 18 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt order by urgenztxt desc)  urgenztext from (
select ticketnr,nachname,vorname,geburtsdatum,plz,strasse,dummy_text9,
CONCAT('Beginn: ', beginn , 'Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 18 and concat(nachname,vorname) in (
select concat(nachname,vorname) from ticket where id in (select * from inko2016_duplet )
and  mandant_id = 18 and kampagne_id <> 99 
) order by nachname, ticketnr desc
) x
group by concat(nachname,vorname,geburtsdatum)
";
// 
if (mysqli_query($dbconn, $ins_urgenz ))
  {
  echo "<br><br>INSERT INKO2016URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT INKO2016URGENZ : " . mysqli_error($dbconn);
  }
//
// update ticket  join inkourgenz 
$heute = date("d.m.Y H:i:s");    
echo "<br>INKO2016 IMPORT - update ticket  join inkourgenz    : ".$heute;
//
$update_urgenz = "
update ticket  join inko2016urgenz
on ticket.ticketnr = inko2016urgenz.ticketnr and ticket.mandant_id = inko2016urgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 18 and ticket.ticketnr = inko2016urgenz.ticketnr
";
// 
if (mysqli_query($dbconn, $update_urgenz ))
  {
  echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET URGENZ: " . mysqli_error($dbconn,);
  } 
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From inko2016urgenz
"; 
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_urgenz);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_urgenz'] > 0)
      {
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | URGENZ : ".$line['anzahl_n_urgenz']."<br>";
	  }
    }	  
//
$query_offene = "
select count(*) anzahl_n_offen from ticket where mandant_id = 18 and status_id = 66 and kampagne_id <>99  and datediff(beginn, curdate()) < 1
"; 
//
echo "<br><br><b>Pr&uuml;fung OFFENE  EINGESPIELT:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_offene);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_offen'] > 0)
      {
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | OFFEN EINGESPIELT: ".$line['anzahl_n_offen']."<br>";
	  }
    }	
//
	$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKO2016 IMPORT - Ende: ".$heute;
//
// mysql_free_result($result);
// mysql_close();

dbClose($dbconn);

?>
</body>    
</html>
