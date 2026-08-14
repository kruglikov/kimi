<html>
  <head>
     <title>KIMI-Plus - Lastschrift</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Lastschrift</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Lastschrift - Start: ".$heute;
// Abfrage Lastschriften
$query_lastschrift = "select s.ktonr,
case 
when IFNULL(s.gesamtsaldo,0) > IFNULL(s.ratenhoehe,0) then IFNULL(s.ratenhoehe,0)
else IFNULL(s.gesamtsaldo,0)
end einziehbetrag,
s.lastschrift,l.kz_lastschrift,l.sepa_einzug_sequenz, l.iban,b.bic ,
 DATE_FORMAT(l.dat_unterschrift, '%Y-%m-%d') dat_unterschrift,
CONCAT(k.vorname, ' ', k.nachname) name,
lpad(s.ktonr,12,'0') ktonr12stellen,
case 
when l.sepa_einzug_sequenz = 'FRST' then  
(select ADDDATE(vw.buchungsdatum, INTERVAL +5 DAY)  from verwaltungssatz vw
where kz_aktuell = 'J' and markt =  10)
else
(select ADDDATE(vw.buchungsdatum, INTERVAL +2 DAY)  from verwaltungssatz vw
where kz_aktuell = 'J' and markt =  10)
end budat_frst_rcur
from stichtag st
join stammdaten s on s.id = st.stammdaten_id
join lastschrift l on l.stammdaten_id = s.id
join kunde k on k.id = s.kunde_id
join bankleitzahl b on b.id = l.bankleitzahl_id
where st.kz_verarbeitet in ( 'I' , 'G')
and (
case  when  IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
      when  IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
      when  IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
       else null
      end ) ='J'
and (case  when  IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
      when  IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
      when  IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
       else null
      end ) = s.lastschrift
order by l.sepa_einzug_sequenz,s.ktonr
";
$result = mysql_query($query_lastschrift);
$sepa_einzug_sequenz = '';
$count = 0;
// XML-Struktur
$version = '';
$header = '';
$einzug = '';
$footer = '';
//
$version='<br>§?xml version="1.0" encoding="UTF-8"?!
<br>§Document xmlns="APC:STUZZA:payments:ISO:pain:008:001:01:austrian:002" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"!
<br>__§pain.008.001.01!
';
// Gruppenheader
$vs_firma_iban = 'AT113400000001143700';
$anzahl_konten = 0;
$systemdatum= date("dmYHis");   
$erstelldatum =  date("Y-m-d")."T".date("H:i:s");   
$erstelldatum2 =  date("Ymd").date("His").'00';   
$summe_betrag = 0;
$id = date("Ymd").date("Hisu");   
$einzug = '';
$sepa_einzug_sequenz = '';
//
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
  if   ($line['sepa_einzug_sequenz'] <> $sepa_einzug_sequenz)
    {
    //echo "<br>Gruppenwechsel_Sequence".$line['sepa_einzug_sequenz'];
    $sepa_einzug_sequenz = $line['sepa_einzug_sequenz'];    
    // wenn Wechsel von FRST auf RCUR "PmtInf" abschliessen
    if (empty($einzug)==FALSE) {
      $einzug = $einzug .= '<br>____§/PmtInf!';
    }
    //  
    if ($line['sepa_einzug_sequenz'] != 'FRST' )
    {
      $budat_sequenz = $line['budat_frst_rcur'];
    } else {
      $budat_sequenz = $line['budat_rcur_rcur'];
    }
    //    
    $einzug = $einzug .= '<br>____§PmtInf!';
    $einzug = $einzug .= '<br>______§PmtInfId!'.$erstelldatum2.'§/PmtInfId!';
    $einzug = $einzug .= '<br>______§PmtMtd!DD§/PmtMtd!';
    $einzug = $einzug .= '<br>______§PmtTpInf!';
    $einzug = $einzug .= '<br>________§SvcLvl!';
    $einzug = $einzug .= '<br>__________§Cd>SEPA§/Cd!';
    $einzug = $einzug .= '<br>________§/SvcLvl!';
    $einzug = $einzug .= '<br>________§LclInstrm!';
    $einzug = $einzug .= '<br>__________§Cd>CORE§/Cd!';
    $einzug = $einzug .= '<br>________§/LclInstrm!';
    $einzug = $einzug .= '<br>________§SeqTp!'.$line['sepa_einzug_sequenz'].'§/SeqTp!';
    $einzug = $einzug .= '<br>______§/PmtTpInf!';
    $einzug = $einzug .= '<br>______§ReqdColltnDt!'.$budat_sequenz.'§/ReqdColltnDt!';
    $einzug = $einzug .= '<br>______§Cdtr!';
    $einzug = $einzug .= '<br>________§Nm!Infoscore Portfoliomanagement GmbH§/Nm!';
    $einzug = $einzug .= '<br>______§/Cdtr!';
    $einzug = $einzug .= '<br>______§CdtrAcct!';
    $einzug = $einzug .= '<br>________§Id!';
    $einzug = $einzug .= '<br>__________§IBAN!AT113400000001143700§/IBAN!';
    $einzug = $einzug .= '<br>________§/Id!';
    $einzug = $einzug .= '<br>______§/CdtrAcct!';
    $einzug = $einzug .= '<br>______§CdtrAgt!';
    $einzug = $einzug .= '<br>________§FinInstnId!';
    $einzug = $einzug .= '<br>__________§BIC!RZOOAT2L§/BIC!';
    $einzug = $einzug .= '<br>________§/FinInstnId!';
    $einzug = $einzug .= '<br>______§/CdtrAgt!';
  }
  $einzug = $einzug .= '<br>______§DrctDbtTxInf!';
  $einzug = $einzug .= '<br>________§PmtId!';
  $einzug = $einzug .= '<br>__________§EndToEndId!'.$line['ktonr'].'§/EndToEndId!';
  $einzug = $einzug .= '<br>________§/PmtId!';
  $einzug = $einzug .= '<br>________§InstdAmt Ccy="EUR"!'.$line['einziehbetrag'].'§/InstdAmt!';
  $einzug = $einzug .= '<br>________§DrctDbtTx!';
  $einzug = $einzug .= '<br>__________§MndtRltdInf!';
  $einzug = $einzug .= '<br>____________§MndtId!'.$line['ktonr12stellen'].'-'.$line['dat_unterschrift'].'§/MndtId!';
  $einzug = $einzug .= '<br>____________§DtOfSgntr!'.$line['dat_unterschrift'].'§/DtOfSgntr!';
  $einzug = $einzug .= '<br>__________§/MndtRltdInf!';
  $einzug = $einzug .= '<br>__________§CdtrSchmeId!';
  $einzug = $einzug .= '<br>____________§Id!';
  $einzug = $einzug .= '<br>______________§PrvtId!';
  $einzug = $einzug .= '<br>________________§OthrId!';
  $einzug = $einzug .= '<br>__________________§Id!DE28ZZZ00000010426§/Id!';
  $einzug = $einzug .= '<br>__________________§IdTp!SEPA§/IdTp!';
  $einzug = $einzug .= '<br>________________§/OthrId!';
  $einzug = $einzug .= '<br>______________§/PrvtId!';
  $einzug = $einzug .= '<br>____________§/Id!';
  $einzug = $einzug .= '<br>__________§/CdtrSchmeId!';
  $einzug = $einzug .= '<br>________§/DrctDbtTx!';
  $einzug = $einzug .= '<br>________§DbtrAgt!';
  $einzug = $einzug .= '<br>__________§FinInstnId!';
  $einzug = $einzug .= '<br>____________§BIC!'.$line['bic'].'§/BIC!';
  $einzug = $einzug .= '<br>__________§/FinInstnId!';
  $einzug = $einzug .= '<br>________§/DbtrAgt!';
  $einzug = $einzug .= '<br>________§Dbtr!';
  $einzug = $einzug .= '<br>__________§Nm!'.$line['name'].'§/Nm!';
  $einzug = $einzug .= '<br>________§/Dbtr!';
  $einzug = $einzug .= '<br>________§DbtrAcct!';
  $einzug = $einzug .= '<br>__________§Id>';
  $einzug = $einzug .= '<br>____________§IBAN!'.$line['iban'].'§/IBAN!';
  $einzug = $einzug .= '<br>__________§/Id!';
  $einzug = $einzug .= '<br>________§/DbtrAcct!';
  $einzug = $einzug .= '<br>________§RmtInf!';
  $einzug = $einzug .= '<br>__________§Ustrd!'.$line['ktonr'].'§/Ustrd!';
  $einzug = $einzug .= '<br>________§/RmtInf!';
  $einzug = $einzug .= '<br>______§/DrctDbtTxInf!';
  $anzahl_konten++;
  $summe_betrag =  $summe_betrag + $line['einziehbetrag'];
 ?>
 <?PHP 
}
/* letzten Satz ausgeben */
    
// Ausgabe zusammenbauen
$header =  '<br>____§GrpHdr! ';
$header = $header .= '<br>______§MsgId!'.$systemdatum.'§/MsgId!';
$header = $header .= '<br>_____ §CreDtTm!'.$erstelldatum.'§/CreDtTm!';
$header = $header .= '<br>______§NbOfTxs!'.$anzahl_konten.'§/NbOfTxs!';
$header = $header .= '<br>______§CtrlSum!'.$summe_betrag.'§/CtrlSum!';
$header = $header .= '<br>______§Grpg>MIXD§/Grpg!';
$header = $header .= '<br>______§InitgPty!';
$header = $header .= '<br>________§Id!';
$header = $header .= '<br>__________§OrgId!';
$header = $header .= '<br>____________§BkPtyId>AT113400000001143700§/BkPtyId!';
$header = $header .= '<br>__________§/OrgId!';
$header = $header .= '<br>________§/Id!';
$header = $header .= '<br>______§/InitgPty!';
$header = $header .= '<br>____§/GrpHdr!';
$footer = '<br>____§/PmtInf!';
$footer = $footer .= '<br>__§/pain.008.001.01!';
$footer = $footer .= '<br>§/Document!';


echo "<br>".$version.$header.$einzug.$footer;

mysql_free_result($result);

mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Lastschrift - Ende: ".$heute;

?>
</body>    
</html>
