<?php
/*
Clase controladora de la tabla control-pay
Gestionara el tipo de pago dentro del sistema
Roberto Alarcon Garcia
roberto.alarcon@tours360.com.mx
version 1.0
*/

// @importamos clases
include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';

Class BD_Control_Pay{
	
	protected $table 				= 'control_pay';
	public $request_quote_id 		= 0;
	public $supplier_id				= 0;
	protected $tipo_de_pago 		= array (0		=>'credito', 
											1		=>'cheque',
											2 		=>'transferencia',
											3		=>'efectivo');
	
	
	
	// Metodo encargado de verificar si ya existe el registro 
	public function revisarRegistro(){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT type_pay FROM ".$this->table." where request_quote_id = '".$this->request_quote_id."' and supplier_id = '".$this->supplier_id."' ;";
		$db_stock->query($query);
		if( $db_stock->numLineas() != 0 ){
			
			$return = true;
		}else{
			
			$return = false;
		}
		
		return $return;
		
	}
	
	
	// Metodo encargado de regresar el tipo de pago (int)
	public function obtenerTipodePago(){
		
		$return = 0;
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT type_pay FROM ".$this->table." where request_quote_id = '".$this->request_quote_id."' and supplier_id = '".$this->supplier_id."' ;";
		$db_stock->query($query);
		if( $db_stock->numLineas() != 0 ){
				
			 $rows = $db_stock->getArray();
			 $return = $rows['type_pay']; 
				
		}
	
		$db_stock->desconectar();
		return $return;
	
	}
	
	
	// Metodo encargado de entregar la etiqueta del tipo de pago
	public function labelTipodePago( $type ){
		
		return ( $this->tipo_de_pago[$type] );
		
	}
	
	// Metodo encargado de insert el registro 
	public function insertBD( $pago ){
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$data = array( 	'type_pay' => $pago,
						'request_quote_id'=>$this->request_quote_id , 
						'supplier_id' => $this->supplier_id,
						'modification_date' => time());
		$db_stock->makeQueryInsert($this->table,$data);
		$db_stock->desconectar();
		
	}
	
	// Metodo encargado de actualizar el registro 
	public function updateBD( $pago ){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$data = array( 'type_pay' => $pago,
						'modification_date' => time());
		$where = array( 'request_quote_id'=>$this->request_quote_id , 
						'supplier_id' => $this->supplier_id
						);
		$db_stock->makeQueryUpdate($this->table,$data,$where);
		$db_stock->desconectar();
		
		
	}
	
} 



?>