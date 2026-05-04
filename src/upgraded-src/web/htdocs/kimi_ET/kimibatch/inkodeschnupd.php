<html>
  <head>
     <title>KIMI-Plus - INKO-DE SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-DE SchnittstellenUpdate</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    

echo "INKO-DE SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkosantander_erledigt = "
select * from ticket t where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodeerledigt)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodeerreicht)
";
$select_inkosantander_erreicht = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodeerreichtap)
";
$select_inkosantander_unerreichbar = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in  (select ticketnr from inkodeunerreichbar)
";
$select_inkosantander_telefonnummerfalsch = "
select * from ticket where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodetelefonnummerfalsch)
";
// Updates für Stati
$update_inkosantander_erledigt = "
update ticket set status_id = 102 
where mandant_id = 24 and kampagne_id <>99 and ticketnr  in (select ticketnr from inkodeerledigt)
";
$update_inkosantander_erreicht = "
update ticket set anruf_status_id = 335 
where mandant_id = 24 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkodeerreicht)
";
$update_inkosantander_erreichtap = "
update ticket set anruf_status_id = 448 
where mandant_id = 24 and  kampagne_id <>99 and ticketnr in (select ticketnr from inkodeerreichtap)
";
$update_inkosantander_telefonnummerfalsch = "
update ticket set anruf_status_id = 336
where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodetelefonnummerfalsch)
";
$update_inkosantander_unerreichbar = "
update ticket set anruf_status_id = 337
where mandant_id = 24 and kampagne_id <>99 and ticketnr in (select ticketnr from inkodeunerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-DE-Tabellen:<br></b>";
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
  echo "Error creating database: " . mysqli_error($dbconn);
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
  echo "Error creating database: " . mysqli_error();
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
echo "<br><br>INKODE SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
