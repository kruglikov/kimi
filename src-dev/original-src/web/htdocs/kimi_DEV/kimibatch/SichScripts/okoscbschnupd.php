<html>
  <head>
     <title>KIMI-Plus - OKO-SCB SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO-SCB SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "OKO SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_oko_erledigt = "
select * from ticket where mandant_id = 19 and ticketnr in (select ticketnr from okoscberledigt)
";
$select_oko_erreicht = "
select * from ticket where mandant_id = 19 and ticketnr in (select ticketnr from okoscberreicht)
";
$select_oko_unerreichbar = "
select * from ticket where mandant_id = 19 and ticketnr in (select ticketnr from okoscbunerreichbar)
";
$select_oko_telefonnummerfalsch = "
select * from ticket where mandant_id = 19 and ticketnr in (select ticketnr from okoscbtelefonnummerfalsch)
";
// Updates für Stati
$update_oko_erledigt = "
update ticket set status_id = 73
where mandant_id = 19 and ticketnr in  (select ticketnr from okoscberledigt)
";
$update_oko_erreicht = "
update ticket set anruf_status_id = 258
where mandant_id = 19 and ticketnr in (select ticketnr from okoscberreicht)
";
$update_oko_telefonnummerfalsch = "
update ticket set anruf_status_id = 259
where mandant_id = 19 and ticketnr in (select ticketnr from okoscbtelefonnummerfalsch)
";
$update_oko_unerreichbar = "
update ticket set anruf_status_id = 260
where mandant_id = 19 and ticketnr in (select ticketnr from okoscbunerreichbar)
";

//


echo "<br><br><b>UPDATE Stati der OKO-SCB Tabellen:<br></b>";
if (mysql_query($update_oko_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_oko_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_oko_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($update_oko_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

//

//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>OKO - SCB SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
