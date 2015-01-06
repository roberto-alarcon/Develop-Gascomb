<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	
	$incial = (isset($_GET["incial"]))?$_GET["incial"]:0;
	$final	= (isset($_GET["final"]))?$_GET["final"]:0;
	$cadena	= (isset($_GET["cadena"]))?$_GET["cadena"]:'null';
	
	$stock = new Stock();
	$stock->gridAllProduct($incial,$final,$cadena);
	
?>