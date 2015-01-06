<?php 
// Enviamos la informacion del formulario para ingresar una entrada
// Version 1.0
// ******* Return *******
// {"return": 0 / 1}

header("Content-type: text/json");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_purchase.php');


// Formato de prueba este se reemplaza por el formulario //

$hoy = time();
$_POST['id_inventory'] = 291;
$_POST['numero'] = 15;
$_POST['precio_unitario'] = 14.80;
$_POST['proveedor'] = 241;
$_POST['tipo_pago'] = 1;
$_POST['no_factura'] = 'AA1234';
$_POST['fecha_facturacion'] = $hoy ;
$_POST['code'] = "1234";


$compra = new InventoryControlPurchase();
$compra->id_inventory_control = 291;
$compra->insert();

//print_r($_POST);




?>