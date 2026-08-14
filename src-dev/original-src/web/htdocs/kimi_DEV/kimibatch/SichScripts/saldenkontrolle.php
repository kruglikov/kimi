<html>
  <head>
     <title>KIMI-Plus - Saldenkontrolle</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Saldenkontrolle</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Saldenkontrolle - Check - Start: ".$heute;
// Abfrage Stichtag
$query_konto = "select count(*) anzahl from
(
SELECT s.ktonr,
sum(distinct IFNULL(s.betrag_l_auslagerung,0)) auslagerungssaldo,  
 sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then 0 
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end ) sum_buchungen,
sum(distinct IFNULL(s.gesamtsaldo,0)) gesamtsaldo
 FROM buchungen b 
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join stammdaten s on s.id = b.stammdaten_id 
/*where s.ktonr = 55136063*/
group by s.ktonr
) kto
where gesamtsaldo <> (auslagerungssaldo+sum_buchungen)";
// Abfrage Sukonto_neu
$query_subkonto_neu = "select count(*) anzahl from 
(SELECT  sk.stammdaten_id,sk.sk_lfdnr,
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
join stammdaten s on s.id = sk.stammdaten_id
join subkontobuchungen_auslag skba on skba.sk_ktonr = s.ktonr and skba.sk_lfdnr = sk.sk_lfdnr
group by sk.stammdaten_id /*,sk.sk_lfdnr*/
) subkto
where sk_saldo <> sk_sum_toepfe";
// Stichtag

echo "<br><br><b>Pr&uuml;fung Konto (Stammdaten):<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_konto);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Differenzen Gesamtsaldo und Buchungen: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
mysql_free_result($result);
echo "Ende: ".date("d.m.Y H:i:s");  
//Subkonten
echo "<br><br><b>Pr&uuml;fung Subkonten:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_subkonto_neu);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Differenzen Subkontosaldo und Subkonto-T&ouml;pfe: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  


mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Saldenkontrolle - Check - Ende: ".$heute;

?>
</body>    
</html>
