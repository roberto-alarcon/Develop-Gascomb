<?php
    header('Content-Type: text/html; charset=iso-8859-1');
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
        
    $activity_id = $_GET['activity_id'];
    $cheklist_folio = $_GET['cheklist_folio'];
    
    $CheckList = new Checklist('204');
    $CheckList->checklist_id = $cheklist_folio;

    
    
    echo '<form name="QualityForm" action="quality_insert_update_form.php?cheklist_folio='.$cheklist_folio.'" method="post">';
    
    $CheckList->createCheckListForm($activity_id);
    
    echo '<input type="submit" value="Submit">';
    echo '</form><hr>';
    
    $CheckList->createCheckListView($activity_id);
   
    
?>