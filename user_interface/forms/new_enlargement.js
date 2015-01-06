/****************************
	Form Enlargement
****************************/				
var new_enlargement = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", name:"fieldset_title", inputWidth:'100%', label:"Nueva ampliacion:", list:[
			/*{type: "combo", name:"email_id", label: "Email:", comboType: "checkbox", position:"label-left",labelWidth:80, width:250, options:[
								{text: "--", value: "", selected:true}
								
			]},		*/
			/*{type: "input", name:"receiber", position:"label-left", label: "Para:", labelWidth:80, width:385,validate: "NotEmpty",info: true, tooltip: "Solo acepta un correo, si desea agregar mas destinatarios, favor de agregarlos en el siguiente campo CC"},						
			{type: "input", name:"cc", position:"label-left", label: "Cc:", labelWidth:80, width:385,info: true, tooltip: "Puede agregar mas correos separados por coma, ejemplo: correo1@hotmail.com,correo2@hotmail.com", note: { text: "Puede agregar mas correos separados por coma"}},						
			{type: "input", name:"title", position:"label-left", label: "Asunto:", labelWidth:80, width:385,validate: "NotEmpty"},						*/
			{type: "editor", name:"message", label: "Mensaje:", labelWidth:80,inputWidth: 550,inputHeight: 180,validate: "NotEmpty"},			
			{type: "input", name:"comments", label: "Comentarios:", labelWidth:80,width: 550,inputHeight: 40},			
			{type: "input", name:"approved_by", position:"label-left",label: "Aprobado por:", labelWidth:80, width:550},
			{type: "input", name:"vobo", position:"label-left",label: "Vobo por:", labelWidth:80, width:550},
			{type: "select", name:"status", label: "Status:", position:"label-left",labelWidth:80,  disabled:true, options:[
					{text: "Pendiente", value: "0", selected:true},
					{text: "Autorizado", value: "1"},
					{text: "Cancelado", value: "2"}
			]},
			{type:"label", label:""},
			{type: "block", inputWidth: 260, list:[
				{type: "button", name:"enviar", value: "Enviar"},
				{type: "button", name:"guardar", value: "Guardar"},
				{type:"newcolumn"},
				{type: "button", name:"cancelar",value: "Cancelar"	}
			]}
		
		]},									
		
	];