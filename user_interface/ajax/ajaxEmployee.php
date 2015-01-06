<?php
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.employees.php');	
	
	$Employee = new Employee;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
		$user_data["name"] = $_REQUEST['name'];
		$user_data["last_name"] = $_REQUEST['last_name'];
		$user_data["email"] = $_REQUEST['email'];
		$user_data["creation_time"] = time();
		$user_data["department"] = $_REQUEST['department'];
		$user_data["company"] = $_REQUEST['company'];
		//$user_data["password"] = $_REQUEST['password'];
		$user_data["profile"] = $_REQUEST['profile'];
		$user_data["status"] = $_REQUEST['status'];
		if($_REQUEST['access_requisition'] == "1"){
			$user_data["access_requisition"] = $_REQUEST['access_requisition'];
			$user_data["requisition_pwd"] = $_REQUEST['requisition_pwd'];
		}else{
			$user_data["access_requisition"] = "0";
			$user_data["requisition_pwd"] = "";
		}
		
		if ($Employee->validateinsert($user_data) == false){
			echo  '{"return":"0","data":['.json_encode($Employee->errors).']}';
		}else{
			$Employee = $Employee->add($Employee->userdata);		
			echo  '{"return":"1","data":['.json_encode($Employee).']}';		
		}
	}
		
	if (isset($_REQUEST['action']) and ($_REQUEST['action'] == 'get')){
		$id = $_REQUEST['id'];
		$userdata = $Employee->selectbyId($id);		
		$userdata["role"] = utf8_encode($userdata["role"]);
		$userdata["department"] = utf8_encode($userdata["department"]);
		$userdata["last_name"] = utf8_encode($userdata["last_name"]);
		$userdata["name"] = utf8_encode($userdata["name"]);
		echo json_encode($userdata);
		
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
		$user_data["name"] = $_REQUEST['name'];
		$user_data["last_name"] = $_REQUEST['last_name'];		
		$user_data["role"] = $_REQUEST['role'];
		$user_data["department"] = $_REQUEST['department'];
		$user_data["company"] = $_REQUEST['company'];
		$user_data["modification_time"] = time();
		$user_data["status"] = $_REQUEST['status'];
		if($_REQUEST['access_requisition'] == "1"){
			$user_data["access_requisition"] = $_REQUEST['access_requisition'];
			$user_data["requisition_pwd"] = $_REQUEST['requisition_pwd'];
		}else{
			$user_data["access_requisition"] = "0";
			$user_data["requisition_pwd"] = "";
		}
		
		$Employee->updatewhere = array("employee_id" =>$_REQUEST["id"]);
			$Employees = $Employee->update($user_data);		
			if($Employees){
				echo  '{"return":"1","data":['.json_encode($Employees).']}';		
			}else{
				echo  '{"return":"0","data":['.json_encode($Employees).']}';		
			}
			
		
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'disable'){
		if(isset($_REQUEST["id"]) && $_REQUEST["id"] !== ""){
			$Employee->updatewhere = array("employee_id" =>$_REQUEST["id"]);
			$status = array("status"=>"0");
			$empl = $Employee->update($status);
			echo  '{"return":"1","data":['.json_encode($empl).']}';		
		}else{
			echo  '{"return":"0","data":{"error":"No se recibio el id"}}';
		}		
	}
	

	