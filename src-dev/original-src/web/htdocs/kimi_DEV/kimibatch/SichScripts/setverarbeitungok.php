<html>
  <head>
     <title>KIMI-Plus - SET Verarbeitung OK</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SET Verarbeitung OK</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "SET Verarbeitung OK - Start: ".$heute;
// Tagesverareitung im Verwaltungssatz auf OK setzen
$aendern = "update verwaltungssatz vw
set vw.kz_verarbeitet = 'J' where vw.kz_aktuell = 'J'";
// 
echo "<br><br><b>Update Verwaltungssatz KZ_VERARBEITET:<br></b>";
if (mysql_query($aendern))
  {
  echo "&Auml;nderung KZ_VERARBEITET bei aktuellen Verwaltungss&auml;tzen durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>SET Verarbeitung OK - Ende: ".$heute;

?>
</body>    
</html>
