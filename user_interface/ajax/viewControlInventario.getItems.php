<?php 
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.inventory_control.php');

$intances = new InventoryControl();
$json = json_encode($intances->getValuesByID($_GET['id']));
echo $json;


?>