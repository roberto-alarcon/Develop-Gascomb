<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'class.inventory_control.config.php';
include_once 'manejaDB.php';

class Suppliers
{	

    var $errors= array();
	var $supplierdata = array();
	var $updatewhere = array();
	var $primary = 'id_proveedor';

	
	/* Metodo insert: inserta un nuevo proveedor*/
	function add($data){
			if (is_array($data)){
				$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
				if($id = $db->makeQueryInsert(Table_Inventory_Suppliers,$data)){
					$result = $this->selectbyId($id);
					$db->desconectar();
					return($result);           		
				}				
				echo $db->mensaje();
			}			
    }
	function selectAll($limit){
					
            $db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
            $db->query("SELECT * FROM ".Table_Inventory_Suppliers." ORDER BY $this->primary DESC limit $limit");

			$result = $db->getArrayAsoc();	
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);
    }	
	function update($data){
			if (is_array($data)){
				$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
				$db->makeQueryUpdate(Table_Inventory_Suppliers,$data,$this->updatewhere);
				$result = $this->selectbyId($this->updatewhere["id_proveedor"]);
				$db->desconectar();
				return($result);           			
			}	
               
    }	
	function selectbyId($id){ 
            $db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$db->query("select * from ".Table_Inventory_Suppliers." where $this->primary = '".$id."'");
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

    function getName( $id ){
    	
    	$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
    	$db->query("select nombre from ".Table_Inventory_Suppliers." where $this->primary = '".$id."'");
    	$result = $db->getArray();
		$result = ($result)? $result["nombre"] : false;				
		$db->desconectar();
		return($result);
    	
    }
    
    
	/*
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
	
    /*
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
    */
	//Valida los datos de entrada para insert
	function validateinsert($datasupplier){
		$this->supplierdata["id_proveedor"]='null';
		if (isset($datasupplier['nombre']) && $datasupplier['nombre'] !== ''){
				$this->supplierdata["nombre"] = utf8_decode($datasupplier['nombre']);
		}else{ $this->errors[] = 'No se recibio el parametro nombre'; }
		
		if (isset($datasupplier['direccion']) && $datasupplier['direccion'] !== ''){
				$this->supplierdata["direccion"] = utf8_decode($datasupplier['direccion']);
		}else{ $this->errors[] = 'No se recibio el parametro direccion'; }
		
		if (isset($datasupplier['telefono']) && $datasupplier['telefono'] !== ''){
				$this->supplierdata["telefono"] = utf8_decode($datasupplier['telefono']);
		}else{ $this->errors[] = 'No se recibio el parametro telefono'; }		
		
		if (isset($datasupplier['correo']) && $datasupplier['correo'] !== ''){
				if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datasupplier['correo'])) {
					$this->errors[] = $datasupplier['correo'] . ": No es un mail valido";
				}else{
					$this->supplierdata["correo"] = htmlentities($datasupplier['correo']);
				}			
		}else{ $this->errors[] = 'No se recibio el parametro correo'; }
		
		
		$this->supplierdata["fecha_creacion"] = time();
		$this->supplierdata["status"] = (isset($datasupplier['status']) && $datasupplier['status'] !== '') ? $datasupplier['status'] : '0';
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}

	//Valida los parametros de entrada para insert
	function validateupdate($datasupplier){
		
		$this->supplierdata["id_proveedor"]='null';
		if (isset($datasupplier['nombre']) && $datasupplier['nombre'] !== ''){
				$this->supplierdata["nombre"] = utf8_decode($datasupplier['nombre']);
		}else{ $this->errors[] = 'No se recibio el parametro nombre'; }
		
		if (isset($datasupplier['direccion']) && $datasupplier['direccion'] !== ''){
				$this->supplierdata["direccion"] = utf8_decode($datasupplier['direccion']);
		}else{ $this->errors[] = 'No se recibio el parametro direccion'; }
		
		if (isset($datasupplier['telefono']) && $datasupplier['telefono'] !== ''){
				$this->supplierdata["telefono"] = utf8_decode($datasupplier['telefono']);
		}else{ $this->errors[] = 'No se recibio el parametro telefonp'; }		
		
		if (isset($datasupplier['correo']) && $datasupplier['correo'] !== ''){
				if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $datasupplier['correo'])) {
					$this->errors[] = $datasupplier['correo'] . ": No es un mail valido";
				}else{
					$this->supplierdata["correo"] = htmlentities($datasupplier['correo']);
				}			
		}else{ $this->errors[] = 'No se recibio el parametro correo'; }
		
		
		$this->supplierdata["status"] = (isset($datasupplier['status']) && $datasupplier['status'] !== '') ? $datasupplier['status'] : '0';
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
}
