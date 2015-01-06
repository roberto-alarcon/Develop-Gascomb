<?php
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	ini_set('display_errors', '1');
	//print_r($_SERVER);die;
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	if(isset($_SESSION['active_user_id']) && $_SESSION['active_user_id']){
		$session_group = ( isset ( $_SESSION['active_user_group'] ) ) ? $_SESSION['active_user_group'] : 1;
		if($session_group !== "5"){
			 header( 'Location: '.$protocol.$_SERVER["HTTP_HOST"]) ;
		}
	}else{
		header( 'Location: '.$protocol.$_SERVER["HTTP_HOST"]) ;
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>		
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Sistema de produccion</title>
	<!--
	Librerias DHTMLX
	Version 1.0
	-->
	
	<!-- TabBar -->
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>
	
	<!-- Grid -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/dhtmlxgrid.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/dhtmlxgridcell.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/dhtmlxgrid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_skyblue.css">
	
	<!-- Formularios -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/dhtmlxform.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/skins/dhtmlxform_dhx_skyblue.css">
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/dhtmlxform_item_calendar.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/dhtmlxform_item_upload.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/dhtmlxform_item_editor.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/dhtmlxform_item_combo.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/dhtmlxform_dyn.js"></script>	
    <script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxForm/codebase/ext/swfobject.js"></script>
	
	<!-- LayOut -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxLayout/codebase/dhtmlxlayout.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxLayout/codebase/dhtmlxlayout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxLayout/codebase/skins/dhtmlxlayout_dhx_skyblue.css">
	
	<!-- Window -->
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxWindows/codebase/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxWindows/codebase/skins/dhtmlxwindows_dhx_skyblue.css">
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxWindows/codebase/dhtmlxwindows.js"></script>
	
	<!-- Menu Bar -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css"></link>
	
	
	
		
	
	<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			overflow: hidden;
		}
		
	</style>
	
	</head>
	
	<body style="background:#E3EFFF;">	
	<div id="parentId" style="position: relative; top: 20px; left: 20px; width: 600px; height: 400px; aborder: #B5CDE4 1px solid;"></div>
	</body>
	
	<script>
	
	// Declaracion de variables
	<?php //echo $session_result; ?>
	var dhxLayout,dhxToolbar,gridBrand;
	
	/****************************
		Event LoadPage
	****************************/
	window.addEventListener("load", function () {
		
		var dhxLayout = new dhtmlXLayoutObject("parentId", "2U");
		dhxLayout.cells("a").setText("Marcas");
		dhxToolbar = dhxLayout.cells("a").attachToolbar();
		dhxToolbar.setIconsPath("../menu/imgs/");
		dhxToolbar.addSeparator('sep_pagging', 1);
		dhxToolbar.addButton('btn_newbrand',2,'Nuevo','success_icon.gif','success_icon.gif');
		dhxToolbar.addSeparator('sep_pagging3',3);	
		dhxToolbarModels = dhxLayout.cells("b").attachToolbar();
		dhxToolbarModels.setIconsPath("../menu/imgs/");
		dhxToolbarModels.addSeparator('sep_pagging', 1);
		dhxToolbarModels.addButton('btn_newmodel',2,'Nuevo','success_icon.gif','success_icon.gif');
		dhxToolbarModels.addSeparator('sep_pagging3',3);
		
		dhxToolbar.attachEvent("onClick", function(itemId){
			formBrand = [
			{
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
			w1.setText("Nueva marca");
			w1.centerOnScreen();
			var formBrandd = w1.attachForm(formBrand);
			
			formBrandd.attachEvent("onButtonClick", function(name, command){			
				if(name=="save"){
					if(this.getItemValue("marca") == ""){
						alert("Es importante escribir una marca en el area correspodiente");
					}else{
						this.send('brands.php?action=add', function(loader, response) {	
							cargarMarcas();
							w1.close();
						});
					}
				}
				if(name=="cancel"){
					 w1.close();
				}
			});
			
		});
		//grid.setColTypes("txt");
		cargarMarcas();
		
				
		dhxLayout.cells("b").setText("Modelos");
		var gridModels = dhxLayout.cells("b").attachGrid();
		dhxLayout.cells("b").setWidth(400);		
		gridModels.setHeader("Marca, Modelo, Typo");
		gridModels.setInitWidths("100,100,100");
		gridModels.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");								
		gridModels.setColTypes("txt,txt,txt");	
		//gridModels.loadXML("models.php?action=get&id="+id);
		//gridModels.init();	
		
		function doOnRowSelectBrand(id) {
			var gridModels = dhxLayout.cells("b").attachGrid();			
			gridModels.setHeader("Marca, Modelo, Typo");
			gridModels.setInitWidths("100,*");
			gridModels.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");								
			gridModels.setColTypes("txt,txt,txt");	
			gridModels.loadXML("models.php?action=get&id="+id);
			gridModels.init();			
		}
		
		dhxToolbarModels.attachEvent("onClick", function(itemId){
			formModel = [
			{
				type: "fieldset",
				label: "Agregar nuevo modelo:",
				inputWidth: 320,
				list: [ {type: "select", name:"support_brand_vehicular_id", label: "Marca:&nbsp;", inputWidth: 230, position:"label-left", connector:"../ajax/grids/select_brands.php"},
						{
							type: "input",
							name:"model",
							label:"Modelo:",
							inputWidth: 230,
						},{
							type: "input",
							name:"tipo",
							label:"Tipo:&nbsp;&nbsp;&nbsp;&nbsp;",
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
			
			dhxWins = new dhtmlXWindows();			
			dhxWins.attachViewportTo("vp");
			w2 = dhxWins.createWindow("w1", 10, 10, 350, 250);
			w2.setText("Nuevo modelo");
			w2.centerOnScreen();
			formModell = w2.attachForm(formModel);
			
			formModell.attachEvent("onButtonClick", function(name, command){			
				if(name=="save"){
					if(this.getItemValue("model") == ""){
						alert("Es importante escribir un modelo en el area correspodiente");
					}else{
						//this.send("models.php?action=add");
						this.send('models.php?action=add', function(loader, response) {	
							doOnRowSelectBrand(formModell.getItemValue("support_brand_vehicular_id"))
							w2.close();
						});
						//gridModels.init();
					}
				}
				if(name=="cancel"){
					 w2.close();
				}
			});
						
		});	
		function cargarMarcas(){
				gridBrand = dhxLayout.cells("a").attachGrid();
				gridBrand.setHeader("Marcas");
				gridBrand.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
				gridBrand.setInitWidths("300");
				gridBrand.enableMultiline(true);
				gridBrand.loadXML("brands.php?action=get");
				gridBrand.init();
				gridBrand.attachEvent("onRowSelect", doOnRowSelectBrand);
			}
	});	
	
	
	</script>
	
	</html>
