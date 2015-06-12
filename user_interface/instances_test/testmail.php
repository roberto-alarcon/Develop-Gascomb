<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/
ini_set('display_errors', '1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	//include PATH_CLASSES_FOLDER.'class.stock.php';
include PATH_CLASSES_FOLDER.'PHPmailer5.1/class.phpmailer.php';

/*
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "mail.gascomb.com"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->Host       = "mail.gascomb.com"; // sets the SMTP server
  $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
  $mail->Username   = "ralarcon@gascomb.com"; // SMTP account username
  $mail->Password   = "entrar";        // SMTP account password
  $mail->AddReplyTo('gascomb@gascomb.com', 'First Last');
  $mail->AddAddress('l._.m@hotmail.com', 'Lázaro Martínez');
  $mail->SetFrom('gascomb@gascomb.com', 'First Last');
  $mail->AddReplyTo('gascomb@gascomb.com', 'First Last');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML('Test content');  
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}*/



try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	//$body             = file_get_contents('contents.html');
	//$body             = preg_replace('/\\\\/','', $body); //Strip backslashes
	$body = "Se ha agregado una nueva ampliación or lo que solicitamos autorize o rechace dicha sls ";

	$mail->IsSMTP();  
	// tell the class to use SMTP	
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP server port
	$mail->Host       = "mail.gascomb.com"; // SMTP server
	$mail->Username   = "ralarcon@gascomb.com";     // SMTP server username
	$mail->Password   = "entrar";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("gascomb@gascomb.com","Gascomb");

	$mail->From       = "gascomb@gascomb.com";
	$mail->FromName   = "Gascomb";

	$to = "lic-inf_martinez@hotmail.com";

	$mail->AddAddress($to);

	$mail->Subject  = "Nueva ampliación";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>
