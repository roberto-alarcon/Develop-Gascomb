<?php
//ini_set('display_errors', '1');
//header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
 if (isset($_GET['id']) && ($_GET['id'] != '')){
		$value = $_GET['id'];		
		$typesearch = $_GET['type'];
		$values["folio_id"] = $value;			
 }else{
	$values = null;
 }
$vehicle = new Vehicle;
$vehic = $vehicle->selectbyId($id_folio);
print_r($vehic);