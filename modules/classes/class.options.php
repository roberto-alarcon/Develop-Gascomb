<?php
/**************************************************************
* Clase: Options, Llena los combos para autocompletarlos
*
* @access public 
* @since 06/01/2015  
**************************************************************/
include_once 'class.inventory_control.config.php';
include_once 'manejaDB.php';

class Options{
    
    
    // @ Methods
    function __construct (){
        
    }
    
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
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->query("select * from ".Table_Inventory_Suppliers." ".$datos_where." order by id_proveedor DESC limit $limit");
		$result = $db->getArrayAsoc();						
		$result = ($result)? $result : false ;
		$db->desconectar();
		return($result);
	}
    
    
}
    
?>