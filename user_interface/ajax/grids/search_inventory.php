<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once (PATH_CLASSES_FOLDER.'class.inventory.php');
include_once PATH_CLASSES_FOLDER.'class.folio.php';
 if (isset($_GET['id']) && ($_GET['id'] != '')){
		$value = $_GET['id'];		
		//$typesearch = $_GET['type'];
		//$values[$typesearch] = $value;			
 }else{
	$values = null;
 }
$inventory = new Inventory;
 
if(isset($_GET['type']) && ($_GET['type'] == 'folio_id')){
	$folio = new Folio;
	$folio = $folio->selectbyId($value);
	$inventory_id = $folio["inventory_id"];
	
	$inventory_data = $inventory->selectbyId($inventory_id);
}else{
	$inventory_data = $inventory->selectbyId($value);
}
	
	if($inventory_data){
		echo "<data>";
			foreach ($inventory_data as $clave => $valor) {				
					echo "<$clave><![CDATA[".utf8_encode($valor)."]]></$clave>";					
			}
		echo "</data>";	
	}else{
		echo "<data>";
		echo "</data>";
	}
?>
