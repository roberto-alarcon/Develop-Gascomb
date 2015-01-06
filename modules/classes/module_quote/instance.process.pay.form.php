<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.details.php';

$id 		= $_POST['request_id'];
$supplier	= $_POST['supplier'];
$pago 		= new Quote_Pay_Form( $id , $supplier);
$pago->request_tipo_de_pago	= $_POST['tipo_pago'];
$pago->actualizaFormulario();

?>