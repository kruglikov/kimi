<html>
  <head>
     <title>KIMI-Plus - Verwaltungssatz Salden berechnen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Verwaltungssatz Salden berechnen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Verwaltungssatz Salden berechnen - Start: ".$heute;
// �ndern der Felder DAT_LTZT_ZAHLUNG und BETRAG_LTZT_ZAHLUNG
$saldotag_at = "Update verwaltungssatz   set
saldo_tag = (
SELECT   sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') then 0 
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0    
 else ABS(IFNULL(b.betrag,0))
 end )
 FROM buchungen b 
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join kunde k on k.id = b.stammdaten_id 
where b.buchungsdatum = (select max(buchungsdatum)  from buchungen )
and bugr.kz_saldowirksam = 'J'
and k.markt = 10)
where kz_aktuell = 'J' and markt = 10 and mandant_id = 1 and 
buchungsdatum = (select max(buchungsdatum)  from buchungen )";
// 
$saldotag_st = "Update verwaltungssatz   set
saldo_tag = (
SELECT   sum(
case 
 when IFNULL(bugr.kz_saldowirksam,'N') then 0 
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0    
 else ABS(IFNULL(b.betrag,0))
 end )
 FROM buchungen b 
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join kunde k on k.id = b.stammdaten_id 
where b.buchungsdatum = (select max(buchungsdatum)  from buchungen )
and bugr.kz_saldowirksam = 'J'
and k.markt = 21)
where kz_aktuell = 'J' and markt = 21 and mandant_id = 1 and 
buchungsdatum = (select max(buchungsdatum)  from buchungen )";
// 
$gessaldo_at = "update verwaltungssatz set
saldo_gesamt = (select sum(gesamtsaldo) from stammdaten s 
join kunde k on k.id = s.kunde_id 
where k.markt = 10)
where kz_aktuell = 'X' and markt = 10";
// 
$gessaldo_st = "update verwaltungssatz set
saldo_gesamt = (select sum(gesamtsaldo) from stammdaten s 
join kunde k on k.id = s.kunde_id
where k.markt = 21)
where kz_aktuell = 'X' and markt = 21";

//
//echo "<br><br><b><font color='#FF0000'>ACHTUNG:</font><br></b>";
//echo "<br><br><b><font color='#FF0000'>select date_add(max(buchungsdatum), INTERVAL -1 DAY)  from buchungen anpassen</font></b><br>";

// 
echo "<br><br><b>Update Verwaltungssatz Saldo Tag AT:<br></b>";
if (mysql_query($saldotag_at))
  {
  echo "&Auml;nderung SALDO_TAG AT  durchgef&uml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
//
echo "<br><br><b>Update Verwaltungssatz Saldo Tag ST:<br></b>";
if (mysql_query($saldotag_st))
  {
  echo "&Auml;nderung SALDO_TAG AT  durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
//
echo "<br><br><b>Update Verwaltungssatz Gesamtsaldo Tag AT:<br></b>";
if (mysql_query($gessaldo_at))
  {
  echo "&Auml;nderung GESSALDO_AT  durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
//
echo "<br><br><b>Update Verwaltungssatz Gesamtsaldo Tag ST:<br></b>";
if (mysql_query($gessaldo_st))
  {
  echo "&Auml;nderung GESAMTSALDO_AT  durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);

mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Verwaltungssatz Salden berechnen - Ende: ".$heute;

?>
</body>    
</html>
