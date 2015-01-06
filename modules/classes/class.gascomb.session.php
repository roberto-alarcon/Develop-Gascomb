<?php
include_once('manejaDB.php');
Class Session{
	
	
	public function session_folio($folio = false){
		if($folio){
			$_SESSION['folio'] = $folio;
			return $_SESSION['folio'];
		
		}else{
			return $_SESSION['folio'];
		}
		
	}
	
	public function session_user_id(){
		return $_SESSION['active_user_id'];
	}
	
	public function session_user_name(){
		return $_SESSION['active_user_name'];
	}
	
	public function session_user_email(){
		return $_SESSION['active_user'];
	}
	
	public function session_employee_id(){
		return $_SESSION['active_employee_id'];
	}
	
	public function session_employee_role(){
		return $_SESSION['active_employee_role'];
	}
	
	public function session_profile(){
		return $_SESSION['user_profile'];
	}
	
	
	
}


?>