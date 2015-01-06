<?php 
include_once 'class.inventory_control.php';

class Adicional_Sevices extends InventoryControl{
	
	 
	public function __construct ($folio_id){
	
		$this->folio_id = $folio_id;
		
	}
	
	
	// Metodo para obtener los registros 
	public function getAllElementsByID(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Adicional_Services." where folio_id = '".$this->folio_id."'  order by fecha;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	public function getXML(){
		
		$elements = $this->getAllElementsByID();
		
		$grid = '<rows>';
		
		foreach ($elements as $item ){
				
					
			$grid .= '<row id="'.$item['id_aditional_services'].'">';
			$grid .= '<cell>'.date('d/m/Y H:i:s',$item['fecha']).'</cell>';
			$grid .= '<cell>'.utf8_decode($item['descripcion']).'</cell>';
			$grid .= '<cell>'.utf8_decode($item['autoriza']).'</cell>';
			$grid .= '<cell>$'.number_format($item['monto'],2).'</cell>';
			$grid .= '</row>';
				
		}
		
		$grid.= '</rows>';
		
		echo $grid;
		
		
	}
	
	public function addNewServices(){
		global $_POST;
		
		$data_info = array(
				'folio_id'=>$this->folio_id,
				'monto' => $_POST['Monto'],
				'fecha' => time(),
				'descripcion' => $_POST['Descripcion'],
				'autoriza' => $_POST['Autoriza']
				
					);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryInsert(Table_Adicional_Services,$data_info);
		$db->desconectar();
	}
	
	
}


?>