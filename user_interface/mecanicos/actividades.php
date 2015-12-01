<?php
?>
<!DOCTYPE html>
<html lang="es">
<html>
<head>
<title>Grid-Actividades</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta charset="UTF-8">

<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/style.css" rel="stylesheet" media="screen">
<body>

	<nav class="navbar navbar-default" role="navigation">

	  <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-ex1-collapse">
		  <span class="sr-only">Desplegar navegación</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand padd_cero" href="#"><img src="logo2.png" /></a>
	  </div>

	  <div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  Menú <b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="#">Salir</a></li>
			  <!--<li class="divider"></li>
			  <li><a href="#">Acción #2</a></li>-->
			</ul>
		  </li>
		</ul>
		<p class="navbar-text">Herminio Medina</p>
	  </div>
	</nav>


	<div class="container">
		<div class="row">
			<div class="panel panel-default">
			  <div class="panel-heading">Datos Generales del Folio</div>
			  <div class="panel-body">
				<table class="table table-condensed" >
				<tbody>
				  <tr>
					<td class="active">
					  <img src="http://i2.gascomb.com/37763/_qrcode/qrcode.png" border="0" title="" />
					</td>
					<td class="active small-data">
					  Folio <span>31638</span><br /><br />
					  Fecha de ingreso:<br />
					  Tipo de Servicio:<br />
					  Recibido por: <br />
					  Jefe de mecanicos:
					</td>				
					<!--<td class="success">dfdf</td>-->
					<td class="active">
					   <div class="small-data">
							Torre: 45 <br />
							Cajon: F17
					   </div>
					   <div class="head_services">SERVICIOS A REALIZAR</div>
					   &nbsp;<br />
					   
							<table class="table table-bordered">
								<tbody>
								  <tr>
									<td>
										<div class="small-data">Reparación de escape</div>
									</td>
									<td>
									  <div align="center">
										  <button type="button" class="btn btn btn-success btn-sm">INICIAR</button>
										  <button type="button" class="btn btn-primary btn-sm">TRABJANDO</button>
										  <button type="button" class="btn btn-warning btn-sm">PENDIENTE</button>
									  </div> 
									</td>
								  </tr>
								</tbody>  
							</table>					
					</td>
					<!--<td class="success">
					<td class="warning">-->
					<td class="danger">
						<div class="small-data">
							&nbsp; <br />
							&nbsp;
					   </div>				
					   <div class="head_services priority_red">
						NIVEL DE PRIORIDAD
					   </div>
					   &nbsp;<br />
					   <div class="medium-data center red">URGENTE</div>				   
					</td>
				  </tr>
				  <tr>
					<td colspan="5">
					  <div align="right">
						<button type="button" class="btn btn-info btn-lg" id="detalles" data-id="31645">Ver detalles</button>
					  </div>
					</td>
					<td></td>
				  </tr>
				</tbody>
				</table>		
			  </div>
			</div>
		</div>	
	</div>

	<div class="modal fade" id="myModal2" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Detalles del Folio</h4>
				</div>
				<div class="modal-body">
				  <!---->
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			  </div>
		</div>
	</div>

</div>

  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type='text/javascript'>
	$(document).ready(function() {
	  /*modal - open*/
	  $("#detalles").click(function(){
		 var id = $(this).attr("data-id");
		 var url_media = "http://github-develop.gascomb.com/user_interface/mecanicos/"+id+"/pdf/"+id+".pdf";
		 $(".modal-body").html('<iframe width="100%" height="610" frameborder="0" scrolling="yes" allowtransparency="true" src="'+url_media+'"></iframe>');
		 $('#myModal2').modal('show');	 
	  });	

	});
  </script>	

</body>
</html>  
