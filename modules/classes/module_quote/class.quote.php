<?php
/**************************************************************
* Super clase cotizador 
*
* @access public 
* @since 02/04/2013  
**************************************************************/
include_once 'class.quote.config.php';
include_once MODULES_CLASES.'manejaDB.php';
include_once MODULES_CLASES_QUOTE.'class.quote.items.php';


/**********************
* Clase cotizador
***********************/

Class Quote{

	var $folio_id;
	var $requisicion_id;
	var $objStock;
	
	//Celdas a mostrar
	var $image_field 	= false;
	var $promedio_field	= false;
	
	
	//Al cargar la clase se realizara la instancia con una requisicion
	function __construct ($requisicion = 0){
		$this->requisicion_id = $requisicion;	
		
	}
    
		
	// Cotizadore paso 1
	public function doQuoteStep1(){
		$objItems = new itemStep1($this->requisicion_id);
		$this->quoteHeader($objItems);
		$this->quoteList($objItems);
		$this->quoteFooter($objItems);
		$this->quoteFooterButtons($objItems);
	}
	
	// Cotizador paso 2
	public function doQuoteStep2(){
		$objItems = new itemStep2($this->requisicion_id);
		$this->quoteHeader($objItems);
		$this->quoteList($objItems);
		//$this->quoteFooter($objItems);
		$this->quoteFooterButtons($objItems);
		
	}
	
	// Cotizador paso 3
	public function doQuoteStep3(){
		
		
	}
	
	// Metodo encargado de mostrar el encabezado del cotizador
	public function quoteHeader($objItems){
		
		$table = '
			<table width="1400px">
				<tr>
				<th colspan=6>GRUPO AUTOMOTRIZ EN SERVICIOS DE COMBUSTIBLES, S.A. DE C.V.</th>
				</tr>
				<tr>
				<th>Marca:</th>
				<td>'.$objItems->getBrand().'</td>
				<th>Dependencia:</th>
				<td>'.$objItems->getDependency().'</td>
				<th>Fecha:</th>
				<td>'.$objItems->getDate().'</td>
				</tr>
				<tr>
				<th>Tipo:</th>
				<td>'.$objItems->getBrandType().'</td>
				<th>Vin:</th>
				<td>'.$objItems->getVIN().'</td>
				<th>Requisicion:</th>
				<td class="cell_red">'.$objItems->getRequisition().'</td>
				</tr>
				<tr>
				<th>Placa:</th>
				<td>'.$objItems->getPlaca().'</td>
				<th>Mecanico:</th>
				<td>'.$objItems->getMechanic().'</td>
				<th>Folio:</th>
				<td class="cell_red">'.$objItems->getFolio().'</td>
				</tr>
			</table>';
			
		echo $table;
		
	
	}
	
	// Metodo encargado de realizar el footer
	public function quoteFooter($objItems){
		
		$table = '
			<table width="1400px">
				<tr>
				<th>Solicito:</td>
				<td width="250px">'.$objItems->getUserRequest().'</td>
				<th rowspan=2>Observaciones:</td>
				<td rowspan=2 width="550px">'.$objItems->getObservations().'</td>
				<th>Forma de Pago:</td>
				<th>Tiempo para cotizar:</td>
				
				</tr>
				<th>Autorizo:</td>
				<td width="350px">'.$objItems->getUserAuthorize().'</td>
				<td width="350px">'.$objItems->getPayForm().'</td>
				<td width="350px">'.$objItems->configDate().'</td>
				</tr>
				
				
				</table>';
				
		echo $table;
		
	}
	
	// Metodo para crear tabla con botonera en footer
	public function quoteFooterButtons( $objItems ){
		
		$table = '
			<table width="1400px">
				<tr>
				</tr>
				<th class="right">'.$objItems->btnsForm().'</td>
				</tr>
				</table>';
				
		echo $table;
		
	}
	
	
	// Metodo encargado de crear el listado de elementos
	public function quoteList($objItems){
	
		$table = '<table width="1400px">
				<tr>
				<th rowspan="2">SKU</td>
				<th rowspan="2">CANTIDAD</td>
				<th rowspan="2">UNIDAD</td>
				<th rowspan="2">DESCRIPCION</td>';
				if( $this->image_field){
					$table .='<th rowspan="2">IMAGEN</td>';
				}
				
		$table .='<th rowspan="2">STOCK</td>
				<th>PROVEEDOR 1</td>
				<th>PROVEEDOR 2</td>
				<th>PROVEEDOR 3</td>
				<th>PROVEEDOR 4</td>
				<th>PROVEEDOR 5</td>';
				if( $this->promedio_field){
					$table .='<th rowspan="2">PROMEDIO</td>';
				}
		$table .='</tr>
				<tr>
				<td>'.$objItems->supplierList1().'</td>
				<td>'.$objItems->supplierList2().'</td>
				<td>'.$objItems->supplierList3().'</td>
				<td>'.$objItems->supplierList4().'</td>
				<td>'.$objItems->supplierList5().'</td>
				</tr>';
				
			// Obtenemos todos los productos de la requisicion
			$cont_row = 0;
			foreach($objItems->getElements() as $indice => $value){
			
			$cont_row = ($cont_row <= 1) ? $cont_row : 0 ;	
			
			$table.='<tr class="row_'.$cont_row.'">
				<td>SKU</td>
				<td>'.$objItems->getQuantity($indice).'</td>
				<td>'.$objItems->selectUnidad($indice).'</td>
				<td>'.$objItems->getDescription($indice).'</td>';
				if( $this->image_field){
					$table.='<td>'.$objItems->image($indice).'</td>';
				}
			$table.='<td>'.$objItems->getStockSelect($indice).'</td>
				<td>'.$objItems->supplier1($indice).'</td>
				<td>'.$objItems->supplier2($indice).'</td>
				<td>'.$objItems->supplier3($indice).'</td>
				<td>'.$objItems->supplier4($indice).'</td>
				<td>'.$objItems->supplier5($indice).'</td>';
				if( $this->image_field){
					$table.='<td>'.$objItems->average($indice).'</td>';
				}
				$table.='</tr>';
			
			$cont_row ++ ;
			
			}
				
			$table.='</table>';
				
		echo $table;
	
	}
	

}

?>