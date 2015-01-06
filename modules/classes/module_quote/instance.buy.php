<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.buy.php';

$id = $_GET['id'];

$compra = new Quote_Buy($id);
$compra->generarCompra();

?>