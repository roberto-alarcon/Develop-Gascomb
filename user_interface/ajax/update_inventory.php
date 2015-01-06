<?php	
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.image.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';

	$folio_id = $_REQUEST['folio_id'];
	//obtener valores de inventarios
	
	foreach($_REQUEST as $key => $value){
		if($value == "1"){
			if($key !== "files_count"){
				$inventorydata[$key] = $value;
			}
		}
	}
	$inventorydata["observations"] = utf8_decode(strtr(strtoupper($_REQUEST['observations']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));//utf8_decode($_REQUEST['observations']);
	$inventorydata["fuel_level"] = $_REQUEST['fuel_level'];
	$Inventory = new Inventory;
	$folio = new Folio;	
	
  	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
		$inventory_old = $Inventory->selectbyId($_REQUEST["inventory_id"]);
		unset($inventory_old["inventory_id"]);unset($inventory_old["observations"]);unset($inventory_old["fuel_level"]);
		foreach($inventory_old as $key => $value){
					$inventoryold[$key] = '0';
		}
	
		
		$inventory_id = array("inventory_id"=>$_REQUEST["inventory_id"]);
		$Inventory->updatewhere = $inventory_id;
		$result= $Inventory->update($inventoryold);
		
		$Inventory->updatewhere = $inventory_id;
		$Inventory = $Inventory->update($inventorydata);
		if($Inventory){
			$folio_data = $folio->selectbyId($folio_id);
			$vehicles = new Vehicle;		
			$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
			$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
			$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);		
			
			include_once "generatepdf.php";
			echo  '{"return":"1","data":['.json_encode($Inventory).']}';
		}
			
		
	}