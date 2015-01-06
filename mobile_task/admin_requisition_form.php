<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.mobile.php');	
	
	$id = $_GET['folio'];
	//$id = 204;
	
	$stock = new Stock_mobile('1');

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
				
				autocompl('autocomplete0')				
				var cont = 1;
				$( '#btnNuevo').on( "click", function(event, ui) {
					
					$("#formContent_"+cont).show();
					autocompl('autocomplete'+cont);
					$('html, body').stop().animate({  
						scrollTop: $('#formContent_'+cont).offset().top  
					}, 1000); 
					
					cont++;												
				});
				$( '#btnGuardar').on( "click", function(event, ui) {
					var engine = $("#engine").val();
					
					if(engine == ""  || engine == "null"){
						alert("Es importante agregar tipo de motor");
						$("#engine").focus();
						throw ""
					}
				
					var productos = [];
					var count = 0;
					$('.ui-listview-filter input:visible').each(function () {
						if($("#product_"+count).val() !== "" || $(this).val() !=='' ){
								var producto = {};
								 producto.producto_id = ($("#product_"+count).val())? $("#product_"+count).val() : $(this).val();
								 producto.cantidad = $("#cantidad_"+count).val();
								 producto.unit = $("#unidad_"+count).val(); 
								 producto.engine = engine;	
								 producto.comentario = $("#comentario_"+count).val();							 
								productos.push(producto);
						}
					
						//console.log($("#product_"+count).val());
						//console.log($(this).val());
						count++;
					});
					
					/*
					$('.products').each(function() {						
						
						var count= $(this).attr('id').replace("autocomplete", "");						
							if($("#product_"+count).val() !== ""){
								var producto = {};
								 producto.producto_id = $("#product_"+count).val();
								 producto.cantidad = $("#cantidad_"+count).val();
								 producto.comentario = $("#comentario_"+count).val();							 
								productos.push(producto);
							}
						
					});	*/
					//console.log(productos);
					if(productos.length !== 0){
						productoss = JSON.stringify(productos)					
						$.ajax({
							url: "./ajax/insert_requisition.php?action=add&folio="+folio_id+"&products="+productoss,
							type: "POST"						
						})
						.done( function ( response ) {
							if(response == "true"){
								//$('#dialogContent').html('Se ha registrado la solicitud de los productos');
								//$("#openDialog").click();								
								alert("Se ha guardado la información");
								window.location = "admin_requisition.php?folio=<?php echo $id; ?>&tab=3&subtab=1";								
								//refreshPage(); 
							}else{
								alert("Ocurrió un problema al solicitar productos");								
								//$('#dialogContent').html('Ocurrió un problema al solicitar productos');
								//$("#openDialog").click();
							}
							
						});
					}else{
						alert("Favor de agregar productos a la solicitud");										
					}

					
				});		
			
			});
			
			//autocomplete
				function autocompl(id_input){	
					 $( "#"+id_input ).on( "listviewbeforefilter", function ( e, data ) {
						$("#"+id_input).show();						
						var $ul = $( this ),
							$input = $( data.input ),
							value = $input.val(),							
							html = "";
						
							$ul.html( "" );
						if ( value && value.length > 2 ) {
							$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
							$ul.listview( "refresh" );
							$.ajax({
								url: "search_product.php",
								dataType: "json",
								data: {
									q: $input.val()
								}
							})
							.done( function ( response ) {								
								$.each( response, function ( i, val ) {																	
									html += "<li id="+val.support_stock_product_id+">" + val.product + "</li>";
								});
								$ul.html( html );
								$ul.listview( "refresh" );
								$ul.trigger( "updatelayout");
							});
						}
						
						$("#"+id_input).on('click', 'li', function(e,data){		
							$("#"+id_input).val($(this).text());
							$input.val($(this).text());
							$("#"+id_input).hide();
							
							var count_input= id_input.replace("autocomplete", "");
							var productselected_id = $(this).attr('id');
							//console.log(productselected_id);
							/*
							$('.products').each(function() {						
								var count= $(this).attr('id').replace("autocomplete", "");
								
								if(productselected_id = $("#product_"+count).val()){
									console.log('repetido');
									console.log($("#product_"+count).val());
									return;
								}else{
									console.log('aceptado');
								}
								// producto.producto_id = $("#product_"+count).val();
							});*/
							//Aplicamos el producto seleccionado al input hidden
							$("#product_"+count_input).val($(this).attr('id'));							
						}); 
						
					});
					
					
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
		
			<form action="" id="frmProducts" class="validate" method="post" data-ajax="false">
					<div class="ui-grid-solo">				
					<div class="ui-block-a">
						<div data-role="fieldcontain">
							<label for="engine"><strong>MOTOR:</strong></label>
							<input type="text" name="engine" id="engine" value="" placeholder="MOTOR 4.8 6 CIL" />
						</div>
					</div>					
				</div>
				
				<ul class="product" id="formContent_0" data-role='listview' data-inset='true' style="width:98%; margin:10px auto;">
						<li data-role="list-divider">
								<h1>Solicitud 1:</h1>
						</li>
						<li data-role="fieldcontain">
							<div data-role="fieldcontain">
							<input type="hidden" id="product_0" value="" />
							<ul id="autocomplete0" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
							</div>
						</li>
						<li data-role="fieldcontain">
							<label for="cantidad_0">Cantidad:</label>
							<input type="number" name="cantidad_0" id="cantidad_0" min="1" value="1" />
						</li>
						<li data-role="fieldcontain">
							<label for="unidad_0">Unidad de medida:</label>
							<input type="text" name="unidad_0" id="unidad_0" placeholder="Pieza, Litros, juego, bote, lata.." />
						</li>
						<li data-role="fieldcontain" data-mini="true">
							<label for="comentario_0">Comentarios:</label>
							<textarea name="comentario_0" id="comentario_0" data-mini="true" class="required"></textarea>
						</li>
				</ul>
				
				
				<ul class="product" id="formContent_1" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 2:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
							<input type="hidden" id="product_1" value="" />
							<ul id="autocomplete1" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_1">Cantidad:</label>
						<input type="number" name="cantidad_1" id="cantidad_1" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_1">Unidad de medida:</label>
							<input type="text" name="unidad_1" id="unidad_1" placeholder="Pieza, Litros, juego, bote, lata.." />
						</li>
					<li data-role="fieldcontain">
						<label for="comentario_1">Comentarios:</label>
						<textarea name="comentario_1" id="comentario_1" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				
				<ul class="product" id="formContent_2" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 3:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
							<input type="hidden" id="product_2" value="" />							
							<ul id="autocomplete2" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_2">cantidad:</label>
						<input type="number" name="cantidad_2" id="cantidad_2" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_2">Unidad de medida:</label>
							<input type="text" name="unidad_2" id="unidad_2" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_2">Comentarios:</label>
						<textarea name="comentario_2" id="comentario_2" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_3" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 4:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
							<input type="hidden" id="product_3" value="" />
							<ul id="autocomplete3" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_3">Cantidad:</label>
						<input type="number" name="cantidad_3" id="cantidad_3" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_3">Unidad de medida:</label>
							<input type="text" name="unidad_3" id="unidad_3" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_3">Comentarios:</label>
						<textarea name="comentario_3" id="comentario_3" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_4" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 5:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
							<input type="hidden" id="product_4" value="" />
							<ul id="autocomplete4" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_4">Cantidad:</label>
						<input type="number" name="cantidad_4" id="cantidad_4" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_4">Unidad de medida:</label>
							<input type="text" name="unidad_4" id="unidad_4" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_4">Comentarios:</label>
						<textarea name="comentario_4" id="comentario_4" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_5" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 6:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_5" value="" />
						<ul id="autocomplete5" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_5">Cantidad:</label>
						<input type="number" name="cantidad_5" id="cantidad_5" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_5">Unidad de medida:</label>
							<input type="text" name="unidad_5" id="unidad_5" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_5">Comentarios:</label>
						<textarea name="comentario_5" id="comentario_5" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_6" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 7:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_6" value="" />
						<ul id="autocomplete6" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_6">Cantidad:</label>
						<input type="number" name="cantidad_6" id="cantidad_6" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_6">Unidad de medida:</label>
							<input type="text" name="unidad_6" id="unidad_6" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_6">Comentarios:</label>
						<textarea name="comentario_6" id="comentario_6" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				
				<ul class="product" id="formContent_7" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 8:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_7" value="" />
						<ul id="autocomplete7" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_7">Cantidad:</label>
						<input type="number" name="cantidad_7" id="cantidad_7" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_7">Unidad de medida:</label>
							<input type="text" name="unidad_7" id="unidad_7" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_7">Comentarios:</label>
						<textarea name="comentario_7" id="comentario_7" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				<ul class="product" id="formContent_8" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 9:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_8" value="" />
						<ul id="autocomplete8" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_8">Cantidad:</label>
						<input type="number" name="cantidad_8" id="cantidad_8" min="1" value="1"  />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_8">Unidad de medida:</label>
							<input type="text" name="unidad_8" id="unidad_8" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_8">Comentarios:</label>
						<textarea name="comentario_8" id="comentario_8" data-mini="true" class="required"></textarea>
					</li>
					
					
				</ul>
				<ul class="product" id="formContent_9" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 10:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_9" value="" />
						<ul id="autocomplete9" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_9">Cantidad:</label>
						<input type="number" name="cantidad_9" id="cantidad_9" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_9">Unidad de medida:</label>
							<input type="text" name="unidad_9" id="unidad_9" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_9">Comentarios:</label>
						<textarea name="comentario_9" id="comentario_9" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_10" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 11:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_10" value="" />
						<ul id="autocomplete10" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_10">Cantidad:</label>
						<input type="number" name="cantidad_10" id="cantidad_10" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_10">Unidad de medida:</label>
							<input type="text" name="unidad_10" id="unidad_10" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_10">Comentarios:</label>
						<textarea name="comentario_10" id="comentario_10" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_11" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 12:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_11" value="" />
						<ul id="autocomplete11" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_11">Cantidad:</label>
						<input type="number" name="cantidad_11" id="cantidad_11" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_11">Unidad de medida:</label>
							<input type="text" name="unidad_11" id="unidad_11" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_11">Comentarios:</label>
						<textarea name="comentario_11" id="comentario_11" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_12" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 13:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_12" value="" />
						<ul id="autocomplete12" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_12">Cantidad:</label>
						<input type="number" name="cantidad_12" id="cantidad_12" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_12">Unidad de medida:</label>
							<input type="text" name="unidad_12" id="unidad_12" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_12">Comentarios:</label>
						<textarea name="comentario_12" id="comentario_12" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_13" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 14:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_13" value="" />
						<ul id="autocomplete13" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_13">Cantidad:</label>
						<input type="number" name="cantidad_13" id="cantidad_13" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_13">Unidad de medida:</label>
							<input type="text" name="unidad_13" id="unidad_13" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_13">Comentarios:</label>
						<textarea name="comentario_13" id="comentario_13" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_14" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 15:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_14" value="" />
						<ul id="autocomplete14" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_14">Cantidad:</label>
						<input type="number" name="cantidad_14" id="cantidad_14" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_14">Unidad de medida:</label>
							<input type="text" name="unidad_14" id="unidad_14" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_14">Comentarios:</label>
						<textarea name="comentario_14" id="comentario_14" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_15" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 16:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_15" value="" />
						<ul id="autocomplete15" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_15">Cantidad:</label>
						<input type="number" name="cantidad_15" id="cantidad_15" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_15">Unidad de medida:</label>
							<input type="text" name="unidad_15" id="unidad_15" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_15">Comentarios:</label>
						<textarea name="comentario_15" id="comentario_15" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_16" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 17:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_16" value="" />
						<ul id="autocomplete16" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_16">Cantidad:</label>
						<input type="number" name="cantidad_16" id="cantidad_16" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_16">Unidad de medida:</label>
							<input type="text" name="unidad_16" id="unidad_16" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_16">Comentarios:</label>
						<textarea name="comentario_16" id="comentario_16" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_17" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 18:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_17" value="" />
						<ul id="autocomplete17" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_17">Cantidad:</label>
						<input type="number" name="cantidad_17" id="cantidad_17" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_17">Unidad de medida:</label>
							<input type="text" name="unidad_17" id="unidad_17" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_17">Comentarios:</label>
						<textarea name="comentario_17" id="comentario_17" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_18" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 19:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_18" value="" />
						<ul id="autocomplete18" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_18">Cantidad:</label>
						<input type="number" name="cantidad_18" id="cantidad_18" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_18">Unidad de medida:</label>
							<input type="text" name="unidad_18" id="unidad_18" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					<li data-role="fieldcontain">
						<label for="comentario_18">Comentarios:</label>
						<textarea name="comentario_18" id="comentario_18" data-mini="true" class="required"></textarea>
					</li>
				</ul>
				<ul class="product" id="formContent_19" data-role='listview' data-inset='true' style="display:none;width:98%; margin:10px auto;">
					<li data-role="list-divider">
								<h1>Solicitud 20:</h1>
					</li>
					<li data-role="fieldcontain">
						<div data-role="fieldcontain">
						<input type="hidden" id="product_19" value="" />
						<ul id="autocomplete19" class="products" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="buscar producto.." data-filter-theme="d"></ul>								
						</div>
					</li>
					<li data-role="fieldcontain">
						<label for="cantidad_19">Cantidad:</label>
						<input type="number" name="cantidad_19" id="cantidad_19" min="1" value="1" />
					</li>
					<li data-role="fieldcontain">
							<label for="unidad_19">Unidad de medida:</label>
							<input type="text" name="unidad_19" id="unidad_19" placeholder="Pieza, Litros, juego, bote, lata.." />
					</li>
					
					<li data-role="fieldcontain">
						<label for="comentario_19">Comentarios:</label>
						<textarea name="comentario_19" id="comentario_19" data-mini="true" class="required"></textarea>
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