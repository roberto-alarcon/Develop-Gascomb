<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.stock.mobile.php';
$autorize_user = $Gascomb->session_user_id();
$folio_id = $_REQUEST["folio"];
$Stock = new Stock;
$status = '0';

if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'autorize'){
	$status = "1";
}elseif(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'cancel'){
	$status = "2";
	
}else{
	$status = '0';
}

	if(isset($_REQUEST["products"])){
		$products = explode(",",$_REQUEST["products"]);
		
		foreach($products as $product){					
				
				$result = $Stock->autorizeRequisition($product,$autorize_user,$status);
				
				
		}
		if($result=='true'){
							
				$stock_id = $Stock->getStockId($folio_id);
				$Stock->checkTreeActive( $stock_id );
				
				
				//if(!$Stock->pendingStockDetails($stock_id)){					
				$proceso 	= new statusPendingRequisition($folio_id);				
				$Gascomb->createStatus($proceso);
				//}
			echo 'true';		
			
		}else{
			echo 'false';
		}
	}

?>