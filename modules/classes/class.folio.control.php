<?php
/*
Clase encargada de controlar los procesos y dependencias externas 
*/
include_once('class.checklist.php');
include_once('class.stock.php');
class folioControl{

	var $folio_id;
	var $stock_id;
	var $checklist_folio_id;
	var $obj_cheklist;
	var $obj_stock;
	
	// @ Methods
    function __construct ($folio = 0){
        $this->folio_id = $folio;
		$this->obj_obj_stock	= new Stock($this->folio_id);
		$this->obj_cheklist		= new Checklist($this->folio_id);	
    }
	
	//Metodo para cargar stock
	public function fnStock(){
		
		return $this->obj_obj_stock->createNewRequisition();	
	
	}
	
	//Metodo para cargar checklist 
	public function fnChecklistFolio($activity){
		
		return $this->obj_cheklist->insertChecklistItem($activity);
		
		
	}

}


?>