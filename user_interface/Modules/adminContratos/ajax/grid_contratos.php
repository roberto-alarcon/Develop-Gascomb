<?php 
header("Content-type: text/xml");
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.dependency.php');

$dependency = new dependency();
$dependency->gridDependency();


?>