<?php
/**************************************************************
* Clase: activities, Maneja el ABC de las notificaciones
*
* @access public 
* @since 01/04/2003 11:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Notifications
{
	var $table = 'notifications';
	var $primary = 'notification_id';	
	
	/* Metodo insert: inserta una notificacion*/
	function sendNotification($data){
		if (is_array($data)){
			$db = new manejaDB();
			if($id = $db->makeQueryInsert($this->table,$data)){
				//$result = $this->selectbyId($id);
				$db->desconectar();
				return (true);
			}				
			echo $db->mensaje();
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
	
	function selectbyUserId($id){ 
		$db = new manejaDB();
		$db->query("select * from ".$this->table." where user_id = '".$id."'");
		$gr=array();
		while($result = $db->getArray()){
			foreach ($result as $clave => $valor) {
				if(is_numeric($clave)) { unset($result[$clave]); }
			}
			array_push($gr,$result);
		}
		$db->desconectar();
		return($gr);
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
	
}