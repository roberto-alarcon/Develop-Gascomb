<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.contracts.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';	
include_once PATH_CLASSES_FOLDER.'class.employees.php';	
include_once PATH_CLASSES_FOLDER.'class.type_activities.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.support_activities.php';
include_once PATH_CLASSES_FOLDER.'class.folio.control.php';
include_once(PATH_CLASSES_FOLDER.'class.stock.php');	
include_once PATH_CLASSES_FOLDER.'class.checklist.php';
global $GASCOMB; 
	$folio_id = $_REQUEST['folio_id'];
	
	if(!empty($_REQUEST)){
			foreach($_REQUEST as $x => $y){
				//$_REQUEST[$x] = utf8_decode($y);
				$_REQUEST[$x] = utf8_decode(strtr(strtoupper($y),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
			}
	}
	$activities = explode(",", @$_REQUEST["act"]);
	//print_r($_REQUEST);	
	//exit(0);
	//$folio_data["user_id"] = "2";
	$folio_data["dependency_id"] = @$_REQUEST["dependency_id"];
	$folio_data["contract_id"] = @$_REQUEST["contract_id"];
	$folio_data["creation_time"] = time();	
	$folio_data["mechanic_assigned"] = @$_REQUEST["mechanic_assigned"];
	$folio_data["received_by"] = @$_REQUEST["received_by"];
	
	$folio_data["entry_date"] = @$_REQUEST["entry_date"];
	$folio_data["entry_time"] = @$_REQUEST["entry_time"];
	$folio_data["departure_date"] = @$_REQUEST["departure_date"];	
	$folio_data["departure_time"] = @$_REQUEST["departure_time"];
	$folio_data["validity_until"] = "2";
	$folio_data["registration_plate"] = @$_REQUEST["registration_plate"];
	$folio_data["support_brand_vehicular_id"] = @$_REQUEST["support_brand_vehicular_id"];
	$folio_data["support_models_vehicular_id"] = @$_REQUEST["support_models_vehicular_id"];
	$folio_data["inventory_id"] = @$_REQUEST["inventory_id"];
	$folio_data["owner_name"] = @$_REQUEST["owner_name"];
	$folio_data["owner_adress"] = @$_REQUEST["owner_adress"];
	$folio_data["owner_phone"] = @$_REQUEST["owner_phone"];
	$folio_data["owner_cell"] = @$_REQUEST["owner_cell"];
	$folio_data["owner_email"] = @$_REQUEST["owner_email"];
	$folio_data["owner_email2"] = @$_REQUEST["owner_email2"];
	$folio_data["vehicle_operator"] = @$_REQUEST["vehicle_operator"];
	$folio_data["operator_tel"] = @$_REQUEST["operator_tel"];
	$folio_data["traffic_light"] = "2";
	$folio_data["tower"] = @$_REQUEST["tower"];
	$folio_data["parking_space"] = @$_REQUEST["parking_space"];
	$folio_data["vin"] = @$_REQUEST["vin"];	
	$folio_data["area_sector"] = @$_REQUEST["area_sector"];	
	$folio_data["zone"] = @$_REQUEST["zone"];	
	
	$folio_data["order_number"] = @$_REQUEST["order_number"];
	$folio_data["type_service"] = @$_REQUEST["type_service"];
	$folio_data["failures"] = @$_REQUEST["failures"];
	
	$vehicle_data["registration_plate"] = @$_REQUEST["registration_plate"];
	$vehicle_data["economic_number"] = @$_REQUEST["economic_number"];
	$vehicle_data["engine_number"] = @$_REQUEST["engine_number"];
	
	$vehicle_data["support_brand_vehicular_id"] = @$_REQUEST["support_brand_vehicular_id"];
	$vehicle_data["support_models_vehicular_id"] = @$_REQUEST["support_models_vehicular_id"];
	$vehicle_data["owner_name"] = @$_REQUEST["owner_name"];
	$vehicle_data["owner_adress"] = @$_REQUEST["owner_adress"];
	$vehicle_data["owner_phone"] = @$_REQUEST["owner_phone"];
	$vehicle_data["owner_cell"] = @$_REQUEST["owner_cell"];
	$vehicle_data["owner_email"] = @$_REQUEST["owner_email"];
	$vehicle_data["owner_email2"] = @$_REQUEST["owner_email2"];
	$vehicle_data["year"] = @$_REQUEST["year"];
	$vehicle_data["cilinders"] = @$_REQUEST["cilinders"];
	$vehicle_data["km"] = @$_REQUEST["km"];
	$vehicle_data["vin"] = @$_REQUEST["vin"];	
	$vehicle_data["fuel"] = @$_REQUEST["fuel"];	
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'UPDATE'){
		$folio = new Folio;			
		$folio->updatewhere["folio_id"] = $folio_id;
		$folio_data = $folio->update($folio_data);		
		if($folio_data){
			$folioControl = new folioControl($folio_id);
			
			//Creamos actividades a realizar		
			$f_activity = new FloorActivity;
			$Checklist = new Checklist;
			foreach($activities as $value){
				if($value !== ""){
					//Se crea nueva actividad si no existe en tabla: support_checklist_activities
					//if (!preg_match("/[0-9]/i", $value)) {
					if (!preg_match("/^\d+$/i", $value)) {
						$newactivity["activity_name"] = $value;
						$newactivity["status"] = 1;				
						$value = $Checklist->addSupportChecklistActivity($newactivity);					
						$fl_act["description"] = $Checklist->getNameActivitybyId($value);
					}else{
						$description = $Checklist->getNameActivitybyId($value);
						$fl_act["description"] = $description;
					}
					$fl_act["folio_id"] = $folio_id;
					$fl_act["support_activity_id"] = $value;
					$result_f_activity = $f_activity->add($fl_act);
					$folioControl->fnChecklistFolio($value);
				}
			}
		
			$vehicles = new Vehicle;		
			$vehicles->updatewhere["vehicles_record_id"] = $_REQUEST["vehicles_record_id"];
			$vehicle = $vehicles->update($vehicle_data);
			$Inventory = new Inventory;
			$Inventory = $Inventory->selectbyId($folio_data["inventory_id"]);
			//$Inventory["observations"] = utf8_decode(strtr(strtoupper($Inventory['observations']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
			
			if($vehicle){				
				$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
				$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
				if($Inventory){					
					$vehicles = new Vehicle;		
					$vehicle = $vehicles->selectbyId($folio_data["vehicles_record_id"]);
					$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
					$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
				}				
				
				include_once "generatepdf.php";
				echo  '{"return":"1","data":['.json_encode($folio_data).']}';
			}else{
				echo  '{"return":"0","data":"Hubo un error al actualizar los datos del vehiculo"}';
			}
			
		}else{
			echo  '{"return":"0","data":"Hubo un error al actualizar los datos del folio"}';
		}
	
			
		
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'DELIVERY'){
		$dataupdate["departure_date"] = date("d/m/Y",time());	
		$dataupdate["departure_time"] = date("H:i",time());
		$dataupdate["support_status_id"] = "8";
	
		$folio = new Folio;
		$folioinfo = $folio->selectbyId($folio_id);
		if($folioinfo["support_status_id"] == "8"){
			echo  '{"return":"0","data":"Este folio ya habia sido cerrado"}';exit(0);
		}
		if($folioinfo["support_status_id"] == "9"){
			echo  '{"return":"0","data":"Este folio ya habia sido cancelado, por lo que no puede ser cerrado"}';exit(0);
		}
		$folio->updatewhere["folio_id"] = $folio_id;
		$folio_data = $folio->update($dataupdate);		
		if($folio_data){
			echo  '{"return":"1","data":"Folio cerrado correctamente"}';
			$Gascomb->log("Se ha entregado el vehiculo con folio #".$Gascomb->session_folio($folio_id));		
		}else{
			echo  '{"return":"0","data":"Hubo un error al cerrar folio"}';
		}
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'CANCEL'){
		$dataupdate["departure_date"] = date("d/m/Y",time());	
		$dataupdate["departure_time"] = date("H:i",time());
		$dataupdate["support_status_id"] = "9";
	
		$folio = new Folio;
		$folioinfo = $folio->selectbyId($folio_id);
		if($folioinfo["support_status_id"] == "9"){
			echo  '{"return":"0","data":"Este folio ya habia sido cancelado"}';exit(0);
		}
		if($folioinfo["support_status_id"] == "8"){
			echo  '{"return":"0","data":"Este folio ya habia sido cerrado, por lo que no puede ser cancelado"}';exit(0);
		}
		$folio->updatewhere["folio_id"] = $folio_id;
		$folio_data = $folio->update($dataupdate);		
		if($folio_data){
			$Gascomb->log("Se ha cancelado el vehiculo con folio #".$Gascomb->session_folio($folio_id));		
			echo  '{"return":"1","data":"Folio cancelado correctamente"}';
			
		}else{
			echo  '{"return":"0","data":"Hubo un error al cancelar folio"}';
		}
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ACTIVATE'){
		$dataupdate["departure_date"] = date("d/m/Y",time());	
		$dataupdate["departure_time"] = date("H:i",time());
		$dataupdate["support_status_id"] = "2";
		$folio = new Folio;
		$folioinfo = $folio->selectbyId($folio_id);
		if($folioinfo["support_status_id"] == "2"){
			echo  '{"return":"0","data":"El folio seleccionado actualmente se encuentra activo por lo tanto no se realizo ninguna operacion"}';exit(0);
		}
		$folio->updatewhere["folio_id"] = $folio_id;
		$folio_data = $folio->update($dataupdate);		
		if($folio_data){
			$Gascomb->log("Se ha reactivado el vehiculo con folio #".$Gascomb->session_folio($folio_id));		
			echo  '{"return":"1","data":"Folio fue reactivado correctamente"}';
			
		}else{
			echo  '{"return":"0","data":"Hubo un error al reactivar folio"}';
		}
	
	
	}
	
	
	
	
?>	
	