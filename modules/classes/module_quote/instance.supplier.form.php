<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.supplier.php';
?>

<html>
<head>
<!-- Javascript libs -->
<script src="<?php echo WEB_QUOTE_JS;?>jquery-1.10.1.min.js"></script>
<script src="<?php echo WEB_QUOTE_JS;?>jquery-migrate-1.2.1.min.js"></script>

<script>

	$(document).ready(function() {
		
				
        });
	
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
<div id="LoadAlerts" align="center">
	
	<?php
	
	if(!isset($_GET['token'])){
		echo "<h1>Acceso no autorizado</h1>";
		die();
	}else{

		echo '<form name="form3" enctype="multipart/form-data" method="post" action="instance.process.supplier.form.php">';
		$SupplierForm = new Quote_Supplier($_GET['token'] , $_GET['item_supplier'] );
		$SupplierForm->createFORM();
		echo '</form>';	


	}

	?>

</div>
</body>
</html>