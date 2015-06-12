/****************************
	Form Details Stock
****************************/

var stock_details = [
	{type:"settings", position:"label-top"},
	{type:"fieldset", inputWidth:'100%', label:"", list:[
		{type:"label", label:"Detalles de producto", position:"label-left"},
		{type: "input", rows:3, style:"width:400px;height:100px;",label: "Comentarios:", labelWidth:100,inputLeft:5},
		{type:"label", label:""},
		{type: "select", label: "Estatus:", labelWidth:100, options:[
						{text: "Pendiente", value: "pendiente", selected:true},
						{text: "Entregado", value: "entregado"},
						{text: "Cancelado", value: "cancelado"},
						{text: "Administrador", value: "administrador"}
				]},
		{type:"label", label:""},
		{type:"label", label:""},
		{type: "block", inputWidth: 260, list:[
			{type: "button", value: "Guardar"},
			{type:"newcolumn"},
			{type: "button", value: "Reset"	}
		]}
	]},
];
