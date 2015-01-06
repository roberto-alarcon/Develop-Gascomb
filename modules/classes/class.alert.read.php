<?php
/*
 * Clase encargada de realizar la lectura y la administracion de alertas
 *
 */

include_once('manejaDB.php');
include_once('class.folio.php');
include_once('class.vehicles.php');
include_once('class.dependency.php');
 
class Alert_Read {
    
    var $user_id;
	var $module_link  = 'gantt';
    
    function __construct ($user_id = 0){
        
        $this->user_id = $user_id;
        
    }
	
	/* Funcion para debbug tabla 
	BORRA TODOS LOS ELEMENTOS DE LA TABLA*/
	private function clearTable(){
	
		$db = new manejaDB();
		$query = "truncate alert";
		$db->query($query);
		return true;
		
	}
    
    
    public function doRows(){
	
		$db = new manejaDB();
		$query = "SELECT * FROM alert where status=0 and user_id=".$this->user_id." order by datetime desc";
		$db->query($query);
		
		if( $db->numLineas() != 0 ){
		
			$table = "<table width='99%' border='1'>";
			$table .= "<tr><th width='40px'>Fecha</th>";
			$table .= "<th width='40px'>Folio </th>";
                        $table .= "<th width='40px'>Torre</th>";
			$table .= "<th width='40px'>Area que Notifica</th>";
			$table .= "<th width='500px'>Mensaje</th></tr>";
			
			
			while( $rows = $db->getArray() ){
					
                                        
                                        $folio = new Folio();
                                        $info_folio = $folio->selectbyId($rows['folio_id']);
                                        $torre = $info_folio['tower'];
                                            			
					$table .="<tr><td>".date('d/m/Y H:i:s',$rows['datetime'])."</td>";
					
					if ($this->module_link == 'gantt'){ 
					
					switch ($rows['code']){
					
						case '#task':
							$table .='<td><a href="./update_task_form.php?folio='.$rows['folio_id'].'&tab=2&subtab=2" data-ajax="false">'.$rows['folio_id'].'</a></td>';
							break;
							
						case '#mech_floor':
							$table .='<td><a href="./admin_requisition_authorize.php?folio='.$rows['folio_id'].'&tab=3&subtab=3" data-ajax="false">'.$rows['folio_id'].'</a></td>';
							break;
						
						
						default:
							$table .="<td>".$rows['folio_id']."</td>";	
							break;
					
					
					}
					
					}else{
					
						$table .="<td>".$rows['folio_id']."</td>";	
					
					}
					
					
					$table .="<td>".$torre."</td>";
                    $table .="<td>".$rows['area']."</td>";
					$table .="<td>".$rows['message']."</td></tr>";
					
								
					
			}
			
			$table.= '</table>';
			echo $table;
                }
        
        
        
        $db->desconectar();
		
		
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
    
    
}



?>