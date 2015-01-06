<?php
/**************************************************************
* Clase: activities, Maneja el ABC de las actividades
*
* @access public 
* @since 01/04/2003 11:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class FloorActivity
{	
    var $errors= array();
	var $data = array();
	var $updatewhere = array("floor_activity_id"=>"1");	
	var $table = 'floor_activities';
	var $primary = 'floor_activity_id';
	
	/* Metodo insert: inserta una nueva actividad de piso*/
	function add($data){
		if (is_array($data)){
			$db = new manejaDB();			
			if($id = $db->makeQueryInsert($this->table,$data)){
				$result = $this->selectbyId($id);
				$db->desconectar();
				return($result);           		
			}				
			echo $db->mensaje();
		}			
    }

	function update($data){
		
		if (is_array($data)){
			$db = new manejaDB();			
			$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
			$result = $this->selectbyId($this->updatewhere["floor_activity_id"]);
			$db->desconectar();
			
			return($result);           			
		}	
    }
	
	function delete($id){ 
		
    }
	
	function selectbyId($id){ 
		$db = new manejaDB();
		$db->query("select * from ".$this->table." where $this->primary = '".$id."'");
		$result = $db->getArray();	
		if (is_array($result)){
			foreach ($result as $clave => $valor) {
				if(is_numeric($clave)) { unset($result[$clave]); }
			}
		}
		$db->desconectar();
		return($result);
    }
	function selectbyColumn($where, $limit){
			$limit = isset($limit) ? $limit : 10;			
			if($where){
				foreach($where as $apuntador => $v){
					$datos_[]=$apuntador." ='".$v."'";
				}
					$datos_where = " where ";
					$datos_where .= implode(" AND ",$datos_);		
			}else{
				$datos_where = '';
			}
			
            $db = new manejaDB();			
			$db->query("select * from ".$this->table." ".$datos_where." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
    }
	
	function getDataFolio($id){
		$db = new manejaDB();
		$db->query("select entry_date, registration_plate from folios where folio_id = '".$id."'");
		
		$result = $db->getArray();
		$return=array();
		if(!empty($result)){
			$return["registration_plate"]=$result["registration_plate"];
			list($dia,$mes,$ano)=explode("/",$result["entry_date"]);
			$return["data_start_proyect"]=$ano.",".$mes.",".$dia;
		}
		else { die("folio ".$id." no encontrado"); }
		return $return;
	}
	function getEntryDateTime($id){
		$db = new manejaDB();
		$db->query("select entry_date, entry_time from folios where folio_id = '".$id."'");
		
		$result = $db->getArray();
		$return="";
		if(!empty($result)){
			$return=$result["entry_date"]." ".$result["entry_time"];
			
		}
		else { die("folio ".$id." no encontrado"); }
		return $return;
	}
	
	function allFolios(){
		$db = new manejaDB();
		$db->query("select folio_id from folios");
		
		$return=array();
		while($result = $db->getArray()){
			$return[]=$result["folio_id"];
		}
		return $return;
	}
	
	function writeXmlData($id){
		
		$r_data_folio = $this->getDataFolio($id);
		
		
		$text_model='<?xml version="1.0" encoding="ISO-8859-1"?>
<projects>
	<project id = "'.$id.'" name = "Folio: '.$id.' \ Placa: '.$r_data_folio["registration_plate"].'" startdate = "'.$r_data_folio["data_start_proyect"].'" >'; // 2013,04,27		
		$db = new manejaDB();
		$sql = "select * from ".$this->table." where folio_id = '".$id."'";
		
		$db->query($sql);
		while($result = $db->getArray()){
			$max_time_hours = $this->adjustMaxTimeHours($result["time_start"],$result["max_time_hours"]);
		
			$text_model.='
		<task id="'.$result["floor_activity_id"].'">
			<name>'.$result["description"].'</name>
			<est>'.$this->formatDateData($result["time_start"]).'</est>
			<duration>'.$result["max_time_hours"].'</duration>
			<percentcompleted>'.$result["percent_completed"].'</percentcompleted>
			<predecessortasks></predecessortasks>
			<childtasks></childtasks>
		</task>';
		}		
		$text_model.='
	</project>
</projects>';

		$db->desconectar();

		$file_name = PATH_SERV."user_interface/ajax/gantt/ajax/gantt/data/".$id.".xml";		
		$h=fopen($file_name, "w+");
		fwrite($h,$text_model);
		fclose($h);
		
		//temporal
		$file_name1 = PATH_SERV."mobile_folio/mobile_task/ajax/gantt/data/".$id.".xml";		
		$h1=fopen($file_name1, "w+");
		fwrite($h1,$text_model);
		fclose($h1);
		
		
	}
	
	function writeShedulerData($id){
		
		$r_data_folio = $this->getDataFolio($id);
		$text_model='var elements = ';
		 //[{key:1, label:"Folio: '.$id.'", open: true, children: ';
				$db = new manejaDB();
				$sql = "select * from ".$this->table." where folio_id = '".$id."'";
				
				$db->query($sql);
				$ve = array();
				while($result = $db->getArray()){
					$key["key"] = $result["floor_activity_id"];
					$key["label"] = utf8_encode($result["description"]);
					array_push($ve,$key);
				}
				$text_model .= json_encode($ve);
				$text_model .= ";";
		//$text_model.= '}
		//];';
		
		echo $text_model;
		
	}
	function writeShedulerXml($id){
		$horaInicioDia = 9; //Hora de inicio de la jornada laboral 9:00am
		$horaFinDia = 19; //Hora de termino de la jornada laboral 19:00am
	
		$r_data_folio = $this->getDataFolio($id);				
		$db = new manejaDB();
		$sql = "select * from ".$this->table." where folio_id = '".$id."'";
		
		$db->query($sql);
		$ve = array();
		
		$text_model = "<data>";
		while($result = $db->getArray()){
			
			$max_time_hours = $result["max_time_hours"];			
			$entry_date =  date("Y-m-d H:i",$result["time_start"]);
			
			
			$hour_entry = date("H",$result["time_start"]);
			$day_entry = date("d",$result["time_start"]);
			$end_date = $this->sumarhoras($entry_date ,$max_time_hours);
			/*
			if(($hour_entry+$max_time_hours) > $horaFinDia){
				$horasParasiguientedia = (($hour_entry+$max_time_hours)-$horaFinDia);				
				$horadeiniciosiguientedia = $horaInicioDia+$horasParasiguientedia;
					
				if($horadeiniciosiguientedia > $horaFinDia){
					$horasParasiguientedia = ($horadeiniciosiguientedia-$horaFinDia);				
					$horadeiniciosiguientedia = $horaInicioDia+$horasParasiguientedia;
					$dias = $day_entry+2;
				}else{
					$dias = $day_entry+1;
				}
				
				$end_date = (date("Y-m",$result["time_start"]))."-".$dias." ".$horadeiniciosiguientedia.":".(date("i",$result["time_start"]));
			}else{
				$end_date = $this->dateadd($entry_date,0,0,0,$max_time_hours,0,0);
			}*/		
			
			$text_model .= '<event start_date="'.$entry_date.'" end_date="'.$end_date.'" text="'.utf8_encode($result["description"]).'" section_id="'.$result["floor_activity_id"].'"/>';
			//$entry_date = $end_date;		
		}
		
		$text_model .= "</data>";
		
		echo $text_model;
	}
	
	function sumarhoras($fechainicial, $max_time_hours){
		//echo $fechainicial."<br>";
		$minute = date("i",strtotime($fechainicial));
		$horaFinDia = 18; //Hora en que finaliza la jornada laboral
		$horaInicioDia = "8:".$minute; //Hora en que inicia la jornada laboral
		$hour_entry = date("H",strtotime($fechainicial));	
		if(($hour_entry+$max_time_hours) > $horaFinDia){
			$restahoras = $horaFinDia-$hour_entry;
			$horassobrantes = $max_time_hours-$restahoras;
			$diadelasemana = date("N",strtotime($this->dateadd($fechainicial,1,0,0,0,0,0)));
			//Si es fin sab o dom, brincar a lunes	
			if($diadelasemana == 6 || $diadelasemana == 7){			
				$nuevafecha = $this->dateadd($fechainicial,1,0,0,0,0,0);
				$proximo_lunes = strtotime($nuevafecha) + ( (7-($diadelasemana-1)) * 24 * 60 * 60 );
				$dia = date("Y-m-d",$proximo_lunes);			
			}else{
				$dia = date("Y-m-d",strtotime($this->dateadd($fechainicial,1,0,0,0,0,0)));
			}		
			//$dia = $dia." 09:00";
			$dia = $dia." ".$horaInicioDia;
			
			return $this->sumarhoras($dia,$horassobrantes);		
		}else{		
			return $this->dateadd($fechainicial,0,0,0,$max_time_hours,0,0);
		}

	}
	
	function getPercentProgress($id){
					
		$db = new manejaDB();		
		$db->query("select count(*) as total from ".$this->table." where folio_id = '".$id."' and (status = '1' or status = '3')");		
		$result = $db->getArray();
		$db->query("select count(*) as total from ".$this->table." where folio_id = '".$id."' and status = '3'");		
		$finalizados = $db->getArray();
		$finalizados = $finalizados["total"];
		$total = $result["total"];
		if($finalizados and $total){
			$return = $finalizados*100/$total;			
		}else{
			$return = false;
		}
		
		return $return;
	}	
	
	function getDeliveryDate($id){
		$horaInicioDia = 9; //Hora de inicio de la jornada laboral 9:00am
		$horaFinDia = 19; //Hora de termino de la jornada laboral 19:00am
	
					
		$db = new manejaDB();
		$sql = "select time_start,max_time_hours from ".$this->table." where folio_id = '".$id."' and (status = '1' or status = '3')";		
		$db->query($sql);
		$ve = array();
		
		$text_model = "";
		$fechatermino = "0";
		
		while($result = $db->getArray()){			
			$max_time_hours = $result["max_time_hours"];			
			$entry_date =  date("Y-m-d H:i",$result["time_start"]);			
			$end_date = $this->sumarhoras($entry_date ,$max_time_hours);
			//$text_model .= 'inicio:'.$entry_date.' final:'.$end_date.' | '.strtotime($end_date).'<br>';
			if(strtotime($end_date) > $fechatermino){
				$fechatermino = strtotime($end_date);
			}			
		}		
		//$fechatermino = date("Y-m-d H:i",$fechatermino);
		$fecha_entrega = date("Y-m-d",$fechatermino);		
		$db = new manejaDB();
		$db->query("select support_status_id, departure_date from folios where folio_id = '".$id."'");		
		$datafolio = $db->getArray();
		$dataf=array();
		$fecha_entregado = false;
		if(!empty($datafolio)){			
			if($datafolio["support_status_id"] == '4'){			
				$fecha_entregado=date("Y-m-d",strtotime($datafolio["departure_date"]));
			}
		}
		//echo $fecha_entregado;
		//print_r($dataf);exit(0);
		
		//Agregar validación para folios cerrados
		//Si folio esta cerrado
		//Obtener fecha en que fue entregado y comparar 
		$result = $this->dias_restantes($fecha_entregado,$fecha_entrega);
		/*if($fecha_entregado){
			$result = $this->dias_restantes($fecha_entregado,$fecha_entrega);
		}else{
			$result = $this->dias_restantes($fecha_entregado,$fecha_entrega);		
			//$result = $this->dias_restantes('2013-09-12');		
		}*/
		
		$return["dias"] = $result;
		//en tiempo
		if($result > 1){ 
			$return["color"] = "verde";
			$return["hex"] = "#41A317";
		}
		//No se han asignado tareas
		elseif($fecha_entrega == '1969-12-31'){ 
			$return["color"] = "verde";
			$return["hex"] = "#41A317";
		} 
		//falta un dia para la entrega
		elseif($result == 1){ 
			$return["color"] = "amarrillo"; 
			$return["hex"] = "#FFA62F";
		} 
		//dia de entrega
		elseif($result == 0){ 
			$return["color"] ="ambar"; 
			$return["hex"] = "#E2893A";
		} 
		//retraso
		elseif($result < 0){ 
			$return["color"] = "rojo"; 
			$return["hex"] = "#F80000";
			$return["dias"] = abs($result); 
		} 
		return $return;
		
	}
	function dias_restantes($fecha_actual = false,$fecha_final) {  
		if ($fecha_actual === false) {
			$fecha_actual =  date("Y-m-d"); 
		}		
		//$fecha_actual = date("Y-m-d");  
		$s = strtotime($fecha_final)-strtotime($fecha_actual);  
		$d = intval($s/86400);  
		$diferencia = $d;  
		return $diferencia;  
	}

	
	function getActivitiesArray($id){
		//$r_data_folio = $this->getDataFolio($id);				
		$db = new manejaDB();
		$sql = "select * from ".$this->table." where folio_id = '".$id."' order by time_start ASC";
		
		$db->query($sql);
		$result = $db->getArrayAsoc();	
		$result = ($result)? $result : false ;
		$db->desconectar();
		return($result);
	}
	
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
		  $date_r = getdate(strtotime($date));
		  $date_result = date("Y-m-d H:i",
		  
						mktime(($date_r["hours"]+$hh),
							   ($date_r["minutes"]+$mn),
							   ($date_r["seconds"]+$ss),
							   ($date_r["mon"]+$mm),
							   ($date_r["mday"]+$dd),
							   ($date_r["year"]+$yy)));

		 return $date_result;
	}	
	
	function getstart_date($id){
		$db = new manejaDB();
		//$db->query("SELECT * from sistema_gascomb.floor_activities where folio_id = '".$id."' limit 1");
		$db->query("SELECT * from sistema_gascomb.floor_activities where folio_id = '".$id."' and time_start IS NOT NULL order by time_start ASC");
		
		//$result = $db->getArray();
		$result = $db->getArrayAsoc();
		
		$date = false;
        if($result){
            foreach($result as $value){			
    			if($value["time_start"]!== "0"){
    				$date = $value["time_start"];
    				break; 
    			};			
    		}   
        }
		
		//echo $date;
		//print_r($date);
		//exit(0);
		//$return="";
		//if(!empty($result)){
		//	$return=$this->formatDateData($result["time_start"]);			
		//}
		//echo $date;
		if($date){
			$return=$this->formatDateData($date);			
		}else { $return = false; }
		return $return;		
	}

	function formatDateData($timeUnix){
		return date("Y,m,d",$timeUnix);
	}

	function adjustMaxTimeHours($time_start,$max_time_hours){
		$fines_de_semana=0;
		$dia_feriado=0;

		$fines_de_semana = $this->cuantos_fines($time_start,$max_time_hours);		
		
		$dias_feriados = $this->cuantos_feriados($time_start,$max_time_hours);
		
		
		
		$max_time_hours = $max_time_hours + ($fines_de_semana * 20);		
		$max_time_hours = $max_time_hours + ($dias_feriados * 10);		
		
		return $max_time_hours;
	}
	
	
	function cuantos_fines($time_start,$max_time_hours){		
		
		$dia_en_n = date("N",$time_start);
		$total_fines_de_semana = 0;
		$dias_a_trabajar = ceil($max_time_hours / 10);
		$dias_en_segundos = $dias_a_trabajar * 24 * 60 * 60;
		
		while($dias_a_trabajar){		
			if($dia_en_n == 6 ){
				$total_fines_de_semana++;
				$dia_en_n=0;
				$dias_a_trabajar++;
			}		
			$dia_en_n++;
			$dias_a_trabajar--;
		}
		
		$dias_en_segundos_fines = ($total_fines_de_semana * 2 * 24 * 60 * 60) - 86400;
		$nts= ($time_start+$dias_en_segundos+$dias_en_segundos_fines);
		
		//echo "inicia: ".date("l, d/m/Y",$time_start)."<br>"; 
		//echo "termina: ".date("l, d/m/Y",$nts); 
		return $total_fines_de_semana;
	}
	
	function cuantos_feriados($time_start,$max_time_hours){
		return 0;
	}
	
	function getSupportActivities(){
		$db = new manejaDB();
		$db->query("SELECT * FROM sistema_gascomb.support_checklist_activities");
		$result = $db->getArrayAsoc();
		if($result){
			$result = $result;
		}else{
			$result = "";
		}
		$db->desconectar();
		return($result);
    }
	
	
}
/*
$instancia = new FloorActivity();
$todos = $instancia->allFolios();

while (list(, $folio) = each($todos)) {
	$instancia->writeXmlData($folio);
	echo "creado el xml $folio <br>";
}*/



