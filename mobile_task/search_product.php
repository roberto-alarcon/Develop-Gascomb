<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once(PATH_CLASSES_FOLDER.'class.stock.php');		
$stock = new Stock;
if(isset($_REQUEST["q"]) && $_REQUEST["q"] != "" ){
	$text = $_REQUEST["q"];
	$limit = '100';
	$where = array("product"=>$text);
	$products = $stock->searchProduct($where,true,$limit);
	foreach($products as $product){	
		$prod["support_stock_product_id"] = $product["support_stock_product_id"];	
		$prod["product"] = utf8_encode($product["product"]);
		$productresult[] = $prod;
	}
	echo json_encode($productresult);
}	

?>