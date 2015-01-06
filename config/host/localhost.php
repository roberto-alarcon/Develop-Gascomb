<?php
define("DOMAIN", "http://localhost/");
define("PATH_DHTMLX_LIBRARY", "http://localhost/user_interface/dhtmlxLibrary/");
define("PATH_USER_INTERFACE_AJAX", "http://localhost/user_interface/ajax/");
define("PATH_MULTIMEDIA", "http://localhost/multimedia/");
define("PATH_MULTIMEDIA_BASE", '/Applications/XAMPP/htdocs/multimedia');
define("PATH_BASE_FOLDER", '/Applications/XAMPP/htdocs/');
define("PATH_CLASSES_FOLDER", '/Applications/XAMPP/htdocs/modules/classes/');
define("URL_MULTIMEDIA","http://localhost/multimedia/");
define("QR_IMAGE_URL",PATH_MULTIMEDIA."[id_folio]/_qrcode/qrcode.png");
define("PDF_URL",PATH_MULTIMEDIA."[id_folio]/pdf/[id_folio].pdf");
define("PATH_IMAGE_INVENTORY", "/multimedia/inventory/");
define("PATH_SERV", "/Applications/XAMPP/htdocs/");
// BD // 

define("BD_USER", "root");
define("BD_PASSWORD", "");
define("BD_DATABASE", "develop_gascomb");
define("BD_SERVER", "localhost");
//header && nom
$headerpdf = '<span class="title_emp">GRUPO MECANICO EMPRESARIAL, S.A DE C.V</span><br/><br/>
			<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTR���NICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y M���CANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
			<span class="text_small">R.F.C. GME-951206-9K1   GME@AVANTE.NET<br/>
			TELS. 2693-2370, 5693-2276, 5693-4367</span>';
define("NOM-OFICIAL", "NOM-L");			
define("HEADER-PDF", $headerpdf);
// Variables Ampliaciones				
define("A_RECEIVER", "l._.m@hotmail.com");			
define("A_SENDER", "Gascomb <gascomb@gascomb.com>");			
define("A_SUBJECT", "Ampliación de servicios");
?>