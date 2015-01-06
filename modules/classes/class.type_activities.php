<?php
/**************************************************************
* Clase: Maneja el ABC de los contractos
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';

class Type_activities
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("support_type_activities_id"=>"9");
	var $table = 'support_type_activities';
	var $primary = 'support_type_activities_id';
	
	
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
				$result = $this->selectbyId($this->updatewhere["support_type_activities_id"]);
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
			foreach ($result as $clave => $valor) {
				if(is_numeric($clave)) { unset($result[$clave]); }		
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
	function selectRows($limit){
			$limit = isset($limit) ? $limit : 10;
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();						
			$db->desconectar();
			return($result);
    }
	/*
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
			$db->desconectar();
			return($result);
    }*/
	function selectbyColumn($where,$like=false, $limit){
		$limit = isset($limit) ? $limit : 10;
		if($like){
			$like = "like";
			$simbol = "%";
		}else{
			$like = "=";
			$simbol = "";
		}
		if($where){
			foreach($where as $apuntador => $v){
				$datos_[]=$apuntador." $like '".$v."$simbol'";
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

}