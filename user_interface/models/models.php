<?php
//ini_set('display_errors', '1');
include_once('/home/gascomb/develop_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.models.php");

$id = isset($_GET["id"])? $_GET["id"] : '1';

if(isset($_GET["action"]) && $_GET["action"] == 'get'){
		header ("Content-Type:text/xml");
			$db = new manejaDB();
			$db->query("select * from support_models_vehicular where support_brand_vehicular_id = '".$id."'");
			$result = $db->getArrayAsoc();			
			echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
			foreach ($result as $valor) {
				echo "<row id='".$valor["support_models_vehicular_id"]."'>";				
				$db->query("select * from support_brand_vehicular where support_brand_vehicular_id='".$valor["support_brand_vehicular_id"]."'");
				$brand = $db->getArrayAsoc();
				$brand = isset($brand[0]["brand"])? $brand[0]["brand"] : "";
				echo "<cell>".$valor["model"]."</cell>";
				echo "<cell>".$valor["type"]."</cell>";
				echo "</row>";
			}	
			echo "</rows>";	
			$db->desconectar();
}
if(isset($_GET["action"]) && $_GET["action"] == 'add'){
	
		$marca = $_POST['id'];
		$modelo = $_POST['modelo'];
		$tipo	= $_POST['tipo'];
		
		$db = new manejaDB();	
		$db->query("insert into support_models_vehicular (support_brand_vehicular_id,model,type) values (".$marca.",'".$modelo."','".$tipo."')");
		$db->desconectar();
	
}

if(isset($_GET["action"]) && $_GET["action"] == 'delete'){
	if(isset($_GET["id"]) && $_GET["id"] !== ''){
		$db = new manejaDB();
		$db->query("delete from support_models_vehicular where support_models_vehicular_id = '".$_GET["id"]."'");
		$db->desconectar();
		echo "true";
	}
}


// Obtenemos valores del modelo
if(isset($_GET["action"]) && $_GET["action"] == 'getValues'){
	if(isset($_GET["id"]) && $_GET["id"] !== ''){
		$db = new manejaDB();
		$db->query("select * from support_models_vehicular where support_models_vehicular_id = '".$_GET["id"]."'");
		$result = $db->getArrayAsoc();
		$json = json_encode($result);
		echo $json;
		
		
		$db->desconectar();
		
	}
}

// Actualizamos los valores del modelo
if(isset($_GET["action"]) && $_GET["action"] == 'update'){
	if(isset($_GET["id"]) && $_GET["id"] !== ''){
		
		$marca = $_POST['id'];
		$modelo = $_POST['modelo'];
		$tipo	= $_POST['tipo'];
		
		$db = new manejaDB();
		$db->query("update support_models_vehicular set model='".$modelo."',type='".$tipo."' where support_models_vehicular_id = '".$_GET["id"]."'");
		$result = $db->getArrayAsoc();
		$json = json_encode($result);
		echo $json;
		
		
		$db->desconectar();
		
	}
}


?> 
