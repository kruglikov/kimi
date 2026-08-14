<html>
  <head>
     <title>KIMI-Plus - INKO SEPADATEN-Export V 1 20200620</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO SEPADATEN-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select
'projekt','id',	'email', 'anrede', 'name','index','indexauf','name2','adresse','rate','datum'
from dual
union 
select 'INKO2016',ticketnr,email,'Anrede',CONCAT(TRIM(vorname),' ',TRIM(nachname)) name,dummy_text9,
concat('x',LPAD(truncate(dummy_number1,0), 5, '0'),' ',LPAD(truncate(dummy_number2,0), 10, '0'),' ',LPAD(truncate(dummy_number3,0), 4, '0')) inkassonummer,
concat(TRIM(vorname),' ',TRIM(nachname)) NameZahlungspf,
concat(plz,' ',TRIM(Ort),', ',TRIM(strasse)) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    ELSE '00.00.0000'
END

from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
where ticket.mandant_id = 18 
 and ticket.status_id = 68 -- ERLEDIGT
 and ticket.anruf_status_id = 234 -- ERREICHT
 and ticket.produkt_id  =39 -- SEPA JA
union
-- INDKO DE 

select 'INKODE',ticketnr,email,'Anrede',CONCAT(TRIM(vorname),' ',TRIM(nachname)) name,dummy_text9,
concat('x',LPAD(truncate(dummy_number1,0), 5, '0'),' ',LPAD(truncate(dummy_number2,0), 10, '0'),' ',LPAD(truncate(dummy_number3,0), 4, '0')) inkassonummer,
concat(TRIM(vorname),' ',TRIM(nachname)) NameZahlungspf,
concat(plz,' ',TRIM(Ort),', ',TRIM(strasse)) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    ELSE '00.00.0000'
END

from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
where ticket.mandant_id = 24 
 and ticket.status_id = 101 -- ERLEDIGT
 and ticket.anruf_status_id = 333 -- ERREICHT
 and ticket.produkt_id  =64 -- SEPA JA

";

$filename = "files/".date("YmdHi")."_INKO_SEPA_Daten".".csv";
$fp = fopen($filename, 'w');


$result = mysqli_query($dbconn, $query);
// 
if ($result) {
    while ($line = mysqli_fetch_array($result)) { 
            //fputcsv($fp, array_keys($line));
            $string = $line['projekt'].";".$line['id'].";".$line['email'].";".$line['anrede'].";".$line['name'].";".$line['index'].";".$line['indexauf'].";".$line['name2'].";".$line['adresse'].";".$line['rate'].";".$line['datum']; 
            $string = $string."\n"; 
            //echo $string;
            // being transformed into a newline
            //fwrite($fp, $string); // will proccess /n as newline ... 	
            if ($convert_export_csvUtf82Ansi) {
                fwrite($fp, convert2ANSI($string)); // will proccess /n as newline ... 	
            } else {
                fwrite($fp, $string); // will proccess /n as newline ... 	
            }
    
        
    }
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
    if (ob_get_length() > 0) {
    	ob_clean();
	}
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."INKO SEPADATEN-Export- Ende: ".$heute;

?>
</body>    
</html>
