<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.contracts.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';	
include_once PATH_CLASSES_FOLDER.'class.employees.php';	
include_once PATH_CLASSES_FOLDER.'class.type_activities.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.support_activities.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.folio.control.php';
include_once PATH_CLASSES_FOLDER.'class.checklist.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
global $Gascomb;

	
	/************************
	Roberto Alarcon 
	Validamos entrada para post por dispositivo movil
	*************************/
	/*	
	if(isset($_REQUEST['activities'])){
		// Array dispositivo movil
		
		$activities = array();
		foreach($_REQUEST['activities'] as $v){
			if(!empty($v)){
				$activities[] = $v;
			}
		
		}
		
		$_REQUEST["support_type_vehicular_id"] = $_REQUEST["support_brand_vehicular_id"];
	
	}
	
	else{
		// Array sistema vista web
		$activities = explode(",", $_REQUEST["act"]);
	}*/
	//print_r($_REQUEST);
	if(!empty($_REQUEST)){
		foreach($_REQUEST as $x => $y){
			$y = utf8_encode($y);
			$y = strtr(strtoupper($y),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			//$_REQUEST[$x] = strtr(strtoupper($y),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			$_REQUEST[$x] = utf8_decode($y);			
		}
	}
	//print_r($_REQUEST);exit(0);
	/************************
	FIN cambio
	*************************/
	$_REQUEST["support_type_vehicular_id"] = $_REQUEST["support_brand_vehicular_id"];
	$folio_data["user_id"] = isset($_SESSION["active_user_id"])? $_SESSION["active_user_id"]:"2";
	$folio_data["dependency_id"] = $_REQUEST["dependency_id"];
	$folio_data["creation_time"] = time();	
	$folio_data["mechanic_assigned"] = $_REQUEST["mechanic_assigned"];
	$folio_data["received_by"] = $_REQUEST["received_by"];
	
	$folio_data["entry_date"] = $_REQUEST["entry_date"];
	$folio_data["entry_time"] = $_REQUEST["entry_time"];
	//$folio_data["departure_date"] = $_REQUEST["departure_date"];	
	//$folio_data["departure_time"] = $_REQUEST["departure_time"];
	$folio_data["validity_until"] = "2";
	$folio_data["registration_plate"] = $_REQUEST["registration_plate"];
	$folio_data["support_brand_vehicular_id"] = $_REQUEST["support_brand_vehicular_id"];
	$folio_data["support_models_vehicular_id"] = $_REQUEST["support_models_vehicular_id"];
	$folio_data["inventory_id"] = "0";
	$folio_data["owner_name"] = $_REQUEST["owner_name"];
	$folio_data["owner_adress"] = $_REQUEST["owner_adress"];
	$folio_data["owner_phone"] = $_REQUEST["owner_phone"];
	$folio_data["owner_cell"] = $_REQUEST["owner_cell"];
	$folio_data["owner_email"] = $_REQUEST["owner_email"];
	$folio_data["owner_email2"] = $_REQUEST["owner_email2"];
	$folio_data["vehicle_operator"] = strtr($_REQUEST["vehicle_operator"],"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
	$folio_data["operator_tel"] = $_REQUEST["operator_tel"];
	$folio_data["traffic_light"] = "2";
	$folio_data["tower"] = $_REQUEST["tower"];
	$folio_data["parking_space"] = $_REQUEST["parking_space"];
	$folio_data["vin"] = $_REQUEST["vin"];	
	$folio_data["area_sector"] = $_REQUEST["area_sector"];	
	$folio_data["zone"] = $_REQUEST["zone"];
	
	$folio_data["order_number"] = $_REQUEST["order_number"];
	$folio_data["type_service"] = $_REQUEST["type_service"];
	$folio_data["failures"] = $_REQUEST["failures"];
	
	$vehicle_data["registration_plate"] = $_REQUEST["registration_plate"];
	$vehicle_data["economic_number"] = $_REQUEST["economic_number"];
	//$vehicle_data["engine_number"] = isset($_REQUEST["engine_number"])? $_REQUEST["engine_number"] : "";
	
	$vehicle_data["support_brand_vehicular_id"] = $_REQUEST["support_brand_vehicular_id"];
	$vehicle_data["support_models_vehicular_id"] = $_REQUEST["support_models_vehicular_id"];
	$vehicle_data["owner_name"] = $_REQUEST["owner_name"];
	$vehicle_data["owner_adress"] = $_REQUEST["owner_adress"];
	$vehicle_data["owner_phone"] = $_REQUEST["owner_phone"];
	$vehicle_data["owner_cell"] = $_REQUEST["owner_cell"];
	$vehicle_data["owner_email"] = $_REQUEST["owner_email"];
	$vehicle_data["owner_email2"] = $_REQUEST["owner_email2"];
	$vehicle_data["year"] = $_REQUEST["year"];
	//$vehicle_data["cilinders"] = isset($_REQUEST["cilinders"])? $_REQUEST["cilinders"] : "";
	//$vehicle_data["km"] = isset($_REQUEST["km"])? $_REQUEST["km"] : "";
	//$vehicle_data["vin"] = isset($_REQUEST["vin"])? $_REQUEST["vin"] : "";	
	$vehicle_data["fuel"] = $_REQUEST["fuel"];	

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ADD'){
		
	
		
		//$contracts_data["dependency_id"] = $_REQUEST["dependency_id"];
		//$contract = new Contract;
		//$contractdata = $contract->add($contracts_data);		
		$folio_data["contract_id"] = $_REQUEST["contract_id"];
		
		$vehicle = new Vehicle;
		$vehicle = $vehicle->add($vehicle_data);		
		$folio_data["vehicles_record_id"] = $vehicle["vehicles_record_id"];
		
		$sup_act["contract_id"] = $_REQUEST["contract_id"];
		$sup_act["dependency_id"] = $_REQUEST["dependency_id"];
		$sup_act["support_type_vehicular_id"] = $_REQUEST["support_type_vehicular_id"];
		$sup_act["support_models_vehicular_id"] = $_REQUEST["support_models_vehicular_id"];
		$sup_act["support_type_activities_id"] = $_REQUEST["type_service"];
		
		//Obtener id de inventario
  		$Inventory = new Inventory;	
		$inventorydata["observations"] = ".";
  		$Inventory = $Inventory->add($inventorydata);
		$folio_data["inventory_id"] = $Inventory["inventory_id"];
				
		$folio = new Folio;		
		$folio = $folio->add($folio_data);					
		//Log, status, alert
		$creado = new statusCreation($folio['folio_id']);		
		$Gascomb->createStatus($creado);
		// Create new requisition.
		
		$stock = new Stock($folio["folio_id"]);
		$stock->createNewRequisition();
		
		$folioControl = new folioControl($folio["folio_id"]);
		// Insertamos inventario en stock
		$folioControl->fnStock();
		
		if(isset($_REQUEST['activities'])){	
			$activities = json_decode(utf8_encode($_REQUEST["activities"]),true);

			//print_r($activities);exit(0);
			//Creamos actividades a realizar		
				$f_activity = new FloorActivity;
				$Checklist = new Checklist;
				foreach($activities as $value){			
					$value = $value["SUPPORT_ACTIVITIES_ID"];
					
					if($value !== ""){
						//Se crea nueva actividad si no existe en tabla: support_checklist_activities
						//if (!preg_match("/[0-9]/i", $value)) {
						if (!preg_match("/^\d+$/i", $value)) {
							$newactivity["activity_name"] = utf8_decode($value);
							$newactivity["status"] = 1;				
							$value = $Checklist->addSupportChecklistActivity($newactivity);					
							$fl_act["description"] = $Checklist->getNameActivitybyId($value);
						}else{
							$description = $Checklist->getNameActivitybyId($value);
							$fl_act["description"] = $description;
						}
						$fl_act["folio_id"] = $folio["folio_id"];			
						$fl_act["support_activity_id"] = $value;
						$result_f_activity = $f_activity->add($fl_act);
						
						$folioControl->fnChecklistFolio($value);
						
					}
				}
		}
		
		/*
		$s_activity = new SupportActivity;
		$f_activity = new FloorActivity; 		
			foreach($activities as $value){
				if($value !== ""){					
					$sup_act["description"] = $value;
					$fl_act["description"] = $value;					
					$result_sactivity = $s_activity->add($sup_act);					
					$fl_act["support_activity_id"] = $result_sactivity["support_activity_id"];
					$result_f_activity = $f_activity->add($fl_act);					
				}
			}	
		*/
		//echo  '{"return":"1","data":'.json_encode($folio).'}';
		
		header('location:../view_inventory.php?folio_id='.$folio["folio_id"]);
		
		
	}
	
	

	
	
?>
