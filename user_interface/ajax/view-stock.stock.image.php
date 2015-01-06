<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$id = $_GET['id'];
	$stock = new Stock();
	$image 		= $stock->getImagebyId($id);
	if($image){
	
		echo '<img src="'.$image.'" width="500px">';
	}else{
		
		echo file_get_contents('./system.msj.php', true);
	}
	
?>