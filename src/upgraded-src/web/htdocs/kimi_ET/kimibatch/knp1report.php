<html>
  <head>
     <title>KIMI-Plus - KNP 1 REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KNP 1 REPORT</h1>
<?PHP 
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    
echo "KNP 1 REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_knp1
select ticket.*,now() from ticket 
where ticket.mandant_id =40 and kampagne_id <>99 and status_id = 187
and anruf_status_id in (536,545,544,537,613);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_knp1 durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_knp1 in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."KNP 1 REPORT - Ende: ".$heute;
//
dbClose($dbconn);
?>
</body>    
</html>
