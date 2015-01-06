<?php
/*****************************************************
Clase controladora de alertas para Jefes de piso y asesores de servicio
Roberto Alarcon 
roberto.alarcon@tours360.com.mx
02/09/2013
*******************************************************/

include_once('class.alert.php');

Class Alert_WorkFloor extends Alert{

	var $_users_gasolinar		= array(41);  // ID Usuarios Gasolina William
	var $_users_diesel			= array(50);  // ID Usuario Diesel Serafin	
	var $_users_dependencia		= array(
										36 => array( 5,14,9,10,13,8 ),			// ID usuario => array (ID dependencia)
										37 => array( 20,11,4,16,17,3,1,23,15 ),	// ID usuario => array (ID dependencia)
										21 => array( 6,2,22 )					// ID usuario => array (ID dependencia)
										);

	function __construct ($folio_id = 0){
        $this->folio_id 	= $folio_id;
		$this->_code 		= '#task';
		$folio = new Folio();
		$this->_info_folio	= $folio->selectbyId($this->folio_id);
   
	}
	
		
	/* Metodo encargado de verificar el tipo de combustible
	en base a un folio_id */
	public function getTypeOfFuel(){
	
		$vehicles = new Vehicle();		
		$info_vehicles = $vehicles->selectbyId($this->_info_folio['vehicles_record_id']);
		return strtolower ( $info_vehicles['fuel'] );
	}
	
	/* Metodo para obtener la dependicia */
	public function getUserbyDependency(){
			
		$user_dependencia = 0;
		foreach( $this->_users_dependencia as $usuario => $array_dependencia ){
		
			if( in_array( $this->_info_folio['dependency_id'] , $array_dependencia ) ){
				$user_dependencia = $usuario;
				break;
			}
		
		}
				
		return $user_dependencia;
	
	}
	
	public function getNameDependency(){
	
		$dependency = new dependency();
		$info_dependency = $dependency->selectbyId($this->_info_folio['dependency_id']);
		return $info_dependency['name'];
	
	}
	
	/* Actualizar Status tareas asiganadas */
	public function alertAssingTaskUpdate(){
		
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
				echo 'usuario gasolina';
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				echo 'usuario diesel';
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			//$this->doAlert( $user , $mensaje );
			$this->updateAlert( $user , $this->_code , $this->folio_id );
		
		}
		
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia = $this->getUserbyDependency();
				
		if( $user_dependencia != 0 ){
		
			
			$this->updateAlert( $user_dependencia , $this->_code , $this->folio_id );
		
			
					
		}
		
	}


	/* Alerta para asiganar tareas */
	public function alertAssingTask(){
		print 'entramos';
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		$this->_area_solicitud 	= 'Ingreso de Vehiculos';
		$mensaje = '#Asignacion de Tareas: El folio #'.$this->folio_id.' a ingresado a piso es necesario asignar tareas';
		
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			$this->doAlert( $user , $mensaje );
		
		}
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia = $this->getUserbyDependency();
		$mensaje_dependencia = '#Asignacion de Tareas: Acaba de entrar el vehiculo con folio #'.$this->folio_id.' que pertenece a la dependencia '.$this->getNameDependency().' y esta en espera de asignacion de tareas';
		
		if( $user_dependencia != 0 ){
		
			$this->doAlert( $user_dependencia , $mensaje_dependencia );
							
		}	
		 
	}
	
	
	/*
	Metodo encargado de notificar cuando cuando esta listo el material
	por parte del area de almacen 
	*/
	public function alertStock(){
	
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		$this->_area_solicitud 	= 'Almacen';
		$this->_code			= '#stock_floor';
		$mensaje = '#Entrega de material: El material del folio #'.$this->folio_id.' se encuentra listo, por favor pasa por el';
		
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			$this->doAlert( $user , $mensaje );
		
		}
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia 		= $this->getUserbyDependency();
		$this->_code			= '#stock_floor';
		$mensaje_dependencia 	= '#Entrega de material: El material del folio #'.$this->folio_id.' que pertenece a la dependencia '.$this->getNameDependency().' esta listo';
		
		if( $user_dependencia != 0 ){
		
			$this->doAlert( $user_dependencia , $mensaje_dependencia );
							
		}	
	
	
	}
	
	// Actualizamos la notificacion de Alamacen  
	public function alertStockUpdate(){
	
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		$this->_code			= '#stock_floor';
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
				echo 'usuario gasolina';
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				echo 'usuario diesel';
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			//$this->doAlert( $user , $mensaje );
			$this->updateAlert( $user , $this->_code , $this->folio_id );
		
		}
		
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia = $this->getUserbyDependency();
				
		if( $user_dependencia != 0 ){
		
			
			$this->updateAlert( $user_dependencia , $this->_code , $this->folio_id );
		
			
					
		}
	
	}
	
	
	/* Metodo encargado de alertar cuando hay material pendiente por aprobar*/
	public function alertPendingStockItems(){
	
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		$this->_area_solicitud 	= 'Mecanicos';
		$this->_code			= '#mech_floor';
		$mensaje = '#Autorizar Material: Se a solicitado material para el folio #'.$this->folio_id.' esta en espera de autorizacion';
		
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			$this->doAlert( $user , $mensaje );
		
		}
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia 		= $this->getUserbyDependency();
		$this->_code			= '#mech_floor';
		$mensaje_dependencia 	= '#Autorizar Material:Se a solicitado material para el folio #'.$this->folio_id.' que pertenece a la dependencia '.$this->getNameDependency().' esta en espera de autorizacion';
		
		if( $user_dependencia != 0 ){
		
			$this->doAlert( $user_dependencia , $mensaje_dependencia );
							
		}
		
		

	}

	/* Metodo para actualizar las notificaciones de autorizar material */
	public function alertUpdatePendingStockItems() {
	
		$_tipo_de_combustible 	= $this->getTypeOfFuel();
		$this->_code			= '#mech_floor';
		switch( $_tipo_de_combustible ){
		
			case 'gasolina':
				$list_user = $this->_users_gasolinar;
				break;
				
			
			case 'diesel':
				$list_user = $this->_users_diesel;
				break;
				
				
			default:
				$list_user = $this->_users_gasolinar;
				break;
			
		}
		
		// Mandamos alerta a los jefes de piso 
		foreach( $list_user as $user ){
		
			//$this->doAlert( $user , $mensaje );
			$this->updateAlert( $user , $this->_code , $this->folio_id );
		
		}
		
		
		//Mandamos Alerta a los asesores de servicio
		$user_dependencia = $this->getUserbyDependency();
				
		if( $user_dependencia != 0 ){
		
			
			$this->updateAlert( $user_dependencia , $this->_code , $this->folio_id );
		
			
					
		}
	
	}
	
	
	
	
	/*
	Metodo encargado de notificar cuando se a autorizado 
	una ampliacion 
	*/
	public function alertExtends(){
	
	
	}
	
	// Actualizamos la notificacion de Ampliaciones
	public function alertExtendsUpdate(){
	
	
	}	
	
	

}

//$alert = new Alert_WorkFloor(28414);
//$alert->alertPendingStockItems();
//$alert->alertUpdatePendingStockItems();



?>