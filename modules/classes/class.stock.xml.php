<?php
// Clase encargada de armar arbol y elementos XML

include_once('class.stock.php');
Class Stock_XML extends Stock{

	var $stock_id = 0;
	
	public function __construct ($folio = 0){
		$this->folio = $folio;
		$this->getStockIDxml();
	}
	
	// Obtenemos el Folio asigando de la requisicion 
	public function getStockIDxml(){
		
		$db = new manejaDB();
        $query = "SELECT stock_id FROM ".$this->table_stock." where folio_id =".$this->folio.";";
        $db->query($query);
       
        if( $db->numLineas() != 0 ){
		
            while( $rows = $db->getArray() ){
                    
                    $this->stock_id = $rows['stock_id'];
                           		
                    
            }

        }
        
        $db->desconectar();
		
		
	}
	
	
	// Funcion para obtener el XML 
	public function doXMLFolio(){
		
		// Obtenemos en un arreglo todas las fechas 
		/*$arrayDates = $this->getAllDates(); */
		
		$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xml.="\n";		
		$xml.='<tree id="0">';
		$xml.="\n\t";
		//$xml.='<item text="Root - Activas ('.count($arrayDates).')" id="root" open="1" im0="lock.gif" im1="lock.gif" im2="iconSafe.gif" call="1" select="1">';
		$xml.='<item text="(Requisicion:'.$this->stock_id.' / Folio:'.$this->folio.')" id="'.$this->stock_id.'-'.$this->folio.'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
		$xml.="\n\t";
		/*
		foreach($arrayDates as $key => $rows){
			$txt_fecha = date('d/m/y H:i', $rows['creation_datetime']);
			$xml .='<item text="'.$txt_fecha.'" id="'.$this->folio.'-'.$rows['creation_datetime'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif"></item>';
			$xml.="\n\t";
		}
		*/
		$xml.='</item>';
		$xml.="\n";
		$xml.='</tree> ';
		
		
		echo $xml;
		
		//$this->makeDynamicTreeXml(true);
		
		
	}
	
	// Metodo para crear el arbol dinamico con todas las requisiciones pendientes
	/*
	 * El arbol solo debe la requisicion cuando el material:
	 * - esta autorizado 
	 * - Y se encuentra en algun estado diferente al pendiente
	 */
	
	public function doXML(){
		
		// Get all open requisitions.
		$array_tree = array();
		 
		 $db = new manejaDB();
		 $db->query("select * from ".$this->table_stock." where tree_active = '1'");
		 
		if( $db->numLineas() != 0 ){
	
			while( $rows = $db->getArray() ){
				$array_tree[] = array(
					'folio'=>$rows['folio_id'],
					'stock_id' => $rows['stock_id']
				);			
				
			}		
		}
		$db->desconectar();
		
		
		$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xml.="\n";		
		$xml.='<tree id="0">';
		$xml.="\n\t";
		$xml.='<item text="Root - Activas ('.count($array_tree).')" id="root" open="1" im0="lock.gif" im1="lock.gif" im2="iconSafe.gif" call="1" select="1">';
		$xml.="\n\t";
		
		foreach($array_tree as $indice => $value){
		
			if ( $this->checkActiveRequest($value['stock_id']) ){
			
				$xml.='<item text="(Requisicion:'.$value['stock_id'].' / Folio:'.$value['folio'].')" id="'.$value['stock_id'].'-'.$value['folio'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
				$xml.="\n\t";
				
				$xml.='</item>';
				$xml.="\n\t";
			
			}

		}
		
		$xml.='</item>';
		$xml.="\n";
		$xml.='</tree> ';
		
		print $xml;
	
	}
	
	
	/*
	Metodo encargado de verificar si existe elementos pendientes a entregar
	@String `stock_id`
	*/
	public function checkActiveRequest($stock_id){
	
		$regreso = false;
		$db = new manejaDB();
		$select = "select stock_id from ".$this->table_stock_details." where stock_id = '".$stock_id."' and status_auth = 1 and status not in (1)";
		$db->query($select);
		
		if( $db->numLineas() != 0 ){
			$regreso = true;
		}
		$db->desconectar();
		
		return $regreso;
	
	}
	
	
	
	public function getAllDates(){
	
		// Get all elements for ID	
		$array_tree = array();	 
		$db = new manejaDB();
		$select = "SELECT DISTINCT creation_datetime, stock_id
					FROM  stock_details 
					WHERE stock_id ='".$this->stock_id."' and status_auth = 1 order by creation_datetime DESC";
		
		
		$db->query($select);
		 
		if( $db->numLineas() != 0 ){
	
			while( $rows = $db->getArray() ){
				$array_tree[] = array(
					'creation_datetime'=>$rows['creation_datetime'],
					'stock_id'=>$rows['stock_id']
				);			
				
			}
		
			
			
		}
		$db->desconectar();
		return $array_tree;
	
	}
	
	

}


?>