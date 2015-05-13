<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'phpqrcode/qrlib.php'; 
    ob_start();
	$folio_id = $folio['folio_id'];
	$PNG_TEMP_DIR = PATH_MULTIMEDIA_BASE."/".$folio_id."/_qrcode/";
	if(is_dir($PNG_TEMP_DIR)==false){
				//shell_exec("mkdir -p ".$PNG_TEMP_DIR.";"); 
				mkdir("$PNG_TEMP_DIR", 0777,true);		// Create directory if it does not exist
			}    
    $filename = $PNG_TEMP_DIR."qrcode.png";
	QRcode::png($folio_id, $filename, "Q", 5, 2);
	$imageqrcode = str_replace("[id_folio]", $folio_id, QR_IMAGE_URL);	
	
?>