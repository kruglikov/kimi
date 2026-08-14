
<html>
    <head>
        <meta charset="UTF-8">
        <title>VALID PHONE EXPORT</title>
    </head>
    <body> 
     
        <?php
        include 'db.php';
        $heute = date("Y-m-d H:i:s");
        echo "VALIDPHONE  EXPORT - START:".$heute ;
        
      // select Auswertung
        $query ="select 

'anruf_Status', 'Mandant_Id', 'Mandant', 'Mandant_wert','Ticket','TicketNr', 'Telefon','Ergebnis','import'
union all

select -- OKO


CASE
WHEN anruf_status.text is null THEN 'offen'
else anruf_status.text END text,
ticket.mandant_id,
validphone.* 
from validphone
join ticket on ticket.ticketnr = validphone.ticketnr and  (ticket.mandant_id = 16 and  validphone.mandant = 'OKO')
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id

union all

select -- INKODE


CASE
WHEN anruf_status.text is null THEN 'offen'
else anruf_status.text END text,
ticket.mandant_id,
validphone.*
from validphone
join ticket on ticket.ticketnr = validphone.ticketnr    and  (ticket.mandant_id =24 and validphone.mandant = 'INKODE')
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id

union all

select -- INKOSAN


CASE
WHEN anruf_status.text is null THEN 'offen'
else anruf_status.text END text,
ticket.mandant_id,
validphone.*
from validphone
join ticket on ticket.ticketnr = validphone.ticketnr     and  (ticket.mandant_id =12 and validphone.mandant = 'INKOSAN')
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id

union all

select -- INKO2016


CASE
WHEN anruf_status.text is null THEN 'offen'
else anruf_status.text END text,
ticket.mandant_id,
validphone.*
from validphone
join ticket on ticket.ticketnr = validphone.ticketnr    and  (ticket.mandant_id =18 and validphone.mandant = 'INKO2016' )
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id";
    
// query Prüfung
        if (!$result = mysql_query($query)) {
            echo('Invalid query: ' . mysql_error());
            }  
        else {
            echo 'sucessful query';    
        }
            //filename 
            $filname = $filename ="files/validphone_exp".date("YmdH").".csv";
            $fp = fopen($filename,"w");
          while ($line = mysql_fetch_array($result)){ 
          
             $string = $line['anruf_Status'].";".$line['Mandant_Id'].";".$line['Mandant'].";".$line['Mandant_wert'].";".$line['Ticket'].";".$line['TicketNr'].";".$line[ 'Telefon'].";".$line['Ergebnis'].";";
             $string = $string.";"."\n";
        // being transformed into a newline
       fwrite($fp, $string);
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
                
            
        ?>
        <?php
        $heute1 = date("d.m.Y H:i:s");    
        echo "<br><br>"."VALIDPHONE  EXPORT - Ende: ".$heute1;
        ?>
    </body>
</html>