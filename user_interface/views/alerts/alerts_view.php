<?php
include '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.alert.read.php');
$user = $Gascomb->session_user_id();
$alert = new Alert_Read($user);
$alert->module_link = 'web';
$total = $alert->totalRows();

?>

<html>
<head>

<script src="./../../js/jquery-2.0.3.min.js"></script>


<script>
	
	function loadAler() {
		
		$('#LoadAlerts').html('<img src="../../img/loading.gif"/>');
		//$('#LoadAlerts').html('');
		
		$.ajax({
			url: "alerts_load.php",
			cache: false
		      }).done(function( html ) {
			$("#LoadAlerts").html(html);
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
		background-color: #ffffff;
	}
	</style>

</head>
<body>
<h3>Bandeja de alertas </h3>
<div id="LoadAlerts">


	<h4>Resultados encontrados - ( <?php echo $total; ?> ) </h4>
	<?php
		
		
		$alert->doRows();
	?>

</div>


<script>
	//timer = setInterval("loadAler()", 60000);
	timer = setInterval("loadAler()", 6000);
	
</script>
</body>



</html>