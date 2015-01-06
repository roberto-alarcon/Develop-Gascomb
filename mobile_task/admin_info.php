<?php

	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once '/home/gascomb/secure_html/config/secure_validations.php';
	header('Content-Type: text/html; charset=utf-8'); 
	
	//$id = $_GET['folio'];
	
	if(!isset($_SESSION['active_user_id'])){
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
	}

?>
<?php
	/*****************************
	Get params for folio
	*****************************/
	$id = isset($_GET['folio']) ? $_GET['folio'] : 0; 
	//$id = 204;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script language="text/javascript">
			$(document).ready(function(){
				$.mobile.defaultPageTransition = 'none';					
			});		
		</script>
		
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
				
	</head>
	<body>
	
		<div data-role="header">
			<h1>  Módulo :: Información general :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once('menu.php');?>				 
			
		</div>
		<div data-role="content">
			<div style="height:520px; overflow-y:scroll">
				<?php 
						include_once('./ajax/tab_datos_generales.php');
				 ?>
			</div>
		</div>
		<?php  include "footer.php";?>
	
	
	</body>
</html>