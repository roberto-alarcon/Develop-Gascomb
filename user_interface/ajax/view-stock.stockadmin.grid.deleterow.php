<?php	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once(PATH_CLASSES_FOLDER.'class.stock.php');
	$stock = new Stock();
	$id = $_POST['id'];
	$action_id = $stock->deleteProducts($id);
	echo '{"result":"true"}';
	
?>