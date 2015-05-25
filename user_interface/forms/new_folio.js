/****************************
	Form Nuevo Folio
****************************/
var new_folio = [
		{type:"settings", position:"label-left"},
		{type:"fieldset",  label:"Nuevo Folio", position:"absolute", offsetLeft :20, list:[
			{type:"label", label:"Datos del Cliente", position:"label-left"},
			{type: "select", name:"dependency_id", label: "Cliente:", position:"label-left",labelWidth:120, connector:"ajax/grids/select_dependency.php"},
			{type: "select", name:"contract_id", label: "Contrato:", position:"label-left",labelWidth:120, options:[
					{text: "--", value: "", selected:true}
				]},				
			{type: "input", position:"label-left", name:"owner_name", label: "Nombre(s):", validate: "NotEmpty",labelWidth:120, width:300},
			{type: "input", name:"type_capture", type:"hidden"},
			{type: "input", name:"owner_adress", label: "Dirección:", validate: "NotEmpty", labelWidth:120,width:300},			
			{type: "input", name:"owner_phone", label: "Teléfono:", validate: "NotEmpty", labelWidth:120,width:150},
			{type: "input", name:"owner_cell", label: "Celular:", labelWidth:120,width:150},
			{type: "input", name:"owner_email", label: "Correo Electrónico:", labelWidth:120,width:250},											
			{type: "input", name:"owner_email2", label: "Correo Electrónico2:", labelWidth:120,width:250},											
			{type: "input", name:"area_sector", label: "Area/Sector:",labelWidth:120,width:250},											
			{type: "input", name:"zone", label: "Zona:",labelWidth:120,width:250},											
			{type:"label", label:""},
			{type:"label", label:"Datos de vehículo"},
			{type: "block", list:[
				{type: "input",  name:"registration_plate",labelWidth:100,label: "No de Placas",validate: "NotEmpty"},
				{type:"newcolumn"}, 
				{type: "button", value: 'Buscar', name:'search_regis_plate', position:"absolute", inputLeft:15, width:60},
			]},	

			{type: "input",  name:"economic_number", labelWidth:120,label: "No. Económico",validate: "NotEmpty"},
			{type: "input",  name:"engine_number", labelWidth:120,label: "No. de Motor"},
			{type: "input",  name:"vin", labelWidth:120,label: "VIN:"},
			{type: "select", name:"support_brand_vehicular_id", label: "Marca:", position:"label-left",labelWidth:120, connector:"ajax/grids/select_brands.php"},
			{type: "select", name:"support_models_vehicular_id",label: "Tipo:", position:"label-left",labelWidth:120, options:[
					{text: "--", value: "", selected:true}
			]},			
			{type: "input",  name:"year", labelWidth:120,label: "Año:",validate: "NotEmpty"},
			{type: "input",  name:"cilinders", labelWidth:120,label: "Cilindros:"},
			{type: "input",  name:"km", labelWidth:120,label: "Kms:"},
			{type: "select", name:"fuel", label: "Combustible:", position:"label-left",labelWidth:120, options:[
								{text: "Gasolina", value: "Gasolina", selected:true},
								{text: "Diesel", value: "Diesel"}
								
			]},			
			{type: "input",  name:"vehicle_operator", labelWidth:120, width:300, label: "Operador del vehículo:"},
			{type: "input",  name:"operator_tel", labelWidth:120,label: "Tel. del operador:"},
			
			
			{type:"newcolumn"}, 							
			{type: "block", inputWidth: 450, list:[
				{type:"label", label:"Perfil Corporativo"},												
				{type: "select", name:"type_service", position:"label-left",labelWidth:120,label: "Tipo de Servicio:", width:280,connector:"ajax/grids/select_type_activities.php"},				
				{type: "select",  name:"mechanic_assigned", labelWidth:120,label: "Jefe de mecánicos", width:280, connector:"ajax/grids/select_employees.php?profile=jefe mecanicos"},
				{type: "select",  name:"received_by", labelWidth:120,label: "Recibido por:", width:280, connector:"ajax/grids/select_employees_receptor.php"},
				
				{type: "calendar", labelWidth:120,label: "Fecha de ingreso", width:280, dateFormat: "%d/%m/%Y", value: "", name: "entry_date", validate: "NotEmpty"},				
				{type: "calendar",  labelWidth:120,label: "Hora de ingreso", width:280, dateFormat: "%H:%i", name:"entry_time", validate: "NotEmpty"},
				//{type: "calendar", labelWidth:120,label: "Fecha de entrega", width:280, dateFormat: "%d/%m/%Y", name: "departure_date", validate: "NotEmpty"},
				//{type: "calendar",  labelWidth:120,label: "Hora de entrega", width:280, dateFormat: "%H:%i", name:"departure_time", validate: "NotEmpty"},
				{type: "input",  labelWidth:120,label: "Torre", name:"tower", width:280},		
				{type: "input",  labelWidth:120,label: "Cajón", name:"parking_space", width:280},				
				{type: "input",  labelWidth:120,label: "Orden de trabajo(Cliente):", name:"order_number", width:280},				
				{type: "input", name: "failures", label: "Fallas que ocurren:", labelWidth:120, value: "", rows: 3, width:400, validate: "NotEmpty"},
				/*{type: "fieldset", width:380, label: "Servicios a realizar:", list:[
						{type: "input", name:"activities", value: "1", width:290, labelWidth:10, label: "1"},						
						{type:"newcolumn"},
						{type: "button", value: "[+]", name: "add_activity", position:"absolute", inputLeft:2, width:30}
				]},*/
				{type: "fieldset", className: "activs",width:410, label: "Servicios a realizar:", list:[
						{type: "combo", name:"activities", width:290, labelWidth:10,filtering:true},												
						{type:"newcolumn"},
						{type: "button", value: "[+]", name: "add_activity", position:"absolute", inputLeft:2, width:30}
				]}
				
				
			]},					
			
			
			{type:"label", label:""},
			{type: "block", inputWidth: 400, list:[
				{type: "button", name:"guardar", value: "Guardar"},
				{type:"newcolumn"},
				{type: "button", name:"reset", value: "Reset" },
				{type:"newcolumn"},
				{type: "button", name:"guardarIPAD", value: "Guardar IPAD"},
			]}
		
		]},							
		
	];