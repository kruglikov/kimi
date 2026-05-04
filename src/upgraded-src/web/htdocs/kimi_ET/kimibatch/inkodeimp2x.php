<html>
  <head>
     <title>KIMI-Plus - INKODE IMPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKODE IMPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INKODE IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =24";
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
		 id,24,0,1,CONCAT( TRIM(bemerkung), ' / RH:', IFNULL(rh,''), ' / FAELL: ', IFNULL(faell,''), ' / DAT L. ZAHL: ', IFNULL(datlzahl,''),' / BETR L ZAHL: ', IFNULL(betrlzahl,'') ),
		0,null,null,name,vorname,plz,2,
		ort,strasse,null,
		kimi_encrypt(getvwhw(49, TRIM(kimi_decrypt(telnr)))), 
		kimi_encrypt(getvwhw(49, TRIM(kimi_decrypt(telnr2)))),
        gebdatum,year(NOW())- year(kimi_decrypt(gebdatum)) ,
		indexa, indexb,indexc,saldo,verzzinsen,
        IFNULL(REPLACE(iban,' ',null),'DE42 7402 0100 0008 1030 87'),IFNULL(REPLACE(bic,' ',null),'RZOODE77'),connect,rpc,ptp,concat('10980049',TRIM(telnr)),concat('10980049',TRIM(telnr2)),
		NOW(),'FranZ',104,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END 
		DAY),79,16,TRIM(email), CONCAT(RTRIM(sbname),' / E-Mail: ',RTRIM(sbemail),' / ',RTRIM(sbtelnr)),CONCAT(glname, ' / ' , glort),
       CONCAT('naechster Schritt: ' , naechsterschritt), -- textinfo5,
         'Zeigen Sie lösungsbereitschaft? Unter welcher Telefonnummer?',
         'Wie sieht Ihr Lösungsvorschlag aus ? Hintergrund?',
         CONCAT ( 
'- Pilot 43 - Aus und eingehende Nummer von KIMI 004985137956007', CHAR(13,10),
'- gerichtliche Mahn- bzw. Vollstreckungsbescheide (deutsches Recht) - um einen Vollstreckungsbescheid zu ', CHAR(13,10),
'erlangen, müssen Gläubiger zunächst einen Mahnbescheid beantragen. Dieser hemmt die Verjährung der ', CHAR(13,10),
'Forderung und führt zur Eröffnung des gerichtlichen Mahnverfahrens. Ein rechtskräftiger', CHAR(13,10),
'Vollstreckungsbescheid hat die Wirkung eines Pfändungstitels.', CHAR(13,10),
'Hartz IV in Deutschland / gleichzusetzen mit Mindestsicherung in Deutschland ', CHAR(13,10),
 'Zwangsvollstreckung = Pfändung in Deutschland -im Gegensatz zu Österreich (Exekution). Wir verwenden bei', CHAR(13,10) ,
 'deutschen Schuldnern das Wort Zwangsvollstreckung oder Pfändung', CHAR(13,10) ,
 '- Kreditinstitut: Raiffeisenlandesbank Oberösterreich AG – Niederlassung Passau', CHAR(13,10),
 '- Verwendungszweck: Indexnummer' ),
        CONCAT(ROUND(indexa),'-', ROUND(indexb),'-',ROUND(indexc)),1,0,TRIM(telnrapl),arbplatz
        from inkode where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
";

//
$result = mysqli_query($dbconn, $query_id);
while ($line = bFetchArray($result)) { ?>
<?PHP
$id= $line['id'];
echo "<br>".$id;

 ?>
 <?PHP 
 
}

//
// INKO-DE-Datei

$lines = file('files/INKODE.CSV');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	//20170127 AR: wenn nicht UTF-8 dann konvertieren
	$line = convert2Utf8($line);

    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
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
        //echo "<br>BETR L. ZAHLUNG: ".$betrlzahl;		
//		
		//echo "<br> ";		
	  // Insert in INKODE
	  $inkode_ins = "INSERT INTO inkode (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,telnr,telnr2,gebdatum,saldo,iban,bic,bemerkung,verzzinsen,connect,rpc,ptp,import,email,glname,glort,sbname,sbemail,sbtelnr,naechsterschritt,telnrapl,arbplatz,rh,faell,datlzahl,betrlzahl ) 
	  values ("."'".$id."'".",'".$indexa."'".",'".$indexb."','".$indexc."',
	  kimi_encrypt('".$name."'),
	  kimi_encrypt('".$vorname."'),
	  kimi_encrypt('".$strasse."'),
	  kimi_encrypt('".$plz."'),
	  kimi_encrypt('".$ort."'),
	  TRIM(LEADING '0' FROM '".$telnr."')),
	  TRIM(LEADING '0' FROM '".$telnr2."')),
	  kimi_encrypt('".$gebdatum."'),
	  REPLACE('".$saldo."', ',', '.'),'".$iban."','".$bic."','".$bemerkung."',REPLACE('".$verzzinsen."', ',', '.'),'".$connect."','".$rpc."','".$ptp."',NOW(),
	  kimi_encrypt('".$email."'),
	  '".$glname."','".$glort."','".$sbname."','".$sbemail."','".$sbtelnr."','".$naechster_schritt."',TRIM(LEADING '0' FROM '".$telnrapl."'),'".$arbplatz."',REPLACE('".$rh."', ',', '.'),'".$faell."','".$datlzahl."',REPLACE('".$betrlzahl."', ',', '.'))";
       //20170127 AR: wenn nicht UTF-8 dann konvertieren
	   echo "<br>".convert2Utf8($inkode_ins)."<br>";
	  if (mysqli_query($dbconn, $inkode_ins))
	  {
      echo "Insert in INKODE durchgef&uuml;hrt";
      }
      else
      {
      echo "<br><br>Error insert INKODE in database: " . mysqli_error($dbconn);
      }
	  
	
		
    }
}
// INSERT IN TICKET-Tabelle

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
// $mehrfach_trunc = "truncate table inkode_duplet";
// $mehrfach_trunc = "delete from inkode_duplet";
$mehrfach_trunc = "drop table inkode_duplet"; //2017-01-06 umbau wegen hanging on copying to tmp table

// 
if (mysqli_query($dbconn, $mehrfach_trunc ))
  {
  echo "<br><br>TRUNCATE inkode_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE inkode_duplet: " . mysqli_error($dbconn);
  }
//
// Dupletten INSERT
//2017-01-06 umbau wegen hanging on copying to tmp table von insert auf create_function
$insert_dup = "
create table inkode_duplet
select id From ticket where mandant_id = 24 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 24 and kampagne_id <> 99 and datediff(beginn, curdate()) < 1
-- and ticketnr in (400,401)
group by kimi_encrypt(nachname),kimi_encrypt(vorname),kimi_encrypt(plz),kimi_encrypt(ort),kimi_encrypt(geburtsdatum)
having count(*) >1)
 and anruf_status_id is null";
// 
if (mysqli_query($dbconn, $insert_dup ))
  {
  echo "<br><br>INSERT inkode_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT inkodeduplet: " . mysqli_error($dbconn);
  }
// Dupletten UPDATE
$update_dup = "
update ticket set 
ergebnis = '' -- ergebnisfeld ist beim Einspielen leer ! -- 2022-0428: Text 'Schuldner mehrfach vorhanden' nicht mehr schreiben da nicht immer gelöscht, daher mit leer = ''
where mandant_id = 24 and kampagne_id <> 99
and id in (
select * from  inkode_duplet
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
$trunc_urgenz = "
truncate table inkodeurgenz
";
// 
if (mysqli_query($dbconn, $trunc_urgenz ))
  {
  echo "<br><br>TRUNCATE INKODEOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE INKODEURGENZ : " . mysqli_error($dbconn);
  }
//
// insert into inkodeurgenz 
$ins_urgenz = "
insert into inkodeurgenz 
select 24 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt order by urgenztxt desc)  urgenztext from (
select ticketnr,kimi_encrypt(nachname),kimi_encrypt(vorname),kimi_encrypt(geburtsdatum),kimi_encrypt(plz),kimi_encrypt(strasse),dummy_text9,
CONCAT('Beginn: ' , beginn, 'Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 24 and concat(nachname,vorname) in (
select concat(kimi_encrypt(nachname),kimi_encrypt(vorname)) from ticket where id in (select * from inkode_duplet )
and  mandant_id = 24 and kampagne_id <> 99 
) order by kimi_encrypt(nachname), ticketnr desc
) x
group by concat(kimi_encrypt(nachname),kimi_encrypt(vorname),kimi_encrypt(geburtsdatum))
";
// 
if (mysqli_query($dbconn, $ins_urgenz ))
  {
  echo "<br><br>INSERT INKODEOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT INKODEURGENZ : " . mysqli_error($dbconn);
  }
//
// update ticket  join inkourgenz 
$update_urgenz = "
update ticket  join inkodeurgenz
on ticket.ticketnr = inkodeurgenz.ticketnr and ticket.mandant_id = inkodeurgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 24 and ticket.ticketnr = inkodeurgenz.ticketnr
";
// 
if (mysqli_query($dbconn, $update_urgenz ))
  {
  echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET URGENZ: " . mysqli_error($dbconn);
  } 
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From inkodeurgenz
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
select count(*) anzahl_n_offen from ticket where mandant_id = 24 and status_id = 104 and kampagne_id <>99 and datediff(beginn, curdate()) < 1
"; 
//
echo "<br><br><b>Pr&uuml;fung OFFENE EINGESPIELT:<br></b>";
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
//I
echo "<br><br>"."INKODE IMPORT - Ende: ".$heute;
//
// mysql_free_result($result);

// mysql_close();

dbClose($dbconn);

?>
</body>    
</html>
