  <head>
     <title>KIMI-PLUS - WIEN_ENERGIE_AKTE_GOLDLISTE : EXPORT</title>
  </head>
  <body>
  <h1>KIMI-PLUS - WIEN_ENERGIE_AKTE_GOLDLISTE : EXPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KIMI-PLUS - WIEN_ENERGIE_AKTE_GOLDLISTE : EXPORT - Start: ".$heute;


$query = "select  
'VK Nummer',
'Anrede' ,
'Kunde Nachname',
'Kunde Vorname',
'Geburtsdatum' ,
'Firmenbuchnummer',
'Straße',
'LKZ',
'PLZ',
'Ort',
'Telefonnr',
'weitere Schuldner',
'Archivnummer',
'Klagsbetrag',
'Zinssatz Kapital',
'restl. Nebenforderung',
'Zinsstartdatum',
'verzinsl. RA-Honorar Klage',
'unverzinsl. RA-Kosten',
'Summe Zahlungen',
'Titelgericht',
'Urteilsdatum',
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
akt_zinsstartdatum  abrechnungsstichtag,
REPLACE(REPLACE(FORMAT(
case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_kap_zinsen_bis_stichtag,0) / 13.7603 ELSE IFNULL(akt_kap_zinsen_bis_stichtag,0) END
, 2),',',''),'.',',')  kap_zinsen_bis_stichtag,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_kosten_sonst,0) / 13.7603 ELSE IFNULL(akt_kosten_sonst,0) END
, 2),',',''),'.',',') rest_ra_honorar,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_rest_ra_honorar,0) / 13.7603 ELSE IFNULL(akt_rest_ra_honorar,0) END
, 2),',',''),'.',',') akt_rest_ra_honorar,/*
REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_barauslagen ,0) / 13.7603 ELSE IFNULL(akt_restl_barauslagen ,0) END
, 2),',',''),'.',',') restl_barauslagen, */
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


where ticket.kundennummer in  (
'220001912267-0',
'220002768947-0',
'220003165508-0',
'220002795818-1',
'220000902148-0',
'220002325743-1',
'220002508981-0',
'220001712877-0',
'220002747692-0',
'220002729536-0',
'220001847974-1',
'220002124699-1',
'220000099626-0',
'220000899165-0',
'220002963260-0',
'220001326560-0',
'220001326560-1',
'220002588890-1',
'220002317900-0',
'220000077981-1',
'220001816960-1',
'220000061338-1',
'220002668276-0',
'220000165002-0',
'220003563448-0',
'220002162717-0',
'220002162717-1',
'220002190673-0',
'220003003244-0',
'220002272748-0',
'220002272748-1',
'220002392196-0',
'220002896483-0',
'220001876836-0',
'220003164099-0',
'220002521708-0',
'220002660730-0',
'220002994671-0',
'220002633576-0',
'220002644075-0',
'220003109672-1',
'220002713868-1',
'220003297086-0',
'220002975436-0',
'220003202832-0',
'220001985866-0',
'220002595024-0',
'220001720368-0',
'220000788672-0',
'220002904894-2',
'220000266351-0',
'220000860256-0',
'220001860715-0',
'220001904509-0',
'220001012717-0',
'220002156377-0',
'220002359541-0',
'220001827186-1',
'220000222550-0',
'220003222990-0',
'220002906992-0',
'220002875093-2',
'220002598360-0',
'220000707776-0',
'220000545932-0',
'220000282512-2',
'220000481757-0',
'220002230881-0',
'220002262268-0',
'220000954928-0',
'220003020524-0',
'220001620870-2',
'220000919084-0',
'220003115839-0',
'220001853641-0',
'220002231909-0',
'220002864994-0',
'220003008564-1',
'220003191113-1',
'220003521802-0',
'220001586264-0',
'220003145271-0',
'220003414499-0',
'220002180065-0',
'220003149590-0',
'220002127208-0',
'220001991945-0',
'220002581721-0',
'220002878029-0',
'220000142245-0',
'220001994743-0',
'220002339935-0',
'220000357134-0',
'220003108686-0',
'220002769128-0',
'220002512148-0',
'220003075588-0',
'220002728543-0',
'220002318959-0',
'220000930088-0',
'220002911716-1',
'220001916809-1',
'220002921452-0',
'220002838592-0',
'220002108502-0',
'220003126251-0',
'220000957719-0',
'220002710529-0',
'220000306387-0',
'220002753685-0',
'220001490665-0',
'220003122659-0',
'220002020694-0',
'220001617151-0',
'220002004668-0',
'220003127566-0',
'220002291349-1',
'220001118081-0',
'220002694891-0',
'220002693716-0',
'220003337893-0',
'220001074241-0',
'220002035106-0',
'220001935410-0',
'220002374081-0',
'220001908601-0',
'220001138089-0',
'220001453622-0',
'220000706424-0',
'220002071454-0',
'220000393407-0',
'220002153819-0',
'220000660410-0',
'220001917804-0')
and janein1.text = 'Gold' -- Betreibung = JA
";

$filename = "files/wienenergieakte-goldliste-schnittstelle".date("Ymdm").".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        $string = $line['VK Nummer'].";".$line['Anrede'].";".$line['Kunde Nachname'].";".$line['Kunde Vorname'].";".$line['Geburtsdatum'].";".$line['Firmenbuchnummer'].";".$line['Straße'].";"; 
		$string = $string.$line['LKZ'].";".$line['PLZ'].";".$line['Ort'].";".$line['Telefonnr'].";".$line['weitere Schuldner'].";".$line['Archivnummer'].";".$line['Klagsbetrag'].";".$line['Zinssatz Kapital'].";".$line['Zinsstartdatum'].";"; 
		$string = $string.$line['verzinsl. RA-Honorar Klage'].";".$line['unverzinsl. RA-Kosten'].";".$line['Summe Zahlungen'].";".$line['Titelgericht'].";".$line['Urteilsdatum'].";".$line['Geschäftszahl Titel'].";".$line['letztes Exekutionsgericht'].";".$line['Geschäftszahl Exe'].";"; 		
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
echo "<br><br>"."KIMI-PLUS - WIEN_ENERGIE_AKTE_GOLDLISTE : EXPORT - Ende: ".$heute;

?>
</body>    
</html>
