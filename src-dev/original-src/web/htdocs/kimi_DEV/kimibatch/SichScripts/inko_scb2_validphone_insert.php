<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>INKO SCB2_SPEZIAL:VALID PHONE INSERT </title>
        <style type ="text/css">
            .sucess,.error {
                margin-top:1em;
                margin-bottom:1em;
                padding-left: 1em;
                border:1px solid #060;
                border-left-width:10px;
                background-color:#FFC;
            }
            .error{
                border-color:#900;
                color:#900;
                pont-weight:bold;
            }
            b {
                 color:#090;
            }
        </style>
    </head>
    <body>
        <h1>KIMI-Plus -  INKOSCB2_SPEZIAL -INSERT :VALIDPHONE_BATCH</h1>
        <?php
        $heute = date("d.m.Y H:i:s"); 
        include ("db.php");
        echo "<br>";
        echo "<br>";
        echo "INKOSCB2_SPEZIAL VALIDPHONE INSERT START:".$heute ;
        echo "<br>";
        echo "<br>";
        
        $insert_inkoSan_validphone_batch = "
-- INKOSCB2_SPEZIAL
    insert into validphone_batch
            (
            mandant_id,
            ticket_id,
            kampagne_id,
            telefon_nr,
            telefon_nr_ursprung,
            status,
            zeitpunkt_erstellung,
            zeitpunkt_uebermittlung,
            zeitpunkt_rueckmeldung,
            ergebnis,
            ergebnis_code,
            ergebnis_text,
            mandant_text,
            kunde_text,
            ticket_nr)
            select mandant_id,ticket.id,13,replace(ticket.telefon,' ',''),'telefon1',0,now(),null,null,null,null,null,'INKOSCB2_SPEZIAL',null,ticketnr
from ticket where mandant_id =21 and status_id =85 and beginn >= '20170821' /* 40 */ and telefon != ''
and substr(telefon,1,6) in ('+43663','+43664','+43688','+43660','+43678','+43699','+43650','+43676','+43681','+43680')
and ticketnr > 882

            union
            select mandant_id,ticket.id,13,replace(ticket.telefon2,' ',''),'telefon2',0,now(),null,null,null,null,null,'INKOSCB2_SPEZIAL',null,ticketnr

from ticket where mandant_id =21 and status_id =85  and beginn >= '20170821'/* 40 */ and telefon2 != ''
and substr(telefon2,1,6) in ('+43663','+43664','+43688','+43660','+43678','+43699','+43650','+43676','+43681','+43680')
and ticketnr > 882





";
               
        $result = mysql_query($insert_inkoSan_validphone_batch);
         if (!$result) {
    
     $msg = $msg.'<p class = "error"> Query: INSERT INTO validphone_batch  Error:' .mysql_error().'</p>';
        }
     else {
        $msg =$msg.'<p class = "sucess"> INKOSCB2_SPEZIAL: INSERT INTO validphone_batch Sucessful</p>';
     }

     
   $query_result = "select * from validphone_batch where zeitpunkt_erstellung >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) and  mandant_id = 21 ";
   $result1 = mysql_query($query_result);
   
   
   if (mysql_num_rows($result1) > 0) {
                   
                   
                   $msg =  $msg.'<p class = "sucess"><b>'. mysql_num_rows($result1) .'</b>::Datensätze eingespielt</p>';
                 
       } 
    else {
           $msg =$msg.'<p class = "error"><b>Keine Datensätze eingespielt</b></p>';
        }    
        ?>
    <?php
        echo $msg ;
   ?>
    <?php
    echo '<br>';
    echo '<br>';
    $heute1 = date("d.m.Y H:i:s"); 
    echo "INKOSCB2_SPEZIAL VALIDPHONE INSERT  - ENDE:".$heute1 ;
    ?>
    </body>
</html>
