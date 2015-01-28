<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.suppliers.php';
	
	//print_r($_REQUEST);
	
	$supplier = new Suppliers;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
		$supplier_data["nombre"] = utf8_decode(strtr(strtoupper($_REQUEST['name']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$supplier_data["direccion"] = utf8_decode(strtr(strtoupper($_REQUEST['address']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$supplier_data["telefono"] = $_REQUEST['phone'];
		$supplier_data["correo"] = trim(strtolower($_REQUEST['email']));
		$supplier_data["fecha_creacion"] = time();

		$supplier_data["status"] = $_REQUEST['status'];
		
		if ($supplier->validateinsert($supplier_data) == false){
			echo  '{"return":"0","data":['.json_encode($supplier->errors).']}';
		} else {
			$supplier = $supplier->add($supplier_data);
			if($supplier){
				if($supplier["id_proveedor"]){
						echo  '{"return":"1","data":['.json_encode($supplier).']}';		
				}else{
					echo  '{"return":"0","data":"Error"}';
				}		
				
			}else{
				echo  '{"return":"0","data":"Error"}';
			}
			
		}
	}
		
	if (isset($_REQUEST['action']) and ($_REQUEST['action'] == 'get')){
		$id = $_REQUEST['id'];
		$supplierdata = $supplier->selectbyId($id);
		$supplierdata["nombre"] = utf8_encode($supplierdata["nombre"]);
		$supplierdata["direccion"] = utf8_encode($supplierdata["direccion"]);
		$supplierdata["telefono"] = utf8_encode($supplierdata["telefono"]);
		$supplierdata["correo"] = utf8_encode($supplierdata["correo"]);
		$supplierdata["status"] = utf8_encode($supplierdata["status"]);
		echo json_encode($supplierdata);
		
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){

		$supplier_data["nombre"] = utf8_decode(strtr(strtoupper($_REQUEST['name']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$supplier_data["direccion"] = utf8_decode(strtr(strtoupper($_REQUEST['address']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		$supplier_data["telefono"] = $_REQUEST['phone'];
		$supplier_data["correo"] = trim(strtolower($_REQUEST['email']));
		$supplier_data["fecha_actualizacion"] = time();
		$supplier_data["status"] = $_REQUEST['status'];
		
		if ($supplier->validateupdate($supplier_data) == false){
			echo  '{"return":"0","data":['.json_encode($supplier->errors).']}';		
		}else{
			//print_r($user->userdata);exit(0);
			$supplier->updatewhere = array("id_proveedor" =>$_REQUEST["id"]);
			$supplier = $supplier->update($supplier_data);
			echo  '{"return":"1","data":['.json_encode($supplier).']}';		
		}	
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'disable'){
		if(isset($_REQUEST["id"]) && $_REQUEST["id"] !== ""){
			$supplier->updatewhere = array("id_proveedor" =>$_REQUEST["id"]);
			$status = array("status"=>"0");
			$supp = $supplier->update($status);
			echo  '{"return":"1","data":['.json_encode($supp).']}';		
		}else{
			echo  '{"return":"0","data":{"error":"No se recibio el id del proveedor"}}';
		}		
	}
	
