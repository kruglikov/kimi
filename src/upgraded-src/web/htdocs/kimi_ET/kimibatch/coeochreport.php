<html>
  <head>
     <title>KIMI-Plus - COEOCH DE REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  COEOCH DE  REPORT</h1>
<?PHP 
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    
echo "COEOCH DE REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_knp3
select ticket.*,now() from ticket 
where ticket.mandant_id =41 and kampagne_id <>99 and status_id = 191
and anruf_status_id in (620,629,630,631,627)
and fahrgestellnummer like 'de-CH%';
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_knp3 durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_knp3 in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."COEOCH REPORT - Ende: ".$heute;
//
dbClose($dbconn);
?>
</body>    
</html>
