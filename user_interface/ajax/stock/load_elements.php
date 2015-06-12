<?php
// Include configuration
include_once('/home/gascomb/secure_html/config/set_variables.php'); 

$folio = '47890';
$file = $_GET['file'];

$path = PATH_MULTIMEDIA.$folio."/".$file;
echo '<img src="'.$path.'" width=800px/>';
	
?>
