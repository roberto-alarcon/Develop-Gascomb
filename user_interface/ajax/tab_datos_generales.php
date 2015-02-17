<?php 
header( 'Content-type: text/html; charset=iso-8859-1' );
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.contracts.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.inventory.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.employees.php';
include_once PATH_CLASSES_FOLDER.'class.users.php';
include_once PATH_CLASSES_FOLDER.'class.type_activities.php';


	//$_REQUEST["folio_id"]="30";	
	$folio_id = $_REQUEST["id"];
	$folio = new Folio;			
	$folio = $folio->selectbyId($folio_id);	
	$vehicles = new Vehicle;		
	$vehicle = $vehicles->selectbyId($folio["vehicles_record_id"]);	
	$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
	$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
	$dependency = new dependency;			
	$dependency_data = $dependency->selectbyId($folio["dependency_id"]);	
	$dependency_name = utf8_encode($dependency_data["name"]);
	$inventorydata = array();
	//print_r($model);
	
	$status = $folio["support_status_id"];
	

	//echo $folio["inventory_id"];
	$inventory = new Inventory;	
	if($folio["inventory_id"] !==""){	
		$inventory = $inventory->selectbyId($folio["inventory_id"]);
		if($inventory){
			foreach($inventory as $key => $value){
				if($value == "1" and $key !== "inventory_id"){
					$inventorydata[$key] = $value;
				}
			}
		}	
	}
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

<title>Datos generales</title>
 <style>
      table {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12px;
		color:#3b3b3b;
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
 </style>
</head>

<body>
			<?php if(isset($_REQUEST["get"]) && $_REQUEST["get"] == "general") { ?>
            
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="40%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="30%"><span style="width: 142px"><img src="<?php echo str_replace("[id_folio]", $folio["folio_id"], QR_IMAGE_URL);; ?>" /></span></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="38%"><strong>Folio:</strong></td>
            <td><span class="bigtext" style="width: 115px; height: 19px"><?php echo $folio["folio_id"]; ?></span></td>
          </tr>
		  <tr>
            <td><strong>Semaforo de entrega:</strong></td>
            <td>
							
				  <?php 
				  switch ($status){
					case '8':
						echo '<div style="text-align:left; font-size:18px; color:#f00">';
						echo "<b>ENTREGADO</b>";
						echo '</div>';
						break;
					case '9':
						echo '<div style="text-align:left; font-size:18px; color:#f00">';
						echo "<b>CANCELADO</b>";
						echo '</div>';
						break;
					default:
						echo '<div style="width:25px;height:20px; padding:7px; text-align:center; font-size:18px; color:#fff;background'.$resultSemaforo["hex"].'">';
						echo ($resultSemaforo["color"] == "verde" || $resultSemaforo["color"] == "amarrillo" || $resultSemaforo["color"] == "ambar")? "" : $resultSemaforo["dias"];
						echo '</div>';
						break;
				  
				  }
			  
					?>
				
			</td>
          </tr>
		  
          <tr>
            <td><strong>Fecha de 
			    ingreso:</strong></td>
            <td><span style="width: 115px; height: 19px"><?php echo $folio["entry_date"]; ?> <?php echo $folio["entry_time"]; ?></span></td>
          </tr>
          <tr>
            <td><strong>Tipo de servicio:</strong></td>
            <td><span style="width: 115px; height: 19px"><?php echo $type_activity; ?> <?php echo $folio["departure_time"]; ?></span></td>
          </tr>
          <tr>
            <td><span style="width: 100px; height: 19px"><strong>Recibido por:</strong></span></td>
            <td><span style="width: 115px; height: 19px"><?php echo $recibe_unidad; ?></span></td>
          </tr>
          <tr>
            <td><strong>Jefe de mecanicos:</strong></td>
            <td><?php echo $jefemecanicos; ?></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
    <td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="9%"><strong>Torre:</strong></td>
			<td><span style="margin:20px;"><?php echo $folio["tower"]; ?></span></td>
		  </tr>
		  <tr>
			<td><strong>Cajon:</strong></td>
			<td><span style="margin:20px;"><?php echo $folio["parking_space"]; ?></span></td>
		  </tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<?php if($status == '9'){?>
			<tr>
			  <td width="100%" align="center"><span class="bigtext" style="width: 115px; height: 19px; color:red">CANCELADO</span></td>			  
			</tr>			
			<?php }else{ ?>
			<tr>
			  <td width="60%" align="center" bgcolor="#01B8E2" ><span style="color:#fff; width: 330px; height: 19px"><strong>SERVICIOS A REALIZAR:</strong></span></td>
			  <td width="40%"  align="center" bgcolor="#BDBDBD"><span style="color:#fff; width: 200px; height: 19px"><strong>FALLAS:</strong></span></td>
			</tr>
			<tr>
			  <td bgcolor="#F6F6F6"><div style="margin:5px;">
				<?php if($activities){
									echo "<OL>";
									foreach($activities as $value){
										if($value["description"] !== ""){
											echo "<LI>".$value["description"];										
										}
									}
									echo "</OL>";
								}else{
									echo "";
								}
							?>
			  </div></td>
			  <td bgcolor="#eaeaea">						<div style="margin:10px;"><?php echo $folio["failures"]; ?></div></td>
			</tr>
			<?php } ?>
		</table>
	</td>
  </tr>
</table>
            <?php } ?>
		
		<?php if(isset($_REQUEST["get"]) && $_REQUEST["get"] == "client") { ?>
<table style="width: 100%">
				<tr>
					<td><strong>Nombre:</strong></td>
					<td><?php echo $vehicle["owner_name"]; ?></td>
				</tr>
				<tr>
					<td><strong>Direccci&oacute;n</strong></td>
					<td><?php echo $vehicle["owner_adress"]; ?></td>
				</tr>
				<tr>
					<td><strong>Tel.:</strong></td>
					<td><?php echo $vehicle["owner_phone"]; ?></td>
				</tr>
				<tr>
					<td style="height: 19px"><strong>Cel.:</strong></td>
					<td style="height: 19px"><?php echo $vehicle["owner_cell"]; ?></td>
				</tr>
				<tr>
					<td><strong>email:</strong></td>
					<td><?php echo $vehicle["owner_email"]; ?></td>
				</tr>
				<tr>
					<td><strong>Cliente:</strong></td>
					<td><?php echo utf8_decode($dependency_name); ?></td>
				</tr>
				<tr>
					<td><strong>Responsable <br>de la unidad:</strong></td>
					<td><?php echo $folio["vehicle_operator"]; ?></td>
				</tr>
				<tr>
					<td><strong>Tel.:</strong></td>
					<td><?php echo $folio["operator_tel"]; ?></td>
				</tr>
				<tr>
					<td><strong>Area/Sector:</strong></td>
					<td><?php echo $folio["area_sector"]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
</table>
			<?php } ?>
			
			<?php if(isset($_REQUEST["get"]) && $_REQUEST["get"] == "vehicle") { ?>
			<table style="width: 100%">
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
					<td style="width: 138px"><strong>A&ntilde;o:</strong></td>
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
				<tr>
					<td style="width: 138px"><strong>Tipo de combustible:</strong></td>
					<td><?php echo $vehicle["fuel"] ?></td>
				</tr>
</table>
				<?php } ?>
				
				
				<?php if(isset($_REQUEST["get"]) && $_REQUEST["get"] == "inventory") { ?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >	
						<?php 
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
							}	
						?>
					<table>	
					<?php } ?>
				
</body>

</html>
