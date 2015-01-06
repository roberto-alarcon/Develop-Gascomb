<?php
	 //Mostrar errores de ejecución
	ini_set('display_errors', '1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	//$Alerts = new Alert();
	
	$Recepcion 	= new Alert_Reception();
	$Almacen	= new Alert_Stock();
	$Calidad	= new Alert_Quality();
	$Piso		= new Alert_Floor();
	
	$Gascomb->Menssage = 'La requisicion esta lista favor de continuar con el trabajo';
	$Gascomb->Area_Origin = $Almacen;
	$Gascomb->Area_Request = $Recepcion;
	$Gascomb->session_folio(204);
        $Gascomb->folio_id = $Gascomb->session_folio();
	$Gascomb->doAlert();
	
?>