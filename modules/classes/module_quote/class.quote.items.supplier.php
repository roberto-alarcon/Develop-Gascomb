<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';

class ItemSupplierForm{

	var $supplier_id				= 0;
	var $request_quote_id				= 0;
	var $_array_supplier_items_info			= array();
	var $Table_request_quote_items			= array();
	var $canal					= 0;
	var $requisition_id				= 0;
	
	function __construct ($request_quote_id = 0 , $supplier_id = 0 ){
		$this->request_quote_id = $request_quote_id;
		$this->supplier_id = $supplier_id;
		$this->getStockItemsbySupplierID();
		$this->encuentraCanal();
		$this->getRequestQuoteItems();
		
	
	}
	
	public function getStockItemsbySupplierID( ){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote_details." 
		where request_quote_id = '$this->request_quote_id' and (s1_id = '$this->supplier_id' OR s2_id = '$this->supplier_id' OR s3_id = '$this->supplier_id' OR s4_id = '$this->supplier_id' or s5_id = '$this->supplier_id');";
		//echo $query;
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->_array_supplier_items_info[] = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
	
	}
	
	public function getRequestQuoteItems(){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote." where request_quote_id = '".$this->request_quote_id."';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->Table_request_quote_items = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		
		
	}
	
	// Metodo para encontrar en que parrilla se encuentra el elemento para poder posicionar el apuntador
	public function encuentraCanal(){
		
		
		foreach ($this->_array_supplier_items_info as $value){
			
			if ( $value['s1_id'] == $this->supplier_id ){
				$this->canal = '1';
				break;
			}
			
			if ( $value['s2_id'] == $this->supplier_id ){
				$this->canal = '2';
				break;
			}
			
			if ( $value['s3_id'] == $this->supplier_id ){
				$this->canal = '3';
				break;
			}
			
			if ( $value['s4_id'] == $this->supplier_id ){
				$this->canal = '4';
				break;
			}
			
			if ( $value['s5_id'] == $this->supplier_id ){
				$this->canal = '5';
				break;
			}
			
			
			
			
		}
		
		
	}
	
	
	
	public function totalRows(){
		
		return count( $this->_array_supplier_items_info );
	
	}
	
	public function cantidadItem($indice){
	
		return $this->_array_supplier_items_info[$indice]['quantity'];
	
	}
	
	public function uMedidaItem($indice){
	
		return $this->_array_supplier_items_info[$indice]['unity'];
	
	}
	
	public function imagenItem($indice){
		
		$image_path = PATH_MULTIMEDIA_STOCK.date('Y',$this->Table_request_quote_items["time_request"]).'/'.$this->Table_request_quote_items["request_quote_id"].'/'.$this->_array_supplier_items_info[$indice]['stock_details_id'].'.jpg';
		$image_url = URL_MULTIMEDIA_STOCK.date('Y',$this->Table_request_quote_items["time_request"]).'/'.$this->Table_request_quote_items["request_quote_id"].'/'.$this->_array_supplier_items_info[$indice]['stock_details_id'].'.jpg';
		if(is_file($image_path)){
			return '<a href="'.$image_url.'" target="_blank">Ver imagen</a><br/>';
		}else{
			return "";		
		}		
		
		
		
		
	}
	
	public function parteItem($indice){
	
		return $this->_array_supplier_items_info[$indice]['description_part'];
	
	}
	
	
	public function quoteIDItem($indice){
		return '<input type="hidden" name="control[]" value="'.$this->_array_supplier_items_info[$indice]['request_quote_details_id'].'">';	
	}

	
	public function brandItem($indice){
		
		$item_value = 's'.$this->canal.'_brand';
		return '<input type="text" name="form_'.$this->_array_supplier_items_info[$indice]['request_quote_details_id'].'_brand" value="'.$this->_array_supplier_items_info[$indice][$item_value].'" size=40/>';
	
	}
	
	public function comentariosItem($indice){
		
		$item_value = 's'.$this->canal.'_comments';
		return '<textarea name="form_'.$this->_array_supplier_items_info[$indice]['request_quote_details_id'].'_comentarios"  COLS=40 ROWS=3>'.$this->_array_supplier_items_info[$indice][$item_value].'</textarea>';
	
	}
	
	public function pUnitarioItem($indice){
	
		$item_value = 's'.$this->canal.'_unit_price';
		return '$<input type="text" name="form_'.$this->_array_supplier_items_info[$indice]['request_quote_details_id'].'_punitario" value="'.$this->_array_supplier_items_info[$indice][$item_value].'" size=7/>';
	
	}
	
	public function totalItem($indice){
	
		$item_value = 's'.$this->canal.'_price';
		return '$<input type="text" name="form_'.$this->_array_supplier_items_info[$indice]['request_quote_details_id'].'_total" value="'.$this->_array_supplier_items_info[$indice][$item_value].'" size=7/>';
	}
	
	public function OwnerItem(){
	
		$item_value = 's'.$this->canal.'_owner_name';
		return '<input type="text" name="form_owner" value="'.$this->_array_supplier_items_info[0][$item_value].'" size=80/>';
	}
	
	public function canalItem(){
		return '<input type="hidden" name="canal" value="'.$this->canal.'">';	
	}
	
	public function enviarButton(){
		
		return '<input type="submit" value="Enviar cotizacion">';
	}
	
	public function restablecerButton(){
		
		return '<input type="reset" value="Limpiar">';
	}
	

}

?>
