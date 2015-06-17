<?php
ini_set('display_errors', '1');
header('Content-Type: application/json');
include_once ('../../modules/classes/class.mobile.folio.global.php');

$folio_mobile = new FoliosMobiles;
$folios_mobile = $folio_mobile->selectAllPending();
$ipad_pending = array();

#echo "<pre>"; print_r($folios_mobile); echo "</pre>"; die();
if(isset($folios_mobile) && $folios_mobile != null && count($folios_mobile) > 0){
	foreach ($folios_mobile as $clave => $valor) {
		$qrcode = "";
		$dependency = "";
		
		if ($valor['company'] == "Gascomb"){
		  $c = 1;
		}else if($valor['company'] == "PT Service"){
		  $c = 2;
		}
		
		$dependency = $folio_mobile->getDependency($valor['dependency_id'],$c);
		$qrcode = $folio_mobile->getUrlqrcode($valor["folio_id"],$c);
		
		$pad_pending[$clave]['folio'] = $valor["folio_id"];
		$pad_pending[$clave]['url_qrcode'] = $qrcode;
		$pad_pending[$clave]['dependency'] = utf8_encode($dependency);
		$pad_pending[$clave]['plate'] = $valor['registration_plate'];
		$pad_pending[$clave]['company'] = $valor['company'];
	}
} else {
	$pad_pending[0]['folio'] = "";
	$pad_pending[0]['url_qrcode'] = "";
	$pad_pending[0]['dependency'] = "";
	$pad_pending[0]['plate'] = "";
	$pad_pending[0]['company'] = "";	    	
}	
#echo "<pre>"; print_r($pad_pending); echo "</pre>"; die();
echo json_encode($pad_pending);

?>
