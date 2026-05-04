<html>
  <head>
     <title>KIMI-Plus - INKO-2016 SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-2016 SchnittstellenUpdate</h1>
<?PHP

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    

echo "INKO-2016 SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkosantander_erledigt = "
select * from ticket t where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016erledigt)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016erreicht)
";
$select_inkosantander_erreichtap = "
select * from ticket where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016erreichtap)
";
$select_inkosantander_unerreichbar = "
select * from ticket where mandant_id = 18 and kampagne_id <>99 and ticketnr in  (select ticketnr from inko2016unerreichbar)
";
$select_inkosantander_telefonnummerfalsch = "
select * from ticket where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016telefonnummerfalsch)
";
// Updates für Stati
$update_inkosantander_erledigt = "
update ticket set status_id = 69 
where mandant_id = 18 and kampagne_id <>99 and ticketnr  in (select ticketnr from inko2016erledigt)
";
$update_inkosantander_erreicht = "
update ticket set anruf_status_id = 236 
where mandant_id = 18 and  kampagne_id <>99 and ticketnr in (select ticketnr from inko2016erreicht)
";
$update_inkosantander_erreichtap = "
update ticket set anruf_status_id = 446 
where mandant_id = 18 and  kampagne_id <>99 and ticketnr in (select ticketnr from inko2016erreichtap)
";
$update_inkosantander_telefonnummerfalsch = "
update ticket set anruf_status_id = 237 
where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016telefonnummerfalsch)
";
$update_inkosantander_unerreichbar = "
update ticket set anruf_status_id = 238 
where mandant_id = 18 and kampagne_id <>99 and ticketnr in (select ticketnr from inko2016unerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-2016-Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_inkosantander_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_inkosantander_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn, );
  }
if (mysqli_query($dbconn, $update_inkosantander_erreichtap))
  {
  echo "Update Status ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_inkosantander_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_inkosantander_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

//

//mysql_free_result($result);

// mysql_close();

dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>INKO2016 SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
