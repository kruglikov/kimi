<html>
  <head>
     <title>KIMI-Plus - Tagesabschlusscheck</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Tagesabschlusscheck</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Tagesabschluss - Check - Start: ".$heute;
// Abfrage Stichtag
$query_stichtag = "select count(*) anzahl_n_verarbeitet from stichtag st where NOT IFNULL(st.kz_verarbeitet,'N') = 'X'
AND NOT IFNULL(st.kz_verarbeitet,'N') = 'J' AND NOT IFNULL(st.kz_verarbeitet,'N') = 'M' AND NOT IFNULL(st.kz_verarbeitet,'N') = 'S'";
// Abfrage Stichtag SAVE
$query_stichtagsave = "select count(*) anzahl_n_verarbeitet from stichtag_save st where NOT IFNULL(st.kz_verarbeitet,'N') = 'X'
AND NOT IFNULL(st.kz_verarbeitet,'N') = 'J' AND NOT IFNULL(st.kz_verarbeitet,'N') = 'M' AND NOT IFNULL(st.kz_verarbeitet,'N') = 'S'
AND NOT IFNULL(st.kz_verarbeitet,'N') = 'G'
";
// Abfrage Buchungen
$query_buchungen = "select count(*) anzahl_n_verarbeitet from buchungen b where NOT IFNULL(b.kz_gebucht,'N') = 'J'
and b.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')";
// Abfrage Sukonto_neu
$query_subkonto_neu = "select count(*) anzahl_n_verarbeitet from subkonto_neu sk where NOT IFNULL(sk.kz_gebucht,'N') = 'J'
and sk.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')";
// Abfrage SW mit KA
$query_swka = "select count(*) anzahl_n_verarbeitet
from stichtag st
join kunde k on k.id = st.stammdaten_id
where k.kenner like '%SW%'
and st.kz_verarbeitet <>'X' and IFNULL(st.kontoauszug_art,'X') <> 'X'";
// Abfrage XX mit SP
$query_xxsp = "select count(*) anzahl_n_verarbeitet
from buchungen  b 
join kunde k on k.id = b.stammdaten_id
where 
(k.kenner like '%XX%' and k.kenner = '%SP%')
and
IFNULL(b.kz_gebucht,'N') = 'J'
and b.bua_bgr_man_id = 1104030
and b.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')";
// Abfrage SP mit KA und Mahnstufe 3
$query_spkam3 = "select count(*) anzahl_n_verarbeitet
from stichtag st
join kunde k on k.id = st.stammdaten_id
where k.kenner like '%SP%'
and st.kz_verarbeitet <>'X' and IFNULL(st.kontoauszug_art,'X') <> 'X'
and st.mahnstufe_neu = 3";
// Inkassostatus falsch bei ATIN	
$query_atin = "select count(*) anzahl_n_verarbeitet
from buchungen  b 
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

echo "<br><br><b>Pr&uuml;fung Stichtag:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_stichtag);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Nichtverarbeitet Stichtag: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "<br><br><b>Pr&uuml;fung Stichtag SAVE:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_stichtagsave);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Nichtverarbeitet StichtagSAVE: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
mysql_free_result($result);
echo "Ende: ".date("d.m.Y H:i:s");  
//Subkonten
echo "<br><br><b>Pr&uuml;fung Subkonten:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_subkonto_neu);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Nichtverarbeitet Subkonten: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  

//Buchungen
echo "<br><br><b>Pr&uuml;fung Buchungen:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_buchungen);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Nichtverarbeitet Buchungen: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  

//Verstorben mit Versicherung  KEINE Prämie XX und SP !!
echo "<br><br><b>Pr&uuml;fung Verstorbene mit Versicherungspr&auml;mie:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_xxsp);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Verstorben mit Versicherungspr&auml;ie - DARF NICHT SEIN: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  

//Sachwalter mit Kontoauszug !!
echo "<br><br><b>Pr&uuml;fung Sachwalter mit Kontoauszug<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_xxsp);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Sachwalter mit Kontoauszug - Kontoauszug an Sachwalter, Kundennummer ermitteln: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  


//Versicherung mit Kontoauszug und Mahnstufe 3!!
echo "<br><br><b>Pr&uuml;fung Versicherung mit Kontoauszug und Mahnstufe = 3<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_xxsp);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Versicherung mit Kontoauszug - Mahnstufe 3 - Mahnung Versicherung: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s");  

//Versicherung mit Kontoauszug und Mahnstufe 3!!
echo "<br><br><b>Pr&uuml;fung Inkassostatus bei ATIN	<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_atin);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Inkassostatus bei ATIN nicht richtig gesetzt: ".$line['anzahl_n_verarbeitet']."<br>";
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 <?PHP 
 
}
echo "Ende: ".date("d.m.Y H:i:s"); 

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Tagesabschluss - Check - Ende: ".$heute;

?>
</body>    
</html>
