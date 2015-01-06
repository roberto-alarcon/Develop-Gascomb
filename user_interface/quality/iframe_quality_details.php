<?php
    header('Content-Type: text/html; charset=iso-8859-1');
    ini_set('display_errors', '1');
    include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include PATH_CLASSES_FOLDER.'class.checklist.php';
    //include '../../modules/classes/class.checklist.form.php';
    
    $activity_id = $_GET['activity_id'];
    $cheklist_folio = $_GET['cheklist_folio'];
        
    ?>
    
    <!-- CSS goes in the document HEAD or added to your external stylesheet -->
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
    
        
    <?php
    $CheckList = new Checklist('204');
    $CheckList->checklist_id = $cheklist_folio;   
    $CheckList->createCheckListView($activity_id);
   
    
?>