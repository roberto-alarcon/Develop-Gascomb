<?
	if(empty($_REQUEST["userId"]))
		die("invalid session");
	$userId=$_REQUEST["userId"];
	include_once("../../modules/classes/class.notifications.php");
	$notifications = new Notifications();
	$array_notifications = $notifications->selectbyUserId($userId);	
	echo json_encode($array_notifications);
?>