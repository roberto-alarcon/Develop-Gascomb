<?php

include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once PATH_CLASSES_FOLDER.'class.activities.php';

if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "delete"){
	if(isset($_REQUEST["id"])){
		//print_r($_REQUEST);exit(0);
		
		$db = new manejaDB();			
		$db->query('DELETE FROM sistema_gascomb.floor_activities where floor_activity_id="'.$_REQUEST["id"].'"');		
		$db->desconectar();	
					
		echo 'true';
		
	}
}

?>