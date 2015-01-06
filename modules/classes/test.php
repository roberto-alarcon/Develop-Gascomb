<?php
include_once 'manejaDB.php';
echo "prueba";



//print(mkdir($estructura, 0777, true));
/*if(!mkdir($estructura, 0775, true))
{
    die('Fallo al crear carpetas...');
}
*/
/*
$db = new manejaDB();

$db->query("select * from users where user_id = '2'");

$result = $db->getArray();
print_r($result);
echo "ss";
exit(0);
foreach ($result as $clave => $valor) {
	if(is_numeric($clave)) { unset($result[$clave]); }		
}
$db->desconectar();
return($result);*/
?>