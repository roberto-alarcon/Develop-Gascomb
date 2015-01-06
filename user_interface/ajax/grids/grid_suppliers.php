<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
include_once PATH_CLASSES_FOLDER.'class.suppliers.php';

$supplier = new Suppliers;
$suppliers = $supplier->selectAll(500);

echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($suppliers as $clave => $valor) {
			echo "<row id='".$valor["id_proveedor"]."'>";
				echo "<cell>".$valor["id_proveedor"]."</cell>";
				echo "<cell><![CDATA[".$valor["nombre"]."]]></cell>";
				echo "<cell><![CDATA[".$valor["direccion"]."]]></cell>";
				echo "<cell>".$valor["telefono"]."</cell>";
				echo "<cell>".$valor["correo"]."</cell>";
				echo "<cell>".date("d/m/Y", $valor["fecha_creacion"])."</cell>";			
				echo ($valor["fecha_actualizacion"] != 0 || $valor["fecha_actualizacion"] != 0) ? "<cell>".date("d/m/Y", $valor["fecha_actualizacion"])."</cell>" : "<cell></cell>";
				echo ($valor["status"] == "1") ? "<cell>Activo</cell>" : "<cell>Inactivo</cell>";
			echo "</row>";
				
			}
echo "</rows>";


?>
