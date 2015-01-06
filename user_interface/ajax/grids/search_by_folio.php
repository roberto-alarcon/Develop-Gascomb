<?php
//ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
 if (isset($_GET['id']) && ($_GET['id'] != '')){
		$value = $_GET['id'];		
		$typesearch = isset($_GET['type']) ? $_GET['type'] : "";
		$values["folio_id"] = $value;			
 }else{
	$values = null;
 }
$Folio = new Folio;
$vehicle = new Vehicle;


$tipo_de_combustible = array(
			     'GASOLINA' => 1,
			     'DIESEL'	=> 2,
			     'GAS CARBURANTE' => 3
			     );

 if (isset($_GET['getmodel'])){
	$foliodata = $Folio->selectbyId($value);
	if($foliodata){
		echo isset($foliodata["support_models_vehicular_id"])? $foliodata["support_models_vehicular_id"] : "";
	}	
 }elseif(isset($_GET['getcontract'])){
	$foliodata = $Folio->selectbyId($value);
	if($foliodata){
		echo isset($foliodata["contract_id"])? $foliodata["contract_id"] : "";
	}
	
	
 }elseif(isset($_GET['getfuel'])){
	       
	$Folios = $Folio->selectbyColumn($values, 20);
	
	$id_vehicle = $Folios[0]["vehicles_record_id"];
	$vehic = $vehicle->selectbyId($id_vehicle);
	echo ucfirst ( strtolower ( $vehic["fuel"] ) );
 
	
 }else{

	$Folios = $Folio->selectbyColumn($values, 20);
	
	$id_vehicle = $Folios[0]["vehicles_record_id"];
	$vehic = $vehicle->selectbyId($id_vehicle);
	

	if($Folios){
		echo "<data>";
		//vehicles data
			echo "<economic_number><![CDATA[".$vehic["economic_number"]."]]></economic_number>";		
			echo "<engine_number><![CDATA[".$vehic["engine_number"]."]]></engine_number>";		
			echo "<year><![CDATA[".$vehic["year"]."]]></year>";		
			echo "<cilinders><![CDATA[".$vehic["cilinders"]."]]></cilinders>";		
			echo "<km><![CDATA[".$vehic["km"]."]]></km>";
			echo "<fuel><![CDATA[".$tipo_de_combustible[ $vehic["fuel"] ]."]]></fuel>";
		
		foreach ($Folios as $clave => $valor) {	
			foreach ($valor as $item => $value) {
				echo "<$item><![CDATA[".utf8_encode($value)."]]></$item>";		
			}			
		}
		echo "</data>";
	}else{
		echo "<data>";
		echo "</data>";
	}
}
?>
