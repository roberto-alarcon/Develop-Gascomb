<?php

include_once 'class.quote.config.php';
include_once 'class.quote.stock.php';
include_once 'class.folio.php';
include_once 'class.vehicles.php';
include_once 'class.dependency.php';

 
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
    
 }
 
 class itemStep3 extends itemForm{
    
 }

?>