<?php
/**************************************************************
* Super clase cotizador 
*
* @access public 
* @since 02/04/2013  
**************************************************************/
include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';
include_once MODULES_CLASES_QUOTE.'class.quote.items.supplier.php';

Class Quote_Supplier{

	var $_guid 							= 0;
	var $_supplier_guid					= 0;
	var $_array_requisition 			= array();
	var $_array_supplier_info			= array();
	var $_array_supplier_items_info		= array();
	var $_table_size					= 1200;
	
	//Incializamos clase por GUID
	function __construct ($GUID = 0 , $Supplier_GUID = 0){
		$this->_guid = $GUID;
		$this->_supplier_guid = $Supplier_GUID;
				
		/** cargamos informacion de la requisicion **/
		$this->getRequisitionValues($this->_guid);
		/** cargamos informacion del proveedor **/
		$this->getSupplierValues($this->_supplier_guid);
		/** validaciones de la solicitud **/
		$this->validateRequest();
		
		
	}
	
	public function getRequisitionValues($guid){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote." where guid = '$guid';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			$this->_array_requisition = $rows = $db_stock->getArray();
			
		}
		$db_stock->desconectar();
	
	}
	
	public function getSupplierValues($guid){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where md5_id = '$guid';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			$this->_array_supplier_info = $rows = $db_stock->getArray();
			
		}
		$db_stock->desconectar();
	
	}
	
	
	public function validateRequest(){
	
		global $_GET;
		
		if(count($this->_array_requisition) == 0){
			die("<h1>No existe el numero de solicitud </h1>");
		
		}
		
		/** Validacion del proveedor **/
		
		if(!isset($_GET['item_supplier'])){
			die("<h1>No existe el parametro del proveedor </h1>");
		}
		
		if( count($this->_array_supplier_info) == 0){
			die("<h1>No existe el proveedor </h1>");
		}
		
		/** Validacion vigencia de la solicitud **/
		
		if($this->_array_requisition['time_set'] < time()){
			die("<h1>Esta solicitud caducado el ".date('d/m/Y H:i:s',$this->_array_requisition['time_set'])." </h1>");
		}
		
	
	}
	
	
	public function createFORM(){
	
		/** Obtenemos todos los elementos **/
		//$this->getArrayElementsBySupplier();
		$supplier_id = $this->getSupplierID();
		$request_quote_id = $this->getRequestQuoteID();
		$OBJItems = new ItemSupplierForm( $request_quote_id , $supplier_id);
		
		
		
		/** Header **/
		$this->supplierFormHeader();
		/** Boddy **/
		$this->supplierFormBody( $OBJItems );
		/** Footer **/
		$this->supplierFormFooter( $OBJItems );
		
	
	}
	
	public function supplierFormHeader(){
	
		$logo = '<img src="'.WEB_QUOTE_IMG.'logo.png">';
		$table = '<h2>Vigencia de la solicitud - '.date('d/m/Y H:i:s',$this->_array_requisition['time_set']).'</h2>';		
		$table .= '
			<table width="'.$this->_table_size.'px">
				<tr>
				<th>'.$logo.'</th>
				<th colspan=5>GRUPO AUTOMOTRIZ EN SERVICIOS DE COMBUSTIBLES, S.A. DE C.V.</th>
				</tr>
				<tr>
				<th width="150px">Nombre:</th>
				<td>'.$this->_array_supplier_info['name'].'</td>
				<th>Direccion:</th>
				<td>'.$this->_array_supplier_info['address'].'</td>
				<th>Telefono:</th>
				<td>'.$this->_array_supplier_info['phone1'].'</td>
				</tr>
				<tr>
				<th>Correo 1:</th>
				<td>'.$this->_array_supplier_info['mail_1'].'</td>
				<th>Correo 2:</th>
				<td>'.$this->_array_supplier_info['mail_2'].'</td>
				<th>Telefono 2:</th>
				<td class="cell_red">'.$this->_array_supplier_info['phone2'].'</td>
				</tr> 
			</table>';
			
		echo $table;
	
	}
	
	public function supplierFormBody( $OBJItems ){
	
		$header_table = '<table width="'.$this->_table_size.'px">
				<tr>
				<th width="150px">Nombre Responsable:</th>
				<td>'.$OBJItems->OwnerItem().' '.$OBJItems->canalItem().'</th>
				</tr></table>';
		
		echo $header_table;
		
		
		$total_row = $OBJItems->totalRows();
		
		$table = '
			<table width="'.$this->_table_size.'px">
				<tr>
				<th width="25px">Cant:</th>
				<th width="25px">Ui:</th>
				<th width="200px">Pieza / Parte:</th>
				<th width="300px">Marca:</th>
				<th width="350px">Comentarios:</th>
				<th>P Unitario:</th>
				<th>Total:</th>
				</tr>';
		
		for ($i = 0; $i <$total_row; $i++) {
			
			$table .= $OBJItems->quoteIDItem($i).'<tr>
				<td>'.$OBJItems->cantidadItem($i).'</th>
				<td>'.$OBJItems->uMedidaItem($i).'</th>
				<td>'.$OBJItems->imagenItem($i).' '.$OBJItems->parteItem($i).'</th>
				<td>'.$OBJItems->brandItem($i).'</th>
				<td>'.$OBJItems->comentariosItem($i).'</th>
				<td>'.$OBJItems->pUnitarioItem($i).'</th>
				<td>'.$OBJItems->totalItem($i).'</th>
				</tr>';
			
		}
		
				
		$table .= '</table>';
			
		echo $table;
	
	}
	
	public function supplierFormFooter( $OBJItems ){
	
		$table = '
			<table width="'.$this->_table_size.'px">
				<tr>
				<th width="1005px" align="right">Subtotal:</th>
				<td></th>
				</tr>
				<tr>
				<th align="right">Iva:</th>
				<td></th>
				</tr>
				<tr>
				<th align="right">Total:</th>
				<td></th>
				</tr>
				<tr>
				<th colspan=2 align="right">'.$OBJItems->enviarButton().' '.$OBJItems->restablecerButton().'</th>
				</tr>
				</table>';
				
		echo $table;
	
	
	}
	
	
	public function getSupplierID(){
		
		return $this->_array_supplier_info['support_suppliers_id'];
	
	}
	
	public function getRequestQuoteID(){
	
		return $this->_array_requisition['request_quote_id'];
	
	}
	
	

}

?>