<?php
	ini_set('display_errors', '1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');
	
	$Gascomb->loadUser(58);
	//$Alerts = new Alert(32);
	$total = $Gascomb->totalRows();
	
        echo '<h4>Resultados encontrados - ( '. $total .' )</h4>';
        $Gascomb->doRows();
	
?>