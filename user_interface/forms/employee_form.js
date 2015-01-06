/****************************
	Form Usuarios
****************************/
var employee_form = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
			{type:"label", label:"Empleados (Agregar / Modificar)", position:"label-left"},
			{type: "input", position:"label-left", label: "Nombre(s):", labelWidth:120, width:200},
			{type: "input", label: "Apellido Paterno:", labelWidth:120,width:200},
			{type: "input", label: "Apellido Materno:", labelWidth:120,width:200},
			{type: "input", label: "Nickname:", labelWidth:120,width:200},
			{type: "select", label: "Puesto:", position:"label-left",labelWidth:120, options:[
					{text: "Recepcion", value: "recepcion", selected:true},
					{text: "Jefe de Piso", value: "jefe-piso"},
					{text: "Almacen", value: "almacen"},
					{text: "Administrador", value: "administrador"}
			]},
			
			{type:"label", label:""},
			{type:"label", label:"Estatus"},
			{type: "radio", name: "status", value: "by_pages", label: "Activo",position:"label-right", checked: true},
			{type: "radio", name: "status", value: "custom", label: "Inactivo",position:"label-right"},
			
			{type:"label", label:""},
			{type: "block", inputWidth: 260, list:[
				{type: "button", value: "Save"},
				{type:"newcolumn"},
				{type: "button", value: "Reset"	}
			]}
		
		]},							
		
	];