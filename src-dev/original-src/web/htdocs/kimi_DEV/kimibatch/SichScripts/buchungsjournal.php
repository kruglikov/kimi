<html>
  <head>
     <title>KIMI-Plus - Buchungsjournal</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Buchungsjournal</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Buchungsjournal - Start: ".$heute;
// Abfrage Kontoauszugsdaten
$query = "select m.mandant,k.markt,k.kdnr,
DATE_FORMAT(b.buchungsdatum, '%Y-%c-%d') buchungsdatum,
DATE_FORMAT(b.valutadatum, '%Y-%c-%d') valutadatum,
substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) ba,
substring(cast(bugr.bugru_key as CHAR) FROM -2 FOR 2) bg,
REPLACE(CAST(IFNULL(b.betrag,0) AS CHAR), '.', ',') betrag ,
mw.mwst_key mwst_key,
mw.mwst_proz,
REPLACE(CAST(IFNULL(b.mwst_20,0) AS CHAR), '.', ',') mwst_20 ,
REPLACE(CAST(IFNULL(b.mwst_0,0) AS CHAR), '.', ',') mwst_0 ,
REPLACE(CAST(IFNULL(b.mwst_10,0) AS CHAR), '.', ',') mwst_10 ,
case
when b.buchungskennzeichen = 1 then 'S'
else '0'
end buchungskennzeichen,
bugr.kz_berechnung,
REPLACE(CAST(IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0)) 
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen = 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0) AS CHAR), '.', ',') lastschrift,
REPLACE(CAST(IFNULL(case 
  when IFNULL(bugr.kz_saldowirksam,'N') = 'N'  then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'J' and bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0))
  when IFNULL(b.kz_gebucht,'N') = 'N' then 0   
 else 0
 end,0) AS CHAR), '.', ',') gutschrift ,
bugr.text,
verwendungszweck,
b.herkunft,
b.geaendert_von
from buchungen b
join stammdaten s on s.id = b.stammdaten_id
join kunde k on k.id = s.kunde_id
join mandant m on m.id = k.mandant_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
left join mwst mw on mw.id = b.mwst_id
where IFNULL(b.kz_gebucht,'N') = 'J'
and b.buchungsdatum in (select DATE_ADD(vw.buchungsdatum,INTERVAL -0 DAY) from verwaltungssatz vw where vw.kz_aktuell = 'J')
and substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) not between 20 and 27
";
$result = mysql_query($query);
//Spalten�berschrift //
$drucksatz='Mandant;markt;kdnr;buchungsdatum;valutadatum;ba;bg;betrag;mwst_key;mwst_proz;mwst20;mwst_0;mwst_10;buchungskennzeichen;kz_berechnung;lastschrift;gutschrift;text;verwendungszweck;herkunft;geaendert_von;';
echo "<br>".$drucksatz;
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['mandant'].";".$line['markt'].";".$line['kdnr'].";".$line['buchungsdatum'].";".$line['valutadatum'].";".$line['ba'].";".$line['bg'].";".$line['betrag'].";".$line['mwst_key'].";".$line['mwst_proz'].";".$line['mwst_20'].";".$line['mwst_0'].";".$line['mwst_10'].";".$line['buchungskennzeichen'].";".$line['kz_berechnung'].";".$line['lastschrift'].";".$line['gutschrift'].";".$line['text'].";".$line['verwendungszweck'].";".$line['herkunft'].";".$line['geaendert_von'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Buchungssjournal - Ende: ".$heute;

?>

</body>    
</html>
