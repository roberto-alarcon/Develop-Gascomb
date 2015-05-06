<?php
include_once('/home/gascomb/secure_html/config/set_variables.php');

echo "<h3>Sistema</h3>";
echo "Dominio -> ".DOMAIN."<br>";
echo "Path Libreria -> ".PATH_DHTMLX_LIBRARY."<br>";
echo "Path Ajax -> ".PATH_USER_INTERFACE_AJAX."<br>";
echo "Path Multimedia -> ".PATH_MULTIMEDIA."<br>";
echo "Dir Multimedia -> ".PATH_MULTIMEDIA_BASE."<br>";
echo "Dir Aplicacion -> ".PATH_BASE_FOLDER."<br>";


echo "Dir Clases -> ".PATH_CLASSES_FOLDER."<br>";
echo "Path Multimedia -> ".URL_MULTIMEDIA."<br>";
echo "Path QR -> ".QR_IMAGE_URL."<br>";
echo "Path URL PDF -> ".PDF_URL."<br>";
echo "Path Imagen -> ".PATH_IMAGE_INVENTORY."<br>";
echo "Path Server -> ".PATH_SERV."<br>";
// BD // 
echo "<h3>BD</h3>";
echo "BD USER -> ".BD_USER."<br>";
echo "BD PASS -> ".BD_PASSWORD."<br>";
echo "BD DATABASE -> ".BD_DATABASE."<br>";
echo "BD SERVER -> ".BD_SERVER."<br>";

echo "<h3>Variables Globales Server Ubutntu 1.2</h3>";
echo "<h3>Sin conflictos</h3>";
print_r($Gascomb);
?>
