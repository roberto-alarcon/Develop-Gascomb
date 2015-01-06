<?php
header("Content-type: text/xml");
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER."class.folio.php";
include_once PATH_CLASSES_FOLDER."class.vehicles.php";
 if (isset($_GET['id']) && ($_GET['id'] != '')){
		$value = $_GET['id'];		
		//$typesearch = $_GET['type'];
		$values["registration_plate"] = $value;			
 }else{
	$values = null;
 }
$Vehicle = new Vehicle;
$vehicles = $Vehicle->selectbyColumn($values, 1);
//print_r($vehicles);exit(0);

if($vehicles){
	echo "<data>";
	foreach ($vehicles as $clave => $valor) {		
				echo "<registration_plate><![CDATA[".$valor["registration_plate"]."]]></registration_plate>";
					echo "<economic_number><![CDATA[".$valor["economic_number"]."]]></economic_number>";				
					echo "<engine_number><![CDATA[".$valor["engine_number"]."]]></engine_number>";
					echo "<vin><![CDATA[".$valor["vin"]."]]></vin>";
					echo "<support_brand_vehicular_id><![CDATA[".$valor["support_brand_vehicular_id"]."]]></support_brand_vehicular_id>";
					echo "<support_models_vehicular_id><![CDATA[".$valor["support_models_vehicular_id"]."]]></support_models_vehicular_id>";
					echo "<owner_name><![CDATA[".utf8_encode($valor["owner_name"])."]]></owner_name>";
					echo "<owner_adress><![CDATA[".utf8_encode($valor["owner_adress"])."]]></owner_adress>";
					echo "<owner_phone><![CDATA[".$valor["owner_phone"]."]]></owner_phone>";
					echo "<owner_cell><![CDATA[".$valor["owner_cell"]."]]></owner_cell>";						
					echo "<owner_email><![CDATA[".$valor["owner_email"]."]]></owner_email>";
					echo "<owner_email2><![CDATA[".$valor["owner_email2"]."]]></owner_email2>";						
					echo "<year><![CDATA[".$valor["year"]."]]></year>";
					echo "<cilinders><![CDATA[".$valor["cilinders"]."]]></cilinders>";						
					echo "<km><![CDATA[".$valor["km"]."]]></km>";
					echo "<fuel><![CDATA[".$valor["fuel"]."]]></fuel>";						
				}
	echo "</data>";
}else{
	echo "<data>";
	echo "</data>";
}

?>