<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.activities.php');
	include_once(PATH_CLASSES_FOLDER.'class.employees.php');	
	$id = $_GET['folio'];
	//$id = 204;
	$activity = new FloorActivity;
	$employee = new Employee;
	$support_activities = $activity->getSupportActivities();
	$mecanics = $employee->getMechanics();
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
	
		
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" /> 
		<link type="text/css" href="js/datebox/jqm-datebox.min.css" rel="stylesheet" /> 

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script> 
		<script type="text/javascript" src="js/datebox/jqm-datebox.core.min.js"></script>
		<script type="text/javascript" src="js/datebox/jqm-datebox.mode.calbox.min.js"></script>
		<script type="text/javascript" src="js/datebox/jqm-datebox.mode.datebox.min.js"></script>
		
		
		<script>
			var productsarray = new Array()
			var folio_id = <?php echo $id;?>;
			$(document).ready(function(){
				$.mobile.defaultPageTransition = 'none';
				$('fecha').datebox('setTheDate', new Date());
				$( '#link').on( "click", function(event, ui) {
					var datetime = $("#fecha").val()+" "+$("#hora").val();
					var timeunix = new Date(datetime).getTime() / 1000;
					
					console.log(timeunix);
					//console.log($("#mode1").val());						
					//console.log($("#mode6").val());						
				});
			
			});
			
		</script>
		
		
	</head>
	<body>
	<div data-role="page" id="home">
		<div data-role="header">
			<h1> Módulo :: Administración de tareas :: Folio - <?php echo $id; ?></h1>
			<a href="index.html" data-icon="gear" class="ui-btn-right">Options</a>
			 <?php include_once 'menu.php';?>	
			 <div data-role="navbar">
				<ul>
					<li><a href="admin_task.php?folio=<?php echo $id;?>&tab=2&subtab=1" data-ajax="false">Gráfica de Gantt</a></li>
					<li><a href="admin_task_form.php?folio=<?php echo $id;?>&tab=2&subtab=2" class="ui-btn-active ui-state-persist" data-ajax="false">Asignación de Tareas</a></li>
				</ul>
			</div>
				
		</div>
		<div data-role="content">		
					<div data-role="fieldcontain">										
						<label for="fecha">Fecha de inicio:</label>
						<input name="fecha" id="fecha" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"calbox"}' />
					</div>	
					<div data-role="fieldcontain">
						<label for="hora">Hora:</label>
						<input name="hora" id="hora" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"timebox"}' />					
					</div>	
					<a href="#" id="link" data-role="button">Link button</a>				
		</div>		
	
	</body>
</html>