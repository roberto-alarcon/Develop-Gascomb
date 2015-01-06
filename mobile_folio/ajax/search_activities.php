<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';	
include_once PATH_CLASSES_FOLDER.'class.checklist.php';		
$typeactivities = new Checklist;


if(isset($_REQUEST["q"]) && $_REQUEST["q"] != "" ){
	
	$text = $_REQUEST["q"];
	$limit = '100';
	$where = array("activity_name"=>$text);
	$activities = $typeactivities->selectbyColumn($where,true,$limit);	
	if($activities){		
		foreach($activities as $activity){
			//echo '<option value="'.$activity["support_activities_id"].'">'.utf8_encode($activity["activity_name"]).'</option>';
			//$prod["support_activities_id"] = $activity["support_activities_id"];	
			//$prod["activity_name"] = $activity["activity_name"];
			$prod["support_activities_id"] = $activity["support_activities_id"];	
			$prod["activity_name"] = utf8_encode($activity["activity_name"]);
			$productresult[] = $prod;
			
		}
		echo json_encode($productresult);
		
	}
}	
?>