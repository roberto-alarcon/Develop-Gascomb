<?php 
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_entrance.php');

$id_inventory_control = $_GET['id'];

$entrance = new InventoryControlEntrance();
$entrance->id_inventory_control = $id_inventory_control;
echo $entrance->gridHistory();

?>