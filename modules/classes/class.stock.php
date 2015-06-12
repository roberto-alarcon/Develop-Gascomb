<?php
/**************************************************************
* Clase: stock, Controla vista Stock
*
* @access public 
* @since 02/04/2013  
**************************************************************/

include_once 'manejaDB.php';
include_once('class.users.php');
include_once('class.employees.php');

	class Stock{
	
		//@ properties
		var $path_multimedia 		= PATH_MULTIMEDIA;
		VAR $path_multimedia_base	= PATH_MULTIMEDIA_BASE;
		var $path_config			= '../../user_interface/xml/';
		var $table_stock 			= 'stock';
		var $table_stock_details	= 'stock_details';
		var $table_stock_products	= 'support_stock_product';
		var $requisition			= 0;
		var $folio					= 0;
		var $user_id				= 0;
		var $stock_id				= 0;
		var $authorize_user_id		= 0;
		var $status					= array(
											'pendiente'=>0,
											'entregado'=>1,
											'cancelado'=>2,
											'en espera proveedor'=>3,
											'no lo ha recogido el mecanico' => 4,
											'espera de autorizacion' => 5,
											'cotizando' => 6,
											'vinculado' => 7
											);
		
		var $status_auth			= array('pendiente' => 0 , 'autorizado' => 1 , 'cancelado' => 2 );
		
		
	
		 public function __construct ($folio = 0){
			$this->folio = $folio;
		 }
		
		//@ methods
		public function showPath(){
		
			echo $this->path_multimedia;
		}
		
		// // Metodo para obtener el stock_id atraves de un folio 
		public function stockID(){
		
			$db = new manejaDB();
			$query= "";
		
		}
		
		
		// Method insert;
		public function createNewRequisition(){
			global $Gascomb;
			//Bug 1.0
			// Verificamos que el Folio no se haya insertado antes
			$this->getStockId($this->folio);
			if($this->stock_id == 0){
						
				$data = array(
						 'folio_id' => $this->folio,
						 'creation_datetime' => time(),
						 'status' => 1,
						 );
				
				$result = 0;
				if (is_array($data)){
					$db = new manejaDB();			
					if($id = $db->makeQueryInsert($this->table_stock,$data)){
						$result = $id;
						
						$Gascomb->systemLog('Se creo el folio de requisicion #'.$result);	
					}				
					echo $db->mensaje();
				}
				
				$db->desconectar();
				return($result);
			
			}
				
		}
		
		public function createNewDetailProduct(){
			global $_REQUEST;
			
			
			$this->createDirImage($_REQUEST['creation_datetime']);
			
			$data = array(
					 'stock_id' => $_REQUEST['stock_id'],
					 'support_stock_product_id' => $_REQUEST['support_stock_product_id'],
					 'request_user_id' => $_REQUEST['request_user_id'],
					 'authorize_user_id' =>$_REQUEST['authorize_user_id'],
					 'creation_datetime' => $_REQUEST['creation_datetime'],
					 'quantity' => $_REQUEST['quantity'],
					 'status' => '0',
					 'path_image' => (isset($_REQUEST['image'])) ? $this->path_multimedia.$this->folio.'/requisiciones/'.$_REQUEST['creation_datetime'].'/'.$_REQUEST['image'] : 'null',
					 'comments' => $_REQUEST['comments']
					 );
					 
			$db = new manejaDB();			
				if($id = $db->makeQueryInsert($this->table_stock_details,$data)){
					$result = $id;
					$db->desconectar();
					return($result);           		
				}				
				echo $db->mensaje();
			
		
		}
		
		public function autorizeRequisition($id_product,$user_id,$status){
			
			$datos = array('status_auth'=>$status,'authorize_user_id'=>$user_id,'delivery_datetime' => time());
			$where = array('stock_details_id'=>$id_product);
			$db = new manejaDB();			
			if($db->makeQueryUpdate($this->table_stock_details,$datos,$where)){
				$result = true;
			}else{
					$result = $db->mensaje();
			}
			$db->desconectar();				
			return $result;
		
		}
		
		
		public function closeRequisition($id){
		
			$datos = array('status'=>1);
			$where = array('stock_id'=>$id);
			$db = new manejaDB();			
			if($db->makeQueryUpdate($this->table_stock,$datos,$where)){
				$wtchfl = new Watchful();
				$wtchfl->subAction("to close");
				$wtchfl->logRegistry($this->table_stock,"update",$this->getFolioId());
			}	
			$db->desconectar();	
			echo $db->mensaje();

		}
		
		public function activeRequisition($id){
		
			$datos = array('status'=>1);
			$where = array('stock_id'=>$id);
			$db = new manejaDB();			
			if($db->makeQueryUpdate($this->table_stock,$datos,$where)){
				
				
			}	
			$db->desconectar();	
			echo $db->mensaje();

		}
		
		// Este metodo de encarga de valida que no haya ordenes pendientes
		// Para cambiar a status 2
		public function updateStockStatusLink($stock_detail_id){
			
			$db = new manejaDB();
			$query = "Update stock_details set status='7',delivery_datetime='".time()."' where stock_details_id = '".$stock_detail_id."';";
			$db->query($query);
			$db->desconectar();
			
		}
		
		// Metodo encargado de controlar el estado la columna tree_active
		public function checkTreeActive( $stock_id ){
			
			$array_status = array(
							'activo' => 1,
							'cerrado' => 0
							);
			
			$db = new manejaDB();
			$select = "select * from stock_details where stock_id = '".$stock_id."' and status_auth = 1 and status not in (1,2)";
			$db->query($select);
			
			if( $db->numLineas() != 0 ){
				
				// Activo 
				$status = $array_status['activo'];
				
			}else{
				
				// Inactivo 
				$status = $array_status['cerrado'];
				
			}
			
			$update = "Update stock set tree_active = '".$status."' where stock_id = '".$stock_id."'";
			$db->query($update);
			
			
			$db->desconectar();
			
			
		}
		
		
		public function updateCommentsAndStatus($id_detail,$comments,$status,$id_stock=0){
			
			global $Gascomb;
			$db = new manejaDB();
						
			$query = "Update stock_details set comments='".$comments."',status='".$status."',delivery_datetime='".time()."' where stock_details_id = '".$id_detail."';";
			$db->query($query);
			$db->desconectar();	
			
			// Agregamos nuestro log
			$stock_id = $this->getStockIdByDetails($id_detail);
			$folio_id = $this->getFolioId($stock_id);
			//echo $folio_id;
			
			// Comprobamos si aun tenemos un elementos pendiente de los contrario
			// actualizamos la columna tree_active
			$this->checkTreeActive( $stock_id );
			
			
			//Obtenemos el nombre del material
			$support_product_id = $this->getIDProductByDetails($id_detail);
			$name_product 		= $this->getNameProductbyID($support_product_id);	 
			$status_name 		= "";
			foreach($this->status as $key => $v){
				
				if($v == $status){
				
					$status_name = $key;
					break;
				}
			
			}
						
			$Gascomb->session_folio($folio_id);
			$Gascomb->log('Se a cambiado el producto '.$name_product.' a status '.$status_name);
			
			return true;
			/*
			$datos = array(
						'comments' => $comments,
						'status' => $status
			);
			
			$where = array('stock_details_id'=>$id_stock);
			$return = 'false';
			$db = new manejaDB();			
			if($db->makeQueryUpdate($this->table_stock_details,$datos,$where)){
				$db->desconectar();	
				$return = 'true';
				         		
			}
			
			//$this->walkStockDetails($id_stock);
			*/
			
				
			
		
		}
		
		public function walkStockDetails($id_stock){
			$db = new manejaDB();
			$select = "SELECT count(stock_details_id) FROM stock_details WHERE stock_id = '".$id_stock."' AND status = '0' "; //dame todos losp pendientes
			$db->query($select);
			if( $db->numLineas() == 0 && $id_stock!=0 ){	//ya no hay pendientes, solo entregados y cancelados
				$this->closeRequisition($id_stock);				
			}
		}
		
		public function pendingStockDetails($id_stock){
			$db = new manejaDB();
			$select = "SELECT count(stock_details_id) FROM stock_details WHERE stock_id = '".$id_stock."' AND status = '0' "; //dame todos losp pendientes
			$db->query($select);
			$rows = $db->getArray();	
			if( $rows[0] == 0){	//ya no hay pendientes, solo entregados y cancelados
				$return = false;			
			}else{
				$return = true;
			}
			return $return;
			
		}
		
		public function getIDProductByDetails($id){
		
			$db = new manejaDB();
			$query = "SELECT support_stock_product_id FROM stock_details where stock_details_id = '".$id."'";
			$db->query($query);
			$rows = $db->getArray();
			$support_stock_product_id = $rows["support_stock_product_id"];
			$db->desconectar();
			return $support_stock_product_id;
			
		
		
		}
		
		public function getNameProductbyID($id){
		
			$db = new manejaDB();
			$query = "SELECT product FROM support_stock_product where support_stock_product_id =  '".$id."'";
			$db->query($query);
			$rows = $db->getArray();
			$product = $rows["product"];
			$db->desconectar();
			return $product;
		
		}
		
		public function getStockIdByDetails($id){
		
			$db = new manejaDB();
			$query = "SELECT stock_id FROM stock_details where stock_details_id = '".$id."'";
			$db->query($query);
			$rows = $db->getArray();
			$this->stock_id = $rows["stock_id"];
			$db->desconectar();
			return $this->stock_id;
			
		
		}
		
		public function getFolioId($stock_id){
			$db = new manejaDB();
			$select = "SELECT folio_id FROM stock WHERE stock_id = '".$stock_id."'";
			$db->query($select);
			$rows = $db->getArray();
			$this->folio = $rows["folio_id"];
			$db->desconectar();
			return $this->folio;
		}
		
		public function getStockId($folio_id){
			$db = new manejaDB();			
			$select = "SELECT stock_id FROM stock WHERE folio_id = '".$folio_id."'";
			$db->query($select);
			$rows = $db->getArray();
			$db->desconectar();		
			if(isset($rows["stock_id"]) && $rows["stock_id"] !== ''){
				$this->stock_id = $rows["stock_id"];
			}else{
				$this->stock_id = 0;
			}
			return $this->stock_id;
		}
		
		public function makeTreeXml(){
		
			// Get all open requisitions.
			$array_tree = array();
			 
			 $db = new manejaDB();
			 $db->query("select * from ".$this->table_stock." where status = '1'");
			 
			if( $db->numLineas() != 0 ){
		
				while( $rows = $db->getArray() ){
					$array_tree[] = array(
						'folio'=>$rows['folio_id'],
						'stock_id' => $rows['stock_id']
					);			
					
				}
			
			$db->desconectar();
		
			}
			
			$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.="\n";		
			$xml.='<tree id="0">';
			$xml.="\n\t";
			$xml.='<item text="Root - Activas ('.count($array_tree).')" id="root" open="1" im0="lock.gif" im1="lock.gif" im2="iconSafe.gif" call="1" select="1">';
			$xml.="\n\t";
			
			foreach($array_tree as $indice => $value){
			
				$xml.='<item text="(Requisicion:'.$value['stock_id'].' / Folio:'.$value['folio'].')" id="'.$value['stock_id'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
				$xml.="\n\t";
				
				
				// Nodos internos
				$db = new manejaDB();
				$select = "select distinct creation_datetime from ".$this->table_stock_details." where stock_id = '".$value['stock_id']."'";
				$db->query($select);
				
				if( $db->numLineas() != 0 ){
		
					while( $rows = $db->getArray() ){
						$txt_fecha = date('d/m/y H:i', $rows['creation_datetime']);
						
						$xml .='<item text="'.$txt_fecha.'" id="'.$rows['creation_datetime'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif"></item>';
						$xml.="\n\t";						
						
					}
								
					$db->desconectar();
			
				}
				
				$xml.='</item>';
				$xml.="\n\t";

			}
			
			$xml.='</item>';
			$xml.="\n";
			$xml.='</tree> ';

			// Generamos archivo estatico
			
			$ar= fopen($this->path_config."view-stock.stock.treeFileBrowser.xml","w+") or die("Problemas en la creacion");
			fputs($ar,$xml);
			fclose($ar);
				
			
		}
		
		
		public function makeDynamicTreeXml($folio = false){
		
			// Get all open requisitions.
			$array_tree = array(); 
			$db = new manejaDB();
			$select = "select * from ".$this->table_stock." where status = '1'";
			
			if($folio){
				$select = "select * from ".$this->table_stock." where status = '1' and folio_id = '".$this->folio."'";
			}
			
			//echo $select;
			
			$db->query($select);
			 
			if( $db->numLineas() != 0 ){
		
				while( $rows = $db->getArray() ){
					$array_tree[] = array(
						'folio'=>$rows['folio_id'],
						'stock_id' => $rows['stock_id']
					);			
					
				}
			
			$db->desconectar();
		
			}
			
			// generate xml
			$xml = '<?xml version="1.0" encoding="iso-8859-1"?>';
			$xml.="\n";		
			$xml.='<tree id="0">';
			$xml.="\n\t";
			$xml.='<item text="Root - Activas ('.count($array_tree).')" id="root" open="1" im0="lock.gif" im1="lock.gif" im2="iconSafe.gif" call="1" select="1">';
			$xml.="\n\t";
			
			foreach($array_tree as $indice => $value){
			
				$xml.='<item text="(Requisicion:'.$value['stock_id'].' / Folio:'.$value['folio'].')" id="'.$value['stock_id'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif">';
				$xml.="\n\t";
				
				
				// Nodos internos
				$db = new manejaDB();
				$select = "select distinct creation_datetime from ".$this->table_stock_details." where stock_id = '".$value['stock_id']."'";
				$db->query($select);
				
				if( $db->numLineas() != 0 ){
		
					while( $rows = $db->getArray() ){
						$txt_fecha = date('d/m/y H:i', $rows['creation_datetime']);
						
						$xml .='<item text="'.$txt_fecha.'" id="'.$rows['creation_datetime'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif"></item>';
						$xml.="\n\t";						
						
					}
								
					$db->desconectar();
			
				}
				
				$xml.='</item>';
				$xml.="\n\t";

			}
			
			$xml.='</item>';
			$xml.="\n";
			$xml.='</tree> ';
			
			print $xml;
			
			
		
		}
		
		
		
		
		public function initGridByCreationDatetime($datetime){
			$User = new Users;
			$employee = new Employee;
			$db = new manejaDB();
			$select = 'SELECT 
						'.$this->table_stock_details.'.stock_details_id,
						'.$this->table_stock_details.'.stock_id,
						'.$this->table_stock_details.'.quantity,
						'.$this->table_stock_details.'.status,
						'.$this->table_stock_details.'.request_user_id,
						'.$this->table_stock_details.'.authorize_user_id,
						'.$this->table_stock_details.'.delivery_datetime,
						'.$this->table_stock_details.'.delivery_user_id,
						'.$this->table_stock_details.'.comments,
						'.$this->table_stock_products.'.product,
						'.$this->table_stock_products.'.code_product


						FROM '.$this->table_stock_details.'
						INNER JOIN '.$this->table_stock_products.'
						ON '.$this->table_stock_details.'.support_stock_product_id='.$this->table_stock_products.'.support_stock_product_id
						
						WHERE
						'.$this->table_stock_details.'.creation_datetime = "'.$datetime.'"';
						
						
			
			$db->query($select);
			
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml.="\n";
			$xml.= '<rows>';
			$xml.="\n\t";
			
			if( $db->numLineas() != 0 ){
				
				while( $rows = $db->getArray() ){
					//$Nameuser = ($User->getName($rows['request_user_id'])) ? $User->getName($rows['request_user_id']) : "";
					$Nameuser = ($employee->getName($rows['request_user_id'])) ? $employee->getName($rows['request_user_id']) : "";
					$AuthName = ($User->getName($rows['authorize_user_id'])) ? $User->getName($rows['authorize_user_id']) : "";
					
					$status = 'Pendiente';
					foreach($this->status as $indice => $value){
						
						if( $rows['status'] == $value ){
							$status = ucwords( $indice );
						};
					
					}
						$fechaentrega = ($rows['delivery_datetime'] !== '0') ? date('d/m/Y H:i:s',$rows['delivery_datetime']): '';
						$xml.= '<row id="'.$rows['stock_details_id'].'">';
						$xml.= '<cell>'.$rows['product'].'</cell>';
						$xml.= '<cell>'.$rows['quantity'].'</cell>';
						$xml.= '<cell>'.utf8_decode($Nameuser).'</cell>';
						$xml.= '<cell>'.utf8_encode($AuthName).'</cell>';
						$xml.= '<cell>'.$status.'</cell>';
						$xml.= '<cell>'.$fechaentrega.'</cell>';
						$xml.= '<cell>'.trim( $rows['comments'] ).'</cell>';
						$xml.= '</row>';
						$xml.="\n\t";
						
						//echo $rows['stock_details_id'].'<br/>';
					
				}
							
				$db->desconectar();
		
			}
			
			$xml.='</rows>';
			
			
			echo $xml;
			
		
		}
		
		public function initGridByStockID($stock_id){
			$User = new Users;
			$employee = new Employee;
			$db = new manejaDB();
			$select = 'SELECT 
						'.$this->table_stock_details.'.stock_details_id,
						'.$this->table_stock_details.'.stock_id,
						'.$this->table_stock_details.'.quantity,
						'.$this->table_stock_details.'.status,
						'.$this->table_stock_details.'.request_user_id,
						'.$this->table_stock_details.'.authorize_user_id,
						'.$this->table_stock_details.'.delivery_datetime,
						'.$this->table_stock_details.'.delivery_user_id,
						'.$this->table_stock_details.'.comments,
						'.$this->table_stock_products.'.product,
						'.$this->table_stock_products.'.code_product


						FROM '.$this->table_stock_details.'
						INNER JOIN '.$this->table_stock_products.'
						ON '.$this->table_stock_details.'.support_stock_product_id='.$this->table_stock_products.'.support_stock_product_id
						
						WHERE
						'.$this->table_stock_details.'.stock_id = "'.$stock_id.'" and
						'.$this->table_stock_details.'.status_auth = 1';
						
						
			
			$db->query($select);
			
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml.="\n";
			$xml.= '<rows>';
			$xml.="\n\t";
			
			if( $db->numLineas() != 0 ){
				
				while( $rows = $db->getArray() ){
					//$Nameuser = ($User->getName($rows['request_user_id'])) ? $User->getName($rows['request_user_id']) : "";
					$Nameuser = ($employee->getName($rows['request_user_id'])) ? $employee->getName($rows['request_user_id']) : "";
					$AuthName = ($User->getName($rows['authorize_user_id'])) ? $User->getName($rows['authorize_user_id']) : "";
					
					$status = 'Pendiente';
					foreach($this->status as $indice => $value){
						
						if( $rows['status'] == $value ){
							$status = ucwords( $indice );
						};
					
					}
						$img_status = ( $rows['status'] == 7 )?'https://sistema.gascomb.com/img/chekbox_true.png':'';
						
						$fechaentrega = ($rows['delivery_datetime'] !== '0') ? date('d/m/Y H:i:s',$rows['delivery_datetime']): '';
						$xml.= '<row id="'.$rows['stock_details_id'].'-'.$rows['status'].'">';
						$xml.= '<cell>'.$img_status.'</cell>';
						$xml.= '<cell>'.$rows['product'].'</cell>';
						$xml.= '<cell>'.$rows['quantity'].'</cell>';
						$xml.= '<cell>'.utf8_decode($Nameuser).'</cell>';
						$xml.= '<cell>'.utf8_encode($AuthName).'</cell>';
						$xml.= '<cell>'.$status.'</cell>';
						$xml.= '<cell>'.$fechaentrega.'</cell>';
						$xml.= '<cell>'.trim( utf8_decode($rows['comments']) ).'</cell>';
						$xml.= '</row>';
						$xml.="\n\t";
						
						//echo $rows['stock_details_id'].'<br/>';
					
				}
							
				$db->desconectar();
		
			}
			
			$xml.='</rows>';
			
			
			echo $xml;
			
		
		}
		
		
		
		public function deleteProducts($id){
			$db = new manejaDB();
			$select = "DELETE FROM ".$this->table_stock_products." WHERE support_stock_product_id='".$id."'";
			$db->query($select);
			$db->desconectar();
			
		}
		
		public function gridAllProduct($inicial,$final,$cadena){
		
			$db = new manejaDB();
			if($cadena == 'null'){
				$select = "SELECT * FROM support_stock_product LIMIT $inicial , $final";
			}else{
				$select = "SELECT * FROM support_stock_product Where product like '%$cadena%' LIMIT $inicial , $final";
			}
			
			$db->query($select);
			
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml.="\n";
			$xml.= '<rows>';
			$xml.="\n\t";
			
			if( $db->numLineas() != 0 ){
				
				while( $rows = $db->getArray() ){
				
									
						$xml.= '<row id="'.$rows['support_stock_product_id'].'">';
						$xml.= '<cell>'.$rows['support_stock_product_id'].'</cell>';
						$xml.= '<cell>'.str_replace('&',' ',$rows['product']).'</cell>';
						$xml.= '<cell>'.$rows['code_product'].'</cell>';
						$xml.= '<cell>'.$rows['unit'].'</cell>';
						$xml.= '<cell>'.$rows['price'].'</cell>';
						$xml.= '<cell>'.$rows['line'].'</cell>';
						$xml.= '<cell>'.$rows['brand'].'</cell>';
						$xml.= '</row>';
						$xml.="\n\t";
						
						//echo $rows['stock_details_id'].'<br/>';
					
				}
							
				$db->desconectar();
		
			}
			
			$xml.='</rows>';
			
			
			echo $xml;
		
		}
		
		public function gridAllProductTotalRows($cadena){
			$db = new manejaDB();
			if($cadena == 'null'){
				$select = "SELECT COUNT( support_stock_product_id ) as total FROM support_stock_product";
			}else{
				$select = "SELECT COUNT( support_stock_product_id ) as total FROM support_stock_product Where product like '%$cadena%'";
			}
			
			
			$db->query($select);
			$return = 0;
			if( $db->numLineas() != 0 ){
				
				while( $rows = $db->getArray() ){
					$return = $rows['total'];
										
				}
							
				
		
			}
			$db->desconectar();
			return $return;
			
		}
		
		public function insertUpdateProducts($elementos){
			
			$db = new manejaDB();
			$tabla = $this->table_stock_products;
			$datos = array(
				'product'		=> $elementos['product'],
				'code_product'		=> $elementos['code'],
				'unit'			=> $elementos['unit'],
				'price'			=> $elementos['price'],
				'line'			=> $elementos['line'],
				'brand'			=> $elementos['brand']
			);
			
			if($elementos['id_product'] == '0'){
			
				$id = $db->makeQueryInsert($tabla,$datos);
				$db->desconectar();
				return $id;
				
				
			}else{
				//echo $elementos['id_product'];
				$where = array('support_stock_product_id'=>$elementos['id_product']);
				if($db->makeQueryUpdate($tabla,$datos,$where)){
					$db->desconectar();
					return $elementos['id_product'];
				          		
				}	
				
			}
			
		
		}
		
		public function getProductDetail($id){
		
			$db = new manejaDB();
			$select = "SELECT * FROM  support_stock_product WHERE  support_stock_product_id =".$id;
			$db->query($select);
			$return = 0;
			if( $db->numLineas() != 0 ){
				
				$rows = $db->getArray();
				$db->desconectar();
				return $rows;	
							
				
		
			}
		
		}
		
		
		public function getCommentsbyId($id){
		
			$db = new manejaDB();
			$select = "SELECT comments FROM stock_details where stock_details_id = '".$id."'";
			$db->query($select);
			$return = "";
			if( $db->numLineas() != 0 ){
	
				while( $rows = $db->getArray() ){
					$htmlnews = $rows['comments'];
					//$htmlnews = htmlentities($rows['comments']); //make remaining items html entries.
					$htmlnews = nl2br($htmlnews); //add html line returns
					$htmlnews = str_replace(chr(10), " ", $htmlnews); //remove carriage returns
					$htmlnews = str_replace(chr(13), " ", $htmlnews); //remove carriage returns
					$return = $htmlnews;					
				}
							
				
		
			}
			$db->desconectar();
			return $return;
		
		}
		
		public function getImagebyId($id){
			$db = new manejaDB();
			$select = "SELECT path_image FROM stock_details where stock_details_id = '".$id."'";
			$db->query($select);
			$return = false;
			if( $db->numLineas() != 0 ){
	
				while( $rows = $db->getArray() ){
					$return = $rows['path_image'];					
				}
							
				
		
			}
			$db->desconectar();
			return $return;
		
		}
		
		public function getStatus($id){
			$db = new manejaDB();
			$select = "SELECT status FROM stock_details where stock_details_id = '".$id."'";
			$db->query($select);
			$return = "";
			if( $db->numLineas() != 0 ){
	
				while( $rows = $db->getArray() ){
					$return = $rows['status'];					
				}
							
				
		
			}
			$db->desconectar();
			return $return;
		
		}
		
		
		private function createDirFolio(){
		
			if(!is_dir($this->path_multimedia_base.$this->folio)){
				// Creamos directorio
				//shell_exec("mkdir -p ".$this->path_multimedia_base.$this->folio.";"); 
				@mkdir($this->path_multimedia_base.$this->folio, 0777,true);
				
			}
			
		}
		
		
		private function createDirRequisiciones(){
		
			if(!is_dir($this->path_multimedia_base.$this->folio.'/requisiciones')){
				// Creamos directorio
				//shell_exec("mkdir -p ".$this->path_multimedia_base.$this->folio."/requisiciones;"); 
				@mkdir($this->path_multimedia_base.$this->folio.'/requisiciones', 0777,true);
				
			}
			
		}
		
		private function createDirImage($dir){
		
			$this->createDirFolio();
			$this->createDirRequisiciones();
			
			if(!is_dir($this->path_multimedia_base.$this->folio.'/requisiciones/'.$dir)){
				// Creamos directorio
				//shell_exec("mkdir -p ".$this->path_multimedia_base.$this->folio."/requisiciones/".$dir.";"); 
				@mkdir($this->path_multimedia_base.$this->folio.'/requisiciones/'.$dir, 0777,true);
				
			}
		
		}
		function getAllProducts(){ 
				$db = new manejaDB();
				$db->query("select * from ".$this->table_stock_products);
				$result = $db->getArrayAsoc();
				$result	= ($result)? $result : false;
				$db->desconectar();
				return($result); 						
		}
		
		function selectbyId($id){ 
				$db = new manejaDB();
				$db->query("select * from ".$this->table_stock." where stock_id = '".$id."'");
				$result = $db->getArray();	
				foreach ($result as $clave => $valor) {
					if(is_numeric($clave)) { unset($result[$clave]); }		
				}
				$db->desconectar();
				return($result); 						
		}
		
		function selectbyFolioId($id){ 
				$db = new manejaDB();
				$db->query("select * from ".$this->table_stock." where folio_id = '".$id."'");
				$result = $db->getArray();	
				if($result){
					foreach ($result as $clave => $valor) {
						if(is_numeric($clave)) { unset($result[$clave]); }		
					}
				}else{
					$result = false;
				}	
				$db->desconectar();
				return($result); 						
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
			$db->query("select * from ".$this->table_stock_products." ".$datos_where." order by support_stock_product_id DESC limit $limit");
			$result = $db->getArrayAsoc();						
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);
		}
		
		function searchProduct($where,$like=false, $limit){
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
					$datos_[]=$apuntador." $like '$simbol".$v."$simbol'";
				}
					$datos_where = " where ";
					$datos_where .= implode(" AND ",$datos_);		
			}else{
				$datos_where = '';
			}
            $db = new manejaDB();			
			$db->query("select support_stock_product_id,product from ".$this->table_stock_products." ".$datos_where." order by support_stock_product_id DESC limit $limit");
			$result = $db->getArrayAsoc();						
			$result = ($result)? $result : false ;
			$db->desconectar();
			return($result);
		}
		
		// Cambios 15-10-2014
		// Roberto Alarcon
		
		function getQuantityFromDetaisID($id){
			
			$db = new manejaDB();
			$select = "SELECT quantity FROM stock_details where stock_details_id = '".$id."'";
			$db->query($select);
			$return = "";
			if( $db->numLineas() != 0 ){
			
				$return = $db->getArrayAsoc();
			
			}
			$db->desconectar();
			return $return;
			
			
		}
		
	
	}
	
	
?>