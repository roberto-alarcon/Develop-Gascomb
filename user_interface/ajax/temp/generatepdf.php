<?php
include_once '../../config/set_variables.php';
include "../../modules/classes/phpqrcode/qrlib.php"; 
    ob_start();
	$folio_id = $folio_data["folio_id"];
	$PNG_TEMP_DIR = PATH_MULTIMEDIA_BASE."/".$folio_id."/_qrcode/";
	if(is_dir($PNG_TEMP_DIR)==false){
				mkdir("$PNG_TEMP_DIR", 0755,true);		// Create directory if it does not exist
			}    
    $filename = $PNG_TEMP_DIR."qrcode.png";
	QRcode::png($folio_id, $filename, "Q", 5, 2);
	$imageqrcode = str_replace("[id_folio]", $folio_id, QR_IMAGE_URL);
	//print_r($vehicle); exit(0);
?>
<style type="text/css">
<!--
table{
	border-collapse: collapse;
}
table tr td{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	border-collapse: collapse;
	height: 12px;
}

.text_medium {
	font-size: 10px;
}
.text_small {	font-size:8px;    
}
.title_emp {    font-size:18px;    
}
table.woborder {	border-width: 1px;
	border-spacing: 2px;
	border-style: none;
	border-color: white;
	border-collapse: separate;
	background-color: white;
}

table.gradienttable {
	font-family: Arial;
	font-size:11px;
	color:#4F4F4F;
	border-width: 1px;
	border-color: #636363;
	border-collapse: collapse;
	font-size: 9px;
}
table.gradienttable th {
	padding: 0px;
	background: #dddddd;
	font-size: 9px;
	border: 1px solid #dddddd;
}
table.gradienttable td {
	padding: 0px;
	background-image: linear-gradient(bottom, rgb(242,239,242) 0%, rgb(255,255,255) 100%);
	background-image: -o-linear-gradient(bottom, rgb(242,239,242) 0%, rgb(255,255,255) 100%);
	background-image: -moz-linear-gradient(bottom, rgb(242,239,242) 0%, rgb(255,255,255) 100%);
	background-image: -webkit-linear-gradient(bottom, rgb(242,239,242) 0%, rgb(255,255,255) 100%);
	background-image: -ms-linear-gradient(bottom, rgb(242,239,242) 0%, rgb(255,255,255) 100%);
	background-image: -webkit-gradient(linear,left bottom, left top, color-stop(0, rgb(242,239,242)),color-stop(1, rgb(255,255,255)) );
	font-size: 9px;
	border: 1px solid #ededed;
}
table.gradienttable th p{
	margin:0px;
	padding:4px;
	border-bottom:0px;
	border-right:0px;
}
table.gradienttable td p{
	margin:0px;
	padding:4px;
	border-bottom:0px;
	border-right:0px;
}

-->
</style>
<page backcolor="#FEFEFE"  backtop="0" backbottom="30mm" style="font-size: 12pt">
    <bookmark title="Document" level="0" ></bookmark>
  
    <table cellspacing="0" style="width:90%;">
      <tr>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110" ></td>
        <td style="width: 80%; text-align: center; padding:15px"><span class="title_emp">GRUPO MECANICO EMPRESARIAL, S.A DE C.V</span><br/><br/>
					<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTRÓNICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y MÉCANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
					<span class="text_small">R.F.C. GME-951206-9K1   GME@AVANTE.NET<br/>
					TELS. 2693-2370, 5693-2276, 5693-4367</span></td>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110"></td>
      </tr>
    </table>
    <br>
   <table style="width: 90%; " cellpadding="0" cellspacing="0">
            <tr>
                <td style="text-align: left; width: 50%; height: 25;" class="auto-style6">&nbsp;</td>
                <td style="text-align: center; width: 25%; height: 25px;" >
					No. DE FOLIO: <?php echo $folio_data["folio_id"]; ?></td>
				<td style="width: 25%; height: 25px;">ORDEN DE SERVICIO: <?php echo $folio_data["order_number"]; ?></td>
            </tr>
        </table>
    <table border="1" cellpadding="3" cellspacing="0" style="width: 93%;">
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" >NOMBRE: <?php echo $folio_data["owner_name"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > MARCA: <?php echo $brand; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > TIPO: <?php echo $model; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >PLACAS: <?php echo $folio_data["registration_plate"]; ?></td>
      </tr>
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" > DIRECCIÓN: <?php echo $folio_data["owner_adress"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > FOLIO: <?php echo $folio_data["folio_id"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > FECHA DE RECIBO: <?php echo $folio_data["entry_date"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >HORA: <?php echo $folio_data["entry_time"]; ?></td>
      </tr>
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" >TEL.: <?php echo $folio_data["owner_phone"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > No.
          ECONOMICO: <?php echo $vehicle["economic_number"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > FECHA DE ENTREGA: <?php echo $folio_data["departure_date"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >HORA: <?php echo $folio_data["departure_time"]; ?></td>
      </tr>
      <tr>
        <td rowspan="2"><span style="text-align: left; width: 40%; ">POR 
		REPARAR:</span></td>
        <td class="sample" style="text-align: left; width: 20%; " > AÑO: <?php echo $vehicle["year"]; ?></td>
        <td class="sample" style="text-align: left; width: 20%; " > CILINDROS: <?php echo $vehicle["cilinders"]; ?></td>
        <td class="sample" style="text-align: left; width: 20%; " >KMS: <?php echo $vehicle["km"]; ?></td>
      </tr>
      <tr>
        <td colspan="3"><span style="text-align: left; height: 25px;">FALLA</span></td>
      </tr>
      <tr>
        <td colspan="4" align="center">DETALLES</td>
      </tr>
      <tr>
        <td colspan="4"><?php echo $folio_data["details"]; ?></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table class="woborder" style="90%">
          <tr>
            <td style="height: 16px;">DESPUES DE HABER REVISADO Y PROBADO EL 
          AUTOMOVIL QUE DEJE A REPARACIÓN , ME MANIFIESTO CONFORME CON LOS 
          TRABAJOS REALIZADOS DANDOME POR RECIBIDO EN ESTE MOMENTO DE 
          TODAS LAS REFACCIONES Y PIEZAS USADAS QUE LE FUERON CAMBIADAS AL 
        VEHICULO</td>
          </tr>
        </table>
         </td>
      </tr>
      <tr>
        <td colspan="2" rowspan="4"><span style="text-align: center; width: 20%; "> <br>
            <br>
            <br>
FIRMA DEL CLIENTE:</span></td>
<td><span style="text-align: left; width: 20%; height: 11px;">CONCEPTO</span></td>
        <td><span style="text-align: center; width: 20%; height: 11px;">CLIENTE</span></td>
      </tr>
      <tr>
        <td><span style="text-align: left; width: 20%; height: 11px;">SUBTOTAL</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>IVA</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>TOTAL</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table class="woborder" style="90%">
        <tr>
              <td style="height: 16px; width:60%"><span style="text-align: left; height: 15px;"><strong> OBSERVACIONES</strong>:<br>
                  <span class="text_small">POR MEDIO DE LA PRESENTE ME PERMITO 
				ORDENAR A USTEDES LLEVAR ACABO LOS SERVICIOS DE MANTENIMIENTO Y 
				REPARACIONES ESTIPULADOS EN LA PARTE SUPERIOR DE LA ORDEN DE 
				SERVICIO Y AUTORIZO SE INSTALEN LAS REFACCIONES NECESARIAS( LAS 
				CUALES SE COBRARÃƒÂN APARTE) AL VEHICULO AQUI DESCRITO Y QUE EN 
				ESTA FECHA QUEDA DEPOSITADO EN SUS TALLERES.<br>
AUTORIZO ELUSO 
				DEL VEHICULO DENTRO DE LOS LIMITES DE ESTA CIUDAD PARA EFECTOS 
				DE PRUEBA O INSPECCION DE LAS REPARACIONES EFECTUADAS.<br>
ACEPTO 
				QUE LA EMPRESA NO SE HACE RESPONSABLE POR PERDIDAS DE LOS 
				ARTICULOS QUE SE DEJEN DENTRO DE LOS VEHICULOS, NI POR DAÃƒâ€˜OS A 
				LAS UNIDADES POR CAUSAS DE FUERZA MAYOR<br>
LA GARANTÍA DEL 
				TRABAJO QUEDA REGULADA POR LOS TERMINOS DEL ART. 40 DE LA LEY 
				FEDERAL DE PROTECCIÓN AL CONSUMIDOR.<br>
CUALQUIER DEFICIENCIA EN 
				LA PRESTACIÓN DEL SERVICIO DEBERÁ RECLAMARSE DENTRO DE LOS 30 
				DIAS SIGUIENTES A LA ENTREGA DEL VEHICULO.<br>
AL RECIBIR EL 
				AVISO DE ESTAR TERMINADO EL TRABAJO, ME COMPROMETO A PRESENTARME 
				EN EL TALLER EN UN PLAZO DE 24 HORAS PARA EXPRESAR MI 
				CONFORMIDAD O MI INCONFORMIDAD CON LOS TRABAJOS REALIZADOS, 
				OBLIGANDOME EN EL PRIMER CASO A LIQUIDAR EL IMPORTE DE LOS 
				MISMOS DENTRO DE LAS 24 HORAS SIGUIENTES Y DE NO HACERLO, PAGARÉ 
				ALMACENAJE, CUYA TARIFA NO PODRÁ SER MAYOR A LA OFICIAL EN VIGOR 
				AUTORIZADA; CONSTITUYENDOSE, DESDE ESE MOMENTO PRENDA SOBRE MI 
				VEHICULO LA QUE SE SUJETARÃƒÂ A LOS DISPUESTO POR EL ARTICULO 334 
				DE LA LEY GENERAL DE TITULOS Y OPERACIONES DE CREDITO Y EN LA 
				INTELIGENCIA DE QUE LOS DERECHOS ESTABLECIDOS POR EL ACREEDOR EN 
				LOS ARTICULOS 340,341 Y 342 DE LA MISMA LEY PODRÁN SER 
				EJERCITADOS TRANSCURRIDOS 30 DIAS DE LA CONSTITUCION DE LA 
				PRENDA, AL RECOGER EL AUTOMOVIL SOLICITO ME ENTREGUEN LAS 
				REFACCIONES USADAS.<br>
          </span></span></td>
              </tr>
          </table>
          <table class="woborder" style="90%">
            <tr>
              <td style="height: 16px; width:60%"><span class="text_small"> <br>
                AUTORIZO LA REPARACION DEL VEHICULO POR 
                LO QUE SEA NECESARIO.&nbsp; AUTORIZO LA REPARACION DEL VEHICULO 
                HASTA <br>POR LA CANTIDAD DE $<br>
                EL PAGO DE ESTA ORDEN DE SERVICIO 
                SERÁ AL RIGUROSO CONTADO.<br>
                GARANTIA:&nbsp; CONTRATO DE 
                ADHESIÓN DE PRESTACIÓN DE SERVICI
                OS PARA LA REPARACION Y <br>
                DE VEHICULOS_______________________ 
                NOM-068-scfi/2000 LODO CON NUMERO DE EXPEDIENTE<br>
                416/2500-97 OFICIO 9784 </span></td>
              <td align="right" style="height: 16px; width:40%">FIRMA DEL CLIENTE</td>
            </tr>
        </table></td>
      </tr>
    </table>
    <br>
 <page_footer>
       	<span class="text_medium"><span class="text_medium">GRUPO MECANICO EMPRESARIAL, S.A DE C.V &nbsp; &nbsp; 5 DE MAYO No.105 COL- FRANCISCO VILLA, C.P. 09720, MÉXICO, D.F. TELS.: 5693-2370, 5693-2276, 5693-4367
		</span></span><br/><br/>
</page_footer>
</page>

<page format="180x210" orientation="L"  style="font: arial;">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width:90%;">
      <tr>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110" ></td>
        <td style="width: 80%; text-align: center; padding:15px"><span class="title_emp">GRUPO MECANICO EMPRESARIAL, S.A DE C.V</span><br/><br/>
					<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTRÓNICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y MÉCANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
					<span class="text_small">R.F.C. GME-951206-9K1   GME@AVANTE.NET<br/>
					TELS. 2693-2370, 5693-2276, 5693-4367</span></td>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110"></td>
      </tr>
    </table>


<table width="100%" class="gradienttable"  border="1" cellpadding="3" cellspacing="0" >
  <tr style="background: #DDD; height: 14px;">
    <td colspan="4" style="height: 14px;"><p>NOMBRE RESPONSABLE DE LA UNIDAD: <?php echo $folio_data["vehicle_operator"]; ?></p></td>
    <td colspan="6" style="height: 14px;"><p>TELEFONO OPERADOR: <?php echo $folio_data["operator_tel"]; ?></p></td>
    <td colspan="5" style="height: 14px;"><p>GASOLINA:</p></td>
  </tr>
  <tr style="background:#EDEDED">
    <td style="width:15%;"><p>PIEZA</p></td>
    <td style="width:2.5%"><p>SI</p></td>
    <td style="width:2.5%"><p>NO</p></td>
    <td style="width:15%"><p>PIEZA</p></td>
    <td style="width:2.5%"><p>SI</p></td>
    <td style="width:2.5%"><p>NO</p></td>
    <td height="10" style="width:15%"><p>PIEZA</p></td>
    <td style="width:2.5%"><p>SI</p></td>
    <td style="width:2.5%"><p>NO</p></td>
    <td style="width:15%"><p>PIEZA</p></td>
    <td style="width:2.5%"><p>SI</p></td>
    <td style="width:2.5%"><p>NO</p></td>
    <td style="width:15%"><p>PIEZA</p></td>
    <td style="width:2.5%"><p>SI</p></td>
    <td style="width:2.5%"><p>NO</p></td>
  </tr>
  <?php 
  
  $keys = array_keys($Inventory);
		  $filas = 18; $columnas = 5; $contador = 1;		  


		 //Iniciamos el bucle de las filas
		 for($t=0;$t<18;$t++){
		  echo "<tr class='bg_tr' style='height: 8px'>";
		  //Iniciamos el bucle de las columnas
		  for($y=0;$y<5;$y++){
			if ($contador == "88" || $contador == "89"){
				echo "<td style='width:15%; height: 8px;'></td>";
				echo "<td style='width:2.5%; height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";
				$contador++;
			}elseif($contador == "90"){
				echo "<td style='width:15%; height: 8px;'></td>";
				echo "<td style='width:2.5% height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";				
				$contador++;
			}else{
				$value = $keys[$contador];
				echo "<td style='width:15%;height: 8px;'><p>".ucfirst(str_replace('_', ' ', $keys[$contador]))."</p></td>";
					if($Inventory[$value] == "1"){
						echo "<td style='width:2.5%;height: 8px;'><img src='../img/chekbox_image.png'></td><td style='width:2.5%;height: 8px;'>&nbsp;</td>";
					}else{
						echo "<td style='width:2.5%;height: 8px;'>&nbsp;</td><td style='width:2.5%;height: 8px;'></td>";
					} 
				//echo "<td style='padding:3px;'>".$keys[$contador].$Inventory[$value].$contador."</td>";			
				$contador++;
			}
		  
		   }
		   //Cerramos columna
		   echo "</tr>";
		  }

  
  
  
  /*
  $si = "1";
  	for ($i=0; $i<10; $i++) {
		echo "<tr>";
		for ($e=0; $e<5; $e++){
			echo "<td style='width:15%'>producto</td>";
				if($si = "1"){
					echo "<td style='width:2.5%'>SI</td><td style='width:2.5%'>&nbsp;</td>";
				}else{
					echo "<td style='width:2.5%'>&nbsp;</td><td style='width:2.5%'>NO</td>";
				} 
		}
		echo "</tr>";	
		
		}*/
  ?>

  <tr>
    <td colspan="15"><p><strong>RECIBIÓ LA UNIDAD:</strong></p></td>
  </tr>
  <tr>
    <td colspan="15"><p><strong>DETALLAR GOLPES Y OBSERVACIONES:</strong></p></td>
  </tr>
  <tr>
    <td colspan="15" align="center"><?php echo $folio_data["details"]; ?></td>
  </tr>
  <tr>
    <td colspan="15" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="15" align="center">ORDEN DE SERVICIO: <?php echo $folio_data["folio_id"]; ?></td>
  </tr>
</table>
<page_footer>
       	<span class="text_medium"><span class="text_medium">GRUPO MECANICO EMPRESARIAL, S.A DE C.V &nbsp; &nbsp; 5 DE MAYO No.105 COL- FRANCISCO VILLA, C.P. 09720, MÉXICO, D.F. TELS.: 5693-2370, 5693-2276, 5693-4367
		</span></span><br/><br/>
</page_footer>
</page>

<?php
     $content = ob_get_clean();
	 //$id_folio = $Inventory["inventory_id"];
	
	$id_folio = isset($folio_id) ? 	$folio_id : "30";
    // convert
    //require_once(dirname(__FILE__).'/../html2pdf.class.php');
	require_once(PATH_CLASSES_FOLDER.'html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$directorypdf = PATH_MULTIMEDIA_BASE."/".$id_folio."/pdf/";
		$filepdf = PATH_MULTIMEDIA_BASE."/".$id_folio."/pdf/".$id_folio.".pdf";		
		if(is_dir($directorypdf)==false){
				mkdir("$directorypdf", 0755,true);		// Create directory if it does not exist
			}
		$html2pdf->Output($filepdf, 'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>