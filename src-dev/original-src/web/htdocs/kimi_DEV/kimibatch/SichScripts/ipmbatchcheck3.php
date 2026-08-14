<html>
  <head>
     <title>KIMI-Plus - IPM-BatchCheck3</title>
  </head>
  <body>
  <h1>KIMI-Plus -  IPM-BatchCheck3</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "IPM-BatchCheck3 - Start: ".$heute;
// 1) ALLE maschinellen Zahlungen gebucht?
$query_masch_za = "select count(*) anzahl from 
(
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.kz_gebucht
from buchungen b
where b.bua_bgr_man_id in (1102154, 1102150)
and b.buchungsdatum = curdate()
and IFNULL(b.kz_gebucht,'N') != 'J'
) masch_za";

// 1) Check manuelle Zahlungen?
$query_man_za = "select 'stammdaten_id', 'betrag', 'buchungsdatum', 'valutadatum', 'geaendert_am'
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102254
and b.buchungsdatum = curdate()
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102250
and b.buchungsdatum = curdate()
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102156
and b.buchungsdatum = curdate()
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102159
and b.buchungsdatum = curdate()";

// 2) Check maschinelle Zahlungen?
$query_masch_za2 = "select 'stammdaten_id', 'betrag', 'buchungsdatum', 'valutadatum', 'geaendert_am'
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102154
and b.buchungsdatum = curdate()
UNION
select b.stammdaten_id, b.betrag, b.buchungsdatum, b.valutadatum, b.geaendert_am
from buchungen b
where b.bua_bgr_man_id = 1102150
and b.buchungsdatum = curdate()
";


//
echo "<br><br><b>1) Pr&uuml;fung ALLE maschinellen Zahlungen gebucht?:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_masch_za);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<br><b><font color='#FF0000'>ANZAHL ZAHLUNGEN</font></b>&nbsp;ALLE NICHT maschinellen Zahlungen gebucht?: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER - ALLE MASCHINELLEN ZAHLUNGEN GEBUCHT</font></b><br>";
    }

 ?>
 
 <?PHP 

}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//

echo "<br><br><b>1) Pr&uuml;fung ALLE manuellen Zahlungen gebucht?:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

//
$result = mysql_query($query_man_za);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['stammdaten_id'].";".$line['betrag'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['geaendert_am'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//


echo "<br><br><b>1) Pr&uuml;fung ALLE maschinellen Zahlungen gebucht?:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

//
$result = mysql_query($query_masch_za2);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['stammdaten_id'].";".$line['betrag'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['geaendert_am'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
  //

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>IPM-BatchCheck3- Ende: ".$heute;

?>
</body>    
</html>
