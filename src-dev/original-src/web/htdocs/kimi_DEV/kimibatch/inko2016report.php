<html>
  <head>
     <title>KIMI-Plus - INKO2016 REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO2016 REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKO2016 REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_inko2016
select ticket.*,now() from ticket 
where ticket.mandant_id =18 and kampagne_id <>99 and status_id = 68
and anruf_status_id in (234,241,240,445);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report)) {
  echo "<br><br>Insert in Reporttabelle ticket_inko2016 durchgef&uuml;hrt";
}
else {
  echo "<br><br>Error insert Reporttabelle ticket_inko2016 in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKO2016 REPORT - Ende: ".$heute;
//
if ($result) {
  mysqli_free_result($result);
}
mysqli_close($dbconn);
?>
</body>    
</html>
