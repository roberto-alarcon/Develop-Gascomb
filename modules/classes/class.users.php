<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Users
{	

    var $errors= array();
	var $userdata = array();
	var $updatewhere = array("user_id"=>"9");
	var $table = 'users';
	var $primary = 'user_id';
	var $groups = array(
		'group1' => 1, // Mecanicos / Recepcion
		'group2' => 2, // Almancen
		'group5' => 5  // Administrador
	);
	
	
	/* Metodo insert: inserta un nuevo usuario*/
	function add($data){
			if (is_array($data)){
				$db = new manejaDB();			
				if($id = $db->makeQueryInsert($this->table,$data)){
					$result = $this->selectbyId($id);
					$db->desconectar();
					return($result);           		
				}				
				echo $db->mensaje();
			}			
    }
	function update($data){
			if (is_array($data)){
				$db = new manejaDB();			
				$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
				$result = $this->selectbyId($this->updatewhere["user_id"]);
				$db->desconectar();
				return($result);           			
			}	
               
    }
	function delete($id){ 
               //$this->db_consulta = mysql_query($query,$this->db_conexion); 
    }
	function login($user, $password){
		if (empty($user) || empty($password)) {
			$user 		= '###';
			$password 	= '###';
		}
		$where["email"] = $user;
		$where["password"] = md5($password);
		$result = $this->selectbyColumn($where,1); 
		$result1 = ($result)? $result[0] : false ;
		$result = ($result1["status"] == "1")? $result1 : false ;
		return($result);
	}
	
	function selectbyId($id){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();
			if($result){
				foreach ($result as $clave => $valor) {
					if(is_numeric($clave)) { unset($result[$clave]); }		
				}
			}else{
				$result = false;
			}
			$db->desconectar();
			return($result); 						
    }
	
	function getName($id){ 
            $db = new manejaDB();
			$db->query("select name, last_name from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();
			$result = ($result)? $result["name"]." ".$result["last_name"] : false;				
			$db->desconectar();
			return($result); 						
    }
	function getProfile($id){ 
            $db = new manejaDB();
			$db->query("select profile from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();
			$result = ($result)? $result["profile"] : false;				
			$db->desconectar();
			return($result); 						
    }
	
	function selectAll(){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC limit 100");
			$result = $db->getArray();
			foreach ($result as $clave => $valor) {
				if(is_numeric($clave)) { unset($result[$clave]); }		
			}			
			$db->desconectar();
			return($result);
    }
	
	function selectbyColumn($where, $limit){
			$limit = isset($limit) ? $limit : 10;			
			if($where){
				foreach($where as $apuntador => $v){
					$datos_[]=$apuntador." ='".$v."'";
				}
					$datos_where = " where ";
					$datos_where .= implode(" AND ",$datos_);		
			}else{
				$datos_where = '';
			}
			
            $db = new manejaDB();			
			
			$db->query("select * from ".$this->table." ".$datos_where." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();	
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);
    }
	function getChiefMechanics(){
				 $db = new manejaDB();			
			$db->query("SELECT user_id,name, last_name FROM sistema_gascomb.users
							where profile like 'jefe mecanicos%';");
			$result = $db->getArrayAsoc();						
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
	}

	//Valida los parametros de entrada para insert
	function validateinsert($datauser){
		$this->userdata["user_id"]='null';
		if (isset($datauser['name']) && $datauser['name'] !== ''){
				$this->userdata["name"] = utf8_decode($datauser['name']);
		}else{ $this->errors[] = 'No se recibio el parametro name'; }
		
		if (isset($datauser['last_name']) && $datauser['last_name'] !== ''){
				$this->userdata["last_name"] = utf8_decode($datauser['last_name']);
		}else{ $this->errors[] = 'No se recibio el parametro last_name'; }
		
		if (isset($datauser['email']) && $datauser['email'] !== ''){
				if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datauser['email'])) {
					$this->errors[] = $datauser['email'] . ": No es un mail valido";
				}else{
					$this->userdata["email"] = htmlentities($datauser['email']);
				}			
		}else{ $this->errors[] = 'No se recibio el parametro email'; }
		
		if (isset($datauser['password']) && $datauser['password'] !== ''){
				$this->userdata["password"] = md5($datauser['password']);
		}else{ $this->errors[] = 'No se recibio el parametro password'; }
		
		$this->userdata["creation_time"] = time();
		
		$this->userdata["profile"] = (isset($datauser['profile']) && $datauser['profile'] !== '')  ? $datauser['profile'] : 'Recepcion';
		$this->userdata["status"] = (isset($datauser['status']) && $datauser['status'] !== '')  ? $datauser['status'] : '0';
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
	//Valida los parametros de entrada para insert
	function validateupdate($datauser){
		
		if (isset($datauser['id']) && $datauser['id'] !== ''){
				$this->updatewhere["user_id"] = utf8_decode($datauser['id']);
		}else{ $this->errors[] = 'No se recibio el id del usuario'; }		
		
		if (isset($datauser['name']) && $datauser['name'] !== ''){
				$this->userdata["name"] = utf8_decode($datauser['name']);
		}
		
		if (isset($datauser['last_name']) && $datauser['last_name'] !== ''){
				$this->userdata["last_name"] = utf8_decode($datauser['last_name']);
		}
		
		if (isset($datauser['email']) && $datauser['email'] !== ''){
				if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datauser['email'])) {
					$this->errors[] = $datauser['email'] . ": No es un mail valido";
				}else{
					$this->userdata["email"] = htmlentities($datauser['email']);
				}			
		}
		
		if (isset($datauser['password']) && $datauser['password'] !== ''){
				$this->userdata["password"] = md5($datauser['password']);
		}
		
		if (isset($datauser['profile']) && $datauser['profile'] !== ''){
				$this->userdata["profile"] = $datauser['profile'];
		}
		if (isset($datauser['status']) && $datauser['status'] !== ''){
				$this->userdata["status"] = $datauser['status'];
		}
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
}