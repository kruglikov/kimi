<html>
  <head>
     <title>KIMI-Plus - KNP 1 SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KNP 1 SchnittstellenUpdate</h1>
<?PHP include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "KNP 1 SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_knp1_erledigt = "
select * from ticket t where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1erledigt)
";
$select_knp1_erreicht = "
select * from ticket where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1erreicht)
";
$select_knp1_erreichtap = "
select * from ticket where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1erreichtap)
";
$select_knp1_unerreichbar = "
select * from ticket where mandant_id = 40 and kampagne_id <>99 and ticketnr in  (select ticketnr from knp1unerreichbar)
";
$select_knp1_telefonnummerfalsch = "
select * from ticket where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1telefonnummerfalsch)
";
// Updates für Stati
$update_knp1_erledigt = "
update ticket set status_id = 188
where mandant_id = 40 and kampagne_id <>99 and ticketnr  in (select ticketnr from knp1erledigt)
";
$update_knp1_erreicht = "
update ticket set anruf_status_id = 540 
where mandant_id = 40 and  kampagne_id <>99 and ticketnr in (select ticketnr from knp1erreicht)
";
$update_knp1_erreichtap = "
update ticket set anruf_status_id = 539
where mandant_id = 40 and  kampagne_id <>99 and ticketnr in (select ticketnr from knp1erreichtap)
";
$update_knp1_telefonnummerfalsch = "
update ticket set anruf_status_id = 541 
where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1telefonnummerfalsch)
";
$update_knp1_unerreichbar = "
update ticket set anruf_status_id = 542
where mandant_id = 40 and kampagne_id <>99 and ticketnr in (select ticketnr from knp1unerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  KNP1-Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_knp1_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  $heute = date("d.m.Y H:i:s");    
  echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp1_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  $heute = date("d.m.Y H:i:s");    
  echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp1_erreichtap))
  {
  echo "Update Status ERREICHTAP durchgef&uuml;hrt<br>";
  $heute = date("d.m.Y H:i:s");    
  echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_knp1_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  $heute = date("d.m.Y H:i:s");    
  echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;  
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_knp1_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  $heute = date("d.m.Y H:i:s");    
  echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

//

dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>KNP 1 SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
