<?php
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.pdf.php';
$PDF = new Quote_PDF();
$PDF->creaPDF();

?>