<html>
  <head>
     <title>KIMI-Plus - INKO SEPADATEN-Export V 1 20200620</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO SEPADATEN-Export</h1>
<?PHP 


// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select
'projekt','id',	'email', 'anrede', 'name','index','indexauf','name2','adresse','rate','datum','benutzer','erstellt_am','anrede'
from dual
union 
select 'INKO2016',ticketnr,kimi_decrypt(ticket.email),'Anrede',CONCAT(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) name,dummy_text9,
concat('x',LPAD(truncate(indexa,0), 5, '0'),' ',LPAD(truncate(indexb,0), 10, '0'),' ',LPAD(truncate(indexc,0), 4, '0')) inkassonummer,
concat(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) NameZahlungspf,
concat(kimi_decrypt(ticket.plz),' ',TRIM(kimi_decrypt(ticket.Ort)),', ',TRIM(kimi_decrypt(ticket.strasse))) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '8ter aktuelles Monat' THEN concat('8.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )	
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '8ter Folgemonat' THEN concat('8.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )	
    ELSE '00.00.0000'
END,
benutzer.nachname,
DATE_FORMAT(NOW(), '%Y.%m.%d'),
dummy_id_referenz.text

from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id2 	
        left outer join inko2016 on inko2016.id = ticket.ticketnr
where ticket.mandant_id = 18 
 and ticket.status_id = 68 -- ERLEDIGT
 and ticket.anruf_status_id = 234 -- ERREICHT
 and ticket.produkt_id  =39 -- SEPA JA
union
-- INDKO DE 

select 'INKODE',ticketnr,kimi_decrypt(ticket.email),'Anrede',CONCAT(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) name,dummy_text9,
concat('x',LPAD(truncate(indexa,0), 5, '0'),' ',LPAD(truncate(indexb,0), 10, '0'),' ',LPAD(truncate(indexc,0), 4, '0')) inkassonummer,
concat(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) NameZahlungspf,
concat(kimi_decrypt(ticket.plz),' ',TRIM(kimi_decrypt(ticket.Ort)),', ',TRIM(kimi_decrypt(ticket.strasse))) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )
    WHEN grund.text = '8ter aktuelles Monat' THEN concat('8.',MONTH(CURDATE()),'.',YEAR(CURDATE() ) )	
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )
    WHEN grund.text = '8ter Folgemonat' THEN concat('8.',MONTH(CURDATE())+1,'.',YEAR(CURDATE() ) )	
    ELSE '00.00.0000'
END,
benutzer.nachname,
DATE_FORMAT(NOW(), '%Y.%m.%d'),
dummy_id_referenz.text


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id2 		
        left outer join inkode on inkode.id = ticket.ticketnr
where ticket.mandant_id = 24 
 and ticket.status_id = 101 -- ERLEDIGT
 and ticket.anruf_status_id = 333 -- ERREICHT
 and ticket.produkt_id  =64 -- SEPA JA

";

$filename = "files/".date("YmdHi")."_INKO_SEPA_Daten".".csv";
$fp = fopen($filename, 'w');


$result = mysqli_query($dbconn, $query);
// 
while ($line = dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['projekt'].";".$line['id'].";".$line['email'].";".$line['anrede'].";".$line['name'].";".$line['index'].";".$line['indexauf'].";".$line['name2'].";".$line['adresse'].";".$line['rate'].";".$line['datum'].";".$line['benutzer'].";".$line['erstellt_am'].";".$line['anrede']; 
		$string = $string."\n"; 
        //echo $string;
        // being transformed into a newline

	    //20220528/TF Konvertierung auf ANSI
	    $string = iconv("UTF-8", "WINDOWS-1252", $string);
	
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
echo "<br><br>"."INKO SEPADATEN-Export- Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
