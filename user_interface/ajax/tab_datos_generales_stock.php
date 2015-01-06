<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
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
$folio_id = $_REQUEST["id"];
$folio = new Folio;			
$folio = $folio->selectbyId($folio_id);	
$vehicles = new Vehicle;		
$vehicle = $vehicles->selectbyId($folio["vehicles_record_id"]);	
$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
$dependency = new dependency;			
$dependency_data = $dependency->selectbyId($folio["dependency_id"]);	
$dependency_name =$dependency_data["name"];

$employee = new Employee;	
$result_receiver = $employee->selectbyId($folio["mechanic_assigned"]);
$recibe_unidad = $result_receiver["name"]." ".$result_receiver["last_name"];

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

<?php if(isset($_REQUEST["get"]) && $_REQUEST["get"] == "vehicle") { ?>
			<table style="width: 100%">
				<tr>
					<td style="width: 138px"><strong>Dependencia:</strong></td>
					<td><?php echo $dependency_name; ?></td>
				</tr>
				<tr>
					<td style="width: 138px"><strong>Mecanico:</strong></td>
					<td><?php echo $recibe_unidad; ?></td>
				</tr>
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
</table>
				<?php } ?>

</body>
</html>