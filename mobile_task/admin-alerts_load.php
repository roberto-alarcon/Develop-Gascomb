<?php
	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once (PATH_CLASSES_FOLDER.'class.alert.read.php'); 
$user = $Gascomb->session_user_id();
$alert = new Alert_Read($user);
$total = $alert->totalRows();
	
        echo '<h4>Resultados encontrados - ( '. $total .' )</h4>';
        $alert->doRows();
	
?>