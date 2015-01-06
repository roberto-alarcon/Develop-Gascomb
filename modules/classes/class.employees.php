<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Employee
{	

    var $errors= array();
	var $userdata = array();
	var $updatewhere = array("employee_id"=>"9");
	var $table = 'employees';
	var $primary = 'employee_id';
	
	
	/* Metodo insert: inserta un nuevo usuario*/
	function add($data){
			
			if (is_array($data)){				
				$db = new manejaDB();			
				$id = $db->makeQueryInsert($this->table,$data);
				$result = $this->selectbyId($id);
				$db->desconectar();
				return($result);           			
			}			
    }
	function update($data){
			if (is_array($data)){
				$db = new manejaDB();					
				$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
				$result = $this->selectbyId($this->updatewhere["employee_id"]);
				$db->desconectar();
				return($result);           			
			}	
               
    }
	
	function delete($id){ 
               //$this->db_consulta = mysql_query($query,$this->db_conexion); 
    }
	
	function selectbyId($id){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();	
			if (is_array($result)){
			
				foreach ($result as $clave => $valor) {
					if(is_numeric($clave)) { unset($result[$clave]); }		
				}
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
	
	function getRole($id){ 
            $db = new manejaDB();
			$db->query("select role from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();
			$result = ($result)? $result["role"] : false;				
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
	
	function selectRows($limit){
			$limit = isset($limit) ? $limit : 10;
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();						
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
			$db->query("select * from ".$this->table." ".$datos_where." order by name ASC limit $limit");
			$result = $db->getArrayAsoc();
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
    }
	function getMechanics(){			
            $db = new manejaDB();			
			$db->query("select * from ".$this->table." where role like '%mecanico%' order by name ASC");
			$result = $db->getArrayAsoc();						
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
    }
	
	function selectReceptors(){
				 $db = new manejaDB();			
			$db->query("SELECT employee_id,name, last_name FROM sistema_gascomb.employees
							where role like 'supervisor%'
							or role like 'lavador%'
							or role like 'asesor de servicio%'
							or role like 'control de calidad%'
							or role like 'administra%'
							or role like 'chofer%'
							or role like '%mecanico%';");
			$result = $db->getArrayAsoc();						
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
	}
	
	function getChiefMechanics(){
				 $db = new manejaDB();			
			$db->query("SELECT employee_id,name, last_name FROM sistema_gascomb.employees
							where role like 'jefe mecanicos%';");
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
	function validateinsert(){
		global $_REQUEST;
		$this->userdata["employee_id"]='null';
		if (isset($_REQUEST['name']) && $_REQUEST['name'] !== ''){
				$this->userdata["name"] = utf8_decode($_REQUEST['name']);
		}else{ $this->errors[] = 'No se recibio el parametro name'; }
		
		if (isset($_REQUEST['last_name']) && $_REQUEST['last_name'] !== ''){
				$this->userdata["last_name"] = utf8_decode($_REQUEST['last_name']);
		}else{ $this->errors[] = 'No se recibio el parametro last_name'; }
		
		if (isset($_REQUEST['role']) && $_REQUEST['role'] !== ''){
				$this->userdata["role"] = utf8_decode($_REQUEST['role']);
		}else{ $this->errors[] = 'No se recibio el parametro role'; }
		
		$this->userdata["access_requisition"] = $_REQUEST['access_requisition'];
		$this->userdata["requisition_pwd"] = $_REQUEST['requisition_pwd'];
		
		$this->userdata["creation_time"] = time();		
		$this->userdata["modification_time"] = time();
		$this->userdata["status"] = (isset($_REQUEST['status']) && $_REQUEST['status'] !== '')  ? $_REQUEST['status'] : '0';
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
	//Valida los parametros de entrada para insert
	function validateupdate(){
		global $_REQUEST;
		
		if (isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] !== ''){
				$this->updatewhere["employee_id"] = utf8_decode($_REQUEST['employee_id']);
		}else{ $this->errors[] = 'No se recibio el id del usuario'; }		
		
		if (isset($_REQUEST['name']) && $_REQUEST['name'] !== ''){
				$this->userdata["name"] = utf8_decode($_REQUEST['name']);
		}
		
		if (isset($_REQUEST['last_name']) && $_REQUEST['last_name'] !== ''){
				$this->userdata["last_name"] = utf8_decode($_REQUEST['last_name']);
		}
		
		if (isset($_REQUEST['nickname']) && $_REQUEST['nickname'] !== ''){
				$this->userdata["nickname"] = utf8_decode($_REQUEST['nickname']);
		}
		
		if (isset($_REQUEST['rol']) && $_REQUEST['rol'] !== ''){
				$this->userdata["rol"] = utf8_decode($_REQUEST['rol']);
		}
		
		$this->userdata["access_requisition"] = $_REQUEST['access_requisition'];
		$this->userdata["requisition_pwd"] = $_REQUEST['requisition_pwd'];
		
		$this->userdata["modification_time"] = time();
		$this->userdata["status"] = (isset($_REQUEST['status']) && $_REQUEST['status'] !== '')  ? $_REQUEST['status'] : '0';		
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
	
	public function getIDEmployeByCode( $code ){
	
		$db = new manejaDB();
		$db->query("SELECT employee_id FROM ".$this->table."
						where requisition_pwd = '".$code."';");
		$result = $db->getArrayAsoc();
		if($result){
			$result = $result;
		}else{
			$array_return = array();
			$array_return[0] = array('employee_id'=> 'False');
			$result = $array_return;
		}
		$db->desconectar();
		return($result);
	
	} 
}