<?php
	ini_set('display_errors', '1');
	header('Content-Type: text/html; charset=utf-8');
	include_once ('/home/gascomb/secure_html/config/set_variables.php');
	include_once PATH_CLASSES_FOLDER.'class.folio.php';	
	include_once PATH_CLASSES_FOLDER.'class.tracing.php';
	include_once PATH_CLASSES_FOLDER.'class.users.php';
	include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
	
	$id = $_GET['folio'];	
	$Tracing = new Tracing;
	$user = new Users;
	$folio = new Folio;			
	$vehicles = new Vehicle;		
	$folio = $folio->selectbyId($id);	
	$vehicle = $vehicles->selectbyId($folio["vehicles_record_id"]);	
	$placa = $vehicle["registration_plate"];
	$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
	$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>		
		<script>			
		</script>		
	</head>
	<body>
		<div data-role="page" id="home">
		<div data-role="header">
			<h1>  Módulo :: Seguimiento :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once 'menu.php';?>	
			 <?php include_once 'menu_tracing.php';?>
		</div>
		<div data-role="content">
		
			<div data-role="collapsible" data-theme="c" data-content-theme="c" data-collapsed="false">
					<h2><?php echo "Folio: ".$id; ?></h2>
					<ul data-role="listview" data-theme="c" data-divider-theme="c">
					<li data-role="list-divider"><?php  echo "Vehiculo: ".$brand." ".utf8_encode($model)." | Placas: ".$placa; ?> </li>
					<table width="100%" border="1" style="border-collapse:collapse;border: 1px solid #c0c0c0;" cellpadding="5" cellspacing="0">
					<?php 
					
					$mensajes = $Tracing->getTracings($id);
					if($mensajes){						
						?>
						
						<tr><td><strong>Avances</strong></td><td><strong>Empleado</strong></td><td><strong>Fecha</strong></td></tr>
						
						<?php 
							foreach($mensajes as $rows){
								$name_user = utf8_encode($user->getName($rows['user_id']));
								echo '<tr>';
								echo '<td>'.utf8_encode($rows['comments']).'</td>';
								echo '<td>'.$name_user.'</td>';
								$fechaentrega = ($rows['creation_datetime'] !== '0') ? date('d/m/Y H:i:s',$rows['creation_datetime']): '';
								echo '<td>'.$fechaentrega.'</td>';					
								echo '</tr>';
							}
						}else{ 
							
							echo "<tr><td>Aún no hay información del vehículo</td></tr>";
							
						}
					?>
					</table>
					</ul>
					</div>
			
		</div>
		<?php  include "footer.php";?>
	</body>
</html>