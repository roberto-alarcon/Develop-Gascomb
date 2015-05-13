<?php
  session_start();
  include_once ("../config/set_variables.php");
  
  if(isset($_SESSION['active_user_id']) && $_SESSION['active_user_id']){
  	$session_result = "var secure = false;";
  } else{
  	$session_result = "var secure = true;";
  }
  
  $session_group = ( isset ( $_SESSION['active_user_group'] ) ) ? $_SESSION['active_user_group'] : 1;
// Include configuration 

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
	
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>jquery-2.0.3.min.js"></script>
	<!-- TabBar -->
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>
	
	<!-- Grid -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/dhtmlxgrid.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/codebase/dhtmlxgridcell.js"></script>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGrid/sources/ext/dhtmlxgrid_export.js"></script> 
	
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
	
	<!--Calendar -->
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
	
	<!-- Acordeon -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxAccordion/codebase/dhtmlxaccordion.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxAccordion/codebase/skins/dhtmlxaccordion_dhx_skyblue.css">
	
	<!-- Grafica de Gantt -->
	<link type="text/css" rel="stylesheet" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.css">
	<script type="text/javascript" language="JavaScript" src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.js"></script>

	<!-- Tree -->
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTree/codebase/dhtmlxtree.css">
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxTree/codebase/dhtmlxtree.js"></script>
	
	<!-- DataBilding -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxDataStore/codebase/datastore.js"></script>
	
	<!-- dhtmlxslider -->	
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxSlider/codebase/dhtmlxslider.js"></script>	
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxSlider/codebase/dhtmlxslider.css">	
	<!-- dhtmlxMessage -->	
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxMessage/codebase/dhtmlxmessage.js"></script>	
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxMessage/codebase/skins/dhtmlxmessage_dhx_terrace.css">	
	
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxEditor/codebase/skins/dhtmlxeditor_dhx_skyblue.css">	
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxEditor/codebase/dhtmlxeditor.js" type="text/javascript"></script>
	<!-- dhtmlxCombo -->	
	<link rel="STYLESHEET" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCombo/codebase/dhtmlxcombo.css">
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCombo/codebase/dhtmlxcombo.js"></script>
	<script  src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCombo/codebase/ext/dhtmlxcombo_extra.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxPopup/codebase/skins/dhtmlxpopup_dhx_skyblue.css"/>	
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxPopup/codebase/dhtmlxpopup.js"></script>
	
	
	<!-- Incluimos listado de formularios -->
	<script src="./forms/search_car.js"></script>
	<script src="./forms/new_user.js"></script>
	<script src="./forms/stocktaking.js"></script>
	<script src="./forms/new_folio.js"></script>
	<script src="./forms/new_employee.js"></script>
	<script src="./forms/employee_form.js"></script>
	<script src="./forms/stock_details.js"></script>
	<script src="./forms/view.stock.adminproducts.js"></script>
	<script src="./forms/new_enlargement.js"></script>
	<script src="./forms/office_boos.js"></script>
	<script src="./forms/new_supplier.js"></script>
	
	<!-- Incluimos vistas -->
	<script src="./js_views/viewAdminCars.js?cache=<?php echo time();?>"></script>
	<script src="./js_views/viewControlInventarios.js?cache=<?php echo time();?>"></script>
	<script src="./js_views/viewAdminImages.js?cache=<?php echo time();?>"></script>
	<script src="./js_views/viewAdminRequisiciones.js?cache=<?php echo time();?>"></script>
	<script src="./js_views/viewAdminContratos.js?cache=<?php echo time();?>"></script>
	
	<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			overflow: hidden;
		}

		
		#form_container {
                position: absolute;
                left: 50%;
                top: 50%;
                width: 280px;
                height: 130px;
                margin-top: -150px;
                margin-left: -180px;
				background:#fff;
				padding:10px;
                overflow: auto;
				-moz-border-radius: 5px;
				border-radius: 5px;
				-webkit-box-shadow: 0px 5px 20px rgba(50, 50, 50, 0.6);
				-moz-box-shadow:    0px 5px 20px rgba(50, 50, 50, 0.6);
				box-shadow:         0px 5px 20px rgba(50, 50, 50, 0.6);
                
        }
        
         #form_msj {
                position: absolute;
                left: 50%;
                top: 50%;
                width: 280px;
                height: 20px;
                margin-top: -170px;
                margin-left: -180px;
                color:#FF0000;
 
                overflow: auto;
                
        }
		
	</style>
	
	</head>
	
	<body style="background:#E3EFFF;">
		
		<div id="toolbarObj"></div>		
		<div id="a_tabbar" style="width:100%; height:95%;"/>
		
		<div id="form_msj"></div>	
		<div id="form_container"></div>
		
		
		
		<script>
				
				/****************************
					Variables Globales
				****************************/
				var tabbar;
				var screen_width = screen.width;
				var screen_height = screen.height;
				var tabbs_system_height = screen_height - ( 325 + 60 );
				
				var folio = 0;
				var requisicion = 0;
				var placa = 0;
				var isTabinventoryOpen = false;				
				window.dhx_globalImgPath="<?php echo PATH_DHTMLX_LIBRARY."dhtmlxCombo/codebase/imgs/"; ?>";				
				<?php echo $session_result; ?>
				//var secure = true;
				
				/****************************
					Funciones Globales
				****************************/
				// function crear ventana
				var windowDetal = function(id,title,tab){
					
					tabAvtive 	= (tab != '')?tab:'tab3'
					title 		= (title != '')?title:'Ventana'
					
					var ajaxDatosGenerales = "./ajax/tab_datos_generales.php?id=" + id.toString() ;
					var ajaxFormatosDigitales = "./ajax/tab_formatos_digitales.php?id=" + id.toString() ;
					var iframeCalidad	= "./iframe/iframe_quality_list.php?id=" + id.toString() ;
					
					var dhxWins= new dhtmlXWindows();
					dhxWins.setSkin("dhx_skyblue");
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(id, 50, 50, 1024, 600);
					dhxWins.window(id).setText(title);
					
					tabbar_detail = win.attachTabbar();
					tabbar_detail.setSkin("dhx_skyblue");
					tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar_detail.setHrefMode("ajax-html");
					
					tabbar_detail.addTab("tab1", "Datos Generales", "120px");
					tabbar_detail.setContentHref("tab1",ajaxDatosGenerales);
					tabbar_detail.addTab("tab2", "Formatos Digitales", "120px");
					tabbar_detail.setContentHref("tab2",ajaxFormatosDigitales);
					tabbar_detail.addTab("tab3", "Actividades", "100px");
					tabbar_detail.addTab("tab4", "Requisiciones", "100px");
					tabbar_detail.addTab("tab5", "Ampliaciones", "100px");
					tabbar_detail.addTab("tab6", "Calidad", "100px");
					tabbar_detail.setContentHref("tab6",iframeCalidad);
					tabbar_detail.addTab("tab7", "Logs", "100px");
					tabbar_detail.setTabActive(tabAvtive);
				
				}
				
				function deleteActivity(id_act){
						
						var params = 'action=delete&id='+id_act;	
						//Carga de emails al formulario de ampliaciones
						dhtmlxAjax.post("./ajax/delete_activity.php", params, function(loader){	
								if(loader.xmlDoc.responseText){										
									var json_return = loader.xmlDoc.responseText;
									if(json_return == "true"){
										alert("Actividad eliminada!!");
									}else{
										alert("Hubo un problema al eliminar, favor de reportar este incidente");
									}
								}
						});
						
				}
				
				
				// Ventana Usuarios
				var usuarioWindow = function(){
					var id = 'user-window'
					var dhxWins= new dhtmlXWindows();
					dhxWins.setSkin("dhx_skyblue");
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(id, 50, 50, 500, 600);
					dhxWins.window(id).setText("Administrador de Usuarios");
					
					tabbar_detail = win.attachTabbar();
					tabbar_detail.setSkin("dhx_skyblue");
					tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					
					tabbar_detail.addTab("us1", "Usuarios", "120px");
					tabbar_detail.addTab("us2", "Nuevo", "120px");
					tabbar_detail.setTabActive("us1");
					// Agreagamos grid a la tabla de Usuarios:
					var grid = tabbar_detail.cells("us1").attachGrid();
					
					
					grid.setHeader("Nombre, A Paterno, Correo,Status");
					grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
					
					grid.setInitWidths("120,120,120,*");
					grid.setColTypes("ed,ed,ed,ed");
					grid.init();
					
					grid.loadXML("./dhtmlxLibrary/dhtmlxGrid/samples/common/grid.xml");
					
					// Agregamos el formulario
					var form = tabbar_detail.cells("us2").attachForm(new_user);
					//form.loadStruct("./forms/form_tab_nuevo_usuario.xml?" + new Date().getTime());
					
				
				}
				
				// Ventana Empleados:
				var empleadosWindow = function(){
					
					var id = 'employee-window'
					var dhxWins= new dhtmlXWindows();
					dhxWins.setSkin("dhx_skyblue");
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(id, 50, 50, 500, 600);
					dhxWins.window(id).setText("Administrador de Empleados");
					
				}
								
				
				/****************************
					System Views
				****************************/
				var viewSistema = function () {
					
					var ajaxAlertas = "./views/alerts/alerts_view.php";
					var ajaxReportes = "./ajax/reportes.php";
					
					tabbar = new dhtmlXTabBar("a_tabbar", "top");
					tabbar.setSkin('dhx_skyblue');
					tabbar.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar.setHrefMode("iframes-on-demand");
					tabbar.addTab("a1", "Notificaciones", "100px");
					tabbar.setContentHref("a1",ajaxAlertas);
					tabbar.addTab("a2", "Busquedas", "100px");
					tabbar.addTab("a3", "Nuevo", "100px");
					tabbar.addTab("a4", "Reportes", "100px");
					//tabbar.setContentHref("a4",ajaxReportes);
					tabbar.setTabActive("a2");
					var session_group = <?php echo $session_group; ?>;
					if( session_group != 5 ){
							tabbar.hideTab('a4');
					}
									
					var formfolio;	
					tabbar.attachEvent("onSelect", function(id,last_id){
					
					
							// *******  Tab - Reports **********
						 if(id == "a4"){
							var layout = tabbar.cells("a4").attachLayout("2U");
					
							//Incluimos tipo de reportes
							var cell_2 = layout.cells('a');
							cell_2.fixSize(0,0);
							cell_2.setWidth('350');
							cell_2.setHeight('150');
							cell_2.hideHeader();
							
							var cell_3 = layout.cells('b');
							cell_3.hideHeader();
							
							//var cell_4 = layout.cells('c');
							//cell_4.setText('Resultados');
							//layout.cells('c').collapse();
							
							search_car = [
									{type:"settings", position:"label-right"},									
									{type:"label", label:"Parametros del reporte", position:"label-left"},
									{type: "select", name:"dependency_id", label: "Cliente:", position:"label-left",labelWidth:110, width:200,connector:"ajax/grids/select_dependency.php"},
									{type: "select", name:"mechanic_assigned", label: "Mecanico asignado:", position:"label-left",labelWidth:110, width:200,connector:"ajax/getMechanics.php"},
									{type: "calendar", labelWidth:110,label: "Fecha inicio:", position:"label-left", width:200, dateFormat: "%d/%m/%Y", value: "", name: "date_init", validate: "NotEmpty"},				
									{type: "calendar",  labelWidth:110,label: "Fecha final:", position:"label-left", width:200, dateFormat: "%d/%m/%Y", name:"date_final", validate: "NotEmpty"},									
									{type: "label",label:"Status"}, 
									{type: "radio",name: "status",value: "1",label: "Activos",checked: true},
									{type: "radio",name: "status",value: "8",label: "Cerrados"},									
									{type: "radio",name: "status",value: "9",label: "Cancelados"},									
									{type: "radio",name: "status",value: "0",label: "Todos"},
									{type: "button", value: 'Ver reporte', name:'Submit', inputLeft :150},
									{type: "button", value: 'Reporte productividad', name:'Productividad', inputLeft :150}
							];
							
							var form_reports = cell_2.attachForm(search_car);
							form_reports.getSelect("dependency_id").options.add(new Option("TODOS", "ALL"));
							form_reports.getSelect("mechanic_assigned").options.add(new Option("TODOS", "ALL"));
							
							
							var toolbar_export = cell_3.attachToolbar();
							toolbar_export.setIconsPath("menu/imgs/");
							toolbar_export.addSeparator('sep_pagging', 1);
							toolbar_export.addButton('btn_export',2,'Exportar a excel','success_icon.gif','success_icon.gif');
							toolbar_export.addSeparator('sep_pagging3',3);
							
							//GRID reports
							var grid = cell_3.attachGrid();
							grid.setHeader("Dependencia, Area,Folio, Marca, Tipo,Placas,Entrada,Reparaci������n,Mecanico,Seguimiento,Fecha de asignaci������n, Torre");
							grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
							grid.setInitWidths("100,60,50,60,60,60,60,180,100,180,80,80,*");
							grid.enableMultiline(true);
							//grid.setColTypes("txt");
							//grid.loadXML("ajax/grids/grid_folios.php");
							grid.init();
							
							
							form_reports.attachEvent("onButtonClick", function(id) {								
								var dependency = form_reports.getItemValue("dependency_id");
								var date_init = form_reports.getItemValue("date_init",true);
								var dhxCalendar_init = form_reports.getCalendar("date_init");
								var date_final = form_reports.getItemValue("date_final", true);
								var dhxCalendar_final = form_reports.getCalendar("date_final");
								var mechanic_id = form_reports.getItemValue("mechanic_assigned");
								var status = form_reports.getItemValue("status");
								
								if (id == "Productividad") {
								    
                                    window.open("ajax/grids/report_productivity.php", "_blank");
								    //grid.clearAll();
								    //grid.loadXML("ajax/grids/report_productivity.php");
							        							
							        }else{
								
								
								if(!date_init){ alert("Favor de establecer la fecha de inicio"); dhxCalendar_init.show(); form_reports.setItemFocus("date_init"); return false; }
								if(!date_final){ alert("Favor de establecer la fecha final"); dhxCalendar_final.show(); form_reports.setItemFocus("date_final"); return false; }								
								
								
																
								grid.clearAll();
								grid.loadXML("ajax/grids/grid_reports.php?dependency="+dependency+"&status="+status+"&mechanic_id="+mechanic_id+"&date_init="+date_init+"&date_final="+date_final);
							
								}
							});
							
							form_reports.attachEvent("onEnter", function(){						
								var dependency = form_reports.getItemValue("dependency_id");
								var date_init = form_reports.getItemValue("date_init",true);
								var dhxCalendar_init = form_reports.getCalendar("date_init");
								var date_final = form_reports.getItemValue("date_final", true);
								var dhxCalendar_final = form_reports.getCalendar("date_final");
								var mechanic_id = form_reports.getItemValue("mechanic_assigned");
								if(!date_init){ alert("Favor de establecer la fecha de inicio"); dhxCalendar_init.show(); form_reports.setItemFocus("date_init"); return false; }
								if(!date_final){ alert("Favor de establecer la fecha final"); dhxCalendar_final.show(); form_reports.setItemFocus("date_final"); return false; }								
								
								grid.clearAll();
								grid.loadXML("ajax/grids/grid_reports.php?dependency="+dependency+"&mechanic_id="+mechanic_id+"&date_init="+date_init+"&date_final="+date_final);
							});

							toolbar_export.attachEvent("onClick", function(id){
								if(id == "btn_export"){
									grid.toExcel('ajax/grid-excel-php/generate.php'); 
								}
							});
							
							
						}
						
						//formfolio = null;
						//tab nuevo
						 if(id == "a3"){					 
						 
							//formfolio.clear();
							//dhxAccord.openItem("a1");
							// inicio --- Tab Nuevo --
							var dhxAccord = tabbar.cells("a3").attachAccordion();
							var win1 = dhxAccord.addItem("a1", "Formulario");
							dhxAccord.cells("a1").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/form.gif");
							var win2 = dhxAccord.addItem("a2", "Inventario");
							dhxAccord.cells("a2").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/grid.gif");
							var win3 = dhxAccord.addItem("a3", "Formatos Digitales");
							dhxAccord.cells("a3").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/pdf.gif");

							dhxAccord.setEffect(true);				
					
							formfolio = dhxAccord.cells("a1").attachForm(new_folio);
							dhxAccord.openItem("a1");
							formfolio.clear();
							//Cargar selects dependientes
							formfolio.attachEvent("onChange", function (id, value){
								if(id=="support_brand_vehicular_id"){
									cargarselect(value,"support_models_vehicular_id","ajax/grids/select_models.php",formfolio);
								}								
								if(id=="dependency_id"){
									cargarselect(value,"contract_id","ajax/grids/select_contracts.php",formfolio);
								}
							});	
							
							var coomplete = formfolio.getCombo("activities");
							coomplete.enableFilteringMode(true, "ajax/search_activities.php", true, true);
							//Limpiar PLACA, TORRE, CAJON
							var inp_reg_plate = formfolio.getInput("registration_plate");
							inp_reg_plate.addEventListener("blur", function doOnBlur(e) {								
								var reg_plate = formfolio.getItemValue("registration_plate");
									reg_plate = cleanString(reg_plate);				
									formfolio.setItemValue("registration_plate",reg_plate);		
							}, false);
							
							var cajon = formfolio.getInput("parking_space");
							cajon.addEventListener("blur", function doOnBlur(e) {								
								var cajon = formfolio.getItemValue("parking_space");
									cajon = cleanString(cajon);				
									formfolio.setItemValue("parking_space",cajon);		
							}, false);
							
							var torre = formfolio.getInput("tower");
							torre.addEventListener("blur", function doOnBlur(e) {								
								var torre = formfolio.getItemValue("tower");
									torre = cleanString(torre);				
									formfolio.setItemValue("tower",torre);		
							}, false);
							
							/****************************
								Limpia String
								Params: string
							****************************/
							function cleanString(string){
								string = string.replace("--","");
								string = string.replace("-","");
								string = string.replace(/\s\ /g, "");
								string = string.toUpperCase();
								return string;
							}
							
							/****************************
								cargar select asociativos
								Params: id(Select), value(valor), selectdestino, urlajax
							****************************/
							var cargarselect = function (value,selectdestino, url,form) {
											var params = 'id='+value;	
											dhtmlxAjax.post(url,params, function(loader){																											
													if(loader.xmlDoc.responseText){											
														var someItem = form.getSelect(selectdestino);											
														someItem.outerHTML = loader.xmlDoc.responseText;
													}
											});	
							}
							
							function obtenervalores(objName)
							{  
								var arr = new Array(); var valores = new Array();
								arr = document.getElementsByName(objName);
								for(var i = 0; i < arr.length; i++)
								{
									var obj = document.getElementsByName(objName).item(i);
									valores[i] = obj.value;									
								}
								return valores;
							}
							
							var folio_id = "";
							formfolio.attachEvent("onButtonClick", function(id) {
								
							
								//Agregar nuevo input de servicios a realizar
								/*
								if(id == "add_activity"){
									var input = formfolio.getInput("activities");									
									var padre = input.parentNode.parentNode; var padress = padre.parentNode;																										
									var clone = padre.cloneNode(true); clone.childNodes[1].childNodes[0].value = "";//Limpia input clon						
									clone.childNodes[0].childNodes[0].innerHTML = obtenervalores("activities").length+1;//Label clon
									padress.appendChild(clone);
								}*/
								
								if(id == "add_activity"){
									var jj = $( ".activs .dhxform_control" ).attr( "id", "actividad" );
									var z=new dhtmlXCombo("actividad","activities",290);																		
									z.enableFilteringMode(true, "ajax/search_activities.php", true, true);
									$( "#actividad .dhx_combo_box" ).css('margin-top','5px');
									$( "#actividad .dhx_combo_box" ).css('margin-left','5px');
								}
								
								if(id == "reset"){									
									formfolio.clear();
									
								}
								//Load form data by register plate
								if(id == "search_regis_plate"){	
									var placa = formfolio.getItemValue("registration_plate");	
									formfolio.load("ajax/grids/search_by_registracion_plate.php?id="+placa,function(id, response){
										var id_brand = formfolio.getItemValue("support_brand_vehicular_id");										
										cargarselect(id_brand,"support_models_vehicular_id","ajax/grids/select_models.php",formfolio);	
									});								
																
								}
								
								//guardar Desktop
								if (id == "guardar") {
									formfolio.setItemValue("type_capture", "0");
									var serviciosarealizar = encodeURI(obtenervalores("activities"));
									formfolio.send("ajax/ajaxFolio.php?action=add&act="+serviciosarealizar, function(loader, response) {
										var objJSON = eval("(function(){return " + response + ";})()");
										if(objJSON.return == "1"){
											isTabinventoryOpen = true;											
											folio_id = objJSON.data.folio_id;
											stocktaking[2].list[0].url = "ajax/upload_images.php?folio_id="+folio_id;																
											dhxAccord.cells("a2").open();
											
												var form_inventario = dhxAccord.cells("a2").attachForm(stocktaking);
												var inp = form_inventario.doWithItem("fuel_level", "getInput");
												//Slider de gasolina
												var slider =new dhtmlxSlider("sliderBox", 200);
												slider.setSkin("dhx_skyblue");
												slider.setImagePath("dhtmlxLibrary/dhtmlxSlider/codebase/imgs/");
												slider.linkTo(inp);
												slider.init();
												
												form_inventario.attachEvent("onButtonClick", function(id) {
													if (id == "guardar") { 
														dhtmlx.message({id:"msg_save_inv",text: "Guardando informacion del Inventario y generando formato PDF...",expire: -1})
														
														form_inventario.send("ajax/ajaxInventory.php?action=add&folio_id="+folio_id, function(loader, response) {
															var objJSON = eval("(function(){return " + response + ";})()");
															if(objJSON.return == "1"){
																isTabinventoryOpen = false;																
																dhtmlx.message.hide("msg_save_inv");								
																var urlpdf = "<?php echo PATH_MULTIMEDIA; ?>"+folio_id+"/pdf/"+folio_id+".pdf";
																dhxAccord.cells("a3").attachURL(urlpdf);
																dhxAccord.cells("a3").open();
															}else{
																dhtmlx.message({
																	id:"msg_save_inv_err",
																	type:"error",
																	text: "Ocurrio un error al guardar",
																	expire: 2000
																})
																console.log("erro:"+response);							
															}								
														});
													}					
													
												});
											

											
										}else{
											//console.log(response);
											alert("error:"+response);									
										}								
									});
								}

								//guardar IPAD
								if (id == "guardarIPAD") {
									formfolio.setItemValue("type_capture", "1");
									//var m = formfolio.getItemValue("type_capture");
									var serviciosarealizar = encodeURI(obtenervalores("activities"));
									formfolio.send("ajax/ajaxFolio.php?action=add&act="+serviciosarealizar, function(loader, response) {
										var objJSON = eval("(function(){return " + response + ";})()");
										if(objJSON.return == "1"){
											//isTabinventoryOpen = true;											
											folio_id = objJSON.data.folio_id;
											//stocktaking[2].list[0].url = "ajax/upload_images.php?folio_id="+folio_id;																                                         
											dhtmlx.message({id:"msg_save_IPAD",text: "Registro almacenado correctamente con el folio "+ folio_id,expire: -1})
                                            formfolio.clear();											
										}else{
											//console.log(response);
											alert("error:"+response);									
										}
									});
								}								
								
							});//Fin Tab Nuevo
							
							
							
						}
						
						if(last_id == "a3"){
							  formfolio.clear();
							  formfolio = null;
						}
						
						// Validate if inventory tab is open
						if(!isTabinventoryOpen){
							return true;
						}else{
							dhtmlx.alert({id:"msg_opened_inv",
								type:"alert-warning",
								title:"Alerta, favor de concluir el proceso actual",
								text: "Debe concluir el proceso que est������ realizando, no concluirlo podr������a ocasionar problemas en el Sistema",
								expire: 2000
							})
							return false;
						}
						
					});
					
					
					/******* Tab - Alertas *********
					var layout_alertas = tabbar.cells("a1").attachLayout("2U");
					var cell_alerta_grid = layout_alertas.cells('a');
					cell_alerta_grid.setWidth('400');
					cell_alerta_grid.hideHeader();
					
					var grid_alertas = cell_alerta_grid.attachGrid();
					grid_alertas.setHeader("Folio, Accion, Fecha de Ingreso");
					grid_alertas.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
					
					grid_alertas.setInitWidths("80,250,*");
					grid_alertas.setColTypes("ed,ed,ed");
					grid_alertas.init();
					grid_alertas.loadXML("./dhtmlxLibrary/dhtmlxGrid/samples/common/grid.xml");					
					
					var cell_alerta_ajax = layout_alertas.cells('b');
					cell_alerta_ajax.hideHeader();		
					*/					
					// *******  Tab - Search **********
					var layout = tabbar.cells("a2").attachLayout("3U");
			
					//Incluimos formularios busquedas
					var cell_2 = layout.cells('a');
					cell_2.fixSize(0,0);
					cell_2.setWidth('390');
					cell_2.setHeight('150');
					cell_2.hideHeader();
					
					var cell_3 = layout.cells('b');
					cell_3.hideHeader();
					
					var cell_4 = layout.cells('c');
					cell_4.setText('Resultados');
					layout.cells('c').collapse();
					//cell_4.hideHeader();
					
					
					var form_busqueda = cell_2.attachForm(search_car);
					var session_group = <?php echo $session_group; ?>;
					
					var toolbar_folios = cell_3.attachToolbar();
					toolbar_folios.setIconsPath("menu/imgs/");
					toolbar_folios.addSeparator('sep_pagging', 1);
					toolbar_folios.addButton('btn_refresh',2,'Actualizar','refresh.png','refresh.png');
					toolbar_folios.addSeparator('sep_pagging3',3);					
					toolbar_folios.addButton('btn_edit',4,'Editar','settings.gif','settings.gif');
					toolbar_folios.addButton('btn_entregar',5,'Entregar/Cerrar','success_icon.gif','success_icon.gif');
					toolbar_folios.addButton('btn_activar',6,'Reactivar','redo.gif','success_icon.gif');
					toolbar_folios.addButton('btn_cancelar',7,'Cancelar','delete.png','delete.png');
					if( session_group != 5 ){
							toolbar_folios.removeItem('btn_cancelar');
							toolbar_folios.removeItem('btn_activar');
					}
										
					//Tab Busqueda
					var grid = cell_3.attachGrid();
					grid.setHeader("Folio, Placa, Dependencia,Actividades a realizar,Fecha de Ingreso,No. de Requisicion");
					grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
					grid.setInitWidths("80,80,200,350,*");
					grid.setColTypes("dyn,ed,ed,ed,ed,ed,txt");
					grid.enableMultiline(true);
					grid.loadXML("ajax/grids/grid_folios.php");
					grid.init();
					
					toolbar_folios.attachEvent("onClick", function(id){ 
						if(id == "btn_refresh"){ 
							grid.clearAll();
							grid.loadXML("ajax/grids/grid_folios.php?"+Math.random()); 
							layout.cells('c').collapse();								
						}
						
						// Btn reactivar 
						if (id == "btn_activar") {
							var idfol = grid.getSelectedId();
							if(idfol == null){
								alert('Es necesario seleccionar el folio que deseas reactivar');
							}else{
								if( confirm("������Est������ seguro que deseas reactivar el folio: "+idfol+" ?") ){
									var params = 'folio_id='+idfol+"&action=activate";	
									dhtmlxAjax.post("./ajax/update_folio.php", params, function(loader){						
										if(loader.xmlDoc.responseText){
											var json_return = loader.xmlDoc.responseText;											
											if(JSON.parse(json_return)){
												var json = JSON.parse(json_return);
												alert(json.data);
												grid.clearAll();
												grid.loadXML("ajax/grids/grid_folios.php?"+Math.random()); 
												layout.cells('c').collapse();	
											
											}else{
												alert("Ocurrio un problema al realizar la operacion"); 
											}
											
											
										}
									
									});
								
								}
							
							}
						}
						
						
						if(id == "btn_entregar"){
							var idfol = grid.getSelectedId();
							if(idfol == null){
								alert('Es necesario seleccionar un folio para cerrar');
							}else{
								var estaseguro=confirm("Est������ seguro de cerrar el folio:"+idfol);
								if (estaseguro==true){
									var params = 'folio_id='+idfol+"&action=delivery";	
									dhtmlxAjax.post("./ajax/update_folio.php", params, function(loader){						
										if(loader.xmlDoc.responseText){
											var json_return = loader.xmlDoc.responseText;											
											if(JSON.parse(json_return)){
												var json = JSON.parse(json_return);
												alert(json.data); 
											}else{
												alert("Ocurrio un problema al realizar la operacion"); 
											}
											
											
										}
									
									});
								}
							}
						}
						if(id == "btn_cancelar"){
							var idfol = grid.getSelectedId();
							if(idfol == null){
								alert('Es necesario seleccionar un folio para realizar la cancelaci������n');
							}else{
								var estaseguro=confirm("Est������ seguro de cancelar el folio:"+idfol);
								if (estaseguro==true){
									var params = 'folio_id='+idfol+"&action=cancel";	
									dhtmlxAjax.post("./ajax/update_folio.php", params, function(loader){						
										if(loader.xmlDoc.responseText){
											var json_return = loader.xmlDoc.responseText;											
											if(JSON.parse(json_return)){
												var json = JSON.parse(json_return);
												alert(json.data); 
											}else{
												alert("Ocurrio un problema al realizar la operacion"); 
											}
											
											
										}
									
									});
								}
							}
							
						}
						
						
						if(id == "btn_edit"){
								
						
						
								$("#activi").empty();
								$( ".activs" ).each(function( index ) {
									$(this).empty();								  
								});
								var idfol = grid.getSelectedId();

								if(idfol == null){
									alert('Es necesario seleccionar un elemento para poder editar');
								}else{
									var idwindowfolio = 'window-editfolio';
									var dhxWinsFolio= new dhtmlXWindows();
									dhxWinsFolio.setSkin("dhx_skyblue");
									dhxWinsFolio.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
									var win = dhxWinsFolio.createWindow(idwindowfolio, 50, 50, 1200, 1200);						
									dhxWinsFolio.window(idwindowfolio).setText("Edici������n de Folio");
									dhxWinsFolio.window(idwindowfolio).centerOnScreen();
									
									
									tabbar_detail = win.attachTabbar();
									tabbar_detail.setSkin("dhx_skyblue");
									tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
									tabbar_detail.addTab("_fol", "Folio", "120px");
									tabbar_detail.addTab("_inv", "Inventario", "120px");
									tabbar_detail.addTab("_pdf", "PDF", "120px");
									tabbar_detail.setTabActive("_fol");
									
									
									//load forms tructure
									var tab_formfolio = tabbar_detail.cells("_fol").attachForm(new_folio);
									var tab_forminv = tabbar_detail.cells("_inv").attachForm(stocktaking);
									//on close windows
									dhxWinsFolio.attachEvent("onClose", function(win){
										// code here
										dhxWinsFolio.unload();
										dhxWinsFolio = null;
										tab_formfolio.unload();
										tab_formfolio = null;
										//tabbar_detail.clearAll();
										//dhxWinsFolio.window(idwindowfolio).close();
									});

									var inp = tab_forminv.doWithItem("fuel_level", "getInput");
									//Slider de gasolina
									var slider =new dhtmlxSlider("sliderBox", 200);
									slider.setSkin("dhx_skyblue");
									slider.setImagePath("dhtmlxLibrary/dhtmlxSlider/codebase/imgs/");
									slider.linkTo(inp);
									slider.init();
									
									
									
									tab_formfolio.load("ajax/grids/search_by_folio.php?id="+idfol,function(id, response){									
										var model_id = dhtmlxAjax.getSync("ajax/grids/search_by_folio.php?getmodel=true&id="+idfol);
										model_id = model_id.xmlDoc.responseText;
										var dependency_id = tab_formfolio.getItemValue("dependency_id");									
										var selectscontracts = dhtmlxAjax.getSync("ajax/grids/select_contracts.php?id="+dependency_id);
										var someItem = tab_formfolio.getSelect("contract_id");
										someItem.outerHTML = selectscontracts.xmlDoc.responseText;								
										
										var contract_id = dhtmlxAjax.getSync("ajax/grids/search_by_folio.php?getcontract=true&id="+idfol);									
										tab_formfolio.setItemValue("contract_id",contract_id.xmlDoc.responseText);
										
										// Elementos tipo de combustible
										var tipo_de_gasolina = dhtmlxAjax.getSync("ajax/grids/search_by_folio.php?getfuel=true&id="+idfol);
										tab_formfolio.setItemValue("fuel",tipo_de_gasolina.xmlDoc.responseText);
										
										
										
										var cargarmodelos = function (value,selectdestino, url,form) {
														var params = 'id='+value;	
														dhtmlxAjax.post(url,params, function(loader){																											
																if(loader.xmlDoc.responseText){											
																	var someItem = form.getSelect(selectdestino);											
																	someItem.outerHTML = loader.xmlDoc.responseText;
																	tab_formfolio.setItemValue("support_models_vehicular_id",model_id);
																}
														});	
										}
										
										//Al cargar select								
										var id_brand = tab_formfolio.getItemValue("support_brand_vehicular_id");	
										//console.log(id_brand);
										cargarmodelos(id_brand,"support_models_vehicular_id","ajax/grids/select_models.php",tab_formfolio);
										
										
							    
		
										//Activar autocomplete
										var coomplete = tab_formfolio.getCombo("activities");
										coomplete.enableFilteringMode(true, "ajax/search_activities.php", true, true);
										
										var jj = $( ".activs .dhxform_control" ).attr( "id", "activi" );
										
										var activitiesarray = dhtmlxAjax.getSync("ajax/get_activitiesbyfolio.php?id="+idfol);
										
										if(activitiesarray.xmlDoc.responseText){
											var obj = jQuery.parseJSON(activitiesarray.xmlDoc.responseText);
											
											$.each(obj, function(i, item) {
												$('#activi').prepend('<input type="text" disabled="true" value="'+item.description+'" style="width: 290px;" /><input type="button" value="-" onclick="deleteActivity('+item.floor_activity_id+')"><br>');											
											});
										}	
										
										
									});	
									
									function obtenervalores(objName)
										{  
											var arr = new Array(); var valores = new Array();
											arr = document.getElementsByName(objName);
											for(var i = 0; i < arr.length; i++)
											{
												var obj = document.getElementsByName(objName).item(i);
												valores[i] = obj.value;									
											}
											return valores;
										}
									/****************************
									cargar select asociativos
									Params: id(Select), value(valor), selectdestino, urlajax
									****************************/
									var cargarselect = function (value,selectdestino, url,form) {
													var params = 'id='+value;	
													dhtmlxAjax.post(url,params, function(loader){																											
															if(loader.xmlDoc.responseText){											
																var someItem = form.getSelect(selectdestino);											
																someItem.outerHTML = loader.xmlDoc.responseText;
															}
													});	
									}
									
									
									
									//Cargar selects dependientes
									tab_formfolio.attachEvent("onChange", function (id, value){
										if(id=="support_brand_vehicular_id"){
											cargarselect(value,"support_models_vehicular_id","ajax/grids/select_models.php",tab_formfolio);
										}								
										if(id=="dependency_id"){
											cargarselect(value,"contract_id","ajax/grids/select_contracts.php",tab_formfolio);
										}
									});
								
									tabbar_detail.attachEvent("onSelect", function(id,last_id){
											if(id=="_inv"){
												
												//Load data form inventory
												tab_forminv.load("ajax/grids/search_inventory.php?type=folio_id&id="+idfol);
												//Set value Fuel level
												var fuel_val = tab_forminv.getItemValue("fuel_level");
												slider.setValue(fuel_val);										
											}
											if(id=="_pdf"){
												//Set value Fuel level
												var urlpdf = "<?php echo PATH_MULTIMEDIA ?>"+idfol+"/pdf/"+idfol+".pdf";
												tabbar_detail.cells("_pdf").attachURL(urlpdf);											
											}
											
										  return true;									  
									  });								  
									
									tab_formfolio.hideItem("fieldsetservices");
									tab_formfolio.hideItem("reset");
									
									//Guardar datos de folio
									tab_formfolio.attachEvent("onButtonClick", function(id) {
										//add activity en editar
										if(id == "add_activity"){																			
											
											var dcombo=new dhtmlXCombo("activi","activities",290);																		
											dcombo.enableFilteringMode(true, "ajax/search_activities.php", true, true);
											$( "#activi .dhx_combo_box" ).css('margin-top','5px');
											$( "#activi .dhx_combo_box" ).css('margin-left','0px');
										}
										
										if (id == "guardar") {	
											var serviciosarealizar = encodeURI(obtenervalores("activities"));
											dhtmlx.message({id:"msg_save_inv",text: "Guardando informaci������n del Folio y generando formato PDF...",expire: -1})
											tab_formfolio.send("ajax/update_folio.php?action=update&act="+serviciosarealizar, function(loader, response) {
												
												var objJSON = eval("(function(){return " + response + ";})()");
												if(objJSON.return == 1){
													dhtmlx.alert({
														title:"Datos actualizados",
														type:"alert",
														text:"Los datos fueron guardados correctamente"
													});
													dhtmlx.message.hide("msg_save_inv");											
												}else{
													dhtmlx.alert({
														title:"Error",
														type:"alert",
														text:"Ocurri������ un error a guardar los datos, Recarge la aplicaci������n y revise nuevamente"
													});
												}
												
											});
										}
									});
									tab_forminv.attachEvent("onButtonClick", function(id) {
										if (id == "guardar") {								
											dhtmlx.message({id:"msg_save_inv",text: "Guardando informaci������n del inventario y generando formato PDF...",expire: -1})
											tab_forminv.send("ajax/update_inventory.php?action=update&folio_id="+idfol, function(loader, response) {
												
												var objJSON = eval("(function(){return " + response + ";})()");
												if(objJSON.return == 1){
													dhtmlx.alert({
														title:"Datos actualizados",
														type:"alert",
														text:"Los datos fueron guardados correctamente"
													});
													dhtmlx.message.hide("msg_save_inv");											
												}else{
													dhtmlx.alert({
														title:"Error",
														type:"alert",
														text:"Ocurri������ un error a guardar los datos, Recarge la aplicaci������n y revise nuevamente"
													});
												}
												
											});
										}
									});
									/*
									tab_formfolio.attachEvent("onButtonClick", function(id) {
										console.log(id);
										//Funcion auxiliar secundario
										function obtenervalores(objName)
										{  
											var arr = new Array(); var valores = new Array();
											arr = document.getElementsByName(objName);
											for(var i = 0; i < arr.length; i++)
											{
												var obj = document.getElementsByName(objName).item(i);
												valores[i] = obj.value;									
											}
											return valores;
										}
										if(id == "add_activity"){										
											console.log(id); 
											var input = formfolio.getInput("activities");																			
											var padre = input.parentNode.parentNode; var padress = padre.parentNode;																										
											var clone = padre.cloneNode(true); clone.childNodes[1].childNodes[0].value = "";//Limpia input clon						
											clone.childNodes[0].childNodes[0].innerHTML = obtenervalores("activities").length+1;//Label clon
											console.log(clone);
											console.log(padress);
											padress.appendChild(clone);
										}
									});*/
							
								}
						}
							
					});
						
					grid.attachEvent("onRowDblClicked", function(idfol,cInd){
						
						
					});
						
						
					//Evento doble click en el row
						grid.attachEvent("onRowSelect", function(id,cInd){
							
							folio = id;
							layout.cells('c').expand();
							var ajaxDatosGenerales = "./ajax/tab_datos_generales.php?id=" + id.toString() ;
							var ajaxFormatosDigitales = "./ajax/tab_formatos_digitales.php?id=" + id.toString() ;
							var ajaxGantt = "./ajax/gantt/activities_iframe.php?tab_height="+tabbs_system_height+'&folio='+folio.toString();
							
							tabbar_detail = cell_4.attachTabbar();
							tabbar_detail.setSkin("dhx_skyblue");
							tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
							tabbar_detail.setHrefMode("ajax-html");
							
							
							//****** TAB DATOS GENERALES **************
							tabbar_detail.addTab("tab1", "Datos Generales", "120px");
							//tabbar_detail.setContentHref("tab1",ajaxDatosGenerales);
							var layout_general_data = tabbar_detail.cells("tab1").attachLayout("4T");													
							layout_general_data.cells("a").setHeight(160);	
							layout_general_data.cells("a").hideHeader();
							layout_general_data.cells("a").attachURL("./ajax/tab_datos_generales.php?get=general&id=" + id.toString());							
							layout_general_data.cells("b").setHeight(310);
							layout_general_data.cells("b").setText("Cliente");
							layout_general_data.cells("b").attachURL("./ajax/tab_datos_generales.php?get=client&id=" + id.toString());
							layout_general_data.cells("c").setHeight(310);
							layout_general_data.cells("c").setText("Vehiculo");
							layout_general_data.cells("c").attachURL("./ajax/tab_datos_generales.php?get=vehicle&id=" + id.toString());
							layout_general_data.cells("d").setHeight(310);
							layout_general_data.cells("d").setText("Inventario");
							layout_general_data.cells("d").attachURL("./ajax/tab_datos_generales.php?get=inventory&id=" + id.toString());
							
							//****** TAB DOCUMENTOS MULTIMEDIA **************
							tabbar_detail.addTab("tab2", "Documentos Multimedia", "180px");
							// Insert a file browser
							var layout_file_browser = tabbar_detail.cells("tab2").attachLayout("2U");
							var cell_folder = layout_file_browser.cells('a');
							cell_folder.setText('Folders');
							cell_folder.setWidth('250');
							
							var cell_view = layout_file_browser.cells('b');
							cell_view.hideHeader();
							//Attach tree view
							dhxTree_folder = layout_file_browser.cells("a").attachTree();
							dhxTree_folder.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
							dhxTree_folder.loadXML("ajax/file_browser/load_tree.php?folio_id="+id);							var folio_id = id;
							dhxTree_folder.setOnClickHandler(function(id){
								
								var str =id;
								var node =str.substr(0,6);
								if(node != 'folder' && node != 'root'){									
									layout_file_browser.cells("b").attachURL("./ajax/file_browser/load_elements.php?folio_id="+folio_id+"&file="+id.toString());
								}
								
							});
							
							//****** TAB ACTIVIDADES **************
							tabbar_detail.addTab("tab3", "Actividades", "100px");
							tabbar_detail.setContentHref("tab3",ajaxGantt);							
							tabbar.enableAutoReSize(true);
							
							//****** TAB REQUISICIONES **************
							tabbar_detail.addTab("tab4", "Requisiciones", "100px");
							// Attach tree grid
							var layout_requisiciones = tabbar_detail.cells("tab4").attachLayout("2U");
							var cell_tree_requisiciones = layout_requisiciones.cells('a');
							cell_tree_requisiciones.setText('Solicitudes');
							cell_tree_requisiciones.setWidth('250');
							
							var cell_view_requisiciones = layout_requisiciones.cells('b');
							cell_view_requisiciones.hideHeader();
							
							// Attach tree view
							dhxTree_requisiciones = layout_requisiciones.cells("a").attachTree();
							dhxTree_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
							dhxTree_requisiciones.loadXML("./ajax/view-system.tabstock.tree.php?folio="+folio);
							dhxTree_requisiciones.setOnClickHandler(function(id){
								
								if(id != 'root'){
									
									id = id.split('-');
									var stock_id = id[0]; 
									var folio = id[1];
									
									//tree_id_value = id;
									var grid_requisiciones = cell_view_requisiciones.attachGrid();
									grid_requisiciones.setHeader("Material, Cantidad, Solicita, Autoriza, Status,Fecha de Modificacion,Comentarios");
									grid_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
									grid_requisiciones.setInitWidths("250,60,120,100,80,*");
									grid_requisiciones.setColTypes("ed,ed,ed,ed,ed,ed,ed");
									grid_requisiciones.init();
									grid_requisiciones.loadXML("./ajax/view-stock.stock.grid.php?id="+stock_id);
									
									
								}
								
								
							}); 
										
							//****** TAB AMPLIACIONES **************
														
							tabbar_detail.addTab("tab5", "Ampliaciones", "100px");
							
							//Tab ampliaciones
							var tabbar_ampli = tabbar_detail.cells("tab5").attachTabbar();
							tabbar_ampli.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
							tabbar_ampli.addTab("tab_ampl", "Ampliaciones", "100px");
							tabbar_ampli.addTab("tab_new_ampl", "Nueva ampliaci������n", "130px");							
							tabbar_ampli.setTabActive("tab_ampl");
							//List ampliaciones
							var grid_ampl = tabbar_ampli.cells("tab_ampl").attachGrid();
							grid_ampl.setHeader("ID,Mensaje,Comentarios,Fecha de env������o,Fecha de Autorizaci������n, Autorizado por, status"); //De,Para,
							grid_ampl.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
							grid_ampl.setInitWidths("50,400,300,120,*");							
							grid_ampl.init();
							grid_ampl.loadXML("ajax/grids/grid_extends.php?type=folio_id&id="+folio);
							
							//Formulario Editar ampliacion
							grid_ampl.attachEvent("onRowDblClicked", function(rId,cInd){
									var idwindow_ampl = 'form_ampl';
									var dhxWins= new dhtmlXWindows(); 					
									dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
									var win = dhxWins.createWindow(idwindow_ampl, 50, 50, 730, 490);
									dhxWins.window(idwindow_ampl).centerOnScreen(); 
									dhxWins.window(idwindow_ampl).setText("Ampliaciones");
									dhxWins.window(idwindow_ampl).setModal(true);
									tabbar_detail = win.attachTabbar();					
									tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
									tabbar_detail.addTab("us1", "Ampliaciones", "120px");							 
									tabbar_detail.setTabActive("us1");
									
									// Add form to componenet
									var form_ampliaciones = tabbar_detail.cells("us1").attachForm(new_enlargement);
									form_ampliaciones.hideItem("enviar");
									form_ampliaciones.disableItem("message");
									//form_ampliaciones.showItem("approved_by");
									//form_ampliaciones.showItem("vobo");
									
									form_ampliaciones.enableItem("status");
									form_ampliaciones.setItemLabel("fieldset_title", "Editar Ampliaci������n");
									form_ampliaciones.load('./ajax/ajaxExtends.php?action=get&id='+rId);
									
											
									// Boton guardar/cancelar 
									form_ampliaciones.attachEvent("onButtonClick", function(id) {							
										if(id =="cancelar"){
											dhxWins.window(idwindow_ampl).close();
										}
										if(id =="guardar"){
											form_ampliaciones.send('./ajax/ajaxExtends.php?action=update&id='+rId, function(loader, response) {												
												var json = JSON.parse(response);
												if(json.return == "1"){
													grid_ampl.updateFromXML("ajax/grids/grid_extends.php?type=folio_id&id="+folio);
													dhtmlx.alert({
														title:"Datos guardados",
														type:"alert",
														text:"Datos guardados correctamente"
													});
													dhxWins.window(idwindow_ampl).close();
												}else{
													dhtmlx.alert({
														title:"Error!",
														type:"alert",
														text:"Hubo un error al tratar de guardar los datos en la BD"
													});
												}
											});
										}
														
									});		
							
							
							});
									
							
							// Form nueva ampliaci������n
								var formnew_empl = tabbar_ampli.cells("tab_new_ampl").attachForm(new_enlargement);
								formnew_empl.hideItem("comments");
								formnew_empl.hideItem("guardar");
								formnew_empl.hideItem("approved_by");
								formnew_empl.hideItem("vobo");
								var params = 'id='+id;	
								//Carga de emails al formulario de ampliaciones
								dhtmlxAjax.post("./ajax/grids/select_emails.php", params, function(loader){	
										if(loader.xmlDoc.responseText){										
											var json_return = loader.xmlDoc.responseText;
											var json = JSON.parse(json_return);
											formnew_empl.setItemValue("receiber",json.email1);										
											formnew_empl.setItemValue("cc",json.email2);
										}
								});
								
								//Enviar ampliacion
								formnew_empl.attachEvent("onButtonClick", function(id) {					
									if(id =="enviar"){
										formnew_empl.send('./ajax/ajaxExtends.php?action=sendmail&folio='+folio, function(loader, response) {										
											var result_mail  = JSON.parse(response);
											if(result_mail.return == "1"){
												grid_ampl.loadXML("ajax/grids/grid_extends.php?type=folio_id&id="+folio);
												dhtmlx.alert({
													title:"Mensaje enviado",
													type:"alert",
													text:"El mensaje fue enviado al destinatario"
												});
												formnew_empl.clear();
											}else{											
												dhtmlx.alert({
													title:"Error",
													type:"alert",
													text:result_mail.error
												});
											}										
										});
									}																					
								});
									
							
							tabbar_detail.addTab("tab6", "Calidad", "100px");
							// Insertamos cuadro layout
						  	var layout_quality_browser = tabbar_detail.cells("tab6").attachLayout("2U");
							var cell_quality_folder = layout_quality_browser.cells('a');
							cell_quality_folder.setText('Actividades');
							cell_quality_folder.setWidth('250');
							var cell_quality_view = layout_quality_browser.cells('b');
							cell_quality_view.hideHeader();
							
							// Insertamos arbol
							//Attach tree view
							var dhxTree_quality_folder = layout_quality_browser.cells("a").attachTree();
							dhxTree_quality_folder.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
							dhxTree_quality_folder.loadXML("./quality/tree.php?folio_id="+id);	
							
							dhxTree_quality_folder.setOnClickHandler(function(id){
							      var elementos = id.split('_');
							      var actividades_id	= elementos[0];
							      var cheklist_folio_id	= elementos[1];
							      
							      console.log(actividades_id);
							      console.log(cheklist_folio_id);
							      
							      var str =id;
							      var node =str.substr(0,6);
							      if(node != 'folder' && node != 'root'){									
								      layout_quality_browser.cells("b").attachURL("./quality/iframe_quality_details.php?cheklist_folio="+cheklist_folio_id+"&folio_id="+folio_id+"&activity_id="+actividades_id.toString());
							      }
							      
						      });
							
							
							
							tabbar_detail.addTab("tab7", "Historial", "100px");
							
							var ajaxHistory = "./views/log/log_details.php?folio_id="+folio;
							tabbar_detail.setContentHref("tab7",ajaxHistory);
							
							tabbar_detail.setTabActive('tab1');
							layout.cells("c").showHeader();
							//windowDetal(rId,'Prueba','tab2');
						});	
					
					//Onclick busqueda Folio
					form_busqueda.attachEvent("onButtonClick", function(id) {						
						var search_type = form_busqueda.getItemValue("selectBusqueda");
						var value = form_busqueda.getItemValue("txtValue");						
						grid.clearAll();
						grid.loadXML("ajax/grids/grid_folios.php?type="+search_type+"&id="+value);
					});	
					form_busqueda.attachEvent("onEnter", function(){						
						var search_type = form_busqueda.getItemValue("selectBusqueda");
						var value = form_busqueda.getItemValue("txtValue");						
						grid.clearAll();
						grid.loadXML("ajax/grids/grid_folios.php?type="+search_type+"&id="+value);
					});
					/*
					// --- Tab Nuevo --
					var dhxAccord = tabbar.cells("a3").attachAccordion();
					var win1 = dhxAccord.addItem("a1", "Formulario");
					dhxAccord.cells("a1").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/form.gif");
					var win2 = dhxAccord.addItem("a2", "Inventario");
					dhxAccord.cells("a2").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/grid.gif");
					var win3 = dhxAccord.addItem("a3", "Formatos Digitales");
					dhxAccord.cells("a3").setIcon("./dhtmlxLibrary/dhtmlxAccordion/icons/pdf.gif");

					dhxAccord.setEffect(true);				
					
							var formfolio = dhxAccord.cells("a1").attachForm(new_folio);
							dhxAccord.openItem("a1");						
							//Cargar selects dependientes
							formfolio.attachEvent("onChange", function (id, value){
								if(id=="support_brand_vehicular_id"){
									cargarselect(value,"support_models_vehicular_id","ajax/grids/select_models.php",formfolio);
								}								
								if(id=="dependency_id"){
									cargarselect(value,"contract_id","ajax/grids/select_contracts.php",formfolio);
								}
							});	
							
							var coomplete = formfolio.getCombo("activities");
							coomplete.enableFilteringMode(true, "ajax/search_activities.php", true, true);
							//Limpiar PLACA, TORRE, CAJON
							var inp_reg_plate = formfolio.getInput("registration_plate");
							inp_reg_plate.addEventListener("blur", function doOnBlur(e) {								
								var reg_plate = formfolio.getItemValue("registration_plate");
									reg_plate = cleanString(reg_plate);				
									formfolio.setItemValue("registration_plate",reg_plate);		
							}, false);
							
							var cajon = formfolio.getInput("parking_space");
							cajon.addEventListener("blur", function doOnBlur(e) {								
								var cajon = formfolio.getItemValue("parking_space");
									cajon = cleanString(cajon);				
									formfolio.setItemValue("parking_space",cajon);		
							}, false);
							
							var torre = formfolio.getInput("tower");
							torre.addEventListener("blur", function doOnBlur(e) {								
								var torre = formfolio.getItemValue("tower");
									torre = cleanString(torre);				
									formfolio.setItemValue("tower",torre);		
							}, false);
							
							//
							//	Limpia String
							//	Params: string
							//
							function cleanString(string){
								string = string.replace("--","");
								string = string.replace("-","");
								string = string.replace(/\s\ /g, "");
								string = string.toUpperCase();
								return string;
							}
							
							/****************************
							//	cargar select asociativos
							//	Params: id(Select), value(valor), selectdestino, urlajax
							//***************************
							var cargarselect = function (value,selectdestino, url,form) {
											var params = 'id='+value;	
											dhtmlxAjax.post(url,params, function(loader){																											
													if(loader.xmlDoc.responseText){											
														var someItem = form.getSelect(selectdestino);											
														someItem.outerHTML = loader.xmlDoc.responseText;
													}
											});	
							}
							
							function obtenervalores(objName)
							{  
								var arr = new Array(); var valores = new Array();
								arr = document.getElementsByName(objName);
								for(var i = 0; i < arr.length; i++)
								{
									var obj = document.getElementsByName(objName).item(i);
									valores[i] = obj.value;									
								}
								return valores;
							}
							
							var folio_id = "";
							formfolio.attachEvent("onButtonClick", function(id) {
								
							
								//Agregar nuevo input de servicios a realizar
							
								
								if(id == "add_activity"){
									var jj = $( ".activs .dhxform_control" ).attr( "id", "actividad" );
									var z=new dhtmlXCombo("actividad","activities",290);																		
									z.enableFilteringMode(true, "ajax/search_activities.php", true, true);
									$( "#actividad .dhx_combo_box" ).css('margin-top','5px');
									$( "#actividad .dhx_combo_box" ).css('margin-left','5px');
								}
								
								if(id == "reset"){									
									formfolio.clear();
									
								}
								//Load form data by register plate
								if(id == "search_regis_plate"){	
									var placa = formfolio.getItemValue("registration_plate");	
									formfolio.load("ajax/grids/search_by_registracion_plate.php?id="+placa,function(id, response){
										var id_brand = formfolio.getItemValue("support_brand_vehicular_id");										
										cargarselect(id_brand,"support_models_vehicular_id","ajax/grids/select_models.php",formfolio);	
									});								
																
								}
								
								if (id == "guardar") {
									
									var serviciosarealizar = encodeURI(obtenervalores("activities"));
									formfolio.send("ajax/ajaxFolio.php?action=add&act="+serviciosarealizar, function(loader, response) {
										var objJSON = eval("(function(){return " + response + ";})()");
										if(objJSON.return == "1"){
											isTabinventoryOpen = true;											
											folio_id = objJSON.data.folio_id;
											stocktaking[2].list[0].url = "ajax/upload_images.php?folio_id="+folio_id;																
											dhxAccord.cells("a2").open();
											
												var form_inventario = dhxAccord.cells("a2").attachForm(stocktaking);
												var inp = form_inventario.doWithItem("fuel_level", "getInput");
												//Slider de gasolina
												var slider =new dhtmlxSlider("sliderBox", 200);
												slider.setSkin("dhx_skyblue");
												slider.setImagePath("dhtmlxLibrary/dhtmlxSlider/codebase/imgs/");
												slider.linkTo(inp);
												slider.init();
												
												form_inventario.attachEvent("onButtonClick", function(id) {
													if (id == "guardar") { 
														dhtmlx.message({id:"msg_save_inv",text: "Guardando informaci������n del Inventario y generando formato PDF...",expire: -1})
														
														form_inventario.send("ajax/ajaxInventory.php?action=add&folio_id="+folio_id, function(loader, response) {
															var objJSON = eval("(function(){return " + response + ";})()");
															if(objJSON.return == "1"){
																isTabinventoryOpen = false;																
																dhtmlx.message.hide("msg_save_inv");								
																var urlpdf = "<?php echo PATH_MULTIMEDIA; ?>"+folio_id+"/pdf/"+folio_id+".pdf";
																dhxAccord.cells("a3").attachURL(urlpdf);
																dhxAccord.cells("a3").open();
															}else{
																dhtmlx.message({
																	id:"msg_save_inv_err",
																	type:"error",
																	text: "Ocurrio un error al guardar",
																	expire: 2000
																})
																console.log("erro:"+response);							
															}								
														});
													}					
													
												});
											

											
										}else{
											//console.log(response);
											alert("error:"+response);									
										}								
									});
								}					
								
							});*/
					
					
					
					
				};
				
				
				/****************************
					Views Preventivo
				****************************/
				var viewPreventivo = function(){
					
					//Agregamos un grid con detalles de preventivo
					grid = new dhtmlXGridObject('a_tabbar');
					grid.setHeader("Folio, Placa, Fecha de Ingreso,Dependencia,Mecanico,Verificacion,Afinacion,Lavado y Engrasado,Externo lavado y engrasado,Fecha de Salida");
					grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
					grid.setSkin('dhx_skyblue');
					grid.setInitWidths("80,80,*");
					grid.setColTypes("dyn,ed,ed,ed,ed,ed,ed,ed,ed,ed");
					grid.init();
					
					grid.loadXML("./dhtmlxLibrary/dhtmlxGrid/samples/common/grid.xml");
					
					//Evento doble click en el row
					grid.attachEvent("onRowDblClicked", function(rId,cInd){
						windowDetal(rId,'Prueba','tab2');
					});
					
				};
				
				/****************************
					Views Reports
				This view create the stock panel 
				- Layout
				- Tree
				****************************/
				var viewReports = function(){
				  
				    // Aqui desarrollamos la vista para reportes
					
				    
				}
				
				
				
				
				
				
				
				
				/****************************
					Views Stock
				This view create the stock panel 
				- Layout
				- Tree
				- Grid
				- Form
				****************************/
			
				var viewStock = function(){
					
					var tree_id_value 			= 0;
					var grid_id_value			= 0;
					var requisicion_id_value		= 0;
					// Attach Layout to element 'a_tabbar'

					
					tabbar_stock = new dhtmlXTabBar("a_tabbar", "top");
					tabbar_stock.setSkin('dhx_skyblue');
					tabbar_stock.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar_stock.addTab("a1", "Administrador", "100px");
					tabbar_stock.addTab("a2", "Material", "100px");
					tabbar_stock.setTabActive("a1");
					
					dhxLayoutStock = tabbar_stock.cells("a1").attachLayout("3L");
					
					// Modificamos elementos agregamos 3 tabs
					// Roberto Alarcon 15/09/13 
					// Viva Mexico
					
					dhxLayoutStock = tabbar_stock.cells("a1").attachLayout("2U");
					
					// Cell 1  = tree
					// Cell 2  = tabs
										
					// Agregamos boton Refresh
					var toolbar_treeRequisiciones = dhxLayoutStock.cells('a').attachToolbar();
					toolbar_treeRequisiciones.setIconsPath("menu/imgs/");
					toolbar_treeRequisiciones.addSeparator('sep_pagging', 1);
					toolbar_treeRequisiciones.addButton('btn_refresh_tree',2,'Actualizar','refresh.png','refresh.png');
					toolbar_treeRequisiciones.addSeparator('sep_pagging3',3);	
					toolbar_treeRequisiciones.addText("info_tree",4, "Folio:");
					toolbar_treeRequisiciones.addInput('input_tree',5,'',80);
					toolbar_treeRequisiciones.addButton('btn_buscar_tree',6,'Buscar');
					
										
					// Cell 2 Creamos nuestros tabs
					var tabbar_stock_detail = dhxLayoutStock.cells("b").attachTabbar();
					tabbar_stock_detail.setSkin('dhx_skyblue');
					tabbar_stock_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar_stock_detail.addTab("a1", "Solicitudes", "100px");
					tabbar_stock_detail.addTab("a2", "Mutimedia", "100px");
					tabbar_stock_detail.addTab("a3", "Requisicion Electronica", "150px");
					tabbar_stock_detail.setTabActive("a1");
					
					// Armamos arbol					
					var cell_browse = dhxLayoutStock.cells('a');
					var cell_view_requisiciones = dhxLayoutStock.cells('b');
					var cell_comments = dhxLayoutStock.cells('c');
					cell_view_requisiciones.setHeight('200');
					//dhxLayoutStock.cells('c').hideHeader();
					//dhxLayoutStock.cells('c').collapse();
					
					cell_browse.setWidth('280');
					
					
					cell_browse.setText('Requisiciones');
					cell_view_requisiciones.setText('Productos');
					
					
					dhxTree_requisiciones = dhxLayoutStock.cells("a").attachTree();
					dhxTree_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
					//dhxTree_requisiciones.loadXML("xml/view-stock.stock.treeFileBrowser.xml?str2="+Math.floor((Math.random()*100)+1).toString());
					dhxTree_requisiciones.loadXML("./ajax/view-stock.stockadmin.tree.php?str2="+Math.floor((Math.random()*100)+1).toString());
					
					
					// Controlamos eventos para el menu
					// Boton refrescar
					// Boton buscar
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
										//dhxTree_requisiciones.loadXML("./ajax/view-stock.stockadmin.tree.php?str2="+Math.floor((Math.random()*100)+1).toString());
										//dhxTree_requisiciones.loadXML("./ajax/view-stock.stock.grid.php?id="+folio_tree);
										dhxTree_requisiciones.loadXML("./ajax/view-system.tabstock.tree.php?folio="+folio_tree);
										
									}
									
									break;
								}
					
					});
					
					
					// Handle click event
					dhxTree_requisiciones.setOnClickHandler(function(id){
						console.log(id);
						var n = id.indexOf("-");
						if(id != 'root' && n != -1){

							id = id.split('-');
							var stock_id = id[0]; 
							var folio = id[1];
							
							
							// Cargamos Tab 1 - Solicitudes
							var layoutSolicitudes = tabbar_stock_detail.cells("a1").attachLayout("3E");
							var celda_info 		= layoutSolicitudes.cells('a');
							celda_info.setHeight('230');
							celda_info.setText("Datos del vehiculo");
							
							var celda_grid 		= layoutSolicitudes.cells('b');
							celda_grid.setHeight('200');
							//celda_grid.setText("Material");
							celda_grid.hideHeader();
							
							var celda_details 	= layoutSolicitudes.cells('c');
							celda_details.hideHeader();
							celda_details.collapse();
														
													
							
							
							
							// Cargamos Tab 2 - Multimedia
							var layoutMultimedia = tabbar_stock_detail.cells("a2").attachLayout("2U");
							var celda_tree_multimedia = layoutMultimedia.cells('a');
							celda_tree_multimedia.setWidth('220');
							celda_tree_multimedia.setText("Listado de imagenes");
							
							var celda_visor_multimedia = layoutMultimedia.cells('b');
							celda_visor_multimedia.hideHeader()
							
							//Attach tree view
							dhxTree_folder = celda_tree_multimedia.attachTree();
							dhxTree_folder.setImagePath("./dhtmlxLibrary/dhtmlxTree/codebase/imgs/");
							dhxTree_folder.loadXML("ajax/file_browser/load_tree.php?folio_id="+folio);							
							dhxTree_folder.setOnClickHandler(function(id){
								
								var str =id;
								var node =str.substr(0,6);
								if(node != 'folder' && node != 'root'){									
									celda_visor_multimedia.attachURL("./ajax/file_browser/load_elements.php?folio_id="+folio+"&file="+id.toString());
								}
								
							});
							
							
							;
							
							
							// Cargamos la informacion y datos del vehiculo
							//celda_info.attachURL("./ajax/tab_datos_generales.php?get=vehicle&id=" + folio.toString());
							celda_info.attachURL("./ajax/tab_datos_generales_stock.php?get=vehicle&id=" + folio.toString());
							
							
							var grid_requisiciones = celda_grid.attachGrid();
							//dhxLayoutStock.cells('c').collapse();
							grid_requisiciones.setHeader("Producto,Cantidad, Solicita,Autoriza,Status,Fecha de Modificacion,Comentarios");
							grid_requisiciones.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
							grid_requisiciones.setInitWidths("250,60,90,90,90,90,*");
							grid_requisiciones.setColTypes("ed,ed,ed,ed,ed,ed,ed");
							grid_requisiciones.init();
							grid_requisiciones.loadXML("./ajax/view-stock.stock.grid.php?id="+stock_id);
											
							
							// Handle click row in grid
							grid_requisiciones.attachEvent("onRowSelect", function(rId,cInd){

								// Click en item del arbol
								requisicion_id_value = rId;
								
								celda_details.expand();
								// Attach layout with form and imageview
								var layout_stock_details = celda_details.attachLayout("1C");
								var cell_details = layout_stock_details.cells("a");
								cell_details.setWidth('460');
								cell_details.setText('Detalles');
								
								
								var params = 'id='+rId;	 
								dhtmlxAjax.post("./ajax/view-stock.stock.comments.php", params, function(loader){								
									
									if(loader.xmlDoc.responseText){
										console.log(loader.xmlDoc.responseText);
										var json_return = loader.xmlDoc.responseText;
										var json = JSON.parse(json_return);
										
										var stock_details = [
											{type:"settings", position:"label-top"},
											{type:"fieldset", name:'commentsForm',disabled:false, inputWidth:'100%', label:"", list:[
												{type:"label", label:"Detalles de producto", position:"label-left"},
												{type: "input", name:"comentarios", rows:3, style:"width:400px;height:100px;",label: "Comentarios:", labelWidth:100,inputLeft:5},
												{type:"label", label:""},
												{type: "select",name:'status',label: "Estatus:", labelWidth:100, options:[
																{text: "Pendiente", value: "0", selected:(json.status == "0")?true:false},
																{text: "En espera proveedor", value: "3",selected:(json.status == "3")?true:false},
																{text: "No lo ha recogido el mecanico", value: "4",selected:(json.status == "4")?true:false},
																{text: "Espera de autorizacion", value: "5",selected:(json.status == "5")?true:false},
																{text: "Cotizando", value: "6",selected:(json.status == "6")?true:false},
																{text: "Entregado", value: "1",selected:(json.status == "1")?true:false},
																{text: "Cancelado", value: "2",selected:(json.status == "2")?true:false},
																
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
										
										
										
										var form = layout_stock_details.cells("a").attachForm(stock_details);
										
										// Desactivamos el formulario en caso de estar en estatus 
										// Entregado
										// Cancelado
										if(json.status == "1" || json.status == "2"){
											console.log('desactivamos');
											form.disableItem("commentsForm");
																										 
											
										}
										
										
										var comments_to_br = json.comments.split('<br />').join("\n");
										form.setItemValue('comentarios', comments_to_br);
										
										form.attachEvent("onButtonClick", function(id) {
											
											var select_status = form.getItemValue("status");
											var comments_value = form.getItemValue("comentarios");
											
											if(comments_value == ""){
												alert('Es necesario agregar un comentario');
																								
											
											}else{
												
												params = 'id='+rId+'&comments='+comments_value+'&status='+select_status;
												
												dhtmlxAjax.post("./ajax/view-stock.stock.updatecomments.php", params, function(loader){	
												
													if(loader.xmlDoc.responseText){
														var json_return = loader.xmlDoc.responseText;
														var json = JSON.parse(json_return);
														if(json.result == '1'){
															console.log('Entramos en esta funcion');
															
															if(select_status == "1" || select_status == "2"){
																console.log('desactivamos');
																form.disableItem("commentsForm");
																															 
																
															}
															console.log('actualizamos grid');
															console.log(grid_requisiciones);
															grid_requisiciones.clearAndLoad("./ajax/view-stock.stock.grid.php?id="+stock_id+'&rand=123',function(){
																
																grid_requisiciones.selectRowById(requisicion_id_value);
															});
															
														}
													}
													
													
												});	
												
											}
											
											
											
											
										});
										
										
										
									
									}
	
								});
								
															
							});
						
						
						}else if(id == 'root'){
							// Refresh Console
							//document.getElementById("a_tabbar").innerHTML = "";
							//viewStock();
						
						}
						
						// Work with tab Product
						
						var toolbar_stock = tabbar_stock.cells("a2").attachToolbar();
						var total = 0;
						var paginacion = 50;
						var totalPaginas = 0;
						var elemento_inicial = 0
						var elemmento_final = elemento_inicial + paginacion;
						var pagina_actual = 0;
						var cadenaFiltro = 'null';
						var txt_cadena = '';
					
						toolbar_stock.setIconsPath("menu/imgs/");
						params = 'cadena='+cadenaFiltro;
						dhtmlxAjax.post("./ajax/view-stock.stockadmin.grid.totalrows.php", params, function(loader){
						
							if(loader.xmlDoc.responseText){
								var json_return = loader.xmlDoc.responseText;
								var json = JSON.parse(json_return);
								
								total = parseInt(json.result);	
								totalPaginas = parseInt(total / paginacion);
								//toolbar_stock.setItemText("info", elemento_inicial.toString()+" de "+elemmento_final.toString()+" / total "+total.toString()+" requistos");
								toolbar_stock.setItemText("info", (pagina_actual+1).toString()+" de "+(totalPaginas+1).toString()+" paginas | total "+total.toString()+" requistos");
							}
						
						});
							
							
									
						// Paginacion
						
						toolbar_stock.addSeparator('sep_pagging', 1);
						toolbar_stock.addButton('btn_nuevo',2,'Nuevo','add.png','add.png');
						toolbar_stock.addButton('btn_delete',3,'Borrar','delete.png','delete.png');
						toolbar_stock.addSeparator('sep_pagging3', 4);
						toolbar_stock.addInput('input',5,'',400);
						toolbar_stock.addButton('btn_buscar',6,'Buscar');
						toolbar_stock.addSeparator('sep_pagging2', 7);
						toolbar_stock.addButton('btn_back',8,'','control_start.png');
						toolbar_stock.addButton('btn_back1',9,'','control_rewind.png');
						toolbar_stock.addButton('btn_fw',10,'','control_fastforward.png');
						toolbar_stock.addButton('btn_fwend',11,'','control_end.png');
						//toolbar_stock.addText("info", 11, elemento_inicial.toString()+" de "+elemmento_final.toString()+" / total "+total.toString()+" requistos");
						toolbar_stock.addText("info", (pagina_actual+1).toString()+" de "+(totalPaginas+1).toString()+" paginas | total "+total.toString()+" requistos");
						//totalPaginas = parseInt(total / paginacion);
						
						toolbar_stock.attachEvent("onClick", function(id){   
							
							switch(id){
								
								case 'btn_delete':
								
									var row_id = grid.getSelectedRowId();
									if( row_id != null){
										
										if(confirm("������Estas seguro que deseas eliminar el reguistro?")){
											params = 'id='+row_id;
											dhtmlxAjax.post("./ajax/view-stock.stockadmin.grid.deleterow.php", params, function(loader){
												
												if(loader.xmlDoc.responseText){
													var json_return = loader.xmlDoc.responseText;
													var json = JSON.parse(json_return);
													
													
											}
							
							});
										
										}
									}
									
									console.log(row_id);
								
								break;
								case 'btn_fw':
									pagina_actual = pagina_actual + 1;
									pagina_actual = (pagina_actual <= totalPaginas)?pagina_actual:totalPaginas;
									console.log('pagina actual ->'+pagina_actual);
									if( pagina_actual < totalPaginas){
											elemento_inicial = elemento_inicial+ paginacion;
											elemmento_final = elemmento_final+ paginacion;
											console.log('Pasamos');
											console.log(elemento_inicial);
											console.log(elemmento_final);
									
									}
									
								break;
								
								case 'btn_back1':
									pagina_actual = pagina_actual - 1;
									pagina_actual = (pagina_actual >= 0)?pagina_actual:0;
									console.log(pagina_actual);
									if( pagina_actual > 0){
											elemento_inicial = elemento_inicial- paginacion;
											elemmento_final = elemmento_final- paginacion;
											
											console.log(elemento_inicial);
											console.log(elemmento_final);
									
									}
									
								break;
								
								case 'btn_back':
									pagina_actual = 0;
									elemento_inicial = 0
									elemmento_final = elemento_inicial + paginacion;
									
									console.log(elemento_inicial);
									console.log(elemmento_final);
									
								break;
								
								case 'btn_fwend':
									pagina_actual = totalPaginas;
									elemento_inicial = total - paginacion;
									elemmento_final = total;
									
									console.log(elemento_inicial);
									console.log(elemmento_final);
									
								break;
								
								case 'btn_buscar':
									cadenaFiltro = toolbar_stock.getValue('input');
									pagina_actual = 0;
									elemento_inicial = 0
									elemmento_final = elemento_inicial + paginacion;
									
									
								break;
								
								case 'btn_nuevo':
									stockProductWindow('0',grid,txt_cadena);
									
									
								break;
							
							}
							
							
							params = 'cadena='+cadenaFiltro;
							dhtmlxAjax.post("./ajax/view-stock.stockadmin.grid.totalrows.php", params, function(loader){
								console.log(params);
								if(loader.xmlDoc.responseText){
									var json_return = loader.xmlDoc.responseText;
									var json = JSON.parse(json_return);
									total = parseInt(json.result);
									totalPaginas = parseInt(total / paginacion);
									toolbar_stock.setItemText("info", (pagina_actual+1).toString()+" de "+(totalPaginas+1).toString()+" paginas | total "+total.toString()+" requistos");
									
								}
							
							});
							
							txt_cadena = "./ajax/view-stock.stockadmin.grid.php?incial="+elemento_inicial+"&final="+paginacion+'&cadena='+cadenaFiltro;
							grid.clearAndLoad(txt_cadena);
							
							  
						});
									
								// Generate ajax with total rows
							
							
						toolbar_stock.addSeparator('sep_pagging', 3);
						
						var grid = tabbar_stock.cells("a2").attachGrid();
						grid.setHeader("ID,Producto, Codigo,Unidad,Precio,Linea,Marca");
						grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
						
						grid.setInitWidths("50,500,100,*");
						grid.setColTypes("ed,ed,ed,ed,ed,ed,ed");
						grid.init();
						
						txt_cadena = "./ajax/view-stock.stockadmin.grid.php?incial="+elemento_inicial+"&final="+paginacion+'&cadena='+cadenaFiltro;
						grid.loadXML(txt_cadena);
						grid.attachEvent("onRowDblClicked", function(rId,cInd){
							stockProductWindow(rId,grid,txt_cadena);
							
						},this);
						
					});
					
										
				}
				
				/**********************************************************
					Window insert /update product
				/**********************************************************/
				
				var stockProductWindow = function(type_id,obj_grid,txt_cadena){
					console.log(obj_grid);
					var id = 'stockWindow'
					var dhxWins= new dhtmlXWindows();
					dhxWins.setSkin("dhx_skyblue");
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(id, 50, 50, 400, 320);
					dhxWins.window(id).setText("Administrador de productos");
					
					tabbar_detail = win.attachTabbar();
					tabbar_detail.setSkin("dhx_skyblue");
					tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
					tabbar_detail.addTab("us1", "Productos", "120px");
					//var form = tabbar_detail.attachForm(stock_adminproducts);
					tabbar_detail.setTabActive("us1");
					var form = tabbar_detail.cells("us1").attachForm(stock_adminproducts);
					



					//UpdateElements
					if(type_id != '0'){
						params = 'id='+type_id;
						dhtmlxAjax.post("./ajax/view-stock.stockadmin.grid.product.php", params, function(loader){
							console.log(loader.xmlDoc.responseText);
							if(loader.xmlDoc.responseText){
								var json_return = loader.xmlDoc.responseText;
								var json = JSON.parse(json_return);
								
								form.setItemValue("product", json.product);
								form.setItemValue("code", json.code_product);
								form.setItemValue("unit", json.unit);
								form.setItemValue("price", json.price);
								form.setItemValue("line", json.line);
								form.setItemValue("brand", json.brand);
								
								
							}
							
						
						});
					




					}
					
					form.attachEvent("onButtonClick", function(name) {
					
						switch(name){
						
							case 'save':
								var product	= form.getItemValue("product");
								var code	= form.getItemValue("code");
								var unit	= form.getItemValue("unit");
								var price	= form.getItemValue("price");
								var line	= form.getItemValue("line");
								var brand	= form.getItemValue("brand");
								
								product = product.replace('"','');
								product = product.replace("'","");
								params = 'id_product='+type_id+'&product='+product+'&code='+code+'&unit='+unit+'&price='+price+'&line='+line+'&brand='+brand;
								dhtmlxAjax.post("./ajax/view-stock.stockadmin.form.save.php", params, function(loader){
									
									if(loader.xmlDoc.responseText){
										console.log(loader.xmlDoc.responseText);
										var json_return = loader.xmlDoc.responseText;
										var json = JSON.parse(json_return);
										if(json.result){
											dhxWins.window(id).close();
											obj_grid.clearAndLoad(txt_cadena);	
										}
									}
								
								});
								
								
							break;
							
							case 'reset':
								console.log('cerramos');
								dhxWins.window(id).close();
							break;
						
						}
					
					});
					
					 //dhxWins.window(id).close();
					
					
					
					
				}
				
				
				
				
				/**********************************************************
					Module Users
					Contains:
					- fn windowUser
					- fn viewUser
				/**********************************************************					
				/****************************
				 * Function windowEmployee 
				 * @params
				 * action, default new
				 * 
				 ****************************/
				var windowUser = function(id_user,grid_usr,action){
					
					//Desactivar
					if(action =="delete"){
						var id = grid_usr.getSelectedRowId();
						if(id == null){
							alert("Seleccione un usuario");
						}else{
							
							var answer = confirm("Seguro de desactivar el usuarios seleccionado?")
							if (answer){
								params = 'id='+id;
								dhtmlxAjax.post("./ajax/ajaxUser.php?action=disable", params, function(loader){							
									if(loader.xmlDoc.responseText){	
										var json = JSON.parse(loader.xmlDoc.responseText);
										if(json.return =="1"){
											grid_usr.clearAll();
											grid_usr.loadXML("ajax/grids/grid_users.php");
											alert("Usuario desactivado");											
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
						var idwindow = 'window-user';
						var dhxWins= new dhtmlXWindows();
						dhxWins.setSkin("dhx_skyblue");
						dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
						var win = dhxWins.createWindow(idwindow, 50, 50, 410, 530);						
						dhxWins.window(idwindow).setText("Administrador de Usuarios");
						dhxWins.window(idwindow).centerOnScreen();
						tabbar_detail = win.attachTabbar();
						tabbar_detail.setSkin("dhx_skyblue");
						tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");
						tabbar_detail.addTab("us1", "Usuarios", "120px");
						tabbar_detail.setTabActive("us1");
						
						// Add form to componenet
						var formnew_user = tabbar_detail.cells("us1").attachForm(new_user);						
						if(action !== "update"){ 
							//formnew_user.enableLiveValidation(true);
						}else{
							//formnew_user.enableLiveValidation(false);
						}
						
						//UpdateElements
						if(id_user != '0'){
							params = 'id='+id_user;
							dhtmlxAjax.post("./ajax/ajaxUser.php?action=get", params, function(loader){							
								if(loader.xmlDoc.responseText){
									var json_return = loader.xmlDoc.responseText;
									var json = JSON.parse(json_return);

									formnew_user.setItemValue("name", json.name);
									formnew_user.setItemValue("last_name", json.last_name);
									formnew_user.setItemValue("profile", json.profile);
									formnew_user.setItemValue("email", json.email);								
									formnew_user.setItemValue("status", json.status);
									formnew_user.hideItem("isemployee");
								}
							});
						}	

						// Handle Listener onclinck 
						formnew_user.attachEvent("onButtonClick", function(id) {
							if(id =="cancelar"){
								dhxWins.window(idwindow).close();
							}
							if(id =="guardar"){
								
								var url = "";
								if(id_user == '0'){
									url = "ajax/ajaxUser.php?action=add";
								}else{	
									url = "ajax/ajaxUser.php?action=update&id="+id_user;
								}
									if(formnew_user.getItemValue("password") == "" && id_user == '0'){
										alert("El campo password no puede quedar vac������o");
									}else{
										formnew_user.send(url, function(loader, response) {
											var objJSON = eval("(function(){return " + response + ";})()");
											if(objJSON.return == "1"){
												alert("Guardado correctamente");

											}else{
												alert("Se produjo un error, favor de volver a intentar");
											}
											grid_usr.clearAll();
											grid_usr.loadXML("ajax/grids/grid_users.php");
											dhxWins.window(idwindow).close();
										});
									}	
							}	
						});
					}//Update||insert	
				}
				
				
				/****************************
				This view contains 
						layout
						grid 
						window 
					Goal: Administration of users insert and update 
				****************************/
				
				var viewUser = function(){
					
					document.getElementById("a_tabbar").innerHTML = "";
					
					// Include the layout component
					var layout = new dhtmlXLayoutObject("a_tabbar", "1C");
					
					var cell_2 = layout.cells('a');
					cell_2.setText('Listado de usuarios:');
					cell_2.fixSize(0,1);
					cell_2.setHeight('75');
							
					//Include Grid componenet
					var toolbar_user = cell_2.attachToolbar();
					toolbar_user.setIconsPath("menu/imgs/");
					toolbar_user.addSeparator('sep_pagging', 1);
					toolbar_user.addButton('btn_nuevo',2,'Nuevo','add.png','add.png');
					toolbar_user.addButton('btn_delete',3,'Desactivar','delete.png','delete.png');

					var grid_user = cell_2.attachGrid();
					grid_user.setHeader("Id Usuario,Usuario, Nombre, Apellido,Fecha de Registro,Status");
					grid_user.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
					grid_user.setInitWidths("*");
					grid_user.setColTypes("ro,ro,ro,ro,ro,ro,ro");
					grid_user.init();
					grid_user.loadXML("ajax/grids/grid_users.php");
					//Evento doble click en el row
					grid_user.attachEvent("onRowDblClicked", function(rId,cInd){	
						windowUser(rId,grid_user,'update');
					});
					// Evento nuevo
					toolbar_user.attachEvent("onClick", function(id){
							
							switch(id){
								
								case 'btn_nuevo':
									windowUser('0',grid_user,'insert');
								break;
								case 'btn_delete':
									windowUser('0',grid_user,'delete');
								break;
							}
					});	
										
					
					
				
				};
				
				
				var view_chief_department = function(){
					
					var idwindow_chief = 'chief-department';
					var dhxWins= new dhtmlXWindows(); 					
					dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
					var win = dhxWins.createWindow(idwindow_chief, 50, 50, 400, 300);
					dhxWins.window(idwindow_chief).centerOnScreen(); 
					dhxWins.window(idwindow_chief).setText("Departamento");
					dhxWins.window(idwindow_chief).setModal(true);
					tabbar_detail = win.attachTabbar();					
					tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
					tabbar_detail.addTab("us1", "Departamento", "120px");
					 
					tabbar_detail.setTabActive("us1");
					
					// Add form to componenet
					var form_chief = tabbar_detail.cells("us1").attachForm(office_boos);
							var params = "";
							dhtmlxAjax.post("./ajax/ajaxOffice_boss.php?action=get", params, function(loader){		
								if(loader.xmlDoc.responseText){
									var json_return = loader.xmlDoc.responseText;
									var json = JSON.parse(json_return);										
									var calidad_iduser = json[0].user_id;
									var almacen_iduser = json[1].user_id;
									var recepcion_iduser = json[2].user_id;
									form_chief.setItemValue("recepcion", recepcion_iduser);
									form_chief.setItemValue("almacen", almacen_iduser);									
									form_chief.setItemValue("calidad", calidad_iduser);									
								}
							});
							
						// Boton guardar/cancelar 
						form_chief.attachEvent("onButtonClick", function(id) {							
							if(id =="cancelar"){
								dhxWins.window(idwindow_chief).close();
							}
							if(id =="guardar"){
								var almacen_user = form_chief.getItemValue("almacen");										
								var recepcion_user = form_chief.getItemValue("recepcion");
								var calidad_user = form_chief.getItemValue("calidad");
								var params = "&recepcion="+recepcion_user+"&almacen="+almacen_user+"&calidad="+calidad_user;
								dhtmlxAjax.post("./ajax/ajaxOffice_boss.php?action=update", params, function(loader){
									if(loader.xmlDoc.responseText){									
										var json = JSON.parse(loader.xmlDoc.responseText);
										if(json.return == "1"){
											dhxWins.window(idwindow_chief).close();
											dhtmlx.alert({
												title:"Actualizaci������n completada",
												type:"alert",
												text:"Se guard������ la actualizaci������n realizada"
											});
										}else{
											dhtmlx.alert({
												title:"Error",
												type:"alert",
												text:"Hubo un error al actualizar!, favor de volver a intentar"
											});
										}
										
									}
								});
								
							}
											
						});		
							
					
				
				};
				

				
				/**********************************************************
					Module Employee
					Contains:
					- fn windowEmployee
					- fn viewEmployee
				/**********************************************************					
				/****************************
				 * Function windowEmployee 
				 * @params
				 * action, default new
				 * 
				 ****************************/
				
				var windowEmployees = function(id_user,grid_emp,action){
				
					//Desactivar
					if(action =="disable"){
						var id = grid_emp.getSelectedRowId();
						if(id == null){
							alert("Seleccione un usuario");
						}else{
							
							var answer = confirm("Seguro de desactivar el usuarios seleccionado?")
							if (answer){
								params = 'id='+id;
								dhtmlxAjax.post("./ajax/ajaxEmployee.php?action=disable", params, function(loader){							
									if(loader.xmlDoc.responseText){	
										var json = JSON.parse(loader.xmlDoc.responseText);
										if(json.return =="1"){
											grid_emp.clearAll();
											grid_emp.loadXML("ajax/grids/grid_employees.php");
											alert("Usuario desactivado");											
										}else{
											alert("Oops!!, Sucedi������ un error, volver a intentar");
										}										
									}
								});								
							}								
						}
					}
					
					if(action =="insert" || action =="update"){
							//Create new Window
							var idwindow_emp = 'window-employee';
							var dhxWins= new dhtmlXWindows(); 					
							dhxWins.setImagePath("./dhtmlxLibrary/dhtmlxWindows/codebase/imgs/");
							var win = dhxWins.createWindow(idwindow_emp, 50, 50, 400, 490);
							dhxWins.window(idwindow_emp).centerOnScreen(); 
							dhxWins.window(idwindow_emp).setText("Administrador de Empleados");
							tabbar_detail = win.attachTabbar();					
							tabbar_detail.setImagePath("./dhtmlxLibrary/dhtmlxTabbar/codebase/imgs/");					
							tabbar_detail.addTab("us1", "Empleados", "120px");
							tabbar_detail.setTabActive("us1");
							// Add form to componenet
							var formnew_empl = tabbar_detail.cells("us1").attachForm(new_employee);
							formnew_empl.enableLiveValidation(true);
								//UpdateElements
								if(id_user != '0'){
									params = 'id='+id_user;
									dhtmlxAjax.post("./ajax/ajaxEmployee.php?action=get", params, function(loader){		
										if(loader.xmlDoc.responseText){
											var json_return = loader.xmlDoc.responseText;
											var json = JSON.parse(json_return);
											formnew_empl.setItemValue("name", json.name);
											formnew_empl.setItemValue("last_name", json.last_name);
											formnew_empl.setItemValue("nickname", json.nickname);
											formnew_empl.setItemValue("role", json.role);								
											formnew_empl.setItemValue("department", json.department);																			
											if(json.access_requisition=="1"){ formnew_empl.checkItem("access_requisition"); }									
											formnew_empl.setItemValue("requisition_pwd", json.requisition_pwd);																			
											formnew_empl.setItemValue("company", json.company);								
											formnew_empl.setItemValue("status", json.status);
										}
									});
								}	
							// Boton guardar/cancelar 
							formnew_empl.attachEvent("onButtonClick", function(id) {
								
								if(id =="cancelar"){
									dhxWins.window(idwindow_emp).close();
								}
								if(id =="guardar"){
									var url = "";
									if(id_user == '0'){
										url = "ajax/ajaxEmployee.php?action=add";
									}else{	
										url = "ajax/ajaxEmployee.php?action=update&id="+id_user;
									}
									formnew_empl.send(url, function(loader, response) {											

										var objJSON = eval("(function(){return " + response + ";})()");
										if(objJSON.return == "1"){
											alert("Guardado correctamente");

										}else{
											alert("Se produjo un error, favor de volver a intentar");
										}
										grid_emp.clearAll();
										grid_emp.loadXML("ajax/grids/grid_employees.php");
										dhxWins.window(idwindow_emp).close();
									});
								}
												
							});
					}
					
				}
				
				/****************************
				This view contains 
						layout
						grid 
						window 
					Goal: Administration of users insert and update 
				****************************/
				
				var viewEmployees = function(){
					
					document.getElementById("a_tabbar").innerHTML = "";
					
					// Include the layout component
					var layout = new dhtmlXLayoutObject("a_tabbar", "1C");
					
					var cell_2 = layout.cells('a');
					cell_2.setText('Listado de empleados:');
					cell_2.fixSize(0,1);
					cell_2.setHeight('75');
							
					//Include Grid componenet
					var toolbar_employee = cell_2.attachToolbar();
					toolbar_employee.setIconsPath("menu/imgs/");
					toolbar_employee.addSeparator('sep_pagging', 1);
					toolbar_employee.addButton('btn_nuevo',2,'Nuevo','add.png','add.png');
					toolbar_employee.addButton('btn_delete',3,'Desactivar','delete.png','delete.png');

					var grid_employee = cell_2.attachGrid();
					grid_employee.setHeader("Id empleado, Nombre, Apellidos,Fecha de Registro,Cargo,Empresa,Status");
					grid_employee.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");
					grid_employee.setInitWidths("*");
					grid_employee.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro");
					grid_employee.init();
					grid_employee.loadXML("ajax/grids/grid_employees.php");
					//Evento doble click en el row
					grid_employee.attachEvent("onRowDblClicked", function(rId,cInd){	
						windowEmployees(rId,grid_employee,'update');
					});
					// Evento nuevo
					toolbar_employee.attachEvent("onClick", function(id){
							
							switch(id){
								
								case 'btn_nuevo':
									windowEmployees('0',grid_employee,'insert');
								break;
								case 'btn_delete':
									windowEmployees('0',grid_employee,'disable');
								break;
							}
					});	
										
					
					
				
				};
				
				
				/*************************
				 * Create menu tool bar
				 * 
				 *************************/
				 
				 var menuToolBar = function(){
				
					var session_group = <?php echo $session_group; ?>;
					var toolbar = new dhtmlXToolbarObject("toolbarObj");
					toolbar.setIconsPath("./menu/imgs/");
					toolbar.loadXML("./menu/toolbar.xml?123",function(){
						
						if( session_group == 1 ){
							toolbar.removeItem('vistas');
							toolbar.removeItem('print');
							
							
						}
						
						if( session_group == 2 ){
							toolbar.removeItem('print');
						}
					
					});
										
					toolbar.addText("info", 25, "Gascomb 1.0v");
					toolbar.addSeparator('sep_1', 2);													
					buffer_toolbar = toolbar;
					
					
					
					
					toolbar.attachEvent("onClick", function(id){   
						
						<?php include_once('module_action.php') ?>
						

						
					},this);
					
					}
				
				
				/*************************
				 * Create de view for loggin
				 *************************/
				
				var viewSign = function(){
					
					formData = [
                       	{ type: "fieldset", name: "data", label: "Bienvenidos", inputWidth: "auto", list:[
						{type:"input", name: 'name', label:'Usuario:',labelWidth:80},
						{type:"password", name:"pass", label:"Password:",labelWidth:80},
						{type:"label", label:""},
						{type:"button", name:"save", value:"Ingresar"}] 
		   				}
                   		 ]
					myForm = new dhtmlXForm("form_container", formData);					
					myForm.attachEvent("onButtonClick", function(id) {
						
						validateUser(myForm);				
					});
					
					var userTxt = myForm.getInput("name");
					userTxt.addEventListener("keydown", function(e){
						if( e.keyCode == 13){
							validateUser(myForm);
						}
					}, false);
					
					var passTxt = myForm.getInput("pass");
					passTxt.addEventListener("keydown", function(e){
						if( e.keyCode == 13){
							validateUser(myForm);
						}
					}, false);
					
					var validateUser = function(myForm){
						
						// Send Ajax;
						var user = myForm.getItemValue("name");
						var pass = myForm.getItemValue("pass");
												
						var params = "usuario="+user+"&password="+pass+"";
						dhtmlxAjax.post("views/sign/sign.php", params, function(loader){
							console.log(loader)
							if (loader.xmlDoc.responseXML != null);
    							
    							if(loader.xmlDoc.responseText == "true"){
    								
    								//menuToolBar();
    								//viewSistema();
									window.location.href = './';
    								
    							}else{
    								
    								var msj = document.getElementById("form_msj");
									msj.innerHTML = "Usuario incorrecto";
    							}
    							console.log(loader.xmlDoc.responseText)
							
							
						});
						//alert('Damos click');
						
					}
					
				}
				
				
				
				/****************************
					Event LoadPage
				****************************/
				window.addEventListener("load", function () {
					
					
					if(secure){
						viewSign();
						
					}else{
					
						menuToolBar();
						viewSistema();
						
					}
					
				});	   
	   </script>		   
	</body>
</html>
