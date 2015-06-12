<?php 
//header( 'Content-type: text/html; charset=iso-8859-1' );
global $id;
ini_set('display_errors', '1');
include_once '/home/gascomb/secure_html/modules/classes/manejaDB.php';

$data["folio_id"] = $_GET['folio'];
$db1 = new manejaDB();
$db1->query("select tower from folios where folio_id= '".$data['folio_id']."'");
$result = $db1->getArray();
//print_r($result);exit(0);
$db1->desconectar();
if(!empty($result)){
$tower=$result["tower"];
}else{ 
$tower = "";
}
echo $tower;