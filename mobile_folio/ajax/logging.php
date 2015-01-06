<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.users.php';

$user = new Users;
$usuario 	= $_POST['usuario'];
$password	= $_POST['password'];


$result = $user->login($usuario, $password);	
if($result){
	echo '{"respuesta":true}';
}else{
	echo '{"respuesta":false}';
}


?>