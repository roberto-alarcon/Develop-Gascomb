<?php
header('Content-Type: text/html; charset=iso-8859-1');
include_once('/home/gascomb/secure_html/config/set_variables.php');
$Gascomb->session_folio($_GET['folio_id']);

?>

<style>
         
		.font  { font-family:"Courier New", Courier, monospace; font-size:12px; margin:5px; }
		
		
		

</style>
<html>
<div class="font">
<table width=100%><tr>
<?php  
foreach($Gascomb->getLogsFolio() as $key => $value){
	echo '<tr>';
	echo '<td width="150px"><strong>'.$value['datetime'].'</strong></td>';
	echo '<td width="250px"><b>'.$value['user_name'].'</b></td>';
	echo '<td><b>'.$value['message'].'</b></td></tr>';

}

 ?> 
</table> 
</div>
</html>