<html>
  <head>
     <title>KIMI-Plus - &Uuml;berzahlungen S&uuml;dtirol</title>
  </head>
  <body>
  <h1>KIMI-Plus -  &Uuml;berzahlungen S&uuml;dtirol</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "&Uuml;berzahlungen S&uuml;dtirol - Start: ".$heute;

/* ORIGINAL - View DEVIS
CREATE OR REPLACE VIEW V_GUTHABEN_MARKT21 AS
SELECT k.kundennummer, k.markt, k.titel, k.nachname, k.vorname, k.vorname2, k.adresszusatz, k.strasse, k.hausnummer, k.hausnr_zusatz, k.hausnr_erweiterung, k.plz, k.ort,
bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) Saldo,
(SELECT COUNT(*) anzahl
      FROM subkonten sk
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and sk.t_zahlungsart_markt_oid = 619732094935152092) Anz_RV,
 (SELECT COUNT(*) anzahl
      FROM subkonten sk
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and sk.t_zahlungsart_markt_oid = 619732094935152094) Anz_1X,
       (SELECT COUNT(*) anzahl
      FROM subkonten sk
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and sk.t_zahlungsart_markt_oid = 619732094935152093) Anz_NN
FROM kundensuche k
WHERE k.markt = 21
and bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) < 0

*/

$query = "SELECT 
k.kdnr kundennummer, 
k.markt markt, 
k.titel titel, 
k.nachname nachname , 
k.vorname vorname, 
k.vorname2 vorname2, 
k.adresszusatz, 
k.strasse, 
k.hausnummer, 
null hausnummer_zusatz,
CONCAT (' ',k.hausnummer_erw) hausnummer_erw, /* Hausnummer_zusatz ist hier enthalten */
k.plz, 
k.ort,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') saldo ,
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      join zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = s.id
       AND IFNULL(sk.saldo,0) > 0
       and IFNULL(sk.kz_aktuell,'N') = 'J'
       and z.text = 'RV') anz_rv,
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      join zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = s.id
       AND IFNULL(sk.saldo,0) > 0
       and IFNULL(sk.kz_aktuell,'N') = 'J'
       and z.text = '1X') anz_1x,
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      join zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = s.id
       AND IFNULL(sk.saldo,0) > 0
       and IFNULL(sk.kz_aktuell,'N') = 'J'
       and z.text = 'NN') anz_nn,
DATE_FORMAT(s.dat_ltzt_buchung, '%Y-%c-%d') dat_ltzt_buchung,
s.inkassostatus_id inkassostatus
FROM kunde k
join stammdaten s on s.kunde_id = k.id
WHERE k.markt = 21
and IFNULL(s.gesamtsaldo,0) < 0
";

$filename = "files/ueberzahlungenst.csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string = 'KUNDENNUMMER;MARKT;TITEL;NACHNAME;VORNAME;VORNAME2;ADRESSZUSATZ;STRASSE;HAUSNUMMER;HAUSNR_ZUSATZ;HAUSNR_ERW;PLZ;ORT;SALDO;ANZ_RV;ANZ_1X;ANZ_NN;DAT_LTZT_BUCHUNG;INKASSOSTATUS'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kundennummer'].';'.$line['markt'].';'.$line['titel'].';'.$line['nachname'].';'.$line['vorname'].';'.$line['vorname2'].';'.$line['adresszusatz'].';'.$line['strasse'].';'.$line['hausnummer'].';'.$line['hausnummer_zusatz'].';'.$line['hausnummer_erw'].';'.$line['plz'].';'.$line['ort'].';'.$line['saldo'].';'.$line['anz_rv'].';'.$line['anz_1x'].';'.$line['anz_nn'].';'.$line['dat_ltzt_buchung'].';'.$line['inkassostatus']."\n"; 
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
echo "<br><br>"."&Uuml;berzahlungen S&uuml;dtirol - Ende: ".$heute;

?>
</body>    
</html>
