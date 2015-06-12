<?php
	
	// Enlistamos todos los elementos;
	header('Content-Type: text/html; charset=iso-8859-1');
	ini_set('display_errors', '1');
	include_once('/home/gascomb/secure_html/config/set_variables.php');	
	include PATH_CLASSES_FOLDER.'class.checklist.php';
	
	/*****************************
	Get params for folio
	*****************************/
	$id = isset($_GET['folio'])?$_GET['folio']:0;
	$id = 204;
	
	// Instanciamos la clase
	$CheckList = new Checklist($id);
	$elementos = $CheckList->listQualityElements();
        
        $error_icon     = 'http://mobile-quality.gascomb.com/img/error-icon.png';
        $select_icon    = 'http://mobile-quality.gascomb.com/img/Select-icon.png';
        $rate_icon      = 'http://mobile-quality.gascomb.com/img/rate-icon.png';
        
        foreach( $elementos as $indice => $v){

                $img = $error_icon;
                
                if($v['status'] == 1){
                        $img = 	$select_icon;	
                }elseif($v['status'] == 2){
                        $img = 	$error_icon;
                }
                
                echo '<img src="'.$img.'">&nbsp;&nbsp;<a href="./iframe_quality_details.php?cheklist_folio='.$v['checklist_folio_id'].'&activity_id='.$v['support_checklist_activities'].'&tab=1" data-ajax="false">'.$v['label_activities'].'</a><br>' ;
                
        }

?>