<?php
ini_set('display_errors', '1');
//header("Content-type: text/xml");
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
$Stock = new Stock;
$folio = new Folio;

 if (isset($_GET['id']) && ($_GET['id'] != '') && isset($_GET['type']) && ($_GET['type'] != '')){
		$value = $_GET['id'];		
		$typesearch = $_GET['type'];			
		if($typesearch == "stock_id"){			
			$stock = $Stock->selectbyId($value);
			$values["folio_id"] = $stock["folio_id"];
		}else{
			$values[$typesearch] = $value;
		}
 }else{
	$values = null;
 }
if($values == null){
	$folios = $folio->getActivesFoliosActivities(50); 
}else{
	$folios = $folio->selectbyColumn($values, 50); 
}

echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($folios as $clave => $valor) {
		$dependency = new dependency;			
		$dependency_data = $dependency->selectbyId($valor["dependency_id"]);	
		
		echo "<row id='".$valor["folio_id"]."'>";
		echo "<cell>".$valor["folio_id"]."</cell>";
		echo "<cell>".$valor["registration_plate"]."</cell>";
		echo "<cell>".utf8_encode($dependency_data["name"])."</cell>";
		echo "<cell>".$valor["entry_date"]." ".$valor["entry_time"]."</cell>";				
		//echo "<cell>".$_SESSION[active_user_id]."</cell>";
			
		echo "</row>";
				
}
echo "</rows>";
?>