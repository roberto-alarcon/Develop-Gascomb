<?php
	include_once ("../config/set_variables.php");
	ini_set('display_errors', '1');
	if(isset($_SESSION['active_user_id']) && $_SESSION['active_user_id']){
		$session_result = "var secure = false;";
	}else{
		$session_result = "var secure = true;";
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
	
	<!--Calendar -->
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
	
	<!-- Acordeon -->
	<script src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxAccordion/codebase/dhtmlxaccordion.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxAccordion/codebase/skins/dhtmlxaccordion_dhx_skyblue.css">
	
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
	
	</body>
	
	<script>
	
	// Declaracion de variables
	<?php echo $session_result; ?>
	
	
	/****************************
		Event LoadPage
	****************************/
	window.addEventListener("load", function () {
		
		
		if(secure){
			//viewSign();
			console.log('Loggin');
			
		}else{
		
			console.log('Cargamos aplicacion');
			
			//menuToolBar();
			//viewSistema();
			
		}
		
	});	
	
	
	</script>
	
	</html>