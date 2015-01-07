<?php 
header("Content-type: text/xml");
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_link.php');


$link = new InventoryLink($_GET['folio_id']);
$link->id_inventory_control = $_GET['id_inventory_control'];
$link->stock_details_id = $_GET['stock_detail_id'];
$link->createLinkByPurchaseDetails();


?>