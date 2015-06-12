<?php

include_once('class.gascomb.logs.php');
//include_once('class.folio.php');

//Clase controladora de alertas
Class Alerts extends Logs{
	
        var $Menssage;
	var $Area_Origin;
	var $Area_Request;
	var $folio_id;
	
	var $user_id;
	
    public function __construct ($user_id = 0){
        
        $this->user_id = $user_id;    
    }
    
    
    // Cargamos el usuario
    public function loadUser($user_id = 0){
	
        $this->user_id = $user_id;
            
    }
    
    public function totalRows(){
		
        $db = new manejaDB();
        $query = "SELECT count(1) as total FROM alert where status=0 and user_id=".$this->user_id.";";
        $db->query($query);
        $rows = $db->getArray();
        $total = $rows["total"];
        $db->desconectar();
        return $total;
	
    }
	
    public function doRows(){
	
	$db = new manejaDB();
        $query = "SELECT * FROM alert where status=0 and user_id=".$this->user_id." order by datetime desc";
	$db->query($query);
		
	if( $db->numLineas() != 0 ){
		
            $table = "<table width='99%' border='1'>";
            $table .= "<tr><th width='40px'>Fecha</th>";
            $table .= "<th width='40px'>Folio</th>";
			$table .= "<th width='40px'>Torre</th>";
            $table .= "<th width='40px'>Area</th>";
            $table .= "<th width='500px'>Mensaje</th>";
            $table .= "<th width='50px'>Status</th></tr>";
            
            while( $rows = $db->getArray() ){
							
							$db1 = new manejaDB();
							$db1->query("select tower from folios where folio_id= '".$rows['folio_id']."'");
							
							$result = $db1->getArray();
							//print_r($result);exit(0);
							$db1->desconectar();
							if(!empty($result)){
								$tower=$result["tower"];
							}else{ 
								$tower = "";
							}
							
                            $table .="<tr><td>".date('d/m/Y H:i:s',$rows['datetime'])."</td>";
                            //$table .="<td>".$rows['folio_id']."</td>";
							$table .='<td><a href="http://mobile-gantt.gascomb.com/update_task_form.php?folio='.$rows['folio_id'].'&tab=2&subtab=2">'.$rows['folio_id'].'</a></td>';
							$table .="<td>".$tower."</td>";
                            $table .="<td>".$rows['area']."</td>";
                            $table .="<td>".$rows['message']."</td>";
                            $table .="<td>".$rows['status']."</td></tr>";
                                                    
                            
            }
            
            $table.= '</table>';
            echo $table;
        }
        
        
        
        $db->desconectar();
		
		
    }
	
    
    // Entrada de datos 
    public function doAlert(){
	
       // echo 'Area que solicita: '.$this->Area_Origin->area.'<br>';
       // echo 'Area que recibe: '.$this->Area_Request->area.'<br>';
       // echo 'ID que recibe: '.$this->Area_Request->Manager().'<br>';
       // echo $this->Menssage;

        $data = array(
                'user_id'=>$this->Area_Request->Manager(),
                'folio_id'=>$this->folio_id,
                'area'=>$this->Area_Origin->area,
                'status'=>0,
                'datetime'=>time(),
                'message'=>$this->Menssage
        
        );
        
        if (is_array($data)){
                $db = new manejaDB();			
                if($id = $db->makeQueryInsert('alert',$data)){
                        $result = $id;
                        
                        //return($result);           		
                }				
                $db->desconectar();
                $db->mensaje();
        }
	
    }	


}

Class Alert_BD{

	var $Boss_type 	= 0;
	
	// Obtenemos el encargado de cada area
	public function getManager(){
		
            $db = new manejaDB();
            $query = "SELECT user_id FROM office_boss where office_boss_id = ".$this->Boss_type.";";
            $db->query($query);
            
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $user_id = $rows['user_id'];
                                    
                        
                }
    
            }
        
            $db->desconectar();
            return $user_id;
	
	}
        
        
        //Obtenemos el encargo del vehiculo por medio de un folio
        public function getManagerByFolio(){
            
            global $Gascomb;
            $folio = $Gascomb->session_folio();
            
            $db = new manejaDB();
            $query = "SELECT mechanic_assigned FROM folios where folio_id='".$folio."';";
            $db->query($query);
            
            if( $db->numLineas() != 0 ){
                    
                while( $rows = $db->getArray() ){
                        
                        $mechanic_assigned = $rows['mechanic_assigned'];
                                    
                        
                }
    
            }
        
            $db->desconectar();
            return $mechanic_assigned;
            
            
            
        }
        
        
	

}



// Clase controladora de alertas recepcion
Class Alert_Reception extends Alert_BD {

	var $area 	= 'Recepcion';
	
	
	// Obtenemos al encargado de recepcion 
	public function Manager(){
		
		$this->Boss_type = 1;
		return $this->getManager();
	}
	
	
	public function alert(){
		echo 'Alerta '.$this->area.'<br>';
		echo $this->Manager();
	}

}



// Clase controlado de alertas calidad
Class Alert_Quality extends Alert_BD{

	var $area	= "Calidad";
	
	// Obtenemos al encargado de recepcion 
	public function Manager(){
		
		$this->Boss_type = 3;
		return $this->getManager();
	}
	
	
	public function alert(){
		echo 'Alerta '.$this->area.'<br>';
		echo $this->Manager();
	}

}




// Clase controladora de alertas de Piso 
Class Alert_Floor extends Alert_BD{

	var $area	= "Jefe de Piso";
	
	// Obtenemos al jefe de piso asiganado segun el folio
        public function Manager(){
	    	
            return $this->getManagerByFolio();
         		
	}
	
	
	public function alert(){
		echo 'Alerta '.$this->area;
	}

}


/*-----------------------------------
 *Class Alert_Stock
 *----------------------------------*/

Class Alert_Stock extends Alert_BD{
	
	var $area	= "Almacen";
	
	// Obtenemos al encargado de recepcion 
	public function Manager(){
		
		$this->Boss_type = 2;
		return $this->getManager();
	}
	
	public function alert(){
		echo 'Alerta '.$this->area.'<br>';
		echo $this->Manager();
		
	}

}


?>