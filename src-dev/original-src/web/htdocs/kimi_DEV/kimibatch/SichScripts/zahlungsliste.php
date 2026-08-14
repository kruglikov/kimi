<html>
  <head>
     <title>KIMI-Plus - Zahlungsliste FILE</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Zahlungsliste FILE</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Zahlungsjournal FILE - Start: ".$heute;
// Abfrage Zahlungsdaten
$query = "SELECT
'Zahlungen vorhanden' text,
z.kundennummer stammdaten_id,
CONCAT(lpad(z.ba,2,0), substr(lpad(z.bg,2,0),-2)) bua_bug_man_id,
REPLACE(CAST( IFNULL(z.betrag,0) AS CHAR), '.', ',') betrag ,
DATE_FORMAT((select vw.buchungsdatum from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10), '%Y-%c-%d') buchungsdatum,
DATE_FORMAT(z.belegdatum, '%Y-%c-%d') valutadatum,
herkunft herkunft
From zahlungen z
where  z.kundennummer in (select kundennummer from kunde k 
                         join zahlungen z2 on k.id = z2.kundennummer)
UNION ALL
SELECT
'nicht vorhanden' text,
z.kundennummer stammdaten_id,
CONCAT(lpad(z.ba,2,0), substr(lpad(z.bg,2,0),-2)) bua_bug_man_id,
REPLACE(CAST( IFNULL(z.betrag,0) AS CHAR), '.', ',') betrag ,
DATE_FORMAT((select vw.buchungsdatum from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10), '%Y-%c-%d') buchungsdatum,
DATE_FORMAT(z.belegdatum, '%Y-%c-%d') valutadatum,
herkunft herkunft
From zahlungen z
where  not z.kundennummer in (select kundennummer from kunde k 
                         join zahlungen z2 on k.id = z2.kundennummer)
";

$filename = "files/zahlungsliste".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
// Überschriftszeile
$string ='Text;stammdaten_id;bua_bug_man_id;betrag;buchungsdatum;valutadatum;herkunft'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['text'].";".$line['stammdaten_id'].";".$line['bua_bug_man_id'].";".$line['betrag'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['herkunft']."\n"; 
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
