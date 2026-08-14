<html>
  <head>
     <title>KIMI-Plus - Buchungen Cardif</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Buchungen Cardif</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Buchungen Cardif - Start: ".$heute;

/* ORIGINAL DEVIS-Selektion
CREATE OR REPLACE VIEW V_KRSV_PRAEMIEN_STAT AS
SELECT kusu.kundennummer,
			 an1.an1_anrede_text anrede,
			 pers.titel,
			 pers.vorname,
			 pers.nachname,
			 pers.gebdat,
			 an1.sex_kz geschlecht,
			 CASE
				 WHEN tdbg.kz_berechnung = 'P' --Lastschrift
					THEN
			      CASE WHEN nvl(buch.buchungskennzeichen,0) IN (0, 2) THEN
              NVL(buch.betrag, 0) * -1
            ELSE --Storno
              NVL(buch.betrag, 0)
            END
				 ELSE
					CASE
				 WHEN NVL(buch.buchungskennzeichen, 0) IN (0, 2) THEN
					NVL(buch.betrag, 0)
				 ELSE --Storno
					NVL(buch.betrag, 0) * -1
			 END END praemie,
			 buch.buchungsdatum
	FROM buchungen buch
  JOIN t_buchgrund_markt tbgm ON tbgm.id = buch.t_buchgrund_markt_oid
	JOIN t_db_buchgrund tdbg ON tdbg.id = tbgm.t_db_buchgrund_oid
	JOIN t_db_buchart tdba ON tdba.id = tdbg.t_db_buchart_oid
	JOIN kundensuche kusu ON kusu.kunde_oid = buch.adr_id
	JOIN person pers ON pers.ID = kusu.person_oid
	JOIN t_anrede an1 ON an1.ID = pers.t_anrede_oid
 WHERE tdba.buchungsart IN (40 --Lastschrift Pr�mie
			 , 50 -- Gutschrift Pr�mie
			 )
	 AND tdbg.buchungsgrund = 30 --Pr�mienbuchung
*/

$query = "select k.kdnr kundennummer,
/*anr.text anrede, Tafr- �ber Geschlecht umwandel, da personalisiert*/
case
when k.geschlecht1 = 'M' then 'Herr'
when k.geschlecht1 = 'W' then 'Frau'
when k.geschlecht1 = 'L' then 'Familie'
when k.geschlecht1 = 'F' then 'Firma'
else anr.text
end anrede,
k.titel titel,
k.vorname vorname,
k.nachname nachname,
DATE_FORMAT(k.geburtsdatum, '%Y-%c-%d') gebdat,
k.geschlecht1 geschlecht,
REPLACE(CAST(IFNULL(case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen = 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen = 0 then ABS(IFNULL(b.betrag,0)) *-1
 else ABS(IFNULL(b.betrag,0))
 end,0) AS CHAR), '.', ',') praemie,
DATE_FORMAT(b.buchungsdatum, '%Y-%c-%d') buchungsdatum
from buchungen b
join stammdaten s on s.id = b.stammdaten_id
join kunde k on k.id = s.kunde_id
join anrede anr on anr.id = k.anrede_id
join mandant m on m.id = k.mandant_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
left join mwst mw on mw.id = b.mwst_id
where IFNULL(b.kz_gebucht,'N') = 'J'
and (substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) IN ( 40,50))
and substring(cast(bugr.bugru_key as CHAR) FROM -2 FOR 2) = 30
and (EXTRACT(YEAR_MONTH FROM b.buchungsdatum) = EXTRACT(YEAR_MONTH FROM (NOW() - INTERVAL 1 MONTH))) /*Vormonat */
";

$filename = "files/krsv_praemien".date("Ymdm").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile

$string = 'kundennummer;anrede;titel;vorname;nachname;gebdat;geschlecht;praemie;buchungsdatum'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kundennummer'].';'.$line['anrede'].';'.$line['titel'].';'.$line['vorname'].';'.$line['nachname'].';'.$line['gebdat'].';'.$line['geschlecht'].';'.$line['praemie'].';'.$line['buchungsdatum']."\n"; 
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
echo "<br><br>"."Buchungen Cardif - Ende: ".$heute;

?>
</body>    
</html>
