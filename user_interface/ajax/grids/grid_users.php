<?php
ini_set('display_errors', '1');
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once (PATH_CLASSES_FOLDER.'class.folio.php');
include_once PATH_CLASSES_FOLDER.'class.users.php';
 if (isset($_GET['id']) && ($_GET['id'] != '') && isset($_GET['type']) && ($_GET['type'] != '')){
		$value = $_GET['id'];		
		$typesearch = $_GET['type'];
		$values[$typesearch] = $value;			
 }else{
	$values = null;
 }
$user = new Users;
$users = $user->selectbyColumn($values, 500);
echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($users as $clave => $valor) {
			echo "<row id='".$valor["user_id"]."'>";
				echo "<cell>".$valor["user_id"]."</cell>";
				echo "<cell>".$valor["email"]."</cell>";
				echo "<cell>".$valor["name"]."</cell>";
				echo "<cell>".$valor["last_name"]."</cell>";
				echo "<cell>".date("d/m/Y", $valor["creation_time"])."</cell>";			
				echo ($valor["status"] == "1") ? "<cell>Activo</cell>" : "<cell>Inactivo</cell>";
			echo "</row>";
				
			}
echo "</rows>";
?>
