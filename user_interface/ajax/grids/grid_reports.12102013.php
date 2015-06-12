<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.tracing.php';
$Stock = new Stock;
$folio = new Folio;
$vehicles = new Vehicle;		
	

 if (isset($_GET['dependency']) && ($_GET['dependency'] != '')){
		
		$dependency_id = $_GET['dependency'];
		$date_ini = $_GET['date_init'];
		$date_fin = $_GET['date_final'];
		$mechanic_id = $_GET['mechanic_id'];
		$status = isset($_GET['status'])? $_GET['status'] :"0";
		
		$where = "";
		$datos_where = "";
		if($dependency_id !== "ALL"){
				$where = ($where == "")? " where " : " and ";
				$datos_where .= $where ."dependency_id = '".$dependency_id."' ";
		}
		if($mechanic_id !== "ALL"){
				$where = ($where == "")? " where " : " and ";
				$datos_where .= $where ."mechanic_assigned = '".$mechanic_id."' ";
		}
		
		if($date_ini !==""){
				$where = ($where == "")? " where " : " and ";
				$date_ini_tmst = strtotime(str_replace("/", "-", $date_ini));
				
				//echo date("d-m-Y", $date_ini_tmst);
				$datos_where .= $where."creation_time >= '".$date_ini_tmst."' "; 
				//$datos_where .= $where."entry_date >= '".$date_ini."' "; 
		}
		//echo $where."33";
		if($date_fin !==""){
				$where = ($where == "")? " where " : " and ";
				$date_fin_tmst = strtotime(str_replace("/", "-", $date_fin));
				$datos_where .= $where."creation_time <= '".$date_fin_tmst."' "; 
				//$datos_where .= $where ."entry_date <= '".$date_fin."' "; 
		}
		
		if($status == "1"){
			$where = ($where == "")? " where " : " and ";
			$datos_where .= $where ."support_status_id != '8' and support_status_id != '9' "; 
		}elseif($status == "8" || $status == "9"){
			$where = ($where == "")? " where " : " and ";
			$datos_where .= $where ."support_status_id = '".$status."' "; 
		}else{}
		
 }else{
	$datos_where = null;
 }

//echo  "select folio_id,dependency_id,vehicles_record_id,mechanic_assigned,registration_plate,entry_date,tower from folios ".$datos_where." order by folio_id DESC limit 500";
//die();
$db = new manejaDB();
$db->query("select folio_id,dependency_id,area_sector,vehicles_record_id,mechanic_assigned,registration_plate,entry_date,tower from folios ".$datos_where." order by folio_id DESC limit 2000");
//$db->query("select * from folios ".$datos_where." order by folio_id DESC limit 500");
$folios = $db->getArrayAsoc();						
$db->desconectar();

if($folios or $folios != 0){

echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($folios as $clave => $valor) {
		$dependency = new dependency;			
		$dependency_data = $dependency->selectbyId($valor["dependency_id"]);	
		$Stockid = $Stock->selectbyFolioId($valor["folio_id"]);
		
		$vehicle = $vehicles->selectbyId($valor["vehicles_record_id"]);	
		$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
		$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
		$users = new Users;
	
		if($valor["mechanic_assigned"]){
			$result_receiver = $users->selectbyId($valor["mechanic_assigned"]);
			$jefemecanicos = $result_receiver["name"]." ".$result_receiver["last_name"];
		}else{
			$jefemecanicos ="";
		}
		$activity = new FloorActivity;
		if($activity->getstart_date($valor["folio_id"])){
				$date = explode(",",$activity->getstart_date($valor["folio_id"]));				
				$date["1"] = ($date["1"])-1;
				list($año, $mes, $dia) = $date;
				$mes = ($mes< 10)? "0".$mes : $mes;
				$date = $dia."/".$mes."/".$año;
				//$date = implode("/",$date);
		}else{
			$date = "";
		}
		$Tracing = new Tracing;
		$seguimiento = array();
		$mensajes = $Tracing->getTracings($valor["folio_id"]);
					if($mensajes){foreach($mensajes as $rows){
								$seguimiento[] = utf8_encode($rows['comments']);								
							}
					}
		
		$seguimiento = implode(" , ",$seguimiento);
		$f_activity = new FloorActivity; 
		$folioidd["folio_id"] = $valor["folio_id"];
		$activities = $f_activity->selectbyColumn($folioidd, 30);
			// Depedencia, folio, marca, tipo, placas, fecha de entrada, actividades, mecanico,seguimiento,fechadeasignacion,torre
			echo "<row id='".$valor["folio_id"]."'>";
			echo "<cell>".utf8_encode($dependency_data["name"])."</cell>";
			echo "<cell>".utf8_encode($valor["area_sector"])."</cell>";
			echo "<cell>".$valor["folio_id"]."</cell>";
			echo "<cell>".$brand."</cell>";
			echo "<cell>".$model."</cell>";
			echo "<cell>".$valor["registration_plate"]."</cell>";
			echo "<cell>".$valor["entry_date"]."</cell>";
			
			$acts = array();
			if($activities){
							foreach($activities as $value){
								if($value["description"] !== ""){
									$acts[] = $value["description"];										
								}
							}								
						}else{
							$acts[] = "";
						}
			echo "<cell>".utf8_encode(implode(',',$acts))."</cell>";
			echo "<cell>".utf8_encode($jefemecanicos)."</cell>";				
			//echo "<cell>".$valor["departure_date"]."</cell>";
			echo "<cell>".$seguimiento."</cell>";
			echo "<cell>".$date."</cell>";			
			echo "<cell>".$valor["tower"]."</cell>";				
				
			echo "</row>";
				
}
echo "</rows>";
}
?>