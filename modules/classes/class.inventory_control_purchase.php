<?php 

include_once 'class.inventory_control.php';
include_once 'class.inventory_control_bills.php';
include_once 'class.suppliers.php'; 
include_once 'class.users.php';

class InventoryControlPurchase extends InventoryControl{

	
	var $id_purchase;
	
	
	// Metodo para insertar una compra
	public function insert(){
	
		global $_POST;
		global $Gascomb;
		
		$user_id 	= $Gascomb->session_user_id();
		$proveedor	= $_POST['proveedor'];
		$fecha 		= time();
		$items 		= (int)$_POST['numero'];
		
		try{
			//Insertamos en informacion de la compra
			$data_info = array(
					'id_inventory_control'=> $this->id_inventory_control,
					'id_proveedor' => $proveedor,
					'id_usuario'=> $user_id,
					'total_existencia' => $items,
					'fecha_ingreso' => $fecha,
					'status' => 1,
					'fecha_modificacion' => $fecha
			);
			
			$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$last_id = $db->makeQueryInsert(Table_Inventory_Purchase,$data_info);
			//echo $last_id;
			$db->desconectar();
			
			// Ingresamos los datos de facturacion 
			$factura = new InventoryControlBills();
			$factura->id_compra = $last_id;
			$factura->id_proveedor = $proveedor;
			$factura->fecha_ingreso = $fecha;
			$factura->insertBill();
			
			echo '{"return": 1}';
			
		}catch (Exception $e) {
			
			// Hubo un error al generar el insert
			echo '{"return": 0}';
			
		}
		
			
	}
	
	public function getIDInventarioByIdPurchase( $id_purchase ){
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT id_inventory_control FROM ".Table_Inventory_Purchase." where id_purchase = '".$id_purchase."' order by fecha_ingreso DESC;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	public function getAllPurchaseById(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_Purchase." where status = '1' and id_inventory_control = '".$this->id_inventory_control."' order by fecha_ingreso DESC;";
		$db->query($query); 
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	// Metodo para obtener el total de existencia de varios proveedores
	public function getExistenciaPurchaseById(){
	
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT total_existencia FROM ".Table_Inventory_Purchase." where status = '1' and id_inventory_control = '".$this->id_inventory_control."' order by fecha_ingreso DESC;";
		$db->query($query);
	
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
	
		$db->desconectar();
		return $elements;
	
	}
	
	// Metodo para obtener el total de existencia de 1 compra
	public function getExistencia(){
		
		$existencia = 0;
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT total_existencia FROM ".Table_Inventory_Purchase." where status = '1' and id_purchase = '".$this->id_purchase."' order by fecha_ingreso DESC;";
		$db->query($query);
	
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
	
		$db->desconectar();
		
		if(!empty($elements)){
			
			$existencia = intval($elements[0]['total_existencia']);	
			
		}
		
		return $existencia;
		
		
	}
	
	
	
	// Metodo para obtener el grid historico
	public function gridHistory(){
	
		$elements = $this->getAllPurchaseById();
		$grid = '<rows>';
		
		$User = new Users();
		$Proveedor = new Suppliers();
		$Factura = new InventoryControlBills();
		
	
		foreach ($elements as $item ){
	
			$Factura->id_compra = $item['id_purchase'];
			$Factura->loadItemsByCompra();
			
			$grid .= '<row id="'.$item['id_purchase'].'">';
			$grid .= '<cell>'.date('d-m-Y H:i:s',$item['fecha_ingreso']).'</cell>';
			$grid .= '<cell>'.ucwords( $User->getName($item['id_usuario']) ).'</cell>';
			$grid .= '<cell>'.$Factura->getCantidad().'</cell>';
			$grid .= '<cell> '.ucwords( $Proveedor->getName($item['id_proveedor']) ).'</cell>';
			$grid .= '<cell>$'.number_format($Factura->getPrecioUnitario(),2).'</cell>';
			$grid .= '<cell>$'.number_format($Factura->getPrecioTotal(),2).'</cell>';
			$grid .= '</row>';
	
		}
	
		$grid.= '</rows>';
	
		return $grid;
	
	
	}
	
	
	// Metodo encargado de obtener todas los items que esta disponibles dentro de una compra
	public function gridAvailableByID_Iventory(){
		
		$elements = $this->getAllPurchaseById();
		$Proveedor = new Suppliers();
		$Factura = new InventoryControlBills();
		
		$grid = '<rows>';
		foreach ($elements as $item ){
			
			$Factura->id_compra = $item['id_purchase'];
			$Factura->loadItemsByCompra();
			
			$existencia = intval($item['total_existencia']);
			if ($existencia > 0){
				
				$grid .= '<row id="'.$item['id_purchase'].'">';
				$grid .= '<cell> '.ucwords( $Proveedor->getName($item['id_proveedor']) ).'</cell>';
				$grid .= '<cell> '.$item['total_existencia'].'</cell>';
				$grid .= '<cell>$'.number_format($Factura->getPrecioUnitario(),2).'</cell>';
				$grid .= '<cell>'.$Factura->getNumeroFactura().'</cell>';
				$grid .= '</row>';
				
			}
			
		}
		
		$grid.= '</rows>';
		return $grid;
		
	}
	
	//Obtenemos todos los productos disponibles
	public function getTotalProductsById(){
		
		$elements = $this->getExistenciaPurchaseById();
		$total_existencia = 0;
		foreach ($elements as $item ){
			$existencia = intval($item['total_existencia']);
			$total_existencia = $total_existencia + $existencia;
				
		}
		
		return $total_existencia;
		
	}
	
	
}

?>