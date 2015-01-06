<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	//echo PATH_MULTIMEDIA_BASE;
	
	$file 			= $_POST['file'];
	$folio1 	= $_POST['folio_origen'];
	$folio2 	= $_POST['folio_destino'];
	$tipo			= $_POST['tipo'];
	
	if( $tipo == 'destino' ){
	
		$folio_origen 	= $folio1;
		$folio_destino	= $folio2;
	
	}else{
	
		$folio_origen 	= $folio2;
		$folio_destino	= $folio1;	
	
	}
	
	
	
	$extension = explode('.', $file);
	
	switch ($extension[1]){
		case 'png':
			
			//Amamos path
			$path_origen_file = PATH_MULTIMEDIA_BASE.'/'.$folio_origen.'/images/'.$file;
			
			
			
			break;
		case 'pdf':
			$path_origen_file = PATH_MULTIMEDIA_BASE.'/'.$folio_origen.'/pdf/'.$file;
			
			break;
			
	}
	
	

	switch ( $_POST['dir_destino'] ){
	
		case 'images':
			$path_destino = PATH_MULTIMEDIA_BASE.'/'.$folio_destino.'/images/';
			break;
		case 'pdf':
			$path_destino = PATH_MULTIMEDIA_BASE.'/'.$folio_destino.'/pdf/';
			break;	
		
	
	}
	
	if(is_file($path_origen_file) && is_dir($path_destino) ){
	
		$shell = 'cp '.$path_origen_file.' '.$path_destino;
		echo $shell;
		exec($shell,$output);
		print_r($output);
	
	}
	
	
	//echo $path_origen_file;
	//echo $path_destino;
	
	
	
	//print_r($_POST);
?>