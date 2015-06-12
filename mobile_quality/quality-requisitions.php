<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include_once(PATH_CLASSES_FOLDER.'class.stock.mobile.php');	
	$id = $_GET['folio'];
	$Stock = new Stock;
	$stock_id = $Stock->getStockId($id);
	$stock = new Stock_mobile($stock_id);

?>
<!DOCTYPE html>

<html>

	<head>

		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">

		<!--  JQuery Mobile library -->

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script src="js/jquery.xml2json.js" type="text/javascript" language="javascript"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
	</head>

	<body>

		<div data-role="header">

			<h1>  M&oacutedulo :: Control de Calidad - Requisiciones  :: Folio - <?php echo $id; ?></h1>

			

			 <?php include_once('quality-menu.php');?>	

			

		</div>

		<div data-role="content">

			<div style="height:520px; overflow-y:scroll">

				<div style="height:520px; overflow-y:scroll">
				<?php $stock->getMobileList(); ?>
				</div>

			</div>

		</div>

		 <?php include_once('quality-footer.php');?>	

	

	

	</body>

</html>