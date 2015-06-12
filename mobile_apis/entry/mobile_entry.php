<?php  
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.users.php';
	include_once PATH_CLASSES_FOLDER.'class.employees.php';
	
	$user = new Users;	
	$employee = new Employee;
		
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	
    if ($usuario != "" && $password != ""){
	
	    $result = $user->login($usuario, $password);
	
		if($result){
			$user = $result["email"];
			$user_id = $result["user_id"];
			$employee_id = $result["employee_id"];
			$employee_role = $employee->getRole($employee_id);
			$user_name = $result["name"].' '.$result["last_name"];
			
			$results['access'] = 'true';
			$results['user'] = $user;
			$results['user_id'] = $user_id;
			$results['user_name'] = $user_name;
			$results['employee_id'] = $employee_id;
			$results['employee_role'] = $employee_role;
			
			echo json_encode($results);
			
		}else{
			
			$results['access'] = 'false';
			echo json_encode($results);
			
		}
	} else {
		$results['access'] = 'false';
		echo json_encode($results);
	}	
?>