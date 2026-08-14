<html>
  <head>
     <title>KIMI-Plus - INKO-Santander SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-Santander SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INKO-Santander SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkosantander_erledigt = "
select * from ticket t where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoerledigt)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoerreicht)
";
$select_inkosantander_erreichtap = "
select * from ticket where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkoerreichtap)
";
$select_inkosantander_unerreichbar = "
select * from ticket where mandant_id = 12 and kampagne_id <>99 and ticketnr in  (select ticketnr from inkounerreichbar)
";
$select_inkosantander_telefonnummerfalsch = "
select * from ticket where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkotelefonnummerfalsch)
";
// Updates für Stati
$update_inkosantander_erledigt = "
update ticket set status_id = 46 
where mandant_id = 12 and kampagne_id <>99 and ticketnr  in (select ticketnr from inkoerledigt)
";
$update_inkosantander_erreicht = "
update ticket set anruf_status_id = 144 
where mandant_id = 12 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkoerreicht)
";
$update_inkosantander_erreichtap = "
update ticket set anruf_status_id = 444 
where mandant_id = 12 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkoerreichtap)
";
$update_inkosantander_telefonnummerfalsch = "
update ticket set anruf_status_id = 145 
where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkotelefonnummerfalsch)
";
$update_inkosantander_unerreichbar = "
update ticket set anruf_status_id = 146 
where mandant_id = 12 and kampagne_id <>99 and ticketnr in (select ticketnr from inkounerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-Santander-Tabellen:<br></b>";
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
echo "<br><br>INKO-Santander SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
