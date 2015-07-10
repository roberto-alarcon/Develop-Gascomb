<?php
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'phpqrcode/qrlib.php'; 
include_once PATH_CLASSES_FOLDER.'class.users.php';	
include_once PATH_CLASSES_FOLDER.'class.type_activities.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.employees.php';

    ob_start();
	$folio_id = $folio_data["folio_id"];
	$PNG_TEMP_DIR = PATH_MULTIMEDIA_BASE."/".$folio_id."/_qrcode/";
	$filename = $PNG_TEMP_DIR."qrcode.png";
	$imageqrcode = $filename;
    
		
	$employee = new Employee;
	$result_receiver = $employee->selectbyId($folio_data["received_by"]);
	$recibe_unidad = $result_receiver["name"]." ".$result_receiver["last_name"];
	
	/*$user = new Users;
	$result_receiver = $user->selectbyId($folio_data["received_by"]);
	$recibe_unidad = utf8_encode($result_receiver["name"])." ".utf8_encode($result_receiver["last_name"]);*/
	$type_act = new Type_activities;
	$type_activity = $type_act->selectbyId($folio_data["type_service"]);
	$type_activity =  utf8_encode(strtr(strtoupper($type_activity["name"]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));//utf8_encode(strtoupper($type_activity["name"]));
	$dependency = new dependency;			
	$dependency_data = $dependency->selectbyId($folio_data["dependency_id"]);	
	$dependency_name =  strtoupper(utf8_encode($dependency_data["name"]));
	$f_activity = new FloorActivity; 
	$folioidd["folio_id"] = $folio_data["folio_id"];
	$activities = $f_activity->selectbyColumn($folioidd, 100);
	
	function getFuelLevel($percentage){
		$return = '';
		if($percentage >= 0 and $percentage <= 12){
			$return = 'VACIO';
		}
		if($percentage >= 13 and $percentage <= 37){
			$return = 'CUARTO';
		}
		if($percentage >= 38 and $percentage <= 63){
			$return = 'MEDIO';
		}
		if($percentage >= 64 and $percentage <= 85){
			$return = '3/4';
		}
		if($percentage >= 86 and $percentage <= 100){
			$return = 'LLENO';
		}
		return $return;
	}
	
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
.title_emp {    font-size:16px;    
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
        <td style="width: 80%; text-align: center; padding:15px"><span class="title_emp"><?php echo NAME_COMPANY; ?> <br/>S.A. DE C.V.</span><br/><br/>
					<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTRÓNICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y MÉCANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
					<span class="text_small">R.F.C. GAS0505116J2<br/>
					TELS. 1546-2395,  2608-6865</span></td>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110"></td>
      </tr>
    </table>
    <br>
   <table style="width: 100%; " cellpadding="0" cellspacing="0">
	<tr>
	  <td align="left"style="text-align: left; width: 33.3%; height: 25;" class="auto-style6">&nbsp;</td>
	  <td align="center"style="text-align: center; width: 33.3%; height: 25px;" ><span class="auto-style6" style="font-size:14px; text-align: left; width: 33.3%; height: 25;">No. DE FOLIO: <?php echo $folio_data["folio_id"]; ?></span></td>
	  <td align="right" style="text-align: right; width: 33.3%; height: 25px;">&nbsp;</td>
     </tr>
	<tr>
		<td align="left"style="text-align: left; width: 33.3%; height: 25;" class="auto-style6"><span style="text-align: left; width: 20%; height: 14px;">TORRE: <?php echo $folio_data["tower"]; ?></span></td>
		<td align="center"style="text-align: center; width: 33.3%; height: 25px;" ><span style="text-align: left; width: 20%; height: 14px;">PLACAS: <?php echo $folio_data["registration_plate"]; ?></span></td>
		<td align="right" style="text-align: right; width: 33.3%; height: 25px;">ORDEN DE TRABAJO(CLIENTE): <?php echo $folio_data["order_number"]; ?></td>
	</tr>
</table>
    <table border="1" cellpadding="3" cellspacing="0" style="width: 90%;">
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" >NOMBRE: <?php echo utf8_encode($folio_data["owner_name"]); ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" > FECHA DE RECIBO:<br><?php echo $folio_data["entry_date"].' '.$folio_data["entry_time"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >MARCA: <?php echo  strtoupper(utf8_encode($brand)); ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >TIPO: <?php echo  strtoupper(utf8_encode($model)); ?></td>
      </tr>
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" > DIRECCIÓN: <?php echo utf8_encode($folio_data["owner_adress"]); ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >AREA/SECTOR: <?php echo utf8_encode($folio_data["area_sector"]); ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >No.
        ECONOMICO: <?php echo $vehicle["economic_number"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" ><span class="sample" style="text-align: left; width: 20%; ">KMS: <?php echo $vehicle["km"]; ?></span></td>
      </tr>
      <tr class="sample">
        <td style="text-align: left; width: 40%; height: 14px;" >TEL.: <?php echo $folio_data["owner_phone"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" >ZONA: <?php echo $folio_data["zone"]; ?></td>
        <td style="text-align: left; width: 20%; height: 14px;" ><span class="sample" style="text-align: left; width: 20%; ">AÑO: <?php echo $vehicle["year"]; ?></span></td>
        <td style="text-align: left; width: 20%; height: 14px;" >VIN: <?php echo $folio_data["vin"]; ?></td>
      </tr>
      <tr>
        <td rowspan="2"><span style="text-align: left; width: 40%; ">CLIENTE: <?php echo $dependency_name; ?></span></td>
        <td class="sample" style="text-align: left; width: 20%; " > <span style="text-align: left; width: 20%; height: 14px;">TORRE: <?php echo $folio_data["tower"]; ?></span></td>
        <td class="sample" style="text-align: left; width: 20%; " ><span style="text-align: left; width: 20%; height: 14px;"><span class="sample" style="text-align: left; width: 20%; ">CAJON: <?php echo utf8_encode($folio_data["parking_space"]); ?></span></span></td>
        <td class="sample" style="text-align: left; width: 20%; " >CILINDROS: <?php echo $vehicle["cilinders"]; ?></td>
      </tr>
      <tr>
        <td colspan="3"><span style="text-align: left; height: 25px;">TIPO DE SERVICIO: <?php echo $type_activity; ?></span></td>
      </tr>
      <tr style="background:#EDEDED">
        <td colspan="4" align="center"><strong>SERVICIOS A REALIZAR:</strong></td>
      </tr>
	  <?php
		if($activities){
			$i=1;
			foreach($activities as $value){
				if($value["description"] !== ""){
					echo "<tr>
						<td colspan='4' align='left'>&nbsp;&nbsp;$i.- ". utf8_encode($value["description"])."</td>
					  </tr>";
					$i++;
				}
			}
		}else{
			echo "<tr>
						<td colspan='4' align='left'>&nbsp;</td>
					  </tr>";
		}
		?>
      
	  <tr style="background:#EDEDED">
        <td colspan="4" align="center"><strong>FALLAS:</strong></td>
      </tr>
	  <tr>
        <td colspan="4"><?php echo utf8_encode($folio_data["failures"]); ?></td>
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
              <td style="height: 16px; width:60%"><span style="text-align: left; height: 15px;"><strong>OBSERVACIONES</strong>:<br>
                  <span class="text_small">POR MEDIO DE LA PRESENTE ME PERMITO 
				ORDENAR A USTEDES LLEVAR ACABO LOS SERVICIOS DE MANTENIMIENTO Y 
				REPARACIONES ESTIPULADOS EN LA PARTE SUPERIOR DE LA ORDEN DE 
				SERVICIO Y AUTORIZO SE INSTALEN LAS REFACCIONES NECESARIAS( LAS 
				CUALES SE COBRARÁN APARTE) AL VEHICULO AQUI DESCRITO Y QUE EN 
				ESTA FECHA QUEDA DEPOSITADO EN SUS TALLERES.<br>
AUTORIZO ELUSO 
				DEL VEHICULO DENTRO DE LOS LIMITES DE ESTA CIUDAD PARA EFECTOS 
				DE PRUEBA O INSPECCION DE LAS REPARACIONES EFECTUADAS.<br>
ACEPTO 
				QUE LA EMPRESA NO SE HACE RESPONSABLE POR PERDIDAS DE LOS 
				ARTICULOS QUE SE DEJEN DENTRO DE LOS VEHICULOS, NI POR DAÑOS A 
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
				VEHICULO LA QUE SE SUJETARÁ A LOS DISPUESTO POR EL ARTICULO 334 
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
       	<span class="text_medium"><span class="text_medium"><?php echo NAME_COMPANY; ?> S.A. DE C.V. &nbsp; &nbsp; CALLE 2a ORIENTE SUR  #750 COL. SAN ROQUE, TUXTLA GUTIERREZ CHIAPAS C.P. 29040
		</span></span><br/><br/>
</page_footer>
</page>

<page format="200x210" orientation="L"  style="font: arial;">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width:90%;">
      <tr>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110" ></td>
        <td style="width: 80%; text-align: center; padding:15px"><span class="title_emp"><?php echo NAME_COMPANY; ?> <br/>S.A. DE C.V.</span><br/><br/>
					<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTRÓNICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y MÉCANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
					<span class="text_small">R.F.C. GAS0505116J2<br/>
					TELS. 1546-2395,  2608-6865</span></td>
        <td style="width: 10%;"><img src="<?php echo $imageqrcode; ?>" width="110" height="110"></td>
      </tr>
    </table>

<table style="width: 100%; " cellpadding="0" cellspacing="0">
	<tr>
	  <td align="left"style="text-align: left; width: 33.3%; height: 25;" class="auto-style6">&nbsp;</td>
	  <td align="center"style="text-align: center; width: 33.3%; height: 25px;" ><span class="auto-style6" style="font-size:16px;text-align: left; width: 33.3%; height: 25;">No. DE FOLIO: <?php echo $folio_data["folio_id"]; ?></span><br>
      <strong>CLIENTE: <?php echo $dependency_name; ?></strong></td>
	  <td align="right" style="text-align: right; width: 33.3%; height: 25px;">&nbsp;</td>
    </tr>
	<tr>
		<td align="left"style="text-align: left; width: 33.3%; height: 25;" class="auto-style6"><span style="text-align: left; width: 20%; height: 14px;">TORRE: <?php echo $folio_data["tower"]; ?></span></td>
		<td align="center"style="text-align: center; width: 33.3%; height: 25px;" >PLACAS: <?php echo $folio_data["registration_plate"]; ?></td>
		<td align="right" style="text-align: right; width: 33.3%; height: 25px;">ORDEN DE TRABAJO(CLIENTE): <?php echo $folio_data["order_number"]; ?></td>
	</tr>
</table>
<table width="100%" class="gradienttable"  border="1" cellpadding="3" cellspacing="0" >
  <tr style="background: #DDD; height: 22px;">
    <td colspan="4" style="height: 22px;"><p>NOMBRE RESPONSABLE DE LA UNIDAD:<br> <?php echo utf8_encode($folio_data["vehicle_operator"]); ?></p></td>
    <td colspan="6" style="height: 22px;"><p>TELEFONO OPERADOR: <br> <?php echo $folio_data["operator_tel"]; ?></p></td>
    <td colspan="5" style="height: 22px;"><p>COMBUSTIBLE: <?php echo $vehicle["fuel"]; ?><br> NIVEL DE COMBUSTIBLE: <?php echo getFuelLevel($Inventorys["fuel_level"]); ?></p></td>
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
  //Extraemos las observaciones antes de mostrar inventario
	if(isset($Inventorys["observations"]) &&  $Inventorys["observations"]!== ""){
		$observaciones = (isset($ismobile) && $ismobile == true) ? $Inventorys["observations"] : utf8_encode($Inventorys["observations"]);
	}else{
		$observaciones ="";
		}
	
  //eliminamos las observaciones y nivel de gasolina antes de mostrar inventario
  unset($Inventorys["observations"]);unset($Inventorys["fuel_level"]);
  $keys = array_keys($Inventorys);
		  $filas = 18; $columnas = 5; $contador = 1;		  


		 //Iniciamos el bucle de las filas
		 for($t=0;$t<18;$t++){
		  echo "<tr class='bg_tr' style='height: 8px'>";
		  //Iniciamos el bucle de las columnas
		  for($y=0;$y<5;$y++){
			/*if ($contador == "89"){
				echo "<td style='width:15%; height: 8px;'></td>";
				echo "<td style='width:2.5%; height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";
				$contador++;
			}else*/
			if($contador == "90"){
				echo "<td style='width:15%; height: 8px;'></td>";
				echo "<td style='width:2.5% height: 8px;'>&nbsp;</td><td style='width:2.5%; height: 8px;'></td>";				
				$contador++;
			}else{
				$value = $keys[$contador];
				echo "<td style='width:15%;height: 8px;'><p>".ucfirst(str_replace('_', ' ', $keys[$contador]))."</p></td>";
					if($Inventorys[$value] == "1"){
						echo "<td style='width:2.5%;height: 8px;'><img src='http://develop.gascomb.com/user_interface/img/chekbox_true.png'></td><td style='width:2.5%;height: 8px;'>&nbsp;</td>";
					}else{
						echo "<td style='width:2.5%;height: 8px;'>&nbsp;</td><td style='width:2.5%;height: 8px;'><img src='http://develop.gascomb.com/user_interface/img/chekbox_false.png'></td>";
					} 
				//echo "<td style='padding:3px;'>".$keys[$contador].$Inventory[$value].$contador."</td>";			
				$contador++;
			}
		  
		   }
		   //Cerramos columna
		   echo "</tr>";
		  }

  ?>

  <tr>
    <td colspan="15"><p><strong>RECIBIÓ LA UNIDAD: </strong><?php echo $recibe_unidad; ?></p></td>
  </tr>
  <tr>
    <td colspan="15"><p><strong>OBSERVACIONES DE LA UNIDAD:</strong></p></td>
  </tr>
  <tr>
    <td colspan="15" align="center"><?php 
				echo $observaciones;
				?>			
			
	</td>
  </tr>
  <tr>
    <td colspan="15" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="15" align="center">No. DE FOLIO: <?php echo $folio_data["folio_id"]; ?></td>
  </tr>
</table>
<page_footer>
       	<span class="text_medium"><span class="text_medium"><?php echo NAME_COMPANY; ?> S.A. DE C.V. &nbsp; &nbsp; CALLE 2a ORIENTE SUR  #750 COL. SAN ROQUE, TUXTLA GUTIERREZ CHIAPAS C.P. 29040
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