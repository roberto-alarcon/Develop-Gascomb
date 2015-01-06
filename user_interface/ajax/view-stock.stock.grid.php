<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$stock_id = $_GET['id'];
	
	$stock = new Stock();
	$stock->initGridByStockID($stock_id);
	
?>