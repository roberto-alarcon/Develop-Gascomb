<?php
/**************************************************************
* Super clase controlado de compras
*
* @access public 
* @since 07/02/2014
roberto.alarcon.seo@gmail.com  
**************************************************************/
include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';

class Quote_Buy{

	var $Table_request_quote_items			= array();
	var $Table_request_quote_details_items	= array();
	var $_array_supplier_info				= array();
	var $request_quote_details				= 0;
	
	
	function __construct( $id = 0 ){
	
			$this->request_quote_id = $id;
			$this->queryRequestQuote();
			$this->queryRequestQuoteDetails();
			
					
	}
	
	public function getSupplierValuesByID($id){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			$this->_array_supplier_info = $rows = $db_stock->getArray();
			
		}
		$db_stock->desconectar();
	
	}
	
	public function queryRequestQuote(){
	
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
	
	
	public function queryRequestQuoteDetails(){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote_details." 
		where request_quote_id = '".$this->Table_request_quote_items["request_quote_id"]."'";
		//echo $query;
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->Table_request_quote_details_items[] = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
	
	
	}
	
	public function updateBuyStatus( $status = 0 ){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$data = array( 'buy_status' => $status);
		$where = array( 'request_quote_id'=>$this->request_quote_id );
		$db_stock->makeQueryUpdate(TABLE_request_quote,$data,$where);
		$db_stock->desconectar();
	
	}
	
	public function generarCompra(){
		
		// Actualizamos el estatus a Solicitamos compra
		$this->updateBuyStatus(2);
		
		// Mostramos lista de clientes y enviamos correo 
		foreach ( $this->getArrayClientes() as $proveedor ){
			
			$this->getSupplierValuesByID( $proveedor );
			//print_r($this->_array_supplier_info);
			echo '<br/><h3>'.$this->_array_supplier_info['name'].'</h3>';
			//echo 'Correo enviado<br/>';
			echo '<a href="'.PDF_PATH.'instance.pdf2.php?proveedor='.$proveedor.'&id_electronico='.$this->request_quote_id.'&folio='.$this->Table_request_quote_items['folio_id'].'" target="_blank">Formato de compra</a><br/>';
			echo '<p/>';
			
		}
	
	}
	
	public function verCompra(){
	
	
	}
	
	
	public function getArrayClientes(){
	
		//print_r( $this->Table_request_quote_details_items );
		$array_proveedores = array();
		foreach ( $this->Table_request_quote_details_items as $item => $value ){
			
			if($value['s1_buy']){
				$array_proveedores[] = $value['s1_id'];
			
			}
			
			if($value['s2_buy']){
				$array_proveedores[] = $value['s2_id'];
			
			}
			
			if($value['s3_buy']){
				$array_proveedores[] = $value['s3_id'];
			
			}
			
			if($value['s4_buy']){
				$array_proveedores[] = $value['s4_id'];
			
			}
			
			if($value['s5_buy']){
				$array_proveedores[] = $value['s5_id'];
			
			}
			
					
		}
		
		$proveedores = array_unique( $array_proveedores );
		return $proveedores;
	
	}
	

}

?>