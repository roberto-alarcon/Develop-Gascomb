<?php header( 'Content-type: text/html; charset=iso-8859-1' );

include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';		
	//header('Content-Type: text/html; charset=utf-8'); 
	//$id = $_GET['folio'];
	
	if(!isset($_SESSION['active_user_id'])){
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
	}
	$support_activities = new FloorActivity;
	$activities = $support_activities->getSupportActivities();
	foreach($activities as $x => $y){
		$activities[$x]["value"] = $y["support_activities_id"];
		$activities[$x]["label"] = utf8_encode($y["activity_name"]);
	}
	//echo json_encode($activities);
	//exit(0);
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
		<script type="text/javascript" src="js/jqm.autoComplete-1.5.2-min.js"></script>
		
		
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
		
			$(document).ready(function(){
				//var autocompleteData = $.parseJSON('[{"value":"AL","label":"Alabama"},{"value":"AK","label":"Alaska"},{"value":"AS","label":"American Samoa"},{"value":"AZ","label":"Arizona"},{"value":"AR","label":"Arkansas"},{"value":"CA","label":"California"},{"value":"CO","label":"Colorado"},{"value":"CT","label":"Connecticut"},{"value":"DE","label":"Delaware"},{"value":"DC","label":"District of Columbia"},{"value":"FL","label":"Florida"},{"value":"GA","label":"Georgia"},{"value":"GU","label":"Guam"},{"value":"HI","label":"Hawaii"},{"value":"ID","label":"Idaho"},{"value":"IL","label":"Illinois"},{"value":"IN","label":"Indiana"},{"value":"IA","label":"Iowa"},{"value":"KS","label":"Kansas"},{"value":"KY","label":"Kentucky"},{"value":"LA","label":"Louisiana"},{"value":"ME","label":"Maine"},{"value":"MD","label":"Maryland"},{"value":"MA","label":"Massachusetts"},{"value":"MI","label":"Michigan"},{"value":"MN","label":"Minnesota"},{"value":"MS","label":"Mississippi"},{"value":"MO","label":"Missouri"},{"value":"MT","label":"Montana"},{"value":"NE","label":"Nebraska"},{"value":"NV","label":"Nevada"},{"value":"NH","label":"New Hampshire"},{"value":"NJ","label":"New Jersey"},{"value":"NM","label":"New Mexico"},{"value":"NY","label":"New York"},{"value":"NC","label":"North Carolina"},{"value":"ND","label":"North Dakota"},{"value":"NI","label":"Northern Marianas Islands"},{"value":"OH","label":"Ohio"},{"value":"OK","label":"Oklahoma"},{"value":"OR","label":"Oregon"},{"value":"PA","label":"Pennsylvania"},{"value":"PR","label":"Puerto Rico"},{"value":"RI","label":"Rhode Island"},{"value":"SC","label":"South Carolina"},{"value":"SD","label":"South Dakota"},{"value":"TN","label":"Tennessee"},{"value":"TX","label":"Texas"},{"value":"UT","label":"Utah"},{"value":"VT","label":"Vermont"},{"value":"VI","label":"Virgin Islands"},{"value":"VA","label":"Virginia"},{"value":"WA","label":"Washington"},{"value":"WV","label":"West Virginia"},{"value":"WI","label":"Wisconsin"},{"value":"WY","label":"Wyoming"}]');
				
				var autocompleteData = $.parseJSON('<?php echo json_encode($activities); ?>');
				
				$("#activitie1").autocomplete({
					target: $('#suggestions1'),
					source: autocompleteData,
					matchFromStart: false,
					callback: function(e) {
						var $a = $(e.currentTarget);
						$('#activitie1').val( $a.text() );// Value $a.data('autocomplete').value
						$("#activities1").val($a.data('autocomplete').value);
						$("#activitie1").autocomplete('clear');
						
					},
					link: 'target.html?term=',
					minLength: 1
				});
				$("#activitie0").autocomplete({
					target: $('#suggestions0'),
					source: autocompleteData,
					matchFromStart: false,
					callback: function(e) {
						var $a = $(e.currentTarget);
						$('#activitie0').val( $a.text() );// Value $a.data('autocomplete').value
						$("#activities0").val($a.data('autocomplete').value);
						$("#activitie0").autocomplete('clear');
						
					},
					link: 'target.html?term=',
					minLength: 1
				});
			
			
				
				$( '#enviar' ).on( "click", function(event, ui) {
					//
					//if(form.valid()){					
						var productos = [];
						var count = 0;
						$('.act:visible').each(function () {
							
							console.log($("#activities"+count).val());
							console.log($(this).val());
							if($("#activities"+count).val() !== "" || $(this).val() !=='' ){
									var producto = {};
									 producto.support_activities_id = ($("#activities"+count).val() !== "")? $("#activities"+count).val() : $(this).val();							 
									productos.push(producto);								
							}
							count++;
						});
						
						var productoss = JSON.stringify(productos);
						console.log(productoss);
						//throw "stop execution";
						var input = $("<input>").attr("type", "hidden").attr("name", "activities").val(productoss);
						$("#frmLogin").append($(input));
						 console.log( $("#frmLogin").serialize() );
						//$("#frmLogin").submit();
					//}else{
						//alert("Complete los campos requeridos.");
					//}
					
				});				
				autocompl('autocomplete0')
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
				<input type="hidden" id="activities0" name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
				<input type="search" id="activitie0" class="act" placeholder="Categories">
				<ul id="suggestions0" data-role="listview" data-inset="true" data-filter-reveal="true" data-filter-placeholder="Search cars..."></ul>
				
				<input type="hidden" id="activities1" name="activ" value="" data-mini="true" placeholder="Actividad 1"/>
				<input type="search" id="activitie1" class="act" placeholder="Categories">
				<ul id="suggestions1" data-role="listview" data-inset="true" data-filter-reveal="true" data-filter-placeholder="Search cars..."></ul>
				
				
					
					<label for="name">Servicios a realizar:</br>
						<span style="font-size:10px">Si el servicio no se encuentra en la lista desplegable, por favor escriba el servicio sin seleccionar ningun elemento</span>
					</label>
					<div data-role="fieldcontain" class="ui-hide-label">
						
						<input type="hidden" id="activities2" name="activ" class="act" value="" data-mini="true" placeholder="Actividad 1"/>
						<input type="search" id="activitie2" class="act" placeholder="Categories">
						<ul id="autocomplete2" class="activities[]" data-role="listview" data-filter-placeholder="escribir actividad..." data-filter-theme="d"></ul>
					</div>

						
					</div>
					
					
					<!-- Submit button-->
					<fieldset class="ui-grid-a">					
					<div class="ui-block-a"><button type="reset" data-theme="b">Cancelar</button></div>	   
					<div class="ui-block-b"><button type="button" name="enviar" data-theme="e" id="enviar" value="submit-value" >Enviar</button></div>
					</fieldset>
		
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