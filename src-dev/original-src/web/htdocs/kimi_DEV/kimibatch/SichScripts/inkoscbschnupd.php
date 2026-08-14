<html>
  <head>
     <title>KIMI-Plus - INKO-SCB SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-SCB SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INKO-SCB SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkosantander_erledigt = "
select * from ticket t where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscberledigt)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscberreicht)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscberreichtap)
";
$select_inkosantander_unerreichbar = "
select * from ticket where mandant_id = 21 and kampagne_id <>99 and ticketnr in  (select ticketnr from inkoscbunerreichbar)
";
$select_inkosantander_telefonnummerfalsch = "
select * from ticket where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscbtelefonnummerfalsch)
";
// Updates für Stati
$update_inkosantander_erledigt = "
update ticket set status_id = 83 
where mandant_id = 21 and kampagne_id <>99 and ticketnr  in (select ticketnr from inkoscberledigt)
";
$update_inkosantander_erreicht = "
update ticket set anruf_status_id = 288
where mandant_id = 21 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkoscberreicht)
";
$update_inkosantander_erreichtap = "
update ticket set anruf_status_id = 479
where mandant_id = 21 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkoscberreichtap)
";
$update_inkosantander_telefonnummerfalsch = "
update ticket set anruf_status_id = 289 
where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscbtelefonnummerfalsch)
";
$update_inkosantander_unerreichbar = "
update ticket set anruf_status_id = 290 
where mandant_id = 21 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoscbunerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-SCB-Tabellen:<br></b>";
if (mysql_query($update_inkosantander_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_inkosantander_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_inkosantander_erreichtap))
  {
  echo "Update Status ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }  
if (mysql_query($update_inkosantander_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($update_inkosantander_unerreichbar))
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
echo "<br><br>INKOSCB SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
