<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
    </head>
    <body>
<?php

//require('phpmailer/class.phpmailer.php');
//require_once './class.phpmailer.php';
//require_once './class.smtp.php';

//require "/var/www/kimi/vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$srcDir = "/var/www/kimi/vendor/phpmailer/phpmailer/src";
require "$srcDir/PHPMailer.php";
require "$srcDir/SMTP.php";
require "$srcDir/Exception.php";

$body = '
<h1>My First Heading</h1>
test
<p>My first paragraph.</p>
';

$mail = new PHPMailer();

$mail->SMTPAuth = false;
$mail->Username = 'KSmtp';  //$_POST['from'];
$mail->Password = '$k4020$s$ptms$';     //$_POST['pwd'];
$mail_from = 'kundenservice@kimi-plus.at'; //$_POST['from'];
$mail_fromName = 'KIMI-Plus Kundenservice'; //$_POST['from'];
$mail->CharSet = 'utf-8';

$mail->IsSMTP();
$mail->Host = "83.65.86.204";
$mail->Port = 25;
$mail->SetFrom="kundenservice@kimi-plus.at";
$mail->AddAddress("office@aberl.at");
$mail->Subject = "Testmail von Kimi";
$mail->isHTML(true);
$mail->Body = $body;	// "Meine Nachricht";
$mail->Send();
echo "\ndone\n";
exit;

//$mail->SMTPSecure = "tls";
$mail->SMTPAuth = false;
$mail->Username = 'KSmtp';  //$_POST['from'];
$mail->Password = '$k4020$s$ptms$';     //$_POST['pwd'];
//$mail_from = 'kundenservice@kimi-plus.at'; //$_POST['from'];
//$mail_from = 'kundenservice@kimi-plus.at'; //$_POST['from'];
//$mail_fromName = 'KIMI-Plus Kundenservice'; //$_POST['from'];

//$subject = $_POST['subject'];
$subject = "test";

$body = '
<h1>My First Heading</h1>
test
<p>My first paragraph.</p>
';
//$mail_to = $_POST['mail_to'];
//$mail_to_name = $_POST['mail_to_name'];
$mail_to = "office@aberl.at";
$mail_to_name = "Aberl";


$mail_bcc = 'office@aberl';
$mail_cc = 'ronald.aberl@aberl.at';

$mail->IsSMTP();

try {
    //$mail->Host = "80.243.174.62"; // SMTP server
    #$mail->Host = "192.168.100.10"; // SMTP server
    #$mail->Port = "25"; //SMTP Port
    //$mail->Host = "mse1.inntelco.at"; // SMTP server
	$mail->Host = "83.65.86.204"; // SMTP server
    
    $mail->Port = "25"; //SMTP Port

/*
    $mail->Host ="smtp.office365.com";
    $mail->Port = 587;
    $mail->Host = 'smtp.office365.com';
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;
    $mail->Username = 'ronald.aberl@aberl.at';
    $mail->Password = '$Ar200667$';
    $mail->SetFrom('ronald.aberl@aberl.at', 'Ronald Aberl');
 */
    //
    //$mail->Host = "192.168.100.10"; // SMTP server
    //$mail->Port = "25"; //SMTP Port

    $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
    //$mail->Debugoutput = 'html';
    $mail->AddAddress($mail_to);
    //$mail->AddCC($mail_cc);
//    $mail->AddBCC($mail_bcc);
    //$mail->From = $mail_from;
    //$mail->FromName = $mail_fromName;
    
    //$mail->Reply = $mail_from;        //SetFrom($mail_from); 
    $mail->Subject = $subject;
    $mail->CharSet = 'utf-8';
    
	$mail->isHTML(true);
	$mail->Body = $body;
    //$mail->MsgHTML($body);
    
    $mail->Send();
    echo "Nachricht wurde an ".$mail_to." gesendet!";
    //echo "Click <a href=\"index.php\">here</a> to send another email";
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
    echo "<p>Using Username: " . $mail->Username . "</p>";
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}
?>
    </body>
</html>
