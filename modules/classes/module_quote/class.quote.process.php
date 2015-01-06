<?php
error_reporting(-1);
/*
 *  Clase para procesar Formularios de Cotizacion Electronica
 *  Roberto Alarcon
 *  roberto.alarcon@tours360.com.mx
 *  03/09/2013
 */

include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.upload.php';
include_once MODULES_CLASES.'manejaDB.php';
include_once MODULES_CLASES_QUOTE.'PHPMailer-master/class.phpmailer.php';
 
Class Quote_Process{
    
    var $array_pathImage;
    var $requisition_id;
    var $request_quote_details_id;
	var $request_quote_id;
    
    private function multimediaImageDIR(){
	
		$_annio = date('Y');
		$dir_dest = PATH_MULTIMEDIA_STOCK.$_annio.'/';
		if(!is_dir($dir_dest)){
			mkdir($dir_dest, 0775, true);
		}
		
		return $dir_dest;
		
		
	}
	
	//Inserta y regresa en un array el total de imagenes //
    public function uploadImage(){
        
        global $_POST;
        global $_FILE;
        $this->requisition_id = $_POST['general_requisicion_id'];
        // set image path 
        
	// Generamos un directorio por año
	$path_images = $this->multimediaImageDIR();
	$dir_dest = $path_images.$this->request_quote_details_id;
        $dir_pics = $path_images.$this->request_quote_details_id;
		
        
        // Controlador de imagenes		
		if (isset($_POST['imageControl'])) {
        
            // ---------- MULTIPLE UPLOADS ----------
            $array_image_file    = array();
            $array_image = $_POST['imageControl'];
			
			foreach( $array_image as $file ){
                
                $name_array = explode('_',$file);
                $name_file = $name_array[1];
								
                $handle = new Upload($_FILES[$file]);
                if ($handle->uploaded) {
        
                                
                    $handle->image_resize               = true;
                    $handle->image_ratio_y              = true;
                    $handle->image_x                    = 600;
                    $handle->image_text                 = 'Grupo Automotriz en Servicios de Combustibles, S.A. de C.V.';
                    $handle->image_text_color           = '#FFFFFF';
                    $handle->image_text_position        = 'BL';
                    $handle->image_text_padding_x       = 10;
                    $handle->image_text_padding_y       = 2;
                    $handle->file_new_name_body         = $name_file;
                    $handle->Process($dir_dest);
        
                    // we check if everything went OK
                    if ($handle->processed) {
                        
                        $array_image_file[$name_file] = $dir_pics.'/' . $handle->file_dst_name;
                        
                        
                    } else { /*Ocurrio un error*/ }
        
                } else {  /*no se subio la imagen*/  }
                
        
            } 
        
        }
        
        //print_r($array_image_file);
        
        $this->array_pathImage = $array_image_file;
        
        
    }
    
    public function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
    
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
    
    
    private function time_set($digit,$type){
        
        $now = time();
        
        switch ($type) {
            case 'hr':
                
                $cadena ='+'.$digit .'hours';
                
                break;
            
            case 'day':
                
                if( $digit == '1'){
                    $cadena ='+'.$digit .'day';
                }else{
                    $cadena ='+'.$digit .'days';
                } 
                
                
                break;
            
        }
        
        $time_set = strtotime($cadena, $now);
        return $time_set;
        
        
    }
	
	public function createDir(){
	
		$directory = PATH_MULTIMEDIA_STOCK.$this->requisition_id;
		if(!is_dir($directory)){			
			mkdir($directory, 0775);
		}
		
		return $directory;
	
	}
    
    public function insertFormStep1(){
        
        global $_POST;
        $this->requisition_id = $_POST['general_requisicion_id'];
        // Insetamos datos en la tabla request_quote
        
		//Creamos directorios
		$dir 		= $this->createDir();
		$guid		= $this->gen_uuid();
		$time_set	= $this->time_set($_POST['general_configTime'],$_POST['general_configDate']);
			
        $data = array(
                'guid'=> $guid,
                'requisition_id' => $_POST['general_requisicion_id'],
                'folio_id' => $_POST['general_folio_id'],
                'user_request' => $_POST['general_userRequest'],
                'user_auth' => $_POST['general_userAuth'],
                'pay_form' => $_POST['general_payForm'],
                'time_request' => time(),
                'time_set' => $time_set,
                'status' => 1,
                'comments'=> $_POST['general_comments']
                
                );
        
        
        
        if (is_array($data)){
                $db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);		
                if($id = $db_stock->makeQueryInsert(TABLE_request_quote,$data)){
                        $result = $id;
						$this->request_quote_details_id = $id;
                        //$db_stock->desconectar();
                        //return($result);           		
                
                    // Ordenamos listado para realizar el insert de detalles
                    if (isset($_POST['imageControl'])) {
                    
                        // ---------- MULTIPLE UPLOADS ----------
                        $array_image = $_POST['imageControl'];
                        foreach( $array_image as $file ){
                            
                            $name_array = explode('_',$file);
                            $id = $name_array[1];
                            
                            if(!isset($_POST['form_'.$id.'_stock'])){
                                
                                $data_details = array(
                                                      
                                        'guid'              =>$this->gen_uuid(),
                                        'request_quote_id'  =>$result,
                                        'stock_details_id'  =>$id,
                                        'sku'               =>'sku',
                                        'quantity'          =>$_POST['form_'.$id.'_quantity'],
                                        'unity'             =>$_POST['form_'.$id.'_unity'],
                                        'description_part'  =>$_POST['form_'.$id.'_description_part'],
                                        'image_path'        =>(isset($this->array_pathImage[$id])) ? $this->array_pathImage[$id] : '' ,
                                        's1_id'             =>(isset( $_POST['s1_'.$id.'_check'] )) ? $_POST['general_supplier1'] : '0',
                                        's2_id'             =>(isset( $_POST['s2_'.$id.'_check'] )) ? $_POST['general_supplier2'] : '0',
                                        's3_id'             =>(isset( $_POST['s3_'.$id.'_check'] )) ? $_POST['general_supplier3'] : '0',
                                        's4_id'             =>(isset( $_POST['s4_'.$id.'_check'] )) ? $_POST['general_supplier4'] : '0',
                                        's5_id'             =>(isset( $_POST['s5_'.$id.'_check'] )) ? $_POST['general_supplier5'] : '0'
                                        
                                        
                                                      
                                );
                                
                                //print_r($data_details);
                                
                                if (is_array($data_details)){
									//$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);		
									if($id = $db_stock->makeQueryInsert(TABLE_request_quote_details,$data_details)){
											//$db_stock->desconectar()
									}
                                }                                               
                            }
                        }
                    }
                }
                
                $db_stock->desconectar();
				
		// Notificamos por correo electronico 
		$this->sendMail( $guid , $result , $time_set);
               
        }
        
        
    }
	
	// Metodo encargado de mandar notificaciones a los proveedores
	/*
	* @ GUID string // Elemento de la tabla request_quote
	* @ $request_quote_id int // Numero con el que se genera al detalle
	* El mail se divide en 2 pasos:
	* Paso 1 .- Generamos archivo txt 
	*/
	public function sendMail($guid , $request_quote_id , $time_set){
	
		// Obtenemos la lista de proveedores
		
		if( $suppliers = $this->getQuoteSuppliers($request_quote_id) ){
			
			foreach( $suppliers as $id_supplier => $concentrado ){
			
				$url = URL_FORM_EMAIL.'?token='.$guid.'&item_supplier='.md5($id_supplier);
				$anchor_text = $url;
				$send_mail = $concentrado['mail_1'];
				$send_name = $concentrado['name'];
							
				//Create a new PHPMailer instance
				$mail = new PHPMailer();
				// Set PHPMailer to use the sendmail transport
				$mail->IsSendmail();
				//Set who the message is to be sent from
				$mail->SetFrom(EMAIL_SEND, EMAIL_NAME);
				//Set an alternative reply-to address
				$mail->AddReplyTo(EMAIL_SEND,EMAIL_NAME);
				//Set who the message is to be sent to
				$mail->AddAddress($send_mail, $send_name);
				//Set the subject line
				$mail->Subject = 'Solicitud de requisicion #'.$request_quote_id;
				//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
						
				//echo TEMPLATE_EMAIL;
				$bodytag = str_replace('{URL}',$url,file_get_contents(TEMPLATE_EMAIL));
				$bodytag = str_replace('{ANCHOR_TEXT}',$anchor_text,$bodytag);
				$bodytag = str_replace('{TIME_SET}',date('d/m/Y H:i:s', $time_set ),$bodytag);
				echo $bodytag;
				
				$mail->MsgHTML($bodytag, dirname(__FILE__));
				//Replace the plain text body with one created manually
				$mail->AltBody = 'This is a plain-text message body';
				
				//Send the message, check for errors
				
				if(!$mail->Send()) {
				  echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
				  echo "Message sent! ".$send_mail;
				}
			
			}
		
		}
	
	
	}
	
	
	public function getQuoteSuppliers($request_quote_id){
	
		$suppliers = array();
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		
		// Proveedor 1;
		for($i=1; $i<=5; $i++){
			
			$query = "SELECT s".$i."_id FROM request_quote_details where request_quote_id = '$request_quote_id' and s".$i."_id > 0;";
			$db_stock->query($query);
			
			if( $db_stock->numLineas() != 0 ){
			
				while( $rows = $db_stock->getArray() ){
						
						$suppliers[] = $rows[0];
	
				}
			}
			
		}
		
		$db_stock->desconectar();
				
		$suppliers = array_unique($suppliers);
		
		
		// Obtenemos los datos del proveedor 
		if(count($suppliers) > 0){
			foreach ($suppliers as $id_supplier){
			
				$the_suppliers[$id_supplier] = $this->getAllDataSupplier($id_supplier);
			
			}
			
			return $the_suppliers;
		}else{
			return 0;
		}
	
	}
	
	// Obtenemos toda la informacion de un proveedor por medio de un ID
	public function getAllDataSupplier($id){
	
		$supplier = array();
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$query = "SELECT * FROM support_suppliers where support_suppliers_id = $id;";
		$db_stock->query($query);	
		if( $db_stock->numLineas() != 0 ){
		
			while( $rows = $db_stock->getArray() ){
					
					$supplier['support_suppliers_id'] = $rows['support_suppliers_id'];
					$supplier['name'] = $rows['name'];
					$supplier['address'] = $rows['address'];
					$supplier['phone1'] = $rows['phone1'];
					$supplier['phone2'] = $rows['phone2'];
					$supplier['mail_1'] = $rows['mail_1'];
					$supplier['mail_2'] = $rows['mail_2'];
					$supplier['type'] = $rows['type'];
					
			}
		}
		
		$db_stock->desconectar();
		
		return $supplier;
	
	}
	
	public function insertFormStep2(){
		global $_POST;
		$this->requisition_id 	= $_POST['general_requisicion_id'];
		$this->request_quote_id	= $_POST['request_quote_id'];
		$this->realoadBuyDeatils();
		// Procesamos el arreglo para dejar unicamente los elementos checkbok
		$array_compra = $_POST;
		
		unset($array_compra['general_requisicion_id']);
		unset($array_compra['general_folio_id']);
		unset($array_compra['request_quote_id']);
		
		try {
			foreach($array_compra as $indice => $value){
				
				$insert_explode = explode("_", $indice );
				$insert_supplier = $insert_explode[0];
				$insert_item = $insert_explode[1];
				
				
				$this->updateBuyDetail($insert_supplier , $insert_item );
				
				
			}
			
			// Actualizamos status de compra
			$this->updateBuyStatus(1);
			
			
			
			echo '<h2>Formulario Guardado</h2>';
		} catch (Exception $e) {
			echo '<h2>Error al guardar el formulario</h2>';
		}

	}
	
	
	public function updateBuyStatus( $status = 0 ){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$data = array( 'buy_status' => $status);
		$where = array( 'request_quote_id'=>$this->request_quote_id );
		$db_stock->makeQueryUpdate(TABLE_request_quote,$data,$where);
		$db_stock->desconectar();
	
	}
	
	
	
	public function realoadBuyDeatils(){
		
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		$data = array( 's1_buy' => 0 ,
					   's2_buy' => 0 ,
					   's3_buy' => 0 ,
					   's4_buy' => 0 ,
					   's5_buy' => 0);
		$where = array( 'request_quote_id'=>$this->request_quote_id );
		$db_stock->makeQueryUpdate(TABLE_request_quote_details,$data,$where);
		$db_stock->desconectar();
		
		
	
	}
	
	
	public function updateBuyDetail( $supplier , $item ){
	
		$supplier_colum = $supplier.'_buy';
		$db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
		
		$data = array( $supplier_colum => 1 );
		$where = array('request_quote_details_id' => $item , 'request_quote_id'=>$this->request_quote_id );
		if($db_stock->makeQueryUpdate(TABLE_request_quote_details,$data,$where)){
			$db_stock->desconectar();
		}
		
		
		
	
	
	}
    
    
}


?>
