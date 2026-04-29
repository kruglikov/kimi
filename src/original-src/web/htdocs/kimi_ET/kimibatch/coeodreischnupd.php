<html>
  <head>
     <title>KIMI-Plus - COEODREI SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  COEODREI SchnittstellenUpdate</h1>
<?PHP include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "COEODREI SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_knp3_erledigt = "
select * from ticket t where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreierledigt)
";
$select_knp3_erreicht = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreierreicht)
";
$select_knp3_erreichtap = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreierreichtap)
";
$select_knp3_unerreichbar = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in  (select ticketnr from knpdreiunerreichbar)
";
$select_knp3_telefonnummerfalsch = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreitelefonnummerfalsch)
";
// Updates für Stati
$update_knp3_erledigt = "
update ticket set status_id = 1982
where mandant_id = 27 and kampagne_id <>99 and ticketnr  in (select ticketnr from knpdreierledigt)
";
$update_knp3_erreicht = "
update ticket set anruf_status_id = 375 
where mandant_id = 27 and  kampagne_id <>99 and ticketnr in (select ticketnr from knpdreierreicht)
";
$update_knp3_erreichtap = "
update ticket set anruf_status_id = 515
where mandant_id = 27 and  kampagne_id <>99 and ticketnr in (select ticketnr from knpdreierreichtap)
";
$update_knp3_telefonnummerfalsch = "
update ticket set anruf_status_id = 376
where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreitelefonnummerfalsch)
";
$update_knp3_unerreichbar = "
update ticket set anruf_status_id = 377
where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from knpdreiunerreichbar)
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
echo "<br><br>COEODREI SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
