<?php
ini_set('display_errors',1);

include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.stock.mobile.php';
$id_user = $Gascomb->session_employee_id();
$folio_id = $_REQUEST["folio"];

$Stock = new Stock;
$stock_id = $Stock->getStockId($folio_id);

if(isset($_REQUEST["products"])){
	$products = json_decode($_REQUEST["products"], true);
	$now = time();
	//print_r($products);exit(0);
	foreach($products as $product){
		
		if($product["producto_id"] !== ''){
			$_REQUEST['stock_id'] = $stock_id;	
			//si no existe el producto, agregar
			if (!preg_match("/[0-9]/i", $product["producto_id"])) {
				$producto['id_product'] = '0';
				//$newproduct = utf8_encode($product["producto_id"]);
				$newproduct = strtr(strtoupper($product["producto_id"]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$newproduct = utf8_decode($newproduct);
				
				$producto['product'] = $newproduct;
				$producto['code'] ="";
				$producto['unit'] ="";
				$producto['price']  ="";
				$producto['line']  ="";
				$producto['brand']  ="";
				
				$id = $Stock->insertUpdateProducts($producto);
				$product["producto_id"] = $id;
			}
			$_REQUEST['support_stock_product_id'] = $product["producto_id"];		
			$_REQUEST['quantity'] = $product["cantidad"];
			$_REQUEST['comments'] = $product["comentario"];
			$_REQUEST['request_user_id'] = $id_user;
			$_REQUEST['authorize_user_id'] = '';
			$_REQUEST['creation_datetime'] = $now;
			$_REQUEST['unit'] = $product["unit"];
			$_REQUEST['engine'] = $product["engine"];
			$result = $Stock->createNewDetailProduct();
			
		}
	}
	if($result){
		//Cambiar status a pendiente de requisición		
		$pendientereq 	= new statusPendingRequisition($folio_id);		
		$Gascomb->createStatus($pendientereq);
		echo 'true';
	}else{
		echo 'false';
	}	
}

?>