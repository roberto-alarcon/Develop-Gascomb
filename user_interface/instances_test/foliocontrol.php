<?php
	ini_set('display_errors', '1');
	include '../../modules/classes/class.folio.control.php';
	ini_set('display_errors', '1');
	
	$folio_id = '302';
	$folioControl = new folioControl($folio_id);
	// Insertamos inventario en stock
	$folioControl->fnStock();
	
	// Insertamos control de calidad
	// fnChecklistFolio($activity)
	$folioControl->fnChecklistFolio(5);
	$folioControl->fnChecklistFolio(7);
	$folioControl->fnChecklistFolio(9);
	
	echo 'Listo';	
?>