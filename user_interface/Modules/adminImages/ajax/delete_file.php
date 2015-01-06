<?php

	include_once('/home/gascomb/secure_html/config/set_variables.php');
	$file 			= $_POST['file'];
	$folio_origen 		= $_POST['folio_origen'];
	 	
	$extension = explode('.', $file);
	switch ($extension[1]){
		case 'png':
		case 'jpg':
		case 'gif':
		
			//Amamos path
			$shell = 'rm -fr '.PATH_MULTIMEDIA_BASE.'/'.$folio_origen.'/images/'.$file;	
			break;
		
		case 'pdf':
			$shell = 'rm -fr '.PATH_MULTIMEDIA_BASE.'/'.$folio_origen.'/pdf/'.$file;
			
			break;
			
	}
	
	echo $shell;
	exec($shell,$output);
	
	
	
?>