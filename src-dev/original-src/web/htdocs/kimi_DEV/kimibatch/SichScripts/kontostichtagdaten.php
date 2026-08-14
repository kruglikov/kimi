<html>
  <head>
     <title>KIMI-Plus - Stichtagsdaten am Konto speichern</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtagsdaten am Konto speichern</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Stichtagsdaten am Konto speichern - Start: ".$heute;
// Tabellen Stammdaten updaten
$stammdaten_upd = "update stammdaten s
set 
s.dat_l_kontoauszug =  (select dat_l_kontoauszug_neu from stichtag st where st.stammdaten_id = s.id),
s.betrag_l_kontoauszug = (select betrag_l_kontoauszug_neu from stichtag st where st.stammdaten_id = s.id),
s.mahnstufe = (select mahnstufe_neu from stichtag st where st.stammdaten_id = s.id),
s.geaendert_am = now(),
s.geaendert_von = 'kontostichtagdaten.php',
s.dat_l_mahnlauf = 
IFNULL(
case
when (select kontoauszug_art from stichtag st where st.stammdaten_id = s.id) in ('M1','M2','M3','M4') then
(select dat_l_kontoauszug_neu from stichtag st where st.stammdaten_id = s.id)
end,s.dat_l_mahnlauf),
s.dat_einzbetrag =
IFNULL(
case
when s.lastschrift = 'J' then
(select (select vw.buchungsdatum from verwaltungssatz vw
where vw.kz_aktuell = 'J' and vw.markt = 10) from stichtag st where st.stammdaten_id = s.id)
end,s.dat_einzbetrag)
where s.id in (select st.stammdaten_id from stichtag st where st.kz_verarbeitet in ('I','S','G','M') )";
// 
// Tabellen Stammdaten updaten STICHTAG und ZAHLTAG
	$stammdaten_upd2 = "update stammdaten s
		join  stichtag st on st.stammdaten_id = s.id
		set 
		s.letzter_stichtag = s.stichtag,
		s.letzter_zahltag  = s.zahltag,
		s.stichtag =ADDDATE(s.stichtag, INTERVAL +1 MONTH),
		s.zahltag = ADDDATE(( select vw.buchungsdatum from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10),interval +18 DAY)";
// 
	$stammdaten_sttag1 = "Update stammdaten s
set s.stichtag =
ADDDATE(s.stichtag, INTERVAL +1 DAY) 
where DAYOFMONTH(s.stichtag) <> s.stichtagtagdesmonats
and  DATE_FORMAT(s.stichtag, '%c') = 3
";
//		
	$stammdaten_sttag2 = "Update stammdaten s
set s.stichtag =
ADDDATE(s.stichtag, INTERVAL +1 DAY) 
where DAYOFMONTH(s.stichtag) <> s.stichtagtagdesmonats
and  DATE_FORMAT(s.stichtag, '%c') = 3
";
//
echo "<br><br><b>Update KONTO mit Daten aus Stichtag:<br></b>";
if (mysql_query($stammdaten_upd))
  {
  echo "&Auml;nderung Tabelle STAMMDATEN durchgef&uuml;hrt";
  }
else
  {
  echo "Error Update KONTO mit Daten aus Stichtag: " . mysql_error();
  }
// 
echo "<br><br><b>Update Konto- STAMMDATEN - STICHTAG und ZAHLTAG:<br></b>";
if (mysql_query($stammdaten_upd2))
  {
  echo "&Auml;nderung Tabelle STAMMDATEN - STICHTAG und ZAHLTAG durchgef&uuml;hrt";
  }
else
  {
  echo "Error Update Konto- STAMMDATEN - STICHTAG und ZAHLTAG: " . mysql_error();
  }
// 
echo "<br><br><b>Update Konto- STAMMDATEN - STICHTAG 29/30 Feb - 1:<br></b>";
if (mysql_query($stammdaten_sttag1))
  {
  echo "&Auml;nderung Tabelle STAMMDATEN - - STICHTAG 29/30 Feb - 1 durchgef&uuml;hrt";
  }
else
  {
  echo "Error - STICHTAG 29/30 Feb - 1: " . mysql_error();
  }
// 
echo "<br><br><b>Update Konto- STAMMDATEN -  STICHTAG 29/30 Feb - 2:<br></b>";
if (mysql_query($stammdaten_sttag2))
  {
  echo "&Auml;nderung Tabelle STAMMDATEN -  STICHTAG 29/30 Feb - 2 durchgef&uuml;hrt";
  }
else
  {
  echo "Error  STICHTAG 29/30 Feb - 2: " . mysql_error();
  }
//  
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Stichtagsdaten am Konto speichern - Ende: ".$heute;

?>
</body>    
</html>
