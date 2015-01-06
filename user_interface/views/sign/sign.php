<?php
	session_start();
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once PATH_CLASSES_FOLDER.'class.users.php';
	include_once PATH_CLASSES_FOLDER.'class.employees.php';
	$user = new Users;	
	$employee = new Employee;
	$_POST = $_REQUEST;
	$usuario 	= $_POST['usuario'];
	$password	= $_POST['password'];
	
	$result = $user->login($usuario, $password);
	
	
	if($result){
		$_SESSION['active_user'] = $result["email"];
		$_SESSION['active_user_id'] = $result["user_id"];
		$_SESSION['active_user_group'] = $result["group"];
		$_SESSION['active_employee_id'] = $result["employee_id"];
		$_SESSION['active_employee_role'] = $employee->getRole($_SESSION['active_employee_id']);
		$_SESSION['active_user_name'] = $result["name"].' '.$result["last_name"];
		//$Gascomb->session_user_id = $result["user_id"];
		echo 'true';
	}else{
		echo 'false';
		session_destroy();
	}

?>