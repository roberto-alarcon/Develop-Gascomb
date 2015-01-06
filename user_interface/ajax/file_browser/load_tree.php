<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
$folio_id = isset($_GET['folio_id']) ? $_GET['folio_id'] : 31 ;
$folio = new Folio;
$folio->getxml_Multimedia($folio_id);

?>