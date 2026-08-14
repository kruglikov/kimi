	<html>
  <head>
     <title>KIMI-Plus - Belegartenjornal TAG FILE</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Belegartenjornal TAG  FILE</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Zahlungsjournal FILE - Start: ".$heute;
// Abfrage Kontoauszugsdaten
$query = "select m.mandant,k.markt,
DATE_FORMAT(b.buchungsdatum, '%Y-%c-%d') buchungsdatum,
substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) ba,
substring(cast(bugr.bugru_key as CHAR) FROM -2 FOR 2) bg,
bugr.text,
REPLACE(CAST(
sum(
IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0)) 
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen = 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0)
) AS CHAR), '.', ',') 
lastschrift,
REPLACE(CAST(
sum(
IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0)
) AS CHAR), '.', ',') 
gutschrift ,
count(*) anzahl
from buchungen b
join stammdaten s on s.id = b.stammdaten_id
join kunde k on k.id = s.kunde_id
join mandant m on m.id = k.mandant_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
left join mwst mw on mw.id = b.mwst_id
where IFNULL(b.kz_gebucht,'N') = 'J'
and CONCAT(YEAR(b.buchungsdatum),MONTH(b.buchungsdatum) ) =
CONCAT( (select YEAR('2017-03-03') from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10),
(select MONTH('2017-03-03') from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10))
group by
m.mandant,k.markt,
DATE_FORMAT(b.buchungsdatum, '%Y-%c-%d'),
substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2),
substring(cast(bugr.bugru_key as CHAR) FROM -2 FOR 2),
bugr.text
";

$filename = "files/belegartenjournaltag".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string ='Mandant;markt;buchungsdatum;ba;bg;text;lastschrift;gutschrift;anzahl;'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['mandant'].";".$line['markt'].";".$line['buchungsdatum'].";".$line['ba'].";".$line['bg'].";".$line['text'].";".$line['lastschrift'].";".$line['gutschrift'].";".$line['anzahl'].";"."\n"; 
        //echo $string;
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
mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Zahlungssjournal FILE- Ende: ".$heute;

?>

</body>    
</html>
