<style type="text/Css">
<!--
.test1
{
    border: solid 1px #FF0000;
    background: #FFFFFF;
    border-collapse: collapse;
}
-->
</style>
<page style="font-size: 14px">
   
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 20px">
        <tr>
            
            <td style="width: 25%; color: #444444;">
                <img style="width: 70%;" src="./img/logo.png" alt="Logo"><br>
            </td>
	    <td style="width: 75%;">
		
		
		<table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; padding-top: 5px">
		    <tr>
			<td style="width: 100%; color: #444444; text-align: right">
			    NO. ORDEN: {requisicion} - {proveedor_id}
			</td>
		    </tr>
		    <tr>
			<td style="width: 100%; color: #444444; text-align: center; font-size: 20px;">
			    <br/>Grupo Automotriz en Servicios de Combustibles, S.A. de C.V.
			</td>
		    </tr>
		    <tr>
			<td style="width: 100%; color: #444444; text-align: center">
			    Calle Lucio Blanco No. 417, Col. La Era, Delegacion Iztapalapa, C.P. 09720, Mexico, D. F.
			</td>
		    </tr>
		</table>
		
		
		
	    </td>
        </tr>
    </table>
    <br/>
	
	<table align="center" style="border: solid 1px #000000;">
		<tr>
			<td style="width: 198mm; background: #FFFFFF; font-size: 20px; text-align: center; ">
				ORDEN DE COMPRA
			</td>
		</tr>
	</table>

	<table cellspacing="2" style="width: 198mm; text-align: center; font-size: 14px; border: solid">
        <tr>           
            <td> 
				
				<table cellspacing="2" style="width:100%; min-height:200px; text-align: center; font-size: 14px;">
					<tr>           
						<td style="width: 7%; color: #444444; text-align: left">
							<b>Fecha:</b>
						</td>
						<td style="width: 13%; color: #444444;text-align: left;border-style:solid; border-bottom:#000000;">
							{fecha}
						</td>
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Vendedor:</b>
						</td>
						<td style="width: 50%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{vendedor}
						</td>
						 <td style="width: 6%; color: #444444; text-align: left">
							<b>Folio:</b>
						</td>
						<td style="width: 14%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{folio}
						</td>
					</tr>
				</table>
				
            </td>	
        </tr>
		<tr>           
            <td> 
				
				<table cellspacing="2" style="width:100%; min-height:200px; text-align: center; font-size: 14px;">
					<tr>           
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Empresa:</b>
						</td>
						<td style="width: 40%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{empresa}
						</td>
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Contacto:</b>
						</td>
						<td style="width: 40%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{contacto}
						</td>
					</tr>
				</table>
				
				
            </td>	
        </tr>
		<tr>           
            <td> 
				<table cellspacing="2" style="width:100%; text-align: center; font-size: 14px;">
					<tr>           
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Direccion:</b>
						</td>
						<td style="width: 60%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{direccion}
						</td>
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Telefono:</b>
						</td>
						<td style="width: 20%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{telefono}
						</td>
					</tr>
				</table>
            </td>	
        </tr>
		<tr>
			<td>
				<table cellspacing="2" style="width:100%; text-align: center; font-size: 14px;">
					<tr>
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Correo 1</b>
						</td>
						<td style="width: 40%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{correo1}
						</td>
						<td style="width: 10%; color: #444444; text-align: left">
							<b>Correo 2</b>
						</td>
						<td style="width: 40%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{correo2}
						</td>
					</tr>
				</table>
			</td>
		</tr>
				
    </table>
	<br>
	
	<table cellpadding="3" style="width:100%; text-align: center; font-size: 12px; border:solid;">
		<tr>
			<td style="width: 10%; color: #444444; border:solid; text-align: center; background: #FFFFFF;"> <b>Cantidad</b> </td>
			<td style="width: 10%; color: #444444; border:solid; text-align: center; background: #FFFFFF;"> <b>U. Medida </b> </td>
			<td style="width: 60%; color: #444444; border:solid; text-align: left; background: #FFFFFF;"> <b>Descripcion </b> </td>
			<td style="width: 10%; color: #444444; border:solid; text-align: center; background: #FFFFFF;"> <b>Precio Unitario </b> </td>
			<td style="width: 10%; color: #444444; border:solid; text-align: center; background: #FFFFFF;"> <b>Total </b> </td>
			
		</tr>
		{items}
			<tr>
			<td colspan="3" rowspan="3" style="width: 10%; color: #444444; text-align: left;"></td>
			<td style="width: 10%; color: #444444; text-align: right; "><b>Sub-Total:</b> </td>
			<td style="width: 10%; color: #444444; text-align: right; ">{subtotal}</td>	
		</tr>
		<tr>
			<td style="width: 10%; color: #444444; text-align: right; "><b>Iva:</b> </td>
			<td style="width: 10%; color: #444444; text-align: right; ">{iva}</td>	
		</tr>
		<tr>
			<td style="width: 10%; color: #444444; text-align: right;"><b>Total:</b> </td>
			<td style="width: 10%; color: #444444; text-align: right;">{total}</td>	
		</tr>
	
	</table>
	<br/>
	<table cellpadding="3" style="width:100%; text-align: center; font-size: 12px; border:none;">
		<tr>
			<td style="width: 50%;">
				<table cellspacing="5" style="width:100%; min-height:200px; text-align: center; font-size: 14px; border:solid; background: #FFFFFF;">
					<tr>           
						<td style="width: 40%; color: #444444; text-align: left">
							<b>Fecha de entrega:</b>
						</td>
						<td style="width: 60%; color: #444444;text-align: left;border-style:solid; border-bottom:#000000;">
					{Out fecha}
						</td>
					</tr>
					<tr>
						<td style="width: 40%; color: #444444; text-align: left">
							<b>Formato de Pago:</b>
						</td>
						<td style="width: 60%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{forma_pago}
						</td>
					</tr>
					<tr>
						 <td style="width: 40%; color: #444444; text-align: left">
							<b>Anticipo:</b>
						</td>
						<td style="width: 60%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{anticipo}
						</td>
					</tr>
					<tr>
						 <td style="width: 40%; color: #444444; text-align: left">
							<b>Saldo:</b>
						</td>
						<td style="width: 60%; color: #444444;text-align: left; border-style:solid; border-bottom:#000000;">
							{saldo}
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 50%; text-align:center;">
				<br><br><br><br><br>
				<table cellspacing="5" style="width:100%; min-height:200px; text-align: center; font-size: 14px; border:none;">
					<tr>           
						
						<td style="width: 100%; color: #444444;text-align: center;border-style:solid; border-bottom:#000000;">
							
						</td>
					</tr>
					<tr>
						<td style="width: 100%; color: #444444; text-align: center">
							<b>Firma del Cliente:</b>
						</td>	
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
    
	
	
</page>