<?php
ini_set('display_errors', '1');
header('Content-Type: application/json');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once (PATH_CLASSES_FOLDER.'class.mobile.folio.php');

$folio_mobile = new FoliosMobiles;
$folios_mobile = $folio_mobile->selectAllPending();
$ipad_pending = array();

#echo "<pre>"; print_r($folios_mobile); echo "</pre>"; die();
foreach ($folios_mobile as $clave => $valor) {
			    $qrcode = "";
				$dependency = "";
				$dependency = $folio_mobile->getDependency($valor['dependency_id']);
				$qrcode = $folio_mobile->getUrlqrcode($valor["folio_id"]);
				
				$pad_pending[$clave]['folio'] = $valor["folio_id"];
				$pad_pending[$clave]['url_qrcode'] = $qrcode;
				$pad_pending[$clave]['dependency'] = utf8_encode($dependency);
				$pad_pending[$clave]['plate'] = $valor['registration_plate'];
				$pad_pending[$clave]['company'] = "Gascomb";				
}
#echo "<pre>"; print_r($pad_pending); echo "</pre>"; die();
echo json_encode($pad_pending);

?>
