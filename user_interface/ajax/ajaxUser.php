<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.users.php';
include_once PATH_CLASSES_FOLDER.'class.employees.php';
	
	//print_r($_REQUEST);
	
	$user = new Users;
	$employee = new Employee;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
		$user_data["name"] = utf8_decode(strtr(strtoupper($_REQUEST['name']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$user_data["last_name"] = utf8_decode(strtr(strtoupper($_REQUEST['last_name']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$user_data["email"] = $_REQUEST['email'];
		$user_data["creation_time"] = time();
		$user_data["password"] = md5( $_REQUEST['password'] );
		$user_data["profile"] = $_REQUEST['profile'];
		$user_data["status"] = $_REQUEST['status'];
		
		if($_REQUEST['isemployee'] == "1"){
			$employee_data["name"] = $_REQUEST['name'];
			$employee_data["last_name"] = $_REQUEST['last_name'];
			$employee_data["role"] = utf8_decode($_REQUEST['role']);
			$employee_data["department"] = utf8_decode($_REQUEST['department']);
			$employee_data["company"] = utf8_decode($_REQUEST['company']);
			$employee_data["creation_time"] = time();
			$employee_data["modification_time"] = time();
			$employee_data["status"] = $_REQUEST['status'];
			$emp_result = $employee->add($employee_data);
			if($emp_result){				
				$employee_id = $emp_result["employee_id"];
			}
			
		}else{
			$employee_id = "";
		}
		$user_data["employee_id"] = $employee_id;		
		if ($user->validateinsert($user_data) == false){
			echo  '{"return":"0","data":['.json_encode($user->errors).']}';
		}else{
			$user = $user->add($user_data);
			if($user){
				if($user["user_id"]){
						echo  '{"return":"1","data":['.json_encode($user).']}';		
				}else{
					echo  '{"return":"0","data":"Error"}';
				}		
				
			}else{
				echo  '{"return":"0","data":"Error"}';
			}
			
		}
	}
		
	if (isset($_REQUEST['action']) and ($_REQUEST['action'] == 'get')){
		$id = $_REQUEST['id'];
		$userdata = $user->selectbyId($id);
		$userdata["name"] = utf8_encode($userdata["name"]);
		$userdata["last_name"] = utf8_encode($userdata["last_name"]);
		
		echo json_encode($userdata);
		
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
		
		if ($user->validateupdate($_REQUEST) == "0"){			
			echo  '{"return":"0","data":['.json_encode($user->errors).']}';		
		}else{
			//print_r($user->userdata);exit(0);
			$user = $user->update($user->userdata);
			echo  '{"return":"1","data":['.json_encode($user).']}';		
		}	
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'disable'){
		if(isset($_REQUEST["id"]) && $_REQUEST["id"] !== ""){
			$user->updatewhere = array("user_id" =>$_REQUEST["id"]);
			$status = array("status"=>"0");
			$user = $user->update($status);
			echo  '{"return":"1","data":['.json_encode($user).']}';		
		}else{
			echo  '{"return":"0","data":{"error":"No se recibio el id"}}';
		}		
	}
	
