<html>
  <head>
     <title>KIMI-Plus - COEO CH SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  COEO CH SchnittstellenUpdate</h1>
<?PHP include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "COEO CH SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_knp3_erledigt = "
select * from ticket t where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3erledigt)
";
$select_knp3_erreicht = "
select * from ticket where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3erreicht)
";
$select_knp3_erreichtap = "
select * from ticket where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3erreichtap)
";
$select_knp3_unerreichbar = "
select * from ticket where mandant_id = 41 and kampagne_id <>99 and ticketnr in  (select ticketnr from knp3unerreichbar)
";
$select_knp3_telefonnummerfalsch = "
select * from ticket where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3telefonnummerfalsch)
";
// Updates für Stati
$update_knp3_erledigt = "
update ticket set status_id = 192
where mandant_id = 41 and kampagne_id <>99 and ticketnr  in (select ticketnr from knp3erledigt)
";
$update_knp3_erreicht = "
update ticket set anruf_status_id = 622 
where mandant_id = 41 and  kampagne_id <>99 and ticketnr in (select ticketnr from knp3erreicht)
";
$update_knp3_erreichtap = "
update ticket set anruf_status_id = 632
where mandant_id = 41 and  kampagne_id <>99 and ticketnr in (select ticketnr from knp3erreichtap)
";
$update_knp3_telefonnummerfalsch = "
update ticket set anruf_status_id = 624
where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3telefonnummerfalsch)
";
$update_knp3_unerreichbar = "
update ticket set anruf_status_id = 625
where mandant_id = 41 and kampagne_id <>99 and ticketnr in (select ticketnr from knp3unerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  COEODREI-Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_knp3_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp3_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp3_erreichtap))
  {
  echo "Update Status ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp3_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_knp3_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

//

dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>COEO CH SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
