<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$id = $_POST['id'];
	$stock = new Stock();
	$comments 	= $stock->getCommentsbyId($id);
	$image 		= $stock->getImagebyId($id);
	$status		= $stock->getStatus($id);
	echo '{"comments":"'.$comments.'","status":"'.$status.'"}';
?>