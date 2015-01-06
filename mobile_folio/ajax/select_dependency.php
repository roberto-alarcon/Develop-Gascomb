<?php
header("Content-type: text/xml");
//header("Content-Type: application/xml; charset=utf-8");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.dependency.php");
$dep = new dependency;		
$dependencys = $dep->selectRows(100);
echo "<data>";
foreach ($dependencys as $clave => $valor) {															
				echo "<item value='".$valor["dependency_id"]."' label='".utf8_encode($valor["name"])."'/>";
				
			}
echo "</data>";

?>
