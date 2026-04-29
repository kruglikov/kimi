<html>
  <head>
     <title>KIMI-Plus - COEODREI REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  COEOCDREI REPORT</h1>
<?PHP 
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    
echo "COEODREI REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_knpdrei
select ticket.*,now() from ticket 
where ticket.mandant_id =27 and kampagne_id <>99 and status_id = 117
and anruf_status_id in (373,378,379,372,634);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_knpdrei durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_knpdrei in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."COEODREI REPORT - Ende: ".$heute;
//
dbClose($dbconn);
?>
</body>    
</html>
