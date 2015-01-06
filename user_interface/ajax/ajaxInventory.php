<?php	

include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.image.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
//include_once '../../config/set_variables.php';
global $Gascomb;
	
	$folio_id = $_REQUEST['folio_id'];
	//obtener valores de inventarios
	
	foreach($_REQUEST as $key => $value){
		if($value == "1"){
			if($key !== "files_count"){
				//$inventorydata[$key] = strtoupper($value);
				$inventorydata[$key] = strtr(strtoupper($value),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			}
		}
	}

	$inventorydata["observations"] = strtoupper(utf8_decode($_REQUEST['observations']));
	$inventorydata["fuel_level"] = $_REQUEST['fuel_level'];
  	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
	
		$folio = new Folio;		
  		$folio_data = $folio->selectbyId($folio_id);
	
		//Add inventory to db
  		$Inventory = new Inventory;		
  		$Inventory = $Inventory->add($inventorydata); 

		//add images to db
			for($i = 0; $i <=$_REQUEST["files_count"]-1;$i++){
				$image = $_REQUEST["files_s_".$i];
				$image_data["folio_id"] = $folio_id;
				$image_data["image_name"] = $image;
				$image = new Image;
				$image->add($image_data);
			}
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
		/*
		//Alerta recepcion-Piso
		$Recepcion 	= new Alert_Reception();
		$Piso		= new Alert_Floor();
		$Gascomb->Menssage = 'Se creado el folio:'.$folio_id.' y se encuentra listo para la asignación de tareas';
		$Gascomb->Area_Origin = $Recepcion;
		$Gascomb->Area_Request = $Piso;
		$Gascomb->session_folio($folio_id);
			$Gascomb->folio_id = $Gascomb->session_folio();
		$Gascomb->doAlert();*/
		
		include_once "generatepdf.php";
		echo  '{"return":"1","data":['.json_encode($Inventory).']}';	
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
 
	
