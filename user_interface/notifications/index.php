<?php
session_start();  
	if(empty($_SESSION["active_user_id"]))
		die("invalid session");
		
	$userId=$_SESSION["active_user_id"];
	include_once("../../modules/classes/class.notifications.php");
	$notifications = new Notifications();
	$array_notifications = $notifications->selectbyUserId($userId);	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Notifications Grupo Mecanico Empresarial</title>	
	
	<style>
	@font-face {
		font-family: 'PT Sans';
		src: local('PT Sans'), local('PTSans-Regular'), url(http://desarrollo.grupome.com/notifications/LKf8nhXsWg5ybwEGXk8UBQ.woff) format('woff');
	}
	</style>
	<link rel="stylesheet" href="http://desarrollo.grupome.com/notifications/css/fluid.css"> <!-- sacar fondo -->
	<link rel="stylesheet" href="http://desarrollo.grupome.com/notifications/css/buttons.css">	
</head>

<body>	
<script src="http://desarrollo.grupome.com/notifications/js/libs/jquery-1.7.1.min.js"></script>	
<script src="http://desarrollo.grupome.com/notifications/js/noty/jquery.noty.js"></script>
<script src="http://desarrollo.grupome.com/notifications/js/noty/layouts/top.js"></script>	
<script src="http://desarrollo.grupome.com/notifications/js/noty/themes/default.js"></script>
<script defer src="http://desarrollo.grupome.com/notifications/js/script.js"></script>
<script>

setInterval(function() {
	$.ajax({
		type: "POST",
		url: "refresh.php",
		data: { userId: "<?php echo $userId; ?>" }
	}).done(function( msg ) {
		msg = $.parseJSON(msg);
		for (id in msg){
			if(jQuery.inArray(msg[id].notification_id,notifications_js) == -1){
				
				noty({
					text: msg[id].description+" / Folio:"+msg[id].folio_id,
					type: "alert", dismissQueue: true, layout: "top", buttons: false 
				});

				notifications_js.push(msg[id].notification_id);
				
			}			
		}
	});
}, 10000);

<?php
	$ids='';
	while(list(,$notification)=each($array_notifications)){
		$ids.='"'.$notification["notification_id"].'",';
		echo 'noty({
				text: "'.$notification["description"].' / Folio:'.$notification["folio_id"].'",
				type: "alert", dismissQueue: true, layout: "top", buttons: false 
			});';
	}
	$ids=substr($ids,0,strlen($ids)-1);	
?>
var notifications_js = [<? echo $ids; ?>];
</script>

<input style='position:fixed; bottom:0; left:0; background-color:#FF8000; font-weight:bold; width:300px;' type="button" value="Eliminar Notificaciones Atendidas" onClick="document.location.reload(true)" >
</body>
</html>
