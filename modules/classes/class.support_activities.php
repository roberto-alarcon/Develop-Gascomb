<?php
ini_set('display_errors', '1');
/**************************************************************
* Clase: activities, Maneja el ABC de las actividades
*
* @access public 
* @since 01/04/2003 11:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class SupportActivity
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("support_activity_id"=>"1");	
	var $table = 'support_activities';
	var $primary = 'support_activity_id';
	
	/* Metodo insert: inserta una nueva actividad de piso*/
	public function add($data){
		if (is_array($data)){
			$db = new manejaDB();
			if($id = $db->makeQueryInsert($this->table,$data)){				
				$result = $this->selectbyId($id);
				$db->desconectar();
				return($result);           		
			}else{
				echo $db->mensaje();	
			}				
			
		}			
    }

	function update($data){
		if (is_array($data)){
			$db = new manejaDB();			
			$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
			$result = $this->selectbyId($this->updatewhere["folio_id"]);
			$db->desconectar();
			return($result);           			
		}	
    }
	
	function delete($id){ 
		
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
	function getAll(){			
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC");
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


