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

$employee = new Employee;
$users = $employee->selectReceptors();

array_sort_by_column($users, 'name');
echo "<?xml version='1.0' encoding='ISO-8859-1'?><data>";
			foreach ($users as $clave => $valor) {															
					echo "<item value='".$valor["employee_id"]."' label='".$valor["name"]." ".$valor["last_name"]."'/>";
				}

echo "</data>";

//Funcion para ordenar array por un valor
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	$sort_col = array();
	foreach ($arr as $key=> $row) {
		$sort_col[$key] = $row[$col];
	}

	array_multisort($sort_col, $dir, $arr);
}

?>