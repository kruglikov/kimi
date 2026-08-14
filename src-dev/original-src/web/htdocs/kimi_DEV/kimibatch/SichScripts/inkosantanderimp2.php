<html>
  <head>
     <title>KIMI-Plus - INKOSANTANDER IMPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKOSANTANDER IMPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKOSANTANDER IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =12 and kampagne_id <>99";
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
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9)
		SELECT
		 id,12,0,1,TRIM(bemerkung),
		0,null,null,name,vorname,plz,1,
		ort,strasse,null,TRIM(telnr), TRIM(telnr2),
        gebdatum,year(NOW())- year(gebdatum) ,
		indexa, indexb,indexc,saldo,verzzinsen,
        iban, bic,connect,rpc,ptp,concat('+43',telnr,'**31'),concat('+43',telnr2,'**31'),
		NOW(),'FranZ',40,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END
		DAY),26,5,email, CONCAT(RTRIM(sbname),' / E-Mail: ',RTRIM(sbemail),' / ',RTRIM(sbtelnr)),CONCAT(glname, ' / ' , glort),
         textinfo5,
         textinfo1,
        textinfo2,
        concat( dummy_text10_1 , dummy_text10_2, dummy_text10_3, dummy_text10_4,dummy_text10_5    ),
        CONCAT(ROUND(indexa),'-', ROUND(indexb),'-',ROUND(indexc))
        from inkosantander	 where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
";

//
$result = mysql_query($query_id);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$id= $line['id'];
echo "<br>".$id;

 ?>
 <?PHP 
 
}
//
// INKO-Santander-Datei

$lines = file('files/SCB.CSV');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	if (substr($line, 0,6) == 'IndexA' ) {
      $spaltenueberschrift = substr($line, 0,123);
      echo "<br>1ter Satz: ".$spaltenueberschrift;
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
		$ort= substr($line, 108,17);
        //echo "<br>ort: ".$ort;	
		$telnr= substr($line, 126,20);
        //echo "<br>Telnr: ".$telnr;	
		$telnr2= substr($line, 147,20);
        //echo "<br>TelNr2: ".$telnr2;			
		$email= substr($line, 168,50);
        //echo "<br>EMAil: ".$email;		
		$gebdatum= substr($line, 219,10);
        //echo "<br>GebDatum: ".$gebdatum;		
		$saldo= substr($line, 230,10);
        //echo "<br>Saldo: ".$saldo;	
        $iban= substr($line, 241,30);
        //echo "<br>IBAN: ".$iban;		
		$bic= substr($line, 272,11);
        //echo "<br>BIC: ".$bic;			
		$glname= substr($line, 284,27);
        //echo "<br>GLNAME: ".$glname;		
		$glort= substr($line, 312,17);
        //echo "<br>GLORT: ".$glort;		
		$bemerkung= substr($line, 330,200);
        //echo "<br>Bemerkung: ".$bemerkung;		
		$verzzinsen= substr($line, 531,6);
        //echo "<br>VerzZinsen: ".$verzzinsen;		
		$sbname= substr($line, 538,30);
        //echo "<br>SB-Name: ".$sbname;		
        $sbemail= substr($line, 569,60);
        //echo "<br>SB-EMail: ".$sbemail;		
		$sbtelnr= substr($line, 630,30);
        //echo "<br>SB-Telnr: ".$sbtelnr;		
		$connect= substr($line, 661,0);
        //echo "<br>CONENCT: ".$connect;		
		$rpc= substr($line, 662,0);
        //echo "<br>RPC: ".$rpc;		
		$ptp= substr($line, 663,0);
        //echo "<br>PTP: ".$ptp;	
//		
		//echo "<br> ";		
	  // Insert in INKOSANTANDER
	  $inkosantander_ins = "INSERT INTO inkosantander (id,indexa,indexb,indexc,name,vorname,strasse,plz,ort,telnr,telnr2,gebdatum,saldo,iban,bic,bemerkung,verzzinsen,connect,rpc,ptp,import,email,glname,glort,sbname,sbemail,sbtelnr) 
	  values ("."'".$id."'".",'".$indexa."'".",'".$indexb."','".$indexc."','".$name."','".$vorname."','".$strasse."','".$plz."','".$ort."',TRIM(LEADING '0' FROM '".$telnr."'),TRIM(LEADING '0' FROM '".$telnr2."'),'".$gebdatum."',REPLACE('".$saldo."', ',', '.'),'".$iban."','".$bic."','".$bemerkung."',REPLACE('".$verzzinsen."', ',', '.'),'".$connect."','".$rpc."','".$ptp."',NOW(),'".$email."','".$glname."','".$glort."','".$sbname."','".$sbemail."','".$sbtelnr."')";
       echo "<br>".$inkosantander_ins;
	  
	  if (mysql_query($inkosantander_ins))
	  {
      echo "Insert in INKO2016 durchgef&uuml;hrt";
      }
      else
      {
      echo "<br><br>Error insert INKOSANTANDER in database: " . mysql_error();
      }
	  	
		
    }
}
// INSERT IN TICKET-Tabelle
if (mysql_query($insert_ticket))
{
echo "<br><br>Insert in TICKET durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert TICKET in database: " . mysql_error();
}

//

// Dupletten TRUNCATE
$mehrfach_trunc = "truncate table inkosantander_duplet";
// 
if (mysql_query($mehrfach_trunc ))
  {
  echo "<br><br>TRUNCATE inkosantander_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE inkosantander_duplet: " . mysql_error();
  }
//
// Dupletten INSERT
$insert_dup = "
insert into inkosantander_duplet
select id From ticket where mandant_id = 12 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 12 and kampagne_id <> 99
-- and ticketnr in (400,401)
group by nachname,vorname,plz,ort,geburtsdatum
having count(*) >1)
 and anruf_status_id is null";
// 
if (mysql_query($insert_dup ))
  {
  echo "<br><br>INSERT inkosantander_duplet  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT inkosantander_duplet: " . mysql_error();
  }
// Dupletten UPDATE
$update_dup = "
update ticket set 
ergebnis = 'Schuldner mehrfach vorhanden' -- ergebnisfeld ist beim Einspielen leer !
where mandant_id = 12 and kampagne_id <> 99
and id in (
select * from  inkosantander_duplet
)";
// 
if (mysql_query($update_dup ))
  {
  echo "<br><br>UPDATE TICKET Dupletten  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET Dupletten: " . mysql_error();
  }
//
// truncate table inkourgenz
$trunc_urgenz = "
truncate table inkourgenz
";
// 
if (mysql_query($trunc_urgenz ))
  {
  echo "<br><br>TRUNCATE INKOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE INKOURGENZ : " . mysql_error();
  }
//
// insert into inkourgenz 
$ins_urgenz = "
insert into inkourgenz 
select 12 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt)  urgenztext from (
select ticketnr,nachname,vorname,geburtsdatum,plz,strasse,dummy_text9,
CONCAT('Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 12 and concat(nachname,vorname) in (
select concat(nachname,vorname) from ticket where id in (select * from inkosantander_duplet )
and  mandant_id = 12 and kampagne_id <> 99 
) order by nachname, ticketnr
) x
group by concat(nachname,vorname,geburtsdatum)
";
// 
if (mysql_query($ins_urgenz ))
  {
  echo "<br><br>INSERT INKOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT INKOURGENZ : " . mysql_error();
  }
//
// update ticket  join inkourgenz 
$update_urgenz = "
update ticket  join inkourgenz
on ticket.ticketnr = inkourgenz.ticketnr and ticket.mandant_id = inkourgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 12 and ticket.ticketnr = inkourgenz.ticketnr
";
// 
if (mysql_query($update_urgenz ))
  {
  echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET URGENZ: " . mysql_error();
  }
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From inkourgenz
"; 
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_urgenz);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_urgenz'] > 0)
      {
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | URGENZ : ".$line['anzahl_n_urgenz']."<br>";
	  }
    }	  
//
$query_offene = "
select count(*) anzahl_n_offen from ticket where mandant_id = 12 and status_id = 40 and kampagne_id <>99 
"; 
//
echo "<br><br><b>Pr&uuml;fung OFFENE:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_offene);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_offen'] > 0)
      {
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | OFFEN : ".$line['anzahl_n_offen']."<br>";
	  }
    }	
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKOSANTANDER IMPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();

//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKOSANTANDER IMPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
