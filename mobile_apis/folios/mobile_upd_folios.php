<?php	

include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.folio.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.vehicles.php';


    if(empty($_POST)){
		$results['return'] = 'false';
		echo json_encode($results);		
	} else {

		$folio_id = $_POST['folio_id'];
		$foliodata = array();
		foreach($_POST as $key => $value){
		  if($key == "vin"){
			$foliodata[$key] = strtr(strtoupper($value),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");		
		  } 	
		}
		
		$vehicledata = array();
		foreach($_POST as $key => $value){
		  if($key !== "folio_id" && $key !== "envia"){
			$vehicledata[$key] = strtr(strtoupper($value),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");		
		  } 	
		}	
			
		
		//Upd folios to db
		$folios = new FoliosMobiles;
		$plate = $folios->getPlate($folio_id);	
		#echo "plate es ". $plate;
		$updfolios = $folios->update($folio_id,$foliodata);
		if( ($updfolios) && (isset($plate)) ){
			$results['return'] = 'true';	
		} else {
			$results['return'] = 'false';	
			echo json_encode($results);
			die();
		}
		
		$vehicles = new VehicleMobiles;
		$updvehicles = $vehicles->update($vehicledata,$plate);
		#echo $updvehicles;
		if($updvehicles){
		  $results['return'] = 'true';	
		} else {
		  $results['return'] = 'false';	
		}	
		
		echo json_encode($results);
	}
	
?>