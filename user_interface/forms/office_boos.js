/****************************
	Form Usuarios
****************************/
var office_boos = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', width:375,label:"Asignar Jefe de Departamento:", list:[
			{type:"label", label:""},
			{type: "select",  name:"recepcion", labelWidth:80,label: "Recepci&oacute;n", width:200, connector:"ajax/grids/select_employees.php?department=recepcion"},
			{type:"label", label:""},
			{type: "select",  name:"almacen", labelWidth:80,label: "Almacen", width:200, connector:"ajax/grids/select_employees.php?department=almacen"},
			{type:"label", label:""},
			{type: "select",  name:"calidad", labelWidth:80,label: "Calidad", width:200, connector:"ajax/grids/select_employees.php?department=almacen"},
			
			{type:"label", label:""},
			{type:"label", label:""},
			{type: "block", inputWidth: 250, list:[
				{type: "button", name:"guardar", value: "Guardar"},
				{type:"newcolumn"},
				{type: "button", name:"cancelar",value: "Cancelar"	}
			]}
		
		]},		
			
		
	];