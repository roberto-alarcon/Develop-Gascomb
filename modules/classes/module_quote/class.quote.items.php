<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.stock.php';
include_once MODULES_CLASES.'class.folio.php';
include_once MODULES_CLASES.'class.vehicles.php';
include_once MODULES_CLASES.'class.dependency.php';

 
class itemForm {
    
   var $TEMS;
   var $ITEMS_FOLIO;
   var $folio_id;
   var $requisicion_id;
   var $objStock;
   
   
   // Se conecta a la tabla de detalles de stock y arma el formulario
   public function getElementsFromStock(){
        $this->objStock = new Stock_Quote();
        $this->folio_id = $this->objStock->getFolioId($this->requisicion_id);
        $this->objStock->stock_id = $this->requisicion_id;
        //$this->TEMS = $this->objStock->quoteArrayProducts();
        //return $this->TEMS;
	return $this->objStock->quoteArrayProducts();  
   }
   
   // Obtenemos todos los elementos de un folio
   public function getElementsByFolio(){
      $folio = new Folio();
      return $folio->selectbyId($this->folio_id);
   }
   
   // ITems genericos para el header
   public function getFolio(){
      $this->objStock = new Stock_Quote();
      $this->folio_id = $this->objStock->getFolioId($this->requisicion_id);
      return '<input type="hidden" name="general_folio_id" value="'.$this->folio_id.'">'.$this->folio_id;
   }
   
   
   public function getRequisition(){   
      return '<input type="hidden" name="general_requisicion_id" value="'.$this->requisicion_id.'">'.$this->requisicion_id; 
   }
   
   
   public function getDate(){
      return date('d/m/y H:i:s',time()); 
   }
   
   
   public function getPlaca(){
      return $this->ITEMS_FOLIO['registration_plate'];  
   }
   
   
   public function getBrand(){
      $vehicles = new Vehicle;		
      $vehicle = $vehicles->selectbyId($this->ITEMS_FOLIO["vehicles_record_id"]);	
      $brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);
      return $brand;
   }
   
   
   public function getBrandType(){
      $vehicles = new Vehicle;		
      $vehicle = $vehicles->selectbyId($this->ITEMS_FOLIO["vehicles_record_id"]);	
      $model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
      return  $model;
   }
   
   
   public function getDependency(){
      $dependency = new dependency;			
      $dependency_data = $dependency->selectbyId($this->ITEMS_FOLIO["dependency_id"]);	
      $dependency_name = $dependency_data["name"];
      return $dependency_name;
   }
   
   
   public function getVIN(){
      return $this->ITEMS_FOLIO["vin"];
   }
   
   
   public function getMechanic(){
      return 'Jefe de mecanico';
   }
   
   /********************************************
    *Metodos para footer
    *******************************************/
   
   public function getUserRequest(){
      return 'Roberto Alarcon <input type="hidden" name="general_userRequest" value="5">';
    
   }
   
   
   public function getUserAuthorize(){
      return 'Roberto Alarcon <input type="hidden" name="general_userAuth" value="5">';
    
   }
   
   public function getObservations(){
     return '<textarea rows="2" name="general_comments" cols="60"></textarea>';
     
   }
   
   public function getPayForm(){
      
      return '<input type="radio" name="general_payForm" value="1"> Contado <input type="radio" name="general_payForm" value="2" checked> Credito';
   }
   
   public function configDate(){
      return '# <input type="text" name="general_configTime" value="1" size="3">
	       <select name="general_configDate">
                <option value="hr">Hora(s)</option>
                <option value="day">Dia(s)</option>
                </select>';
      
   }
   
   
   public function btnsForm(){
      
      return '<input type="submit" value="Enviar Cotizacion">';
      
   }
   
      
  
}
 

 class itemStep1 extends itemForm{
    
        
    
    function __construct ($requisicion = 0){
        // Instanciamos clase Stock
    $this->requisicion_id = $requisicion;
	
	// Cargamos array con listado total de elementos
	$this->TEMS = $this->getElementsFromStock();
	//print_r($this->TEMS);
	$this->ITEMS_FOLIO = $this->getElementsByFolio();
	//print_r($this->ITEMS_FOLIO);
	
        
    }
    
    
    
    public function image($indice){
        
        return '<input type="file" size="10" name="upload_'.$this->TEMS[$indice]['stock_details_id'].'_image" value="" /><input type="hidden" name="imageControl[]" value="upload_'.$this->TEMS[$indice]['stock_details_id'].'_image">';
    }
    
    public function selectUnidad($indice){
        
        return '<select name="form_'.$this->TEMS[$indice]['stock_details_id'].'_unity">
                <option value="lts">litros</option>
                <option value="unidad">unidad</option>
                <option value="metros">metros</option>
		<option value="cm">cm</option>
                <option value="pieza">pieza</option>
		<option value="juego">juego</option>
		
                </select>'; 
        
    }
    
    public function getElements(){
        
        return $this->TEMS;
        
    }
    
    public function getQuantity($indice){
        
        return '<input type="text" name="form_'.$this->TEMS[$indice]['stock_details_id'].'_quantity" value="'.$this->TEMS[$indice]['quantity'].'" size=3/>';
        
    }
    
    public function getDescription($indice){
        
         return '<input type="text" name="form_'.$this->TEMS[$indice]['stock_details_id'].'_description_part" value="'.$this->TEMS[$indice]['product'].'" />';
        
    }
    
    public function getStockSelect($indice){
        
        return '<input type="checkbox" id="form_'.$this->TEMS[$indice]['stock_details_id'].'_stock" name="form_'.$this->TEMS[$indice]['stock_details_id'].'_stock" value="'.$this->TEMS[$indice]['stock_details_id'].'">';
    }
    
    public function supplier1($indice){
        
        return '<input type="checkbox" id="s1_'.$this->TEMS[$indice]['stock_details_id'].'_check" name="s1_'.$this->TEMS[$indice]['stock_details_id'].'_check" value="1">';
        
    }
    
    public function supplierList1(){
        
        // Generamos conexion a la BD STOCK
	
	$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
	$query = "SELECT * FROM support_suppliers where status = 1 and type = 1;";
	$db_stock->query($query);
	
	$select = '<select name="general_supplier1" style="width:96px;">';
	
	if( $db_stock->numLineas() != 0 ){
                    
                while( $rows = $db_stock->getArray() ){
                       
		     $select .= ' <option value="'.$rows['support_suppliers_id'].'">'.$rows['name'].'</option>'; 
                          		   
                }
    
         }
	 
	 $select .= '</select>';
            
	
	$db_stock->desconectar();
	return $select; 
        
    }
    
    public function supplier2($indice){
        
	
	return '<input type="checkbox" id="s2_'.$this->TEMS[$indice]['stock_details_id'].'_check" name="s2_'.$this->TEMS[$indice]['stock_details_id'].'_check" value="1">';
        
    }
    
    public function supplierList2(){
        
        // Generamos conexion a la BD STOCK
	
	$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
	$query = "SELECT * FROM support_suppliers where status = 1 and type in (2,3);";
	$db_stock->query($query);
	
	$select = '<select name="general_supplier2" style="width:96px;">';
	
	if( $db_stock->numLineas() != 0 ){
                    
                while( $rows = $db_stock->getArray() ){
                       
		     $select .= ' <option value="'.$rows['support_suppliers_id'].'">'.$rows['name'].'</option>'; 
                          		   
                }
    
         }
	 
	 $select .= '</select>';
            
	
	$db_stock->desconectar();
	return $select;
        
    }
    
    public function supplier3($indice){
        
        return '<input type="checkbox" id="s3_'.$this->TEMS[$indice]['stock_details_id'].'_check" name="s3_'.$this->TEMS[$indice]['stock_details_id'].'_check" value="1">';
        
    }
    
    public function supplierList3(){
        
        // Generamos conexion a la BD STOCK
	
	$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
	$query = "SELECT * FROM support_suppliers where status = 1 and type in (2,3);";
	$db_stock->query($query);
	
	$select = '<select name="general_supplier3" style="width:96px;">';
	
	if( $db_stock->numLineas() != 0 ){
                    
                while( $rows = $db_stock->getArray() ){
                       
		     $select .= ' <option value="'.$rows['support_suppliers_id'].'">'.$rows['name'].'</option>'; 
                          		   
                }
    
         }
	 
	 $select .= '</select>';
            
	
	$db_stock->desconectar();
	return $select;
        
    }
    
    public function supplier4($indice){
        
        return '<input type="checkbox" id="s4_'.$this->TEMS[$indice]['stock_details_id'].'_check" name="s4_'.$this->TEMS[$indice]['stock_details_id'].'_check" value="1">';
        
    }
    
    public function supplierList4(){
        
        // Generamos conexion a la BD STOCK
	
	$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
	$query = "SELECT * FROM support_suppliers where status = 1 and type in (2,3);";
	$db_stock->query($query);
	
	$select = '<select name="general_supplier4" style="width:96px;">';
	
	if( $db_stock->numLineas() != 0 ){
                    
                while( $rows = $db_stock->getArray() ){
                       
		     $select .= ' <option value="'.$rows['support_suppliers_id'].'">'.$rows['name'].'</option>'; 
                          		   
                }
    
         }
	 
	 $select .= '</select>';
            
	
	$db_stock->desconectar();
	return $select;
        
    }
    
    public function supplier5($indice){
        
        return '<input type="checkbox" id="s5_'.$this->TEMS[$indice]['stock_details_id'].'_check" name="s5_'.$this->TEMS[$indice]['stock_details_id'].'_check" value="1">';
        
    }
    
    public function supplierList5(){
        
        // Generamos conexion a la BD STOCK
	
	$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
	$query = "SELECT * FROM support_suppliers where status = 1 and type in (2,3);";
	$db_stock->query($query);
	
	$select = '<select name="general_supplier5" style="width:96px;">';
	
	if( $db_stock->numLineas() != 0 ){
                    
                while( $rows = $db_stock->getArray() ){
                       
		     $select .= ' <option value="'.$rows['support_suppliers_id'].'">'.$rows['name'].'</option>'; 
                          		   
                }
    
         }
	 
	 $select .= '</select>';
            
	
	$db_stock->desconectar();
	return $select; 
        
    }
    
       
    public function average($indice){
        
        return '';
    }
    
    
 }
 
 class itemStep2 extends itemForm{
    
	var $Table_request_quote_items			= array();
	var $Table_request_quote_details_items	= array();
	var $s1_id								= array();
	var $s2_id								= array();
	var $s3_id								= array();
	var $s4_id								= array();
	var $s5_id								= array();
	
	
	function __construct ($requisicion = 0){
		// Instanciamos clase Stock
		$this->requisicion_id = $requisicion;
		
		// Cargamos array con listado total de elementos
		$this->TEMS = $this->getElementsFromStock();
		$this->ITEMS_FOLIO = $this->getElementsByFolio();
		
		// Cargamos elementos de la cotizacion 
		$this->queryRequestQuote();
		$this->queryRequestQuoteDetails();
				
		if(time() < $this->Table_request_quote_items['time_set'] ){
		
			echo '<h1>Esta solicitud tiene una vigencia hasta '. date('d/m/Y H:i:s',$this->Table_request_quote_items['time_set']);
		}else{
			echo '<h1>La solicitud caduco el '. date('d/m/Y H:i:s',$this->Table_request_quote_items['time_set']);	
		}
		
	
    }
	
	public function queryRequestQuote(){
	
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_request_quote." where requisition_id = '".$this->requisicion_id."';";
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
	
	// Metodo encargado de obtener el ID del proveedor
	private function getSupplierID( $field ){
		
		$total_filas = count( $this->Table_request_quote_details_items );
		$id = 0;
		
		for ($i = 0; $i < $total_filas; $i++) {
			
			if( $this->Table_request_quote_details_items[$i][$field] > 0 ){
				$id = $this->Table_request_quote_details_items[$i][$field];
				break;
			}
			
			
		}
		
		return $id;

		
	}
	
	public function supplierList1(){
		
		$id = $this->getSupplierID('s1_id');
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->s1_id = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		return (isset($this->s1_id["name"]))? '<a href="javascript:modalPago('.$this->Table_request_quote_items["request_quote_id"].',\''.$id.'\')">'. $this->s1_id["name"].'</a>' : ' - - ';
	
	}
	
	public function supplierList2(){
		
		$id = $this->getSupplierID('s2_id');
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->s2_id = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		
		return (isset($this->s2_id["name"]))? '<a href="javascript:modalPago('.$this->Table_request_quote_items["request_quote_id"].',\''.$id.'\')">'. $this->s2_id["name"].'</a>' : ' - - ';
	
	}
	
	public function supplierList3(){
		
		$id = $this->getSupplierID('s3_id');
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->s3_id = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		
		return (isset($this->s3_id["name"]))? '<a href="javascript:modalPago('.$this->Table_request_quote_items["request_quote_id"].',\''.$id.'\')">'. $this->s3_id["name"].'</a>' : ' - - ';
	
	}
	
	public function supplierList4(){
		
		$id = $this->getSupplierID('s4_id');
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->s4_id = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		
		return (isset($this->s4_id["name"]))? '<a href="javascript:modalPago('.$this->Table_request_quote_items["request_quote_id"].',\''.$id.'\')">'. $this->s4_id["name"] .'</a>': ' - - ';
		
	
	}
	
	public function supplierList5(){
		
		$id = $this->getSupplierID('s5_id');
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM ".TABLE_support_suppliers." where support_suppliers_id = '$id';";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
			
			while( $rows = $db_stock->getArray() ){
                        
				$this->s4_id = $rows;		
				        
			}
			
		}
		$db_stock->desconectar();
		
		
		return (isset($this->s5_id["name"]))? '<a href="javascript:modalPago('.$this->Table_request_quote_items["request_quote_id"].',\''.$id.'\')">'. $this->s5_id["name"] .'</a>': ' - - ';
	
	}
	
	public function getElements(){
        
        //return $this->TEMS;
		return $this->Table_request_quote_details_items;
        
    }
	
	public function validateRequisition($stock_details_id){
		
		$not_in_stock = false;
		
		foreach ($this->Table_request_quote_details_items as $indice => $item){
		 
			if( $item['stock_details_id'] == $stock_details_id){
				
				$not_in_stock = $indice;
				break;
			
			}
		 
		}
		
		return $not_in_stock;
		
	
	}
	
	public function getQuantity($indice){
        
		return $this->Table_request_quote_details_items[$indice]['quantity'];
    }
	
	public function selectUnidad($indice){
		
		return $this->Table_request_quote_details_items[$indice]['unity'];
	
	}
	
	public function getDescription($indice){
	
		
		return $this->Table_request_quote_details_items[$indice]['description_part'];
		
	}
	
	public function image($indice){
	
		
		$image_path = PATH_MULTIMEDIA_STOCK.date('Y',$this->Table_request_quote_items["time_request"]).'/'.$this->Table_request_quote_items["request_quote_id"].'/'.$this->Table_request_quote_details_items[$indice]['stock_details_id'].'.jpg';
		$image_url = URL_MULTIMEDIA_STOCK.date('Y',$this->Table_request_quote_items["time_request"]).'/'.$this->Table_request_quote_items["request_quote_id"].'/'.$this->Table_request_quote_details_items[$indice]['stock_details_id'].'.jpg';
		if(is_file($image_path)){
			return '<a href="'.$image_url.'" target="_blank">Ver imagen</a><br/>';
		}else{
			return "";		
		}	
	}
	
	public function maxValue( $indice ){
	
		$array = array();
				
		$array[] = $this->Table_request_quote_details_items[$indice]['s1_price'];
		$array[] = $this->Table_request_quote_details_items[$indice]['s2_price'];
		$array[] = $this->Table_request_quote_details_items[$indice]['s3_price'];
		$array[] = $this->Table_request_quote_details_items[$indice]['s4_price'];
		$array[] = $this->Table_request_quote_details_items[$indice]['s5_price'];
		
		return max($array);
		
	
	}
	
	public function minValue( $indice ){
	
		$totalElementos = $this->totalProvedores();
		if ($totalElementos > 1){
		
			$array = array();
			if( $this->Table_request_quote_details_items[$indice]['s1_price'] != 0)
				$array[] = $this->Table_request_quote_details_items[$indice]['s1_price'];
			if( $this->Table_request_quote_details_items[$indice]['s2_price'] != 0)
				$array[] = $this->Table_request_quote_details_items[$indice]['s2_price'];
			if( $this->Table_request_quote_details_items[$indice]['s3_price'] != 0)
				$array[] = $this->Table_request_quote_details_items[$indice]['s3_price'];
			if( $this->Table_request_quote_details_items[$indice]['s4_price'] != 0)
				$array[] = $this->Table_request_quote_details_items[$indice]['s4_price'];
			if( $this->Table_request_quote_details_items[$indice]['s5_price'] != 0)
				$array[] = $this->Table_request_quote_details_items[$indice]['s5_price'];
			
			if(count($array) > 1){
				return min($array);
			
			}else{
				return -1;
			}
			
			
		}else{
			return 0;
		}
		
	
	}
	
	public function supplier1($indice){
		if(isset($this->s1_id["name"]) && $this->Table_request_quote_details_items[$indice]['s1_id'] > 0){
		
			if($this->Table_request_quote_details_items[$indice]['s1_price'] == 0){
				$table = 'En espera';
			}else{
				$maximo = $this->maxValue( $indice );
				$minimo = $this->minValue( $indice );
				
				$class = "";
				if( $maximo == $this->Table_request_quote_details_items[$indice]['s1_price']){
					$class = 'class="cell_red"';
				}
				
				if( $minimo == $this->Table_request_quote_details_items[$indice]['s1_price']){
					$class = 'class="cell_green"';
				}
				
				$checked = ($this->Table_request_quote_details_items[$indice]['s1_buy']) ? 'checked' : '';
				$enable	 = ($this->Table_request_quote_items['buy_status'] == 2) ? 'disabled="disabled"' : '';
			
				$table = '<table width=100% border = 0>
				<tr>
				<th align="left"><a href="javascript:modalDetails('.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].',\'s1\');">Detalles </a> - '.$this->Table_request_quote_details_items[$indice]['s1_brand'].'</td>
				</tr>
				<tr>
				<td '.$class.'><input type="checkbox" id="s1_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" name="s1_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" value="1" '.$checked.' '.$enable.'> &nbsp; $'.number_format($this->Table_request_quote_details_items[$indice]['s1_price'],2).'</td>
				
				</tr>
				</table>';
			}
			
			return $table;
		}else{
		
			return '- -';
		} 
	}
	
	public function supplier2($indice){
	
		if(isset($this->s2_id["name"]) && $this->Table_request_quote_details_items[$indice]['s2_id'] > 0){
		
			if($this->Table_request_quote_details_items[$indice]['s2_price'] == 0){
				$table = 'En espera';
			}else{
			
				$maximo = $this->maxValue( $indice );
				$minimo = $this->minValue( $indice );
				
				$class = "";
				if( $maximo == $this->Table_request_quote_details_items[$indice]['s2_price']){
					$class = 'class="cell_red"';
				}
				
				if( $minimo == $this->Table_request_quote_details_items[$indice]['s2_price']){
					$class = 'class="cell_green"';
				}
				
				$checked = ($this->Table_request_quote_details_items[$indice]['s2_buy']) ? 'checked' : '';
				$enable	 = ($this->Table_request_quote_items['buy_status'] == 2) ? 'disabled="disabled"' : '';
				
				$table = '<table width=100% border = 0>
				<tr>
				<th align="left"><a href="javascript:modalDetails('.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].',\'s2\');">Detalles </a> - '.$this->Table_request_quote_details_items[$indice]['s2_brand'].'</td>
				</tr>
				<tr>
				<td '.$class.'><input type="checkbox" id="s2_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" name="s2_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" value="1" '.$checked.' '.$enable.'> &nbsp; $'.number_format($this->Table_request_quote_details_items[$indice]['s2_price'],2).'</td>
				</tr>
				</table>';
			}
			return $table;
		}else{
		
			return '$ 0';
		} 
	}
	
	public function supplier3($indice){
	
		if(isset($this->s3_id["name"]) && $this->Table_request_quote_details_items[$indice]['s3_id'] > 0){
		
			if($this->Table_request_quote_details_items[$indice]['s3_price'] == 0){
				$table = 'En espera';
			}else{
			
				$maximo = $this->maxValue( $indice );
				$minimo = $this->minValue( $indice );
				
				$class = "";
				if( $maximo == $this->Table_request_quote_details_items[$indice]['s3_price']){
					$class = 'class="cell_red"';
				}
				
				if( $minimo == $this->Table_request_quote_details_items[$indice]['s3_price']){
					$class = 'class="cell_green"';
				}
				
				$checked = ($this->Table_request_quote_details_items[$indice]['s3_buy']) ? 'checked' : '';
				$enable	 = ($this->Table_request_quote_items['buy_status'] == 2) ? 'disabled="disabled"' : '';
				
				$table = '<table width=100% border = 0>
				<tr>
				<th align="left"><a href="javascript:modalDetails('.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].',\'s3\');">Detalles </a> - '.$this->Table_request_quote_details_items[$indice]['s3_brand'].'</td>
				</tr>
				<tr>
				<td '.$class.'><input type="checkbox" id="s3_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" name="s3_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" value="1" '.$checked.' '.$enable.'> &nbsp; $'.number_format($this->Table_request_quote_details_items[$indice]['s3_price'],2).'</td>
				</tr>
				</table>';
				
			}
			return $table;
		}else{
		
			return '- -';
		}
	}
	
	public function supplier4($indice){
	
		if(isset($this->s4_id["name"]) && $this->Table_request_quote_details_items[$indice]['s4_id'] > 0){
		
			if($this->Table_request_quote_details_items[$indice]['s4_price'] == 0){
				$table = 'En espera';
			}else{
			
				$maximo = $this->maxValue( $indice );
				$minimo = $this->minValue( $indice );
				
				$class = "";
				if( $maximo == $this->Table_request_quote_details_items[$indice]['s4_price']){
					$class = 'class="cell_red"';
				}
				
				if( $minimo == $this->Table_request_quote_details_items[$indice]['s4_price']){
					$class = 'class="cell_green"';
				}
				
				$checked = ($this->Table_request_quote_details_items[$indice]['s4_buy']) ? 'checked' : '';
				$enable	 = ($this->Table_request_quote_items['buy_status'] == 2) ? 'disabled="disabled"' : '';
				
				$table = '<table width=100% border = 0>
				<tr>
				<th align="left"><a href="javascript:modalDetails('.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].',\'s4\');">Detalles </a> - '.$this->Table_request_quote_details_items[$indice]['s4_brand'].'</td>
				</tr>
				<tr>
				<td '.$class.'><input type="checkbox" id="s4_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" name="s4_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" value="1" '.$checked.' '.$enable.'> &nbsp; $'.number_format($this->Table_request_quote_details_items[$indice]['s4_price'],2).'</td>
				</tr>
				</table>';
			}
			return $table;
		}else{
		
			return '- -';
		}
	}
	
	public function supplier5($indice){
	
		if(isset($this->s5_id["name"]) && $this->Table_request_quote_details_items[$indice]['s5_id'] > 0){
		
			if($this->Table_request_quote_details_items[$indice]['s5_price'] == 0){
				$table = 'En espera';
			}else{
			
				$maximo = $this->maxValue( $indice );
				$minimo = $this->minValue( $indice );
				
				$class = "";
				if( $maximo == $this->Table_request_quote_details_items[$indice]['s5_price']){
					$class = 'class="cell_red"';
				}
				
				if( $minimo == $this->Table_request_quote_details_items[$indice]['s5_price']){
					$class = 'class="cell_green"';
				}
				
				$checked = ($this->Table_request_quote_details_items[$indice]['s5_buy']) ? 'checked' : '';
				$enable	 = ($this->Table_request_quote_items['buy_status'] == 2) ? 'disabled="disabled"' : '';
				
				$table = '<table width=100% border = 0>
				<tr>
				<th align="left"><a href="javascript:modalDetails('.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].',\'s5\');">Detalles </a> - '.$this->Table_request_quote_details_items[$indice]['s5_brand'].'</td>
				</tr>
				<tr>
				<td '.$class.'><input type="checkbox" id="s5_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" name="s5_'.$this->Table_request_quote_details_items[$indice]['request_quote_details_id'].'_check" value="1" '.$checked.' '.$enable.'> &nbsp; $'.number_format($this->Table_request_quote_details_items[$indice]['s5_price'],2).'</td>
				</tr>
				</table>';
			}
			return $table;
		}else{
		
			return '- -';
		} 
	}
	
	public function getStockSelect($indice){
		
		return 'Pendiente compra';
		
	}
	
	public function average($indice){
		
		//$totalElementos = $this->totalProvedores();
		$totalElementos = 0;
		for($i = 1; $i <= 5; $i++){
		
			if($this->Table_request_quote_details_items[$indice]['s'.$i.'_price'] > 0 ){
				$totalElementos ++;
			}
		
		}
				
		$suma = $this->Table_request_quote_details_items[$indice]['s1_price'] +
		$this->Table_request_quote_details_items[$indice]['s2_price'] +
		$this->Table_request_quote_details_items[$indice]['s3_price'] +
		$this->Table_request_quote_details_items[$indice]['s4_price'] +
		$this->Table_request_quote_details_items[$indice]['s5_price'];
		
		@$resultado = $suma / $totalElementos;
		
		return '$'.number_format($resultado,2);
	
	}
	
	public function totalProvedores(){
	
		$cont = 0;
		if(!empty($this->s1_id)){
			$cont ++ ;
		}
		
		if(!empty($this->s2_id)){
			$cont ++ ;
		}
		
		if(!empty($this->s3_id)){
			$cont ++ ;
		}
		
		if(!empty($this->s4_id)){
			$cont ++ ;
		}
		
		if(!empty($this->s5_id)){
			$cont ++ ;
		}
		
		return $cont;
	
	}
	
	public function btnsForm(){
		/* Agregamos input con el valor con el request_quote_id */
		
		switch (  $this->Table_request_quote_items['buy_status'] ) {
			case 0:
				return '<input type="hidden" name="request_quote_id" value="'.$this->Table_request_quote_items['request_quote_id'].'">
				<input type="submit" value="Guardar">';
				break;
			case 1:
				return '<input type="hidden" name="request_quote_id" value="'.$this->Table_request_quote_items['request_quote_id'].'">
				<input type="submit" value="Guardar"><input type="button" id="btnCompra2" value="Detalles de compra" onclick="javascript:modalCompra('.$this->Table_request_quote_items['request_quote_id'].' )">
				<input id="enviarCompra" type="button" value="Enviar Correo" onclick="javascript:enviarCorreo()';
				break;
			case 2:
				return '<input type="hidden" name="request_quote_id" value="'.$this->Table_request_quote_items['request_quote_id'].'">
				<input type="submit" value="Guardar">
				<input type="button" id="btnCompra2" value="Detalles Compra" onclick="javascript:modalCompra('.$this->Table_request_quote_items['request_quote_id'].' )">';
				
				break;
		}
		
		
		
	
	}
	
	
	
	
 }
 
 class itemStep3 extends itemForm{
    
 }
 
  

?>