<?php
$fileLog = '/home/gascomb/secure_html/multimedia/'.$_GET["folio_id"].'/activityLog';


if(file_exists($fileLog)){
	$fh = fopen($fileLog,'r');
	$lines = '';
	while ( ($buf=fread( $fh, 8192 )) != '' ) {		
		list($fecha,$texto)=explode("|",$buf);
		$lines.='<tr><td><b>'.$fecha.'</b></td><td><div style="margin-left:33px;">'.$texto.'</div></td></tr>';
}
	fclose($fh);	
} else { $lines = "sin historial registrado"; }
?><html>
<head>
	<title>Visor de Logs</title>
	<style>
		.divViewLog { font-family:"Courier New", Courier, monospace; font-size:12px; margin:5px;  }
	</style>
</head>
<body>

<div class="divViewLog">
	<?php
echo 'Entramos<br><br>';
echo 'Entramos<br><br>';
echo 'Entramos<br><br>';
echo $fileLog.'<br><br>';
?>
	
	<table>
		
		
		
		<?=$lines?>
	</table>
</div>
</body>
</html>