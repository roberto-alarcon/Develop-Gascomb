<?php
	$folio = new Folio;			
	$folio = $folio->selectbyId($datas["folio_id"]);	
	$vehicles = new Vehicle;		
	$vehicle = $vehicles->selectbyId($folio["vehicles_record_id"]);	
	$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
	$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
	$dependency = new dependency;			
	$dependency_data = $dependency->selectbyId($folio["dependency_id"]);	
	$dependency_name = utf8_encode($dependency_data["name"]);
	
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
</head>
<body>
<table class="ecxinner frame" align="center" cellpadding="0" cellspacing="0" border="0" width="670" style="background:#fff;border:0;border-left:1px solid #ccc;border-right:1px solid #ccc;">
<tbody>
<tr>
<td> <a href="#" style="border:none;color:#0084b4;text-decoration:none;" target="_blank"><span class="ecxmedia_logo_div"></span></a>
<table cellpadding="0" cellspacing="0" border="0" width="670" class="header frame" style="background:#f2f2f2;table-layout:fixed;">
<tbody>
<tr>
<td class="ecxheader_left ecxcut" style="width:19px;height:77px;">&nbsp;  </td>
<td class="ecxcut" width="88"><span class="ecxheader_padding"><span class="ecxlogo_header ecxcut" style="line-height:100%;"><img  src="https://sistema.gascomb.com/img/logominimail.jpg" width="88" height="77" style="border:0;line-height:100%;border:0;" /></span></span></td>
<td class="ecxcut" width="9">&nbsp;</td>
<td width="10" height="94" class="ecxheader_padding">&nbsp;</td>
<td width="458" height="94" class="ecxmain_header ecxmedia_header" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;">
<table width="428" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td width="326" class="ecxmain_name" style="font-size:14px;font-weight:bold;color:#000;">Grupo Automotriz en Servicios de Combustibles, S.A. de C.V.</td>
</tr>
<tr>
  <td class="ecxsubtitle" style="font-size:14px;color:#666;"><span class="ecxsubtitle" style="font-size:14px;color:#666;">Solicitud de ampliaci&oacute;n de servicios</span></td>
</tr>
<tr>
<td class="ecxsubtitle" style="font-size:14px;color:#666;">Folio: 
  <?php echo $datas["folio_id"]; ?></td>
</tr>
</tbody>
</table> </td>
<td height="94" class="ecxheader_padding">&nbsp;</td>
</tr>
<tr>
<td class="ecxmain ecxheader_drop ecxcut" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">&nbsp;</td>
<td class="ecxmain ecxheader_drop ecxcut" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">&nbsp;</td>
<td class="ecxmain ecxheader_drop ecxcut" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">&nbsp;</td>
<td class="ecxmain ecxheader_drop ecxmedia_header" height="17" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;"><img width="1" height="1" style="display:block;border:0;" src="https://twitter.com/scribe/ibis?uid=109395599&amp;iid=8368a989-7877-4bc9-b9b6-f6df54ae56a8&amp;nid=12+20+20130808&amp;t=1"></td>
<td class="ecxmain ecxheader_drop ecxcut" height="17" colspan="2" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">&nbsp;</td>
</tr>
</tbody>
</table> </td>
<td rowspan="3"></td>
</tr>
<tr>
<td class="ecxcontent" style="background:#fff;">  <style>
@media only screen and (max-width: 480px) {
.ExternalClass table[class="ecxouter"] .ecxt-s p {
padding-right:10px !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-i img {
width:32px !important;
height:32px !important;
}
.ExternalClass table[class="ecxouter"] .ecxm-c, .ExternalClass table[class="ecxouter"] .ecxmid {
padding:0 !important;
}
.ExternalClass table[class="ecxouter"] .ecxo-t, .ExternalClass table[class="ecxouter"] .ecxhide {
display:none !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-ci {
padding-bottom:3px !important;
padding-top:12px !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-c {
border:none !important;
padding-left:10px;
padding-right:10px;
border-bottom:solid 11px #fff !important;
background:#fff !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-c td {
padding-top:0 !important;
}
.ExternalClass table[class="ecxouter"] .ecxx-c {
width:100% !important;
}
.ExternalClass table[class="ecxouter"] .ecxx-t {
font-size:9px !important;
}
.ExternalClass table[class="ecxouter"] .ecxs-i {
width:70px !important;
}
.ExternalClass table[class="ecxouter"] .ecxx-a {
width:170px !important;
text-align:center !important;
display:block !important;
}
.ExternalClass table[class="ecxouter"] .ecxx-a img {
}
.ExternalClass table[class="ecxouter"] .ecxx-b2 {
border-bottom:solid 1px #e8e8e8 !important;
height:10px !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-i {
width:32px !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-m {
}
.ExternalClass table[class="ecxouter"] .ecxt-t, .ExternalClass table[class="ecxouter"] .ecxs-t {
font-size:13px !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-u {
display:block !important;
}
.ExternalClass table[class="ecxouter"] .ecxt-s {
top:10px !important;
left:-40px !important;
width:140% !important;
}
.ExternalClass table[class="ecxouter"] .ecxdate {
left:-40px !important;
text-align:left !important;
}
.ExternalClass table[class="ecxouter"] .ecxmid.cta {
height:10px;
}
.ExternalClass table[class="ecxouter"] table.ecxaction {
width:320px !important;
}
.ExternalClass table[class="ecxouter"] .ecxo-c {
border-radius:0 !important;
}
.ExternalClass table[class="ecxouter"] .ecxo-m {
padding:0 !important;
background-color:#fff !important;
}
.ExternalClass table[class="ecxouter"] .ecxmedia_button {
}
}

@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
.ExternalClass table[class="ecxouter"] .ecxmedia_button td.ecxcut {
width:0 !important;
padding:0 !important;
}
}
</style>
<table style="" class="frame" width="670" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top">
<table width="520" align="center" border="0" cellspacing="0" cellpadding="0" class="ecxaction ecxm-c">
<tbody>
<tr>
<td class="ecxmid" style="padding:10px;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;padding:0;"><table class="ecxt-c" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 20px #fff;">
  <tbody>
  <tr>
  <td>
  <table class="ecxt-ci" width="100%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #d9d9d9;border-radius:4px;background:#FFF;">
  <tbody>
  <tr>
  <td><?php echo $datas["message"]; ?>&nbsp;</td>
  </tr>
  </tbody>
  </table> </td>
  </tr>
  </tbody>
</table></td>
</tr>
</tbody>
</table></td>
</tr>
<tr>
<td class="ecxcta">&nbsp;</td>
</tr>
</tbody>
</table> </td>
</tr>
<tr>
<td>
<table bgcolor="#eeeeee" border="0" cellpadding="0" cellspacing="0" width="670" class="frame footer" style="background-color:#eee;background-position:top;background-repeat:repeat-x;border-top-color:#ddd;border-top-style:solid;border-top-width:1px;">
<tbody>
<tr>
<td colspan="4" height="16" class="ecxfooter-padding-top"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><strong>Cliente: 
      <?php echo $vehicle["owner_name"]; ?></strong></td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxreset">Dependencia: 
      <?php echo utf8_decode($dependency_name); ?></span></td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxreset"><a href="#" class="address" style="border:none;color:#0084b4;text-decoration:none;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;text-decoration:none;font-size:11px;line-height:17px;color:#999999;text-shadow:0 1px 0 #fff;"><?php echo $vehicle["owner_adress"]; ?></a></span></td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><a href="#" class="address" style="border:none;color:#0084b4;text-decoration:none;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;text-decoration:none;font-size:11px;line-height:17px;color:#999999;text-shadow:0 1px 0 #fff;">Tel: <?php echo $vehicle["owner_phone"]; ?> | Cel: <span style="height: 19px"><?php echo $vehicle["owner_cell"]; ?></span>  | Email:<?php echo $vehicle["owner_email"]; ?></a></span></td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;">&nbsp;</td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><strong>Datos del autom&oacute;vil:</strong></td>
  <td class="col ecxcut" style="width:30px;"></td>
  </tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxreset"><?php echo $brand; ?> <?php echo $model ?>, Modelo <?php echo $vehicle["year"] ?></span></td>
  <td class="col ecxcut" style="width:30px;"></td>
  </tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;">Placas: <?php echo $vehicle["registration_plate"] ?> | Num. economico: <span style="height: 19px"><?php echo $vehicle["economic_number"] ?></span> | Cilindros: <?php echo $vehicle["cilinders"] ?> | Kms: <?php echo $vehicle["km"] ?></span></td>
  <td class="col ecxcut" style="width:30px;"></td>
  </tr>
<tr>
  <td class="col ecxcut" style="width:30px;"></td>
  <td class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;">&nbsp;</td>
  <td class="col ecxcut" style="width:30px;"></td>
</tr>
<tr>
  <td colspan="3" class="ecxfooter-padding-bottom" height="25"></td>
</tr>
</tbody>
</table>
<table bgcolor="#eeeeee" border="0" cellpadding="0" cellspacing="0" width="670" class="frame footer" style="background-color:#eee;background-position:top;background-repeat:repeat-x;border-top-color:#ddd;border-top-style:solid;border-top-width:1px;">
  <tbody>
    <tr>
      <td height="25" align="center" class="ecxfooter-padding-bottom"><span class="ecxfooter_body ecxmedia_footer" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:12px; line-height:17px; color:#777; text-shadow:0 1px 0 #fff;"><span class="ecxreset"><a href="#" class="address" style="border:none;color:#0084b4;text-decoration:none;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;text-decoration:none;font-size:11px;line-height:17px;color:#999999;text-shadow:0 1px 0 #fff;">Grupo Automotriz en Servicios de Combustibles, S.A. de C.V.</a></span></span></td>
    </tr>
    </tbody>
</table></td>
</tr>
</tbody>
</table>
</body>
</html>
