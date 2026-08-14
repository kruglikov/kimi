<html>
  <head>
     <title>KIMI-Plus - CHECK Verwaltungssatz Salden</title>
  </head>
  <body>
  <h1>KIMI-Plus -  CHECK Verwaltungssatz Salden</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "CHECK Verwaltungssatz Salden- Start: ".$heute;
// Abfrage VW-Satz AT
$query_vwsatzat = "select count(*) anzahl_n_verarbeitet,
IFNULL(vw.saldo_gesamt,0) gesamtsaldo_neu,
(select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0) from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 10 ) gesamtsaldo_alt_und_buchungen,
IFNULL(vw.saldo_gesamt,0) -
(select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0)
from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 10 ) differenz
 from verwaltungssatz vw
where vw.markt = 10 and vw.kz_aktuell = 'X' and NOT vw.saldo_gesamt = (
select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0) from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 10)";
// Abfrage VW-Satz ST
$query_vwsatzst = "select count(*) anzahl_n_verarbeitet,
IFNULL(vw.saldo_gesamt,0) gesamtsaldo_neu,
(select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0) from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 10 ) gesamtsaldo_alt_und_buchungen,
IFNULL(vw.saldo_gesamt,0) -
(select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0)
from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 10 ) differenz
 from verwaltungssatz vw
where vw.markt = 21 and vw.kz_aktuell = 'X' and NOT vw.saldo_gesamt = (
select IFNULL(saldo_gesamt,0) + IFNULL(saldo_tag,0) from  verwaltungssatz vw2
where vw2.kz_aktuell = 'J' and vw2.markt = 21)";

echo "<br><br><b>Pr&uuml;fung &Uuml;bereinstimmung-Salden BUCHUNGSTAG und GESAMT Buchungstag AT:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_vwsatzat);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Salden BUCHUNGSTAG und GESAMT Buchungstag AT:<br> Gesamtsaldo_neu".$line['gesamtsaldo_neu']."<br> Gesamtsaldo Alt und Buchungen:".$line['gesamtsaldo_alt_und_buchungen']."<br> Gesamtsaldo Alt und Buchungen:".$line['differenz']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>BUCHUNGSTAG ordnungsgem&auml;&szlig; verarbeitet</font></b><br>";
    }

 ?>
 <?PHP 
 
}
mysql_free_result($result);

echo "<br><br><b>Pr&uuml;fung &Uuml;bereinstimmung-Salden BUCHUNGSTAG und GESAMT Buchungstag ST:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_vwsatzst);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Salden BUCHUNGSTAG und GESAMT Buchungstag ST:<br> Gesamtsaldo_neu".$line['gesamtsaldo_neu']."<br> Gesamtsaldo Alt und Buchungen:".$line['gesamtsaldo_alt_und_buchungen']."<br> Gesamtsaldo Alt und Buchungen:".$line['differenz']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>BUCHUNGSTAG ordnungsgem&auml;&szlig; verarbeitet</font></b><br>";
    }

 ?>
 <?PHP 
 
}
mysql_free_result($result);
echo "Ende: ".date("d.m.Y H:i:s");  
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>CHECK Verwaltungssatz Salden - Ende: ".$heute;

?>
</body>    
</html>
