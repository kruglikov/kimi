<html>
  <head>
     <title>KIMI-Plus - OKONONPERFORM REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKONONPERFORM REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "OKO REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_okononperform
select ticket.*,now() from ticket 
where ticket.mandant_id =19 and kampagne_id <>99 and status_id = 72
and anruf_status_id in (256,261,262);
";

// INSERT IN TICKET-Tabelle
if (mysql_query($insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_okononperform^ durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_okononperform in database: " . mysql_error();
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."OKONONPERFORM REPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
