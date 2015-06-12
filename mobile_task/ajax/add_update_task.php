<?php
ini_set('display_errors',1);
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.stock.mobile.php';
include_once PATH_CLASSES_FOLDER.'class.folio.control.php';
include_once PATH_CLASSES_FOLDER.'class.checklist.php';
include_once PATH_CLASSES_FOLDER.'class.alert.workfloor.php';


$id_user = '2';
$folio_id = @$_REQUEST["folio"];

$activity = new FloorActivity;
$Checklist = new Checklist;
$folioControl = new folioControl($folio_id);
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "add"){
	if(isset($_REQUEST["activities"])){
		$activities = json_decode($_REQUEST["activities"], true);
		
		foreach($activities as $activit){		
			if($activit["support_activity_id"] !== ''){
				//Se crea nueva actividad si no existe en tabla: support_checklist_activities
				//if (!preg_match("/[0-9]/i", $activit["support_activity_id"])) {
				if (!preg_match("/^\d+$/i", $activit["support_activity_id"])) {
					$newactivity["activity_name"] = $activit["support_activity_id"];
					$newactivity["status"] = 1;				
					$id = $Checklist->addSupportChecklistActivity($newactivity);					
					$activit["support_activity_id"] = $id;
				}	
					
				//convertir fecha de inicio a timestamp
				//list($day, $month, $year, $hour, $minute) = split('[/ :]',$activit["time_start"]);
				//$timestamp=mktime($hour, $minute,0, $month, $day, $year);
				
				$date = explode(' ',$activit["time_start"]);
				list($day, $month, $year) = explode('/',$date[0]);
				list($hour, $minute) = explode(':',$date[1]);
				
				$timestamp=mktime($hour, $minute,0, $month, $day, $year);
				
				$datainsert["folio_id"] = $folio_id;				
				$datainsert['employee_id'] = $activit["employee_id"];
				$datainsert['support_activity_id'] = $activit["support_activity_id"];		
				$datainsert['description'] = utf8_decode($activit["description"]);		
				$datainsert['max_time_hours'] = $activit["max_time_hours"];						
				$datainsert['time_start'] = $timestamp;										
				$datainsert['status'] = $activit["status"];		
				$datainsert['comments'] = utf8_decode($activit["comments"]);	
				$datainsert['percent_completed'] = 0;	
				/**/
				$folioControl->fnChecklistFolio($activit["support_activity_id"]);
				
				$result = $activity->add($datainsert);				
				
			}
		}
		if($result){		
			$proceso 	= new statusTasksAssigment($folio_id);		
			$Gascomb->createStatus($proceso);
			echo 'true';
		}else{
			echo 'false';
		}
	}
}
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "update"){
	if(isset($_REQUEST["activities"])){
		//print_r($_REQUEST);
		$activities = json_decode($_REQUEST["activities"], true);
		//print_r($activities); die();
		foreach($activities as $activit){		
			if($activit["support_activity_id"] !== '' and $activit["time_start"] != 0){
							
				$datainsert["folio_id"] = $folio_id;				
				$datainsert['employee_id'] = $activit["employee_id"];
				$datainsert['support_activity_id'] = $activit["support_activity_id"];		
				$datainsert['description'] = utf8_decode($activit["description"]);		
				$datainsert['max_time_hours'] = $activit["max_time_hours"];						
				$datainsert['time_start'] = $activit["time_start"];										
				$datainsert['status'] = $activit["status"];		
				$datainsert['comments'] = utf8_decode($activit["comments"]);					
				//print_r($datainsert);
				$activity->updatewhere["floor_activity_id"] = $activit["floor_activity_id"];
				$result = $activity->update($datainsert);
				
			}
		}
		if($result){
			$proceso 	= new statusTasksAssigment($folio_id);		
			$Gascomb->createStatus($proceso);
			echo 'true';
		}else{
			echo 'false';
		}
	}
}
if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "delete"){
	if(isset($_REQUEST["floor_activity_id"])){
		
		$db = new manejaDB();			
		$db->query('DELETE FROM '.BD_DATABASE.'.floor_activities where floor_activity_id="'.$_REQUEST["floor_activity_id"].'"');		
		$db->desconectar();	
					
		echo 'true';
		
	}
}

?>