<?php
/*****************************************************
Super Clase controladora de alertas y funciones generales 
Roberto Alarcon 
roberto.alarcon@tours360.com.mx
15/10/2013
*******************************************************/

include_once('manejaDB.php');
include_once('class.folio.php');
include_once('class.vehicles.php');
include_once('class.dependency.php');

Class Alert {

	var $folio_id;
	var $_tipo_de_combustible;
	var $_dependencia;
	var $_area_solicitud;
	var $_info_folio;
	var $_code;
	
	/* Metodo encargado de Generar las alertas */
	public function doAlert( $user_id , $msj ){
		$fecha = time();
		$data = array(
			'user_id'=>$user_id,
			'folio_id'=>$this->folio_id,
			'area'=>$this->_area_solicitud,
			'code'=>$this->_code,
			'status'=>0,
			'datetime'=>$fecha,
			'modification_datetime'=>$fecha,
			'message'=>$msj
		
		);
		
		if (is_array($data)){
			$db = new manejaDB();			
			if($id = $db->makeQueryInsert('alert',$data)){
				$result = $id;
				
				//return($result);           		
			}				
			$db->desconectar();
			$db->mensaje();
		}
	
	
	}
	
	/*Metodo para Actualizar update*/
	public function updateAlert( $user_id , $code , $folio_id ){
		
		$fecha = time();
		$array_data = array(
				    'status' => 1,
					'modification_datetime'=>$fecha 
				    );
		
		$array_where = array(
				     'folio_id' =>$folio_id,
				     'user_id' => $user_id,
				     'code' => $code
				     
				     );
		
		
		$db = new manejaDB();			
		$db->makeQueryUpdate('alert',$array_data,$array_where);
		$db->desconectar();
		
	}

}

?>