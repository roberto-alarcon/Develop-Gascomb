<?php	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.folio.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.vehicles.php';


    if(empty($_POST)){
		$results['return'] = 'false';
		echo json_encode($results);		
	} else {
        #echo "<pre>"; print_r($_POST); echo "</pre>"; die();
		$folio_id = $_POST['folio_id'];
		$inventorydata = array();
		$pdf = "no";
		
		foreach($_POST as $key => $value){

			if($key !== "folio_id" && $key !== "envia"){
				if($key == "observations" || $key == "fuel_level"){
					$pdf = "si";
				}
				//$inventorydata[$key] = strtoupper($value);
				$inventorydata[$key] = strtr(strtoupper($value),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			}
			
		}

		#echo "<pre>"; print_r($inventorydata); echo "</pre>";

		$folio = new FoliosMobiles;		
		$folio_data = $folio->selectbyId($folio_id);
		$folio_inventory = $folio_data["inventory_id"];
		$Inventory = new InventoryMobiles;
		
        if($pdf == 'si'){
			$Inventorys = $Inventory->selectbyId($folio_inventory);
			
			$vehicles = new VehicleMobiles;		
			$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
			$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
			$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);	
			
			if ( is_array($Inventorys) && is_array($folio_data) ){
			   include_once PATH_USER_INTERFACE_AJAX_PDF . 'generatepdf-ipad.php';	
			}
			
		}

		//Add inventory to db
		$Inventory2 = $Inventory->update($inventorydata,$folio_inventory);

		if ($Inventory2){
			$results['return'] = 'true';	
			#echo "id_inventario actualizado en folios, inventory y pdf ok ".  $folio_inventory. "<br />";
			echo json_encode($results);
		} else {
			$results['return'] = 'false';	
			#echo "error";
			echo json_encode($results);		
		}

	}
?>