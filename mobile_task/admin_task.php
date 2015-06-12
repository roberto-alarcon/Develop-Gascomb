<?php
	header('Content-Type: text/html; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	include_once PATH_CLASSES_FOLDER.'class.activities.php';
	$id = (isset($_GET['folio']))?$_GET['folio'] : '1';
	//$id = 204;
	$tab_height = (isset($_GET['tab_height']))?$_GET['tab_height'] : '610';
	
	$activities = new FloorActivity();
	$percentProgress = $activities->getPercentProgress($id);
	$percentProgress = ($percentProgress)? round($percentProgress) : '';
	echo "<!-- $percentProgress -->";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">	
		
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> 
		<script type='text/javascript'>
			$(function(){
					$(document).on('pagebeforeshow', '#index', function(){ 
						$.mobile.ajaxEnabled = false;	
						$.mobile.defaultPageTransition = 'none';
						$('<input>').prependTo('[ data-role="content"]').attr({'name':'slider','id':'slider','data-highlight':'true','min':'0','max':'100','value':'50','type':'range'}).slider({
							create: function( event, ui ) {
								$(this).parent().find('input').hide();
								$(this).parent().find('input').css('margin-left','-9999px'); // Fix for some FF versions
								$(this).parent().find('.ui-slider-track').css('margin','0 15px 0 15px');
								$(this).parent().find('.ui-slider-track').prepend('<div id="label" style="position:absolute;text-align: center;width: 100%;">5%</div>');
								$(this).parent().find('.ui-slider-handle').hide();
								
							},
						}).slider("refresh");  
						// Test
						progressBar.setValue('#slider',<?php echo $percentProgress;?>);
					});

					var progressBar = {
						setValue:function(id, value) {
							$(id).val(value);
							$(id).slider("refresh");
							$("#label").text(value+"%");
						}
					}

			});//]]>
		/*
			$(function(){
			//$(document).bind("mobileinit", function () {
			$(document).on('pagebeforeshow', '#index', function(){ 
				$.mobile.ajaxEnabled = false;	
				$.mobile.defaultPageTransition = 'none';
				$('<input>').prependTo('[ data-role="content"]').attr({'name':'slider','id':'slider','data-highlight':'true','min':'0','max':'100','value':'50','type':'range'}).slider({
					create: function( event, ui ) {
						$(this).parent().find('input').hide();
						$(this).parent().find('input').css('margin-left','-9999px'); // Fix for some FF versions
						$(this).parent().find('.ui-slider-track').css('margin','0 15px 0 15px');
						$(this).parent().find('.ui-slider-track').prepend('<div id="label" style="position:absolute;text-align: center;width: 100%;">5%</div>');
						$(this).parent().find('.ui-slider-handle').hide();
						
					},
				}).slider("refresh");      
				
					// Test
					progressBar.setValue('#slider',<?php echo $percentProgress;?>);
				var progressBar = {
				setValue:function(id, value) {
					$(id).val(value);
					$(id).slider("refresh");
					$("#label").text(value+"%");
				}
			}
				
			});		
			});	*/
			
		</script>
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>		
		<link type="text/css" rel="stylesheet" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.css" />
		<script type="text/javascript" language="JavaScript" src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxcommon.js"></script>
		<script type="text/javascript" language="JavaScript" src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.js"></script>
	</head>
	<body>
	<div data-role="page" id="index">
		<div data-role="header">
			<h1> Módulo :: Administración de tareas :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once('menu.php');?>	
			<div data-role="navbar">
				<ul>
					<li><a href="admin_task.php?folio=<?php echo $id;?>&tab=2&subtab=1" class="ui-btn-active ui-state-persist" data-ajax="false">Gráfica de Gantt</a></li>					
					<li><a href="update_task_form.php?folio=<?php echo $id;?>&tab=2&subtab=2" data-ajax="false">Asignar / Modificar tareas</a></li>
					<li><a href="admin_task_form.php?folio=<?php echo $id;?>&tab=2&subtab=3" data-ajax="false">Agregar nueva tarea</a></li>
				</ul>
			</div><!-- /navbar -->
			
			
		</div>
		<div data-role="content">
			<iframe style="width:100%;border:none;" height="480px" src="https://sistema.gascomb.com/ajax/gantt/gantt_demo.php?tab_height=<?php echo $tab_height;?>&folio=<?php echo $id;?>"></iframe>
		</div>
		<?php  include "footer.php";?>
		</div>  
	</body>
</html>
