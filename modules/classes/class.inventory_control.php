<?php 
/**************************************************************
* Clase: Control de inventarios
*
* @access public 
* @since 07/07/2014  
**************************************************************/
include_once 'class.inventory_control.config.php';
include_once 'manejaDB.php';
include_once 'class.inventory_control_purchase.php';

class InventoryControl{
	
	var $tipo_almacen;
	var $sku;
	var $id_inventory_control;
	var $tipo;
	var $folio_id;
	
	public function getAllInventory(){
		
		
		switch ($this->tipo_almacen) {
	    
		case 'stock_off':
	        $query = "SELECT * FROM ".Table_Inventory." where id_almacen like '1%' and status = '0' order by tipo;";
	        break;
	    
	    default:
	        $query = "SELECT * FROM ".Table_Inventory." where id_almacen = '".$this->tipo_almacen."' and status = '1' order by tipo;";
	        break;
		}
		
		$elements = array(); 
        $db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
        $db->query($query);
        
        if( $db->numLineas() != 0 ){
        	$elements = $db->getArrayAsoc();
        }

        $db->desconectar();
        return $elements;
		
	}
	
	public function getElementsBySKU(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory." where sku= '".$this->sku."'  order by producto;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	public function getElementsByTipo(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory." where tipo like '%".$this->tipo."%'  order by producto;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	public function getValuesByID($id){
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory." where id_inventory_control = '".$id."';";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	public function getExistenciaID($id){
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT existencia FROM ".Table_Inventory." where id_inventory_control = '".$id."';";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	// Metodo encargado de controla la existencia de un producto 
	public function controlExistenciaSuma( $id_inventory_control , $items ){
		$actual = $this->getExistenciaID($id_inventory_control);
		$actual = (int)$actual[0]['existencia'];
		$items	= (int)$items;
		$total = $actual + $items;
		
		// Update
		$data = array(
				'existencia'=> $total
		);
		
		$where = array(
			'id_inventory_control'=>$id_inventory_control
		);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryUpdate(Table_Inventory,$data,$where);
		$db->desconectar();
	
	}
	
	// Metodo encargado de restar del control de un producto
	public function controlExistenciaResta( $id_inventory_control , $items ){
		$actual = $this->getExistenciaID($id_inventory_control);
		$actual = (int)$actual[0]['existencia'];
		$items	= (int)$items;
		$total = $actual - $items;
	
		// Update
		$data = array(
				'existencia'=> $total
		);
	
		$where = array(
				'id_inventory_control'=>$id_inventory_control
		);
	
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryUpdate(Table_Inventory,$data,$where);
		$db->desconectar();
	
	}
	
	
	public function addInventory(){
		global $_POST;
		$data = array(
				'id_almacen'=> $_POST['id_almacen'],
				'codigo_producto' => $_POST['codigo_producto'],
				'sku' => $_POST['sku'],
				'producto' => $_POST['producto'],
				'tipo' => $_POST['tipo'],
				'proveedor' => $_POST['proveedor'],
				'fila' => $_POST['fila'],
				'anaquel' => $_POST['anaquel'],
				'repisa' => $_POST['repisa'],
				'item_min' => $_POST['item_min'],
				'item_max' => $_POST['item_max'],
				'status' => $_POST['status']
		
		);
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryInsert(Table_Inventory,$data);
		$db->desconectar();
		
	}
	
	public function updateInventory( $id ){
		global $_POST;
		$data = array(
				'id_almacen'=> $_POST['id_almacen'],
				'codigo_producto' => $_POST['codigo_producto'],
				'sku' => $_POST['sku'],
				'producto' => $_POST['producto'],
				'tipo' => $_POST['tipo'],
				'proveedor' => $_POST['proveedor'],
				'fila' => $_POST['fila'],
				'anaquel' => $_POST['anaquel'],
				'repisa' => $_POST['repisa'],
				'item_min' => $_POST['item_min'],
				'item_max' => $_POST['item_max'],
				'status' => $_POST['status']
		
		);
		
		$where = array(
			'id_inventory_control'=>$id
		);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryUpdate(Table_Inventory,$data,$where);
		$db->desconectar(); 
		
		
	}
	
	public function gridInventory(){
		
		$elements = $this->getAllInventory();
		//print_r( $elements);
		$grid = '<rows>';
				
		foreach ($elements as $item ){
			$status = ($item['status'] == 1)?'Activo':'N/A';
			$Compra = new InventoryControlPurchase();
			$Compra->id_inventory_control = $item['id_inventory_control'];
			$existencia = $Compra->getTotalProductsById();
			
			$grid .= '<row id="'.$item['id_inventory_control'].'">';
			$grid .= '<cell>'.$item['codigo_producto'].'</cell>';
			$grid .= '<cell>'.$item['sku'].'</cell>';
			$grid .= '<cell>'.$item['producto'].'</cell>';
			$grid .= '<cell>'.$item['tipo'].'</cell>';
			$grid .= '<cell>'.$item['proveedor'].'</cell>';
			$grid .= '<cell>'.$item['fila'].'</cell>';
			$grid .= '<cell>'.$item['anaquel'].'</cell>';
			$grid .= '<cell>'.$item['repisa'].'</cell>';
			$grid .= '<cell>'.$existencia.'</cell>';
			$grid .= '<cell>'.$status.'</cell>';
			$grid .= '</row>';
			
		}
		
		$grid.= '</rows>';
		
		echo $grid;
		
	}
	
	public function gridInventoryByTipo(){
	
		$elements = $this->getElementsByTipo();
		$grid = '<rows>';
		
		foreach ($elements as $item ){
			
			
			$status = ($item['status'] == 1)?'Activo':'N/A';
			
			$grid .= '<row id="'.$item['id_inventory_control'].'">';
			$grid .= '<cell>'.$item['codigo_producto'].'</cell>';
			$grid .= '<cell>'.$item['sku'].'</cell>';
			$grid .= '<cell>'.$item['producto'].'</cell>';
			$grid .= '<cell>'.$item['tipo'].'</cell>';
			$grid .= '<cell>'.$item['existencia'].'</cell>';
			$grid .= '</row>';
			
		}
		
		$grid.= '</rows>';
		
		echo $grid;
	
	}
	
	public function gridInventoryBySku(){
		
		$elements = $this->getElementsBySKU();
		//print_r( $elements);
		$grid = '<rows>';
		
		foreach ($elements as $item ){
			$status = ($item['status'] == 1)?'Activo':'N/A';
				
			$grid .= '<row id="'.$item['id_inventory_control'].'">';
			$grid .= '<cell>'.$item['codigo_producto'].'</cell>';
			$grid .= '<cell>'.$item['sku'].'</cell>';
			$grid .= '<cell>'.$item['producto'].'</cell>';
			$grid .= '<cell>'.$item['proveedor'].'</cell>';
			$grid .= '<cell>'.$item['fila'].'</cell>';
			$grid .= '<cell>'.$item['anaquel'].'</cell>';
			$grid .= '<cell>'.$item['existencia'].'</cell>';
			$grid .= '<cell>'.$status.'</cell>';
			$grid .= '</row>';
				
		}
		
		$grid.= '</rows>';
		
		echo $grid;
		
		
	}
	
	
	
}


?>