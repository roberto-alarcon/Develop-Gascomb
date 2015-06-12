<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.process.php';

Class Quote_Process_Supplier extends Quote_Process{
    
    var $form_values    = array();
    
    function __construct ( ){
	global $_POST;
        
        if(empty($_POST)){
            
            die('<h1>Ocurrio un error favor de intentar mas tarde</h1>');
        }
        
        $this->form_values = $_POST;
       
        
	
    }
    
    public function update(){
        
        $ids    = $this->form_values['control'];
        $canal  = $this->form_values['canal']; 
        
        $db_stock = new manejaDB(BD_STOCK_USER,BD_STOCK_PASSWORD,BD_STOCK_DATABASE,BD_STOCK_SERVER);
        foreach ($ids as $id){
            
            $now = time();
            $data = array(
                    's'.$canal.'_brand' => $this->form_values['form_'.$id.'_brand'],
                    's'.$canal.'_comments' => $this->form_values['form_'.$id.'_comentarios'],
                    's'.$canal.'_unit_price' => $this->form_values['form_'.$id.'_punitario'],
                    's'.$canal.'_price' => $this->form_values['form_'.$id.'_total'],
                    's'.$canal.'_owner_name' => $this->form_values['form_owner'],
                    's'.$canal.'_time_request' => time()
                   );
               
                
		$where = array('request_quote_details_id'=>$id);
		if($db_stock->makeQueryUpdate(TABLE_request_quote_details,$data,$where)){
			$result = true;
			
		}
	   
            
        }
        
        $db_stock->desconectar();
        $this->mensajeWireFrame();
        
        
    }
    
    public function mensajeWireFrame(){
        
        $logo = '<img src="'.WEB_QUOTE_IMG.'logo.png">';	
        $table = '<br/><br/>
                <table width="500px">
                        <tr>
                        <th>'.$logo.'</th>
                        <th>GRUPO AUTOMOTRIZ EN SERVICIOS DE COMBUSTIBLES, S.A. DE C.V.</th>
                        </tr>
                        <tr>
                        <td colspan=2><b> La cotizacion fue guardada exitosamente !!! <br/><br/></b>Gracias por utilizar nuestro servicio en breve nos pondremos en contacto con ustedes.</th>
                        </tr> 
                </table>';
			
	echo $table;
        
    }
    
   
}

?>