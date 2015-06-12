<?php

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
		
	<!-- TabBar -->
	
	<script  src="./dhtmlxLibrary/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
	
	
	
	<!-- Formularios -->
	<script src="./dhtmlxLibrary/dhtmlxForm/codebase/dhtmlxform.js"></script>
	<link rel="stylesheet" type="text/css" href="./dhtmlxLibrary/dhtmlxForm/codebase/skins/dhtmlxform_dhx_skyblue.css">
	<script src="./dhtmlxLibrary/dhtmlxForm/codebase/ext/dhtmlxform_item_calendar.js"></script>
	<script src="./dhtmlxLibrary/dhtmlxForm/codebase/ext/dhtmlxform_item_upload.js"></script>
    <script src="./dhtmlxLibrary/dhtmlxForm/codebase/ext/swfobject.js"></script>
	
	 <style>
        #form_container {
                position: absolute;
                left: 50%;
                top: 50%;
                width: 280px;
                height: 300px;
                margin-top: -150px;
                margin-left: -180px;
 
                overflow: auto;
                
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
<body onload="doOnLoad()">
	
<div id="form_msj"></div>	
<div id="form_container"></div>

<script>
	var myForm, formData;
	
	
	var msj = document.getElementById("form_msj");
	msj.innerHTML = "Error";
	
	function doOnLoad() {
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
			
			// Send Ajax;
			
			alert('Damos click');
						
		});
		
		
		
	}	
</script>
 
</body>
	</script>
 

</html>