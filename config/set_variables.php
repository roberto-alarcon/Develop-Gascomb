<?php
error_reporting(-1);
//session_start();
//include_once('host/develop.gascomb.com.php');
if ( $_SERVER['SERVER_NAME'] == 'localhost' ){
	// Developing
	include_once('host/localhost.php');
	
}elseif($_SERVER['SERVER_NAME'] == 'sistema.gascomb.com'){
	include_once('host/sistema.gascomb.com.php');
}elseif($_SERVER['SERVER_NAME'] == 'pts.gascomb.com'){
	include_once('host/pts.gascomb.com.php');
}elseif($_SERVER['SERVER_NAME'] == 'develop.gascomb.com'){	
	include_once('host/develop.gascomb.com.php');
}elseif($_SERVER['SERVER_NAME'] == 'localhost'){	
	include_once('host/localhost.php');
}elseif($_SERVER['SERVER_NAME'] == 'gascomb.dev'){	
	include_once('host/gascomb.dev.php');
}elseif ($_SERVER['SERVER_NAME'] == 'github-develop.gascomb.com') {
	include_once('host/github-develop.gascomb.com.php');
}elseif ($_SERVER['SERVER_NAME'] == 'staging.gascomb.com') {
	include_once('host/staging.gascomb.com.php');
}else{
	// Main Site
	die("No existe una configuracion para el host ".$_SERVER['SERVER_NAME']);
	//include_once('host/sistema.gascomb.com.php');
}
//echo PATH_CLASSES_FOLDER."class.gascomb.php";exit(0);
//include_once (PATH_CLASSES_FOLDER."class.gascomb.php");

//$Gascomb = new Gascomb();

?>