<?php

// 	Clase controla log de acceso y los de usuarios
include_once('class.gascomb.session.php');
include_once('class.users.php');
Class Logs extends Session{
	
	
	
	public function log($mensaje){
	
		if(isset($_SESSION['folio'])){
		
			$result;
			$datos = array(
				'folio_id' 	=> $this->session_folio(),
				'datetime'	=> time(),
				'user_id'	=> $this->session_user_id(),
				'message'	=> $mensaje
				);
				
			if (is_array($datos)){
					$db = new manejaDB();			
					if($id = $db->makeQueryInsert('logs',$datos)){
						$result = $id;
						          		
					}				
					//echo $db->mensaje();
				}
				
			$db->desconectar();
			return($result); 
		
		}
		
	}
	
	
	public function systemLog($mensaje){
	
		if(isset($_SESSION['folio'])){
		
			$result;
			$datos = array(
				'folio_id' 	=> $this->session_folio(),
				'datetime'	=> time(),
				'user_id'	=> 0,
				'message'	=> $mensaje
				);
				
			if (is_array($datos)){
					$db = new manejaDB();			
					if($id = $db->makeQueryInsert('logs',$datos)){
						$result = $id;
						          		
					}				
					//echo $db->mensaje();
				}
				
			$db->desconectar();
			return($result); 
		
		}
		
	} 
	
	
	public function getLogsFolio(){
	
		$db = new manejaDB();
		$query = "SELECT * FROM logs where folio_id = '".$this->session_folio()."' order by datetime desc;";
		$db->query($query);
		
		$User = new Users();
		
		$array_log = array();
		if( $db->numLineas() != 0 ){
		
				while( $rows = $db->getArray() ){
					$array_log[] = array(
						'folio_id'=>$rows['folio_id'],
						'datetime' => date('d/m/Y h:i:s',$rows['datetime']),
						'user_id' => $rows['user_id'],
						'user_name' =>($rows['user_id'] == 0)?'log sistema':$User->getName($rows['user_id']),
						'message'=>  $rows['message']
					);			
					
				}
			
			
		}
		
		$db->desconectar();
		return $array_log;
		
	}
	
	public function getLogUser(){
	
	}

}



?>