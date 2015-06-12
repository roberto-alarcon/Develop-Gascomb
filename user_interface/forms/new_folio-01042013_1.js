/****************************
	Form Nuevo Folio
****************************/
var new_folio = [
		{type:"settings", position:"label-left"},
		{type:"fieldset",  label:"Nuevo Folio", position:"absolute", offsetLeft :20, list:[
			{type:"label", label:"Datos de propietario", position:"label-left"},
			{type: "input", position:"label-left", label: "Nombre(s):", labelWidth:120, width:300},
			{type: "input", label: "Direccion:", labelWidth:120,width:300},
			{type: "input", label: "Colonia:", labelWidth:120,width:200},
			{type: "input", label: "Telefono:", labelWidth:120,width:150},
			{type: "input", label: "Celular:", labelWidth:120,width:150},
			{type: "input", label: "Correo Electronico:", labelWidth:120,width:250},						
			
										
			{type:"label", label:""},
			{type:"label", label:"Datos de vehiculo"},
			{type: "input",  labelWidth:120,label: "No de Placas"},
			{type: "input",  labelWidth:120,label: "No. Economico"},
			{type: "select", label: "Marca:", position:"label-left",labelWidth:120, options:[
					{text: "--", value: "null", selected:true},
					{text: "Preventivo", value: "preventivo"},
					{text: "Correctivo", value: "correctivo"}
					
			]},
			{type: "select", label: "Tipo:", position:"label-left",labelWidth:120, options:[
					{text: "--", value: "null", selected:true},
					{text: "Preventivo", value: "preventivo"},
					{text: "Correctivo", value: "correctivo"}
					
			]},
			{type: "input",  labelWidth:120,label: "Año"},
			{type: "input",  labelWidth:120,label: "Cilindros"},
			{type: "input",  labelWidth:120,label: "Kms"},
			
			
			{type:"newcolumn"}, 							
			{type: "block", inputWidth: 300, list:[
				{type:"label", label:""},
				{type:"label", label:"Perfil Corporativo"},
				{type: "select", label: "Contrato:", position:"label-left",labelWidth:120, options:[
						{text: "--", value: "null", selected:true},
						{text: "Recepcion", value: "recepcion"},
						{text: "Jefe de Piso", value: "jefe-piso"},
						{text: "Almacen", value: "almacen"},
						{text: "Administrador", value: "administrador"}
				]},
				{type: "select", label: "Tipo de Servicio:", position:"label-left",labelWidth:120, options:[
						{text: "--", value: "null", selected:true},
						{text: "Preventivo", value: "preventivo"},
						{text: "Correctivo", value: "correctivo"}
						
				]},
				{type: "input",  labelWidth:120,label: "Folio Interno"},
				{type: "calendar", labelWidth:120,label: "Fecha de ingreso",dateFormat: "%d/%m/%Y", value: "", name: "start_date" },
				{type: "input",  labelWidth:120,label: "Hora de ingreso"},
				{type: "calendar", labelWidth:120,label: "Fecha de entrega",dateFormat: "%d/%m/%Y", value: "", name: "end_date" },
				{type: "input",  labelWidth:120,label: "Hora de entrega"},
				{type: "input",  labelWidth:120,label: "No de Orden"}
			]},					
			
			
			{type:"label", label:""},
			{type: "block", inputWidth: 260, list:[
				{type: "button", value: "Guardar"},
				{type:"newcolumn"},
				{type: "button", value: "Reset"	}
			]}
		
		]},							
		
	];