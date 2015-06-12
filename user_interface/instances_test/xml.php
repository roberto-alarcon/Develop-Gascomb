<?php
	header ("Content-Type:text/xml");
	ini_set('display_errors', '1');
	include '../../modules/classes/class.stock.xml.php';
	
	
	$folio_id = '227';
	$xml = new Stock_XML($folio_id);
	$xml->doXML();
	
?>