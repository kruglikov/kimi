<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>INKO DE:VALID PHONE INSERT </title>
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
        <h1>KIMI-Plus -  INKODE-INSERT :VALIDPHONE_BATCH</h1>
        <?php
         $heute = date("d.m.Y H:i:s");
        include ("db.php");
        echo "<br>";
        echo "<br>";
        echo "INKODE VALIDPHONE INSERT START:".$heute ;
        echo "<br>";
        echo "<br>";
        
        $insert_inkoDe_validphone_batch = "
            -- inkode 
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
            select mandant_id,ticket.id,16,concat('49',replace(ticket.telefon,' ','')),'telefon1',0,now(),null,null,null,null,null,'INKODE',null,ticketnr
            from ticket where mandant_id =24 and status_id =104 and beginn = curdate() and telefon != ''
            and ( 
            substr(telefon,1,4) in ('1511','1512','1514','1515','1516','1517','1520','1522','1523','1525','1573','1575','1577','1578')
            or
            substr(telefon,1,3) in ('160','170','171','175','162','172','173','174','163','177','178','176','179')
            )
            union
            select mandant_id,ticket.id,16,concat('49',replace(ticket.telefon2,' ','')),'telefon2',0,now(),null,null,null,null,null,'INKODE',null,ticketnr
            from ticket where mandant_id =24 and status_id =104 and beginn = curdate() and telefon2 != ''
            and ( 
            substr(telefon2,1,4) in ('1511','1512','1514','1515','1516','1517','1520','1522','1523','1525','1573','1575','1577','1578')
            or
            substr(telefon2,1,3) in ('160','170','171','175','162','172','173','174','163','177','178','176','179')
            )



            ";
               
        $result = mysql_query($insert_inkoDe_validphone_batch);
         if (!$result) {
    
     $msg =$msg.'<p class = "error"> Query: INSERT INTO validphone_batch  Error:' .mysql_error().'</p>';
        }
     else {
        $msg =$msg.'<p class = "sucess"> INKODE: INSERT INTO validphone_batch Sucessful</p>';
     }

     $query_result = "select * from  validphone_batch where zeitpunkt_erstellung >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) and  mandant_id = 24 ";
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
    echo "INKODE VALIDPHONE INSERT  - ENDE:".$heute1 ;
    ?>
    </body>
</html>
