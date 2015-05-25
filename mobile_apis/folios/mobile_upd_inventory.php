<?php	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.folio.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.inventory.php';

    if(empty($_POST)){
		$results['return'] = 'false';
		echo json_encode($results);		
	} else {

		$folio_id = $_POST['folio_id'];
		$inventorydata = array();
		
		foreach($_POST as $key => $value){

				if($key !== "folio_id" && $key !== "envia"){
					//$inventorydata[$key] = strtoupper($value);
					$inventorydata[$key] = strtr(strtoupper($value),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				}
			
		}

		#echo "<pre>"; print_r($inventorydata); echo "</pre>"; die();
		
		
		$folio = new FoliosMobiles;		
		$folio_inventory = $folio->getIDinventory($folio_id);

		//Add inventory to db
		$Inventory = new InventoryMobiles;		
		$Inventory = $Inventory->update($inventorydata,$folio_inventory);

		if ($Inventory){
			$results['return'] = 'true';	
			#echo "id_inventario actualizado en folios ".  $folio_inventory. "<br />";
			echo json_encode($results);
		} else {
			$results['return'] = 'false';	
			#echo "error";
			echo json_encode($results);		
		}

	}
?>