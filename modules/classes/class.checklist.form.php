<?php

/**************************************************************
* Clase: Checklist, encargada de controlar el formulario y los elementos
*
* @access public 
* @since 02/04/2013  
**************************************************************/

include_once 'manejaDB.php';

    class Checklist_Fom {
        #code
        var $Form;
        var $Checklist_folio;
        var $Checklist_folio_status = array();
        
        
        function __construct ($idChecklist,$post){
            
            $this->Checklist_folio  = $idChecklist;
            $this->Form             = $post;
        
        }
        
        // Procesa Fomulario
        public function insertUpdate(){
            
            //echo $this->Checklist_folio;
            $array_rows = array();
            $this->Checklist_folio_status = array();
            
            if(is_array($this->Form)){
                
                //print_r($this->Form);
                               
                foreach($this->Form as $name => $value){
                    
                    if(!empty($value)){
                    
                        $row = explode('-',$name);
                        $row = $row[0].'-'.$row[1];
                        
                        $array_rows[$row][] = array('item'=>$name,'val'=>$value);
                        
                        
                        
                    }
                }
                
                
                
                // Procesamos el insert a la BD
                // Borramos todos los elementos de la BD
                $this->deleteDetails();
                
                foreach($array_rows as $key => $v){
                    
                    
                    
                    $checklis_folio_id  = $this->Checklist_folio;
                    $explode_name       = explode('-',$key);
                    $type_test          = $explode_name[1];
                    
                    $activity_id        = $explode_name[0];
                    $activity_ready     = '';
                    $rate               = '';
                    $comments           = '';
                    
                    //echo $key.'<br><br><br>'; 
                    //print_r($v);
                    
                    foreach($v as $element){
                        
                        if( $element['item'] == $key.'-activityready'){
                            
                            $activity_ready     = $element['val'];
                            $this->Checklist_folio_status[] = $activity_ready;
                        }
                        
                        if( $element['item'] == $key.'-rate'){
                            
                            $rate     = $element['val'];
                        }
                        
                        if( $element['item'] == $key.'-comments'){
                            
                            $comments     = $element['val'];
                        }
                        
                    }
                    
                    
                    
                    $data = array(
                                    'checklis_folio_id' => $checklis_folio_id,
                                    'type_test' => $type_test,
                                    'activity_id' => $activity_id,
                                    'activity_ready' => $activity_ready,
                                    'rate' => $rate,
                                    'comments' => $comments,
                                    'modification_datetime' => time()
                                    
                                    );
                    
                    
                    
                    
                    
                    if (is_array($data)){
				$db = new manejaDB();			
				if($id = $db->makeQueryInsert('checklist_details',$data)){
					$result = $id;
					$db->desconectar();
					//return($result);           		
				}				
				echo $db->mensaje();
			}
                    
                    
                    
                }
                
                // Actualizamo estatus de la aplicacion
                $this->updateCheckFolioListStatus();
                
            }
            
        }
        
        
        public function deleteDetails(){
            
            $db = new manejaDB();
            $query = 'Delete FROM checklist_details where checklis_folio_id = "'.$this->Checklist_folio.'";';
            $db->query($query);
            $db->desconectar();
            
        }
        
        // Metodo encargado de revisar que la todos los elementos sean correctos
        // para actualizar el status de la aplicacion 
        private function updateCheckFolioListStatus(){
            
            $update = true;
            
            foreach($this->Checklist_folio_status as $value){
                
                if($value != "1"){
                    
                    $update = false;
                     break;     
                }
                    
                
            }
            
            
            // Actualizamos tabla checklist_folio
            if($update){               
                
                $db = new manejaDB();
                $query = 'UPDATE checklist_folio SET status="1",datetime="'.time().'" WHERE checklist_folio_id = '.$this->Checklist_folio.';';
                $db->query($query);
                $db->desconectar();
                
            }else{
                $db = new manejaDB();
                $query = 'UPDATE checklist_folio SET status="0",datetime="'.time().'" WHERE checklist_folio_id = '.$this->Checklist_folio.';';
                $db->query($query);
                $db->desconectar();
                
            }
            
            
            
            
        }
        
        
    }
    
    
    
    class Items_Form extends Checklist_Fom{
        
        var $table;
        var $item;
        var $type_activity;
        
        var $activityready  = "2";
        var $rate           = "1";
        var $comments       = "";
        
        //funcion para procesar elementos
        function processValues(){
            
            $this->getActivityready();
            $this->getRate();
            $this->getComments();
            
        }
        
        // Funcion que arma elemento con un radio
        function getActivityready(){
            
            
            $db = new manejaDB();
            $query = "SELECT activity_ready
                    From checklist_details
                    where checklis_folio_id = '".$this->Checklist_folio."' and
                    activity_id = '".$this->item."' and
                    type_test = '".$this->table."';";
                    
            $db->query($query);
           
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $activityready = $rows['activity_ready'];        		
                        
                }
    
            }
            
            $db->desconectar();
            if(!empty($activityready))
                $this->activityready = $activityready;
            
            
            
        }
        
        // Function para obtener el rate
        function getRate(){
            
            $db = new manejaDB();
            $query = "SELECT rate
                    From checklist_details
                    where checklis_folio_id = '".$this->Checklist_folio."' and
                    activity_id = '".$this->item."' and
                    type_test = '".$this->table."';";
            
            $db->query($query);
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $rate = $rows['rate'];        		
                        
                }
    
            }
            
            $db->desconectar();
            if(!empty($rate))
                $this->rate = $rate;
            
        }
        
        function getComments(){
            
            $comments = "";
			$db = new manejaDB();
            $query = "SELECT comments
                    From checklist_details
                    where checklis_folio_id = '".$this->Checklist_folio."' and
                    activity_id = '".$this->item."' and
                    type_test = '".$this->table."';";
            
            $db->query($query);
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $comments = $rows['comments'];        		
                        
                }
    
            }
            
            $db->desconectar();
            $this->comments = $comments;
            
        }
        
        
        function activity_ready(){
            
            
            $checked = ($this->activityready == '1')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-activityready" value="1" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function activity_non_ready(){
            
            $checked = ($this->activityready == '2')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-activityready" value="2" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_1(){
            
            $checked = ($this->rate == '1')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-rate" value="1" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_2(){
            
            $checked = ($this->rate == '2')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-rate" value="2" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_3(){
            
            $checked = ($this->rate == '3')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-rate" value="3" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_4(){
            
            $checked = ($this->rate == '4')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-rate" value="4" '.$checked.'>';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_5(){
            
            $checked = ($this->rate == '5')?"checked":"";
            return '<input type="radio" name="'.$this->item.'-'.$this->table.'-rate" value="5" '.$checked.'>';
            
        }
        
        // Funcion arma elementos de comentarios
        function comments(){
            /*
            return '<textarea rows="4" cols="50" name="'.$this->table.'_rate_'.$this->item.'"></textarea>
            <input type="hidden" name="'.$this->table.'_control_'.$this->item.'" value="'.$this->table.'_'.$this->item.'" >
            ';
            */
            
            //echo $this->comments;
            return '<textarea rows="4" cols="50" name="'.$this->item.'-'.$this->table.'-comments">'.$this->comments.'</textarea>';
            
        }
        
        
        
        function showElements(){
            return $this->item;
            
            
        }
        
        
        // Insertamos y procesamos los datos en tabla checklist detals
        public function insertUpdateForm($idChecklist,$post){
            
            if(is_array($post)){
                
                
                
                
            }
            
            
        }
        
        
        
    }
    
    
    // Clase extendida formularios de pruebas fisicas
    class Items_Form_Physical extends Items_Form{
        
        function __construct (){
            
            $this->table = 'support_checklist_physical';
            $this->type_activity = 'Fisica';
            
        }
        
        
        function loadItem($item){
            
            $this->item = $item;
            
        }
        
        
        
    }
    
    // Clase extendida formulario de pruebas mecanicas
    class Items_Form_Mechanical extends Items_Form{
        
        function __construct (){
            
            $this->table = 'support_checklist_mechanical';
            $this->type_activity = 'Mecanica';
            
        }
        
                
        
        
    }
    
    // Clase extendida formulario de pruebas en pista
    class Items_Form_OnRoad extends Items_Form{
        
        function __construct (){
            
            $this->table = 'support_checklist_onroad';
            $this->type_activity = 'Pista';
            
        }
        
            
        
    }
	
	
	// Clase para generar los botones para vincular la aplicacion
	class Link_Form_Activities extends Items_Form{
        
        function __construct (){
            
            $this->table = '`support_checklist_activities_list`';
            $this->type_activity = 'botones';
            
        }
		
		function getLinkButtons(){
			
			 $db = new manejaDB();
			$elements = array();
			$query = "SELECT * FROM ".$this->table." where status = 1 order by activity_name;";
			$db->query($query);
        
			if( $db->numLineas() != 0 ){
			
				while( $rows = $db->getArray() ){
						
						 $elements[] = array(
                                        'support_activities_list_id'=>$rows['support_activities_list_id'],
                                        'activity_name' => $rows['activity_name'],
										'status' => $rows['status']);
								
						
				}

			}
			
			$db->desconectar();
			return $elements;
		
		}
        
            
        
    }
	
	

?>