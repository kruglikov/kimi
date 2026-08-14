<html>
  <head>
     <title> SCHLAUSTROM -check</title>
  </head>
  <body>
  <h1>KIMI-Plus -   SCHLAUSTROM -check</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "SCHLAUSTROM -check - Start: ".$heute;


//
echo "<br><br><b>Pr&uuml;fung Abfrage Status 'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_status_anruf_status);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | Anruf_Status: ".$line['anzahl_n_verarbeitet']."<br>";
//
echo "<br><br><b>Status ERLEDIGT und NICHT ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";


</body>    
</html>
