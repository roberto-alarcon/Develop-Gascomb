<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$id = $_POST['id'];
	$stock = new Stock();
	$product = $stock->getProductDetail($id);
	echo '{"product":"'.str_replace('"',"'",$product['product']).'","code_product":"'.$product['code_product'].'","unit":"'.$product['unit'].'","price":"'.$product['price'].'","line":"'.$product['line'].'","brand":"'.$product['brand'].'"}';
	
?>