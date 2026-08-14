  <head>
     <title>KIMI-PLUS - AKTE_SCHROTTLISTE : EXPORT</title>
  </head>
  <body>
  <h1>KIMI-PLUS - AKTE_SCHROTTLISTE : EXPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KIMI-PLUS - AKTE_SCHROTTLISTE : EXPORT - Start: ".$heute;


$query = "select  
'klient',
'aktenbezeichnung',
'kundennummer',
'anrede' ,
'familienname',
'vorname',
'erledigungsdatum' ,
'aktnr',
'bewertung',
'erledigungsgrund',
'ausbuchungsgrund',
'kimi-info',
'kimi-info2'
from dual
UNION
select  
'IPM' klient,
'Quelle-Handakten SCHROTT'     aktenbezeichnung,
kundennummer kundennummer,
anrede anrede ,
nachname familienname,
vorname vorname,
kunde_geburtsdatum Geburtsdatum ,
concat(kundennummer,'-',dummy_text9,'-',ticketnr) aktnr,
nummern2.text bewertung,
produkt.text erledigungsgrund,
grund.text ausbuchungsgrund,
replace(REPLACE( dummy_text10, CHAR(13,10), ' ' ),';',' ') info,
replace(
REPLACE( 

CASE
  WHEN kunde_nachname != akt_su_nachname or
       kunde_vorname !=  akt_su_vorname or
       kunde_plz != akt_su_plz or
       kunde_ort != akt_su_ort or
       concat(kunde_strasse ,' ',kunde_hausnummer , ' ' , kunde_hausnummer_erw) != akt_su_strhnr or
       kunde_geburtsdatum != akt_su_gebdatum
  THEN CONCAT (akt_hinweise,' / QuelleDaten: ',
               kunde_vorname, 
               kunde_nachname, 
               kunde_strasse, ' ', 
               kunde_hausnummer, 
               kunde_hausnummer_erw, ' ',
               kunde_plz,' ',
               kunde_ort)
  ELSE akt_hinweise
END

, CHAR(13,10), ' ' ),
';',' ')
kimi_info
from ticket 
left outer join akt ON  akt.ticket_id = ticket.id 
left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
left outer join grund on grund.id = ticket.grund_id
left outer join produkt on produkt.id = ticket.produkt_id

where akt.mandant_id = 1 and status_id = 2 and janein1.text = 'Nein' -- Betreibung = Nein
";

$filename = "files/akte-schrott".date("Ymdm").".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        $string = $line['klient'].";".$line['aktenbezeichnung'].";".$line['kundennummer'].";".$line['anrede'].";".$line['familienname'].";".$line['vorname'].";".$line['erledigungsdatum'].";".$line['aktnr'].";".$line['bewertung'].";"; 
		$string = $string.$line['erledigungsgrund'].";".$line['ausbuchungsgrund'].";".$line['kimi-info'].";".$line['kimi-info2']; 				
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
echo "<br><br>"."KIMI-PLUS - AKTE_SCHROTTISTE : EXPORT - Ende: ".$heute;

?>
</body>    
</html>
