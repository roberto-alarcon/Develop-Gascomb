<?php
/**************************************************************
* Clase: users, Maneja el ABC de Folios para moviles
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'class.mobile.folio.control.config.php';
include_once 'manejaDB.php';

class FoliosMobiles
{	

    var $errors= array();
	var $supplierdata = array();
	var $updatewhere = array();
    var $type_capture = "1";
	


	function selectAllPending(){ 
            $db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$db->query("select * from ".Table_Folios." where type_capture = '".$this->type_capture."'");
			
			$result = $db->getArrayAsoc();	
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);						
    }

    public function getUrlqrcode( $folio ){

		$url = "http://develop.gascomb.com/multimedia/".$folio."/_qrcode/qrcode.png";
		$fp = curl_init($url);
		$ret = curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
		$ret = curl_setopt($fp, CURLOPT_TIMEOUT, 30);
		$ret = curl_exec($fp);
		$info = curl_getinfo($fp, CURLINFO_HTTP_CODE);
		curl_close($fp);
		
		if($info == 404){
			$result = "";
		}else{
			$result = $url;
		}
		return($result);
    	
    }
	
    public function getDependency( $id ){

            $db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$db->query("select name from ".Table_Dependency." where dependency_id = '".$id."'");
			
			$result = $db->getArrayAsoc();	
			$result = ($result)? $result : false ;
			foreach ($result as $clave => $valor) {
				$res = $valor['name'];
			}			
			return($res);	
    	
    }

}
