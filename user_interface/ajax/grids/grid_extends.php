<?php
ini_set('display_errors', '1');
//header("Content-type: text/xml");
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.users.php');
include_once PATH_CLASSES_FOLDER.'class.extends.php';
 if (isset($_GET['id']) && ($_GET['id'] != '') && isset($_GET['type']) && ($_GET['type'] != '')){
		$value = $_GET['id'];		
		$typesearch = $_GET['type'];
		$values[$typesearch] = $value;			
 }else{
	$values = null;
 }

$extends = new Extend;
$extends = $extends->selectbyColumn($values, 50);
if($extends){
	echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
	foreach ($extends as $clave => $valor) {
			$user = new Users;
			$users = $user->selectbyId($valor["sender"]);
			//$mail = ($users)? $users["email"]: "";
	
				echo "<row id='".$valor["extend_id"]."'>";
					echo "<cell>".$valor["extend_id"]."</cell>";
					//echo "<cell>".$mail."</cell>";
					//echo "<cell>".$valor["receiber"]."</cell>";
					//echo "<cell>".$valor["cc"]."</cell>";
					//echo "<cell>".$valor["title"]."</cell>";
					echo "<cell><![CDATA[".utf8_encode($valor["message"])."]]></cell>";
					echo "<cell><![CDATA[".utf8_encode($valor["comments"])."]]></cell>";
					echo "<cell>".date("d/m/Y G:i", $valor["creation_datetime"])."</cell>";
					echo ($valor["approved_datetime"] !=="") ? "<cell>".date("d/m/Y G:i", $valor["approved_datetime"])."</cell>" : "<cell>Pendiente</cell>";
					echo ($valor["approved_by"] !=="") ? "<cell><![CDATA[".utf8_encode($valor["approved_by"])."]]></cell>" : "<cell>Pendiente</cell>";
					//echo "<cell><![CDATA[".utf8_encode($valor["vobo"])."]]></cell>";
					switch ($valor["status"]) {
						case 0:
							$status= "Pendiente";
							break;
						case 1:
							$status= "Autorizado";
							break;
						case 2:
							$status= "Cancelado";
							break;
					}					
					echo "<cell>$status</cell>";
				echo "</row>";
					
				}
	echo "</rows>";
}	
?>
