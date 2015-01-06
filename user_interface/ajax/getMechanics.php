<?php
	header("Content-type: text/xml");
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.activities.php');
	include_once(PATH_CLASSES_FOLDER.'class.employees.php');
	$employee = new Employee;
	
	$mecanics = $employee->getMechanics();
	array_sort_by_column($mecanics, 'name');
	//Funcion para ordenar array por un valor
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}
	echo "<data>";
	foreach($mecanics as $mecanic){ 
		echo "<item value='".$mecanic["employee_id"]."' label='".utf8_encode($mecanic["name"])." ".utf8_encode($mecanic["last_name"])."'/>";							
	} 
	echo "</data>";
	?>