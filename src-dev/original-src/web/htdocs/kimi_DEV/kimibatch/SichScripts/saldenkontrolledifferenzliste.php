<html>
  <head>
     <title>KIMI-Plus - Saldenkontrolle Differenzliste</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Saldenkontrolle Differenzliste</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Saldenkontrolle Diffferenzliste - Start: ".$heute;

$query = "select 
case 
when kto_gesamtsaldo <> sk_saldo then 'FE'
else 'OK'
end kto_saldo_sk_saldo,
case 
when sk_saldo <> sk_sum_toepfe then 'FE'
else 'OK'
end sk_saldo_toepfe,
case 
when ROUND(sk_sum_auslag_kauf_buchungsbetrag, 2) <> sk_saldo then 'FE'
else 'OK'
end sk_saldo_buchungen,
case 
when kto_sum_auslagsaldo_buchungen <>kto_gesamtsaldo then 'FE'
else 'OK'
end kto_saldo_buchungen,
kto.*,subkto.* from (
SELECT s.ktonr,
DATE_FORMAT(s.dat_ltzt_buchung, '%Y-%c-%d') dat_ltzt_buchung,
REPLACE(CAST(sum(distinct IFNULL(s.betrag_l_auslagerung,0)) AS CHAR), '.', ',') kto_auslagerungssaldo,  
REPLACE(CAST( sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then 0 
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0
 else ABS(IFNULL(b.betrag,0))
 end ) AS CHAR), '.', ',') kto_sum_buchungen,
REPLACE(CAST(
sum(distinct IFNULL(s.betrag_l_auslagerung,0)) +
 sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N')  = 'N' then 0 
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0
 else ABS(IFNULL(b.betrag,0))
 end )
 AS CHAR), '.', ',')
 kto_sum_auslagsaldo_buchungen,
REPLACE(CAST(sum(distinct IFNULL(s.gesamtsaldo,0)) AS CHAR), '.', ',') 
  kto_gesamtsaldo
 FROM buchungen b 
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join stammdaten s on s.id = b.stammdaten_id 
/*where s.ktonr = 165225 /*351106 /*2483063 */
group by s.ktonr
) kto
left outer join (
SELECT  sk.stammdaten_id sk_ktonr, /*,sk.sk_lfdnr,skba.sk_auslagsaldo,*/
REPLACE(CAST(sum(IFNULL(
case 
when kz_aktuell = 'J' then IFNULL(sk.kaufwert,0) 
else 0
end
,0)) AS CHAR), '.', ',')  sk_kaufwert,
REPLACE(CAST(sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then 0 
 when IFNULL(sk.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and sk.buchungskennzeichen= 1 then ABS(IFNULL(sk.buchungsbetrag,0)) *-1
 when IFNULL(sk.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and sk.buchungskennzeichen= 0 then ABS(IFNULL(sk.buchungsbetrag,0)) *-1
 when IFNULL(sk.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(sk.buchungsbetrag,0))
 end) AS CHAR), '.', ',') sk_sum_buchungsbetrag,
REPLACE(CAST(sum(
case 
when kz_aktuell = 'J' then IFNULL(skba.sk_auslagsaldo2,0) 
else 0
end) AS CHAR), '.', ',') sk_sum_auslagerungssaldo,
REPLACE(CAST( 
sum(IFNULL(
case 
when kz_aktuell = 'J' then IFNULL(skba.sk_auslagsaldo2,0) 
else 0
end
,0)) +

sum(IFNULL(
case 
when kz_aktuell = 'J' then IFNULL(sk.kaufwert,0) 
else 0
end
,0)) +

sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then 0 
 when IFNULL(sk.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and sk.buchungskennzeichen= 1 then ABS(IFNULL(sk.buchungsbetrag,0)) *-1
 when IFNULL(sk.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and sk.buchungskennzeichen= 0 then ABS(IFNULL(sk.buchungsbetrag,0)) *-1
 when IFNULL(sk.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(sk.buchungsbetrag,0))
 end) AS CHAR), '.', ',') sk_sum_auslag_kauf_buchungsbetrag,
REPLACE(CAST(sum(IFNULL(
case 
when kz_aktuell = 'J' then sk.saldo
else 0
end
,0)) AS CHAR), '.', ',') sk_saldo,
REPLACE(CAST(sum(
case 
when kz_aktuell = 'J' then IFNULL(m4,0)
else 0
end +
case 
when kz_aktuell = 'J' then IFNULL(m3,0)
else 0
end +
case 
when kz_aktuell = 'J' then IFNULL(m2,0)
else 0
end +
case 
when kz_aktuell = 'J' then IFNULL(m1,0)
else 0
end +
case 
when kz_aktuell = 'J' then IFNULL(m0,0)
else 0
end +

case 
when kz_aktuell = 'J' then IFNULL(rest,0)
else 0
end 

)  AS CHAR), '.', ',') sk_sum_toepfe
 FROM subkonto_neu sk
join bua_bgr_man buabgr on  buabgr.id = sk.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
left outer join subkontobuchungen_auslag skba on skba.sk_ktonr = sk.stammdaten_id and skba.sk_lfdnr = sk.sk_lfdnr
group by sk.stammdaten_id /*,sk.sk_lfdnr*/
) subkto on kto.ktonr = subkto.sk_ktonr
where 
kto_gesamtsaldo <> sk_saldo 
or sk_saldo <> sk_sum_toepfe
or round(sk_sum_auslag_kauf_buchungsbetrag,2) <> sk_saldo 
or kto_sum_auslagsaldo_buchungen <>kto_gesamtsaldo
";

$filename = "files/saldenkontrollediffenzliste.csv";
$fp = fopen($filename, 'w');
// Überschriftszeile

$string = 'kto_saldo_sk_saldo;sk_saldo_toepfe;sk_saldo_buchungen;kto_saldo_buchungen;ktonr;dat_ltzt_buchung;kto_auslagerungssaldo;kto_sum_buchungen;kto_sum_auslagsaldo_buchungen;kto_gesamtsaldo;sk_kaufwert;sk_sum_buchungsbetrag;sk_sum_auslagerungssaldo;sk_sum_auslag_kauf_buchungsbetrag;sk_saldo;sk_sum_toepfe'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kto_saldo_sk_saldo'].';'.$line['sk_saldo_toepfe'].';'.$line['sk_saldo_buchungen'].';'.$line['kto_saldo_buchungen'].';'.$line['ktonr'].';'.$line['dat_ltzt_buchung'].';'.$line['kto_auslagerungssaldo'].';'.$line['kto_sum_buchungen'].';'.$line['kto_sum_auslagsaldo_buchungen'].';'.$line['kto_gesamtsaldo'].';'.$line['sk_kaufwert'].';'.$line['sk_sum_buchungsbetrag'].';'.$line['sk_sum_auslagerungssaldo'].';'.$line['sk_sum_auslag_kauf_buchungsbetrag'].';'.$line['sk_saldo'].';'.$line['sk_sum_toepfe']."\n"; 
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
echo "<br><br>"."Saldenkontrolle Differenzliste - Ende: ".$heute;

?>
</body>    
</html>
