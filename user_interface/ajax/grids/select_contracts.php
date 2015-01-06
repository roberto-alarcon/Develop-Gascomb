<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.contracts.php');
$dependency_id = isset($_REQUEST["id"])? $_REQUEST["id"] : 2;
$xml = isset($_REQUEST["xml"])?true:false;

$contr = new Contract;
$contractos = $contr->selectbyDependency($dependency_id);

if($xml){

	if($contractos){
		echo "<data>";
		foreach ($contractos as $clave => $valor) {															
						echo "<item value='".$valor["contract_id"]."' label='".utf8_encode($valor["contract_number"])."'/>";
						//echo "<option value='".$valor["contract_id"]."' label='".utf8_encode($valor["contract_id"])."'/>";
					}
		echo "</data>";
	}else{
		echo "<data>";					
						echo "<item value='null' label='--'/>";					
		echo "</data>";
	}
	

}else{

	if($contractos){
		echo "<select id='contract_id'>";
		foreach ($contractos as $clave => $valor) {															
						//echo "<item value='".$valor["contract_id"]."' label='".utf8_encode($valor["contract_id"])."'/>";
						echo "<option value='".$valor["contract_id"]."' label='".utf8_encode($valor["contract_number"])."'/>";
					}
		echo "</select>";
	}else{
		echo "<select id='emails'>";					
						echo "<option value='null' label='--'/>";					
		echo "</select>";
	}

}


?>
