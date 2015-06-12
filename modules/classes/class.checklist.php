<?php
/**************************************************************
* Clase: Checklist, Controla vista CheckList
*
* @access public 
* @since 02/04/2013  
**************************************************************/

include_once 'manejaDB.php';
include_once 'class.checklist.form.php';
include_once 'class.checklist.Items.php';

class Checklist{
    
    //@ properties
    var $checklist_id;
    var $folio_id;
    var $checklist_structure;        // Visita las tablas de soporte y genera la estructura
    
    // Interaccion con la base de datos
    var $db_checklist           = 'support_checklist';
    var $db_activities          = 'support_checklist_activities';
    var $db_activities_list	    = 'support_checklist_activities_list';
    var $db_physichal           = 'support_checklist_physical';
    var $db_mechanical          = 'support_checklist_mechanical';
    var $db_onroad              = 'support_checklist_onroad';
    
    // Propiedades de la vista
    var $activity;
    var $array_mechanical;
    var $array_onroad;
    var $array_physical;
    
    
    
    
    // @ Methods
    function __construct ($folio = 0){
        $this->folio_id = $folio;
        
    }
    
    // Metodo para insertar valores en la tabla checklisfolio
    public function insertChecklistItem($activity_id){
		$this->activity = $activity_id;
		global $Gascomb;
		$data = array(
			   'folio_id' => $this->folio_id,
			   'support_checklist_activities' => $activity_id,
			   'status' => 0,
			   'datetime' => time()
			   
			   );
		 
		if (is_array($data)){
			$db = new manejaDB();			
			if($id = $db->makeQueryInsert('checklist_folio',$data)){
				$result = $id;
				$Gascomb->log('Agrego la actividad #'.$this->getNameActivity().'');
				$db->desconectar();
				//return($result);           		
			}				
			
			$db->mensaje();
		}
	 
	
	
    }
	
	function addSupportChecklistActivity($data){
		
		if (is_array($data)){
			$db = new manejaDB();			
			if($id = $db->makeQueryInsert($this->db_activities,$data)){
				$result = $this->selectActivitybyId($id);
				$db->desconectar();
				return($result);           		
			}else{
				echo $db->mensaje();
			}				
			
		}
				
    }
	
	/*Metodo para vincular la cheklistfolio con la actividad*/
	function linkingActivity($cheklist_folio, $activity){
	
		try{
			$db = new manejaDB();
			$query = 'UPDATE checklist_folio SET 
						support_checklist_activities_list_id="'.$activity.'",
						datetime="'.time().'" 
					WHERE checklist_folio_id = '.$cheklist_folio.';';
			$db->query($query);
			$db->desconectar();
			
			// Borramos elementos 
			$form = new Checklist_Fom($cheklist_folio , array());
			$form->deleteDetails();
			
			
			return true;
		}catch (Exception $e) {
			return false;
		}
	
	}
	
	function linkingChangeActivity($cheklist_folio){
	
		try{
			$db = new manejaDB();
			$query = 'UPDATE checklist_folio SET 
						support_checklist_activities_list_id="0",
						datetime="'.time().'" 
					WHERE checklist_folio_id = '.$cheklist_folio.';';
			$db->query($query);
			$db->desconectar();
			
			// Borramos elementos 
			$form = new Checklist_Fom($cheklist_folio , array());
			$form->deleteDetails();
			
			//Actualizamos relacion 
			$db = new manejaDB();
			$query = 'UPDATE checklist_folio SET status="0",datetime="'.time().'" WHERE checklist_folio_id = '.$cheklist_folio.';';
			$db->query($query);
			$db->desconectar();
			
			
			return true;
		}catch (Exception $e) {
			return false;
		}
	
	}
	
	
	function selectActivitybyId($id){ 
            $db = new manejaDB();
			$db->query("select support_activities_id from ".$this->db_activities." where support_activities_id = '".$id."'");
			$result = $db->getArray();
			$result	= ($result["support_activities_id"])? $result["support_activities_id"] : false;			
			$db->desconectar();
			return($result); 						
    }
	function getNameActivitybyId($id){ 
            $db = new manejaDB();
			$db->query("select activity_name from ".$this->db_activities." where support_activities_id = '".$id."'");
			$result = $db->getArray();
			$result	= ($result["activity_name"])? $result["activity_name"] : false;			
			$db->desconectar();
			return($result); 						
    }
	
	function getNameActivityListByID($id){
		$db = new manejaDB();
		$db->query("select activity_name from ".$this->db_activities_list." where support_activities_list_id = '".$id."'");
		$result = $db->getArray();
		$result	= ($result["activity_name"])? $result["activity_name"] : false;			
		$db->desconectar();
		return($result); 
	
	}
    
   
    public function listQualityElements(){
    
        $elements = array();
        
        $db = new manejaDB();
        $query = "SELECT * FROM checklist_folio where folio_id =".$this->folio_id.";";
        $db->query($query);
        
        if( $db->numLineas() != 0 ){
		
            
            while( $rows = $db->getArray() ){
                    
                    $this->activity = $rows['support_checklist_activities'];
                    
                    $elements[] = array(
                                        'checklist_folio_id'=>$rows['checklist_folio_id'],
                                        'support_checklist_activities' => $rows['support_checklist_activities'],
										'support_checklist_activities_list_id' => $rows['support_checklist_activities_list_id'],
                                        'label_activities' => $this->getNameActivity(),
                                        'status'=>$rows['status']);
                      		
                    
            }

        }
        
        
        
        $db->desconectar();
        
        return $elements;
    
    
   }
   
    
    // Este metodo controlar la vista 
    public function createCheckListView($activity_id){
        
        $ObjPhysicalView    = new Items_View_Physical();
        $ObjMechanical      = new Items_View_Mechanical();
        $ObjOnRoad          = new Items_View_OnRoad();
        
        
        $this->activity = $activity_id;
        $this->getCkeckListItems();
        $labels = $this->getNameActivityAndLinkActivity();
		echo '<h3>Actividad:<i> '.$labels[0].'</i> vinculado con: >> <a href="javascript:changeLink('.$this->checklist_id.')">'.$labels[1].'</a></h3>';
		//$this->createTableItemsNonCal('Prueba Fisica:',$this->array_physical,$ObjPhysical);
        $this->createTableItemsNonCal('Prueba Fisica:',$this->array_physical,$ObjPhysicalView);
        $this->createTableItems('Prueba Mecanica:',$this->array_mechanical,$ObjMechanical);
        $this->createTableItems('Prueba en Pista:',$this->array_onroad,$ObjOnRoad);
        //$this->createTableItemsNonCal('Prueba Fisica:',$this->array_physical,$ObjPhysicalView);
        
        
        
        
        
    }
    
    // Este metodo controlar la vista tipo formulario 
    public function createCheckListForm($activity_id){
        
        if ( $activity_id ) {
			$ObjPhysical    = new Items_Form_Physical();
			$ObjMechanical = new Items_Form_Mechanical();
			$ObjOnRoad      = new Items_Form_OnRoad();
			
			
			$this->activity = $activity_id;
			$this->getCkeckListItems();
			
			$labels = $this->getNameActivityAndLinkActivity();
			echo '<h3>Actividad:<i> '.$labels[0].'</i> vinculado con: >> <a href="javascript:changeLink('.$this->checklist_id.')">'.$labels[1].'</a></h3>';
			$this->createTableItemsNonCal('Prueba Fisica:',$this->array_physical,$ObjPhysical);
		//$this->createTableItems('Prueba Fisica:',$this->array_physical,$ObjPhysical);
			$this->createTableItems('Prueba Mecanica:',$this->array_mechanical,$ObjMechanical);
			$this->createTableItems('Prueba en Pista:',$this->array_onroad,$ObjOnRoad);
			//$this->createTableItemsNonCal('Prueba Fisica:',$this->array_physical,$ObjPhysical);
		}else{
	
			echo '<h3>Es necesario vincular esta actividad con alguno de los siguientes registros:</h3> ';
			$this->formLinkActivities( $activity_id );
			die();
		
		}
	
	}
	
	public function formLinkActivities( $activity_id ){
	
		$formButtons = new Link_Form_Activities();
		$arrayButtons = $formButtons->getLinkButtons();	
		//print_r($arrayButtons);
		
		$buttons = '<div data-demo-html="true" style="width:70%">
				<ul data-role="listview">';
				
				foreach($arrayButtons as $button){
				
					$buttons .='<li><a href="javascript:linkElement('.$button['support_activities_list_id'].')">'.$button['activity_name'] .'</a></li>';
				}
				
		$buttons .='</ul>
			</div>';
			
		echo $buttons;	
	
	}
	
    // Funcion para obtener la Nombre de la actividad
    public function getNameActivity(){
        
        $activity_name = '';
        $db = new manejaDB();
        $query = "SELECT * FROM support_checklist_activities where support_activities_id =".$this->activity.";";
        $db->query($query);
        
        if( $db->numLineas() != 0 ){
		
            while( $rows = $db->getArray() ){
                    
                    $activity_name = $rows['activity_name'];
                      		
                    
            }

        }
        
        $db->desconectar();
        
        return $activity_name;
        
        
    }
	
	public function getNameActivityAndLinkActivity(){
	
		$labels = array();
		$db = new manejaDB();
		$query = 'SELECT support_checklist_activities , support_checklist_activities_list_id FROM checklist_folio where checklist_folio_id = '.$this->checklist_id.';';
		$db->query($query);
		if( $db->numLineas() != 0 ){
		
			 while( $rows = $db->getArray() ){
                    
                    $labels[0] 	= $this->getNameActivityByID( $rows['support_checklist_activities'] );
                    $labels[1] 	= $this->getNameActivityListByID( $rows['support_checklist_activities_list_id'] );    		
                    
					
            }
		
		}

		return $labels;
		 
		 
	}
	
    
    //Obtenemos todos los items y lo metemos a cada uno de los arrays
    private function getCkeckListItems(){
        
        $mechanical;     
        $physical;      
        $onroad;         
		
        $db = new manejaDB();
        $query = "SELECT * FROM support_checklist where support_checklist_activities_id=".$this->activity.";";
        $db->query($query);
        
        if( $db->numLineas() != 0 ){
		
            while( $rows = $db->getArray() ){
                    
                    $mechanical = $rows['mechanical_ids'];
                    $physical   = $rows['physical_ids'];
                    $onroad     = $rows['onroad_ids'];       		
                    
            }
			
			// Cargamos los elementos
			$this->array_mechanical = $this->getMechanicalInstances( explode(';',$mechanical) );
			$this->array_physical   = $this->getPhysicalInstances( explode(';', $physical) );
			$this->array_onroad     = $this->getOnRoadInstances( explode(';',$onroad) );

        }else{
			echo '<h3>Actualmente no existe ningun elemento a calificar para esta actividad</h3> ';
			die();
		
		}
        
        $db->desconectar();
        
        
                
        
    }
    
    // Obtenemos elementos de pruebas mecanicas
    private function getMechanicalInstances($list){
        
        $array_mechanical_name = array();
        
        $db = new manejaDB();
        foreach ($list as $value){
            
            $query = "SELECT * FROM support_checklist_mechanical where support_checklist_mechanical_id = '".$value."';";
            $db->query($query);
        
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $array_mechanical_name[$value] = $rows['mechanical_name'];        		
                        
                }
    
            }
            
            
        }
        
        $db->desconectar();
        return $array_mechanical_name;
        
    }
    
    // Obtenemos elementos de pruebas fisicas
    private function getPhysicalInstances($list){
        
        $array_physical_name = array();
        
        $db = new manejaDB();
        foreach ($list as $value){
            
            $query = "SELECT * FROM support_checklist_physical where support_checklist_physical_id = '".$value."';";
            $db->query($query);
        
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $array_physical_name[$value] = $rows['physical_name'];        		
                        
                }
    
            }
            
            
        }
        
        $db->desconectar();
        return $array_physical_name;
        
        
    }
    
    //Obtenemos elementos de pruebas en pista
    private function getOnRoadInstances($list){
        
        $array_onroad_name = array();
        
        $db = new manejaDB();
        foreach ($list as $value){
            
            $query = "SELECT * FROM support_checklist_onroad where support_checklist_onroad_id = '".$value."';";
            $db->query($query);
        
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $array_onroad_name[$value] = $rows['onroad_name'];        		
                        
                }
    
            }
            
            
        }
        
        $db->desconectar();
        return $array_onroad_name;
        
        
    }
    
    
    // Metodo encargado de contruir la tabla con los elementos de cada item
    private function createTableItems($label,$items,$Obj){
        
        
        
        
        $table = "<table width='99%' border='1'><tr><td colspan=9><h4>$label</h4></td></tr>";
        
        $table .= "<tr><th width='400px'>Tipo de prueba</th>";
        $table .= "<th>Cumple</th>";
        $table .= "<th>No Cumple</th>";
        $table .= "<th width='32px'>1</th>";
        $table .= "<th width='32px'>2</th>";
        $table .= "<th width='32px'>3</th>";
        $table .= "<th width='32px'>4</th>";
        $table .= "<th width='32px'>5</th>";
        $table .= "<th td width='400px'>Observaciones</th></tr>"; 
        
        foreach ($items as $key=>$item){
            
            $Obj->item = $key;
            $Obj->Checklist_folio = $this->checklist_id;
            $Obj->processValues();
            
            $table .="<tr><td>$item</td>";
            $table .="<td>".$Obj->activity_ready()."</td>";
            $table .="<td>".$Obj->activity_non_ready()."</td>";
            $table .="<td>".$Obj->rate_1()."</td>";
            $table .="<td>".$Obj->rate_2()."</td>";
            $table .="<td>".$Obj->rate_3()."</td>";
            $table .="<td>".$Obj->rate_4()."</td>";
            $table .="<td>".$Obj->rate_5()."</td>";
            $table .="<td>".$Obj->comments()." </td></tr>";
            
            
        }
        
        
         
        $table .= '</table><br/>';
        
        echo $table;
       
        
    }
    
    // Metodo encargado de contruir la tabla con los elementos de cada item sin calificacion
    private function createTableItemsNonCal($label,$items,$Obj){
        
        
        $table = "<table width='99%' border='1'><tr><td colspan=9><h4>$label</h4></td></tr>";
        
        $table .= "<tr><th width='400px'>Tipo de prueba</th>";
        $table .= "<th>Cumple</th>";
        $table .= "<th>No Cumple</th>";
        $table .= "<th td width='400px'>Observaciones</th></tr>"; 
        
        foreach ($items as $key=>$item){
            
            $Obj->item = $key;
            $Obj->Checklist_folio = $this->checklist_id;
            $Obj->processValues();
            
            $table .="<tr><td>$item</td>";
            $table .="<td>".$Obj->activity_ready()."</td>";
            $table .="<td>".$Obj->activity_non_ready()."</td>";
            $table .="<td>".$Obj->comments()." </td></tr>";
            
            
        }
        
        
         
        $table .= '</table><br/>';
        
        echo $table;
       
        
    }
	function selectbyColumn($where,$like=false, $limit){
		$limit = isset($limit) ? $limit : 10;
		if($like){
			$like = "like";
			$simbol = "%";
		}else{
			$like = "=";
			$simbol = "";
		}
		if($where){
			foreach($where as $apuntador => $v){
				$datos_[]=$apuntador." $like '".$v."$simbol'";
			}
				$datos_where = " where ";
				$datos_where .= implode(" AND ",$datos_);		
		}else{
			$datos_where = '';
		}
		$db = new manejaDB();					
		$db->query("select * from ".$this->db_activities." ".$datos_where." order by support_activities_id DESC limit $limit");
		$result = $db->getArrayAsoc();						
		$result = ($result)? $result : false ;
		$db->desconectar();
		return($result);
	}
    
    
}
    
?>