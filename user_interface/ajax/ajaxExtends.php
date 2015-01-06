<?php
session_start(); 
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.extends.php');	


	$Extend = new Extend;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'sendmail'){		
		$user_data["folio_id"] = $_REQUEST["folio"];
		$user_data["sender"] = $_SESSION["active_user_id"];
		//$user_data["receiber"] = $_REQUEST['receiber'];
		//$user_data["cc"] = isset($_REQUEST['cc'])? $_REQUEST['cc'] : "";
		$user_data["receiber"] = utf8_decode(A_RECEIVER);
		$user_data["sender"] = A_SENDER;
		$user_data["title"] = A_SUBJECT;		
		$user_data["message"] = utf8_decode($_REQUEST['message']);
		$user_data["comments"] = utf8_decode($_REQUEST['comments']);
		$user_data["status"] = $_REQUEST['status'];
		$user_data["creation_datetime"] = time();
		$res = $Extend->add($user_data);
		if($res){
			$result = $Extend->sendmail($user_data);			
			$res_obj = json_decode($result);
			if($res_obj->return == "1"){
					echo  '{"return":"1","data":['.json_encode($res).']}';		
			}else{
					echo $result;
			}
			
		}else{
			echo  '{"return":"0","error":"Error al agregar info a la BD"]}';
		}
	}
		
	if (isset($_REQUEST['action']) and ($_REQUEST['action'] == 'get')){
		$id = $_REQUEST['id'];
		header("Content-type: text/xml");
		$extenddata = $Extend->selectbyId($id);
		echo "<data>";
		if($extenddata){			
			foreach($extenddata as $key => $value){				
				//if($key == "message"){
					echo "<$key><![CDATA[".utf8_encode($value)."]]></$key>";
				/*}else{
					echo "<$key>".utf8_encode($value)."</$key>";
				}*/
				
			}
			
		}
		echo "</data>";	
		
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){		
		//$user_data["receiber"] = $_REQUEST['receiber'];
		//$user_data["cc"] = isset($_REQUEST['cc'])? $_REQUEST['cc'] : "";
		//$user_data["title"] = utf8_decode($_REQUEST['title']);		
		$user_data["message"] = utf8_decode($_REQUEST['message']);
		$user_data["comments"] = utf8_decode($_REQUEST['comments']);
		$user_data["status"] = $_REQUEST['status'];
		if($user_data["status"] == "1" || $user_data["status"] == "2"){
				$user_data["approved_datetime"] = time();
				$user_data["approved_by"] = utf8_decode($_REQUEST['approved_by']);
				$user_data["vobo"] = utf8_decode($_REQUEST['vobo']);
		}
		$Extend->updatewhere = array("extend_id"=>$_REQUEST["id"]);
		$Extends = $Extend->update($user_data);		
		if($Extends){
			echo  '{"return":"1","data":['.json_encode($Extends).']}';		
		}else{
			echo  '{"return":"0","data":['.json_encode($Extends).']}';		
		}
		
	}/*
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'disable'){
		if(isset($_REQUEST["id"]) && $_REQUEST["id"] !== ""){
			$Employee->updatewhere = array("employee_id" =>$_REQUEST["id"]);
			$status = array("status"=>"0");
			$empl = $Employee->update($status);
			echo  '{"return":"1","data":['.json_encode($empl).']}';		
		}else{
			echo  '{"return":"0","data":{"error":"No se recibio el id"}}';
		}		
	}*/
	

	