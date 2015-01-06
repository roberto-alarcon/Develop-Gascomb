<?php
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.inventory_control_pdf.php');

// Instanciamos la clase
// Segunda linea brach master
$PDF = new Services_PDF('28866');
$PDF->creaPDF();
