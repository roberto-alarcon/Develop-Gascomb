<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<title>Gascomb - App administrador de inventarios</title>
		
		<script type="text/javascript">
			$(document).ready(function() {
				//Agregamos tabla de proporciones de combustible
				$("div[role='application']").prepend('<table class="tablea"><tr class="tra"><td class="tda">Vacío</td><td class="tda">1/4</td><td class="tda">Medio</td><td class="tda">3/4</td><td class="tda">Lleno</td></tr></table>');
			});
		</script>
		<style>
			.tablea{
				top: 0;
				height: 20px;
				width: 119%;
				margin-top: -30px;
				border-collapse: collapse;
				font-size: 12px;
				padding:0px !important;
			}
			.tda{
				text-align:top;
				width:21%;
				border-left: 1px solid #a2a2a2;
				padding:0px 0px 0px 5px !important;
				color: #686868;
			}
			.tra{
				text-align:top;
				width:21%;
				border-left: 1px solid #a2a2a2;
				padding:0px 0px 0px 5px !important;
			}
			.ui-slider-track{
				border-radius: 0px !important;
			}
		</style>
		
	</head>
	<body>
	
		<div data-role="header" data-theme="a">
			<h1> Control de inventarios | Folio - <?php echo $_GET['folio_id']; ?> </h1>
		</div><!-- /header -->
	
		<div style="width:99%; align:center">
		
		<form action="./ajax/insert_inventory.php?action=add&folio_id=<?php echo $_GET['folio_id']; ?>" id="frmLogin" method="post" data-ajax="false">
		
		
			
			<div data-role="collapsible" data-collapsed="false" data-theme="e" data-content-theme="c">
			
			<div data-role="collapsible">
			<h3>Detalles de vehiculo:</h3>
					
					<div data-role="fieldcontain">
							<label for="engine_number">No. Motor:</label>
							<input type="text" name="engine_number" id="engine_number" value="" data-mini="true"/>
					</div>
					<div data-role="fieldcontain">
							<label for="vin">VIN:</label>
							<input type="text" name="vin" id="vin" value="" data-mini="true" class="required"/>
					</div>					
					
					<div data-role="fieldcontain">
							<label for="cilinders">Cilindros:</label>
							<input type="text" name="cilinders" id="cilinders" value="" data-mini="true" class="required"/>
					</div>
					
					<div data-role="fieldcontain">
							<label for="km">Kms:</label>
							<input type="text" name="km" id="km" value="" data-mini="true" class="required"/>
					</div>
				
			</div>
			
			<div data-role="collapsible">
			<h3>Exteriores:</h3>
			
			<fieldset data-role="controlgroup" data-mini="true">
								
				<input type="checkbox" name="tapon_gasolina" id="tapon_gasolina">		
				<input type="checkbox" name="llave_tapon_gasolina" id="llave_tapon_gasolina">		
				<input type="checkbox" name="molduras" id="molduras">		
				<input type="checkbox" name="tapones_ruedas" id="tapones_ruedas">		
				<input type="checkbox" name="faro_derecho" id="faro_derecho">		
				<input type="checkbox" name="faro_izquierdo" id="faro_izquierdo">
				<input type="checkbox" name="luces_stop" id="luces_stop">
				<input type="checkbox" name="direccional_derecha" id="direccional_derecha">
				<input type="checkbox" name="direccional_izquierda" id="direccional_izquierda">
				<input type="checkbox" name="calavera_izquierda" id="calavera_izquierda">
				<input type="checkbox" name="calavera_derecha" id="calavera_derecha">
				<input type="checkbox" name="llantas" id="llantas">
				<input type="checkbox" name="rines" id="rines">
				<input type="checkbox" name="llanta_refaccion" id="llanta_refaccion">
				<input type="checkbox" name="llave_ruedas" id="llave_ruedas">
				<input type="checkbox" name="dado_birlo_seguridad" id="dado_birlo_seguridad">
				<input type="checkbox" name="marcha" id="marcha">
				<label for="tapon_gasolina">Tapon de gasolina</label>		
				<label for="llave_tapon_gasolina">Llave de tapa de gas</label>		
				<label for="molduras">Molduras</label>		
				<label for="tapones_ruedas">Tapones de ruedas</label>		
				<label for="faro_derecho">Faro derecho</label>		
				<label for="faro_izquierdo">Faro izquierdo</label>
				<label for="luces_stop">Luces de stop</label>
				<label for="direccional_derecha">Direccional derecha</label>
				<label for="direccional_izquierda">Direccional izquierda</label>
				<label for="calavera_izquierda">Calavera izquierda</label>
				<label for="calavera_derecha">Calavera derecha</label>
				<label for="llantas">Llantas</label>
				<label for="rines">Rines</label>
				<label for="llanta_refaccion">Llanta de refaccion</label>
				<label for="llave_ruedas">Llave de ruedas</label>
				<label for="dado_birlo_seguridad">Dado de birlos seg</label>
				<label for="marcha">Marcha</label>
				
				<input type="checkbox" name="antena" id="antena">
				<input type="checkbox" name="limpiadores" id="limpiadores">
				<input type="checkbox" name="gomas_limpiadores" id="gomas_limpiadores">
				<input type="checkbox" name="espejo_lateral_derecho" id="espejo_lateral_derecho">
				<input type="checkbox" name="espejo_lateral_izquierdo" id="espejo_lateral_izquierdo">
				<input type="checkbox" name="defensa_delantera" id="defensa_delantera">
				<input type="checkbox" name="defensa_trasera" id="defensa_trasera">
				<input type="checkbox" name="porta_placas" id="porta_placas">
				<input type="checkbox" name="placa_delantera" id="placa_delantera">
				<input type="checkbox" name="placa_trasera" id="placa_trasera">
				<input type="checkbox" name="cristales_delanteros" id="cristales_delanteros">
				<input type="checkbox" name="cristales_traseros" id="cristales_traseros">
				<input type="checkbox" name="cristales_laterales" id="cristales_laterales">
				<input type="checkbox" name="llave_cajuela" id="llave_cajuela">
				<input type="checkbox" name="manijas_exteriores" id="manijas_exteriores">
				<input type="checkbox" name="emblema" id="emblema">
				<input type="checkbox" name="alternador" id="alternador">
				<label for="antena">Antena</label>
				<label for="limpiadores">Limpiadores</label>
				<label for="gomas_limpiadores">Gomas de limpiadores</label>
				<label for="espejo_lateral_derecho">Espejo lateral derecho</label>
				<label for="espejo_lateral_izquierdo">Espejo lateral izquierdo</label>
				<label for="defensa_delantera">Defensa delantera</label>
				<label for="defensa_trasera">Defensa trasera</label>
				<label for="porta_placas">Porta placas</label>
				<label for="placa_delantera">Placa delantera</label>
				<label for="placa_trasera">Placa trasera</label>
				<label for="cristales_delanteros">Cristales delanteros</label>
				<label for="cristales_traseros">Cristales traseros</label>
				<label for="cristales_laterales">Cristales laterales</label>
				<label for="llave_cajuela">Llave cajuela</label>
				<label for="manijas_exteriores">Manijas exteriores</label>
				<label for="emblema">Emblema</label>
				<label for="alternador">Alternador</label>
			</fieldset>	
			</div>
			
			<div data-role="collapsible">
			<h3>Interiores:</h3>
			
			<fieldset data-role="controlgroup" data-mini="true">
				
				<!-- Interiores -->
				<input type="checkbox" name="focos_tablero" id="focos_tablero">
				<input type="checkbox" name="amperimetro" id="amperimetro">
				<input type="checkbox" name="marcador_gasolina" id="marcador_gasolina">
				<input type="checkbox" name="velocimetro" id="velocimetro">
				<input type="checkbox" name="manijas_interiores" id="manijas_interiores">
				<input type="checkbox" name="ceniceros" id="ceniceros">
				<input type="checkbox" name="encendedor" id="encendedor">
				<input type="checkbox" name="radio" id="radio">
				<input type="checkbox" name="caratula" id="caratula">
				<input type="checkbox" name="bocinas" id="bocinas">
				<input type="checkbox" name="caja_discos" id="caja_discos">
				<input type="checkbox" name="aire_acondicionado" id="aire_acondicionado">
				<input type="checkbox" name="defroster" id="defroster">
				<input type="checkbox" name="vestiduras" id="vestiduras">
				<input type="checkbox" name="botones_puertas" id="botones_puertas">					
				<input type="checkbox" name="viceras" id="viceras">
				<input type="checkbox" name="llave_switch" id="llave_switch">
				<input type="checkbox" name="switch" id="switch">
				<label for="focos_tablero">Focos de tablero</label>
				<label for="amperimetro">Amperimetro</label>
				<label for="marcador_gasolina">Marcador de gasolina</label>
				<label for="velocimetro">Velocimetro</label>
				<label for="manijas_interiores">Manijas interiores</label>
				<label for="ceniceros">Ceniceros</label>
				<label for="encendedor">Encendedor</label>
				<label for="radio">Radio</label>
				<label for="caratula">Caratula</label>
				<label for="bocinas">Bocinas</label>
				<label for="caja_discos">Caja de Discos</label>
				<label for="aire_acondicionado">Aire acondicionado</label>
				<label for="defroster">Defroster</label>
				<label for="vestiduras">Vestiduras</label>
				<label for="botones_puertas">Botones puertas</label>					
				<label for="viceras">Viceras</label>
				<label for="llave_switch">Llave de switch</label>
				<label for="switch">Switch</label>
				
				
				<input type="checkbox" name="reloj" id="reloj">
				<input type="checkbox" name="claxon" id="claxon">
				<input type="checkbox" name="espejo_retrovisor" id="espejo_retrovisor">
				<input type="checkbox" name="tapetes" id="tapetes">
				<input type="checkbox" name="hule_piso" id="hule_piso">
				<input type="checkbox" name="tapete_cajuela" id="tapete_cajuela">
				<input type="checkbox" name="alfombra_cajuela" id="alfombra_cajuela">
				<input type="checkbox" name="tapas_puertas" id="tapas_puertas">
				<input type="checkbox" name="tapa_guantera" id="tapa_guantera">
				<input type="checkbox" name="coderas" id="coderas">
				<input type="checkbox" name="cielo" id="cielo">
				<input type="checkbox" name="juego_herramientas" id="juego_herramientas">
				<input type="checkbox" name="gato" id="gato">
				<input type="checkbox" name="reflejantes" id="reflejantes">
				<input type="checkbox" name="extintor" id="extintor">
				<input type="checkbox" name="baston_seguridad" id="baston_seguridad">
				<input type="checkbox" name="tolvas" id="tolvas">
				<label for="reloj">Reloj</label>
				<label for="claxon">Claxon</label>
				<label for="espejo_retrovisor">Espejo retrovisor</label>
				<label for="tapetes">Tapetes</label>
				<label for="hule_piso">Hule de piso</label>
				<label for="tapete_cajuela">Tapete de cajuela</label>
				<label for="alfombra_cajuela">Alfombra de cajuela</label>
				<label for="tapas_puertas">Tapas de puertas</label>
				<label for="tapa_guantera">Tapa de guantera</label>
				<label for="coderas">Coderas</label>
				<label for="cielo">Cielo</label>
				<label for="juego_herramientas">Jgo. de herramientas</label>
				<label for="gato">Gato</label>
				<label for="reflejantes">Reflejantes</label>
				<label for="extintor">Extintor</label>
				<label for="baston_seguridad">Baston de seguridad</label>
				<label for="tolvas">Tolvas</label>
				
				<input type="checkbox" name="tapon_radiador" id="tapon_radiador">
				<input type="checkbox" name="tapones_aceite" id="tapones_aceite">
				<input type="checkbox" name="nivel_aceite" id="nivel_aceite">
				<input type="checkbox" name="tapon_licuadora" id="tapon_licuadora">
				<input type="checkbox" name="tapon_recuperador" id="tapon_recuperador">
				<input type="checkbox" name="filtro_aceite" id="filtro_aceite">
				<input type="checkbox" name="filtro_gasolina" id="filtro_gasolina">
				<input type="checkbox" name="filtro_aire" id="filtro_aire">
				<input type="checkbox" name="bayoneta_motor" id="bayoneta_motor">
				<input type="checkbox" name="bayoneta_transmisor" id="bayoneta_transmisor">
				<input type="checkbox" name="bateria" id="bateria">
				<input type="checkbox" name="luz_motor" id="luz_motor">
				<input type="checkbox" name="golpes" id="golpes">
				<input type="checkbox" name="costado_derecho" id="costado_derecho">
				<input type="checkbox" name="costado_izquierdo" id="costado_izquierdo">
				<input type="checkbox" name="parte_delantera" id="parte_delantera">
				<input type="checkbox" name="parte_trasera" id="parte_trasera">
				<input type="checkbox" name="antena_oficial" id="antena_oficial">
				<input type="checkbox" name="equipo_radiocomunicacion" id="equipo_radiocomunicacion">
				<input type="checkbox" name="portafiltro" id="portafiltro">
				<label for="tapon_radiador">Tapon de radiador</label>
				<label for="tapones_aceite">Tapon de aceite</label>				
				<label for="nivel_aceite">Nivel de aceite</label>
				<label for="tapon_licuadora">Tapon de licuadora</label>
				<label for="tapon_recuperador">Tapon de recuperador</label>
				<label for="filtro_aceite">Filtro de aceite</label>
				<label for="filtro_gasolina">Filtro de gasolina</label>
				<label for="filtro_aire">Filtro de aire</label>
				<label for="bayoneta_motor">Bayoneta de motor</label>
				<label for="bayoneta_transmisor">Bayoneta de transmision</label>
				<label for="bateria">Bateria</label>
				<label for="luz_motor">Luz de Motor</label>
				<label for="golpes">Golpes</label>
				<label for="costado_derecho">Costado derecho</label>
				<label for="costado_izquierdo">Costado izquierdo</label>
				<label for="parte_delantera">Parte delantera</label>
				<label for="parte_trasera">Parte trasera</label>
				<label for="antena_oficial">Antena oficial</label>
				<label for="equipo_radiocomunicacion">Equipo radio comu.</label>
				<label for="portafiltro">Porta filtro</label>
				
			</fieldset>
			</div>
			
			<div data-role="collapsible">
			<h3>Detalles:</h3>
				
				<div data-role="fieldcontain">
				<br><br>
				<label for="slider">Nivel de combustible(%):</label>
				<input type="range" name="slider" id="slider" value="50" min="0" max="100" />
				</div>
				<div data-role="fieldcontain">
					<label for="observations">Detalles/Observaciones:</label>
					<textarea name="observations" id="observations" data-mini="true"></textarea>
				</div>
				
			</div>
			
			
			<fieldset class="ui-grid-a">			
			<div class="ui-block-a"><button type="reset" data-theme="b">Cancelar</button></div>	   
			<div class="ui-block-b"><button type="submit" data-theme="e" name="submit" value="submit-value" >Enviar</button></div>
			</fieldset>
			
			</div>
		</form>
		</div>
	
	</body>
</html>