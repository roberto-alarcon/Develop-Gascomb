<?php
header("Content-type: text/xml");

// Enlistamos todos los elementos;
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include PATH_CLASSES_FOLDER.'class.checklist.php';

/*****************************
Get params for folio
*****************************/
$id = isset($_GET['folio_id'])?$_GET['folio_id']:0;
//$id = 204;

// Instanciamos la clase
$CheckList = new Checklist($id);
$elementos = $CheckList->listQualityElements();
//print_r($elementos);

$xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
$xml .= "<tree id='0'>";
$xml .= '<item text="Raiz" id="root" open="1" im0="lock.gif" im1="lock.gif" im2="iconSafe.gif" call="1" select="1">';

foreach( $elementos as $indice => $v){
    $xml .= '<item text="'.$v['label_activities'].'" id="'.$v['support_checklist_activities'].'_'.$v['checklist_folio_id'].'" im0="folderClosed.gif" im1="folderOpen.gif" im2="folderClosed.gif"></item>';

}

$xml .= "</item>";
$xml .= "</tree>";
echo $xml;
?>