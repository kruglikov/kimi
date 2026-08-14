<html>
  <head>
     <title>KIMI-Plus - Inkasso-Kontoauszug</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Inkasso-Kontoauszug</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Inkasso-Kontoauszug - Start: ".$heute."<br><br><br>";
// Abfrage Kontoauszugsdaten
$query = "select 
'1' sort,
cAST(s.ktonr as char) stammkundennummer,
null,
CONCAT(k.vorname,' ', k.nachname) name_buchdat,
CONCAT( k.strasse,' ', CAST(k.hausnummer AS CHAR), IFNULL(k.hausnummer_erw,'')) strasse_buchtext,
concat(k.plz,' ' , k.ort) plz_ort_belegdat,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') saldo_betrag,
REPLACE(CAST(IFNULL(s.betrag_l_auslagerung,0) AS CHAR), '.', ',') auslagsaldo_lieferungen,
NULL zahlungen,
NULL retouren,
NULL sonstige_buchungen,
NULL storno
from stammdaten s
join kunde k on k.id = s.kunde_id
join buchungen b on b.stammdaten_id = s.id
left join anrede anr on anr.id = k.anrede_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
where s.ktonr in (83591792 )
union
select 
'2' sort,
cast(b.stammdaten_id  as char) stammkundennummer,
b.buchungsdatum , /* f�r Sort */
DATE_FORMAT(b.buchungsdatum, '%d.%c.%Y') buch_dat,
case
when IFNULL(b.auftragsnummer,'leer') = 'leer' then bugr.text
else b.auftragsnummer
end  rechng_nr,
DATE_FORMAT(b.valutadatum, '%d.%c.%Y') beleg_dat,
REPLACE(CAST(IFNULL(case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end,0) AS CHAR), '.', ',') betrag,
REPLACE(CAST(IFNULL(case
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 01 and 10 then
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end  
else 0 
end,0) AS CHAR), '.', ',') lieferungen,
REPLACE(CAST(IFNULL(case
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 20 and 27 then
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end  
else 0 
end ,0) AS CHAR), '.', ',') zahlungen,
REPLACE(CAST(IFNULL(case
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 11 and 19 then
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end  
else 0 
end,0) AS CHAR), '.', ',') retouren,
REPLACE(CAST(IFNULL(case
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 01 and 10 then 0
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 11 and 19 then 0
when substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) between 20 and 27 then 0
else 
case 
 when IFNULL(bugr.kz_saldowirksam,'N') = 'N' then ABS(IFNULL(b.betrag,0))
 when bugr.kz_berechnung = 'M' and b.buchungskennzeichen= 1 then ABS(IFNULL(b.betrag,0)) *-1
 when bugr.kz_berechnung = 'P' and b.buchungskennzeichen= 0 then ABS(IFNULL(b.betrag,0)) *-1
 when IFNULL(b.kz_gebucht,'N') = 'N' then 0 
 else ABS(IFNULL(b.betrag,0))
 end  
end,0) AS CHAR), '.', ',') sonstige,
case 
 when b.buchungskennzeichen= 1 then '*'
 else ''
end storno
from stammdaten s
join kunde k on k.id = s.kunde_id
join buchungen b on b.stammdaten_id = s.id
left join anrede anr on anr.id = k.anrede_id
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
where s.ktonr in (83591792	 )
and IFNULL(b.kz_gebucht,'N') = 'J' 
order by 2,1,3
";
$result = mysql_query($query);
$kdnr = 0;
$count_kto = 0;
$count_buch = 0;
$sum_lieferungen = 0;
$sum_zahlungen = 0;
$sum_retouren = 0;
$sum_sonstige = 0;
$sum_betrag = 0;
//
// 
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
if ($line['stammkundennummer'] > $kdnr)     {
    //echo $kdnr."Gruppenwechsel".$line['ktonr'];
    // wenn erster Gruppenwechsel Summen und Endzeile ausgeben
    if (($kdnr > 0 ) and $count_kto > 0)  {
    echo "<br>Summen;".$sum_lieferungen.";".$sum_zahlungen.";".$sum_retouren.";".$sum_sonstige.";".$sum_betrag.";;;;";
    echo "<br>Saldo alt:;".$saldo_alt.";Saldo neu;".$saldo_neu.";;;;;";  
    // ENDEZeile - LEER ausgeben
    $drucksatz= "<br>".';;;;;;;;;';    
    echo $drucksatz;
    }
    // Gruppenwechselfeld und Z�hler
    $kdnr = $line['stammkundennummer'];
    $count_kto++;
    // Zeile 1 - ausgeben
    $drucksatz = $line['name_buchdat'].";;;;;;Stammkundennummer".";;;";
    echo "<br>".$drucksatz;    
    // Zeile 2 - ausgeben    
    $drucksatz = $line['strasse_buchtext'].";;;;;;".$line['stammkundennummer'].";;;";
    echo "<br>".$drucksatz;  
    // Zeile 3 - ausgeben    
    $drucksatz = $line['plz_ort_belegdat'].";;;;;;;;;";
    echo "<br>".$drucksatz;    
    // Zeile 4 - LEER ausgeben
    $drucksatz= "<br>".';;;;;;;;';
    echo $drucksatz;
    // Zeile 5 - ausgeben
    $drucksatz= "<br>".'Kontoauszug;vom;'.$heute = date("d.m.Y").';;;;;;;';
    echo $drucksatz;
    // Zeile 6 - LEER ausgeben
    $drucksatz= "<br>".';;;;;;;;;';
    echo $drucksatz;
    // Zeile 7 - ausgeben -  Splaten�berschriften
    $drucksatz= 'BUCH.DAT;LIEFERUNGEN;ZAHLUNGEN;REOTUREN;SONST.BUCHG;RECHNR.NR;BELEG.DAT;BETRAG;STORNO';
    echo "<br>".$drucksatz;
    // Salden vom ersten Satz merken
    $saldo_neu = $line['saldo_betrag'];
    $saldo_alt = $line['auslagsaldo_lieferungen'];
    // Summen zur�cksetzen !!
    $sum_lieferungen = 0;
    $sum_zahlungen = 0;
    $sum_retouren = 0;
    $sum_sonstige = 0;
    $sum_betrag = 0;
} else {
$count_buch++;
$drucksatz= $line['name_buchdat'].";".$line['auslagsaldo_lieferungen'].";".$line['zahlungen'].";".$line['retouren'].";".$line['sonstige_buchungen'].";".$line['strasse_buchtext'].";".$line['plz_ort_belegdat'].";".$line['saldo_betrag'].";".$line['storno'].";";
echo "<br>".$drucksatz;
$sum_lieferungen =  $sum_lieferungen + $line['auslagsaldo_lieferungen'];
$sum_lieferungen =  $sum_lieferungen + $line['zahlungen'];
$sum_retouren =  $sum_retouren + $line['retouren'];
$sum_sonstige =  $sum_sonstige + $line['sonstige_buchungen'];
$sum_betrag =  $sum_betrag + $line['saldo_betrag'];
}
 ?>
 <?PHP 
}
// Letzten Satz ausgeben
if ($kdnr > 0 )  {
  echo "<br>Summen;".$sum_lieferungen.";".$sum_zahlungen.";".$sum_retouren.";".$sum_sonstige.";;;".$sum_betrag.";;";
  echo "<br>Saldo alt:;".$saldo_alt.";Saldo neu;".$saldo_neu.";;;;;";  
  echo "<br>*) bedeutet Storno;;;;;";
}

echo "<br><br>Kontoausz�ge ".$count_kto;
echo "<br>Kontoausz�geBuchungeszeilen ".$count_buch;

mysql_free_result($result);

mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br><br>"."Inkasso-Kontoauszug - Ende: ".$heute;

?>
</body>    
</html>
