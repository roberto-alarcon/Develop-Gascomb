<?php
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.pdf.php';

$PDF = new Quote_PDF();
$PDF->proveedor = $_GET['proveedor'];
$PDF->id_electronico = $_GET['id_electronico'];
$PDF->requisicion = $_GET['folio'];
$PDF->creaPDFPorProveedor();

?>