<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';
include_once MODULES_CLASES_QUOTE.'class.bd.control-pay.php';

/* Clase controladora sobre los detalles del producto */
class Quote_Details{

	var $request_quote_details_id 			= 0;
	var $channel							= "";
	var $Table_request_quote_details_items	= array();
	
	function __construct ($request_quote_details_id = 0 , $channel = '' ){
	
		$this->request_quote_details_id = $request_quote_details_id;
		$this->channel = $channel;
		$this->getRequestQuoteDetailsItems();
	
	}
	
	public function getRequestQuoteDetailsItems(){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote_details." where request_quote_details_id = '".$this->request_quote_details_id."';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->Table_request_quote_details_items = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
	
	}
	
	public function doTable(){
	
		$table = "<table width=98%>
			<tr>
			<th colspan=2> Informacion de la solicitud </th>
			</tr>
			<tr>
			<th width=200px>ID:</td><td>".$this->Table_request_quote_details_items['request_quote_details_id']."</td>
			</tr>
			<tr>
			<th>Parte:</td><td>".$this->Table_request_quote_details_items['description_part']."</td>
			</tr>
			<tr>
			<th>Precio Unitario:</td><td>".number_format($this->Table_request_quote_details_items[$this->channel.'_unit_price'],2)."</td>
			</tr>
			<tr>
			<th>Total:</td><td>".number_format($this->Table_request_quote_details_items[$this->channel.'_price'],2)."</td>
			</tr>
			<tr>
			<th>Marca:</td><td>".$this->Table_request_quote_details_items[$this->channel.'_brand']."</td>
			</tr>
			<tr>
			<th>Comentarios:</td><td>".$this->Table_request_quote_details_items[$this->channel.'_comments']."</td>
			</tr>
			<tr>
			<th>Nombre del Responsable:</td><td>".$this->Table_request_quote_details_items[$this->channel.'_owner_name']."</td>
			</tr>
			<tr>
			<th>Fecha de la cotizacion:</td><td>".date('d/m/Y H:i:s',$this->Table_request_quote_details_items[$this->channel.'_time_request'])."</td>		
			</tr>
		</table>";
		
		echo $table;
	
	}

}


/* Clase controladora ventana de forma de pago */
Class Quote_Pay_Form{

	var $request_quote_id 			= 0;
	var $supplier_id				= 0;
	var $foma_de_pago				= 1;
	var $tipo_de_pago 				= array('credito'		=>0, 
											'cheque'		=>1,
											'transferencia' =>2,
											'efectivo'		=>3);
	var $request_tipo_de_pago		= 0;
	var $objBDControl_pay;
	
	
	function __construct ($request_quote_id = 0 , $supplier_id = 0 ){
		
		$this->request_quote_id = $request_quote_id;
		$this->supplier_id = $supplier_id;
		
		$this->objBDControl_pay = new BD_Control_Pay();
		$this->objBDControl_pay->request_quote_id = $this->request_quote_id;
		$this->objBDControl_pay->supplier_id = $this->supplier_id;
				
		
	}
	
	function creaFormulario(){
		$this->obtenerTipodePago();
		$this->doForm();
		
	}
	
	function actualizaFormulario(){
		
		
		if( $this->objBDControl_pay->revisarRegistro() ){
			
			$this->objBDControl_pay->updateBD( $this->request_tipo_de_pago );
			echo '{"result": 1}';
		
		}else{
			
			$this->objBDControl_pay->insertBD( $this->request_tipo_de_pago );
			echo '{"result": 1}';
			
		}
		
		
	}
	
	
	function obtenerTipodePago(){
		
		$this->foma_de_pago = $this->objBDControl_pay->obtenerTipodePago();
		
		
	}
	
	function doForm(){
		
		$check_credito = ($this->tipo_de_pago['credito'] == $this->foma_de_pago) ? 'checked' : '';
		$check_cheque = ($this->tipo_de_pago['cheque'] == $this->foma_de_pago) ? 'checked' : '';
		$check_transferencia = ($this->tipo_de_pago['transferencia'] == $this->foma_de_pago) ? 'checked' : '';
		$check_efectivo = ($this->tipo_de_pago['efectivo'] == $this->foma_de_pago) ? 'checked' : '';
		
		$table = "<table width=98%>
			<tr>
			<th colspan=2> Credito: </th>
			</tr>
			<tr>
			<th width=200px align='right'>Pago de credito:</td><td><input type='radio' name='pay' value='".$this->tipo_de_pago['credito']."' ".$check_credito." ></td>
			</tr>
			
			<tr>
			<th colspan=2> Contado </th>
			</tr>
			
			<tr>
			<th width=200px align='right'>Pago con cheque:</td><td><input type='radio' name='pay' value='".$this->tipo_de_pago['cheque']."' $check_cheque></td>
			</tr>
			
			<tr>
			<th width=200px align='right'>Pago con trasnferencia bancaria:</td><td><input type='radio' name='pay' value='".$this->tipo_de_pago['transferencia']."' $check_transferencia></td>
			</tr>
			
			<tr>
			<th width=200px align='right'>Pago en efectivo:</td><td><input type='radio' name='pay' value='".$this->tipo_de_pago['efectivo']."' $check_efectivo></td>
			</tr>
			
			<tr>
			<th colspan=2 align='right'> <input type='button' value='Guardar' onclick='javascript:SaveForm()'> </th>
			</tr>
			
		</table>
		<input type='hidden' name='supplier' value='".$this->supplier_id."'>
		<input type='hidden' name='request_quote_id' value='".$this->request_quote_id."'>
		
		";
		
		echo $table;
		
	
	}
	
	
	
	

}



