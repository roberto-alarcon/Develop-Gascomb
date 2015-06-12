<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
$folio_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";

$fol = new Folio;
$folio_data = $fol->selectbyId($folio_id);
	if($folio_data){
		if($folio_data["owner_email"]){
			$emails["email1"] = $folio_data["owner_email"];
		}
		if($folio_data["owner_email2"]){
			$emails["email2"] = $folio_data["owner_email2"];
		}
		if(isset($emails)){
				echo json_encode($emails);
		}
		
	}else{
		echo "";
	}

?>
