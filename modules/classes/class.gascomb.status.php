<?php

include_once('class.gascomb.alerts.php');
include_once('class.alert.workfloor.php');
include_once('class.alert.stock.php');


Class Status extends Alerts{
	
	var $folio_id;
	var $status_id;
	var $nameStatus;

	public function createStatus($obj){
		
			$obj->create();
	}
	
	public function getStatusId($folio){
		
		$db = new manejaDB();
		$db->query("select support_status_id from folios where folio_id = '".$folio."'");
		$result = $db->getArray();	
		$result = ($result["support_status_id"])? $result["support_status_id"] : false;		
		$db->desconectar();
		return($result); 
	
	}
}

/**************************************** 
Status creado ID 1 
****************************************/
Class statusCreation extends Status{
	//
	var $status	= "1";
	var $message = "creado";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			//Update db
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			//log
			$Gascomb->systemLog("Se ha ".$this->message." un nuevo folio con #".$Gascomb->session_folio());		
			//alert no va			
		}
		
		
	}

}

/******************************************* 
Status pendiente asiganacion de tareas ID 2 
********************************************/
Class statusPendingAssignment extends Status{
	//
	var $status	= "2";
	var $message = "pendiente de asignación";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			//Log
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." esta en status ".utf8_decode($this->message));						
			$alerta = new Alert_WorkFloor($Gascomb->session_folio());
			$alerta->alertAssingTask();
			
		}
	}

}

/******************************************* 
Status tareas asiganadas en proceso ID 3 
********************************************/
Class statusTasksAssigment extends Status{

	var $status	= "3";
	var $message = "proceso";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			//Log
			$Gascomb->log("Se han agregado tareas al folio #".$Gascomb->session_folio()." el status se encuentra en ".utf8_decode($this->message));						
			
			$alerta = new Alert_WorkFloor($Gascomb->session_folio());
			$alerta->alertAssingTaskUpdate();
				
		}
	}

}

/*********************************************
 Status pendiente autorizacion de material ID 10
**********************************************/
Class statusPendingMaterial extends Status{

	var $status	= "10";
	var $message = "pediente por autorizar";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		//if($this->getStatusId($Gascomb->session_folio()) != $this->status){
		$db = new manejaDB();
		$where["folio_id"] = $Gascomb->session_folio();
		$set["support_status_id"] = $this->status;			
		$db->makeQueryUpdate('folios',$set,$where);
		$db->desconectar();
		//Log
		$Gascomb->systemLog("Se solicitado material para el folio #".$Gascomb->session_folio()." el status se encuentra en ".utf8_decode($this->message));						
		
		$alerta = new Alert_WorkFloor($Gascomb->session_folio());
		$alerta->alertPendingStockItems();
			
				
		//}
	}

}




/* Status Material entregado */

/* Status pendiete ampliacion */

/* Status ampliacion solicitada */

/* Status pendiente validacion de calidad */

/* Status calidad no cumple con lineamiento */

/* Status listo para la entega */

/* Status entergado */

/* Status cancelado */




Class statusProcess extends Status{
	//
	var $status	= "3";
	var $message = "proceso";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}	
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." se encuentra en ".utf8_decode($this->message));
			
			//Alert recepción a piso			
			$Recepcion 	= new Alert_Reception();
			$Piso		= new Alert_Floor();
			
			$Gascomb->Menssage = "El folio #".$Gascomb->session_folio()." se encuentra en proceso de reparación";
			$Gascomb->Area_Origin = $Piso;
			$Gascomb->Area_Request = $Recepcion;
			$Gascomb->folio_id = $Gascomb->session_folio();
			$Gascomb->doAlert();
			
			
		}
	}

}

/******************************************* 
Status solicitud de material almacen ID 4 
********************************************/
Class statusPendingRequisition extends Status{
	//
	var $status	= "4";
	var $message = "pendiente de requisición";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}	
		
	public function create(){
		global $Gascomb;
		
		//echo $Gascomb->getStatusId($Gascomb->session_folio());
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;	
				
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." se encuentra  ".utf8_decode($this->message));
			
			// Alerta
			$alerta = new Alert_WorkFloor($Gascomb->session_folio());
			$alerta->alertUpdatePendingStockItems();
			
			$alerta = new myAlert_Stock( $Gascomb->session_folio());
			$alerta->alertNewRequisition();
			
		}	
		
	}

}


/***************************************
 Status Material entregado en proceso 
****************************************/
Class statusStockAssigment extends Status{

	var $status	= "3";
	var $message = "proceso";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			//Log
			$Gascomb->log("Se han entregado el material del folio #".$Gascomb->session_folio()." el status se encuentra en ".utf8_decode($this->message));						
			
			// Alerta
			$alerta = new myAlert_Stock( $Gascomb->session_folio());
			$alerta->alertUpdateRequisition();
							
		}
	}

}



Class statusPendingExtends extends Status{
	//
	var $status	= "5";
	var $message = "pendiente de Ampliación";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){		
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." se encuentra  ".utf8_decode($this->message));
			
			//Alert recepción a piso			
			$Recepcion 	= new Alert_Reception();
			$Piso		= new Alert_Floor();
			
			$Gascomb->Menssage = utf8_decode("Se ha solicitado una ampliación de servicio para el vehiculo con folio #".$Gascomb->session_folio());
			$Gascomb->Area_Origin = $Piso;
			$Gascomb->Area_Request = $Recepcion;
			$Gascomb->folio_id = $Gascomb->session_folio();
			$Gascomb->doAlert();
			
		}
	}

}

Class statusQuality extends Status{
	//
	var $status	= "6";
	var $message = "calidad";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){			
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." se encuentra en proceso de  ".utf8_decode($this->message));
		}	
	}

}
Class statusDelivery extends Status{
	//
	var $status	= "7";
	var $message = "entrega";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){				
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." se encuentra en proceso de  ".utf8_decode($this->message));
		}
	}

}
Class statusCommitted extends Status{
	//
	var $status	= "8";
	var $message = "entregado";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." ha sido entregado");
		}
	}

}
Class statusCanceled extends Status{
	//
	var $status	= "9";
	var $message = "cancelado";
	
	public function __construct($folio){
		global $Gascomb;
		$Gascomb->session_folio($folio);
	}
		
	public function create(){
		global $Gascomb;
		if($this->getStatusId($Gascomb->session_folio()) != $this->status){
			$db = new manejaDB();
			$where["folio_id"] = $Gascomb->session_folio();
			$set["support_status_id"] = $this->status;			
			$db->makeQueryUpdate('folios',$set,$where);
			$db->desconectar();
			$Gascomb->systemLog("El folio #".$Gascomb->session_folio()." ha sido cancelado");
		}
	}

}


?>