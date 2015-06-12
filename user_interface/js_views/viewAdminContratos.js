/************************
*CREAMOS LA VISTA PARA MODIFICAR LOS VEHICULOS
*ROBERTO ALARCON
*roberto.alarcon@tours360.com.mx
*25/03/2014
********************************/

var formModel = [{
		type: "fieldset",
		label: "Agregar nuevo modelo:",
		inputWidth: 320,
		list: [ 
						{
								type: "input",
								name:"contrato",
								label:"Contrato:",
								inputWidth: 230,
						},{
								type: "input",
								name:"Comentario",
								label:"Comentarios:&nbsp;&nbsp;",
								inputWidth: 230,
						},{
						type: "label",
						list: [{
								type: "label",
								labelWidth: 250
						}, {
								type: "newcolumn"
						}, {
								type: "button",
								name:"cancel",
								value: "Cancelar"
						}, {
								type: "newcolumn"
						}, {
								type: "button",
								name:"save",
								value: "Guardar"
						}]}]
		}];

var viewAdminContratos = function(){
 
   document.getElementById("a_tabbar").innerHTML = "";
   var dhxLayout = new dhtmlXLayoutObject("a_tabbar", "2U");
    dhxLayout.cells("a").setText("Nombre de la dependencia");
    dhxLayout.cells("a").setWidth(300);
    dhxToolbar = dhxLayout.cells("a").attachToolbar();
    dhxToolbar.setIconsPath("./menu/imgs/");
    dhxToolbar.addSeparator('sep_pagging', 1);
    // Botones
    dhxToolbar.addButton('btn_newbrand',2,'Nuevo','success_icon.gif','success_icon.gif');
    dhxToolbar.addButton('btn_deletebrand',3,'Borrar','delete.png','delete.png');
    
    
    dhxToolbar.addSeparator('sep_pagging3',3);	
    dhxToolbarModels = dhxLayout.cells("b").attachToolbar();
    dhxToolbarModels.setIconsPath("./menu/imgs/");
    dhxToolbarModels.addSeparator('sep_pagging', 1);
    dhxToolbarModels.addButton('btn_newmodel',2,'Nuevo','success_icon.gif','success_icon.gif');
    dhxToolbarModels.addButton('btn_deletemodel',3,'Borrar','delete.png','delete.png');
    
    
    dhxToolbarModels.addSeparator('sep_pagging3',3);
    
    gridDependencia = dhxLayout.cells("a").attachGrid();
    gridDependencia.setHeader("Marcas");
    gridDependencia.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
    gridDependencia.setInitWidths("300");
    gridDependencia.enableMultiline(false);
    gridDependencia.loadXML("./Modules/adminContratos/ajax/grid_contratos.php?action=get");
    gridDependencia.init();
   
    var gridModels = true;
    gridDependencia.attachEvent("onRowSelect", function(id){
        
        gridContratos = dhxLayout.cells("b").attachGrid();			
        gridContratos.setHeader(" Contrato, Comentarios");
        gridContratos.setInitWidths("200,*");
        gridContratos.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");								
        gridContratos.setColTypes("txt,txt,txt");	
        gridContratos.loadXML("./Modules/adminContratos/ajax/grid_contratos_details.php?action=get&id="+id);
        gridContratos.init();
		
        gridContratos.attachEvent("onRowDblClicked", function(rId,cInd){
			
                        // Obtenemos los elementos mediante un ajax
                        dhtmlxAjax.get("./models/models.php?action=getValues&id="+rId,function(loader){
                                
                                console.log(loader.xmlDoc.responseText);
                                
                                var values = JSON.parse(loader.xmlDoc.responseText);
                                var modelo =    (values[0].model == null) ? "" : values[0].model;
                                var tipo =      (values[0].type == null) ? "" : values[0].type;

                                dhxWins = new dhtmlXWindows();			
                                dhxWins.attachViewportTo("vp");
                                w2 = dhxWins.createWindow("w1", 10, 10, 360, 220);
                                w2.setText("Ediatr el modelo");
                                w2.centerOnScreen();
                                formModell = w2.attachForm(formModel);
                                
                                formModell.setItemValue("contrato", modelo);
                                formModell.setItemValue("comentarios", tipo);
                                
                                formModell.attachEvent("onButtonClick", function(name, command){			
				if(name=="save"){
					
                                    if(this.getItemValue("model") == ""){
						alert("Es importante escribir un modelo en el area correspodiente");
				    }else{
                                    
                                        var id = rId;
                                        var modelo = this.getItemValue("model");
                                        var tipo = this.getItemValue("tipo");
                                        
                                        
                                        var params = 'id='+id+'&modelo='+modelo+'&tipo='+tipo;
                                        dhtmlxAjax.post('./models/models.php?action=update&id='+rId,params,function(loader){
                                    
                                                var selId = gridBrand.getSelectedId();
                                                gridModels.clearAll();
                                                gridModels.loadXML("./models/models.php?action=get&id="+selId);
                                                w2.close();
                                            
                                        });
                                        
                                        
                                    }
						
					
				}
				if(name=="cancel"){
					 w2.close();
				}
		    });
                                
                                
                            
                        });
			
			
		
		});  
    
    });
    
    // Controlamos los eventos para el menu de marcas
    dhxToolbar.attachEvent("onClick", function(itemId){
       
       switch( itemId ){
        
            case 'btn_newbrand':
                
                // Ventana emergente para agregar un nuevo modelo
                
                var formBrand = [{
                                type: "fieldset",
                                label: "Agregar nueva marca:",
                                inputWidth: 320,
                                list: [{
                                                        type: "input",
                                                        label:"Marca: ",
                                                        name: 'marca',
                                                        inputWidth: 230,
                                                },{
                                                type: "label",
                                                list: [{
                                                        type: "label",
                                                        labelWidth: 250
                                                }, {
                                                        type: "newcolumn"
                                                }, {
                                                        type: "button",
                                                        name: 'cancel',
                                                        value: "Cancelar"
                                                }, {
                                                        type: "newcolumn"
                                                }, {
                                                        type: "button",
                                                        name: 'save',
                                                        value: "Guardar"
                                                }]}]
                                        }];
                dhxWins = new dhtmlXWindows();	
                dhxWins.attachViewportTo("vp");
                w1 = dhxWins.createWindow("w1", 10, 10, 350, 170);
                w1.setText("Agrega un nueva marca");
                w1.centerOnScreen();
                var formBrandd = w1.attachForm(formBrand);
                
                formBrandd.attachEvent("onButtonClick", function(name, command){			
                        if(name=="save"){
                            if(this.getItemValue("marca") == ""){
                                    alert("Es importante escribir una marca en el area correspodiente");
                            }else{
                                    this.send('./models/brands.php?action=add', function(loader, response) {	
                                    w1.close();
                                    
                                    gridBrand.clearAll();
                                    gridBrand.loadXML("./models/brands.php?action=get");
                                    
                                    });
                            }
                        }
                        if(name=="cancel"){
                                 w1.close();
                        }
		});
                
                
                break;
            
            
            case 'btn_deletebrand':
                
                var selId = gridBrand.getSelectedId();
                if (selId != null ){
                    
                    if (confirm("Estas seguro de borrar este registro?")) {
                        
                        //async mode
                        dhtmlxAjax.get("./models/brands.php?action=delete&id="+selId,function(loader){
                                
                                gridBrand.clearAll();
                                gridBrand.loadXML("./models/brands.php?action=get");
                                gridModels.clearAll();
                            
                        });
                        
                        
                    }
                    
                }else{
                    
                    alert("Es necesario seleccionar una marca para poder borrar el elemento");
                    
                }
                
                
                
                
                break;
        
       }
       
        
    });
    
    
    // Controlamos los eventos para el menu de modelos
    dhxToolbarModels.attachEvent("onClick", function(itemId){
    
        switch( itemId ){
        
            case 'btn_newmodel':
                
                var selId = gridBrand.getSelectedId();
                if (selId != null ){
                
                    dhxWins = new dhtmlXWindows();			
                    dhxWins.attachViewportTo("vp");
                    w2 = dhxWins.createWindow("w1", 10, 10, 350, 200);
                    w2.setText("Nuevo modelo");
                    w2.centerOnScreen();
                    formModell = w2.attachForm(formModel);
                    
                    formModell.attachEvent("onButtonClick", function(name, command){			
				if(name=="save"){
					
                                    if(this.getItemValue("model") == ""){
						alert("Es importante escribir un modelo en el area correspodiente");
				    }else{
                                    
                                        var id = selId;
                                        var modelo = this.getItemValue("model");
                                        var tipo = this.getItemValue("tipo");
                                        
                                        
                                        var params = 'id='+id+'&modelo='+modelo+'&tipo='+tipo;
                                        dhtmlxAjax.post('./models/models.php?action=add&id='+selId,params,function(loader){
                                    
                                                
                                                gridModels.clearAll();
                                                gridModels.loadXML("./models/models.php?action=get&id="+id);
                                                w2.close();
                                            
                                        });
                                        
                                        
                                    }
						
					
				}
				if(name=="cancel"){
					 w2.close();
				}
		    });
                    
                    
                    
                }else{
                    
                    alert("Es necesario seleccionar una marca para poder agregar un nuevo modelo");
                    
                }
                
                
                
                break;
            
            case 'btn_deletemodel':
                
                var selId = gridModels.getSelectedId();
                if (selId != null ){
                    
                    if (confirm("Estas seguro de borrar este registro?")) {
                        
                        //async mode
                        var marcaId = gridBrand.getSelectedId();
						dhtmlxAjax.get("./models/models.php?action=delete&id="+selId,function(loader){
                                
                                gridModels.clearAll();
                                gridModels.loadXML("./models/models.php?action=get&id="+marcaId);
                               
                            
                        });
                        
                        
                    }
                    
                }else{
                    
                    alert("Es necesario seleccionar una marca para poder borrar el elemento");
                    
                }
                
                
                break;
         
            
        }
    
        
    });
    
		
               
 
 
}