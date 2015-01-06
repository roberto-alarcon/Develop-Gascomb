<?php 
//header( 'Content-type: text/html; charset=iso-8859-1' );
global $id;
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.contracts.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.employees.php';
include_once PATH_CLASSES_FOLDER.'class.type_activities.php';



	//$_REQUEST["folio_id"]="30";	
	$folio_id = $id;
	$folio = new Folio;			
	$folio = $folio->selectbyId($folio_id);	
	if(!$folio){ exit(0); }	//si no encuentra el folio detener ejecución
	$vehicles = new Vehicle;		
	$vehicle = $vehicles->selectbyId($folio["vehicles_record_id"]);	
	$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
	$model = utf8_encode($vehicles->getModel($vehicle["support_models_vehicular_id"]));
	$dependency = new dependency;			
	$dependency_data = $dependency->selectbyId($folio["dependency_id"]);	
	$dependency_name = utf8_encode($dependency_data["name"]);
	//print_r($model);

	//echo $folio["inventory_id"];
	$inventory = new Inventory;		
	$inventory = $inventory->selectbyId($folio["inventory_id"]);
		
		foreach($inventory as $key => $value){
			if($value == "1" and $key !== "inventory_id"){
				$inventorydata[$key] = $value;
			}
		}
	//print_r($inventorydata);
	
	$_REQUEST["get"] = 'general'; 
	$_REQUEST["client"] = 'client';
	$f_activity = new FloorActivity; 
	$folioidd["folio_id"] = $folio_id;
	$activities = $f_activity->selectbyColumn($folioidd, 30);
	$resultSemaforo = $f_activity->getDeliveryDate($folio_id);
	$employee = new Employee;
	if($folio["received_by"]){
		$result_receiver = $employee->selectbyId($folio["received_by"]);
		$recibe_unidad = $result_receiver["name"]." ".$result_receiver["last_name"];
	}else{
		$recibe_unidad ="";
	}
	$users = new Users;
	
	if($folio["mechanic_assigned"]){
		$result_receiver = $users->selectbyId($folio["mechanic_assigned"]);
		$jefemecanicos = $result_receiver["name"]." ".$result_receiver["last_name"];
	}else{
		$jefemecanicos ="";
	}
	$type_act = new Type_activities;
	$type_activity = $type_act->selectbyId($folio["type_service"]);
	$type_activity =  strtoupper($type_activity["name"]);
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="es-mx" http-equiv="Content-Language" />
<!-- <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />-->
<title>Datos generales</title>
 <style>
      html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			overflow: hidden;
		}
	  
	 table {
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12px;
	 }
	 
	 label{
		font-size: 20px;
		font-weight: bold;
	 }
	 
	 .bigtext {
		font-size: 24px;
	}
	 .bigtext {
		font-size: 36px;
	}
	 .bigtext {
		font-weight: bold;
	}
	 .bigtext {
		font-size: 50px;
	}
	 .bigtext {
		font-size: 40px;
	}

	.full-width{
		border:solid 3px #e2e2e2;
		padding:10px;
		min-height:100px;
	}
	
	.left-width{
		border:solid 3px #e2e2e2;
		padding:10px;
		float:left;
		width:47%;
		height:200px;
	}

 </style>
</head>

<body>
			
			<!-- Create table content info -->
			<table border="1" style="width: 100%; border-collapse:collapse;border: 1px solid #c0c0c0;" cellpadding="5" >
				<tr>
				  <td colspan=3>
                  
                  <table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td width="13%"  valign="top"><img src="<?php echo str_replace("[id_folio]", $folio["folio_id"], QR_IMAGE_URL);; ?>" /></td>
    <td width="42%" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr style="color:#06C; font-size:18px; font-weight:normal">
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr  style="color:#06C; font-size:14px; font-weight:bold">
            <td>Cliente: <?php echo $dependency_name ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div style="width:30px;height:25px; padding:7px; text-align:center; font-size:18px; color:#fff;background:<?php echo $resultSemaforo["hex"];?>">
				  <?php echo ($resultSemaforo["color"] == "verde" || $resultSemaforo["color"] == "amarrillo" || $resultSemaforo["color"] == "ambar")? "" : $resultSemaforo["dias"];?>
				</div>
		</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span style="width: 120px; height: 19px"><strong>Folio:</strong></span></td>
        <td><span style="width: 115px; height: 19px"><?php echo $folio["folio_id"]; ?></span></td>
      </tr>
      <tr>
        <td><strong>Direccción</strong></td>
        <td><?php echo utf8_encode($vehicle["owner_adress"]); ?></td>
      </tr>
      <tr>
        <td><strong>Tel.:</strong></td>
        <td><?php echo utf8_encode($vehicle["owner_phone"]); ?> <strong>Cel.:</strong> <span style="height: 19px"><?php echo $vehicle["owner_cell"]; ?></span></td>
      </tr>
      <tr>
        <td><strong>Nombre:</strong></td>
        <td><?php echo utf8_encode($vehicle["owner_name"]); ?></td>
      </tr>
      <tr>
        <td><strong>email:</strong></td>
        <td><?php echo $vehicle["owner_email"]; ?></td>
      </tr>
      <tr>
        <td><strong>Responsable 
          de la unidad:</strong></td>
        <td><?php echo utf8_encode($folio["vehicle_operator"]); ?></td>
      </tr>
      <tr>
        <td><strong>Tel. responsable de la unidad:</strong></td>
        <td><?php echo $folio["operator_tel"]; ?></td>
      </tr>
    </table></td>
    <td width="42%" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="0">
      <tr align="center" bgcolor="#EEEEEE">
        <td  style="height: 19px"><strong>Actividades a realizar:</strong></td>
      </tr>
      <tr>
        <td><?php
			if($activities){
				echo "<UL>";
				foreach($activities as $value){
					if($value["description"] !== ""){
						echo "<LI>".utf8_encode($value["description"]);										
					}
				}
				echo "</UL>";
			}else{
				echo "";
			}
		?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td align="center" bgcolor="#FFE09F" style="height: 19px"><span style="height: 19px"><strong>Detalle de la falla:</strong></span></td>
      </tr>
      <tr>
        <td height="50" valign="top" bgcolor="#FAFAFA"><span style="height: 19px"><span style="margin:20px;"><?php echo utf8_encode($folio["failures"]);?></span></span></td>
        </tr>
    </table></td>
  </tr>
</table>
				
				
				</td></tr>
				<tr style="color:#06C; font-size:14px; font-weight:bold">
				  <td valign="top" bgcolor="#EEEEEE"><span style="width: 100px; height: 19px">Información corporativa</span></td>
				  <td valign="top" bgcolor="#EEEEEE"><span style="width: 100px; height: 19px">Vehiculo</span></td>
			  </tr>
				<tr><td valign="top">
				
				<table width="100%">
					<tr>
					  <td width="20%" style="width: 100px; height: 19px"><strong>Fecha de 
					  ingreso:</strong></td>
					  <td style="width: 115px; height: 19px"><?php echo $folio["entry_date"]; ?> <?php echo $folio["entry_time"]; ?></td>
				  </tr>
				  <tr>
					  <td style="width: 100px; height: 19px"><strong>Tipo de servicio:</strong></td>
					  <td style="width: 115px; height: 19px"><?php echo $type_activity; ?></td>
				  </tr>
					<tr>
					  <td style="width: 100px; height: 19px"><span style="width: 182px"><strong>Recibido por:</strong></span></td>
					  <td style="width: 115px; height: 19px"><span style="width: 115px"><?php echo $recibe_unidad; ?></span></td>
				  </tr>
				<tr>
					  <td style="width: 100px; height: 19px"><strong>Jefe de mecanicos:</strong></td>
					  <td style="width: 115px; height: 19px"><?php echo $jefemecanicos; ?></td>
				  </tr>				 
					<tr>
					  <td style="height: 19px"><strong>Torre:</strong></td>
					  <td style="height: 19px"><span><?php echo $folio["tower"]; ?></span></td>
				  </tr>
					<tr>
					  <td><strong>Cajon:</strong></td>
					  <td><span><?php echo $folio["parking_space"]; ?></span></td>
				  </tr>
				</table>
				
				
				<!-- end datos generales -->
				
				</td>
				
				<td valign="top"><table width="100%">
					<tr>
						<td style="width: 138px"><strong>Marca:</strong></td>
						<td><?php echo $brand; ?></td>
				  </tr>
					<tr>
						<td style="width: 138px"><strong>Tipo:</strong></td>
						<td><?php echo $model ?></td>
					</tr>
					<tr>
						<td style="width: 138px"><strong>Placas:</strong></td>
						<td><?php echo $vehicle["registration_plate"] ?></td>
					</tr>
					<tr>
						<td style="height: 19px; width: 138px;"><strong>No. economico:</strong></td>
						<td style="height: 19px"><?php echo $vehicle["economic_number"] ?></td>
					</tr>
					<tr>
						<td style="width: 138px"><strong>Año:</strong></td>
						<td><?php echo $vehicle["year"] ?></td>
					</tr>
					<tr>
						<td style="width: 138px"><strong>Cilindros:</strong></td>
						<td><?php echo $vehicle["cilinders"] ?></td>
					</tr>
					<tr>
						<td style="width: 138px"><strong>Kms:</strong></td>
						<td><?php echo $vehicle["km"] ?></td>
					</tr>
					</table>
				<!-- End datos del vehiculo -->
				
				</td>
				
				</tr>
				<tr style="color:#06C; font-size:14px; font-weight:bold">
				  <td colspan=3 align="center" bgcolor="#DDDDDD">Inventario</td>
			  </tr>
				<tr><td colspan=3>
				
				<!-- Creamos inventario -->
				
			
				<table width="100%" class="gradienttable" style="border-collapse:collapse;border: 1px solid #c0c0c0;" cellpadding="1" cellspacing="0" >
				  <tr style="background:#EDEDED">
					<td style="width:15%;padding-left:10px">PIEZA</td>
					<td style="width:2.5%;">SI</td>
					<td style="width:2.5%">NO</td>
					<td style="width:15%; border-left:1px solid #ddd; padding-left:10px">PIEZA</td>
					<td style="width:2.5%">SI</td>
					<td style="width:2.5%">NO</td>
					<td height="10" style="width:15%; border-left:1px solid #ddd; padding-left:10px">PIEZA</td>
					<td style="width:2.5%">SI</td>
					<td style="width:2.5%">NO</td>
					<td style="width:15%; border-left:1px solid #ddd; padding-left:10px">PIEZA</td>
					<td style="width:2.5%">SI</td>
					<td style="width:2.5%">NO</td>
					<td style="width:15%;border-left:1px solid #ddd; padding-left:10px">PIEZA</td>
					<td style="width:2.5%">SI</td>
					<td style="width:2.5%">NO</td>
				  </tr>
				  
				  <?php 
				  
				 unset($inventory["observations"]);unset($inventory["fuel_level"]);
				 //unset($inventory["inventory_id"]);
	
				  $keys = array_keys($inventory);
						  $filas = 18; $columnas = 5; $contador = 1;		  
							
						 //Iniciamos el bucle de las filas
						 for($t=0;$t<18;$t++){
						  echo "<tr class='bg_tr' style='height: 8px'>";
						  //Iniciamos el bucle de las columnas
						  for($y=0;$y<5;$y++){
							/*if ($contador == "89"){
								echo "<td style='width:15%; height: 8px;'></td>";
								echo "<td style='width:2.5%; height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";
								$contador++;
							}else*/
							if($contador == "90"){
								echo "<td style='width:15%; height: 8px;'></td>";
								echo "<td style='width:2.5% height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";				
								$contador++;
							}else{
								$value = $keys[$contador];
								echo "<td style='width:15%;height: 8px;border-left:1px solid #ddd; padding-left:10px'>".ucfirst(str_replace('_', ' ', $keys[$contador]))."</td>";
									if($inventory[$value] == "1"){
										echo "<td style='width:2.5%;height: 8px;'><img src='../img/chekbox_true.png'></td><td style='width:2.5%;height: 8px;'>&nbsp;</td>";
									}else{
										echo "<td style='width:2.5%;height: 8px;'>&nbsp;</td><td style='width:2.5%;height: 8px;'><img src='../img/chekbox_false.png'></td>";
									} 
								
								$contador++;
							}
						  
						   }
						   //Cerramos columna
						   echo "</tr>";
						  }

				  ?>
				  
				</table>
				
				<!--
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >	
					<?php /*
						if($inventory){

								if($inventorydata){
									$keys = array_keys($inventorydata);							
									$total =  count($keys)-1;
									$columnas = 2;
									$filas = (int)$total/$columnas;
									$contador = 0;
									for($f=0;$f<round($filas);$f++){								
										echo "<tr style ='height: 8px'>";
											for($c=0;$c<2;$c++){										
												$value = $keys[$contador];
												echo "<td style='width:15%; height: 8px;'> - ".ucfirst(str_replace('_', ' ', $keys[$contador]))."</td>";
												$contador++;
											}
										echo "</tr>";
									}
								}
						}	*/					
					?>
				</table>	
				
				 end inventario -->
				
				</td></tr>
				</table>
				
</body>

</html>

