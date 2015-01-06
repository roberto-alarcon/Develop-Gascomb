/****************************
	Form Proveedores
****************************/
var new_supplier = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
			{type:"label", label:"Datos del Proveedor", position:"label-left"},
			{type: "input", name:"name", position:"label-left", label: "Nombre(s):", labelWidth:120, width:200,  validate: "NotEmpty"},
			{type: "input", name:"address", label: "Dirección :", labelWidth:120,width:200, validate: "NotEmpty"},			
            {type: "input", name:"phone", label: "Teléfono :", labelWidth:120,width:200, validate: "NotEmpty"},			
			{type: "input", name:"email", labelWidth:120, width:200,label: "Email",  validate: "ValidEmail", required: true}, 
			
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