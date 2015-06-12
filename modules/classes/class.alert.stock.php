<?php
/*****************************************************
Clase controladora de alertas para Almacen 
Roberto Alarcon 
roberto.alarcon@tours360.com.mx
15/10/2013
*******************************************************/

include_once('class.alert.php');
include_once('class.folio.php');
include_once('class.stock.php');

Class myAlert_Stock extends Alert {

	// Properties
	var $requisition_id;
	var $_users_asesores_dependencia	= array(
										36 => array( 5,14,9,10,13,8 ),			// ID usuario => array (ID dependencia)
										37 => array( 20,11,4,16,17,3,1,23,15 ),	// ID usuario => array (ID dependencia)
										21 => array( 6,2,22 )					// ID usuario => array (ID dependencia)
										);
										
	var $_users_stock_dependencia		= array(
										33 => array( 14,8,5,18,2,10,6,20 ),			// Daniel Murillo
										31 => array( 11,13,15,7,16,23,4,17,1 )	// Manuel Rodriguez					
										);
	
	
	// Methods
	function __construct ($folio_id = 0){
        $this->folio_id 	= $folio_id;
		$this->_code 		= '#stock';
		$folio = new Folio();
		$this->_info_folio	= $folio->selectbyId($this->folio_id);
		$requisition = new Stock();
		$this->requisition_id = $requisition->getStockId($this->folio_id);
				
	}
	
	/* Metodo para obtener el usuario de almacen por dependencia */
	public function getUserbyDependency(){
			
		$user_dependencia = 0;
		foreach( $this->_users_stock_dependencia as $usuario => $array_dependencia ){
		
			if( in_array( $this->_info_folio['dependency_id'] , $array_dependencia ) ){
				$user_dependencia = $usuario;
				break;
			}
		
		}
				
		return $user_dependencia;
	
	}
	
	/* Metodo para obtener la dependicia */
	public function getAsesorbyDependency(){
			
		$user_dependencia = 0;
		foreach( $this->_users_asesores_dependencia as $usuario => $array_dependencia ){
		
			if( in_array( $this->_info_folio['dependency_id'] , $array_dependencia ) ){
				$user_dependencia = $usuario;
				break;
			}
		
		}
				
		return $user_dependencia;
	
	}
	
	
	/* Metodo encargado de notificar al area de almencen 
	que se a solicitado un material */
	
	public function alertNewRequisition(){
	
		// Notificacion - Usuarios de Almacen
		$_usuario_alert = $this->getUserbyDependency();
		$this->_area_solicitud 	= 'Jefe de Piso';
		$mensaje = '#Solicitud de Material: La requisicion #'.$this->requisition_id.' con folio #'.$this->folio_id.' a solicitado material';
		
		if ( $_usuario_alert ) {
			
			$this->doAlert( $_usuario_alert , $mensaje );
		
		}
		
		// Notificacion - Asesores de servicio
		$_asesor_alert = $this->getAsesorbyDependency();
		$this->_area_solicitud 	= 'Jefe de Piso';
		$mensaje_asesor = '#Solicitud de Material: El folio #'.$this->folio_id.' a solicitado material y esta en espera de entrega';
		
		if ( $_asesor_alert ) {
			
			$this->doAlert( $_asesor_alert , $mensaje_asesor );
		
		}
		
	}
	
	/* Metodo para actualizar una solicitud hecha hacia almacen 
	se activa cuando se entrega el producto a piso */
	
	public function alertUpdateRequisition(){
	
		// Usuario de alamacen 
		$_usuario_alert = $this->getUserbyDependency();
		$this->updateAlert( $_usuario_alert , $this->_code , $this->folio_id );
		
		// Actualizar notificacion a asesor de servicio 
		$_asesor_alert = $this->getAsesorbyDependency();
		$this->updateAlert( $_asesor_alert , $this->_code , $this->folio_id );
	
	}
	

}

//$stock = new myAlert_Stock(28420);
//$stock->alertNewRequisition();
//$stock->alertUpdateRequisition();

?>