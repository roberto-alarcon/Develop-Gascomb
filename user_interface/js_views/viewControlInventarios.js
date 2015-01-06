/************************* 
  Vista control de inventarios 
  Roberto Alarcon 
  07/07/2014 
*************************/


var myFormEntrance = [
			{type:"settings", position:"label-left"},
			//{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
				{type:"label", label:"Informacion del producto", position:"label-left"},
				{type: "input", name:"numero", value:"1", position:"label-left", label: "&nbsp;&nbsp;Numero ingreso:", labelWidth:120, width:100,  validate: "NotEmpty"},
				{type: "input", name:"precio_unitario", label: "&nbsp;&nbsp;Precio unitario :", labelWidth:120,width:100, validate: "NotEmpty"},
				//{type: "input", name:"proveedor", label: "&nbsp;&nbsp;Proveedor :", labelWidth:120,width:200, validate: "NotEmpty"},
				
				{type: "combo", name:"proveedor", width:200, label: "&nbsp;&nbsp;Proveedor :", labelWidth:120,filtering:true},
				
				{type:"label", label:"Datos Factura"},
                {type: "input", name:"fecha_facturacion", position:"label-left", label: "&nbsp;&nbsp;Fecha Facturación:", labelWidth:120, width:100,  validate: "NotEmpty"},				
				{type: "input", name:"no_factura", position:"label-left", label: "&nbsp;&nbsp;Num factura/nota:", labelWidth:120, width:100,  validate: "NotEmpty"},				
				{type: "radio", name: "tipo_pago", value: "1", label: "&nbsp;&nbsp;Factura",position:"label-left", checked: true},
				{type: "radio", name: "tipo_pago", value: "0", label: "&nbsp;&nbsp;Nota remisión",position:"label-left"},				
				{type: "input", name:"code", position:"label-left", label: "&nbsp;&nbsp;Ingresa tu código:", labelWidth:120, width:100,  validate: "NotEmpty"},				
			
			//]},
				{type:"label", label:""},
				{type:"label", label:""},
				{type: "block", inputWidth: 260, list:[
					{type: "button", name:"guardar", value: "Guardar"},
					{type:"newcolumn"},
					{type: "button", name:"cancelar",value: "Cancelar"	}
				]}
						
                      ];


var myForm = [
		{type:"settings", position:"label-left"},
		{type:"fieldset", inputWidth:'100%', label:"General settings", list:[
			{type:"label", label:"Informacion del producto", position:"label-left"},
			{type: "input", name:"producto", position:"label-left", label: "Producto:", labelWidth:120, width:200,  validate: "NotEmpty"},
			{type: "input", name:"tipo", label: "Tipo :", labelWidth:120,width:200},			
			{type: "input", name:"proveedor", label: "Proveedor :", labelWidth:120,width:200, validate: "NotEmpty"},			
			{type: "input", name:"codigo_producto", label: "Codigo del producto:", labelWidth:120,width:100, validate: "NotEmpty"},
			{type: "input", name:"sku", label: "SKU:", labelWidth:120,width:200, validate: "NotEmpty"},
			{type: "select", name:"id_almacen", label: "Tipo de almacen:", position:"label-left",labelWidth:120,  validate: "NotEmpty", options:[
					{text: "Stock", value: "1", selected:true},
					{text: "Gasolina", value: "11"},
					{text: "Diesel", value: "12"},
					{text: "Bicombustible", value: "13"},
					{text: "Laboratorio", value: "14"},
					{text: "Mercancia en consignacion", value: "2"},
					{text: "Servicios", value: "3"},
					{text: "Pedidos", value: "4"}
			]},
			
			{type:"label", label:""},
			{type:"label", label:"Datos de Clasificacion"},
			{type: "input", name:"fila", labelWidth:120, width:200,label: "Fila"}, 
			{type: "input", name:"anaquel", labelWidth:120, width:200,label: "Anaquel"},
			{type: "input", name:"repisa", labelWidth:120, width:200,label: "Repisa"},
			
			{type:"label", label:""},
			{type:"label", label:"Datos de Compra"},
			{type: "input", name:"item_min", label: "Stock minimo :", labelWidth:120,width:50},
			{type: "input", name:"item_max", label: "Stock maximo :", labelWidth:120,width:50},
			
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


var tipo_almacen = 0;
var grid_control;
var viewControlInventarios = function(){
	
	
	var layout = new dhtmlXLayoutObject("a_tabbar", "1C");
	var tabbar_control = layout.cells("a").attachTabbar();
	
	tabbar_control.setSkin("dhx_skyblue");
	tabbar_control.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
	tabbar_control.setHrefMode("ajax-html");
	
	//***********************************
	// TAB 1 CONTROL DE INVENTARIOS
	//***********************************
	tabbar_control.addTab("tab1", "Control de inventarios", "150px");
	tabbar_control.setTabActive("tab1");
	// tool bar
	
	// Agregamos layout
	dhxLayout = tabbar_control.cells("tab1").attachLayout("3L");
    dhxLayout.cells("a").setText("Categorias"); 
    dhxLayout.cells("b").hideHeader();
    dhxLayout.cells("c").hideHeader();
    dhxLayout.cells("a").setWidth(200);
    
    // Agregamos arbol de categorias
    var dhxTree_site = dhxLayout.cells("a").attachTree();
    dhxTree_site.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
    dhxTree_site.loadXML("./Modules/viewControlInventarios/menu/tree_categorias_controlInventarios.xml?123");
    
    var toolbar_control = dhxLayout.cells("b").attachToolbar();
	toolbar_control.setIconsPath("menu/imgs/");
	toolbar_control.addSeparator('sep_pagging', 1);
	toolbar_control.addButton('btn_nuevo',2,'Nuevo','add.png','add.png');
	//toolbar_control.addButton('btn_delete',3,'Desactivar','delete.png','delete.png');
	
    
    // Evento click arbol 
    dhxTree_site.attachEvent("onClick",function(id){
        
    	tipo_almacen = id;
    	dhxLayout.cells("b").detachObject(true)
    	if (id != 'root'){
        	
        	// Agregamos grid
        	
    		grid_control = dhxLayout.cells("b").attachGrid();
        	grid_control.setHeader("Codigo , SKU, Producto, Tipo,Proveedor,Fila,Anaquel,Repiza,Existencia,Status");
        	grid_control.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
        	grid_control.setInitWidths("*");
        	grid_control.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro");
        	grid_control.init();
        	grid_control.loadXML("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.php?almacen="+tipo_almacen);
        	
        	grid_control.attachEvent("onRowDblClicked", function(id){
        	    // your code here
        		windowControlInventario('update' , id , grid_control);
				
        		
        	});
			
        	grid_control.attachEvent("onRowSelect", function(id){
        	    // Agregamos grid
				grid_details = dhxLayout.cells("c").attachGrid();
        		grid_details.setHeader("Proveedor, Número existencia, Precio unitario, Número factura");
				grid_details.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
				grid_details.setInitWidths("*");
				grid_details.setColTypes("ro,ro,ro,ro");
				grid_details.init();
				grid_details.loadXML("./Modules/viewControlInventarios/grids/grid.item.details.php?id="+id);				
				
        	});		
        	
        }
    	
    });
    
    toolbar_control.attachEvent("onClick",function(id){
		if(id == 'btn_nuevo'){
			
			windowControlInventario('new', 0, grid_control);
			
		}
	});
	
	//***********************************
	// TAB 2 Entradas
	//***********************************	
	//tabbar_detail.setContentHref("tab1",ajaxDatosGenerales);
	tabbar_control.addTab("tab2", "Entradas", "120px");
	//Agregamos Layout
	dhxLayout_entrance = tabbar_control.cells("tab2").attachLayout("3J");
	dhxLayout_entrance.cells("a").setText("Busqueda");
	var toolbar_entrance = dhxLayout_entrance.cells('a').attachToolbar();
	toolbar_entrance.setIconsPath("menu/imgs/");
	toolbar_entrance.addSeparator('sep_pagging', 1);
	toolbar_entrance.addButton('btn_refresh_tree',2,'Actualizar','refresh.png','refresh.png');
	toolbar_entrance.addSeparator('sep_pagging3',3);	
	toolbar_entrance.addText("info_tree",4, "SKU:");
	toolbar_entrance.addInput('input_sku',30,'',180);
	toolbar_entrance.addButton('btn_buscar_entrance',6,'Buscar');
	
	toolbar_entrance.attachEvent("onClick",function(id){
		
		if(id == 'btn_buscar_entrance'){
			
			var search_sku = toolbar_entrance.getValue('input_sku');
			console.log(search_sku);
			
			grid_entrance = dhxLayout_entrance.cells('a').attachGrid();
			grid_entrance.setHeader("Codigo , SKU, Producto, Proveedor");
			grid_entrance.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
			grid_entrance.setInitWidths("*");
			grid_entrance.setColTypes("ro,ro,ro,ro");
			grid_entrance.init();
			grid_entrance.loadXML("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.search_sku.php?sku="+search_sku);
			
			// Revisamos si existe el SKU de lo contrario sugerimos abrir la venta insert
			dhtmlxAjax.get("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.search_sku.php?sku="+search_sku ,function(loader){	            
				var response = loader.xmlDoc.responseText;
				if (response == '<rows></rows>'){
					
					if(confirm("El SKU no ha sido dado de alta, desea crearlo ahora ?")){
						
						windowControlInventario('new', 0, 0);
						
					}
				}
				
						
		    });
			
			
			
			grid_entrance.attachEvent("onRowSelect",function(id_inventory){
				//alert(id_inventory);
				grid_log = dhxLayout_entrance.cells('b').attachGrid();
				grid_log.setHeader("Fecha Ingreso , Usuario, No Piezas , Proveedor , Costo Unitario, Costo Total");
				grid_log.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
				grid_log.setInitWidths("*");
				grid_log.setColTypes("ro,ro,ro,ro,ro,ro");
				grid_log.init();
				grid_log.loadXML("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.history_entrance.php?id="+id_inventory);
				
				// Formulario
				form_entrace = dhxLayout_entrance.cells('c').attachForm(myFormEntrance);
				
				var autocomplete_p = form_entrace.getCombo("proveedores");
				autocomplete_p.enableFilteringMode(true, "ajax/search_supplier.php", true, true);
				
				
				form_entrace.attachEvent("onButtonClick", function(btn) {
					
					if(btn == 'guardar'){
						
						form_entrace.send("./Modules/viewControlInventarios/ajax/viewControlInventario.formEntrance.php?id="+id_inventory,"post",function(loader, response){
							  alert("Los datos han sido guardados exitosamente");
							  
							  grid_log.clearAndLoad("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.history_entrance.php?id="+id_inventory);
						});
						
					}
					
				});
				
				
			});
			
			
			
		}
		
		
	});
	
	

	dhxLayout_entrance.cells("b").setText("Historico");
	dhxLayout_entrance.cells("c").setText("Entradas");
	
	//***********************************
	// TAB 3 Refacturación
	//***********************************	
	//tabbar_detail.setContentHref("tab2",ajaxFormatosDigitales);
	tabbar_control.addTab("tab3", "Refacturación", "100px");
	var dhxLayout_departures = tabbar_control.cells("tab3").attachLayout("3J");
	dhxLayout_departures.cells("a").setText("Busqueda de Folio");
	var toolbar_departures = dhxLayout_departures.cells('a').attachToolbar();
	toolbar_departures.setIconsPath("menu/imgs/");
	toolbar_departures.addText("info_folio",4, "Folio:");
	toolbar_departures.addInput('input_folio',30,'',180);
	toolbar_departures.addButton('btn_buscar_departures',6,'Buscar');
	
	var celda_info 		= dhxLayout_departures.cells('a');
	var celda_grid 		= dhxLayout_departures.cells('c');
	celda_grid.setText('Material solicitado');
	
	var cell_salidas 		= dhxLayout_departures.cells('b');
	cell_salidas.setText('Salidas');
	
	//Agregamos barra de herramientas de salidas
	var toolbar2_departures = cell_salidas.attachToolbar();
	toolbar2_departures.setIconsPath("menu/imgs/");
	toolbar2_departures.addText("info_folio",4, "SKU:");
	toolbar2_departures.addInput('input_sku_salida',30,'',180);
	toolbar2_departures.addButton('btn_salida',6,'Salida');
	
	
	toolbar_departures.attachEvent('onClick',function(btn){
	
		if (btn == 'btn_buscar_departures'){
			
			var folio = toolbar_departures.getValue('input_folio');
			console.log(folio);
			celda_info.attachURL("./ajax/tab_datos_generales_stock.php?get=vehicle&id=" + folio.toString());
			
			// Grid
			var grid_requisiciones = celda_grid.attachGrid();
			//dhxLayoutStock.cells('c').collapse();
			grid_requisiciones.setHeader("Producto,Cantidad, Solicita,Autoriza,Status,Fecha de Modificacion,Comentarios");
			grid_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
			grid_requisiciones.setInitWidths("250,60,90,90,90,90,*");
			grid_requisiciones.setColTypes("ed,ed,ed,ed,ed,ed,ed");
			grid_requisiciones.init();
			grid_requisiciones.loadXML("./ajax/view-stock.stock.grid.php?id=3604");
			
			
		}
		
	});
	
	
	//***********************************
	// TAB 4 Proveedores
	//***********************************
	tabbar_control.addTab("tab4", "Proveedores", "100px");
	
	// tool bar	
	var dhxLayout_suppliers = tabbar_control.cells("tab4").attachLayout("1C");
    dhxLayout_suppliers.cells("a").setText("Listado de Proveedores:");
	var toolbar_suppliers = dhxLayout_suppliers.cells('a').attachToolbar();
	toolbar_suppliers.setIconsPath("menu/imgs/");
	toolbar_suppliers.addSeparator('sep_pagging', 1);
	toolbar_suppliers.addButton('btn_nuevo',2,'Nuevo','add.png','add.png');
	toolbar_suppliers.addButton('btn_delete',3,'Desactivar','delete.png','delete.png');		
	//grid

	var grid_suppliers = dhxLayout_suppliers.cells('a').attachGrid();
	grid_suppliers.setHeader("Id Proveedor,Proveedor,Direccion,Telefono,Correo Electronico,Fecha Registro,Fecha Modificacion,Status");
	grid_suppliers.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
	grid_suppliers.setInitWidths("80,225,*,120,120,120,120,95");
	grid_suppliers.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro");
	grid_suppliers.init();
	grid_suppliers.loadXML("ajax/grids/grid_suppliers.php");
	
	//Evento doble click en el row
	grid_suppliers.attachEvent("onRowDblClicked", function(rId,cInd){	
		windowSupplier(rId,grid_suppliers,'update');
	});
	// Evento nuevo
	toolbar_suppliers.attachEvent("onClick", function(id){
			
			switch(id){
				
				case 'btn_nuevo':
					windowSupplier('0',grid_suppliers,'insert');
				break;
				case 'btn_delete':
					windowSupplier('0',grid_suppliers,'delete');
				break;
			}
	});		

	
	/**********************************************************
		Module Supplier
		Contains:
		- fn windowSupplier
		- fn viewSupplier
	/**********************************************************/

	var windowSupplier = function(id_supplier,grid_sup,action){
		
		//Desactivar
		if(action =="delete"){
			var id = grid_sup.getSelectedRowId();
			if(id == null){
				alert("Seleccione un proveedor");
			}else{
				
				var answer = confirm("Seguro de desactivar al proveedor seleccionado?")
				if (answer){
					params = 'id='+id;
					dhtmlxAjax.post("./ajax/ajaxSupplier.php?action=disable", params, function(loader){							
						if(loader.xmlDoc.responseText){	
							var json = JSON.parse(loader.xmlDoc.responseText);
							if(json.return =="1"){
								grid_sup.clearAll();
								grid_sup.loadXML("ajax/grids/grid_suppliers.php");
								alert("Proveedor desactivado");											
							}else{
								alert("Oops!!, Sucedi������ un error, volver a intentar");
							}										
						}
					});								
				}								
			}
		}					
		if(action =="update" || action =="insert"){
			//Create new Window
			var idwindow = 'window-supplier';
			var dhxWins= new dhtmlXWindows();
			dhxWins.setSkin("dhx_skyblue");
			dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
			var win = dhxWins.createWindow(idwindow, 50, 50, 410, 530);						
			dhxWins.window(idwindow).setText("Administrador de Proveedores");
			dhxWins.window(idwindow).centerOnScreen();
			tabbar_detail = win.attachTabbar();
			tabbar_detail.setSkin("dhx_skyblue");
			tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
			tabbar_detail.addTab("prov1", "Proveedores", "120px");
			tabbar_detail.setTabActive("prov1");
			
			// Add form to componenet
			var formnew_supplier = tabbar_detail.cells("prov1").attachForm(new_supplier);						
			if(action !== "update"){ 
				//formnew_user.enableLiveValidation(true);
			}else{
				//formnew_user.enableLiveValidation(false);
			}
			
			//UpdateElements
			if(id_supplier != '0'){
				params = 'id='+id_supplier;
				dhtmlxAjax.post("./ajax/ajaxSupplier.php?action=get", params, function(loader){							
					if(loader.xmlDoc.responseText){
						var json_return = loader.xmlDoc.responseText;
						var json = JSON.parse(json_return);

						formnew_supplier.setItemValue("name", json.nombre);
						formnew_supplier.setItemValue("address", json.direccion);
						formnew_supplier.setItemValue("phone", json.telefono);
						formnew_supplier.setItemValue("email", json.correo);								
						formnew_supplier.setItemValue("status", json.status);
						formnew_supplier.hideItem("idsupplier");
						formnew_supplier.setItemValue("idsupplier",id_supplier);
					}
				});
			}	
            
			// Handle Listener onclinck 
			formnew_supplier.attachEvent("onButtonClick", function(id) {
				if(id =="cancelar"){
					dhxWins.window(idwindow).close();
				}
				if(id =="guardar"){
					
					var url = "";
					if(id_supplier == '0'){
						url = "ajax/ajaxSupplier.php?action=add";
					}else{	
						url = "ajax/ajaxSupplier.php?action=update&id="+id_supplier;
					}
						if (formnew_supplier.getItemValue("nombre") == "" && id_user == '0'){
							alert("El campo nombre no puede quedar vacio");
						} else if (formnew_supplier.getItemValue("telefono") == "" && id_user == '0') {
							alert("El campo telefono no puede quedar vacio");
						}else{
							formnew_supplier.send(url, function(loader, response) {
								var objJSON = eval("(function(){return " + response + ";})()");
								if(objJSON.return == "1"){
									alert("Guardado correctamente");

								}else{
									alert("Se produjo un error, favor de volver a intentar");
								}
								grid_sup.clearAll();
								grid_sup.loadXML("ajax/grids/grid_suppliers.php");
								dhxWins.window(idwindow).close();
							});
						}	
				}	
			});
		}//Update||insert	
	}	
	


	//***********************************
	// TAB 5 Reportes
	//***********************************
	tabbar_control.addTab("tab5", "Reportes", "100px");
	
	
}

var windowControlInventario = function( action , id , grid ){
	
	var id_inventory_control = id;
	var idwindow_control = 'control-inventarios';
	var dhxWins= new dhtmlXWindows(); 					
	dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
	var win = dhxWins.createWindow(idwindow_control, 50, 50, 420, 620);
	dhxWins.window(idwindow_control).centerOnScreen(); 
	dhxWins.window(idwindow_control).setText("Departamento");
	dhxWins.window(idwindow_control).setModal(true);
	tabbar_detail = win.attachTabbar();					
	tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
	tabbar_detail.addTab("us1", "Departamento", "120px");
	tabbar_detail.setTabActive("us1");
	
	var form = tabbar_detail.cells("us1").attachForm(myForm); 
	
	if (action == 'update'){
		
		// Obtenemos todos los datos mediante un ajax
		dhtmlxAjax.get('./Modules/viewControlInventarios/ajax/viewControlInventario.getItems.php?id='+id,function(loader){	            
			var values = JSON.parse(loader.xmlDoc.responseText);
			form.setItemValue("producto",values[0].producto);
			form.setItemValue("tipo",values[0].tipo);
			form.setItemValue("proveedor",values[0].proveedor);
			form.setItemValue("codigo_producto",values[0].codigo_producto);
			form.setItemValue("sku",values[0].sku);
			form.setItemValue("fila",values[0].fila);
			form.setItemValue("anaquel",values[0].anaquel);
			form.setItemValue("repisa",values[0].repisa);
			form.setItemValue("item_min",values[0].item_min);
			form.setItemValue("item_max",values[0].item_max);
			
			form.setItemValue("id_almacen",values[0].id_almacen);
			form.setItemValue("status",values[0].status);
			
			
	    });
		
	}else if(action == 'new'){
		
		form.setItemValue("id_almacen",tipo_almacen);
		form.setItemValue("item_min",5);
		form.setItemValue("item_max",100);
		
		
	}
	
	form.attachEvent("onButtonClick", function(id) {
		if (id == "guardar") {  
			
			if(grid != 0){
			
				//Ajax para obtener consulta
				form.send("./Modules/viewControlInventarios/ajax/viewControlInventario.form.php?action="+action+"&id="+id_inventory_control,"post",function(loader, response){
					  alert("Los datos han sido guardados exitosamente");
					  dhxWins.window(idwindow_control).close();
					  grid.clearAndLoad("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.php?almacen="+tipo_almacen);
				});	
				
			}else{
				form.send("./Modules/viewControlInventarios/ajax/viewControlInventario.form.php?action="+action+"&id="+id_inventory_control,"post",function(loader, response){
					  alert("Los datos han sido guardados exitosamente");
					  dhxWins.window(idwindow_control).close();
					  //grid.clearAndLoad("./Modules/viewControlInventarios/ajax/grid_control_de_inventarios.php?almacen="+tipo_almacen);
				});	
				
			}
	
		}else if(id == "cancelar"){
			
			dhxWins.window(idwindow_control).close();
			
		}
	});
	
	
}


