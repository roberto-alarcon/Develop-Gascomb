<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.php';
include_once MODULES_CLASES_QUOTE.'class.quote.process.php';
?>

<?php

// En caso de salvar los elementos	
if(isset( $_POST['request_quote_id'] )){
	$formAction = new Quote_Process();
	$formAction->insertFormStep2();
}
	
?>

<html>
<head>
<!-- Javascript libs -->
<script src="<?php echo WEB_QUOTE_JS;?>jquery-1.10.1.min.js"></script>
<script src="<?php echo WEB_QUOTE_JS;?>jquery-migrate-1.2.1.min.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" media="screen" />

<script>

	$(document).ready(function() {
		
		$( "#btnCompra" ).click(function() {
			 modalCompra();
		});
				
    });
	
	function modalCompra( id ){
		$('#dialog').attr('title','Solicitar compra');
		$("#dialog").dialog({
			autoOpen: false,
			modal: true,
			height: 600,
			width: 800,
			open: function(ev, ui){
					 $('#myIframe').attr('width','750px');
					 $('#myIframe').attr('height','500px');
					 $('#myIframe').attr('src','./instance.buy.php?id='+id);
				  },
			close: function(ev , ui){
				$('#myIframe').attr('src','');
			}
		});
		
		$('#dialog').dialog('open');
	
	}
		
	function modalDetails( id , channel ){
		$('#dialog').attr('title','Detalles del producto');
		$("#dialog").dialog({
			autoOpen: false,
			modal: true,
			height: 400,
			width: 600,
			open: function(ev, ui){
					 $('#myIframe').attr('width','550px');
					 $('#myIframe').attr('height','300px');
					 $('#myIframe').attr('src','./instance.form2.details.php?id='+id+'&channel='+channel);
				  },
			close: function(ev , ui){
				$('#myIframe').attr('src','');
			}
		});
		
		$('#dialog').dialog('open');
	
	}
	
	function modalPago ( id , proveedor ){
		$('#dialog').attr('title','Forma de pago');
		$("#dialog").dialog({
			autoOpen: false,
			modal: true,
			height: 400,
			width: 600,
			open: function(ev, ui){
					 $('#myIframe').attr('width','550px');
					 $('#myIframe').attr('height','300px');
					 $('#myIframe').attr('src','./instance.form2.pay.php?id='+id+'&supplier='+proveedor);
				  },
			close: function(ev , ui){
				$('#myIframe').attr('src','');
			}
		});
	
	
	$('#dialog').dialog('open');

	}
	
	function closeModal(){
		$('#dialog').dialog('close');
	}
	
	
</script>


<style type="text/css">
	table {
		font-family: verdana,arial,sans-serif;
		font-size:11px;
		color:#333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
	}
	table th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #D0E5FE;
	}
	table td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		/*background-color: #ffffff;*/
	}
	
	.row_0 {
		background-color: #ffffff;
	}
	
	.row_1 {
		background-color: #eFeFeF;
	}
	
	.cell_red{
		color: #FF0000;
		font-weight:bold;
	}
	
	.cell_green{
		color: #00FF00;
		font-weight:bold;
	}
	
	.right {
		text-align: right;
		margin-right: 1em;
	}
	      
	.left {
		text-align: left;
		margin-left: 1em;
	}
	      
	button {
		border-top: 1px solid #96d1f8;
		background: #65a9d7;
		background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
		background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
		background: -moz-linear-gradient(top, #3e779d, #65a9d7);
		background: -ms-linear-gradient(top, #3e779d, #65a9d7);
		background: -o-linear-gradient(top, #3e779d, #65a9d7);
		padding: 6.5px 13px;
		-webkit-border-radius: 8px;
		-moz-border-radius: 8px;
		border-radius: 8px;
		-webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
		-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
		box-shadow: rgba(0,0,0,1) 0 1px 0;
		text-shadow: rgba(0,0,0,.4) 0 1px 0;
		color: white;
		font-size: 14px;
		font-family: Georgia, serif;
		text-decoration: none;
		vertical-align: middle;
	}
	
	button:hover {
		border-top-color: #28597a;
		background: #28597a;
		color: #ccc;
	}
	     
	button:active {
		border-top-color: #1b435e;
		background: #1b435e;
	}
	
	</style>

</head>
<body>
<div id="LoadAlerts" style="text-align:center;">
	
	<?php
	$cotizador = new Quote(95);
	$cotizador->image_field = true;
	$cotizador->promedio_field = true;
                //Paso 1
        
	echo '<form name="form3" enctype="multipart/form-data" method="post" action="'.$_SERVER["PHP_SELF"].'">';
	$cotizador->doQuoteStep2();
	echo '</form>';	
		
	?>
	
<div id="dialog" title="Detalles del producto">
<iframe id="myIframe" src="" width="550" height="300" frameborder="0"></iframe>
</div>
