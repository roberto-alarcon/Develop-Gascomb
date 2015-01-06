<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$stock = new Stock();
	$action_id = $stock->insertUpdateProducts($_POST);
	echo '{"result":"'.$action_id.'"}';
	
?>