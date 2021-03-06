<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
	$id = $_GET['folio'];
	/*****************************
	Get params for folio
	*****************************/
	$id = isset($_GET['folio'])?$_GET['folio']:0;
	
	
	// Instanciamos la clase
	$CheckList = new Checklist($id);
	$elementos = $CheckList->listQualityElements();
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
			<h1>  M&oacutedulo :: Calidad :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once('menu.php');?>	
			<?php include_once 'menu_quality.php';?>
			
			
		</div>
		
		<div data-role="content">

			<div style="height:520px; overflow-y:scroll">

				<?php
				
				$error_icon     = 'http://mobile-quality.gascomb.com/img/error-icon.png';
				$select_icon    = 'http://mobile-quality.gascomb.com/img/Select-icon.png';
				$rate_icon      = 'http://mobile-quality.gascomb.com/img/rate-icon.png';
				
				foreach( $elementos as $indice => $v){
        
					$img = $error_icon;
					
					if($v['status'] == 1){
						$img = 	$select_icon;	
					}elseif($v['status'] == 2){
						$img = 	$error_icon;
					}
					
					echo '<img src="'.$img.'">&nbsp;&nbsp;<a href="admin_quality_list.php?folio='.$id.'&cheklist_folio='.$v['checklist_folio_id'].'&activity_id='.$v['support_checklist_activities_list_id'].'&tab=4&subtab=1" data-ajax="false">'.$v['label_activities'].'</a><br>' ;
					
				}
				
				?>

			</div>
		</div>
		<?php  include "footer.php";?>
	</body>
</html>