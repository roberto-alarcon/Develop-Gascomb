<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$id 		= $_POST['id'];
	$comments	= $_POST['comments'];
	$status		= $_POST['status'];
	
		
	$stock 		= new Stock();
	$update 	= $stock->updateCommentsAndStatus($id,$comments,$status);
	
	echo '{"result":"'.$update.'"}';
	
?>