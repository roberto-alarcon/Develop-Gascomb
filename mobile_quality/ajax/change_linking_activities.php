<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
	
	$folio_id		= $_GET['folio'];
	$checklistfolio	= $_GET['checklistfolio'];
	$activity		= $_GET['activity'];
	
	$CheckList = new Checklist($folio_id);
	
	
	
	if ( $_GET['action'] == 'add' ){
	
		if ( $CheckList->linkingChangeActivity($checklistfolio) ) {
			
			echo 'true';
		}else{
		
			echo 'false';
		}
		
	}
	
?>