<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$cadena	= (isset($_POST["cadena"]))?$_POST["cadena"]:'null';
	$stock = new Stock();
	$total = $stock->gridAllProductTotalRows($cadena);
	echo '{"result":"'.$total.'"}';
	
?>