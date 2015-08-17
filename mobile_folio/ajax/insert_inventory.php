<?php	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.image.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
global $Gascomb;
	
	$folio_id = $_GET['folio_id'];
	//obtener valores de inventarios
	
		
	foreach($_REQUEST as $key => $value){
		if($value == "on"){
			if($key !== "files_count"){
				$inventorydata[$key] = '1';
			}
		}
	}
	$inventorydata["observations"] = $_REQUEST['observations'];
	
	$inventorydata["fuel_level"] = $_REQUEST['slider'];//nivel de gasolina
  	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
	
		$folio = new Folio;		
  		$folio_data = $folio->selectbyId($folio_id);
		
		//print_r($folio_data);exit(0);
	
		//Add inventory to db
  		$Inventory = new Inventory;		
  		//$Inventory = $Inventory->add($inventorydata); 
		
		//update inventory	 	
		$Inventory->updatewhere = array("inventory_id"=>$folio_data["inventory_id"]);
		$Inventory = $Inventory->update($inventorydata);
		
		//Reseteamos vin en pdf
		$folio_data["vin"] = $_REQUEST['vin'];
		
		//Actualizar inventory_id en Folios
		$id_inv["inventory_id"] = $Inventory["inventory_id"];
		$id_inv["vin"] = $_REQUEST['vin'];
		$folio_idd = array("folio_id"=>$folio_id);
		$folio->updatewhere = $folio_idd;
		$id_inv["inventory_id"] = $Inventory["inventory_id"];
		$folio->update($id_inv);
		
		$vehicles = new Vehicle;
		
		$vehicle_data_update["vin"] = $_REQUEST['vin'];
		$vehicle_data_update["km"] = $_REQUEST['km'];
		$vehicle_data_update["engine_number"] = $_REQUEST['engine_number'];
		$vehicle_data_update["cilinders"] = $_REQUEST['cilinders'];
		$vehicles->updatewhere = array("vehicles_record_id"=>$folio_data["vehicles_record_id"]);
		$vehicles->update($vehicle_data_update);

		
		$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
		$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
		$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);		
		
		$pendiente = new statusPendingAssignment($folio_id);		
		$Gascomb->createStatus($pendiente);
		
		
		$ismobile = true; //validaciòn para mobile
		$inventorydata["observations"] = html_entity_decode($inventorydata["observations"]);
		
		include_once "../../user_interface/ajax/generatepdf.php";
		//echo  '{"return":"1","data":['.json_encode($Inventory).']}';
		
		//Pintamos el folio
		//echo '<h1>Se a insertado el folio '.$$folio_id.' correctamente</h1>';
		header('location:'.PATH_MULTIMEDIA.$folio_id.'/pdf/'.$folio_id.'.pdf');
		
  	}
  	
  	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
  		
  		$Employee = new Employee;
  		if ($Employee->validateupdate() == false){
  			echo  '{"return":"0","data":['.json_encode($Employee->errors).']}';
  		}else{
  			$Employee = $Employee->update($Employee->userdata);		
  			echo  '{"return":"1","data":['.json_encode($Employee).']}';		
  		}
  	}
 
	
