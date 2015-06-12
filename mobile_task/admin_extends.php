<?php
	ini_set('display_errors', '1');
	header('Content-Type: text/html; charset=utf-8');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.extends.php';
	include_once PATH_CLASSES_FOLDER.'class.users.php';
$data["folio_id"] = $_GET['folio'];
$id = $_GET['folio'];
$extend = new Extend;
$extends = $extend->selectbyColumn($data, 50);
$userlogged = new Users;
$profile = $userlogged->getProfile($_SESSION["active_user_id"]);
$users = new Users;

?>


<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>		
		<script>
			$(document).ready(function(){
				$.mobile.defaultPageTransition = 'none';
				$('.autorizar').click(function() {
						var ampli_id = this.id;
						
						//throw '';
						$.ajax({
								url: "./ajax/add_update_extends.php?action=update&id="+ampli_id+"&status=1",
								type: "POST"						
						})
						.done( function ( response ) {
							var response = jQuery.parseJSON(response);
							if(response.return == "1"){								
								alert("La ampliación ha sido autorizada");
								location.reload();
							}else{
								alert("Ocurrió un problema al solicitar productos");
								location.reload();								
							}
							
						});
				});
				$('.cancelar').click(function() {
						var ampli_id = this.id;
						$.ajax({
								url: "./ajax/add_update_extends.php?action=update&id="+ampli_id+"&status=2",
								type: "POST"						
						})
						.done( function ( response ) {
							var response = jQuery.parseJSON(response);
							if(response.return == "1"){								
								alert("La ampliación ha sido cancelada");	
								location.reload();
							}else{
								alert("Ocurrió un problema al solicitar productos");
								location.reload();								
							}
							
						});
				});
			});
		</script>
		<style>
			.linked .ui-link:visited {
				color: #333 !important;
			}
			.linked .ui-link {
				color: #333 !important;
				font-weight: normal !important;
			}
			a:-webkit-any-link {
			color: #333;
			text-decoration: none;
			}
		</style>
	
	</head>
	<body>
		<div data-role="page" id="home">
		<div data-role="header">
			<h1>  Módulo :: Ampliaciones :: Folio - <?php echo $id; ?></h1>
			
			 <?php include_once 'menu.php';?>	
			 <?php include_once 'menu_quality.php';?>
		</div>
		<div data-role="content">

			<div data-role="collapsible" data-theme="c" data-content-theme="c" data-collapsed="false">
					<h2><?php echo "Folio: ".$id; ?></h2>
					<ul data-role="listview" data-theme="c" data-divider-theme="c">
					
					<table width="100%" border="1" style="border-collapse:collapse;border: 1px solid #c0c0c0;" cellpadding="5" cellspacing="0">
					<?php 
					
					if($extends){						
						?>
						
						<tr><td><strong>Mensaje</strong></td><td><strong>Fecha de envío</strong></td><td><strong>Fecha de Autorización/Cancelación</strong></td><td><strong>Autorizado/Cancelado por:</strong></td><td><strong>Status</strong></td><td><strong></strong></td></tr>
						
						<?php 
							foreach($extends as $rows){
								
							
								echo '<tr>';
							
								echo '<td><a class="linked" href="update_extends_form.php?folio='.$id.'&id='.$rows['extend_id'].'&tab=4&subtab=2">'.utf8_encode($rows['message']).'</a></td>';
								//echo '<td>'.utf8_encode($rows['comments']).'</td>';
								echo '<td>'.date("d/m/Y G:i", $rows["creation_datetime"]).'</td>';
								echo ($rows["approved_datetime"] !=="") ? "<td>".date("d/m/Y G:i", $rows["approved_datetime"])."</td>" : "<td>Pendiente</td>";
								if($rows["approved_by"] !==""){
									//echo $rows["approved_by"];
									$usern = $users->getName($rows["approved_by"]);
									
									echo "<td>".utf8_encode($usern)."</td>";
								}else{								
									echo "<td>Pendiente</td>";
								}
								switch ($rows["status"]) {
									case 0:
										$status= "Pendiente";
										break;
									case 1:
										$status= "Autorizado";
										break;
									case 2:
										$status= "Cancelado";
										break;
								}					
								echo "<td>$status</td>";
								//echo $profile; exit(0);
								//if($profile =="asesor de servicio" || $profile =="administrator"){
									echo '<td><div data-role="controlgroup" data-mini="true">
										<a href="#" class="autorizar" id="'.$rows['extend_id'].'" data-icon="check" data-role="button" data-ajax="false">Autorizar</a>
										<a href="#" class="cancelar" id="'.$rows['extend_id'].'" data-icon="delete" data-role="button" data-ajax="false">Cancelar</a>
									</div></td>';
								//}
								//echo '<td><a href="update_extends_form.php?folio='.$id.'&id='.$rows['extend_id'].'&tab=4&subtab=2" data-role="button" data-theme="b" data-ajax="false" data-mini="true">Ver más</a></td>';
											
								echo '</tr>';
							}
						}else{ 
							
							echo "<tr><td>Aún no hay información del vehiculo</td></tr>";
							
						}
					?>
					</table>
					</ul>
					</div>
			
		</div>
		<?php  include "footer.php";?>
	</body>
</html>