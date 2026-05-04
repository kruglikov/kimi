<html>
  <head>
     <title>KIMI-Plus - OKO IMPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO IMPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");



$heute = date("d.m.Y H:i:s");    
echo "OKO IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
$query_id = "select max(ticketnr) id from ticket
where ticket.mandant_id =16 ";
//
$insert_ticket = "
INSERT INTO ticket
		(ticketnr,mandant_id,kunde_id,benutzer_id, beschreibung_detail,
		kundennummer,anrede,titel,nachname,vorname,plz,land_id,
		ort,strasse,hausnummer,telefon,telefon2,email,
        geburtsdatum,dummy_number5,
        dummy_number1,dummy_number2,dummy_number3,dummy_number4,
	    dummy_text1, dummy_text2, dummy_text3, dummy_text5, dummy_text6,dummy_text7,
		geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,dummy_date2,dummy_text8,wiedervorlage_automatik, anzahl_anrufe,ergebnis)
		SELECT
		 id,16,0,1,TRIM(CONCAT(aufgabe1,aufgabe2)), -- CHAR(13)
		0,null,null,schuldner,'','',1,
		schuldner_ort,schuldner_strasse,null,telnr1, telnr2,email01,
        CASE WHEN kimi_decrypt(geburtsdatum) like '%--%' THen null else geburtsdatum end geburtsdatum,
		CASE WHEN kimi_decrypt(geburtsdatum) like '%--%' THen null else year(now()) - year(kimi_decrypt(geburtsdatum)) end geburtsdatum,
		ratenanzahl, ratenhoehe,gesamtzahlung,saldo,
        iban, bic,CONCAT( glaeubiger, ' ' , glaeubiger_anschrift),sachbearb,
		telnr4, -- concat('+43',telnr1,'**33'), --> dummy_text6 20220627 FT - Felder deaktiviert -- 2023-07-19 tele3 und tele4 aktiviert
		telnr3, -- concat('+43',telnr2,'**33'), --> dummy_text7 20220627 FT - Felder deaktiviert -- 2023-07-19 tele3 und tele4 aktiviert
		NOW(),'FranZ',58,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END 
		DAY),39,8,
         'Firma OKO Inkasso, VN NM , Guten Tag!', -- textinfo5
         '', -- textinfo1
        'Wie sieht Ihr Lösungsvorschlag aus ? Bei Ratenzahlung auf Ratenbrief hingewiesen?', -- textinfo2
         bemerkung,
        concat(aktnr1,'/',aktnr2),faelligbis,mitschuldner,1,0,telefon3plus
        from oko where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
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

$lines = file('files/pos30cc.txt');

echo "<br>Anzeige: Eingabefile: <br>";
$data = '';
$erstersatz = 0;
$aktnr1 = '';
$aktnr2 = '';
$sachbearb = '';
$glauebiger_name = '';
$glaeubiger_anschrift = '';
$schuldner_name = '';
$schuldner_strasse = '';
$schuldner_ort = '';
$mitschuldner_name  = '';
$aufgabe1 = '';
$aufgabe2 = '';
$saldo = 0;
$telefon1 = '';
$telefon2 = '';
$telefon3 = '';
$telefon4 = '';
$telefon5plus = '';
$telefonintervention = '';
$geburtsdatum;
$iban = 'AT552032000900103615'; /* Allg. Sparkasse Linz */
$bic = 'ASPKAT2L'; /* Allg. Sparkasse Linz */
$ratenhoehe = 0;
$ratenanzahl = 0;
$gesamtzahlung = 0;
$email01 = '';
$z = 0;
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    // echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	$z = $z+1;
	$ausschnitt =(substr($line, 0,10));
	// 2023-11-24 Sonderzeichen "'" oder "*" 
    // echo "<br>"."kein Stern * -> wird ersetzt und auch EIN Hochkomma '.chr(39).' darf nicht sein "."<BR>";
	//  ohne Stern
	$line = str_replace('*', ' ', $line);
	// echo  "<br>".$line;
	// ohne Hochkomma
	$line = str_replace(chr(39), ' ', $line);
	// echo  "<br>Nach der Korrektur".$line."<BR>";
	// 2023-11-24		
    //echo "<br>ausschnitt: ".$ausschnitt;
	if (substr($line, 0,21) == 'Telefonintervention f' ) {
        if ( $erstersatz == 1 ) {
		 		echo "<br><br>".convert2Utf8($telefonintervention);
                echo "<br> ";
				echo "<br>INSERT ";
				echo "<br> ";
		       // Insert in OKO
			   //
			    //saldo aufbereite - Punkte raus
				$saldo = str_replace( '.', '', $saldo );
				$gesamtzahlung = str_replace( '.', '', $gesamtzahlung );
			   //
			   $id = $id + 1;
			   //
	           $oko_ins = "INSERT INTO oko (id,aktnr1,aktnr2,sachbearb,glaeubiger,glaeubiger_anschrift,schuldner,schuldner_strasse,schuldner_ort,mitschuldner,aufgabe1,aufgabe2,saldo,telnr1,telnr2,telnr3,telnr4,iban,bic,bemerkung,geburtsdatum,ratenanzahl,ratenhoehe,gesamtzahlung,faelligbis,import,email01,telefon3plus) 
	            values ("."'".$id."'".",'".$aktnr1."'".",'".$aktnr2."'".",'".$sachbearb."','".$glaeubiger_name."','".$glaeubiger_anschrift."',
				kimi_encrypt('".$schuldner_name."'),
				kimi_encrypt('".$schuldner_strasse."'),
				kimi_encrypt('".$schuldner_ort."'),
				kimi_encrypt('".$mitschuldner_name."'),
				'".$aufgabe1."','".$aufgabe2."',TRIM(LEADING ' ' FROM REPLACE('".$saldo."', ',', '.')),
				kimi_encrypt('".$telefon1."'),
				kimi_encrypt('".$telefon2."'),'".$telefon3."','".$telefon4."','".$iban."','".$bic."',substr('".$telefonintervention."',1,2000),
				kimi_encrypt('".$geburtsdatum."'),'".$ratenanzahl."','".$ratenhoehe."',REPLACE('".$gesamtzahlung."', ',', '.'),'".$faelligbis."',NOW()
				,kimi_encrypt(TRIM('".$email01."')),'".$telefon3plus."')";
               //20170127 AR: wenn nicht UTF-8 dann konvertieren
			   echo "<br>".convert2Utf8($oko_ins);
				if (!executeSQLCmdDML($dbconn, $mandant_id, 'SET NAMES utf8')) {
					echo getLastError();
					exit;
				}			   
				if (executeSQLCmdDML($dbconn, $mandant_id, convert2Utf8($oko_ins))) {
					echo "<br><br>Insert in OKO durchgef&uuml;hrt<br>";
				} else {
					echo "<br><br>Error insert OKO in database: ".getLastError();
				exit;
				}				   
			   // 
			   /*Felder zurücksetzen */
               $aktnr1 = '';
               $aktnr2 = '';
               $sachbearb = '';
               $glauebiger_name = '';
               $glaeubiger_anschrift = '';
               $schuldner_name = '';
               $schuldner_strasse = '';
               $schuldner_ort = '';
               $mitschuldner_name  = '';
               $aufgabe1 = '';
               $aufgabe2 = '';
               $saldo = 0;
               $telefon1 = '';
               $telefon2 = '';
               $telefon3 = '';
			   $telefon4 = '';
			   $telefon3plus = '';
			   $telefon3plus = '';
               $telefonintervention = '';
			   $geburtsdatum;
			   $ratenhoehe = 0;
			   $ratenanzahl = 0;
			   $gesamtzahlung = 0;
			   $email01 = '';
			   $z = 1;
			   
        }				
	}	
    $erstersatz = 1;
	//
	$telefonintervention = $telefonintervention.substr($line, 0,80)."<br>";
	//
	if (substr($line, 0,5) == 'Aktnr' ) {
    	$aktnr1 = substr($line, 11,5);
        echo "<br>aktnr1: ".convert2Utf8($aktnr1);
	    $aktnr2 = substr($line, 17,8);
        echo "<br>aktnr2: ".convert2Utf8($aktnr2);
		$data = 'Aktnr';
	}	

	if (substr($line, 0,10) == 'Sachbearb:' ) {
    	$sachbearb = substr($line, 11,50);
        echo "<br>sachbearb: ".convert2Utf8($sachbearb);
		$data = 'Sachbearb:';
	}	
	if (substr($line, 3,7) == 'ubiger:' ) {
    	$glaeubiger_name = substr($line, 11,50);
        echo "<br>Glauebiger: ".convert2Utf8($glaeubiger_name);
		$data = 'Gläubiger:';
	}	
	if ( $data == 'Gläubiger:'  and substr($line, 3,7) == '       ' ) {
    	$glaeubiger_anschrift = substr($line, 11,50);
        echo "<br>glaeubiger_anschrift: ".convert2Utf8($glaeubiger_anschrift);
		$data = 'Gläubigeranschrift';
	}
	
	if (substr($line, 0,10) == 'Schuldner:' ) {
    	$schuldner_name = substr($line, 11,50);
        echo "<br>Schuldner: ".convert2Utf8($schuldner_name);
		$data = 'Schuldner:';
	}	
	
	if ( $data == 'Schuldner:'  and substr($line, 48,3) == 'GBM' ) {
    	$schuldner_strasse = substr($line, 11,37);
        echo "<br>schuldner_strasse: ".convert2Utf8($schuldner_strasse);
		$geburtsdatum = substr($line, 59,4).'-'.substr($line, 56,2).'-'.substr($line, 53,2);
        echo "<br>geburtsdatum: ".convert2Utf8($geburtsdatum);
	}	
	if ( $data == 'Schuldner:'  and substr($line, 48,3) == 'GBF'  and substr($line, 11,1) == ' ') {
    	$schuldner_ort = substr($line, 12,36);
        echo "<br>schuldner_ort: ".convert2Utf8($schuldner_ort);
	}	

	if ( $data == 'Schuldner:'  and substr($line, 48,3) == 'GBF'  and (substr($line, 11,2) == 'AT') ) {
    	$schuldner_ort = substr($line, 14,34);
        echo "<br>schuldner_ort: ".convert2Utf8($schuldner_ort);
	}	
	if ( $data == 'Schuldner:'  and substr($line, 48,3) == 'GBF'  and (substr($line, 11,2) == 'DE') ) {
    	$schuldner_ort = substr($line, 14,34);
        echo "<br>schuldner_ort: ".convert2Utf8($schuldner_ort);
	}	
	
	if ( $data == 'Schuldner:'  and substr($line, 48,3) == 'GBF'  and (substr($line, 11,1) <> ' ') ) {
    	$schuldner_ort = substr($line, 14,34);
        echo "<br>schuldner_ort: ".convert2Utf8($schuldner_ort);
	}	
	if (substr($line, 0,10) == 'Mitsch.  :' ) {
    	$mitschuldner_name = substr($line, 11,50);
        echo "<br>mitschuldner: ".convert2Utf8($mitschuldner_name);
		$data = 'Mitschuldner:';
	}	
    if (substr($line, 0,10) == 'Ford.Begr:' ) {
		$data = 'Ford.Begr:';
		$lz = $z;
        echo "<br>lz: ".convert2Utf8($lz);
		echo "<br>z: ".convert2Utf8($z);
	}
	if ( $data == 'Ford.Begr:'  and $lz+1 == $z ) { /* nächste zeile */
    	$aufgabe1 = substr($line, 0,80);
        echo "<br>aufgabe1: ".convert2Utf8($aufgabe1);
	}	

	if ( $data == 'Ford.Begr:'  and substr($line, 0,5) == 'Offen' ) {
    	$aufgabe2 = substr($line, 0,80);
        echo "<br>aufgabe2: ".convert2Utf8($aufgabe2);
		$saldo = substr($line, 53,15);
	    echo "<br>saldo: ".convert2Utf8($saldo);	
	}	
	if (substr($line, 0,6) == 'Tele1:' ) {
    	$telefon1 = substr($line, 8,13);
        echo "<br>telefon1: ".convert2Utf8($telefon1);
		$data = 'telefon1:';
	}		
	if (substr($line, 0,6) == 'Tele2:' ) {
    	$telefon2 = substr($line, 8,13);
        echo "<br>telefon2: ".convert2Utf8($telefon2);
		$data = 'telefon2:';
	}
	if (substr($line, 0,6) == 'Tele3:' ) {
    	$telefon3 = substr($line, 8,13);
        echo "<br>telefon3: ".convert2Utf8($telefon3);
		$data = 'telefon3:';
		$telefon3plus = $telefon3plus." Tele3: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
	}
	if (substr($line, 0,6) == 'Tele4:' ) {
    	$telefon4 = substr($line, 8,13);
		$telefon4 = $telefon4." $ ";
        echo "<br>telefon4: ".convert2Utf8($telefon4);
		$data = 'telefon4';
		$telefon3plus = $telefon3plus." Tele4: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
	}	

	if (substr($line, 0,6) == 'Tele5:' ) {
		$telefon3plus = $telefon3plus." Tele5: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}	
	if (substr($line, 0,6) == 'Tele6:' ) {
		$telefon3plus = $telefon3plus." Tele6: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}	
	if (substr($line, 0,6) == 'Tele7:' ) {
		$telefon3plus = $telefon3plus." Tele7: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}	
	if (substr($line, 0,6) == 'Tele8:' ) {
		$telefon3plus = $telefon3plus." Tele8: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}	
	if (substr($line, 0,6) == 'Tele9:' ) {
		$telefon3plus = $telefon3plus." Tele9: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}		
	if (substr($line, 0,6) == 'Tele10:' ) {
		$telefon3plus = $telefon3plus." Tele10: ".substr($line, 8,13)." / ";
        echo "<br>telefon3plus: ".convert2Utf8($telefon3plus);
		$data = '$telefon3plus';
	}	
     
	
	if (substr($line, 11,14) == 'Gesamtzahlung/' ) {
		$ratenanzahl = substr($line, 26,2);
		echo "<br>ratenanzahl: ".convert2Utf8($ratenanzahl);
		$gesamtzahlung = substr($line, 33,12);
		echo "<br>gesamtzahlung: ".convert2Utf8($gesamtzahlung);
		$gesamtzahlung2 = str_replace( '.', '', $gesamtzahlung);
		$ratenhoehe = $gesamtzahlung2 / $ratenanzahl;
		$ratenhoehe = round($ratenhoehe,2);
        echo "<br>ratenhoehe: ".convert2Utf8($ratenhoehe);
		$data = 'ratenhoehe:';
	}	

    if (substr($line, 11,13) == 'Gesamtsaldo f' ) {
		$faelligbis = substr($line, 56,4).'-'.substr($line, 53,2).'-'.substr($line, 50,2);
        echo "<br>faelligbis: ".convert2Utf8($faelligbis);
	}	
	if (substr($line, 0,6) == 'Mail1:' ) {
		$email01 = substr($line, 7,50);
        echo "<br>Mail1: ".convert2Utf8($email01);
	}			
	
}
//
// CRLF etc.  in Bemerkung setzen
//
$update_crlf= "update 
oko set bemerkung = REPLACE(REPLACE(bemerkung,'<br>',''),CHAR(13),''),
sachbearb= REPLACE(REPLACE(TRIM(sachbearb),CHAR(10),''),CHAR(13),''),
glaeubiger= REPLACE(REPLACE(TRIM(glaeubiger),CHAR(10),''),CHAR(13),''),
glaeubiger_anschrift= REPLACE(REPLACE(TRIM(glaeubiger_anschrift),CHAR(10),''),CHAR(13),''),
schuldner= kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(schuldner)),CHAR(10),''),CHAR(13),'')),
schuldner_ort = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(schuldner_ort)),CHAR(10),''),CHAR(13),'')),
schuldner_strasse = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(schuldner_strasse)),CHAR(10),''),CHAR(13),'')),
mitschuldner = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(mitschuldner)),CHAR(10),''),CHAR(13),'')),
telnr1 = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(telnr1)),CHAR(10),''),CHAR(13),'')),
telnr2 = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(telnr2)),CHAR(10),''),CHAR(13),'')),
email01 = kimi_encrypt(REPLACE(REPLACE(TRIM(kimi_decrypt(email01)),CHAR(10),''),CHAR(13),''))
where import >= DATE_ADD(CURDATE(),INTERVAL -1.1 DAY)
"; /*-- CHAR(13) */
// 
$heute = date("d.m.Y H:i:s");    
echo "<br>OKO  IMPORT - Update CRLF    : ".$heute;
//
if (mysqli_query($dbconn, $update_crlf ))
  {
  echo "<br><br>UPDATE OKO CRLF durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE OKO CRLF: " . mysqli_error($dbconn);
}
  
//
// INSERT IN TICKET-Tabelle
$heute = date("d.m.Y H:i:s");    
echo "<br>OKO  IMPORT - INSERT IN TICKET-Tabelle    : ".$heute;
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
echo "<br>OKO  IMPORT - Dupletten TRUNCATE    : ".$heute;
//

// $mehrfach_trunc = "truncate table okomehrfach";
// $mehrfach_trunc = "delete from okomehrfach";
$mehrfach_trunc = "drop table okomehrfach"; //2017-01-06 umbau wegen hanging on copying to tmp table
// 

if (mysqli_query($dbconn, $mehrfach_trunc ))
  {
  echo "<br><br>TRUNCATE okomehrfach  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE okomehrfach: " . mysqli_error($dbconn);
  }

//
// Dupletten INSERT
$heute = date("d.m.Y H:i:s");    
echo "<br>OKO  IMPORT - Dupletten INSERT    : ".$heute;
//

//2017-01-06 umbau wegen hanging on copying to tmp table von insert auf create_function
$insert_dup = "
create table `okomehrfach` 
 select distinct ticketnr From ticket where mandant_id = 16
and CONCAT(IFNULL(nachname,''),IFNULL(vorname,''),IFNULL(geburtsdatum,'')) in (
select CONCAT(IFNULL(nachname,''),IFNULL(vorname,''),IFNULL(geburtsdatum,''))  From ticket where mandant_id = 16
group by nachname,vorname,geburtsdatum
having count(*) >1)
 and anruf_status_id is null and datediff(beginn, curdate()) < 1";

 // 

if (mysqli_query($dbconn, $insert_dup ))
  {
  echo "<br><br>INSERT okomehrfach  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT okomehrfach: " . mysqli_error($dbconn);
  }
// Dupletten UPDATE
$heute = date("d.m.Y H:i:s");    
echo "<br>OKO  IMPORT - Dupletten UPDATE    : ".$heute;
//
//$update_dup = "
//update ticket set ergebnis = CONCAT('Schuldner mehrfach vorhanden',IFNULL(ergebnis,''))
//where  mandant_id = 16 and ticketnr in (select * from okomehrfach)";

$update_dup = "
update ticket set ergebnis = CONCAT('',IFNULL(ergebnis,''))
where  mandant_id = 16 and ticketnr in (select * from okomehrfach)";
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
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From okomehrfach
"; 
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_urgenz);
while ($line = dbFetchArray($result))  { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_urgenz'] > 0)
      {
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | URGENZ : ".$line['anzahl_n_urgenz']."<br>";
	  }
    }	  
//
$query_offene = "
select count(*) anzahl_n_offen from ticket where mandant_id = 16 and status_id = 58 and beginn = curdate()
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
       echo "<b><font color='#FF0000'>Anzahl</font></b>&nbsp;Status | OFFEN : ".$line['anzahl_n_offen']."<br>";
	  }
    }	
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."OKO IMPORT - Ende: ".$heute;
//
// mysql_free_result($result);
// mysql_close();

dbClose($dbconn);

?>
</body>    
</html>
