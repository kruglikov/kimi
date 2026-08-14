<html>
  <head>
     <title>KIMI-Plus - Kontoauszug</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Kontoauszug</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
//XXX echo "Kontoauszug - Start: ".$heute;
// Abfrage Kontoauszugsdaten
$query = "select 
/*case 
when st.mahnstufe = 4 then 'M4'
when st.mahnstufe = 3 then 'M3'
when st.mahnstufe = 2 then 'M2'
when st.mahnstufe = 1 then 'M1'
when st.mahnstufe = 0 and
dat_l_kontoauszug_neu >= CURDATE() and s.lastschrift = 'J' then 'KAAB'
when dat_l_kontoauszug_neu >= CURDATE() then 'KA'
else 'X'
end verarb, */
st.kontoauszug_art verarb,
/*LPAD(s.ktonr,8,'0') ktonr, */
CONCAT(LPAD(s.ktonr,8,'0'),
case 
when k.kenner like '%SP%' then ' SP '
else ''
end ,
case 
when s.kto_kenner like '%EM%' then ' EM '
else ''
end ,
case 
when k.kenner like '%SW%' then ' SW '
else ''
end ,
case 
when k.kenner like '%XX%' then ' XX '
else '  '
end)  ktonr ,
anr.text anredetext,
k.titel,
case 
WHEN k.titel is null or k.titel = ' 'THEN  k.vorname
ELSE CONCAT(k.titel, ' ' , k.vorname)
END vorname,
k.nachname,
k.strasse,
CONCAT( CAST(k.hausnummer AS CHAR), IFNULL(k.hausnummer_erw,'')) hausnummer,
k.plz,
k.ort,

REPLACE(CAST(IFNULL(st.mahnbetrag,0) AS CHAR), '.', ',') mahnbetrag,
REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ',') ratenhoehe,
REPLACE(CAST(IFNULL(st.faelliger_betrag,0) AS CHAR), '.', ',') faelliger_betrag,
DATE_FORMAT(s.dat_l_kontoauszug, '%Y-%c-%d') dat_l_kontoauszug,
REPLACE(CAST(IFNULL(s.betrag_l_kontoauszug,0) AS CHAR), '.', ',') betrag_l_kontoauszug,
DATE_FORMAT(CURDATE(), '%Y-%c-%d') dat_akt_kontoauszug,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') betrag_akt_kontoauszug,
/*DATE_FORMAT(s.zahltag, '%Y-%c-%d') zahltag,*/
ADDDATE(( select vw.buchungsdatum from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10),interval +18 DAY) zahltag,
DATE_FORMAT(b.buchungsdatum, '%Y-%c-%d') buchungsdatum,
case 
when b.buchungsdatum > s.dat_l_kontoauszug then 'J'
else 'N'
end ausgabe,
DATE_FORMAT(b.valutadatum, '%Y-%c-%d') valutadatum,
bugr.kontoauszugstext,
IFNULL(b.betrag,0) betrag,
case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0)) 
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen = 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end lastschrift,
case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end gutschrift,
 REPLACE(CAST(IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then  ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen = 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0) AS CHAR), '.', ',') lastschrift_auf,
REPLACE(CAST(IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0) AS CHAR), '.', ',') gutschrift_auf,
 88888 summeLastschrift,
 99999 summegutschrift
from stammdaten s
join kunde k on k.id = s.kunde_id
join buchungen b on b.stammdaten_id = s.id
join stichtag st on st.stammdaten_id = s.id
left join anrede anr on anr.id = k.anrede_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id

where s.id in (select st2.stammdaten_id from stichtag st2 where st2.kz_verarbeitet = 'I')
/* and s.ktonr in (1598911,94326287,92956317) */
/* and s.ktonr in( 8128605,48550842) */
and IFNULL(b.kz_gebucht,'N') = 'J' /*and IFNULL(bugr.kz_saldowirksam,'N') = 'J' NICHT-Saldowirksame werden angezeigt */
and kontoauszug_art != 'X'
/*and s.ktonr in (48550842,8128605) */
 order by LPAD(s.ktonr,8,'0')  asc,b.id desc
";
//
//
$filename = "files/Kontoauszug_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
//$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
//fwrite($fp, $string); // will proccess /n as newline ... 
//
$result = mysql_query($query);
$kdnr = 0;
$count = 0;
$sum_gutschrift = 0;
$sum_lastschrift = 0;
//Stammdaten //
$drucksatz='Verarb;Kontonummer;anredetext;titel;vorname;nachname;strasse_hausnummer;plz;ort;mahnbetrag;ratenhoehe;faelliger_betrag;dat_l_kontoauszug;betrag_l_kontoauszug;dat_akt_kontoauszug;betrag_akt_kontoauszug;zahltag;';
//Buchungsdaten //
$i = 1;
while ($i <= 20) {
    $drucksatz = $drucksatz .= 'buchungsdatum'.$i.';valutadatum'.$i.';kontoauszugstext'.$i.';lastschrift_auf'.$i.';gutschrift_auf'.$i.";";
//      $drucksatz = $drucksatz .= '$line['verarb'].$i.';valutadatum'.$i.';kontoauszugstext'.$i.';lastschrift_auf'.$i.';gutschrift_auf'.$i.";";
    $i++;  
}
//
$drucksatz = $drucksatz .= 'summe_lastschrift;summe_gutschrift';
//
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
if ($line['ktonr'] > $kdnr)
     {
    //echo $kdnr."Gruppenwechsel".$line['ktonr'];
    /*Spalten�berschrift als erste Zeile ausgeben */
    if ($kdnr ==0) {
      // Drucksatz Spalten�berschrift ausgeben
      //XXX echo "<br>".$drucksatz;
	  $string = $drucksatz."\n"; 
      fwrite($fp, $string); // will proccess /n as newline ... 
    }
    /* Drucksatz ausgeben wenn erster Gruppenwechsel  */
    //  echo  "<br>COUNT1 : ".$count;    
    if ($kdnr >0) {
      // Drucksatz ausgeben
      //echo "Drucksatz ausgeben<br>";
      //echo '<br>SUMME        Lastschrift ist ='.$sum_lastschrift;    
      //echo '<br>SUMME        Gutschrift ist ='.$sum_gutschrift;       
      /* wenn nicht alle Zeilen aufgef�llt, dann restliche mit Trennzeichen auff�llen  */
      if ($count <= 20)    {
        // AusgebenrestlicheTrennzeichen"
        while ($count <= 20) {
          //echo "restliche Trennzeichen";
          $drucksatz= $drucksatz .= ";;;;;";
          $count++;  
        } 
      }
      //XXXecho '<br>'.$drucksatz.number_format($sum_lastschrift, 2, ',', '').";".number_format($sum_gutschrift, 2, ',', '');      
	  $string = $drucksatz.number_format($sum_lastschrift, 2, ',', '').";".number_format($sum_gutschrift, 2, ',', '')."\n"; 
      fwrite($fp, $string); // will proccess /n as newline ... 
    }
    $kdnr = $line['ktonr'];
    $count = 1;
    //echo "<br>Count2: ",$count;
    /* Drucksatz wieder neu aufbauen */
    $drucksatz = $line['verarb'].";".$line['ktonr'].";".$line['anredetext'].";".$line['titel'].";".$line['vorname'].";".$line['nachname'].";".$line['strasse'].' '.$line['hausnummer'].";".$line['plz'].";".$line['ort'].";".$line['mahnbetrag'].";".$line['ratenhoehe'].";".$line['faelliger_betrag'].";".$line['dat_l_kontoauszug'].";".$line['betrag_l_kontoauszug'].";".$line['dat_akt_kontoauszug'].";".$line['betrag_akt_kontoauszug'].";".$line['zahltag'].";";
    // Summen Lastschrift und Gutschrift wieder zur�cksetzen !!
    $sum_gutschrift = 0;
    $sum_lastschrift = 0;    
}
//$count++;
if ($count <= 21)    {
    //echo "Ausgeben".$count;
    if ($line['lastschrift']== 0) {
      //echo '<br>Lastschrift ist 0<br>';
      $line['lastschrift_auf'] = '';
    }
    if ($line['gutschrift']== 0) {
      //echo '<br>Gutschrift ist 0<br>';
      $line['gutschrift_auf'] = '';
    }    
    //echo '<br>Ausgabe: '.$line['ausgabe'] ;
    if ($line['ausgabe'] == 'J') {
      $drucksatz= $drucksatz .= $line['buchungsdatum'].";".$line['valutadatum'].";".$line['kontoauszugstext'].";".$line['lastschrift_auf'].";".$line['gutschrift_auf'].";";
      $sum_lastschrift =  $sum_lastschrift + $line['lastschrift'];
      $sum_gutschrift = $sum_gutschrift + $line['gutschrift'];
      $count++;
    }
    // echo "<br>Count2: ",$count;
    
    //$drucksatz= $drucksatz .= $line['buchungsdatum'].";".$line['valutadatum'].";".$line['kontoauszugstext'].";".$line['lastschrift_auf'].";".$line['gutschrift_auf'].";";
    //$sum_lastschrift =  $sum_lastschrift + $line['lastschrift'];
    //$sum_gutschrift = $sum_gutschrift + $line['gutschrift'];
    
    //echo '<br>Lastschrift ist ='.$line['lastschrift'];    
    //echo '<br>Gutschrift ist ='.$line['gutschrift'];    
    //echo '<br>SUMLastschrift ist ='.$sum_lastschrift;    
    //echo '<br>SUMGutschrift ist ='.$sum_gutschrift;    
    
}
/*    else{
        echo "Count>20NICHTAUSGEBEN".$count;
        
} */
 ?>
 <?PHP 
}
/* letzten Satz ausgeben */
//echo "Letzten Drucksatz ausgeben:".$drucksatz;
      if ($count <= 20)    {
        // AusgebenrestlicheTrennzeichen"
        while ($count <= 20) {
          $drucksatz= $drucksatz .= ";;;;;";
          $count++;  
        }
      }
// Letzten Drucksatz ausgeben
//XXX echo "<br>".$drucksatz.number_format($sum_lastschrift, 2, ',', '').";".number_format($sum_gutschrift, 2, ',', '');
$string = $drucksatz.number_format($sum_lastschrift, 2, ',', '').";".number_format($sum_gutschrift, 2, ',', '')."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
//echo '<br>SUMME        Lastschrift ist ='.$sum_lastschrift;    
//echo '<br>SUMME        Gutschrift ist ='.$sum_gutschrift;       

// FILE
$ende = date("d.m.Y H:i:s");
//$string ="Ende;".$ende.";;;;;;;;;;;;;;;;;;;"."\n"; 
//fwrite($fp, $string); // will proccess /n as newline ... 

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

//
mysql_free_result($result);

mysql_close();

$heute = date("d.m.Y H:i:s");    
//XXX echo "<br>"."Kontoauszug - Ende: ".$heute;

?>
</body>    
</html>
