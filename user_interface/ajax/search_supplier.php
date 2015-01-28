<?php

include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once(PATH_CLASSES_FOLDER.'class.options.php');		

$typesuppliers = new Options;
if(isset($_REQUEST["mask"]) && $_REQUEST["mask"] != "" ){
	
	$text = $_REQUEST["mask"];
	$limit = '100';
	$where = array("nombre"=>$text);
	$suppliers = $typesuppliers->selectbyColumn($where,true,$limit);	
	if($suppliers){
		echo '<?xml version="1.0"?><complete>';
		foreach($suppliers as $supplier){
			echo '<option value="'.$supplier["id_proveedor"].'"><![CDATA['.utf8_decode($supplier["nombre"]).']]></option>';
			
		}
		echo '</complete>';
	}else{
		
	}
}	

?>