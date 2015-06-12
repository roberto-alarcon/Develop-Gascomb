<?php
	header("Content-type: text/xml");
	/* version 1.0
	include_once('../../modules/classes/class.stock.php');
	$folio = (isset($_GET["folio"]))?$_GET["folio"]:0;
	$stock = new Stock($folio);
	$stock->makeDynamicTreeXml(true);
	*/
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include PATH_CLASSES_FOLDER.'class.stock.xml.php';
	$folio_id = (isset($_GET["folio"]))?$_GET["folio"]:0;
	$xml = new Stock_XML($folio_id);
	$xml->doXMLFolio();
	
?>