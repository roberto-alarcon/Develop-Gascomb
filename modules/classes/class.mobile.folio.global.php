<?php
/**************************************************************
* Clase: users, Maneja el ABC de Folios para moviles
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
* @modify 27/06/2015 12:54 p.m.
**************************************************************/
include_once 'class.mobile.folio.control.config.global.php';
include_once 'mobile_manejaDB.php';

class FoliosMobiles
{	

    var $errors= array();
	var $supplierdata = array();
	var $updatewhere = array();
    var $type_capture = "1";
	var $table = "folios";
	var $primary = "folio_id";
	var $data_gascomb = array();
	var $data_pts = array();
	
	function selectAllPending(){ 
            $this->data_gascomb = $this->selectGascomb();
			$this->data_pts = $this->selectPts();

			if ( ( is_array($this->data_gascomb) && count($this->data_gascomb) > 0 ) && ( is_array($this->data_pts) && count($this->data_pts) > 0 ) ){		  
			  
			  $result = array_merge($this->data_gascomb, $this->data_pts);

			} else {
			  
			  if ( is_array($this->data_gascomb) && count($this->data_gascomb) > 0 ){
			     $result = $this->data_gascomb;
			  } else if (is_array($this->data_pts) && count($this->data_pts) > 0 ){
			     $result = $this->data_pts;
			  } else {
			     $result = 0;
			  }

			}  

			return($result);						
    }
	
	public function selectGascomb(){ 
            $db = new manejaDB();
			$db->make_connDB(BD_DATABASE_GASCOMB);
			$db->query("select * from ".Table_Folios." where type_capture = '".$this->type_capture."'");
			
			$result = $db->getArrayAsoc(1);	
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);						
    }

	public function selectPts(){ 
            $db2 = new manejaDB();
			$db2->make_connDB(BD_DATABASE_PTS);
			$db2->query("select * from ".Table_Folios." where type_capture = '".$this->type_capture."'");
			
			$result = $db2->getArrayAsoc(2);	
			$result = ($result)? $result : false ;
			$db2->desconectar();
			return($result);						
    }	
	
	
    public function getDependency( $id, $c ){
            $dbd = new manejaDB();
			if ($c == 1){
				$dbd->make_connDB(BD_DATABASE_GASCOMB);
			}else if ($c == 2){
				$dbd->make_connDB(BD_DATABASE_PTS);
			}
			
			$dbd->query("select name from ".Table_Dependency." where dependency_id = '".$id."'");
			
			$result = $dbd->getArrayAsoc(0);	
			$result = ($result)? $result : false ;
			foreach ($result as $clave => $valor) {
				$res = $valor['name'];
			}			
			return($res);	
    	
    }	
	
    public function getUrlqrcode( $folio, $c ){
        if($c == 1){
			$url = "http://develop.gascomb.com/multimedia/";
		}else if($c == 2){
			$url = "http://cdn-p.gascomb.com/";
		}
		$urls = $url . $folio . "/_qrcode/qrcode.png";
		$fp = curl_init($urls);
		$ret = curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
		$ret = curl_setopt($fp, CURLOPT_TIMEOUT, 30);
		$ret = curl_exec($fp);
		$info = curl_getinfo($fp, CURLINFO_HTTP_CODE);
		curl_close($fp);
		
		if($info == 404){
			$result = "";
		}else{
			$result = $urls;
		}
		return($result);
    	
    }	
	

}
