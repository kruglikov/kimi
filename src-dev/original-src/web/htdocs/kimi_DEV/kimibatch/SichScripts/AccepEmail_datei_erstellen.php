
<!DOCTYPE html>

<html>
    <head>
        <title>Email und SMS erstellen</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
        <h1> KIMI-PLUS - AcceptEmail -Schnittstelle</h1>
       
   <?php
       $heute = date("d-m-Y H:i:s");
       echo "KIMI-PLUS - AcceptEmail -Schnittstelle - START:". $heute;
       echo('<br>');
       echo('<br>');
       
   $source_file = fopen("files/uebergabedateikimiplus.csv","r");
   $source = file("files/uebergabedateikimiplus.csv");
   //$file_handle = fopen("uebergabedateikimiplus.csv", "r");
   $fp= fopen('files/new.csv',"w+");
   $file_handle = fopen("files/new.csv", "r");

   //datum
   $date = date("YmdHis");
   $tagesdatum= date("d.m.Y");
   $akutelles_Datum_Uhrzeit=date("d.m.Y H:i");
   $Tagesdatum_7Tage=date('d.m.Y', strtotime(' + 7 days'));

   
   
   // changes the date ,datetime,expiredate of the original file($source_file)
   while ($line_of_text = fgetcsv($source_file, 10000,";")) {
        
         $line_of_text[12] = $line_of_text[3].".pdf";
         $line_of_text[18] = "Phone_number";
         $num = $line_of_text[10];
        // prüf ob numeric 
           $result= is_numeric($num);
           if ( $result= is_numeric($num)){
               
                //echo $num.'<br>';
                
                $line_of_text[10]= "";
                $line_of_text[18]= $num;
        
           }
          // else { echo gettype($num)."<br>";  }
              
          //
         $inhalt=$line_of_text[0].";".$line_of_text[1].";".$line_of_text[2].";".$line_of_text[3].";".$line_of_text[4].";".$line_of_text[5].";".$line_of_text[6].";".$line_of_text[7].";".$line_of_text[8].";".$line_of_text[9].";".$line_of_text[10].";".$line_of_text[18].";".$line_of_text[11].";".$line_of_text[12].";".$line_of_text[13].";".$line_of_text[14].";".$line_of_text[15].";".$line_of_text[16].";".$line_of_text[17].";";

       $inhalt.="\n";
       
       fwrite($fp, $inhalt);
         
   
   }
   
  
 $row = fgetcsv($file_handle ,10000,";");
 //---ACCEPT_EMAIL DATEI ERSTELLEN---
 

$file = fopen('files/kimiplus_ae_email'.$date.'.csv','a');

//----Ueberschrift----
  //$email_ueberschrift = str_replace("SenderRecordReferenceID","SenderRecordReferenceID",$row[0]).";".str_replace("batch_date","batch_date",$row[1]).";".str_replace("ticketid_kimi_reference","ticketid_kimi_reference",$row[2]).";".str_replace("payment_reference","payment_reference",$row[3]).";".str_replace("description","description",$row[4]).";".str_replace("amount","amount",$row[5]).";".str_replace("currency","currency",$row[6]).";".str_replace("datetime","datetime",$row[7]).";".str_replace("countdowndays","countdowndays",$row[8]).";".str_replace("expiredate","expiredate",$row[9]).";".str_replace("emailaddress_phonenumber","emailaddress",$row[10]).";".str_replace("accepemail_template","acceptemail_template",$row[11]).";".str_replace("attachement","attachment",$row[12]).";".str_replace("salutation","salutation",$row[13]).";".str_replace("customer_name","customer_name",$row[14]).";".str_replace("customer_adress","customer_adress",$row[15]).";".str_replace("customer_postalcode","customer_postalcode",$row[16]).";".str_replace("company","company",$row[17]).";".str_replace("Phonenumber","Phonenumber",$row[18]).";"."\n";
   $email_ueberschrift = str_replace("SenderRecordReferenceID","SenderRecordReferenceID",$row[0]).";".str_replace("batch_date","batch_date",$row[1]).";".str_replace("ticketid_kimi_reference","ticketid_kimi_reference",$row[2]).";".str_replace("payment_reference","payment_reference",$row[3]).";".str_replace("description","description",$row[4]).";".str_replace("amount","amount",$row[5]).";".str_replace("currency","currency",$row[6]).";".str_replace("datetime","datetime",$row[7]).";".str_replace("countdowndays","countdowndays",$row[8]).";".str_replace("expiredate","expiredate",$row[9]).";".str_replace("emailaddress_phonenumber","emailaddress",$row[10]).";".str_replace("Phone_number","phonenumber",$row[11]).";".str_replace("accepemail_template","acceptemail_template",$row[12]).";".str_replace("attachement","attachment",$row[13]).";".str_replace("salutation","salutation",$row[14]).";".str_replace("customer_name","customer_name",$row[15]).";".str_replace("customer_adress","customer_adress",$row[16]).";".str_replace("customer_postalcode","customer_postalcode",$row[17]).";".str_replace("company","company",$row[18]).";"."\n";

  fwrite($file,$email_ueberschrift); 

//$maxLines
 $maxLines = count( $source )-1;

for ($i = 0; $i < $maxLines && !feof($file_handle); $i++)

{
    $line_of_text = fgetcsv($file_handle, 10000,";");
    $col = str_replace("Phone_number","",$line_of_text[11]); 
         $line_of_text[11] = $col;
         //Datum
           $line_of_text[1] = $tagesdatum;
           $line_of_text[7] = $akutelles_Datum_Uhrzeit;
           $line_of_text[9] = $Tagesdatum_7Tage;
    $email_file= $line_of_text[0].";".$line_of_text[1].";".$line_of_text[2].";".$line_of_text[3].";".$line_of_text[4].";".$line_of_text[5].";".$line_of_text[6].";".$line_of_text[7].";".$line_of_text[8].";".$line_of_text[9].";".$line_of_text[10].";".$line_of_text[11].";".$line_of_text[12].";".$line_of_text[13].";".$line_of_text[14].";".$line_of_text[15].";".$line_of_text[16].";".$line_of_text[17].";".$line_of_text[18].";";
	$email_file.="\n";
	 
    fwrite($file,$email_file); 
}
fclose($file_handle);
   ?>
  <?php
          echo '<br>';
          echo'Dateien im Download bereich';
          echo '<br>';
          echo '<br>';
         $heute1 = date("d-m-Y H:i:s");
         echo "KIMI-PLUS - AcceptEmail -Schnittstelle - ENDE:". $heute1;
  ?>
    </body>
</html>


