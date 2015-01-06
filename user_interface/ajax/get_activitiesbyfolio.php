<?php
header('Content-Type: text/html; charset=utf-8'); 
include '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
	
	$id = $_GET['id'];
	$f_activity = new FloorActivity; 
	$folioidd["folio_id"] = $id;
	$activities = $f_activity->selectbyColumn($folioidd, 50);
	if($activities){
		$a=array();
		foreach($activities as $value){
			if($value["description"] !== ""){
				$b["floor_activity_id"] = utf8_encode($value["floor_activity_id"]);
				$b["description"] = utf8_encode($value["description"]);
				array_push($a, $b);				
			}
		}
		/*foreach($activities as $value){
			if($value["description"] !== ""){
				$a[]["description"] = utf8_encode($value["description"]);												
			}
		}*/
		echo json_encode($a);		
	}else{
		echo "";
	}
?>
