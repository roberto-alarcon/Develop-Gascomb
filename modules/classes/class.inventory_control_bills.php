<?php 

include_once 'class.inventory_control.php';
include_once 'class.inventory_control_purchase.php';


class InventoryControlBills extends InventoryControl{

	var $id_compra;
	var $id_proveedor;
	var $fecha_ingreso;
	
	var $items;
	
	public function insertBill(){
	
		global $_POST;
		global $Gascomb;
		
		$total = (intval($_POST['numero']))*(floatval($_POST['precio_unitario']));
		
		$array_insert = array(
			'id_purchase' => $this->id_compra,
			'id_proveedor' => $this->id_proveedor,
			'tipo'=> $_POST['tipo_pago'],
			'cantidad'=>$_POST['numero'],
			'precio_unitario'=>$_POST['precio_unitario'] ,
			'precio_total'=>$total ,
			'no_factura'=>$_POST['no_factura'] ,
			'fecha_facturacion'=> $_POST['fecha_facturacion'],
			'fecha_ingreso'=> $this->fecha_ingreso,
			'fecha_modificacion'=> $this->fecha_ingreso,
			'code'=> $_POST['code']
				
		);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$last_id = $db->makeQueryInsert(Table_Inventory_Bills,$array_insert);
		//echo $last_id;
		$db->desconectar();
		
	}
	
	// Metodo encargado de generar un grid mediante el id del proveedor mas el numero de 
	// Factura
	public function gridBySupplierAndBill( $id_proveedor , $no_factura ){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_Bills." where id_proveedor = '".$id_proveedor."' and no_factura = '".$no_factura."';";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$grid = '<rows>';
		foreach ($elements as $item ){
		
			$Compra = new InventoryControlPurchase();
			$inventario =  $Compra->getIDInventarioByIdPurchase( $item['id_purchase'] );
			
			if(isset( $inventario[0]['id_inventory_control'] )){
				
				$control_inventarios = $this->getValuesByID( $inventario[0]['id_inventory_control'] );
				
				$grid .= '<row id="'.$item['id_purchase'].'">';
				$grid .= '<cell>'.$control_inventarios[0]['producto'].'</cell>';
				$grid .= '<cell>'.$item['cantidad'].'</cell>';
				$grid .= '<cell>'.date('d-m-Y',$item['fecha_facturacion']).'</cell>';
				$grid .= '<cell>$'.number_format($item['precio_unitario'],2).'</cell>';
				$grid .= '<cell>$'.number_format($item['precio_total'],2).'</cell>';
				$grid .= '</row>';
				
				
			}

		
		}
		
		$grid.= '</rows>';
		
		return $grid;
		
		print_r( $elements );
		
		$db->desconectar();
		
	}
	
	
	public function loadItemsByCompra( ){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_Bills." where id_purchase = '".$this->id_compra."';";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		$this->items = $elements;
		return $elements;
		
	}
	
	public function getCantidad(){
		
		return isset($this->items[0]['cantidad'])?$this->items[0]['cantidad'] : 'null';
		
	}
	
	public function getPrecioUnitario(){
		
		return isset($this->items[0]['precio_unitario'])?$this->items[0]['precio_unitario'] : 0;
		
	}
	
	public function getPrecioTotal(){
	
		return isset($this->items[0]['precio_total'])?$this->items[0]['precio_total'] : 0;
	
	}
	
	public function getNumeroFactura(){
		
		return isset($this->items[0]['no_factura'])?$this->items[0]['no_factura'] : 0;
		
	}
	
}

?>