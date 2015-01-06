<?php
header("Content-type: text/xml");
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once (PATH_CLASSES_FOLDER."class.employees.php");

 if (isset($_GET['profile']) && ($_GET['profile'] != '')){
		$value = $_GET['profile'];		
		$values["profile"] = $value;			
 }else{
	$values = null;
 }

$user = new Users;
//$users = $user->selectbyColumnLike($values,true, 500);
$users = $user->getChiefMechanics();
array_sort_by_column($users, 'name');
echo "<?xml version='1.0' encoding='ISO-8859-1'?><data>";
			foreach ($users as $clave => $valor) {															
					echo "<item value='".$valor["user_id"]."' label='".$valor["name"]." ".$valor["last_name"]."'/>";
				}

echo "</data>";


/*
$department = isset($_REQUEST["department"])? $_REQUEST["department"] : false;

$Employee = new Employee;		
if(isset($_REQUEST["role"]) && $_REQUEST["role"] == "mecanico"){
	$employees = $Employee->getMechanics();
}elseif($department){
	//Select by department
	$departmentt["department"] = $_REQUEST["department"];
	$employees = $Employee->selectbyColumn($departmentt,100);
}else{
	$employees = $Employee->selectRows(150);
}
//Ordenar por nombre:
array_sort_by_column($employees, 'name');
if ($employees){
	echo "<data>";
	foreach ($employees as $clave => $valor) {															
					echo "<item value='".$valor["employee_id"]."' label='".utf8_encode($valor["name"]." ".$valor["last_name"])."'/>";
				}
	echo "</data>";
}else{
	echo "<data>";
		echo "<item value='' label='--'/>";
	echo "</data>";
}*/


//Funcion para ordenar array por un valor
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	$sort_col = array();
	foreach ($arr as $key=> $row) {
		$sort_col[$key] = $row[$col];
	}

	array_multisort($sort_col, $dir, $arr);
}

?>
