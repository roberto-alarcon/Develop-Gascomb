<?php
/**************************************************************
* Clase: Maneja el ABC de los contractos
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
include_once 'class.models.php';
include_once 'class.brand_vehicle.php';

class VehicleMobiles
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("vehicles_record_id"=>"9");
	var $table = 'vehicles_record';
	var $primary = 'vehicles_record_id';
	
	
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
	function update($data,$plate){
			if (is_array($data)){
				$db = new manejaDB();	
                $this->updatewhere = array("registration_plate"=>$plate);			
				$result = $db->makeQueryUpdate($this->table,$data,$this->updatewhere);
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
	function getBrandd($brand_vehicular_id){
		$brandVehicle = new brandVehicle();				
		$brand = $brandVehicle->getBrand($brand_vehicular_id);
		return $brand["brand"];
	
	}
	
	function getModel($model_vehicular_id){
		$Models = new models;		
		$model = $Models->getModel($model_vehicular_id);
		
		if($model){		
			return $model["model"]." ".$model["type"];
		}else{
			return false;
		}
	}
	


}