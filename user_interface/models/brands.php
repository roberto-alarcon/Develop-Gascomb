<?php
//ini_set('display_errors', '1');

include_once('/home/gascomb/develop_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.models.php");
//print_r($_POST); die;

if(isset($_GET["action"]) && $_GET["action"] == 'get'){
			header ("Content-Type:text/xml");
			$db = new manejaDB();
			$db->query("select * from support_brand_vehicular");
			$result = $db->getArrayAsoc();
			array_sort_by_column($result, 'brand');
			echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";			
			foreach ($result as $valor) {
				echo "<row id='".$valor["support_brand_vehicular_id"]."'>";
				echo "<cell>".$valor["brand"]."</cell>";
				echo "</row>";
			}
			$db->desconectar();
			echo "</rows>";
}

if(isset($_GET["action"]) && $_GET["action"] == 'add'){
	if(isset($_POST["marca"]) && $_POST["marca"] !== ''){
		$db = new manejaDB();
		$brand = addslashes(strtoupper($_POST["marca"]));
		$db->query("insert into support_brand_vehicular (brand) values ('".$brand."')");
		$db->desconectar();
	}
}

if(isset($_GET["action"]) && $_GET["action"] == 'delete'){
	if(isset($_GET["id"]) && $_GET["id"] !== ''){
		$db = new manejaDB();
		$db->query("delete from support_brand_vehicular where support_brand_vehicular_id = '".$_GET["id"]."'");
		$db->desconectar();
		echo "true";
	}
}

			
//Funcion para ordenar array por un valor
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	$sort_col = array();
	foreach ($arr as $key=> $row) {
		$sort_col[$key] = $row[$col];
	}

	array_multisort($sort_col, $dir, $arr);
}


?> 
