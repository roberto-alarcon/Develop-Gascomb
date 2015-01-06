<?php 
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_bills.php');


$id_proveedor = '241';
$no_factura = 'AA1234';

$factura = new InventoryControlBills();
echo $factura->gridBySupplierAndBill($id_proveedor , $no_factura);


?>