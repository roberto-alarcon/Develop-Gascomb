<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.tracing.php';
include_once PATH_CLASSES_FOLDER.'class.employees.php';
$Stock = new Stock;
$folio = new Folio;

$vehicles = new Vehicle;
$employee = new Employee;
		
	

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
				$datos_where .= $where ."folios.dependency_id = '".$dependency_id."' ";
		}
		/*
		if($mechanic_id !== "ALL"){
				$where = ($where == "")? " where " : " and ";
				$datos_where .= $where ."folios.mechanic_assigned = '".$mechanic_id."' ";

		}*/
		
		if($date_ini !==""){
				$where = ($where == "")? " where " : " and ";
				$date_ini_tmst = strtotime(str_replace("/", "-", $date_ini));
				
				//echo date("d-m-Y", $date_ini_tmst);
				$datos_where .= $where."folios.creation_time >= '".$date_ini_tmst."' "; 
				//$datos_where .= $where."entry_date >= '".$date_ini."' "; 
		}
		//echo $where."33";
		if($date_fin !==""){
				$where = ($where == "")? " where " : " and ";
				$date_fin_tmst = strtotime(str_replace("/", "-", $date_fin));
				$datos_where .= $where."folios.creation_time <= '".$date_fin_tmst."' "; 
				//$datos_where .= $where ."entry_date <= '".$date_fin."' "; 
		}
		
		if($status == "1"){
			$where = ($where == "")? " where " : " and ";
			$datos_where .= $where ."folios.support_status_id != '8' and folios.support_status_id != '9' "; 
		}elseif($status == "8" || $status == "9"){
			$where = ($where == "")? " where " : " and ";
			$datos_where .= $where ."folios.support_status_id = '".$status."' "; 
		}else{}
		
 }else{
	$datos_where = null;
 }
 
if($mechanic_id !== "ALL"){
	$where = ($where == "")? " where " : " and ";
	$datos_where .= $where ."floor_activities.employee_id  = '".$mechanic_id."'"; //and floor_activities.status='1'
	$db = new manejaDB(); 
	
	
	$db->query("SELECT folios.folio_id, group_concat(floor_activities.description separator ', ') as description,
			folios.dependency_id,folios.area_sector,folios.vehicles_record_id,folios.registration_plate,folios.entry_date,folios.tower
			FROM floor_activities
			left join
			folios on folios.folio_id = floor_activities.folio_id ".$datos_where." 
			group by folio_id order by folio_id DESC;");
	$folios = $db->getArrayAsoc();						
	$db->desconectar();
		
}else{
	$db = new manejaDB();
	$db->query("select folio_id,dependency_id,area_sector,vehicles_record_id,mechanic_assigned,registration_plate,entry_date,tower from folios ".$datos_where." order by folio_id DESC");
	$folios = $db->getArrayAsoc();						
	$db->desconectar();
}










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

		if($mechanic_id !== "ALL"){
				$mecanicName = $employee->getName($mechanic_id);
				$jefemecanicos = utf8_encode($mecanicName);
		}else{
			$db = new manejaDB();
			//Sacar mecanicos que tienen asignada alguna tarea en proceso
			$db->query("
				SELECT group_concat(DISTINCT CONCAT(employees.name,' ' ,employees.last_name) separator ', ') as mecanicos
				FROM floor_activities
				left join employees
				on employees.employee_id = floor_activities.employee_id
				where floor_activities.folio_id = '".$valor["folio_id"]."' group by floor_activities.folio_id;
			"); /*and floor_activities.status = 1 */
			$mecanicos = $db->getArrayAsoc();						
			$db->desconectar();
			if($mecanicos and ISSET($mecanicos[0]["mecanicos"])){
				$jefemecanicos = $mecanicos[0]["mecanicos"];
			}else{
				$jefemecanicos ="";
			}		
			
		}
		/*if($valor["mechanic_assigned"]){
			$result_receiver = $users->selectbyId($valor["mechanic_assigned"]);
			$jefemecanicos = $result_receiver["name"]." ".$result_receiver["last_name"];
		}else{
			$jefemecanicos ="";

		}*/
		$activity = new FloorActivity;
		if($activity->getstart_date($valor["folio_id"])){
				$date = explode(",",$activity->getstart_date($valor["folio_id"]));				
				//$date["1"] = ($date["1"])-1;
				list($año, $mes, $dia) = $date;
				//$mes = ($mes< 10)? "0".$mes : $mes;
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

			if($mechanic_id !== "ALL"){
				echo "<cell>".utf8_encode($valor["description"])."</cell>";
			}else{
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
			}
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