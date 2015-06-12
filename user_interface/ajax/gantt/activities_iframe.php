<?php $id= $_REQUEST["folio"]; ?>
<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
</head>

<body>
<iframe style="width:100%;height:600px" frameBorder="0" src="./ajax/gantt/gantt_demo.php?tab_height=650&folio=<?php echo $id;?>"></iframe>
</body>

</html>