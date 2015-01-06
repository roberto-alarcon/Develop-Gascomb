<?php
	 //Mostrar errores de ejecución
	ini_set('display_errors', '1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include PATH_CLASSES_FOLDER.'class.stock.php';
	$stock = new Stock;
	if($stock->pendingStockDetails(59)){
		echo "hay";
	}else{
		echo "no";
	}
	
	/*
	$creation 	= new statusCreation();
	
	$Gascomb->session_folio(227);
	//$Gascomb->createStatus($creation);
	$pendiente 	= new statuspendingAssignment();
	$proceso 	= new statusprocess();
	$pendienterequisition = new statuspendingRequisition();
	$Gascomb->createStatus($pendienterequisition);*/
	
	
	
?>