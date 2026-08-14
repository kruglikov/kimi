<html>
  <head>
     <title>KIMI-Plus - CHECK Verarbeitung Buchungstag</title>
  </head>
  <body>
  <h1>KIMI-Plus -  CHECK Verarbeitung Buchungstag abgeschlossen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "CHECK Verarbeitung Buchungstag- Start: ".$heute;
// Abfrage Stichtag
$query_vwsatz1 = "SELECT count(*) anzahl_n_verarbeitet from verwaltungssatz vw
where IFNULL(vw.kz_verarbeitet,'N') = 'N' and IFNULL(vw.kz_aktuell,'N') = 'J'";

echo "<br><br><b>Pr&uuml;fung Ordnungsgem&auml;&szlig;e Verarbeitung Buchungstag:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_vwsatz1);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Tagesverarbeitung NICHT verarbeitet: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>BUCHUNGSTAG ordnungsgem&szlig; verarbeitet</font></b><br>";
    }

 ?>
 <?PHP 
 
}
mysql_free_result($result);
echo "Ende: ".date("d.m.Y H:i:s");  
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>CHECK Verarbeitung Buchungstag - Ende: ".$heute;

?>
</body>    
</html>
