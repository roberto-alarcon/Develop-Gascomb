<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.details.php';

?>

<html>
<head>
<!-- Javascript libs -->
<script src="<?php echo WEB_QUOTE_JS;?>jquery-1.10.1.min.js"></script>
<script src="<?php echo WEB_QUOTE_JS;?>jquery-migrate-1.2.1.min.js"></script>


<script>

	function SaveForm(){
		
		
		tipo_pago 	= $( "input:radio[name=pay]:checked" ).val();
		supplier	= $( "input:hidden[name=supplier]" ).val(); 
		request_id	= $( "input:hidden[name=request_quote_id]" ).val(); 

		console.log(supplier)
		
		// Generamos ajax para guardar lso elementos
		$.post( "instance.process.pay.form.php", { tipo_pago: tipo_pago, supplier: supplier , request_id:request_id })
			.done(function( data ) {
				var obj = jQuery.parseJSON( data );
				if(obj.result){
					parent.closeModal();
				}else{
					alert("Ocurrio un problema al guardar el registro, por favor vuelva a intentarlo");
				}
				
			})
			.fail(function() {
				alert("Ocurrio un problema al guardar el registro, por favor vuelva a intentarlo");
			});
	
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
	$request_quote_id 		= $_GET['id'];
	$supplier_id			= $_GET['supplier'];
	
	
	$pago 		= new Quote_Pay_Form( $request_quote_id , $supplier_id);
	$pago->creaFormulario();
			
	?>
	
</div>
</body>
