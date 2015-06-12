<?php
	//header ("Content-Type:text/xml");
	
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	print_r($_SESSION);		
	echo $Gascomb->session_user_name();
	echo $Gascomb->session_folio(204).'<br><br>';
	echo $Gascomb->session_folio();
	$Gascomb->log('Este es mi primer mensaje de prueba');
	
	//print_r($Gascomb->getLogsFolio());
	
?>