<?php 
header("Content-type: text/xml");
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_link.php');


$link = new InventoryLink($_GET['folio_id']);
$link->stock_id = $_GET['id'];
$link->checkbox = (isset( $_GET['check']  ))?true:false;
$link->gridLink();


?>