<?php
/**************************************************************
* Clase: Extend, Maneja el ABC de las Ampliaciones
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
include_once 'class.folio.php';
include_once 'class.vehicles.php';
include_once 'class.dependency.php';

class Extend
{	

    var $errors= array();
	var $userdata = array();
	var $updatewhere = array("extend_id"=>"9");
	var $table = 'extends';
	var $primary = 'extend_id';
	
	
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
				$result = $this->selectbyId($this->updatewhere["extend_id"]);
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
	
	function sendmail($datas){
			$errors = false;
			$sender = $datas["sender"];
			if (isset($datas["receiber"])){
				$email = $datas["receiber"];
				//if (filter_var($email, FILTER_VALIDATE_EMAIL)) {		
					//Validacion cc
					if (isset($datas["cc"]) && $datas["cc"] !== ""){
						$emails = explode(",",$datas["cc"]);
						/*foreach($emails as $value){
								if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {						
									$errors = '{"return":"0","error":"el email: '.$value.' no es válido"}';
								}
						}*/
						$emails = implode(",",$emails);	
					}else{
						$emails = "";
					}
					//validacion titulo
					
					if(isset($datas["title"]) && $datas["title"] != ""){
						$title = $datas["title"];
					}else{
						$errors = '{"return":"0","error":"Titulo vacío"}';
					}
					if (isset($datas["message"]) && $datas["message"] !== ""){
						//$message = $datas["message"];
						ob_start();
						include 'mail_html.php';
						$message = ob_get_clean();
					}else{
						$errors = '{"return":"0","error":"Mensaje vacío"}';
					}
					
				//}else{		
					//$errors = '{"return":"0","error":"'.$email.' email no válido"}';
				//}	
			}else{
				$errors = '{"return":"0","error":"No se recibio destinatario"}';
			}

			//Si hubo error
			if($errors){
				$return = utf8_encode($errors);
			}else{
				//Enviar
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$cabeceras .= "Cc: $emails" . "\r\n";
				$cabeceras .= "From: $sender" . "\r\n";
				if(mail($email, $title, $message, $cabeceras)){
						$return = '{"return":"1"}';
				}else{
					$return = '{"return":"0","error":"Hubo un problema al enviar el mail, favor de volver a intentar"}';
				}
				
			}
			return $return;
	}	
}
