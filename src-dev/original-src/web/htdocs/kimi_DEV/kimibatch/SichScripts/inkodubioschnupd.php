<html>
  <head>
     <title>KIMI-Plus - INKO-DUBIO SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-DUBIO SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INKO-DUBIO SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkosantander_erledigt = "
select * from ticket t where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodubioerledigt)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodubioerreicht)
";
$select_inkosantander_unerreichbar = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in  (select ticketnr from inkodubiounerreichbar)
";
$select_inkosantander_telefonnummerfalsch = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodubiotelefonnummerfalsch)
";
// Updates für Stati
$update_inkosantander_erledigt = "
update ticket set status_id = 102 
where mandant_id = 24 and kampagne_id <>99 and ticketnr  in (select ticketnr from inkodubioerledigt)
";
$update_inkosantander_erreicht = "
update ticket set anruf_status_id = 335 
where mandant_id = 24 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkodubioerreicht)
";
$update_inkosantander_telefonnummerfalsch = "
update ticket set anruf_status_id = 336
where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodubiotelefonnummerfalsch)
";
$update_inkosantander_unerreichbar = "
update ticket set anruf_status_id = 337
where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodubiounerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-DUBIO-Tabellen:<br></b>";
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
echo "<br><br>INKODUBIO SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
