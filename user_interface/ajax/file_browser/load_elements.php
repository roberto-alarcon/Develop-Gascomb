<?php
// Include configuration

ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');

$folio = $_GET['folio_id'];
$file = $_GET['file'];

$ext = explode(".", $file);
if(isset($ext[1])){

		$ext = $ext[1];
		
		if($ext == "jpg"){ 
				$path = PATH_MULTIMEDIA.$folio."/images/".$file;
				echo '<img src="'.$path.'" width=800px/>';
		}
		
		if($ext == "png"){ 
				$path = PATH_MULTIMEDIA.$folio."/images/".$file;
				echo '<img src="'.$path.'" width=800px/>';
		}
		
		
		if($ext == "pdf"){ 
			header('Content-type: application/pdf');
			readfile(PATH_MULTIMEDIA.$folio."/pdf/".$file);
		}

}
	
?>
