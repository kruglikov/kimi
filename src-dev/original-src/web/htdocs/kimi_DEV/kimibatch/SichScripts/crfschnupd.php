<html>
  <head>
     <title>KIMI-Plus - CRF SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  CRF SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "CRF SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_crf_erledigt = "
select * from ticket t where mandant_id = 25 and kampagne_id <>99 and ticketnr in (select ticketnr from crferledigt)
";
$select_crf_erreicht = "
select * from ticket where mandant_id = 25 and kampagne_id <>99 and ticketnr in (select ticketnr from crferreicht)
";
$select_crf_unerreichbar = "
select * from ticket where mandant_id = 25 and kampagne_id <>99 and ticketnr in  (select ticketnr from crfunerreichbar)
";
$select_crf_telefonnummerfalsch = "
select * from ticket where mandant_id = 25 and kampagne_id <>99 and ticketnr in (select ticketnr from crftelefonnummerfalsch)
";
// Updates für Stati
$update_crf_erledigt = "
update ticket set status_id = 106 
where mandant_id = 25 and kampagne_id <>99 and ticketnr  in (select ticketnr from crferledigt)
";
$update_crf_erreicht = "
update ticket set anruf_status_id = 347 
where mandant_id = 25 and  kampagne_id <>99 and ticketnr in (select ticketnr from crferreicht)
";
$update_crf_telefonnummerfalsch = "
update ticket set anruf_status_id = 348
where mandant_id = 25 and kampagne_id <>99 and ticketnr in (select ticketnr from crftelefonnummerfalsch)
";
$update_crf_unerreichbar = "
update ticket set anruf_status_id = 349
where mandant_id = 25 and kampagne_id <>99 and ticketnr in (select ticketnr from crfunerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INKO-DE-Tabellen:<br></b>";
if (mysql_query($update_crf_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_crf_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_crf_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($update_crf_unerreichbar))
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
echo "<br><br>CRF SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
