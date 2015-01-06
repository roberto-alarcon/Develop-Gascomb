<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHPMailer - sendmail test</title>
</head>
<body>
<?php
require '../class.phpmailer.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
// Set PHPMailer to use the sendmail transport
$mail->IsSendmail();
//Set who the message is to be sent from
$mail->SetFrom('roberto.alarcon@tours360.com.mx', 'Roberto Alarcon');
//Set an alternative reply-to address
$mail->AddReplyTo('roberto.alarcon@tours360.com.mx','Roberto Alarcon');
//Set who the message is to be sent to
$mail->AddAddress('roberto.alarcon.seo@gmail.com', 'Don Roberto Alarcon');
//Set the subject line
$mail->Subject = 'PHPMailer esperemos que llegue bien este correo';
//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->AddAttachment('images/phpmailer_mini.gif');

//Send the message, check for errors
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>
</body>
</html>
