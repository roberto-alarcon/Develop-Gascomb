<?php
	// Extends class for stock
	include_once('class.stock.php');
	include_once('class.users.php');
	include_once('class.employees.php');
	class Stock_mobile extends Stock {
	 
	 var $error_icon     = 'http://mobile-quality.gascomb.com/img/error-icon.png';
	 var $select_icon    = 'http://mobile-quality.gascomb.com/img/Select-icon.png';
	 var $pending_icon   = 'http://mobile-quality.gascomb.com/img/clock_red.png';

  	 public function __construct ($requisicion = 0){
			$this->requisition = $requisicion;
	}
	
	public function msj($mensaje){
	
		$div_return = '<div class="mensaje"> '.$mensaje.'</div>';
		return $div_return;
	}
  
    function getMobileList () {
        	
		// Get all elements for ID	
         $array_tree = array();	 
		 $db = new manejaDB();
		 $select = "SELECT DISTINCT creation_datetime, stock_id
					FROM  stock_details 
					WHERE stock_id ='".$this->requisition."' order by creation_datetime DESC";
		 
		 $db->query($select);
		 
		if( $db->numLineas() != 0 ){
	
			while( $rows = $db->getArray() ){
				$array_tree[] = array(
					'creation_datetime'=>$rows['creation_datetime'],
					'stock_id'=>$rows['stock_id']
				);			
				
			}
		
			$db->desconectar();
			
			if(count($array_tree)>0){
			
				foreach($array_tree as $v){
					
					echo "<div data-role=\"collapsible\" data-theme=\"c\" data-content-theme=\"c\" data-collapsed=\"false\">\n";
					echo "<h2> Solicitud: ".date('d/m/Y H:i:s',$v['creation_datetime'])."</h2>\n";
					echo "<ul data-role=\"listview\" data-theme=\"c\" data-divider-theme=\"c\">\n";
					echo "<li data-role=\"list-divider\">Requisici&oacuten # ".$v['stock_id']." </li>\n";
					
					$this->getElementsByDate($v['creation_datetime']);
					
					echo "</ul>\n";
					echo "</div>\n\n\n";
					
				}
				
			}else{
				echo $this->msj('No se han solicitado ninguna requisicion');
		
		}
		
		//return $array_tree;
	
		}else{
			echo $this->msj('No se han solicitado ninguna requisición');
		}
        
        
        
    }
	
	public function getElementsByDate($datetime){
		$User = new Users;
		$employee = new Employee;
		$db = new manejaDB();
		$select = 'SELECT 
					'.$this->table_stock_details.'.stock_details_id,
					'.$this->table_stock_details.'.stock_id,
					'.$this->table_stock_details.'.quantity,
					'.$this->table_stock_details.'.status,
					'.$this->table_stock_details.'.status_auth,
					'.$this->table_stock_details.'.delivery_datetime,
					'.$this->table_stock_details.'.delivery_user_id,
					'.$this->table_stock_details.'.request_user_id,
					'.$this->table_stock_details.'.comments,
					'.$this->table_stock_products.'.product,
					'.$this->table_stock_products.'.code_product


					FROM '.$this->table_stock_details.'
					INNER JOIN '.$this->table_stock_products.'
					ON '.$this->table_stock_details.'.support_stock_product_id='.$this->table_stock_products.'.support_stock_product_id
					
					WHERE
					'.$this->table_stock_details.'.creation_datetime = "'.$datetime.'"';
		$db->query($select);
		
		// Create the table 
		echo '<table width="100%" border="1" style="border-collapse:collapse;border: 1px solid #c0c0c0;" cellpadding="5" cellspacing="0">';
		echo '<tr><td><td><strong>Producto</strong></td><td><strong>Solicita</strong></td><td><strong>Estatus</strong></td><td><strong>Fecha de Modificacion</strong></td><td><strong>Comentarios</strong></td></tr>';	
		
		while( $rows = $db->getArray() ){
					//Empleado 
					$Nameuser = ($employee->getName($rows['request_user_id'])) ? $employee->getName($rows['request_user_id']) : "";
					// Tomamos los datos por nombre de usuario
					//$Nameuser = ($User->getName($rows['request_user_id'])) ?$User->getName($rows['request_user_id']) : "";
		
					
					
					switch($rows['status_auth']){
					 
					   				   
					   case 1:
					    $status_auth = $this->select_icon;
					    break;
					   
					   case 2:
					    $status_auth = $this-> error_icon;
					    break;
					   
					   case 0:
					   $status_auth = $this-> pending_icon;
					    break;
					 
					}
					
					//$status_auth = ($rows['status_auth'] == 1) ? $this->select_icon : $this-> error_icon;
					
					
					$status = 'Pendiente';
					foreach($this->status as $indice => $value){
						
						if( $rows['status'] == $value ){
							$status = ucwords( $indice );
						};
					
					}
				
						
						//echo '<li>';
						//echo  '<h3>'.$rows['product'].'</h3>';
						//echo '<p><strong>Solicita:</strong>Jose Luis Ortiz</p>';
						//echo '<p><strong>Estatus:</strong>'.$status.'</p>';
						//echo '<p><strong>Fecha Entrega:</strong>'.$rows['delivery_datetime'].'</p>';
						//echo '<p>'.nl2br ( $rows['comments'] ).'</p>';
						//echo '</li>';
												
						//echo $rows['stock_details_id'].'<br/>';
					$fechaentrega = ($rows['delivery_datetime'] !== '0') ? date('d/m/Y H:i:s',$rows['delivery_datetime']): 'Pendiente';
					echo '<tr>';
					echo '<td><img src="'.$status_auth.'"/></td>';
					echo '<td>'.utf8_encode($rows['product']).'</td>';
					echo '<td>'.utf8_encode($Nameuser).'</td>';
					echo '<td>'.$status.'</td>';
					echo '<td>'.$fechaentrega.'</td>';
					echo '<td>'.nl2br ( $rows['comments'] ).'</td>';
					echo '</tr>';
					
					
		}
					
		echo '</table>';			
		
		$db->desconectar();
		
		

	}
	
	public function getElementsPending($stock_id){
		$array_tree = array();	 
		 $db = new manejaDB();
		 $select = "SELECT DISTINCT creation_datetime
					FROM  stock_details 
					WHERE stock_id ='".$stock_id."' AND status_auth='0' order by stock_details_id DESC";
		
		 $db->query($select);
				
		if( $db->numLineas() != 0 ){
	
			while( $rows = $db->getArray() ){
				$array_tree[] = array(
					'creation_datetime'=>$rows['creation_datetime']
				);			
				
			}
		
			$db->desconectar();
			
			if(count($array_tree)>0){
				echo '<div class="ui-grid-b">
						<div class="ui-block-a">
							<a href="#" data-role="button" id="btnSelectAll" data-icon="plus">Seleccionar todo</a>
						</div>
						<div class="ui-block-b">
							<a data-role="button" id="btnCancel" data-icon="delete" href="#" >Cancelar</a><!--data-rel="dialog"-->
						</div>
						<div class="ui-block-c">
							<a data-role="button" id="btnAutorize"  data-theme="e" data-icon="check" href="#">Autorizar</a>
						</div>
					</div>';
				echo "<ul data-role='listview' data-inset='true'>";
				foreach($array_tree as $v){								
					
					$this->getElementsByDate1($v['creation_datetime']);															
				}
				echo "</ul>\n";					
				
			}else{
				echo $this->msj('No se han solicitado ninguna requisicion');
		
		}
		}else{
			echo $this->msj('No se han solicitado ninguna requisición');
		}
        
        
		
	}
	
	public function getElementsByDate1($datetime){
		$db = new manejaDB();
		$select = 'SELECT 
					'.$this->table_stock_details.'.stock_details_id,
					'.$this->table_stock_details.'.stock_id,
					'.$this->table_stock_details.'.quantity,
					'.$this->table_stock_details.'.status,
					'.$this->table_stock_details.'.status_auth,
					'.$this->table_stock_details.'.delivery_datetime,
					'.$this->table_stock_details.'.delivery_user_id,
					'.$this->table_stock_details.'.comments,
					'.$this->table_stock_products.'.product,
					'.$this->table_stock_products.'.code_product


					FROM '.$this->table_stock_details.'
					INNER JOIN '.$this->table_stock_products.'
					ON '.$this->table_stock_details.'.support_stock_product_id='.$this->table_stock_products.'.support_stock_product_id
					
					WHERE
					'.$this->table_stock_details.'.creation_datetime = "'.$datetime.'" AND '.$this->table_stock_details.'.status_auth = "0"';
		
		
		$db->query($select);
		
		if( $db->numLineas() != 0 ){
			echo '<li data-role="list-divider">'.date('d/m/Y H:i:s',$datetime).'</li>';										
			echo '<li><fieldset data-role="controlgroup">';		
				
				while( $rows = $db->getArray() ){
							$status = 'Pendiente';
							foreach($this->status as $indice => $value){
								
								if( $rows['status'] == $value ){
									$status = ucwords( $indice );
								};
							
							}				
									echo '<label for="'.$rows['stock_details_id'].'">'.utf8_encode($rows['product']).'</label>
									<input type="checkbox" class="products" name="'.$rows['stock_details_id'].'" id="'.$rows['stock_details_id'].'">';
							
				}					
			echo '</fieldset></li>';	
		}			
		
		$db->desconectar();
		
		

	}
	
}

?>