<?php	

include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.image.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
//include_once '../../config/set_variables.php';
global $Gascomb;


	$folio_id = $_POST['folio_id'];
    $inventorydata = array();
	
	foreach($_POST as $key => $value){
		$v = "";
		if($value == "on"){
		    $v = 1;
			if($key !== "files_count" && $key !== "folio_id"){
				//$inventorydata[$key] = strtoupper($value);
				$inventorydata[$key] = strtr(strtoupper($v),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			}
		}
		
	}

	#echo "<pre>"; print_r($inventorydata); echo "</pre>"; die();
	$inventorydata["observations"] = strtoupper(utf8_decode($_POST['observations']));
	$inventorydata["fuel_level"] = $_POST['fuel_level'];
	
	
	$folio = new Folio;		
	$folio_data = $folio->selectbyId($folio_id);
	
	//Add inventory to db
  	$Inventory = new Inventory;		
  	$Inventory = $Inventory->add($inventorydata);

	//Actualizar inventory_id en Folios
	$id_inv["inventory_id"] = $Inventory["inventory_id"];
	$folio_idd = array("folio_id"=>$folio_id);
	$folio->updatewhere = $folio_idd;
	$id_inv["inventory_id"] = $Inventory["inventory_id"];
	$folio->update($id_inv);
	
	$vehicles = new Vehicle;		
	$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
	$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
	$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);	
	
	$pendiente = new statusPendingAssignment($folio_id);		
	$Gascomb->createStatus($pendiente);	
	
		
	include_once '../../user_interface/ajax/generatepdf.php';
	
	#echo  '{"return":"1","data":['.json_encode($Inventory).']}';
    $results['make'] = 'true';	
	echo "id_inventario actualizado en folios ".  $Inventory. "<br />"
	#echo json_encode($results);
	
?>