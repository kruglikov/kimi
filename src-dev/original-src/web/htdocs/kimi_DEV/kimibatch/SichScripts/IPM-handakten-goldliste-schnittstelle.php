  <head>
     <title>KIMI-PLUS - AKTE_GOLDLISTE : EXPORT</title>
  </head>
  <body>
  <h1>KIMI-PLUS - AKTE_GOLDLISTE : EXPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KIMI-PLUS - AKTE_GOLDLISTE : EXPORT - Start: ".$heute;


$query = "select  
'KDNr',
'Anrede' ,
'Gegner Nachname',
'Vorname',
'Geburtsdatum' ,
'Firmenbuchnummer',
'Straße',
'LKZ',
'PLZ',
'Ort',
'Telefonnr',
'weitere Schuldner',
'Archivnummer',
'restl. Hauptforderung',
'Zinssatz Kapital',
'restl. Nebenforderung',
'Abrechnungsstichtag',
'kapitalisierte Zinsen bis Stichtag',
'restl. RA-Honorar',
'restl. Barauslagen',
'Titelgericht',
'Titel vom',
'Geschäftszahl Titel',
'letztes Exekutionsgericht',
'Geschäftszahl Exe',
'Status KIMI'
from dual
UNION 
select  
ifnull(kunde_kdnr,ticket.kundennummer) kundennummer,
akt_su_anrede anrede ,-- kunde_anrede_text anrede ,
ifnull(akt_su_nachname,ticket.nachname) familienname,-- ifnull(kunde_nachname,ticket.nachname) familienname,
ifnull(akt_su_vorname,ticket.vorname) vorname,-- ifnull(kunde_vorname,ticket.vorname) vorname,
akt_su_gebdatum Geburtsdatum, -- kunde_geburtsdatum Geburtsdatum ,
akt_su_firmenbuchnummer firmenbuchnummer,
akt_su_strhnr strasse_und_hausnummer,
'A' laenderkennzeichen,
ifnull(akt_su_plz,ticket.plz) plz,
ifnull(akt_su_ort,ticket.ort) ort,
null kommunikation,
akt_forderungsgrund01 forderungsgrund01,
case 
when akt_forderungsgrund12 ='' then concat(kundennummer,'-',dummy_text9,'-',ticketnr)
else akt_forderungsgrund12 end  forderungsgrund12,
REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_hauptforderung,0) / 13.7603 ELSE IFNULL(akt_restl_hauptforderung,0) END
, 2),',',''),'.',',') restl_hauptforderung,
REPLACE(REPLACE(FORMAT(

akt_zinssatz_kapital
, 2),',',''),'.',',')  zinssatz_kapital,
REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_nebenforderung,0) / 13.7603 ELSE IFNULL(akt_restl_nebenforderung,0) END
, 2),',',''),'.',',')  restl_nebenforderung,
curdate()  abrechnungsstichtag,
REPLACE(REPLACE(FORMAT(
case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_kap_zinsen_bis_stichtag,0) / 13.7603 ELSE IFNULL(akt_kap_zinsen_bis_stichtag,0) END
, 2),',',''),'.',',')  kap_zinsen_bis_stichtag,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_rest_ra_honorar,0) / 13.7603 ELSE IFNULL(akt_rest_ra_honorar,0) END
, 2),',',''),'.',',') rest_ra_honorar,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_barauslagen ,0) / 13.7603 ELSE IFNULL(akt_restl_barauslagen ,0) END
, 2),',',''),'.',',') restl_barauslagen,
akt_titel_gericht titel_gericht,
akt_titel_datum titel_vom,
akt_titel_geschaeftszahl titel_geschaeftszahl,
akt_letztes_exekutionsgericht letztes_exekutionsgericht,
akt_exekution_geschaeftszahl exekution_geschaeftszahl,
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

, CHAR(13,10), ' ' ) ,
';',' ')
kimi_info


from ticket
left outer join akt ON  akt.ticket_id = ticket.id 
left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
left outer join grund on grund.id = ticket.grund_id
left outer join produkt on produkt.id = ticket.produkt_id


where ticket.mandant_id = 1 and status_id = 3 -- status_id = 5 and akt_abrechnungsstichtag = '2016-09-30' --
and janein1.text = 'Ja' -- Betreibung = JA
";

$filename = "files/akte-goldliste".date("Ymdm").".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        $string = $line['KDNr'].";".$line['Anrede'].";".$line['Gegner Nachname'].";".$line['Vorname'].";".$line['Geburtsdatum'].";".$line['Firmenbuchnummer'].";".$line['Straße'].";"; 
		$string = $string.$line['LKZ'].";".$line['PLZ'].";".$line['Ort'].";".$line['Telefonnr'].";".$line['weitere Schuldner'].";".$line['Archivnummer'].";".$line['restl. Hauptforderung'].";".$line['Zinssatz Kapital'].";".$line['restl. Nebenforderung'].";".$line['Abrechnungsstichtag'].";"; 
		$string = $string.$line['kapitalisierte Zinsen bis Stichtag'].";".$line['restl. RA-Honorar'].";".$line['restl. Barauslagen'].";".$line['Titelgericht'].";".$line['Titel vom'].";".$line['Geschäftszahl Titel'].";".$line['letztes Exekutionsgericht'].";".$line['Geschäftszahl Exe'].";"; 		
		$string = $string.$line['Status KIMI']."\n"; 				
		//$string = $string."\n"; 
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
echo "<br><br>"."KIMI-PLUS - AKTE_GOLDLISTE : EXPORT - Ende: ".$heute;

?>
</body>    
</html>
