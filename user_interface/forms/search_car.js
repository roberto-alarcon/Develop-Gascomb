/****************************
	Form Search new car
****************************/
				
search_car = [
		{type:"settings", position:"label-right"},
		{type: "label", label: "Tipo de Busqueda"},
		{type: "select", label: "", position:"label-top", name:'selectBusqueda', inputLeft :10,options:[
						{text: "Folio", value:"folio_id"},
						{text: "Placa", value:"registration_plate"},
						{text: "Requisicion", value:"stock_id"}
		]},
		{type: "input", value: '', name:'txtValue', position:"absolute", inputTop:28,inputLeft :100},
		{type: "button", value: 'Buscar', name:'Submit', position:"absolute", inputTop:26,inputLeft :250}
];