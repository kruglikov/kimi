<html>
  <head>
     <title>KIMI-Plus - Inkasso-Saldoaufstellung</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Inkasso-Saldoaufstellung</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Inkasso-Saldoaufstellung - Start: ".$heute."<br><br><br>";
// Abfrage Kontoauszugsdaten
$query = "select '1',
cast(s.ktonr as char) ktonr,
CONCAT(k.vorname,' ', k.nachname ) name,
null eroeffnet_am,
null kaufwert,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') gesamtsaldo,
case
when IFNULL(s.krsv,9) = 9 then 'Nein'
else 'Ja'
end versicherung
from stammdaten s 
join kunde k on k.id = s.kunde_id
where s.ktonr in (SELECT ktonr FROM saldoaufstellung)
union
select '2',
cast(sk.stammdaten_id as char) stammdaten_id,
sk.rechnungsnummer,
DATE_FORMAT(sk.eroeffnet_am, '%d.%c.%Y') eroeffnet_am,
REPLACE(CAST(IFNULL(sk.kaufwert,0) AS CHAR), '.', ',') kaufwert,
REPLACE(CAST(IFNULL(sk.saldo,0) AS CHAR), '.', ',') saldo,
null
 From subkonto_neu sk
where sk.stammdaten_id in (SELECT ktonr FROM saldoaufstellung)
and sk.kz_aktuell = 'J'
order by 2,1,4
";
$result = mysql_query($query);
$kdnr = 0;
$count_kto = 0;
$count_subkto = 0;
$gesamtsaldo = 0;
//
// 
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
if ($line['ktonr'] > $kdnr)     {
    //echo $kdnr."Gruppenwechsel".$line[ktonr];
    // wenn erster Gruppenwechsel Summen und Endzeile ausgeben
    if (($kdnr > 0 ) and $count_kto > 0)  {
    echo "<br>;;offener Gesamtbetrag;".$gesamtsaldo.";";
    echo "<br>Versicherung;".$versicherung.";;";  
    echo "<br>;;;";        
    echo "<br>*) Hierbei handelt es sich um ein laufendes Rateneinkaufskonto.";
    echo "<br> Die Zahlungswidmung erfolgt immer auf die &auml;lteste Forderung";  
    echo "<br>**) Saldo-Kauf beinhaltet Kapital, Zinsen und beim &Auml;ltesten Subkonto";
    echo "<br> zus&auml;tzlich Mahnkosten und gegebenenfalls Versicherungsgeb&uuml;hren";  
    
    // ENDEZeile - LEER ausgeben
    $drucksatz= "<br>".';;;;';    
    echo $drucksatz;
    }
    // Gruppenwechselfeld und Z�hler
    $kdnr = $line['ktonr'];
    $count_kto++;
    // Zeile 1 - ausgeben
    $drucksatz = "SALDOAUFSTELLUNG *);;erstellt am;".$heute = date("d.m.Y").";";;
    echo "<br>".$drucksatz;    
    // Zeile 2 - LEER ausgeben    
    $drucksatz = ";;;;";
    echo "<br>".$drucksatz;    
    // Zeile 3 - ausgeben    
    $drucksatz = $line['name'].";;Kundenkonto;".$line['ktonr'].";";
    echo "<br>".$drucksatz;  
    // Zeile 4 - LEER ausgeben
    $drucksatz= "<br>".';;;;;;;;';
    // Zeile 5 - ausgeben -  Spalten�berschriften
    $drucksatz= 'Rechnungen;Datum;Rechnungsbetrag;Saldo Kauf **)';
    echo "<br>".$drucksatz;
    // Salden vom ersten Satz merken
    $gesamtsaldo = $line['gesamtsaldo'];
    $versicherung = $line['versicherung'];    
} else {
$count_subkto++;
$drucksatz= $line['name'].";".$line['eroeffnet_am'].";".$line['kaufwert'].";".$line['gesamtsaldo'].";";
echo "<br>".$drucksatz;
}
 ?>
 <?PHP 
}
// Letzten Satz ausgeben
if ($kdnr > 0 )  {
  echo "<br>;;offener Gesamtbetrag;".$gesamtsaldo.";";
  echo "<br>Versicherung;".$versicherung.";;;";  
  echo "<br>;;;";    
  echo "<br>*) Hierbei handelt es sich um ein laufendes Rateneinkaufskonto.";
  echo "<br> Die Zahlungswidmung erfolgt immer auf die &auml;lteste Forderung";  
  echo "<br>**) Saldo-Kauf beinhaltet Kapital, Zinsen und beim &Auml;ltesten Subkonto";
  echo "<br> zus&auml;tzlich Mahnkosten und gegebenenfalls Versicherungsgeb&uuml;hren";  

}

echo "<br><br>Saldoaufstellungen ".$count_kto;
echo "<br>SaldoaufstellungSubkonten ".$count_subkto;

mysql_free_result($result);

mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br><br>"."Inkasso-Saldoaufstellung - Ende: ".$heute;

?>
</body>    
</html>
