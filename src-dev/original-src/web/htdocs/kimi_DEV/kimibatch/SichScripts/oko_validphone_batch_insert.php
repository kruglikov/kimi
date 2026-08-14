<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>OKO:VALID PHONE INSERT </title>
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
        <h1>KIMI-Plus -  OKO-INSERT :VALIDPHONE_BATCH</h1>
        <?php
         $heute = date("d.m.Y H:i:s");
        include ("db.php");
        echo "<br>";
        echo "<br>";
   
        echo "OKO VALIDPHONE INSERT START:".$heute ;
        echo "<br>";
        echo "<br>";
        
        $insert_oko_validphone_batch = "
            -- OKO

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
            select mandant_id,ticket.id,8,
            concat('43',replace(replace(replace(
            CASE 
              WHEN locate(' ',telefon)>0 THEN substring(telefon,1,locate(' ',telefon))
              ELSE  telefon
            END
            ,'LT.',''),'/',''),' ','')),
            'telefon2',0,now(),null,null,null,null,null,'OKO',null,ticketnr  
            from ticket where mandant_id =16 and status_id =58 and beginn = curdate() /* 58 */ and telefon != ''
            and substr(telefon,1,3) in ('663','664','688','660','678','699','650','676','681','680')
            union
            select mandant_id,ticket.id,8,
            concat('43',replace(replace(replace(
            CASE 
              WHEN locate(' ',telefon2)>0 THEN substring(telefon2,1,locate(' ',telefon2))
              ELSE  telefon2
            END
            ,'LT.',''),'/',''),' ','')),
            'telefon2',0,now(),null,null,null,null,null,'INKODE',null,ticketnr
            from ticket where mandant_id =16 and status_id =58 and beginn = curdate() /* 58 */ and telefon2 != ''
            and substr(telefon2,1,3) in ('663','664','688','660','678','699','650','676','681','680')

        ";
               
            $result = mysql_query($insert_oko_validphone_batch);
             if (!$result) {

                $msg =$msg.  '<p class = "error"> Query: INSERT INTO validphone_batch  Error:' .mysql_error().'</p>';
                }
            else {
            $msg = $msg.'<p class = "sucess"> OKO: INSERT INTO validphone_batch Sucessful</p>';
            }

     
            // Getting the total number of records inserted
            $query_result = "select * from validphone_batch where zeitpunkt_erstellung >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) and  mandant_id = 16 ";
            $result1 = mysql_query($query_result);

   
             if (mysql_num_rows($result1) > 0) {
                   
                   
                   $msg =  $msg.'<p class = "sucess"><b>'. mysql_num_rows($result1) .'</b>::Datensätze eingespielt</p>';
                 
                    } 
                    
            else {
            $msg = $msg.'<p class = "error"><b>Keine Datensätze eingespielt</b></p>';
        }            
        ?>
    <?php
        echo $msg ;
   ?>
    <?php
    echo '<br>';
    echo '<br>';
    $heute1 = date("d.m.Y H:i:s"); 
    echo "OKO VALIDPHONE INSERT  - ENDE:".$heute1 ;
    ?>
    </body>
</html>
