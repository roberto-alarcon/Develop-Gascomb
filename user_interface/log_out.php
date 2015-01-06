<?php
	session_start();
	session_destroy();
	header( 'Location: /' ) ;
	//include_once ("../config/set_variables.php");
	//print_r($_SESSION);
	//unset($_SESSION['active_user']);
	//session_destroy();
	//header('location:./');
	
?>