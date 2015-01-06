<?php
	header ("Content-Type:text/xml");
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include PATH_CLASSES_FOLDER.'class.stock.xml.php';
	$xml = new Stock_XML(0);
	$xml->doXML();
	
?>