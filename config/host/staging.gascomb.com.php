<?php
//https://sistema.gascomb.com/user_interface/ || http://desarrollo.grupome.com
//https://sistema.gascomb.com/multimedia/ || http://desarrollo-i2.grupome.com/ 
// /home/gascomb/secure_html/ || /home/grupome/public_html/dev_controlProcess/
define("DOMAIN", "http://staging.gascomb.com/");
define("COMPANY", "Staging");
define("PATH_DHTMLX_LIBRARY", "http://staging.gascomb.com/dhtmlxLibrary/");
define("PATH_USER_INTERFACE_AJAX", "http://staging.gascomb.com/ajax/");
define("PATH_MULTIMEDIA", "http://cdn-s.gascomb.com/");
define("PATH_MULTIMEDIA_BASE", '/home/gascomb/staging_secure_html/Develop-Gascomb/multimedia');
define("PATH_BASE_FOLDER", '/home/gascomb/staging_secure_html/Develop-Gascomb/');
define("PATH_CLASSES_FOLDER", '/home/gascomb/staging_secure_html/Develop-Gascomb/modules/classes/');
define("URL_MULTIMEDIA","http://cdn-s.gascomb.com/");
define("QR_IMAGE_URL",PATH_MULTIMEDIA."[id_folio]/_qrcode/qrcode.png");
define("PDF_URL",PATH_MULTIMEDIA."[id_folio]/pdf/[id_folio].pdf");
define("PATH_IMAGE_INVENTORY", "/multimedia/inventory/");
define("PATH_SERV", "/home/gascomb/staging_secure_html/Develop-Gascomb/");


// BD //
define("BD_USER", "root");
define("BD_PASSWORD", "AAKBgQCtNFZpXIDoab00ce0BeVe5Jqjgc+");
define("BD_DATABASE", "sistema_staging");
define("BD_SERVER", "localhost");

//header && nom
$headerpdf = '<span class="title_emp">GRUPO MECANICO EMPRESARIAL, S.A DE C.V</span><br/><br/>
			<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTR�NICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y M�CANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
			<span class="text_small">R.F.C. GME-951206-9K1   GME@AVANTE.NET<br/>
			TELS. 2693-2370, 5693-2276, 5693-4367</span>';
define("NOM-OFICIAL", "NOM-L");			
define("HEADER-PDF", $headerpdf);

// Variables Ampliaciones				
define("A_RECEIVER", "l._.m@hotmail.com");			
define("A_SENDER", "Gascomb <gascomb@gascomb.com>");			
define("A_SUBJECT", "Ampliaci�n de servicios");			
?>