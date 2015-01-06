<?php
header('Content-type: application/json');
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.employees.php');


$code = $_POST['code'];
$employee = new Employee();
$result = $employee->getIDEmployeByCode($code);
echo json_encode($result);

//print_r($_POST);

?>