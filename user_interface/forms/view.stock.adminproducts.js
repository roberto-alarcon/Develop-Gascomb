/****************************
	Form Details Stock
****************************/

var stock_adminproducts = [
	{type:"settings", position:"label-left"},
	{type:"fieldset", inputWidth:'100%', label:"", list:[
		{type:"label", label:"Detalles de producto", position:"label-left"},
		{type: "input",name:'product', label: "Producto:", labelWidth:100,width:200},
		{type: "input",name:'code', label: "Codigo:", labelWidth:100,width:120},
		{type: "input",name:'unit', label: "Unidad:", labelWidth:100,width:100},
		{type: "input",name:'price', label: "Precio:", labelWidth:100,width:100},
		{type: "input",name:'line', label: "Linea:", labelWidth:100,width:120},
		{type: "input",name:'brand', label: "Marca:", labelWidth:100,width:120},
		{type:"label", label:""},
		{type:"label", label:""},
		{type: "block", inputWidth: 260, list:[
			{type: "button", name:'save', value: "Guardar"},
			{type:"newcolumn"},
			{type: "button", name:'reset', value: "Reset"	}
		]}
	]},
];
