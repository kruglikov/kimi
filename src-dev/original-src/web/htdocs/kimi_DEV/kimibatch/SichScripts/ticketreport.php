<html>
  <head>
     <title>KIMI-Plus - Ticketreport</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Ticketreport</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Ticketreport - Start: ".$heute;
// Abfrage 1
$query = "select m.text mandant,IFNULL(ast.text,'offen') status ,count(*) anzahl
from ticket t
left outer join mandant m on m.id = t.mandant_id
left outer join benutzer b on b.id = t.benutzer_id
left outer join anruf_status ast on ast.id = t.anruf_status_id
left outer join status st on st.id = t.status_id
left outer join prioritaet p on p.id = t.prioritaet_id
left outer join grund g on g.id = t.grund_id
left outer join firma f on f.id = t.firma_id
left outer join produkt pro on pro.id = t.produkt_id
group by t.mandant_id,IFNULL(ast.text,'offen') 
order by 1,2
";
// Abfrage 2
$query2 = "select m.text mandant,IFNULL(st.text,'offen') status , bewertung, count(*) anzahl
from ticket t
left outer join mandant m on m.id = t.mandant_id
left outer join benutzer b on b.id = t.benutzer_id
left outer join anruf_status ast on ast.id = t.anruf_status_id
left outer join status st on st.id = t.status_id
left outer join prioritaet p on p.id = t.prioritaet_id
left outer join grund g on g.id = t.grund_id
left outer join firma f on f.id = t.firma_id
left outer join produkt pro on pro.id = t.produkt_id
group by m.text,IFNULL(st.text,'offen') , bewertung
order by 1,2,3
";
$result = mysql_query($query);
$sum_anzahl= 0;
//Spaltenüberschrift //
$drucksatz='  <table border="1"><tr><td><b>Mandant</b></td><td><b>Status</b></td><td><b>Anzahl</b></td></tr>';
echo "<br>".$drucksatz;
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= "<tr><td>".$line['mandant']."</td><td>".$line['status']."</td><td>".$line['anzahl']."</td></tr>";
$sum_anzahl= $sum_anzahl + $line['anzahl'];

echo $drucksatz;

 ?>
 <?PHP 
 
}
echo "<tr><td><b>Summe</b></td><td></td><td>".$sum_anzahl."</td></tr></table>";

mysql_free_result($result);

$result = mysql_query($query2);
$sum_anzahl= 0;
//Spaltenüberschrift //
$drucksatz='  <table border="1"><tr><td><b>Mandant</b></td><td><b>Status</b></td><td><b>Bewertung</b></td><td><b>Anzahl</b></td></tr>';
echo "<br>".$drucksatz;
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= "<tr><td>".$line['mandant']."</td><td>".$line['status']."</td><td>".$line['bewertung']."</td><td>".$line['anzahl']."</td></tr>";
$sum_anzahl= $sum_anzahl + $line['anzahl'];

echo $drucksatz;

 ?>
 <?PHP 
 
}
echo "<tr><td><b>Summe</b></td><td></td><td></td><td>".$sum_anzahl."</td></tr></table>";

mysql_free_result($result);



mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Ticketreport - Ende: ".$heute;

?>

</body>    
</html>
