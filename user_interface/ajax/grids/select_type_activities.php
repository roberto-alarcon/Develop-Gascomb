<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.type_activities.php");
$type_act = new Type_activities;		
$type_acts = $type_act->selectRows(100);
if($type_acts){
	echo "<data>";
	foreach ($type_acts as $clave => $valor) {							
					echo "<item value='".$valor["support_type_activities_id"]."' label='".utf8_encode($valor["name"])."'/>";
					
				}
	echo "</data>";
}else{
	echo "<data>";					
					echo "<item value='null' label='--'/>";					
	echo "</data>";
}	
?>