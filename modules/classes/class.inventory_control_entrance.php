<?php 

include_once 'class.inventory_control.php';
include_once 'class.users.php';

class InventoryControlEntrance extends InventoryControl{
	
	
	
	public function insert(){
		
		
		global $_POST;
		global $Gascomb;
		
		$user_id 	= $Gascomb->session_user_id();
		$items 		= (int)$_POST['numero'];
		$precio_unitarios = str_replace(",","",$_POST['precio_unitario']);
		$precio_total = $items * $precio_unitarios;
		$fecha 		= time();
		$proveedor = strtolower ( $_POST['proveedor'] );
		
		//Insertamos en informacion de la compra
		$data_info = array(
				'id_inventory_control'=> $this->id_inventory_control,
				'id_usuario' => $user_id,
				'proveedor'=> $proveedor,
				'datetime' => $fecha,
				'no_piezas' => $items,
				'c_unitario' => $precio_unitarios,
				'c_total' => $precio_total
					);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryInsert(Table_Inventory_entrance_info,$data_info);
		$db->desconectar();
		
		//Obtenemos cada uno de los valores
		$elements = $this->getValuesByID($this->id_inventory_control);
		
		for($i=0; $i<$items; $i++ ){
			
			$data = array(
					'id_inventory_control'=> $this->id_inventory_control,
					'id_usuario' => $user_id,
					'sku' => $elements[0]['sku'],
					'datetime' => $fecha,
					'costo' => $precio_unitarios
			
			);
			$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$db->makeQueryInsert(Table_Inventory_entrance,$data);
			
		}

		$db->desconectar();
		
		// Sumamos los items a la existencia
		$this->controlExistenciaSuma( $this->id_inventory_control , $items );
		
	}
	
	
	public function getAllEntranceById(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_entrance." where id_inventory_control = '".$this->id_inventory_control."' order by datetime DESC;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements; 
		
	}
	
	public function getAllEntranceById_info(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_entrance_info." where id_inventory_control = '".$this->id_inventory_control."' order by datetime DESC;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements; 
		
	}
	
	
	public function gridHistory(){
		
		$elements = $this->getAllEntranceById_info();
		$grid = '<rows>';
		
		$User = new Users();
		
		foreach ($elements as $item ){
				
			$grid .= '<row id="'.$item['id_inventory_control_entrance_info'].'">';
			$grid .= '<cell>'.date('d-m-Y H:i:s',$item['datetime']).'</cell>';
			$grid .= '<cell>'.ucwords( $User->getName($item['id_usuario']) ).'</cell>';
			$grid .= '<cell>'.$item['no_piezas'].'</cell>';
			$grid .= '<cell> '.ucwords ($item['proveedor']).'</cell>';
			$grid .= '<cell>$'.$item['c_unitario'].'</cell>';
			$grid .= '<cell>$'.$item['c_total'].'</cell>';
			$grid .= '</row>';
				
		}
		
		$grid.= '</rows>';
		
		return $grid;
		
		
	}
	
	
	
	
	
}

?>