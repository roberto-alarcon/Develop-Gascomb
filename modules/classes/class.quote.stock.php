<?php

include_once 'class.stock.php';

/**********************
* Extendemos la clase de Stock
***********************/

Class Stock_Quote extends Stock{
	
	public function quoteArrayProducts(){
	
		$arrayReturn = array();
		$db = new manejaDB();
		$select = 'SELECT 
					'.$this->table_stock_details.'.stock_details_id,
					'.$this->table_stock_details.'.stock_id,
					'.$this->table_stock_details.'.quantity,
					'.$this->table_stock_details.'.status,
					'.$this->table_stock_details.'.delivery_datetime,
					'.$this->table_stock_details.'.delivery_user_id,
					'.$this->table_stock_details.'.request_user_id,
					'.$this->table_stock_details.'.comments,
					'.$this->table_stock_products.'.product,
					'.$this->table_stock_products.'.code_product


					FROM '.$this->table_stock_details.'
					INNER JOIN '.$this->table_stock_products.'
					ON '.$this->table_stock_details.'.support_stock_product_id='.$this->table_stock_products.'.support_stock_product_id
					
					WHERE
					'.$this->table_stock_details.'.stock_id = "'.$this->stock_id.'"';
		
		
                $db->query($select);
		if( $db->numLineas() != 0 ){
		
			while( $rows = $db->getArray() ){
				
				$arrayReturn[] = $rows;
				
			}
	    
		}
		
		$db->desconectar();
		
		return $arrayReturn;
	
	}
	
}


?>

