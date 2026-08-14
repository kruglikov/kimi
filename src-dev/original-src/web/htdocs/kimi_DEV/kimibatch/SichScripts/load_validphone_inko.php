<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>INKO VALID PHONE LOAD</title>
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
   <h1>KIMI-Plus -  INKO VALIDPHONE IMPORT</h1>
        <?php
        include 'db.php';
        $heute = date("d.m.Y H:i:s");
echo "INKO VALID PHONE IMPORT - START:".$heute ;
echo '<br>';
echo '<br>';
$msg = "";
/* Datenbank Verbindung Prüfung
if (mysql_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysql_connect_error();
  }
 else {
      echo"sucessful :-)"  ;
       }*/


//query

$inko_validphone="LOAD DATA LOCAL INFILE 'files/validphoneINKO.txt' INTO TABLE validphone CHARACTER SET 'latin1' FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\\\' LINES TERMINATED BY '\r\n' (text,mandant,ticket, ticketnr, telefon, ergebnis,@import)
SET import = now()";
$result = mysql_query($inko_validphone);
$query_result = "select *from validphone
where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) and  mandant like '%inko%'";
$result1 = mysql_query($query_result);

if (!$result) {
    
     $msg = "Query Error:".mysql_error();
}
/*else
{
    $msg = '<p class = "sucess">querry sucessful</p>';
}*/
if (mysql_num_rows($result1) > 0) {
                   
                   $msg =  $msg.'<p class = "sucess">INKO IMPORT SUCCESFUL. </p>';
                   $msg =  $msg.'<p class = "sucess"><b>'. mysql_num_rows($result1) .'</b>::Datensätze eingespielt</p>';
                 
} 
else {
            echo '<p class = "error"><b>Keine Datensätze eingespielt</b></p>';
        }     


echo '<br>';
echo $msg;


   

    ?>
   <?php
    echo '<br>';
    echo '<br>';
    echo "INKO VALID PHONE IMPORT - ENDE:".$heute ;
    ?>
    </body>
</html>


