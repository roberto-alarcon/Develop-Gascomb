// Decalaramos contantes
var stock_detail_id;
var id_inventory_control;
var grid_requisiciones;
var grid_stock;
var grid_stock_entregas;
var dhxTree_entregas;


var myFormService = [
          			{type:"settings", position:"label-left"},
          			//{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
          				{type:"label", label:"Gastos Adicionales", position:"label-left"},
          				{type: "input", name:"Monto", value:"", position:"label-left", label: "&nbsp;&nbsp;Monto:", labelWidth:120, width:100,  validate: "NotEmpty,ValidNumeric"},
          				{type: "input", name:"Descripcion", rows: 4,label: "&nbsp;&nbsp;Descripcion :", labelWidth:120,width:200, validate: "NotEmpty"},
          				{type: "input", name:"Autoriza", label: "&nbsp;&nbsp;Autoriza :", labelWidth:120,width:200, validate: "NotEmpty"},
          			//]},
          				{type:"label", label:""},
          				{type:"label", label:""},
          				{type: "block", inputWidth: 260, list:[
          					{type: "button", name:"guardar", value: "Guardar"},
          					{type:"newcolumn"},
          					{type: "button", name:"cancelar",value: "Cancelar"	}
          				]}
          						
                                ];
								
var myFormCode = [
          			{type:"settings", position:"label-left"},
          			//{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
          				{type:"label", label:"Codigo de Seguridad", position:"label-left"},
          				{type: "password", name:"code", value:"", position:"label-left", label: "&nbsp;&nbsp;Codigo:", labelWidth:120, width:100,  validate: "NotEmpty,ValidNumeric"},
          				{type:"label", label:""},
          				{type:"label", label:""},
          				{type: "block", inputWidth: 260, list:[
          					{type: "button", name:"guardar", value: "Guardar"},
          					{type:"newcolumn"},
          					{type: "button", name:"cancelar",value: "Cancelar"	}
          				]}
          						
                                ];




var viewAdminRequisiciones = function(){

	tabbar_stock = new dhtmlXTabBar("a_tabbar", "top");
	tabbar_stock.setSkin('dhx_skyblue');
	tabbar_stock.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
	tabbar_stock.addTab("a1", "Administrador", "100px");	
	tabbar_stock.setTabActive("a1");
	
	dhxLayoutStock = tabbar_stock.cells("a1").attachLayout("2U");
	var toolbar_treeRequisiciones = dhxLayoutStock.cells('a').attachToolbar();
	toolbar_treeRequisiciones.setIconsPath("menu/imgs/");
	toolbar_treeRequisiciones.addSeparator('sep_pagging', 1);
	toolbar_treeRequisiciones.addButton('btn_refresh_tree',2,'Actualizar','refresh.png','refresh.png');
	toolbar_treeRequisiciones.addSeparator('sep_pagging3',3);	
	toolbar_treeRequisiciones.addText("info_tree",4, "Folio:");
	toolbar_treeRequisiciones.addInput('input_tree',5,'',80);
	toolbar_treeRequisiciones.addButton('btn_buscar_tree',6,'Buscar'); 
	
						
	var cell_browse = dhxLayoutStock.cells('a');
	var cell_view_requisiciones = dhxLayoutStock.cells('b');
	var cell_comments = dhxLayoutStock.cells('c');
	cell_view_requisiciones.setHeight('200');
	cell_browse.setWidth('280');
	cell_browse.setText('Requisiciones');
	cell_view_requisiciones.setText('Solicitudes');
	
	// Armamos arbol
	dhxTree_requisiciones = dhxLayoutStock.cells("a").attachTree();
	dhxTree_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
	
	toolbar_treeRequisiciones.attachEvent("onClick", function(id){   
							
			switch(id){
				
				case 'btn_refresh_tree':
					dhxTree_requisiciones.deleteChildItems(0);
					dhxTree_requisiciones.loadXML("./ajax/view-stock.stockadmin.tree.php?str2="+Math.floor((Math.random()*100)+1).toString());
					break;
												
				case 'btn_buscar_tree':
					
					var folio_tree = toolbar_treeRequisiciones.getValue('input_tree');
					folio_tree = parseInt( folio_tree );
					
					if( isNaN(folio_tree) ){
						alert('Debes de agregar un numero para realizar la consulta');
					}else{
						dhxTree_requisiciones.deleteChildItems(0);
						dhxTree_requisiciones.loadXML("./ajax/view-system.tabstock.tree.php?folio="+folio_tree);
						
					}
					
					break;
				}
	
	});
	
	dhxTree_requisiciones.setOnClickHandler(function(id){
		console.log(id);
		var n = id.indexOf("-");
		if(id != 'root' && n != -1){

			id = id.split('-');
			var stock_id = id[0]; 
			var folio = id[1];
	
	
			// Cell 2 Creamos nuestros tabs
			var tabbar_stock_detail = dhxLayoutStock.cells("b").attachTabbar();
			tabbar_stock_detail.setSkin('dhx_skyblue');
			tabbar_stock_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
			tabbar_stock_detail.addTab("a1", "Vincular", "100px");
			tabbar_stock_detail.addTab("a2", "Requisicion Electronica", "150px");
			tabbar_stock_detail.addTab("a4", "Servicio Adicionales", "150px");
			tabbar_stock_detail.addTab("a3", "Entregas", "100px");
			//tabbar_stock_detail.addTab("a4", "Multimedia", "100px");
			tabbar_stock_detail.setTabActive("a1");
			
			
			// TAB Vincular
			// Datos del Vehiculo
			var layoutSolicitudes = tabbar_stock_detail.cells("a1").attachLayout("3E");
			var celda_info 		= layoutSolicitudes.cells('a');
			celda_info.setHeight('230');
			celda_info.setText("Datos del vehiculo");
			celda_info.attachURL("./ajax/tab_datos_generales_stock.php?get=vehicle&id=" + folio.toString());
			
			// Soliciutdes Mecanico
			var celda_grid 		= layoutSolicitudes.cells('b');
			celda_grid.setHeight('200');
			celda_grid.setText("Solicitudes Mecanico");
			
			grid_requisiciones = celda_grid.attachGrid();
			//dhxLayoutStock.cells('c').collapse();
			grid_requisiciones.setHeader(",Producto,Cantidad, Solicita,Autoriza,Status,Fecha de Modificacion,Comentarios");
			grid_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
			grid_requisiciones.setInitWidths("30,250,60,90,90,90,90,*");
			grid_requisiciones.setColTypes("img,ed,ed,ed,ed,ed,ed,ed");
			grid_requisiciones.init();
			grid_requisiciones.loadXML("./Modules/viewAdminRequisiciones/ajax/view-stock.stock.grid.php?id="+stock_id);
			
			grid_requisiciones.attachEvent("onRowDblClicked", function(rId,cInd){
			
				var n = rId.indexOf("-");
				if( n != -1){

					id = rId.split('-');
					stock_detail_id = id[0]; 
					status_link = id[1];
					
				}
				
				if(status_link != 7){
				
					var idwindow_control = 'control-inventarios';
					var dhxWins= new dhtmlXWindows(); 					
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(idwindow_control, 10, 10, 800, 600);
					dhxWins.window(idwindow_control).centerOnScreen(); 
					dhxWins.window(idwindow_control).setText("Departamento");
					dhxWins.window(idwindow_control).setModal(true);
					
					
					var tabbar_control = win.attachTabbar();
					tabbar_control.setSkin("dhx_skyblue");
					tabbar_control.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar_control.setHrefMode("ajax-html");
					
					//***********************************
					// TAB 1 CONTROL DE INVENTARIOS
					//***********************************
					tabbar_control.addTab("tab1", "Buscar Inventario", "150px");
					
					var toolbar_entrance = tabbar_control.cells("tab1").attachToolbar();
					toolbar_entrance.setIconsPath("menu/imgs/");
					toolbar_entrance.addSeparator('sep_pagging', 1);
					toolbar_entrance.addButton('btn_refresh_tree',2,'Actualizar','refresh.png','refresh.png');
					toolbar_entrance.addSeparator('sep_pagging3',3);	
					toolbar_entrance.addText("info_tree",4, "Tipo:");
					toolbar_entrance.addInput('input_tipo',30,'',180);
					toolbar_entrance.addButton('btn_buscar_entrance',6,'Buscar');
					
					toolbar_entrance.attachEvent("onClick",function(id){
			
						if(id == 'btn_buscar_entrance'){
							
								var tipo = toolbar_entrance.getValue('input_tipo');
									
								// Agregamos un layout al tab1
								layoutDetalles = tabbar_control.cells("tab1").attachLayout("2E");
								var layout_grid_stock = layoutDetalles.cells('a');
								var layout_grid_stock_details = layoutDetalles.cells('b');
								layout_grid_stock.setText('Stock');
								layout_grid_stock_details.setText('Existencia');
								layout_grid_stock_details.setHeight('150');
		
								grid_entrance = layout_grid_stock.attachGrid();
								grid_entrance.setHeader("Codigo , SKU, Producto, Tipo,Existencia");
								grid_entrance.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
								grid_entrance.setInitWidths("*");
								grid_entrance.setColTypes("ro,ro,ro,ro,ro");
								grid_entrance.init();
								grid_entrance.loadXML("./Modules/viewAdminRequisiciones/ajax/grid_control_de_inventarios.search_tipo.php?tipo="+tipo);
																											
								
								/*
								 *La vinculación se tiene que realizar por medio de el detalle
								 *
								grid_entrance.attachEvent("onRowDblClicked", function(rId,cInd){
																
										id_inventory_control = rId;                            	
										dhtmlxAjax.get("./Modules/viewAdminRequisiciones/ajax/action_create_link.php?folio_id="+folio.toString()+"&stock_detail_id="+stock_detail_id+'&id_inventory_control='+id_inventory_control ,function(loader){
												var response = JSON.parse(loader.xmlDoc.responseText);
												console.log(response);
												switch(response.code){
														case 0:
														alert(response.msj);
												break;
												
												case 1:
														dhxWins.window(idwindow_control).close();
												
														grid_requisiciones.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/view-stock.stock.grid.php?id="+stock_id);
														grid_stock.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?id="+stock_id+"&folio_id="+folio.toString());
														grid_stock_entregas.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?check=true&id="+stock_id+"&folio_id="+folio.toString());
												
												break;
										
												}
										});
																		
																		
																		
								});*/
								
								grid_entrance.attachEvent("onRowSelect", function(id){
        	    // Agregamos grid detalles
										grid_details = layout_grid_stock_details.attachGrid();
										grid_details.setHeader("Proveedor, Número existencia, Precio unitario, Número factura");
										grid_details.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
										grid_details.setInitWidths("*");
										grid_details.setColTypes("ro,ro,ro,ro");
										grid_details.init();
										grid_details.loadXML("./Modules/viewControlInventarios/grids/grid.item.details.php?id="+id);
										
										grid_details.attachEvent("onRowDblClicked", function(rId,cInd){
												
												id_inventory_control = rId;                            	
												dhtmlxAjax.get("./Modules/viewAdminRequisiciones/ajax/action_create_link.php?folio_id="+folio.toString()+"&stock_detail_id="+stock_detail_id+'&id_inventory_control='+id_inventory_control ,function(loader){
														var response = JSON.parse(loader.xmlDoc.responseText);
														console.log(response);
														switch(response.code){
																case 0:
																alert(response.msj);
														break;
														
														case 1:
																dhxWins.window(idwindow_control).close();
														
																grid_requisiciones.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/view-stock.stock.grid.php?id="+stock_id);
																grid_stock.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?id="+stock_id+"&folio_id="+folio.toString());
																grid_stock_entregas.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?check=true&id="+stock_id+"&folio_id="+folio.toString());
														
														break;
												
														}
												});
												
												
										});
										
										
										
										
								});	
								
								
						}
					
				});
				

				// Este TAB se activara cuando se incluya el modulo de venta electronica
				//tabbar_control.addTab("tab2", "Actualizar registro", "150px");
				tabbar_control.setTabActive("tab1");
				
				}
			});
			
			
			// Solicitudes Almacen
			var celda_mecanicos 	= layoutSolicitudes.cells('c');
			celda_mecanicos.setText("Solicitudes Almacen");
                        
            // Agregamos un tabbar para contener los grids de En inventarios y por comprar
            var tabbar_links_elements = layoutSolicitudes.cells("c").attachTabbar();
            tabbar_links_elements.setSkin('dhx_skyblue');
			tabbar_links_elements.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
			tabbar_links_elements.addTab("tabb1", "En inventario", "150px");
			tabbar_links_elements.addTab("a2", "Por comprar", "150px");
			tabbar_links_elements.setTabActive("tabb1");
                        
            // Agregamos un grid para Tab
            grid_stock = tabbar_links_elements.cells("tabb1").attachGrid()
			grid_stock.setHeader("Producto,Cantidad, Tipo,SKU,Fila,Anaquel,Repisa");
			grid_stock.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
			grid_stock.setInitWidths("250,60");
			grid_stock.setColTypes("ed,ed,ed,ed,ed,ed,ed");
			grid_stock.init();
			grid_stock.loadXML("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?id="+stock_id+"&folio_id="+folio.toString());
                        
			/*************************
            // Servicios Adicionales
            **************************/
			dhxLayoutAdicionales = tabbar_stock_detail.cells("a4").attachLayout("1C");
			var celda_historico = dhxLayoutAdicionales.cells('a');
            //celda_historico.setText('Historico');
            celda_historico.hideHeader();
			
            // Agregamos Toolbar y con boton nuevo 
            var toolbar_Servicio = celda_historico.attachToolbar();
            toolbar_Servicio.setIconsPath("menu/imgs/");
            toolbar_Servicio.addSeparator('sep_pagging', 1);
            toolbar_Servicio.addButton('btn_nuevo_servicio',2,'Nuevo','success_icon.gif','success_icon.gif');
            
			// Agregamos Grid al layout hitorico
            var grid_servicios = celda_historico.attachGrid();
			//dhxLayoutStock.cells('c').collapse();
            grid_servicios.setHeader("Fecha,Descripcion,Autoriza, Monto");
            grid_servicios.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
            grid_servicios.setInitWidths("130,*,150,150");
            grid_servicios.setColTypes("ed,ed,ed,ed");
            grid_servicios.init();
            grid_servicios.loadXML("./Modules/viewAdminRequisiciones/ajax/view-stock.servicios.grid.php?id="+folio.toString());
			
			
            toolbar_Servicio.attachEvent('onClick',function(btn){
            	
            	if(btn == 'btn_nuevo_servicio'){
            		
            		
                 	var idwindow_control = 'control-services';
                 	var dhxWins= new dhtmlXWindows(); 					
                 	dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
                 	var win = dhxWins.createWindow(idwindow_control, 50, 50, 420, 320);
                 	dhxWins.window(idwindow_control).centerOnScreen(); 
                 	dhxWins.window(idwindow_control).setText("Departamento");
                 	dhxWins.window(idwindow_control).setModal(true);
                 	tabbar_detail = win.attachTabbar();					
                 	tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
                 	tabbar_detail.addTab("us1", "Departamento", "120px");
                 	tabbar_detail.setTabActive("us1");
            
                 	var form = tabbar_detail.cells("us1").attachForm(myFormService);
                 	
                 	form.attachEvent("onButtonClick", function(id) {
                		if (id == "guardar") {  
                			
							form.send("./Modules/viewAdminRequisiciones/ajax/form.addnewservices.php?id="+folio.toString(),"post",function(loader, response){
								  alert("Los datos han sido guardados exitosamente");
								  dhxWins.window(idwindow_control).close();
								  //grid_log.clearAndLoad("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.history_entrance.php?id="+id_inventory);
								  grid_servicios.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/view-stock.servicios.grid.php?id="+folio.toString());
			
							});
							
                	
                		}else if(id == "cancelar"){
                			
                			dhxWins.window(idwindow_control).close();
                			
                		}
                	});
                 	
                 	
            		
            	}
            	
            	
            	
            });

            
            /*************************
            // Tab Entregas
            **************************/
			// Agregamos un layout
            dhxLayoutEntregas = tabbar_stock_detail.cells("a3").attachLayout("3U");
            var celda_entregar = dhxLayoutEntregas.cells('a');
            var celda_arbol_entregas = dhxLayoutEntregas.cells('b');
            var celda_detalles = dhxLayoutEntregas.cells('c');
            celda_arbol_entregas.setWidth('300');
            celda_entregar.setText('Materiales para entregar');
            celda_arbol_entregas.setText('Materiales entregados');
            celda_detalles.setText('Detalles');
            
            // Agregamos Iframe a la ventana de detalles
            celda_detalles.attachURL("./Modules/viewAdminRequisiciones/ajax/pdf_details.php?check=true&id="+stock_id+"&folio_id="+folio.toString());
            
            
            // Agregamos Toolbar y arbol al layout entegas
            var toolbar_treeEntregas = celda_entregar.attachToolbar();
            toolbar_treeEntregas.setIconsPath("menu/imgs/");
            toolbar_treeEntregas.addSeparator('sep_pagging', 1);
            toolbar_treeEntregas.addButton('btn_entregar_producto',2,'Entregar','success_icon.gif','success_icon.gif');
              
            
            
            //Agregamos grid listo para entregas
            grid_stock_entregas = celda_entregar.attachGrid()
			grid_stock_entregas.setHeader(" ,Producto,Cantidad, Tipo,SKU,Fila,Anaquel,Repisa");
            grid_stock_entregas.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
            grid_stock_entregas.setInitWidths("20,250,60");
            grid_stock_entregas.setColTypes("ch,ed,ed,ed,ed,ed,ed,ed");
            grid_stock_entregas.init();
            grid_stock_entregas.loadXML("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?check=true&id="+stock_id+"&folio_id="+folio.toString());
              
            toolbar_treeEntregas.attachEvent("onClick",function(id){
            	
            	if(id == 'btn_entregar_producto'){
            	
            		
            		var list = grid_stock_entregas.getCheckedRows(0);
            		console.log('list' + list);
            		if (list != ""){
					
						var idwindow_control = 'control-entregas';
						var dhxWins= new dhtmlXWindows(); 					
						dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
						var win = dhxWins.createWindow(idwindow_control, 50, 50, 420, 200);
						dhxWins.window(idwindow_control).centerOnScreen(); 
						dhxWins.window(idwindow_control).setText("Entregas");
						dhxWins.window(idwindow_control).setModal(true);
						tabbar_detail = win.attachTabbar();					
						tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
						tabbar_detail.addTab("us1", "Verificar codigo", "120px");
						tabbar_detail.setTabActive("us1");
						var formCode = tabbar_detail.cells("us1").attachForm(myFormCode);
						
						// Generamos el proceso de validacion por codigo
						formCode.attachEvent("onButtonClick", function(id) {
							if (id == "guardar") {  
								
								
								formCode.send("./Modules/viewAdminRequisiciones/ajax/action_validate_code.php","post",function(loader, response){
									  //alert("Los datos han sido guardados exitosamente");
									  
									  var obj = JSON.parse(response);
									  var employee = obj[0].employee_id;
									  
									  console.log(employee);
									  if (employee != 'False'){
										  
										// Generamos ajax para guardar datos
											
											dhtmlxAjax.get("./Modules/viewAdminRequisiciones/ajax/action_delivery_link.php?list="+list+"&folio_id="+folio.toString()+"&employee="+employee ,function(loader){	            
												
												var response = JSON.parse(loader.xmlDoc.responseText);
												
												dhxTree_entregas.deleteChildItems(0);
												dhxTree_entregas.loadXML("./Modules/viewAdminRequisiciones/ajax/tree_entregas.php?folio_id="+folio);
												grid_stock_entregas.clearAndLoad("./Modules/viewAdminRequisiciones/ajax/grid_link_in_stock.php?check=true&id="+stock_id+"&folio_id="+folio.toString());
												dhxWins.window(idwindow_control).close();
												alert("Los datos se han guardado satisfactoriamente");
											});
										  
									  }else{
										  
										  alert("El codigo de verificacion no es valido, favor de ingresarlo nuevamente");
										  //dhxWins.window(idwindow_control).close();
										  
									  }
									  
									  
									  
									 
								});

						
							}else if(id == "cancelar"){
								
								
								
							}
						});

					}

            	}
            	
            });
            
            
            // Generamos arbol con las solicitudes
            dhxTree_entregas = celda_arbol_entregas.attachTree();
            dhxTree_entregas.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
            dhxTree_entregas.loadXML("./Modules/viewAdminRequisiciones/ajax/tree_entregas.php?folio_id="+folio);
            
                  
			
		}
	
	});
	
	

}