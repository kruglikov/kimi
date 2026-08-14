<html>
  <head>
     <title>KIMI-Plus - OKO REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "OKO REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_oko
select ticket.*,now() from ticket 
where ticket.mandant_id =16 and kampagne_id <>99 and status_id = 55
and anruf_status_id in (197,204,203);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_oko durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_oko in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."OKO REPORT - Ende: ".$heute;
//
if ($result) {
  mysqli_free_result($result);
}
mysqli_close($dbconn);
?>
</body>    
</html>
