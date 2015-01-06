<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Inventory
{	

    var $errors= array();
	var $userdata = array();
	var $updatewhere = array("inventory_id"=>"9");
	var $table = 'inventory';
	var $primary = 'inventory_id';
	
	
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
				$result = $this->selectbyId($this->updatewhere["inventory_id"]);
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
			if($result){
				foreach ($result as $clave => $valor) {
					if(is_numeric($clave)) { unset($result[$clave]); }		
				}
			}else{
				$result = "";
			}
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

	//Valida los parametros de entrada para insert
	function validateinsert(){
		global $_REQUEST;
		
		
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
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
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
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
    }
}