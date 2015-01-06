<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
		
	/*****************************
	Get params for folio
	*****************************/
	$id = isset($_GET['folio'])?$_GET['folio']:0;
	
	
	$activity_id = $_GET['activity_id'];
	$cheklist_folio = $_GET['cheklist_folio'];
    
	$CheckList = new Checklist($id);
	$CheckList->checklist_id = $cheklist_folio;
	

?>
<!DOCTYPE html>

<html>

	<head>

		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">

		<!--  JQuery Mobile library -->

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
	
	<!-- CSS goes in the document HEAD or added to your external stylesheet -->
	<style type="text/css">
	table {
		font-family: verdana,arial,sans-serif;
		font-size:11px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
	}
	table th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #dedede;
	}
	table td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #ffffff;
	}
	</style>

	<script>
	
		// Funcion Ajax para vincular la actividad 
		function linkElement(id){
			//alert(id);
			
			$.ajax({
				url: "./ajax/linking_activities.php?action=add&folio=<?php echo $id; ?>&checklistfolio=<?php echo $cheklist_folio; ?>&activity="+id,
				type: "POST"						
			})
			.done( function ( response ) {
				if(response == "true"){
					//$('#dialogContent').html('Se ha registrado la solicitud de los productos');
					//$("#openDialog").click();								
					alert("Se a vinculado la actividad correctamente");
					window.location = "quality-form.php?folio=<?php echo $id; ?>&cheklist_folio=<?php echo $cheklist_folio; ?>&activity_id="+id+"&tab=2";								
					//refreshPage(); 
				}else{
					alert("Ocurrió un problema al solicitar productos");								
					//$('#dialogContent').html('Ocurrió un problema al solicitar productos');
					//$("#openDialog").click();
				}
				
			});
			
			
		}
		
		
		function changeLink(checklistfolio){
		
			if( confirm("Desea cambiar la vinculacion ") ){
			
				$.ajax({
					url: "./ajax/change_linking_activities.php?action=add&folio=<?php echo $id; ?>&checklistfolio=<?php echo $cheklist_folio; ?>&activity=0",
					type: "POST"						
				})
				.done( function ( response ) {
					if(response == "true"){
						//$('#dialogContent').html('Se ha registrado la solicitud de los productos');
						//$("#openDialog").click();								
						//alert("Se ha guardado la información");
						window.location = "quality-form.php?folio=<?php echo $id; ?>&cheklist_folio=<?php echo $cheklist_folio; ?>&activity_id=0&tab=2";								
						//refreshPage(); 
					}else{
						alert("Ocurrió un problema, favor de volver a intentarlo");								
						
					}
					
				});
				
			
			}
		
		}
	
	</script>
	
	
	</head>

	<body>

		<div data-role="header">

			<h1>  M&oacutedulo :: Control de Calidad - Detalles :: Folio - <?php echo $id; ?></h1>

			

			 <?php include_once('quality-menu.php');?>	

			

		</div>

		<div data-role="content">

			<div style="height:520px; overflow-y:scroll">

				<?php
					echo '<form name="QualityForm" action="quality_form_process.php?cheklist_folio='.$cheklist_folio.'&folio='.$id.'" method="post"  data-ajax="false">';
					$CheckList->createCheckListForm($activity_id);
					
					echo '<input type="submit" value="Guardar">';
					echo '</form>';
				
				?>
				
			</div>

		</div>

		 <?php include_once('quality-footer.php');?>	

	

	

	</body>

</html>