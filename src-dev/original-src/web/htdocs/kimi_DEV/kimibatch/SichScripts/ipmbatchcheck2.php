<html>
  <head>
     <title>KIMI-Plus - IPM-BatchCheck2</title>
  </head>
  <body>
  <h1>KIMI-Plus -  IPM-BatchCheck2</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "IPM-BatchCheck2 - Start: ".$heute;
// 1) Versicherung
$query_versicherung = "select count(*) anzahl
from(
select b.stammdaten_id,count(*) from buchungen b
where b.bua_bgr_man_id = 1104030
and b.buchungsdatum = (select vw.buchungsdatum from verwaltungssatz vw where kz_aktuell = 'J' and markt = 10)
and 
b.stammdaten_id in (
select b.stammdaten_id from buchungen b
where b.bua_bgr_man_id in ( 1104235,1104242, 1104234, 1104244)
and b.buchungsdatum = (select vw.buchungsdatum from verwaltungssatz vw where kz_aktuell = 'J' and markt = 10)
)
group by b.stammdaten_id
having count(*) <>2
) versicherung";

// 2) prüfen Belgedatum bei aktuellen Stichtagsbuchungen
$query_belegdatum = "
select count(*) anzahl from buchungen b
where b.buchungsdatum = (select vw.buchungsdatum from verwaltungssatz vw where kz_aktuell = 'J' and markt = 10)
and b.valutadatum > (select vw.buchungsdatum from verwaltungssatz vw where kz_aktuell = 'J' and markt = 10)
and substr(b.bua_bgr_man_id,-4) = 4000
";

 // 3) Prüfung Valutadatum = Stichtagsdatum
$query_valuta_stichtag = "select count(*) anzahl
from(
SELECT s.id, s.stichtag, b.buchungsdatum, b.valutadatum, b.geaendert_von 
FROM buchungen b join stammdaten s on s.id = b.stammdaten_id 
where b.buchungsdatum in 
(select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J') 
and b.valutadatum != s.stichtag and IFNULL(s.inkassostatus_id, 0) not between 03 and 91 
and ( s.stichtag in ( select stichtag1 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag2 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag3 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag4 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag5 from verwaltungssatz where kz_aktuell = 'J')
)
UNION
SELECT s.id, s.stichtag, skn.buchungsdatum, skn.belegdatum, skn.geaendert_von 
FROM subkonto_neu skn join stammdaten s on s.id = skn.stammdaten_id 
where skn.buchungsdatum in 
(select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J') 
and skn.belegdatum != s.stichtag and IFNULL(s.inkassostatus_id, 0) not between 03 and 91 
and ( s.stichtag in ( select stichtag1 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag2 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag3 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag4 from verwaltungssatz where kz_aktuell = 'J') or s.stichtag in ( select stichtag5 from verwaltungssatz where kz_aktuell = 'J')
) 
) check_valutadate";
// 4) Stichtagsdatum
$query_stichtagsdatum = "select count(*) anzahl from stammdaten s
where s.stichtag > adddate(now(),INTErVAL +1 MONTH)";

// 5) INkassodaten
$query_inkassodaten = "
select count(*) anzahl from stammdaten s
where s.inkassostatus_id is null
and exists (select * from inkassoinformation i where i.kundennummer = s.ktonr)"; 

// 6) Mahnstufen
$query_mahnstufen = "select count(*) anzahl
from (
SELECT s.stammdaten_id, s.mahnstufe, s.mahnstufe_neu FROM stichtag s
where kz_verarbeitet in ('I','M', 'S','G') 
and IFNULL(s.mahnstufe,0) <> IFNULL(s.mahnstufe_neu,0)
and IFNULL(s.mahnstufe,0)+1 < IFNULL(s.mahnstufe_neu,0) -- wenn größer, dann nur eine Stufe (ausser bei Stundung?)
) mahnstcheck";

// 7) ATIN
$query_atin = "
select count(*) anzahl
from buchungen b 
join kunde k on k.id = b.stammdaten_id
join stammdaten s on s.id = k.id
where 
(
(IFNULL(s.inkassostatus_id,0) != 116 and IFNULL(s.inkassostatus_id,0) != 123)
and IFNULL(b.kz_gebucht,'N') = 'J'
and b.bua_bgr_man_id = 1104244
and b.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')
)
or
(
IFNULL(s.inkassostatus_id,0) != 101
and IFNULL(b.kz_gebucht,'N') = 'J'
and b.bua_bgr_man_id = 1104242
and b.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')
)"; 

// 8) Berücksichtigung Mahnsperre:
$query_mahnsperre = "
select count(*)  anzahl
from (
SELECT s.ktonr, s.stichtag, s.mahnsperre, b.bua_bgr_man_id,b.buchungsdatum, b.geaendert_von, s.geaendert_am
FROM stammdaten s
join buchungen b on b.stammdaten_id = s.id
where s.mahnsperre = 'MS'
and b.bua_bgr_man_id in (1104234, 1104235, 1104242, 1104244)
and b.buchungsdatum = curdate()
and s.gesamtsaldo > 0
and IFNULL(s.inkassostatus_id,0) not between 03 and 89
) mahnsperre"; 

// 9) Berücksichtigung Stundung:
$query_stundung = "
select count(*) anzahl
from (
SELECT s.ktonr, s.stichtag, s.kto_kenner
FROM stammdaten s
join buchungen b on b.stammdaten_id = s.id
where kto_kenner like '%ST%'
and b.bua_bgr_man_id = 1104234
and b.buchungsdatum = curdate() /* between adddate(curdate(),interval -30 day) and curdate()*/
group by s.ktonr
) stundung"; 
// 
//
echo "<br><br><b>1) Pr&uuml;fung VERSICHERUNG:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_versicherung);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<br><b><font color='#FF0000'>FEHLER</font></b>&nbsp;VERSICHERUNG: ".$line['anzahl']."<br>";
    }
     else {
       echo "<br><b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
echo "<br><br><b>2) Pr&uuml;fung BELEGDATUM bei Stichtagsbuchungen:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_belegdatum);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<br><b><font color='#FF0000'>FEHLER</font></b>&nbsp;BELEGDATUM bei Stichtagsbuchungen: ".$line['anzahl']."<br>";
    }
     else {
       echo "<br><b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  

//
echo "<br><br><b>3) Pr&uuml;fung Valutadatum = Stichtagsdatum:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_valuta_stichtag);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Valutadatum = Stichtagsdatum: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>4) Pr&uuml;fung Stichtagsdatum:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_stichtagsdatum);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Stichtagsdatum: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>5) Pr&uuml;fung Inkassodaten:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_inkassodaten);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Inkassodaten: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>6) Pr&uuml;fung Mahnstufen:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_mahnstufen);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Mahnstufen: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>7) Pr&uuml;fung ATIN:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_atin);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;ATIN: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>8) Pr&uuml;fung Mahnsperre:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_mahnsperre);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Mahnsperre: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//
//
echo "<br><br><b>9) Pr&uuml;fung Stundung:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_stundung);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Stundung: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//



  //

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>IPM-CheckBatch2 - Ende: ".$heute;

?>
</body>    
</html>
