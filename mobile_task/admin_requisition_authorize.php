<?php
	ini_set('display_errors',1);
	header('Content-Type: text/html; charset=utf-8');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.mobile.php');	
	$id = $_GET['folio'];
	//$id = 204;
	$Stock = new Stock;
	$stock_id = $Stock->getStockId($id);	
	$stockmob = new Stock_mobile($id);
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
		<script>
			var productsarray = new Array()
			var folio_id = <?php echo $id;?>;
			$(document).ready(function(){
				$.mobile.defaultPageTransition = 'none';
				$( '#btnSelectAll').on( "click", function(event, ui) {						
					$('.products').each(function(){ 
						this.checked = ! this.checked; 
						$(this).checkboxradio("refresh")
					});
				});
				//Autorizar solicitudes
				$( '#btnAutorize').on( "click", function(event, ui) {	
					var productos = [];
					$('.products:checked').each(function() {																					
							productos.push($(this).attr('id'));
						
					});	
					if(productos.length !== 0){
						$.ajax({
							url: "./ajax/autorize_requisition.php?folio="+folio_id+"&action=autorize&products="+productos,
							type: "POST"						
						})
						.done( function ( response ) {					
							if(response =='true'){
								//$('#dialogContent').html('Se han autorizado los productos seleccionados');
								alert("Se ha guardado la información");
								window.location = "admin_requisition.php?folio=<?php echo $id; ?>&tab=3&subtab=1";	
								//refreshPage();
							}else{
								alert("Ocurrió un error al guardar la información");							
							}
							
						});
					}else{
						alert("Es importante seleccionar un elemento para aplicar esta acción");
						return;
					}	
					
				});
				//Cancelar solicitudes
				$( '#btnCancel').on( "click", function(event, ui) {	
					var productos = [];
					$('.products:checked').each(function() {																					
							productos.push($(this).attr('id'));
						
					});	
					
					if(productos.length !== 0){
						$.ajax({
							url: "./ajax/autorize_requisition.php?folio="+folio_id+"&action=cancel&products="+productos,
							type: "POST"						
						})
						.done( function ( response ) {
							if(response =='true'){
								alert("Se han cancelado las solicitudes seleccionadas");
								refreshPage();
							}else{
								alert("Ocurrió un error al cancelar las solicitudes");							
							}
							
						});
					}else{
						alert("Es importante seleccionar un elemento para aplicar esta acción");
						return;
					}		
					
				});
				
				/*
				$("#dialog").on("pagehide",function(){
						refreshPage();
				});*/
			
			})
			
			function refreshPage() {
				  $.mobile.changePage(
					window.location.href,
					{
					  allowSamePageTransition : true,
					  transition              : 'none',
					  showLoadMsg             : false,
					  reloadPage              : true
					}
				  );
				}
			
		</script>	
	</head>
	<body>
		
		<div data-role="page" id="home">
			<div data-role="header">
				<h1>  Módulo :: Requisiciones :: Folio - <?php echo $id; ?></h1>
				
				 <?php include_once 'menu.php';?>	
				 <?php include_once 'menu_requisition.php';?>
			</div>
			<div data-role="content">
					
				<?php		
				
				$products = $stockmob->getElementsPending($stock_id);
			 ?>
			
			</div>
			<?php  include "footer.php";?>
		</div>	
		<!--
		<div data-role="page" id="dialog">
		
				<div data-role="header" data-theme="d">
					<h1>Dialog</h1>
				</div>
				
				<div data-role="content" data-theme="c" id="dialogContent">					
					
				</div>
		</div>-->
		
			
	</body>

</html>