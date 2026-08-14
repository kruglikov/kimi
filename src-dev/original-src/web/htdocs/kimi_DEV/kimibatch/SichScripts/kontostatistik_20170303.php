<html>
  <head>
     <title>KIMI-Plus - Kontostatistik</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Kontostatistik</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Kontostatistik - Start: ".$heute;
// �ndern der Felder DAT_LTZT_ZAHLUNG und BETRAG_LTZT_ZAHLUNG
$aendern = "update stammdaten s
JOIN buchungen b ON s.id = b.stammdaten_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join (select s.id sid,max(b.id) bid
from  stammdaten s
JOIN buchungen b ON s.id = b.stammdaten_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
where IFNULL(b.kz_gebucht,'N') = 'J'
and b.buchungsdatum in (select '2017-03-03' from verwaltungssatz vw where vw.kz_aktuell = 'J')
and substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 20 and 27
group by s.id) buch on buch.sid = s.id and buch.bid = b.id
SET s.dat_l_zahlung = b.buchungsdatum,
s.betrag_l_zahlung = b.betrag
where IFNULL(b.kz_gebucht,'N') = 'J'
and b.buchungsdatum in (select '2017-03-03' from verwaltungssatz vw where vw.kz_aktuell = 'J')
and substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 20 and 27
";
// 
echo "<br><br><b>Update Kontodaten:<br></b>";
if (mysql_query($aendern))
  {
  echo "&Auml;nderung DAT_LTZT_ZAHLUNG und BETRAG_LTZT_ZAHLUNG durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Kontostatistik - Ende: ".$heute;

?>
</body>    
</html>
