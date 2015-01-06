/****************************
	Form Inventarios
****************************/
var stocktaking = [
	{type:"settings", position:"label-right"},
	{type:"fieldset",  label:"Exteriores", position:"absolute", offsetLeft :20, list:[
		{type: "checkbox", name:"tapon_gasolina",label: "Tapon de gasolina"},		
		{type: "checkbox", name:"llave_tapon_gasolina", label: "Llave de tapa de gas"},		
		{type: "checkbox", name:"molduras", label: "Molduras"},		
		{type: "checkbox", name:"tapones_ruedas", label: "Tapones de ruedas"},		
		{type: "checkbox", name:"faro_derecho", label: "Faro derecho"},		
		{type: "checkbox", name:"faro_izquierdo", label: "Faro izquierdo"},
		{type: "checkbox", name:"luces_stop", label: "Faro Luces stop"},
		{type: "checkbox", name:"direccional_derecha", label: "Direccional derecha"},
		{type: "checkbox", name:"direccional_izquierda", label: "Faro derecho"},
		{type: "checkbox", name:"calavera_izquierda", label: "Calavera derecha"},
		{type: "checkbox", name:"calavera_derecha", label: "Calavera derecha"},
		{type: "checkbox", name:"llantas", label: "Llantas"},
		{type: "checkbox", name:"rines", label: "Rines"},
		{type: "checkbox", name:"llanta_refaccion", label: "Llanta de refaccion"},
		{type: "checkbox", name:"llave_ruedas", label: "Llave de ruedas"},
		{type: "checkbox", name:"dado_birlo_seguridad", label: "Dado de birlos seg"},
		{type: "checkbox", name:"marcha", label: "Marcha"},
		{type:"newcolumn"},
	{type: "block", inputWidth: 240, list:[
			{type: "checkbox", name:"antena", label: "Antena"},
			{type: "checkbox", name:"limpiadores", label: "Limpiadores"},
			{type: "checkbox", name:"gomas_limpiadores", label: "Gomas de limpiadores"},
			{type: "checkbox", name:"espejo_lateral_derecho", label: "Espejo lateral derecho"},
			{type: "checkbox", name:"espejo_lateral_izquierdo", label: "Espejo lateral izquierdo"},
			{type: "checkbox", name:"defensa_delantera", label: "Defensa delantera"},
			{type: "checkbox", name:"defensa_trasera", label: "Defensa trasera"},
			{type: "checkbox", name:"porta_placas", label: "Porta placas"},
			{type: "checkbox", name:"placa_delantera", label: "Placa derecha"},
			{type: "checkbox", name:"placa_trasera", label: "Placa trasera"},
			{type: "checkbox", name:"cristales_delanteros", label: "Cristales delanteros"},
			{type: "checkbox", name:"cristales_traseros", label: "Cristales traseros"},
			{type: "checkbox", name:"cristales_laterales", label: "Cristales laterales"},
			{type: "checkbox", name:"llave_cajuela", label: "Llave cajuela"},
			{type: "checkbox", name:"manijas_exteriores", label: "Manijas exteriores"},
			{type: "checkbox", name:"emblema", label: "Emblema"},
			{type: "checkbox", name:"alternador", label: "Alternador"},
		]},
	]},



		{
		type: "fieldset",
		label: "Multimedia",
		position:"absolute", offsetLeft :20,offsetTop :20,
		list: [{
			type: "upload",
			name: "files",
			inputWidth: 330,
			url: "ajax/upload_images.php",
			_swfLogs: "enabled",
			swfPath: "./dhtmlxLibrary/dhtmlxForm/codebase/ext/uploader.swf",
			swfUrl: "./dhtmlxLibrary/dhtmlxForm/samples/07_uploader/php/dhtmlxform_item_upload.php"
			}]
		},


	{type:"newcolumn"}, 
	{type:"fieldset", label:"Interiores", position:"absolute", offsetLeft :20, list:[
	
		{type: "block", inputWidth: 200, list:[
			{type: "checkbox", name:"focos_tablero", label: "Focos de tablero"},
			{type: "checkbox", name:"amperimetro", label: "Amperimetro"},
			{type: "checkbox", name:"marcador_gasolina", label: "Marcador de gasolina"},
			{type: "checkbox", name:"velocimetro", label: "Velocimetro"},
			{type: "checkbox", name:"manijas_interiores", label: "Manijas interiores"},
			{type: "checkbox", name:"ceniceros", label: "Ceniceros"},
			{type: "checkbox", name:"encendedor", label: "Encendedor"},
			{type: "checkbox", name:"radio", label: "Radio"},
			{type: "checkbox", name:"caratula", label: "Caratula"},
			{type: "checkbox", name:"bocinas", label: "Bocinas"},
			{type: "checkbox", name:"caja_discos", label: "Caja de Discos"},
			{type: "checkbox", name:"aire_acondicionado", label: "Aire acondicionado"},
			{type: "checkbox", name:"defroster", label: "Defroster"},
			{type: "checkbox", name:"vestiduras", label: "Vestiduras"},
			{type: "checkbox", name:"botones_puertas", label: "Botones puertas"},					
			{type: "checkbox", name:"viceras", label: "Viceras"},
			{type: "checkbox", name:"llave_switch", label: "Llave de switch"},
			{type: "checkbox", name:"switch", label: "Switch"},
		]},
		
		{type:"newcolumn"},
		{type: "block", inputWidth: 200, list:[
				{type: "checkbox", name:"reloj", label: "Reloj"},
				{type: "checkbox", name:"claxon", label: "Claxon"},
				{type: "checkbox", name:"espejo_retrovisor", label: "Espejo retrovisor"},
				{type: "checkbox", name:"tapetes", label: "Tapetes"},
				{type: "checkbox", name:"hule_piso", label: "Hule de piso"},
				{type: "checkbox", name:"tapete_cajuela", label: "Tapete de cajuela"},
				{type: "checkbox", name:"alfombra_cajuela", label: "Alfombra de cajuela"},
				{type: "checkbox", name:"tapas_puertas", label: "Tapas de puertas"},
				{type: "checkbox", name:"tapa_guantera", label: "Tapa de guantera"},
				{type: "checkbox", name:"coderas", label: "Coderas"},
				{type: "checkbox", name:"cielo", label: "Cielo"},
				{type: "checkbox", name:"juego_herramientas", label: "Jgo. de herramientas"},
				{type: "checkbox", name:"gato", label: "Gato"},
				{type: "checkbox", name:"reflejantes", label: "Reflejantes"},
				{type: "checkbox", name:"extintor", label: "Extintor"},
				{type: "checkbox", name:"baston_seguridad", label: "Baston de seguridad"},
				{type: "checkbox", name:"tolvas", label: "Tolvas"},
		]},
		{type:"newcolumn"},
		{type: "block", inputWidth: 200, list:[
				{type: "checkbox", name:"tapon_radiador", label: "Tapo de radiador"},
				{type: "checkbox", name:"tapones_aceite", label: "Tapones de aceite"},
				{type: "checkbox", name:"nivel_aceite", label: "Nivel de aceite"},
				{type: "checkbox", name:"tapon_licuadora", label: "Tapon de licuadora"},
				{type: "checkbox", name:"tapon_recuperador", label: "Tapon de recuperador"},
				{type: "checkbox", name:"filtro_aceite", label: "Filtro de aceite"},
				{type: "checkbox", name:"filtro_gasolina", label: "Filtro de gasolina"},
				{type: "checkbox", name:"filtro_aire", label: "Filtro de aire"},
				{type: "checkbox", name:"bayoneta_motor", label: "Bayoneta de motor"},
				{type: "checkbox", name:"bayoneta_transmisor", label: "Bayoneta de transmision"},
				{type: "checkbox", name:"bateria", label: "Bateria"},
				{type: "checkbox", name:"luz_motor", label: "Luz de Motor"},
				{type: "checkbox", name:"golpes", label: "Golpes"},
				{type: "checkbox", name:"costado_derecho", label: "Costado derecho"},
				{type: "checkbox", name:"costado_izquierdo", label: "Costado izquierdo"},
				{type: "checkbox", name:"parte_delantera", label: "Parte delantera"},
				{type: "checkbox", name:"parte_trasera", label: "Parte trasera"},
				{type: "checkbox", name:"antena_oficial", label: "Antena oficial"},
				{type: "checkbox", name:"equipo_radiocomunicacion", label: "Equipo radio comu."},
				{type: "checkbox", name:"portafiltro", label: "Porta filtro"},
		]},
			
		
	]},
	
	{type: "fieldset", label:"Nivel(%) de Combustible:",offsetLeft :20, width:710, list:[		
		{type: "input", name:"fuel_level", width:30, label:"<div id='sliderBox' style='width:200px; margin-right:40px'></div>", value:"1"},
		{type:"newcolumn"},
		{type: "input", name: "observations", label: "Detalles/Observaciones:", position:"label-top", labelWidth:160, value: "", rows: 3, width:440}
	]},

	{type:"label", label:""},
	{type: "block", inputWidth: 260, position:"absolute", offsetLeft :40, list:[
		{type: "button", name:"guardar", value: "Guardar"},
		{type:"newcolumn"},
		{type: "button", value: "Reset"	}
	]}


];