<?php
    
    header('Content-Type: text/html; charset=iso-8859-1');
    include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
    
     $CheckList = new Checklist('204');
     $elementos = $CheckList->listQualityElements();
     //print_r($elementos);
     
     
     foreach( $elementos as $indice => $v){
        
        echo '<a href="instances_quality.php?cheklist_folio='.$v['checklist_folio_id'].'&activity_id='.$v['support_checklist_activities'].'">'.$v['label_activities'].'</a><br>' ;
        
     }
     


?>