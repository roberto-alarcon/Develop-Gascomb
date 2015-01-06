/****************************
	Form Employee
****************************/				
var new_employee = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
			{type:"label", label:"Agregar nuevo Empleado", position:"label-left"},
			{type: "input", name:"name", position:"label-left", label: "Nombre(s):", labelWidth:120, width:200,  validate: "NotEmpty"},
			{type: "input", name:"last_name", label: "Apellidos :", labelWidth:120,width:200, validate: "NotEmpty"},			
			/*{type: "input", name:"nickname", label: "Nombre de Usuario:", position:"label-left",labelWidth:120},*/
			{type: "input", name:"role", label: "Cargo:", position:"label-left",labelWidth:120,  validate: "NotEmpty"},
			{type: "input", name:"department", label: "Departamento:", position:"label-left",labelWidth:120,  validate: "NotEmpty"},
			{type: "input", name:"company", label: "Empresa:", position:"label-left",labelWidth:120,  validate: "NotEmpty"},
			
			{type: "checkbox", name:"access_requisition",label: "¿Tendrá acceso al modulo de requisiciones?<br>(Solo aplicar para mecanicos)", position: "label-right",
				list: [
					{type: "password",name:"requisition_pwd",label: "Password", value: "", labelWidth:100,width:200}					
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