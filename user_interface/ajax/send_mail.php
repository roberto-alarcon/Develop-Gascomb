<?php
ini_set('display_errors', '1');
$return = false;

if (isset($_REQUEST["email"])){
	$email = $_REQUEST["email"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {		
		//Validacion cc
		if (isset($_REQUEST["cc"]) && $_REQUEST["cc"] !== ""){
			$emails = explode(",",$_REQUEST["cc"]);
			foreach($emails as $value){
					if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {						
						$return = '{"return":"0","error":"el email: '.$value.' no es válido"}';
					}
			}
			$emails = implode(",",$emails);	
		}else{
			$emails = "";
		}
		//validacion titulo
		
		if(isset($_REQUEST["title"]) && $_REQUEST["title"] != ""){
			$title = utf8_encode($_REQUEST["title"]);
		}else{
			$return = '{"return":"0","error":"Titulo vacío"}';
		}
		if (isset($_REQUEST["message"]) && $_REQUEST["message"] !== ""){
			$message = $_REQUEST["message"];
		}else{
			$return = '{"return":"0","error":"Mensaje vacío"}';
		}
		
	}else{		
		$return = '{"return":"0","error":"'.$email.' email no válido"}';
	}	
}else{
	$return = '{"return":"0","error":"No se recibio destinatario"}';
}

//Si hubo error
if($return){
	echo utf8_encode($return);
}else{
	//Enviar
	//echo '{"return":"1"}';
	//echo "$email<br>$emails<br>$title<br>$message<br>";
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= "Cc: $emails" . "\r\n";
	$cabeceras .= 'From: Grupome <grupome@grupome.com>' . "\r\n";
	if(mail($email, $title, utf8_decode($message), $cabeceras)){
			echo '{"return":"1"}';
	}else{
		echo '{"return":"0","error":"Hubo un problema al enviar el mail, favor de volver a intentar"}';
	}
	
};

?>
