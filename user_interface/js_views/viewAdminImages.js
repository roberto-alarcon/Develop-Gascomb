var folio_origen;
var folio_destino;
var dhxTree_folder;

viewAdminImages = function(){
	
	tabbar_images = new dhtmlXTabBar("a_tabbar", "top");
	tabbar_images.setSkin('dhx_skyblue');
	tabbar_images.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
	tabbar_images.addTab("a1", "Subir Imagenes", "150px");
	tabbar_images.addTab("a2", "Mover Imagenes", "150px");
	tabbar_images.setTabActive("a1");
	
	// TAB Upload Images
	var toolbar_upload =  tabbar_images.cells("a1").attachToolbar();
	toolbar_upload.setIconsPath("menu/imgs/");
	toolbar_upload.addText("info_folio",1, "Folio:");
	toolbar_upload.addInput('input_folio_upload',2,'',180);
	toolbar_upload.addButton('btn_load_upload',3,'Cargar');
	
	toolbar_upload.attachEvent("onClick",function(id){
	
		if(id == 'btn_load_upload' ){
		
			folio_id = toolbar_upload.getValue('input_folio_upload');
			
			var uploadForm = [
				{
				type: "fieldset",
				label: "Multimedia",
				position:"absolute", offsetLeft :20,offsetTop :20,
				list: [
				{
					type: "upload",
					name: "files",
					inputWidth: 330,
					url: "ajax/upload_images.php?folio_id="+folio_id,
					_swfLogs: "enabled",
					swfPath: "./dhtmlxLibrary/dhtmlxForm/codebase/ext/uploader.swf",
					swfUrl: "./dhtmlxLibrary/dhtmlxForm/samples/07_uploader/php/dhtmlxform_item_upload.php"
					}]
				}
				
				];
			
			var form_inventario = tabbar_images.cells("a1").attachForm(uploadForm);
			
		
		}
		
	});
	
	
	
	
	
	
	// TAB Mover Imagenes
	dhxLayoutImages 	= tabbar_images.cells("a2").attachLayout("3U");
	var cell1 			= dhxLayoutImages.cells('a');
	cell1.setText("Origen");
	var cell2 			= dhxLayoutImages.cells('b');
	cell2.setText("Destino");
	var celda_visor_multimedia 			= dhxLayoutImages.cells('c');
	celda_visor_multimedia.setText("Preview");
	
	// Layout Origen
	var toolbar1_images = cell1.attachToolbar();
	toolbar1_images.setIconsPath("menu/imgs/");
	toolbar1_images.addText("info_folio",1, "Folio:");
	toolbar1_images.addInput('input_folio',2,'',180);
	toolbar1_images.addButton('btn_load',3,'Cargar');
	toolbar1_images.addSeparator('sep_pagging3',4);
	toolbar1_images.addButton('btn_delete',8,'Borrar','delete.png','delete.png');
	toolbar1_images.addSeparator('sep_pagging3',9);

	// Layout Destino
	var toolbar2_images = cell2.attachToolbar();
	toolbar2_images.setIconsPath("menu/imgs/");
	toolbar2_images.addText("info_folio_destino",1, "Folio:");
	toolbar2_images.addInput('input_folio_destino',2,'',180);
	toolbar2_images.addButton('btn_load_destino',3,'Cargar');
	
	
	toolbar1_images.attachEvent("onClick",function(id){
		
		
		
		if(id == 'btn_load'){
			
			folio_origen = toolbar1_images.getValue('input_folio');
			
			dhxTree_folder = cell1.attachTree();
			dhxTree_folder.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
			dhxTree_folder.enableDragAndDrop(true,false);
			//dhxTree_folder.enableMercyDrag(true);
			dhxTree_folder.loadXML("ajax/file_browser/load_tree.php?folio_id="+folio_origen);

			// Evento onClick del arbol
			dhxTree_folder.setOnClickHandler(function(id){
								
				var str =id;
				var node =str.substr(0,6);
				if(node != 'folder' && node != 'root'){									
					celda_visor_multimedia.attachURL("./ajax/file_browser/load_elements.php?folio_id="+folio_origen+"&file="+id.toString());
				}
				
			});
			
			dhxTree_folder.attachEvent("onDrag", function(sId, tId, id, sObject, tObject){
				
				ajaxMoveDocument('origen', sId, tId, id, sObject, tObject );
			
			});
			
			
		
		
		}
		
		if (id == 'btn_delete'){
		
			folio_origen = toolbar1_images.getValue('input_folio');
			
			if(confirm('¿Estas seguro de borrar esta imagen?')){
			
				console.log(folio_origen);
				//console.log(id);
				console.log(dhxTree_folder.getSelectedItemId());
				
				file = dhxTree_folder.getSelectedItemId();
				
				var params = 'folio_origen='+folio_origen+'&file='+file;
				dhtmlxAjax.post('./Modules/adminImages/ajax/delete_file.php',params,function(loader){
			
						console.log(loader.xmlDoc.responseText);
						
						dhxTree_folder.deleteChildItems(0);
						dhxTree_folder.loadXML("ajax/file_browser/load_tree.php?folio_id="+folio_origen);
					
				});
				
			
			}
		
		}
		
	
		
	});
	
	toolbar2_images.attachEvent("onClick",function(id){
		
		if(id == 'btn_load_destino'){
			
			folio_destino = toolbar2_images.getValue('input_folio_destino');
			dhxTree_folder_2 = cell2.attachTree();
			dhxTree_folder_2.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
			dhxTree_folder_2.enableDragAndDrop(true, false);
			dhxTree_folder_2.loadXML("ajax/file_browser/load_tree.php?folio_id="+folio_destino);
			
			
			// Evento onClick del arbol
			dhxTree_folder_2.setOnClickHandler(function(id){
								
				var str =id;
				var node =str.substr(0,6);
				if(node != 'folder' && node != 'root'){									
					celda_visor_multimedia.attachURL("./ajax/file_browser/load_elements.php?folio_id="+folio_destino+"&file="+id.toString());
				}
				
			});
			
			dhxTree_folder_2.attachEvent("onDrag", function(sId, tId, id, sObject, tObject){
				// your code here
				
				ajaxMoveDocument('destino', sId, tId, id, sObject, tObject );
				
				
			});
			
			
		
		}
	
		
	});
	

}

var ajaxMoveDocument = function(tipo, sId, tId, id, sObject, tObject){

	var folio1 	= folio_origen;
	var folio2 	= folio_destino;
	
	if( tipo == 'destino' ){
	
		var result_folio_origen 	= folio1;
		var result_folio_destino	= folio2;
	
	}else{
	
		var result_folio_origen 	= folio2;
		var result_folio_destino	= folio1;	
	
	}
	
	// Validamos que sea hacia una carpeta 
	if (sObject != tObject){
	
		file 		= sId;
		dir_destino = tId;
		
		if( dir_destino != null && ( dir_destino == 'images' || dir_destino == 'pdf') ){
			
			var params = 'folio_origen='+folio_origen+'&folio_destino='+folio_destino+'&tipo='+tipo+'&dir_destino='+dir_destino+'&file='+file;
			dhtmlxAjax.post('./Modules/adminImages/ajax/copy_file.php',params,function(loader){
		
					console.log(loader.xmlDoc.responseText);
					
					tObject.deleteChildItems(0);
					tObject.loadXML("ajax/file_browser/load_tree.php?folio_id="+result_folio_destino);
				
			});
		
		}
	}
	
	

}



