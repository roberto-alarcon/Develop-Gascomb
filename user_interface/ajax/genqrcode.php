<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include PATH_CLASSES_FOLDER.'phpqrcode/qrlib.php';    

	$id_folio = 30;
	$PNG_TEMP_DIR = PATH_MULTIMEDIA_BASE."/".$id_folio."/_qrcode/";
	if(is_dir($PNG_TEMP_DIR)==false){
				
				shell_exec("mkdir -p ".$PNG_TEMP_DIR);
				mkdir("$PNG_TEMP_DIR", 0777);		// Create directory if it does not exist
			}    
    $filename = $PNG_TEMP_DIR."qrcode.png";
	QRcode::png($id_folio, $filename, "Q", 5, 2); 
	
	$imageqrcode = str_replace("[id_folio]", $id_folio, QR_IMAGE_URL);
	echo '<img src="'.$imageqrcode.'" />';	

?>