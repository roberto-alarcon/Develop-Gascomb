<?php	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.folio.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.vehicles.php';

    if(empty($_POST)){
		$results['return'] = 'false';
		echo json_encode($results);		
	} else {

		$folio_id = $_POST['folio_id'];

		#echo "<pre>"; print_r($inventorydata); echo "</pre>";

		$folio = new FoliosMobiles;		
		$folio_data = $folio->selectbyId($folio_id);
		$folio_inventory = $folio_data["inventory_id"];
		$folio_type_capture['type_capture'] = "0";
	
  		$Inventory = new InventoryMobiles;
		$Inventory = $Inventory->selectbyId($folio_inventory);
		
		$vehicles = new VehicleMobiles;		
		$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
		$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
		$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);			


		if ( is_array($Inventory) && is_array($folio_data) ){
			
			include_once PATH_USER_INTERFACE_AJAX_PDF . 'generatepdf-ipad.php';
			
			$rss = $folio->update($folio_id,$folio_type_capture);
			if ($rss){
				$results['return'] = 'true';	
			    #echo "id_inventario actualizado en folios, inventory y pdf ok ".  $folio_inventory. "<br />";
			    echo json_encode($results);
			} else {
			    $results['return'] = 'error-update-pdf';	
				echo json_encode($results);
			}	
			
		} else {
			$results['return'] = 'error-arrays';	
			#echo "error";
			echo json_encode($results);		
		}

	}
?>