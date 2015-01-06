<?php 
/**************************************************************
* Clase: Control de inventarios
*
* @access public 
* @since 07/07/2014  
**************************************************************/

include_once 'class.inventory_control.php';
include_once 'class.stock.php';
include_once 'class.users.php';

class InventoryLink extends InventoryControl{
	
	var $stock_details_id;
	var $stock_id;
	var $checkbox = false;
	var $obj_stock;
	var $employee;
	var $jsonMessage = array(
								'existencia' => '{"code": 0,"msj": "El producto seleccionado no esta en existencia"}',
								'link' => '{"code": 1,"msj": "El vinculo del producto se creo correctamente"}',
								'entregado' => '{"code": 2,"msj": "El producto a sido actualizado"}',
							);
	
	public function __construct ($folio_id){
		
		$this->folio_id = $folio_id;
		$this->obj_stock = new Stock($folio_id);
	}
	
	public function jsonMessage(){
		
		
	}
	
	
	public function createLink(){
		
		global $Gascomb;

		$existencia = $this->getExistenciaID($this->id_inventory_control);
		$cantidad	= $this->obj_stock->getQuantityFromDetaisID($this->stock_details_id);
		$existencia = (isset( $existencia[0]['existencia'] )) ? $existencia[0]['existencia'] : 0;
		$cantidad	= (isset( $cantidad[0]['quantity'] )) ? $cantidad[0]['quantity'] : 0;
		
		if( $existencia >= $cantidad ){
			
			//Si esta el articulo dentro del inventario y hay en existencia
			$data = array(
					"folio_id" => $this->obj_stock->folio,
					"stock_id" => $this->obj_stock->getStockIdByDetails( $this->stock_details_id ),
					"stock_details_id" => $this->stock_details_id,
					"id_inventory_control" => $this->id_inventory_control,
					"cantidad" => $cantidad,
					"user_id" => $Gascomb->session_user_id(),
					"fecha_ingreso" => time(),
					"fecha_modificacion" => time()
					
			);
			
			$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
			$db->makeQueryInsert(Table_Inventory_Link,$data);
			$db->desconectar();
			
			// Actualizamos el status de la tabla stock
			$this->obj_stock->updateStockStatusLink($this->stock_details_id);
			
			echo $this->jsonMessage['link'];
			
			
			
		}else{
			
			// Notificamos que no tenemos producto en existencia
			echo $this->jsonMessage['existencia']; 
		}
		
		
		
	}
	
	public function getLinkElementByFolioID( $id ){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_Link." where id_inventory_control_link = '".$id."' order by fecha_ingreso DESC;";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	public function getLinkElementsByFolio(){
		
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		if($this->checkbox){
			$query = "SELECT * FROM ".Table_Inventory_Link." where stock_id = '".$this->stock_id."' and status = '0' order by fecha_ingreso DESC;";
		}else{
			$query = "SELECT * FROM ".Table_Inventory_Link." where stock_id = '".$this->stock_id."' order by fecha_ingreso DESC;";
		}
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
		
		$db->desconectar();
		return $elements;
		
	}
	
	
	public function gridLink(){
		
		$link_elements = $this->getLinkElementsByFolio();
		
		$grid = '<rows>';
		
		foreach( $link_elements as $element){
			//print_r( $element );
			// Obtenemos la informacion del almacen
			$almance_array = $this->getValuesByID($element['id_inventory_control']);
			
			//print_r($almance_array );
			
			$grid .= '<row id="'.$element['id_inventory_control_link'].'">';
			
			if($this->checkbox){
				$grid .= '<cell>'.$element['status'].'</cell>';
			}
			
			
			$grid .= '<cell>'.$almance_array[0]['producto'].'</cell>';
			$grid .= '<cell>'.$element['cantidad'].'</cell>';
			$grid .= '<cell>'.$almance_array[0]['tipo'].'</cell>';
			$grid .= '<cell>'.$almance_array[0]['sku'].'</cell>';
			$grid .= '<cell>'.$almance_array[0]['fila'].'</cell>';
			$grid .= '<cell>'.$almance_array[0]['anaquel'].'</cell>';
			$grid .= '<cell>'.$almance_array[0]['repisa'].'</cell>';
			$grid .= '</row>';	
		}
		
		$grid.= '</rows>';
		
		echo $grid;
		
		
	}
	
	public function updateLinkStatus($id_inventory_control_link, $fecha){
		
		// Update
		$data = array(
				'status'=> 1,
				'employee_auth_id'=> $this->employee,
				'fecha_modificacion' => $fecha
		);
		
		$where = array(
				'id_inventory_control_link'=>$id_inventory_control_link
				
		);
		
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$db->makeQueryUpdate(Table_Inventory_Link,$data,$where);
		$db->desconectar();
		
	}
	
	
	public function deliveryLink($list){
		
		$array_list = explode(',',$list);
		$fecha = time();
		
		if(count($array_list) > 0){
			
			foreach ($array_list as $id){
				
				$element = $this->getLinkElementByFolioID( $id );
				$cantidad = $element[0]['cantidad'];
				$existencia = $this->getExistenciaID($element[0]['id_inventory_control']);
				$existencia = (isset( $existencia[0]['existencia'] )) ? $existencia[0]['existencia'] : 0;
				
				if($existencia >= $cantidad){
					
					// Restamos un producto del control de existencia
					$this->controlExistenciaResta($element[0]['id_inventory_control'] , $cantidad);
					
					// Actualizamos el status del producto viculado
					$this->updateLinkStatus($id,$fecha);
					
				}
				
				
				
			}
			
			echo $this->jsonMessage['entregado'];
			
		}
		
		
		
		
	}
	
	public function getTreeElementsByFolio(){
	
		$elements = array();
		$db = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".Table_Inventory_Link." where folio_id = '".$this->folio_id."' and status = '1' order by fecha_modificacion DESC ;";
		
		$db->query($query);
	
		if( $db->numLineas() != 0 ){
			$elements = $db->getArrayAsoc();
		}
	
		$db->desconectar();
		return $elements;
	}
	
	
	public function createTreeEntregas(){
		
		$elements = $this->getTreeElementsByFolio();
		
		// Generamos la carpeta
		$array_dir = array();
		foreach ( $elements as $item ){
			
			$array_dir[] = $item['fecha_modificacion'];
			
		}
		
		$folders = array_unique($array_dir);
		
		
		
		$tree = '<?xml version="1.0" ?>';
		$tree.='<tree id="0">';
		foreach ( $folders as $folder){
			
			
				$tree.='<item id="'.$folder.'" text="'.date('d-m-Y H:i:s',$folder).'">'; 	
					
					foreach($elements as $element){
						
						if($element['fecha_modificacion'] == $folder){
							
							$product = $this->getValuesByID($element['id_inventory_control']);
							
							$tree.='<item id="'.$element['id_inventory_control'].'" text="'.$product[0]['producto'].'" />';
							
						}
						
					}
				
					
					
			$tree.='</item>';
		
			
		}
		
		$tree.='</tree>';
		print_r($tree);
		//print_r($elements);
		//print_r($folder);
		
		
	}
	
	
	
	
	
}


?>