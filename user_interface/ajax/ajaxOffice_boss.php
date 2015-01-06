<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.office_boss.php';

	
	$OfficeBoos = new OfficeBoos;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
		$office_data["name"] = $_REQUEST['name'];
		$office_data["last_name"] = $_REQUEST['last_name'];
		$Boos = $OfficeBoos->add($office_data);		
		echo  '{"return":"1","data":['.json_encode($Boos).']}';				
	}
		
	if (isset($_REQUEST['action']) and ($_REQUEST['action'] == 'get')){
		$Boos = $OfficeBoos->selectRows(10);
		if($Boos){
			echo json_encode($Boos);
		}else{
			echo  '{"return":"0","error":"No hay datos"}';		
		}
		
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
		//update Almacen
		$data["user_id"] = $_REQUEST["almacen"];				
		$OfficeBoos->updatewhere = array("office_boss_id"=>"2");		
		$Boos = $OfficeBoos->update($data);		
		//update Recepción
		$data1["user_id"] = $_REQUEST["recepcion"];				
		$OfficeBoos->updatewhere = array("office_boss_id"=>"1");
		$Boos = $OfficeBoos->update($data1);
		$data1["user_id"] = $_REQUEST["calidad"];				
		$OfficeBoos->updatewhere = array("office_boss_id"=>"3");
		$Boos = $OfficeBoos->update($data1);
		
		if ($Boos){
			echo  '{"return":"1","data":['.json_encode($Boos).']}';	
		}else{			
			echo  '{"return":"0","data":['.json_encode($user->errors).']}';						
		}
	}
	
