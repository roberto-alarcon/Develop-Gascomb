<?php
ini_set('display_errors', '1');
//header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.models.php");
$brand_id = isset($_REQUEST["id"])? $_REQUEST["id"] : 2;
$xml = isset($_REQUEST["xml"])?true:false;
$model = new models;		
$models = $model->selectbyBrand($brand_id);

if($xml){
	if($models && $xml){
		echo "<data>";
		foreach ($models as $clave => $valor) {							
						echo "<item value='".$valor["support_models_vehicular_id"]."' label='".$valor["model"]." ".$valor["type"]."'/>";
						
					}
		echo "</data>";
	}else{
		echo "<data>";					
						echo "<item value='null' label='--'/>";					
		echo "</data>";
	}	

}else{
	if($models){
		echo "<select id='support_models_vehicular_id'>";
		foreach ($models as $clave => $valor) {							
						echo "<option value='".$valor["support_models_vehicular_id"]."' label='".utf8_encode($valor["model"])." ".utf8_encode($valor["type"])."'>".utf8_encode($valor["model"])." ".utf8_encode($valor["type"])."</option>";
						
					}
		echo "</select>";
	}else{
		echo "<select id='support_models_vehicular_id'>";					
						echo "<option value='' label='--'/>";					
		echo "</select>";
	}

}

?>