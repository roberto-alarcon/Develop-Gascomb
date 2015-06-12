<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	
	$id = $_GET['folio'];	

?>

<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
		
		<script>
			var productsarray = new Array()
			var folio_id = <?php echo $id;?>;
			$(document).ready(function(){
			//$(document).bind("pageinit", function() {
				//event.preventDefault();
				
				
				$.mobile.defaultPageTransition = 'none';		
				var cont = 1;
				$( '#btnNuevo').on( "click", function(event, ui) {
					
					$("#formContent_"+cont).show();
					$('html, body').stop().animate({  
						scrollTop: $('#formContent_'+cont).offset().top  
					}, 1000); 
					
					cont++;												
				});
				$( '#btnGuardar').on( "click", function(event, ui) {
					var comments = [];					
					$('textarea:visible').each(function() {						
						if($(this).val()){  comments.push($(this).val()); }else{ alert("Debe agregar el comentario en el campo correspondiente"); $(this).focus(); }
						
					});
					
					if(comments.length !== 0){
						comments = JSON.stringify(comments)	
						$.ajax({
								url: "./ajax/insert_tracing.php?action=add&folio="+folio_id+"&comments="+comments,
								type: "POST"						
						})
						.done( function ( response ) {
							if(response == "true"){								
								alert("Se ha guardado la información");
								window.location = "view_tracing.php?folio=<?php echo $id; ?>&tab=5&subtab=1";																
							}else{
								alert("Ocurrió un problema al solicitar productos");								
							}
							
						});						
					}					
				});		
			
			});
			
		</script>
		
		
	</head>
	<body>
		<div data-role="page" id="home">
		<div data-role="header">
			<h1>  Módulo :: Seguimiento :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once 'menu.php';?>	
			 <?php include_once 'menu_tracing.php';?>
		</div>
		<div data-role="content">
		
			<form action="" id="frmProducts" class="validate" method="post" data-ajax="false">
				
				<ul class="product" id="formContent_0" data-role='listview' data-inset='true' style="width:98%; margin:10px auto;">
						<li data-role="list-divider">
								<h1>Avance 1:</h1>
						</li>
						<li data-role="fieldcontain" data-mini="true">
							<label for="comentario_0">Comentarios:</label>
							<textarea name="comentario_0" id="comentario_0" data-mini="true" class="required"></textarea>
						</li>
				</ul>
				
				
				<ul class="product" id="formContent_1" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 2:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_1">Comentarios:</label>
						<textarea name="comentario_1" id="comentario_1" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				
				<ul class="product" id="formContent_2" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 3:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_2">Comentarios:</label>
						<textarea name="comentario_2" id="comentario_2" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_3" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 4:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_3">Comentarios:</label>
						<textarea name="comentario_3" id="comentario_3" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_4" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 5:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_4">Comentarios:</label>
						<textarea name="comentario_4" id="comentario_4" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_5" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 6:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_5">Comentarios:</label>
						<textarea name="comentario_5" id="comentario_5" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_6" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 7:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_6">Comentarios:</label>
						<textarea name="comentario_6" id="comentario_6" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_7" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 8:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_7">Comentarios:</label>
						<textarea name="comentario_7" id="comentario_7" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				<ul class="product" id="formContent_8" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 9:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_8">Comentarios:</label>
						<textarea name="comentario_8" id="comentario_8" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				<ul class="product" id="formContent_9" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Avance 10:</h1>
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_9">Comentarios:</label>
						<textarea name="comentario_9" id="comentario_9" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
			
			
			</form>
			<fieldset class="ui-grid-a" style="width:98%; margin:10px auto 0px;">			
				<div class="ui-block-a"><input type="button" id="btnNuevo" data-icon="plus" value="Nuevo elemento"></div>
				<div class="ui-block-b"><button type="button" id="btnGuardar" data-theme="e" data-icon="check">Guardar</button></div>
			</fieldset>		
		</div>
		<?php  include "footer.php";?>
		</div>
		<div data-role="page" id="dialog">
		
				<div data-role="header" data-theme="d">
					<h1>Mensaje</h1>
				</div>
				
				<div data-role="content" data-theme="c" id="dialogContent">					
					
				</div>
		</div>
		<a id='openDialog' href="#dialog" data-rel="dialog" data-transition="pop" style='display:none;'></a>
	
	</body>
</html>