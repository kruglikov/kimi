<html>
  <head>
     <title>KIMI-Plus - KRSV - Liste</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KRSV - Liste</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KRSV - Liste - Start: ".$heute;

$query = "select 
k.kdnr kundennummer,
k.nachname,
k.vorname,
DATE_FORMAT(v.dat_abschluss, '%Y-%c-%d') vers_dat_abschluss,
DATE_FORMAT(v.dat_storno, '%Y-%c-%d') vers_dat_storno,
v.versicherung_bezeichnung,
sfart.id schadensfall_art_id,
sfart.text schadensfall_art_text,
DATE_FORMAT(sf.dat_schadenseintritt, '%Y-%c-%d') dat_schadenseintritt,
DATE_FORMAT(sf.dat_ende_schadensleistung, '%Y-%c-%d') dat_ende_schadensleistung,
stsf.id schadensfall_status_id,
stsf.text schadensfall_status_text,
DATE_FORMAT(sf.dat_gemeldet, '%Y-%c-%d') sf_dat_gemeldet,
DATE_FORMAT(sf.dat_pruefung, '%Y-%c-%d') sf_dat_pruefung,
DATE_FORMAT(sf.dat_leistung, '%Y-%c-%d') sf_dat_leistung,
DATE_FORMAT(sf.dat_zahlungseingang, '%Y-%c-%d') sf_dat_zahlungseingang,
DATE_FORMAT(sf.dat_erledigt, '%Y-%c-%d') sf_dat_erledigt,
DATE_FORMAT(sf.saldo_gemeldet, '%Y-%c-%d') sf_saldo_gemeldet,
sf.forderungsart sf_forderungsart,
REPLACE(CAST(IFNULL(sf.forderungsbetrag,0) AS CHAR), '.', ',') sf_forderungsbetrag,
DATE_FORMAT(sf.leistung_ab, '%Y-%c-%d') sf_leistung_ab,
REPLACE(CAST(IFNULL(sf.maximale_leistung,0) AS CHAR), '.', ',') sf_maximale_leistung,
REPLACE(CAST(IFNULL(sf.zahlungsbetrag,0) AS CHAR), '.', ',') sf_zahlungsbetrag,
DATE_FORMAT(sf.geaendert_am, '%Y-%c-%d') sf_geaendert_am,
sf.geaendert_von sf_geaendert_von,
DATE_FORMAT(v.geaendert_am, '%Y-%c-%d') vers_geaendert_am,
v.geaendert_von vers_geaendert_von
from versicherung v
join kunde k on k.id = v.stammdaten_id
left outer join schadensfall sf on sf.stammdaten_id = v.stammdaten_id
left outer join status_schadensfall stsf on stsf.id = sf.status_schadensfall_id
left outer join schadensfall_art sfart on sfart.id = sf.schadensfall_art_id
where sf.geaendert_am  >= adddate(now(), INTERVAL -365 DAY)  
or v.geaendert_am >= adddate(now(), INTERVAL -365 DAY)
";

$filename = "files/krsv".date("Ymdm").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string = 'kundennummer;nachname;vorname;vers_dat_abschluss;vers_dat_storno;versicherung_bezeichnung;schadensfall_art_id;schadensfall_art_text;dat_schadenseintritt;dat_ende_schadensleistung;schadensfall_status_id;schadensfall_status_text;sf_dat_gemeldet;sf_dat_pruefung;sf_dat_leistung;sf_dat_zahlungseingang;sf_dat_erledigt;sf_saldo_gemeldet,sf_forderungsart;sf_forderungsbetrag;sf_leistung_ab;sf_maximale_leistung;sf_zahlungsbetrag;sf_geaendert_am;sf_geaendert_von;vers_geaendert_am;vers_geaendert_von'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kundennummer'].';'.$line['nachname'].';'.$line['vorname'].';'.$line['vers_dat_abschluss'].';'.$line['vers_dat_storno'].';'.$line['versicherung_bezeichnung'].';'.$line['schadensfall_art_id'].';'.$line['schadensfall_art_text'].';'.$line['dat_schadenseintritt'].';'.$line['dat_ende_schadensleistung'].';'.$line['schadensfall_status_id'].';'.$line['schadensfall_status_text'].';'.$line['sf_dat_gemeldet'].';'.$line['sf_dat_pruefung'].';'.$line['sf_dat_leistung'].';'.$line['sf_dat_zahlungseingang'].';'.$line['sf_dat_erledigt'].';'.$line['sf_saldo_gemeldet'].';'.$line['sf_forderungsart'].';'.$line['sf_forderungsbetrag'].';'.$line['sf_leistung_ab'].';'.$line['sf_maximale_leistung'].';'.$line['sf_zahlungsbetrag'].';'.$line['sf_geaendert_am'].';'.$line['sf_geaendert_von'].';'.$line['vers_geaendert_am'].';'.$line['vers_geaendert_von']."\n"; 
        // being transformed into a newline
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
echo "<br><br>"."KRSV - Liste - Ende: ".$heute;

?>
</body>    
</html>
