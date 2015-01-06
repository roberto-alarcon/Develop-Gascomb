<?php
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.brand_vehicle.php");
$brands = new brandVehicle;		
$brand = $brands->selectRows(150);
array_sort_by_column($brand, 'brand');		
echo "<data>";
if($brand){
	foreach ($brand as $clave => $valor) {															
		echo "<item value='".$valor["support_brand_vehicular_id"]."' label='".$valor["brand"]."'/>";
	}
}else{
	echo "<item value='0' label='--";
}	
echo "</data>";

//Funcion para ordenar array por un valor
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	$sort_col = array();
	foreach ($arr as $key=> $row) {
		$sort_col[$key] = $row[$col];
	}

	array_multisort($sort_col, $dir, $arr);
}
?>
