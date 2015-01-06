<?php
/**************************************************************
* Clase para generar formato de compra en PDF  
*
* @access public 
* @since 02/04/2013  
**************************************************************/
include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';
include_once MODULES_CLASES.'html2pdf/html2pdf.class.php';
include_once MODULES_CLASES_QUOTE.'class.bd.control-pay.php';

class Quote_PDF{

	var $template_dir	= 'html/';
	var $template_html	= 'tpl.ordern-de-compra.php';
	
	var $proveedor		= 0;
	var $requisicion 	= 0;
	var $id_electronico	= 0;
	
	var $_array_supplier_info	= array();
	var $Table_request_quote_items			= array();
	var $Table_request_quote_details_items	= array();
	
	public function queryRequestQuote(){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote." where request_quote_id = '".$this->id_electronico."';";
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
	
	
	public function getSupplierValuesByID($id){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			$this->_array_supplier_info = $rows = $db_stock->getArray();
			
		}
		$db_stock->desconectar();
	
	}
	
	
	public function obtenerElementosProveedor(){
	
		$canal = $this->obtenerCanal();
		$elementos 	= array();
		foreach( $this->Table_request_quote_details_items as $item => $value ){
		
			if( $value['s'.$canal.'_buy'] ){
				
				$elementos[$item] = array('cantidad' =>$value['quantity'],
											'unidad' =>$value['unity'],
											'parte'	=>$value['description_part'],
											'precio_unitario'=>$value['s'.$canal.'_unit_price'],
											'precio_total'=>$value['s'.$canal.'_price'],
				
				
											);
				
				
				
			}
		
		}
		
		return $elementos;
	
	
	}
	
	public function obtenerCanal(){
		
		$canal = 0;
		foreach( $this->Table_request_quote_details_items as $item => $value ){
		
			if( $value['s1_id'] == $this->proveedor){
			
				$canal = 1;
				break;
			}
			
			if( $value['s2_id'] == $this->proveedor){
			
				$canal = 2;
				break;
			}
			
			if( $value['s3_id'] == $this->proveedor){
			
				$canal = 3;
				break;
			}
			
			if( $value['s4_id'] == $this->proveedor){
			
				$canal = 4;
				break;
			}
			
			if( $value['s5_id'] == $this->proveedor){
			
				$canal = 5;
				break;
			}
		
		}
		
		return $canal;
	
	
	}
	
	
	public function creaPDFPorProveedor(){
	
		$this->getSupplierValuesByID($this->proveedor);
		$this->queryRequestQuote();
		$this->queryRequestQuoteDetails();
		
		//print_r( $this->Table_request_quote_items );
		//print_r( $this->Table_request_quote_details_items );
		
		$content = file_get_contents('./html/tpl.ordern-de-compra.php', true);
		$content = str_replace('{requisicion}', $this->requisicion , $content );
		$content = str_replace('{proveedor_id}', $this->proveedor , $content );
		$content = str_replace('{fecha}', date('d/m/y',time()) , $content );
		$content = str_replace('{vendedor}', 'Roberto Alarcon ' , $content );
		$content = str_replace('{folio}', $this->Table_request_quote_items['folio_id'] , $content );
		
		$content = str_replace('{empresa}', $this->_array_supplier_info['name'] , $content );
		$content = str_replace('{contacto}', $this->_array_supplier_info['contact'] , $content );
		$content = str_replace('{direccion}', $this->_array_supplier_info['address'] , $content );
		$content = str_replace('{telefono}', $this->_array_supplier_info['phone1'] , $content );
		$content = str_replace('{correo1}', $this->_array_supplier_info['mail_1'] , $content );
		$content = str_replace('{correo2}', $this->_array_supplier_info['mail_2'] , $content );
		
		$array_elementos = $this->obtenerElementosProveedor();
		
		$cadena_elementos = '';
		$array_valores = array();
		foreach( $array_elementos as $indice => $elemento ){
			
			$cadena_elementos.='<tr>
			<td style="width: 10%; color: #444444; text-align: left; ">'.$elemento['cantidad'].'</td>
			<td style="width: 10%; color: #444444; text-align: left; ">'.$elemento['unidad'].'</td>
			<td style="width: 60%; color: #444444; text-align: left; ">'.$elemento['parte'].'</td>
			<td style="width: 10%; color: #444444; text-align: right; ">$ '.number_format($elemento['precio_unitario'],2).'</td>
			<td style="width: 10%; color: #444444; text-align: right;">$ '.number_format($elemento['precio_total'],2).'</td>
			
			</tr>';
			
			$array_valores[] = $elemento['precio_total'];
		
		}
		
		$subtotal = array_sum($array_valores);
		$iva = $subtotal * .16;
		$total = $subtotal + $iva;
		
		$content = str_replace('{items}', $cadena_elementos , $content );
		$content = str_replace('{subtotal}', '$ '.number_format($subtotal,2) , $content );
		$content = str_replace('{iva}', '$ '.number_format($iva,2) , $content );
		$content = str_replace('{total}', '$ '.number_format($total,2) , $content );
		
		
		// Cabecera de la izquierda
		$content = str_replace('{Out fecha}', '' , $content );
		$content = str_replace('{anticipo}', '' , $content );
		$content = str_replace('{saldo}', '' , $content );
		
		// Obtenemos tipo de pago 
		$control_pay = new BD_Control_Pay();
		$control_pay->request_quote_id = $this->id_electronico;
		$control_pay->supplier_id = $this->proveedor;
		
		$labelTipodePago = $control_pay->labelTipodePago( $control_pay->obtenerTipodePago() );
		$content = str_replace('{forma_pago}', ucfirst( $labelTipodePago ) , $content );
		
		
		
		require_once(MODULES_CLASES.'html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			//$html2pdf->setModeDebug();
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			//ob_end_clean();
			$html2pdf->Output('exemple00.pdf');
			
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
		
	}
	
	
	
	public function creaPDF(){
	
		/*/ Cargamos template
		ob_start();
		include('./html/tpl.ordern-de-compra.php');
		$content = ob_get_clean();
		
		//echo $content;
		*/
		$content = file_get_contents('./html/tpl.ordern-de-compra.php', true);
		
		require_once(MODULES_CLASES.'html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			//$html2pdf->setModeDebug();
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			//ob_end_clean();
			$html2pdf->Output('exemple00.pdf');
			
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
		
		
	
	}

}
