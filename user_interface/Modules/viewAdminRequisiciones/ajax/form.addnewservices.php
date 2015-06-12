<?php
header('Content-Type: text/xml; charset=iso-8859-1');
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once PATH_CLASSES_FOLDER.'class.inventory_aditional_services.php';

$id = $_GET['id'];

$services = new Adicional_Sevices($id);
$services->addNewServices();

?>

