<?php
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.inventory_control.php');

$action = $_GET['action'];
$id		= $_GET['id'];

print_r($_GET);

$intances = new InventoryControl();


if($action == 'update'){
	
	$intances->updateInventory( $id );
	
}elseif ($action == 'new'){
	
	$intances->addInventory();
	
}



?>