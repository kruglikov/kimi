<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>INKO 2016:VALID PHONE INSERT </title>
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
        <h1>KIMI-Plus -  INKO2016 - INSERT :VALIDPHONE_BATCH</h1>
        <?php
        $heute = date("d.m.Y H:i:s");
        include ("db.php");
        echo "<br>";
        echo "<br>";
        echo "INKO2016 VALIDPHONE INSERT START:".$heute ;
        echo "<br>";
        echo "<br>";
        
        $insert_inko2016_validphone_batch = "
        -- inko2016

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
             select mandant_id,ticket.id,10,concat('43',replace(ticket.telefon,' ','')),'telefon1',0,now(),null,null,null,null,null,'INKO2016',null,ticketnr
             from ticket where mandant_id =18 and status_id =66 and beginn = curdate()/* 66 */ and telefon != ''
             and substr(telefon,1,3) in ('663','664','688','660','678','699','650','676','681','680')
             union
             select mandant_id,ticket.id,10,concat('43',replace(ticket.telefon2,' ','')),'telefon2',0,now(),null,null,null,null,null,'INKO2016',null,ticketnr
             from ticket where mandant_id =18 and status_id =66 and beginn = curdate()/* 66 */ and telefon2 != ''
             and substr(telefon2,1,3) in ('663','664','688','660','678','699','650','676','681','680')


        ";
               
        $result = mysql_query($insert_inko2016_validphone_batch);
         if (!$result) {
    
     $msg =$msg.'<p class = "error"> Query: INSERT INTO validphone_batch  Error:' .mysql_error().'</p>';
        }
     else {
        $msg =$msg.'<p class = "sucess"> Inko 2016: INSERT INTO validphone_batch Sucessful</p>';
     }

     // Getting the total number of records inserted
     $query_result = "select * from validphone_batch where zeitpunkt_erstellung >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) and  mandant_id = 18 ";
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
    echo "INKO2016 VALIDPHONE INSERT  - ENDE:".$heute1 ;
    ?>
    </body>
</html>
