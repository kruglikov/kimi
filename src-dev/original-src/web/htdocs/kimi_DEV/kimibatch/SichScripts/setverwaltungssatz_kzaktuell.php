<html>
  <head>
     <title>KIMI-Plus - SET Verwaltungssatz KZ_AKTUELL</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SET Verwaltungssatz KZ_AKTUELL</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "SET Verwaltungssatz KZ_AKTUELL - Start: ".$heute;
// KZ_AKTUELL für altuellen Verwaltungssatz setzen
$aendern_vwalt = "update verwaltungssatz
set kz_aktuell = NULL,
geaendert_am = NOW(),
geaendert_von = 'System' where kz_aktuell = 'J'";
// 
// KZ_AKTUELL für altuellen Verwaltungssatz setzen
$aendern_vwneu = "update verwaltungssatz
set kz_aktuell = 'J',
geaendert_am = NOW(),
geaendert_von = 'System' where kz_aktuell = 'X'";
// 
// KZ_AKTUELL auf 'X' setzen für den nächsten Buchungstag	
$aendern_vwx = "update verwaltungssatz
set kz_aktuell = 'X',
geaendert_am = NOW(),
geaendert_von = 'System' where kz_aktuell = 'P' 
order by buchungsdatum LIMIT 2";

// 
echo "<br><br><b>Update Verwaltungssatz KZ_VERARBEITET ALT :<br></b>";
if (mysql_query($aendern_vwalt))
  {
  echo "&Auml;nderung KZ_AKTUELL auf 'NULL' f&uuml;r aktuellen Verwaltungssatz durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
// 
echo "<br><br><b>Update Verwaltungssatz KZ_VERARBEITET NEU :<br></b>";
if (mysql_query($aendern_vwneu))
  {
  echo "&Auml;nderung KZ_AKTUELL auf 'J'f&uuml;r aktuellen Verwaltungssatz durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
// 
echo "<br><br><b>Update Verwaltungssatz KZ_VERARBEITET X Setzen <br></b>";
if (mysql_query($aendern_vwx))
  {
  echo "&Auml;nderung KZ_AKTUELL auf 'X'f&uuml;r nächsten Buchungstag";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }  
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>SET Verwaltungssatz KZ_AKTUELL - Ende: ".$heute;

?>
</body>    
</html>
