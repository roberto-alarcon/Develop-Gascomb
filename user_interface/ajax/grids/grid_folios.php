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
	$folios = $folio->getActivesFolios(50); 
}else{
	$folios = $folio->selectbyColumn($values, 50); 
}

echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($folios as $clave => $valor) {
		$dependency = new dependency;			
		$dependency_data = $dependency->selectbyId($valor["dependency_id"]);	
		$Stockid = $Stock->selectbyFolioId($valor["folio_id"]);
		
		$f_activity = new FloorActivity; 
		$folioidd["folio_id"] = $valor["folio_id"];
		$activities = $f_activity->selectbyColumn($folioidd, 30);
		
				echo "<row id='".$valor["folio_id"]."'>";
				echo "<cell>".$valor["folio_id"]."</cell>";
				echo "<cell>".$valor["registration_plate"]."</cell>";
				echo "<cell>".utf8_encode($dependency_data["name"])."</cell>";
				//echo "<cell>".utf8_encode($valor["failures"])."</cell>";
				$acts = array();
				if($activities){
								foreach($activities as $value){
									if($value["description"] !== ""){
										$acts[] = $value["description"];										
									}
								}								
							}else{
								$acts[] = "";
							}
				echo "<cell>".utf8_encode(implode(',',$acts))."</cell>";
				echo "<cell>".$valor["entry_date"]."</cell>";				
				//echo "<cell>".$valor["departure_date"]."</cell>";
				echo "<cell>".$Stockid["stock_id"]."</cell>";				
				
			echo "</row>";
				
			}
echo "</rows>";
?>