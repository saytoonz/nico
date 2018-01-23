<?php
// Display all error
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
require_once "phpmailer/phpmailer.php";

$body  ='<html><body>';
$body .='<table>';
$body .='<tr><td><img src="time.png"/></td></tr>';
$body .='<tr><td>My sample add body text</td></tr>';
$body .='</table>';
$body .='</body></html>';
        
$mail = new PHPMailer(true);
$mail->IsSMTP();

// enables SMTP debug information
$mail->SMTPDebug = 0;

// enable SMTP authentication
$mail->SMTPAuth = true;

// sets the prefix to the server
$mail->SMTPSecure = 'ssl';

// sets GMAIL as the SMTP server
$mail->Host = 'smtp.gmail.com';

// set the SMTP port for the GMAIL server
$mail->Port = 465;

// your gmail address
$mail->Username = 'v.l.vanaliya@gmail.com';

// your gmail password
$mail->Password = '8000309966';

// add a subject on send the email
$mail->Subject = ' Sample email - phperrorcode.com ';

// Sender email address and name
$mail->SetFrom('info@phperrorcode.com', 'Your Name');

// reciever address, person you want to send
$mail->AddAddress('vikraminphp@gmail.com');


// add message body
$mail->MsgHTML($body);

// add attachment if any
$mail->AddAttachment('time.png');

try {
    $mail->Send();
    $msg = "Mail send successfully";
} catch (phpmailerException $e) {
    $msg = $e->getMessage();
} catch (Exception $e) {
    $msg = $e->getMessage();
}
echo $msg;
