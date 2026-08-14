  <head>
     <title>KIMI-PLUS - WIEN_ENERGIE_AKTE_ETIKETTEN : EXPORT</title>
  </head>
  <body>
  <h1>KIMI-PLUS - WIEN_ENERGIE__ETIKETTEN : EXPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KIMI-PLUS - AKTE_ETIKETTEN : EXPORT - Start: ".$heute;


$query = "select 0,
'KundenNummer', 
'PacketNummer',
'TicketNummer', 
'BARCODE', 
'NR'
union


select 1,
kundennummer,
dummy_text9,
concat(LPAD(ticketnr,5,'0'),'-',substr(janein1.text,1,1)),

concat(kundennummer ,'_00')   as BARCODE1,
'00' as nr

from ticket

left outer join akt ON  akt.ticket_id = ticket.id 
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id

 
where akt.mandant_id = 29 and (janein1.text = 'Gold' or janein1.text like 'P%') and status_id = 132

union

select 1,
kundennummer,
dummy_text9,
concat(LPAD(ticketnr,5,'0'),'-',substr(janein1.text,1,1)),


concat(kundennummer, '_01')   as BARCODE2,
'01' as nr

from ticket


left outer join akt ON  akt.ticket_id = ticket.id 
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id

where akt.mandant_id = 29 and (janein1.text = 'Gold' or janein1.text like 'P%') and status_id = 132

/*
union

select 1,
kundennummer,
dummy_text9,
concat(LPAD(ticketnr,5,'0'),'-',substr(janein1.text,1,1)),


concat(kundennummer, '_02')   as BARCODE2,
'02' as nr

from ticket
left outer join akt ON  akt.ticket_id = ticket.id 
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id

where akt.mandant_id = 29 and (janein1.text = 'Gold' or janein1.text like 'P%') and status_id = 132



union

select 1,
kundennummer,
dummy_text9,
concat(LPAD(ticketnr,5,'0'),'-',substr(janein1.text,1,1)),



concat(kundennummer, '_03')   as BARCODE2,
'03' as nr
from ticket
left outer join akt ON  akt.ticket_id = ticket.id 
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id

where akt.mandant_id = 29 and (janein1.text = 'Gold' or janein1.text like 'P%') and status_id = 132

*/

order by 1,3,4,6
";

$filename = "files/wienenergie-akte-etiketten".date("Ymdm").".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 

while ($line = mysql_fetch_array($result)) { 
        $string = $line['KundenNummer'].";".$line['PacketNummer'].";".$line['TicketNummer'].";".$line['BARCODE'].";".$line['NR']; 			
		$string = $string.";"."\n"; 
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
echo "<br><br>"."KIMI-PLUS - WIEN_ENERGIE_ETIKETTEN : EXPORT - Ende: ".$heute;

?>
</body>    
</html>
