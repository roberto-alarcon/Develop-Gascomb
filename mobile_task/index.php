<?phpsession_start();
	/*****************************
	Get params for folio
	*****************************/
	//$id = $_GET['folio'];	//echo isset($_SESSION['active_user_id'])? $_SESSION['active_user_id'] : 'no';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta  name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<!--  JQuery Mobile library -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
				<script>		$(document).ready(function(){			$("#errorMsg").hide();			$("#btnLogin").click(function(){				var usuario = $("#txtuser").val();				var password = $("#txtpassword").val();				$.post("ajax/sign.php",{ usuario : usuario, password : password},function(respuesta){										if (respuesta == "true") {						window.location = "admin_info.php?tab=1";					}					else{						$.mobile.changePage('#pageError', 'pop', true, true);						/*$("#errorMsg").fadeIn(300);						$("#errorMsg").css("display", "block");*/					}				});			});		});		</script>		
	</head>

		<body>		<section id="login" data-role="page">			<header data-role="header">				<h1> Gascomb</h1>			</header>			<article data-role="content">				<form id="form_login">					<li data-role="fieldcontain">								<label for="txtuser">Uusuario:</label>								<input type="text" name="txtuser" id="txtuser" value="" placeholder="Name"  />					</li>					<li data-role="fieldcontain">						<label for="txtpassword">Contraseña:</label>						<input type="password" name="txtpassword" id="txtpassword" value="" placeholder="Password" />					</li>					<input type="button" value="Login"data-theme="b" id="btnLogin">				</form>				 <!--<div id="errorMsg" style="background-color:red;color: #FFFFFF;">Usuario o Contrase�a no valida</div>-->			</article>		</section>		<!-- Aqui nuestro dialog con el mensaje de error  -->		<section id="pageError" data-role="dialog">			<header data-role="header">				<h1>Error</h1>			</header>			<article data-role="content">				<p>Usuario o contraseña no valida</p>				<a href="#" data-role="button" data-theme="b" data-rel="back">Aceptar</a>			</article>		</section>	</body>
</html>