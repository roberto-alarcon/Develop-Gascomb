<?php header( 'Content-type: text/html; charset=iso-8859-1' );
	date_default_timezone_set('America/Mexico_City');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	//header('Content-Type: text/html; charset=utf-8'); 
	$id = isset( $_GET['folio'] ) ? $_GET['folio'] : 0 ;
	
	if(!isset($_SESSION['active_user_id'])){
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
	}

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
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/datebox/jqm-datebox.core.min.js"></script>
		<script type="text/javascript" src="js/datebox/jqm-datebox.mode.calbox.min.js"></script>
		<script type="text/javascript" src="js/datebox/jqm-datebox.mode.datebox.min.js"></script>
		
		<script>
			jQuery.extend(jQuery.validator.messages, {
				required: "Campo requerido.",
				remote: "Please fix this field.",
				email: "Please enter a valid email address.",
				url: "Please enter a valid URL.",
				date: "Please enter a valid date.",
				dateISO: "Please enter a valid date (ISO).",
				number: "Please enter a valid number.",
				digits: "Please enter only digits.",
				creditcard: "Please enter a valid credit card number.",
				equalTo: "Please enter the same value again.",
				accept: "Please enter a value with a valid extension.",
				maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
				minlength: jQuery.validator.format("Please enter at least {0} characters."),
				rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
				range: jQuery.validator.format("Please enter a value between {0} and {1}."),
				max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
				min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
			});
			jQuery.validator.setDefaults({
				  debug: true,
				  success: "valid"
				});
		</script>
		
		
		<title>Gascomb - App administrador de folios</title>
		
		<style>
			label.error {
				float: none; 
				color: red; 
				font-size: 16px;
				font-weight: normal;
				line-height: 1.4;
				margin-top: 0.5em;
				width: 100%;
				display: block;
				margin-left: 22%;
			}

		</style>
		
		
		<script>
		
			$(window).load(function(){
				//var form = $( "#frmLogin" );
				//form.validate();
				var now = new Date();				
				var minutes= (now.getMinutes() < 10)? '0'+now.getMinutes() : now.getMinutes();
				$('#entry_date').val("<?php echo date("d/m/Y"); ?>");
				$('#entry_time').val(now.getHours()+':'+minutes);
				
				$( '#enviar' ).on( "click", function(event, ui) {
					//
					var isValidate = true;
					//$('.required')
					$($(".required").get().reverse()).each(function () {						
						if($(this).val() ==''){							
							isValidate = false
							//Cerrar todos los collapse
							$('.required').each(function () {	
								$(this).trigger( "collapse" );	
							});							
							//Abrir el que le falta datos:
							$(this).closest(".Collap").trigger( "expand" );	
							$(this).focus();
						}
					});
					if(isValidate == false){
							alert("Es necesario llenar los campos especificados");
					}else{
						var productos = [];
						var count = 0;
						$('.ui-listview-filter input:visible').each(function () {
							if($("#activities"+count).val() !== "" || $(this).val() !=='' ){
									var producto = {};
									 producto.support_activities_id = ($("#activities"+count).val())? $("#activities"+count).val() : $(this).val();							 
									productos.push(producto);								
							}
							count++;
						});
						
						var productoss = JSON.stringify(productos);					
						//throw "stop execution";
						var input = $("<input>").attr("type", "hidden").attr("name", "activities").val(productoss);
						$("#frmLogin").append($(input));
						
						$("#frmLogin").submit();
					}
					
					//if(form.valid()){		
					/*
						var productos = [];
						var count = 0;
						$('.ui-listview-filter input:visible').each(function () {
							if($("#activities"+count).val() !== "" || $(this).val() !=='' ){
									var producto = {};
									 producto.support_activities_id = ($("#activities"+count).val())? $("#activities"+count).val() : $(this).val();							 
									productos.push(producto);								
							}
							count++;
						});
						
						var productoss = JSON.stringify(productos);					
						//throw "stop execution";
						var input = $("<input>").attr("type", "hidden").attr("name", "activities").val(productoss);
						$("#frmLogin").append($(input));
						
						$("#frmLogin").submit();
					*/	
					//}else{
						//alert("Complete los campos requeridos.");
					//}
					
				});				
				autocompl('autocomplete0')
				autocompl('autocomplete1')
				autocompl('autocomplete2')
				autocompl('autocomplete3')
				autocompl('autocomplete4')
				autocompl('autocomplete5')
				autocompl('autocomplete6') 
				autocompl('autocomplete7')
				autocompl('autocomplete8')
				autocompl('autocomplete9')
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
								url: "ajax/search_activities.php",
								dataType: "json",
								data: {
									q: $input.val()
								}
							})
							.done( function ( response ) {								
								$.each( response, function ( i, val ) {																	
									html += "<li id="+val.support_activities_id+">" + val.activity_name + "</li>";
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

							//Aplicamos el producto seleccionado al input hidden
							$("#activities"+count_input).val($(this).attr('id'));							
						}); 
						
					});
					
				}
				
			});
			
			
			
			
			$(document).bind('mobileinit',function(){
				$.mobile.selectmenu.prototype.options.nativeMenu = false;
			});
			
			$(document).bind("pageinit", function() {
							
				
				$( "#flip-1" ).bind( "change", function(event, ui) {
					  // Verificamos que tipo de elemento tenemos instanciado
					  value = $( "#flip-1" ).val();
					  if(value == '1'){
						$('#search_placa').textinput('enable');
						$('#search_btn').button('enable');	
					  
					  }
					  
					  if(value == '0'){
						$('#search_placa').textinput('disable');
						$('#search_btn').button('disable');	
					  
					  }
					  
				});
				
				// Ajax lectura placa
				$( '#search_btn' ).bind( "click", function(event, ui) {
					
					event.stopImmediatePropagation();
					event.preventDefault();
				  // Verificamos que exista un valor
				  var placa_value =  $( '#search_placa' ).val();
				  if( placa_value != ''){
					placa_value = placa_value.toUpperCase();
					 
					$.mobile.changePage($('#page2'), 'pop', false, true); 
					
					$.ajax({
						  url: './ajax/search_by_registracion_plate.php?id='+placa_value.toString(),
						  //url: './ajax/test.php',
						  dataType: 'xml',
						  success: function(data) {							
							$.mobile.changePage($('#page1'), 'pop', false, true); 							
							var elements = $.xml2json(data);
							//console.log(elements.registration_plate);
							var placa = elements.registration_plate;
							
							$( '#owner_name' ).val(elements.owner_name);
							$( '#owner_adress' ).val(elements.owner_adress);
							$( '#owner_phone' ).val(elements.owner_phone);
							$( '#owner_cell' ).val(elements.owner_cell);
							$( '#owner_email' ).val(elements.owner_email);
							$( '#owner_email2' ).val(elements.owner_email2);
							$( '#registration_plate' ).val(elements.registration_plate);
							$( '#economic_number' ).val(elements.economic_number);
							$( '#engine_number' ).val(elements.engine_number);
							$( '#vin' ).val(elements.vin);
							$( '#year' ).val(elements.year);
							$( '#cilinders' ).val(elements.cilinders);
							$( '#km' ).val(elements.km);
							
							var combustible = elements.fuel;
							if(combustible == 'gasolina'){
								$('#fuel').attr("checked",true).checkboxradio("refresh");
								$('#fuel2').attr("checked",false).checkboxradio("refresh");
							}else{
								$('#fuel').attr("checked",false).checkboxradio("refresh");
								$('#fuel2').attr("checked",true).checkboxradio("refresh");
							}
							
							
							var el = $('#support_brand_vehicular_id');
							// Select the relevant option, de-select any others
							el.val(elements.support_brand_vehicular_id).attr('selected', true).siblings('option').removeAttr('selected');
							// Initialize the selectmenu
							el.selectmenu();
							// jQM refresh
							el.selectmenu("refresh", true);
							
							var select_value = elements.support_brand_vehicular_id;
							
							$.ajax({
							  url: './ajax/select_models.php?xml=true&id='+select_value,
							  dataType: 'xml',
							  success: function(data) {
								if(data){
									//console.log(data);
									$('#support_models_vehicular_id').empty();
									var options = $.xml2json(data);
									$.each(options.item, function(index, value) {
									   $('#support_models_vehicular_id').append($("<option />").val(value.value).text(value.label));
									  
									});
									
									
								}
								
								$('#support_models_vehicular_id').selectmenu('refresh', true);
								
							  }
							});
							
							
							
						  }
						});
						
					
				  
				  }
				  
				  
				});
				
				
				// Llenamos los selects
				
				// Select recibido por
				$.ajax({
				  url: './ajax/select_employees_receptor.php',				 
				  dataType: 'xml',
				  success: function(data) {
					if(data){
						var options = $.xml2json(data);
						
						$.each(options.item, function(index, value) {
						  
						   $('#received_by').append($("<option />").val(value.value).text(value.label));
						  
						});
						
						
					}
					
					$('#received_by').selectmenu('refresh', true);
					
				  }
				});
				
				// Select mecanicos
				$.ajax({
				  url: './ajax/select_employees.php?profile=jefe mecanicos',
				  dataType: 'xml',
				  success: function(data) {
					if(data){
						var options = $.xml2json(data);
						$.each(options.item, function(index, value) {
						  
						   $('#mechanic_assigned').append($("<option />").val(value.value).text(value.label));
						  
						});
						
						
					}
					
					$('#mechanic_assigned').selectmenu('refresh', true);
					
				  }
				});
				
				// Select dependencias
				$.ajax({
				  url: './ajax/select_dependency.php',
				  dataType: 'xml',
				  success: function(data) {
					if(data){
						var options = $.xml2json(data);
						
						$.each(options.item, function(index, value) {
						 
						   $('#dependency_id').append($("<option />").val(value.value).text(value.label));
						  
						});
						
						
					}
					
					$('#dependency_id').selectmenu('refresh', true);
					
				  }
				});
				
				// Listener change dependencia
				$('#dependency_id').change(function() {
					var select_value = $('#dependency_id').val();
					
					$.ajax({
						  url: './ajax/select_contracts.php?xml=true&id='+select_value.toString(),
						  dataType: 'xml',
						  success: function(data) {
							if(data){
								
								$('#contract_id').empty();
								
								var options = $.xml2json(data);
								//console.log(options)
								if ($.isArray(options.item)){
									$.each(options.item, function(index, value) {										
									   $('#contract_id').append($("<option />").val(value.value).text(value.label));									  
									});
								}else{
									$('#contract_id').append($("<option />").val(options.item.value).text(options.item.label));									
								}
								
								
								
							}
							$('#contract_id').append($("<option />").val('532').text('--'));
							$('#contract_id').selectmenu('refresh', true);
							
						  }
						});
					
					
					
				});
				
				
				
				
				// Select vehiculos
				$.ajax({
				  url: './ajax/select_brands.php',
				  dataType: 'xml',
				  success: function(data) {
					if(data){
						var options = $.xml2json(data);
						//console.log(options);
						//$('#support_brand_vehicular_id').append($("<option />").val('').text('Sin especificar'));
						$.each(options.item, function(index, value) {
							// Sin especificar: 45 se muestra al inicio
							if(value.value !=="45"){
									$('#support_brand_vehicular_id').append($("<option />").val(value.value).text(value.label));
							}						   
						  
						});
						
						
						
					}
					
					$('#support_brand_vehicular_id').selectmenu('refresh', true);
					
				  }
				});
				
				//Agregamos listener para cambiar tipo
				$('#support_brand_vehicular_id').change(function() {
					var select_value = $('#support_brand_vehicular_id').val();
					
					$.ajax({
						  url: './ajax/select_models.php?xml=true&id='+select_value.toString(),
						  dataType: 'xml',
						  success: function(data) {
							if(data){
								
								$('#support_models_vehicular_id').empty();
								var options = $.xml2json(data);
								$.each(options.item, function(index, value) {
									if(value.value !== ""){
											$('#support_models_vehicular_id').append($("<option />").val(value.value).text(value.label));
									}
								   
								  
								});
								
								
							}
							$('#support_models_vehicular_id').append($("<option />").val('').text('Sin especificar'));
							$('#support_models_vehicular_id').selectmenu('refresh', true);
							
						  }
						});
				  
				});
				
				
			});
			
		
		</script>
		
		
	</head>
	<body>
		
		<div data-role="page"  id="page1"> 
		
		<div data-role="header" >
			<h1> Ingreso de vehiculos </h1>
		</div><!-- /header -->
		<div style="width:100%; align:center">
			
		<form action="./ajax/insert_folio.php?action=add" id="frmLogin" class="validate" method="post" data-ajax="false">
			
			<div data-role="header" data-theme="a" class="ui-bar ui-grid-c">
				<div class="ui-block-a">
				<select name="flip-1" id="flip-1" data-role="slider">
					<option value="0">Off</option>
					<option value="1">On</option>
				</select> 
				
				</div>
				<div class="ui-block-b"><label for="search_placa" style="margin:10px 20px 0px 0px; text-align:right;">Placa</label></div>
				<div class="ui-block-c"><input id="search_placa" value="" data-mini="true" disabled></div>	 
				<div class="ui-block-d">
					<div style="margin:6px 0 0 10px;"><button id="search_btn" type="button" data-theme="a" disabled>Buscar</button></div>
				</div>
			</div>
			
			<!-- Acordion View -->
			<div data-role="collapsible" data-collapsed="false" data-theme="e" data-content-theme="c">
				
				<div data-role="collapsible" class="Collap" data-collapsed="false">
					<h3>Datos del cliente</h3>
					
					<!-- Here insert the form to create the a new folio -->
					
					
						<div data-role="fieldcontain">
						   <label for="dependency_id" class="select">Cliente: </label>
						   <select name="dependency_id" id="dependency_id" data-mini="true">
						   </select>
						  
						</div>
						
						<div data-role="fieldcontain">
						   <label for="contract_id" class="select">Contrato:</label>
						   <select name="contract_id" id="contract_id" data-mini="true">
								<option value="">Sin especificar</option>
						   </select>
						  
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_name">Nombre:</label>
							<input type="text" name="owner_name" id="owner_name" value="" data-mini="true" class="required"/>
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_adress">Direccion:</label>
							<textarea name="owner_adress" id="owner_adress" data-mini="true" class="required"></textarea>
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_phone">Teléfono:</label>
							<input type="text" name="owner_phone" id="owner_phone" value="" data-mini="true" class="required"/>
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_cell">Celular:</label>
							<input type="text" name="owner_cell" id="owner_cell" value="" data-mini="true"/>
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_email">Correo electónico 1:</label>
							<input type="text" name="owner_email" id="owner_email" value="" data-mini="true"/>
						</div>
						
						<div data-role="fieldcontain">
							<label for="owner_email2">Correo electónico 2:</label>
							<input type="text" name="owner_email2" id="owner_email2" value="" data-mini="true"/>
						</div>
						
						<div data-role="fieldcontain">
							<label for="area_sector">Area o Sector:</label>
							<input type="text" name="area_sector" id="area_sector" value="" data-mini="true"/>
						</div>
					
						<div data-role="fieldcontain">
							<label for="zone">Zona:</label>
							<input type="text" name="zone" id="zone" value="" data-mini="true"/>
						</div>
					



				</div>
				<div data-role="collapsible" class="Collap" >
					<h3>Datos del vehiculo:</h3>
					
					<div data-role="fieldcontain">
							<label for="registration_plate">No. Placa:</label>
							<input type="text" name="registration_plate" id="registration_plate" value="" data-mini="true" class="required"/>
					</div>
					
					<div data-role="fieldcontain">
							<label for="economic_number">No. Económico:</label>
							<input type="text" name="economic_number" id="economic_number" value="" data-mini="true"/>
					</div>
					
					
					<div data-role="fieldcontain">
					   <label for="support_brand_vehicular_id" class="select">Marca:</label>
					   <select name="support_brand_vehicular_id" id="support_brand_vehicular_id" data-mini="true">
						<option value="45">Sin especificar</option>
					   </select>
					  
					</div>
					
					<div data-role="fieldcontain">
					   <label for="support_models_vehicular_id" class="select">Tipo:</label>
					   <select name="support_models_vehicular_id" id="support_models_vehicular_id" data-mini="true">						
							<option value="">Sin especificar</option>
					   </select>
					  
					</div>
					
					<div data-role="fieldcontain">
							<label for="year">Año:</label>
							<input type="text" name="year" id="year" value="" data-mini="true" class="required"/>
							
					</div>
					
					
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup">
							<legend>Combustible:</legend>
								<input type="radio" name="fuel" id="fuel" value="gasolina" checked="checked" />
								<label for="fuel">Gasolina</label>
								<input type="radio" name="fuel" id="fuel2" value="diesel"  />
								<label for="fuel2">Diesel</label>

								
								

						</fieldset>
					</div>
					
					
					<div data-role="fieldcontain">
							<label for="vehicle_operator">Operador del vehiculo:</label>
							<input type="text" name="vehicle_operator" id="vehicle_operator" value="" data-mini="true"/>
					</div>
					
					<div data-role="fieldcontain">
							<label for="operator_tel">Tel de operador:</label>
							<input type="text" name="operator_tel" id="operator_tel" value="" data-mini="true"/>
					</div>
					
				</div>
				
				<div data-role="collapsible" class="Collap" >
					<h3>Perfil corporativo:</h3>
					
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup">
							<legend>Tipo de Servicio:</legend>
								<input type="radio" name="type_service" id="radio-choice-11" value="3" checked="checked" />
								<label for="radio-choice-11">Matenimiento Correctivo</label>

								<input type="radio" name="type_service" id="radio-choice-12" value="2"  />
								<label for="radio-choice-12">Matenimiento Preventivo</label>
								
								<input type="radio" name="type_service" id="radio-choice-13" value="1"  />
								<label for="radio-choice-13">Matenimiento correctivo y preventivo</label>
								
								<input type="radio" name="type_service" id="radio-choice-14" value="4"  />
								<label for="radio-choice-14">Garantía</label>

						</fieldset>
					</div>
					
					
					<div data-role="fieldcontain">
					   <label for="mechanic_assigned" class="select">Jefe de mecánicos:</label>
					   <select name="mechanic_assigned" id="mechanic_assigned" data-mini="true">						  
					   </select>
					  
					</div>
					
					<div data-role="fieldcontain">
					   <label for="received_by" class="select">Recibido por:</label>
					   <select name="received_by" id="received_by" data-mini="true">
					   </select>
					  
					</div>
					
					<div data-role="fieldcontain">
						 <label for="entry_date">Fecha de ingreso:</label>
						 <!-- <input type="date" name="entry_date" id="entry_date" value="" class="required"/>-->
						 <input name="entry_date" id="entry_date" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"calbox", "overrideDateFormat":"%d/%m/%Y","defaultDate":"<?php echo date("Y,m,d"); ?>"}' />
					</div>
					
					<div data-role="fieldcontain">
						 <label for="entry_time">Hora de ingreso:</label>
						 <!-- <input type="time" name="entry_time" id="entry_time" value="" class="required"/> -->
						 <input name="entry_time" id="entry_time" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"timebox"}' />					
					</div>
					 <!--
					<div data-role="fieldcontain">
						 <label for="departure_date">Fecha máxima de entrega:</label>
						 <input name="departure_date" id="departure_date" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"calbox", "overrideDateFormat":"%d/%m/%Y"}' />
						 
					</div>
					
					<div data-role="fieldcontain">
						 <label for="departure_time">Hora de entrega:</label>
						 
						 <input name="departure_time" id="departure_time" type="text" data-role="datebox" data-theme="d" data-options='{"mode":"timebox"}' />					
					</div>
					-->
					<div data-role="fieldcontain">
							<label for="tower">Torre:</label>
							<input type="text" name="tower" id="tower" value="" data-mini="true"/>
					</div>
					
					<div data-role="fieldcontain">
							<label for="parking_space">Cajón:</label>
							<input type="text" name="parking_space" id="parking_space" value="" data-mini="true"/>
					</div>
					
					<div data-role="fieldcontain">
							<label for="order_number">Orden de trabajo(Cliente):</label>
							<input type="text" name="order_number" id="order_number" value="" data-mini="true"/>
					</div>
					
					
				</div>
				
				<div data-role="collapsible" class="Collap">
					<h3>Detalles de la falla:</h3>
					<div data-role="fieldcontain">
						<label for="failures">Fallas que ocurren:</label>
						<textarea name="failures" id="failures" data-mini="true" class="required"></textarea>
					</div>
										
					<label for="name">Servicios a realizar:</br>
						<span style="font-size:10px">Si el servicio no se encuentra en la lista desplegable, por favor escriba el servicio sin seleccionar ningun elemento</span>
					</label>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities0" name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete0" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities1"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete1" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities2"   name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete2" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities3" name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete3" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities4"  name="activ"  value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete4" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities5"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete5" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					
					<!-- Agregamos 4 campos de actividades -->
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities6"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete6" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities7"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete7" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities8"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete8" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<input type="hidden" id="activities9"  name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
						<ul id="autocomplete9" class="activities[]" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>
					
					
						
					</div>
					
					
					<!-- Submit button-->
					<fieldset class="ui-grid-a">					
					<div class="ui-block-a"><button type="reset" data-theme="b">Cancelar</button></div>	   
					<div class="ui-block-b"><button type="button" name="enviar" data-theme="e" id="enviar" value="submit-value" >Enviar</button></div>
					</fieldset>
				
					
					
				</div>
				
				
				
			
		
		</form>
		
		
		
		</div>
		
	</div>

	<div data-role="page" data-theme="a" id="page2"> 
		<div data-role="content"> 
			<button type="submit" data-theme="e" name="submit" value="submit-value" id="submit-button-2">Cargando datos</button>
		</div>
	</div>

	
	
	</body>
</html>