<?php
/**************************************************************
* Clase: Maneja el ABC de los contractos
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Contract
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("contract_id"=>"9");
	var $table = 'contracts';
	var $primary = 'contract_id';
	
	
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
				$result = $this->selectbyId($this->updatewhere["contract_id"]);
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

    function selectbyIdArray( $id ){
    	$elements = array();
    	$db = new manejaDB();
    	$db->query("select * from ".$this->table." where dependency_id = '".$id."'");
    	 
    	if( $db->numLineas() != 0 ){
    		$elements = $db->getArrayAsoc();
    	}
    	 
    	$db->desconectar();
    	return $elements;
    	 
    }
    

	function selectAll($limit){
			$limit = isset($limit) ? $limit : 50;
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
	function selectbyDependency($id_dep){
			$id_dep = isset($id_dep) ? $id_dep : 10;
            $db = new manejaDB();
			$db->query("select * from ".$this->table." where dependency_id = ".$id_dep."; ");
			$result = $db->getArrayAsoc();			
			if ($result){
				$result = $result;
			}else{
				$result = 0;
			}			
			$db->desconectar();
			return($result);
    }
    
    function gridContratos($id){
    	
    	$elements = $this->selectbyIdArray($id);
    	//print_r($elements);
    	
    	$grid = '<rows>';
    	 
    	foreach( $elements as $element){
    	
    		 
    		$grid .= '<row id="'.$element['contract_id'].'">';
    		$grid .= '<cell>'.utf8_encode ( $element['contract_number'] ).'</cell>';
    		$grid .= '<cell>'.utf8_encode ( $element['validity'] ).'</cell>';
    		$grid .= '</row>';
    	}
    	 
    	$grid.= '</rows>';
    	echo $grid;
    	
    }

}