<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
     ob_start();
     $msg = "Le site de html2pdf\r\nhttp://html2pdf.fr/";
?>
<style type="text/css">
<!--
page
{
    font-size:11px;    
}
.title_emp
{
    font-size:18px;    
}
.text_medium{
	font-size:9.8px;    
}
.text_small{
	font-size:8px;    
}
hr { 
	color: #CCCCCC;
	background-color: #CCCCCC;
	height: 1px;
}
table tr td{
	font-size:9px;    
}

table.sample {
	border-width: thin;
	border-spacing: 0px;
	border-style: none;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
table.sample th {
	border: 1px;
	padding: 1px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: ;
}
table.sample td {
	border: 1px;
	padding: 1px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: ;
}

.auto-style6 {
	border-width: 0;
}

-->
</style>

<page backtop="10mm" >
    <page_header>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left; width: 15%; height: 92px;"><qrcode value="<?php echo $msg; ?>" ec="L" style="width: 25mm;"></qrcode></td>
                <td style="text-align: center; width: 70%; height: 92px;">
					<span class="title_emp">GRUPO MECANICO EMPRESARIAL, S.A DE C.V</span><br/><br/>
					<span class="text_small">LABORATORIO DIESEL INTEGRAL PARA TODAS LAS MARCAS Y TIPOS DE BOMBAS E INYECTORES, LABORATORIO PARA INYECTORES ELECTRÃ“NICOS HUEI, EUI: RECONSTRUCCIONES INTEGRALES Y MÃ‰CANICA EN GENERAL EN GASOLINA DIESEL Y MAQUINARIA PESADA FUEL INYECTION Y DIAGNOSTICOS POR COMPUTADORA ESPECIALIZADO EN EQUIPO PESADO</span><br/>
					<span class="text_small">R.F.C. GME-951206-9K1   GME@AVANTE.NET<br/>
					TELS. 2693-2370, 5693-2276, 5693-4367</span>
				</td>
				<td style="text-align: right; width: 15%; height: 92px;"><qrcode value="<?php echo $msg; ?>" ec="L" style="width: 25mm;"></qrcode></td>
            </tr>
        </table>
		<br>
        <table style="width: 100%; " cellpadding="0" cellspacing="0">
            <tr>
                <td style="text-align: left; width: 50%; height: 25;" class="auto-style6"><NOMBRE:</td>
                <td style="text-align: center; width: 25%; height: 25px;" >
					No. DE ORDEN:</td>
				<td style="width: 25%; height: 25px;">ORDEN DE SERVICIO:</td>
            </tr>
        </table>
        <table class="sample" style="width: 100%; " align="left" cellspacing="0" cellpadding="0">
            <tr>
                <td style="text-align: left; width: 40%; height: 14px;" >NOMBRE:</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					MARCA</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					TIPO</td>
				<td style="text-align: left; width: 20%; height: 14px;" >PLACAS:</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 40%; height: 14px;" >
				DIRECCIÓN:</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					FOLIO:</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					FECHA DE RECIBO:</td>
				<td style="text-align: left; width: 20%; height: 14px;" >HORA:</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 40%; height: 14px;" >TEL.:</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					No.
		ECONOMICO:</td>
                <td style="text-align: left; width: 20%; height: 14px;" >
					FECHA DE ENTREGA:</td>
				<td style="text-align: left; width: 20%; height: 14px;" >HORA:</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 40%; " rowspan="2" >POR 
				REPARAR:</td>
                <td style="text-align: left; width: 20%; " >
					AÑO:</td>
                <td style="text-align: left; width: 20%; " >
					CILINDROS</td>
				<td style="text-align: left; width: 20%; " >KMS:</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 25px;" colspan="3" >
					FALLA:</td>
            </tr>
            <tr>
                <td style="text-align: center; height: 25px;" colspan="4">
				<strong>DETALLES</strong>:</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 18;" colspan="4" ></td>
            </tr>
            <tr>
                <td style="text-align: left; height: 18;" colspan="4" ></td>
            </tr>
            <tr>
                <td style="text-align: left; height: 17px;" colspan="4" >
				</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 18;" colspan="4" >
				&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 18;" colspan="4" >
				&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 40%; " rowspan="5" >
				<span class="text_small">DESPUES DE HABER REVISADO Y PROBADO EL 
				AUTOMOVIL QUE DEJE A REPARACIÓN , ME MANIFIESTO CONFORME CON LOS 
				TRABAJOS REALIZADOS DANDOME POR RECIBIDO EN ESTE MOMENTO DE 
				TODAS LAS REFACCIONES Y PIEZAS USADAS QUE LE FUERON CAMBIADAS AL 
				VEHICULO</span></td>
                <td style="text-align: center; width: 20%; " rowspan="5" >
					<br><br>
					<br>FIRMA DEL CLIENTE:</td>
                <td style="text-align: left; width: 20%; height: 11px;" >
					CONCEPTO</td>
				<td style="text-align: center; width: 20%; height: 11px;" >CLIENTE</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 20%; height: 11px;" >
					&nbsp;</td>
				<td style="text-align: center; width: 20%; height: 11px;" >&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 20%; height: 11px;" >
					SUBTOTAL</td>
				<td style="text-align: left; width: 20%; height: 11px;" ></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 20%; height: 11px;" >
					IVA</td>
				<td style="text-align: left; width: 20%; height: 11px;" ></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 20%; height: 20px;" >
					TOTAL</td>
				<td style="text-align: left; width: 20%; height: 20px;" ></td>
            </tr>
            <tr>
                <td style="text-align: left; height: 15px;" colspan="4"><strong>
				OBSERVACIONES</strong>:<br><span class="text_small">POR MEDIO DE LA PRESENTE ME PERMITO 
				ORDENAR A USTEDES LLEVAR ACABO LOS SERVICIOS DE MANTENIMIENTO Y 
				REPARACIONES ESTIPULADOS EN LA PARTE SUPERIOR DE LA ORDEN DE 
				SERVICIO Y AUTORIZO SE INSTALEN LAS REFACCIONES NECESARIAS( LAS 
				CUALES SE COBRARÁN APARTE) AL VEHICULO AQUI DESCRITO Y QUE EN 
				ESTA FECHA QUEDA DEPOSITADO EN SUS TALLERES.<br>AUTORIZO ELUSO 
				DEL VEHICULO DENTRO DE LOS LIMITES DE ESTA CIUDAD PARA EFECTOS 
				DE PRUEBA O INSPECCION DE LAS REPARACIONES EFECTUADAS.<br>ACEPTO 
				QUE LA EMPRESA NO SE HACE RESPONSABLE POR PERDIDAS DE LOS 
				ARTICULOS QUE SE DEJEN DENTRO DE LOS VEHICULOS, NI POR DAÑOS A 
				LAS UNIDADES POR CAUSAS DE FUERZA MAYOR<br>LA GARANTÍA DEL 
				TRABAJO QUEDA REGULADA POR LOS TERMINOS DEL ART. 40 DE LA LEY 
				FEDERAL DE PROTECCIÓN AL CONSUMIDOR.<br>CUALQUIER DEFICIENCIA EN 
				LA PRESTACIÓN DEL SERVICIO DEBERÁ RECLAMARSE DENTRO DE LOS 30 
				DIAS SIGUIENTES A LA ENTREGA DEL VEHICULO.<br>AL RECIBIR EL 
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
						<br>
				AUTORIZO LA REPARACION DEL VEHICULO POR 
				LO QUE SEA NECESARIO.&nbsp; AUTORIZO LA REPARACION DEL VEHICULO 
				HASTA POR LA CANTIDAD DE $<br>EL PAGO DE ESTA ORDEN DE SERVICIO 
				SERÁ AL RIGUROSO CONTADO.<br>GARANTIA:&nbsp; CONTRATO DE 
				ADHESIÓN DE PRESTACIÓN DE SERVICI
				OS PARA LA REPARACION Y <br>DE VEHICULOS_______________________ 
				NOM-068-scfi/2000 LODO CON NUMERO DE EXPEDIENTE<br>416/2500-97 OFICIO 9784
				
				</span>
				
				</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 15px;" colspan="3"></td>
				<td style="text-align: left; width: 20%; height: 15px;"></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 40%;">&nbsp;</td>
                <td style="text-align: left; width: 20%; ">
					&nbsp;</td>
                <td style="text-align: left; width: 20%;">
					&nbsp;</td>
				<td style="text-align: left; width: 20%;">&nbsp;</td>
            </tr>
        </table>
		<br><br><br><br>
		<br>
		<br><br><br><br>
		<br/>
		<br><br><br><br><br><br><br><br><br><br><br>
		

		
    </page_header>
	<page_footer>
		<br><br><br><br><br><br><br><br><br>
		<hr/>
       	<span class="text_medium">GRUPO MECANICO EMPRESARIAL, S.A DE C.V &nbsp; &nbsp; 5 DE MAYO No.105 COL- FRANCISCO VILLA, C.P. 09720, MÃ‰XICO, D.F. TELS.: 5693-2370, 5693-2276, 5693-4367
		</span><br/><br/>
     </page_footer>    
</page>

<?php
     $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('nombre_del_documento1.pdf', 'F');
        //$html2pdf2->Output('qrcode.pdf');
		header('Content-type: application/pdf');
		readfile('nombre_del_documento1.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

	