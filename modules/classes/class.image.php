<?php
/**************************************************************
* Clase: Maneja el ABC de los contractos
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Image
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("image_id"=>"9");
	var $table = 'images';
	var $primary = 'image_id';
	
	
	/* Metodo insert: inserta un nuevo usuario*/
	function add($data){
			if (is_array($data)){
				$db = new manejaDB();			
				if($id = $db->makeQueryInsert($this->table,$data)){
					$result = $this->selectbyId($id);
					$db->desconectar();
					return($result);           		
				}				
				//echo $db->mensaje();
			}			
    }
	function update($data){
			if (is_array($data)){
				$db = new manejaDB();			
				$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
				$result = $this->selectbyId($this->updatewhere["image_id"]);
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
	
	function imageUpload($image, $directory){
			$file_name = $image['image_name'];
			$tmp_name = $image['tmp_name'];			
			$file_size =$image['size'];			
			if($file_size > 2097152){
				$errors[]='File size must be less than 2 MB';
			}			
			if(is_dir($directory)==false){
				mkdir("$directory", 0755,true);		// Create directory if it does not exist
			}
			if(is_dir("$directory/".$file_name)==false){
				move_uploaded_file($tmp_name,$directory.$file_name);
			}
						
    }

}