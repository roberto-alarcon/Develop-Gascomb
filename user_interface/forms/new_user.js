/****************************
	Form Usuarios
****************************/
var new_user = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
			{type:"label", label:"Agregar nuevo Usuario", position:"label-left"},
			{type: "input", name:"name", position:"label-left", label: "Nombre(s):", labelWidth:120, width:200,  validate: "NotEmpty"},
			{type: "input", name:"last_name", label: "Apellidos :", labelWidth:120,width:200, validate: "NotEmpty"},			
			{type: "select", name:"profile", label: "Perfil:", position:"label-left",labelWidth:120,  validate: "NotEmpty", options:[
					{text: "Recepcion", value: "recepcion", selected:true},
					{text: "Jefe de Piso", value: "jefe-piso"},
					{text: "Jefe de Mecanicos", value: "jefe mecanicos"},
					{text: "Asesor de servicio", value: "asesor de servicio"},
					{text: "Almacen", value: "almacen"},
					{text: "Administrador", value: "administrador"}
			]},
			
			{type:"label", label:""},
			{type:"label", label:"Datos de Acceso"},
			{type: "input", name:"email", labelWidth:120, width:200,label: "Email",  validate: "ValidEmail", required: true}, 
			{type: "password", name:"password", labelWidth:120, width:200,label: "Contrase&ntilde;a"},	

			{type: "checkbox", name:"isemployee",label: "¿Es empleado? <br>Es importante activar esta opción si es empleado", position: "label-right",
				list: [
					{type: "input",name:"role",label: "Cargo", value: "", labelWidth:100,width:200}, 
					{type: "input",name:"department",label: "Departamento",value: "",labelWidth:100,width:200},
					{type: "input",name:"company",label: "Empresa",value: "",labelWidth:100,width:200}
					]
			},	
			
			{type:"label", label:""},
			{type:"label", label:"Estatus"},
			{type: "radio", name: "status", value: "1", label: "Activo",position:"label-right", checked: true},
			{type: "radio", name: "status", value: "0", label: "Inactivo",position:"label-right"},
			
			{type:"label", label:""},
			{type:"label", label:""},
			{type: "block", inputWidth: 260, list:[
				{type: "button", name:"guardar", value: "Guardar"},
				{type:"newcolumn"},
				{type: "button", name:"cancelar",value: "Cancelar"	}
			]}
		
		]},		
			
		
	];