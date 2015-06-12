<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';

class Folio
{	



    var $errors= array();
	var $data = array();
	var $updatewhere = array("folio_id"=>"9");
	var $table = 'folios';
	var $primary = 'folio_id';
	
	
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
				$result = $this->selectbyId($this->updatewhere["folio_id"]);
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
				$result = false;
			}	
			$db->desconectar();
			return($result); 						
    }
	
	function getTower($id){
		$db = new manejaDB();
		$db->query("select tower from ".$this->table." where $this->primary = '".$id."'");
		
		$result = $db->getArray();
		$return="";
		if(!empty($result)){
			$return=$result["tower"];
			
		}
		else { die("folio ".$id." no encontrado"); }
		return $return;
	}
	
	function CheckIfExistFolio($id){ 
            $db = new manejaDB();
			$db->query("select folio_id from ".$this->table." where $this->primary = '".$id."'");
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
	
	function selectAll(){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC limit 100");
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
			$db->query("select * from ".$this->table." ".$datos_where." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();						
			$db->desconectar();
			return($result);
    }
	function getActivesFolios($limit){			
			$limit = ($limit)? $limit : 10;
            $db = new manejaDB();			
			$db->query("select * from ".$this->table." where support_status_id !='8' and support_status_id !='9' order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();						
			$db->desconectar();
			return($result);
    }

	//Valida los parametros de entrada para insert
	function validateinsert(){
		global $_REQUEST;
		unset($_REQUEST["action"]);
		foreach($_REQUEST as $key => $value){
			$this->data[$key] = $value;
		}
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}

	//obtiene un xml de las carpetas contenidas en multimedia
	function getxml_Multimedia($id_folio){
		$path = PATH_MULTIMEDIA_BASE."/".$id_folio."/";		
		echo "<?xml version='1.0' encoding='iso-8859-1'?>";
		echo "<tree id='0'>";
		echo "<item text='Raiz' id='root' open='1' im0='lock.gif' im1='lock.gif' im2='iconSafe.gif' call='1' select='1'>";
					echo $this->list_files($path);			
		echo "</item> </tree>";	
	}
	
	function list_files($path){
		if (is_dir($path)) { 
				  if ($dh = opendir($path)) { 
					 while (($file = readdir($dh)) !== false) { 
						if ($file!="." && $file!=".."){
						
							if (is_dir($path . $file)){
							
							   if (!preg_match("/^_/", $file)) {
								   echo "<item text='".$file."' id='".$file."' im0='folderClosed.gif' im1='folderOpen.gif' im2='folderClosed.gif'>";
									echo $this->list_files($path . $file . "/"); 
								   echo "</item>";
							   }
							   
							}else{
								echo "<item text='".$file."' id='".$file."' im0='leaf.gif' im1='book.gif' im2='leaf.gif'/>";
							}
						}	
					} 
				  closedir($dh); 
				  } 
		}
	}
	
}