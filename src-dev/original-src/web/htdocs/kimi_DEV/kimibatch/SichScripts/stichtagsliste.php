<html>
  <head>
     <title>KIMI-Plus - Stichtags-Liste</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtags-Liste</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Stichtags-Liste - Start: ".$heute;

$query = "select 'kundennummer', 'stichtag','gesamtsaldo','mahnstufe','inkassostatus','inkassostatustext',
'dat_l_kontoauszug','betrag_l_kontoauszug','dat_l_zahlung',
'mahnsperre','mahnsperre_datum','stundung','krsv','lastschrift',
'kz_verarbeitet' , 'xxsp'
union
select CAST(s.ktonr as CHAR) kundennummer,
DATE_FORMAT(st.stichtag, '%Y-%c-%d') stichtag,
REPLACE(CAST(IFNULL(st.gesamtsaldo,0) AS CHAR), '.', ',')  gesamtsaldo,
cast(st.mahnstufe as CHAR) mahnstufe,
cast(st.inkassostatus_id as char) inkassostatus,
text inkassostatustext,
DATE_FORMAT(st.dat_l_kontoauszug, '%Y-%c-%d') dat_l_kontoauszug,
REPLACE(CAST(IFNULL(st.betrag_l_kontoauszug,0) AS CHAR), '.', ',')betrag_l_kontoauszug,
DATE_FORMAT(st.dat_l_zahlung, '%Y-%c-%d') dat_l_zahlung,
s.mahnsperre mahnsperre,
DATE_FORMAT(s.mahnsperre_datum, '%Y-%c-%d') mahnsperre_datum,
case
when s.kto_kenner like '%ST%' then 'ST=JA'
else 'NEIN'
end stundung,
s.krsv,
s.lastschrift,
st.kz_verarbeitet,
case
when k.kenner like '%XX%' AND k.kenner like '%SP%' then 'XX und SP=JA'
else 'NEIN'
end xxsp
from stichtag st
join stammdaten s on s.id = st.stammdaten_id
join kunde k on k.id = s.id
where IFNULL(st.kz_verarbeitet,NULL) is NULL
";

$filename = "files/stichtagsliste".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
//
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kundennummer'].';'.$line['stichtag'].';'.$line['gesamtsaldo'].';'.$line['mahnstufe'].';'.$line['inkassostatus'].';'.$line['inkassostatustext'].';'.$line['dat_l_kontoauszug'].';'.$line['betrag_l_kontoauszug'].';'.$line['dat_l_zahlung'].';'.$line['mahnsperre'].';'.$line['mahnsperre_datum'].';'.$line['stundung'].';'.$line['krsv'].';'.$line['lastschrift'].';'.$line['xxsp'].';'."\n"; 
        // being transformed into a newline
        fwrite($fp, $string); // will proccess /n as newline ... 

}
fclose($fp);
$file = $filename;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Stichtags-Liste - Ende: ".$heute;

?>
</body>    
</html>
