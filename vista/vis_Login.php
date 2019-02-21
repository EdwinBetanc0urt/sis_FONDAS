<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8"/>

	<title>Pagina de Inicio FONDAS</title>

	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link rel="stylesheet" type="text/css" href="public/font-awesome-4.3.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="public/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="public/css/menu.css">
	<link rel="stylesheet" href="public/css/w3.css">
	<link rel="stylesheet" type="text/css" href="public/css/clave_items.css">

	<script type="text/javascript" src="public/jquery/jquery.js"></script>
	<script type="text/javascript" src="public/bootstrap/js/bootstrap.js"></script>
</head>

<body>
	<!--inicio de cintillo-->
	<div class="header" style="width:100%;align:center;position:relative; background:#37474F;"	>
		<div style="width:100%;position:abosolute;height:90%">
			<img src="public/img/logofondas.png" id="logo" style="width:100%"/>
		</div>
	</div>
	<!--fin de cintillo-->

	<div style="padding:20px;position:absolute;background:url('public/img/detrasparrafo.jpg');height:500px;width:100%; ">
		<!--inicio de menu-->
		<div class="topnav" id="myTopnav">
			<a href="?" >&nbsp;&nbsp;Inicio</a>
			<a href="?accion=Nosotros">&nbsp;&nbsp;Nosotros</a>
			<a href="?accion=Galeria">&nbsp;&nbsp;Galería</a>
			<a href="?accion=Contactanos">&nbsp;&nbsp;¿Donde Estamos?</a>
			<a href="?accion=Login" class="active" style="float:right; ">
				<img src="public/img/usuario2.png" width="25" height="25" font=""/>&nbsp;&nbsp;Intranet
			</a>
			<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="mymenu()">&#9776;</a>
		</div>
		<!--fin menu-->

		<!--centro-->
		<div class="row">
			<div	class="col-3 right	">
				<div class="row content">
					<div class="w3-container" style="background:url('public/img/hhh.jpg');">
						<div class="w3-card-4" >
							<div style="background:#37474F" class="w3-center">
								<h4 style="color:#fff">Intranet</h4>
							</div>

							<form class="w3-container" name="form_intranet" id="form_intranet"
								onsubmit="return f_Submit()" method="post" action="controlador/conLogin.php">
								<p align="center">
									<img src="public/img/loginn.png" width="58" height="58" font=""/>
								</p>
								<p><label>Usuario:</label></p>
								<input type="text" class="w3-input" name="usuario" id="usuario"
									title="campo obligatorio" placeholder="ingresé usuario" />

								<p><label>Clave:</label></p>
								<input type="password" title="campo obligatorio" name="clave"
									id="clave" placeholder="ingresé su clave" class="w3-input"/>

								<p><label>Código</label></p>
								<input type="text" name="captcha" id="captcha" readonly
									style="background:url('public/img/dms.png'); width:160px;" />
								<a href="javascript: CargarCaptcha();">
									<span class="glyphicon glyphicon-refresh"></span>
								</a>

								<p><input type="text" class="w3-input valor_mayuscula" name="txtcopia" id="txtcopia"/></p>
								<p>
									<button style="background:#37474F" class="w3-button w3-block"
										name='iniciar' value="ingresar" >
										<span style="color:#fff">INGRESAR</span>
									</button>
								</p>
								<p>
									<a data-toggle="modal" data-target="#VentanaModal" onclick="desplegar();"
									style="color: #000; font-weight: bold;font-size:12px;list-style-type: none;display: block;text-decoration: none;">
										<center>
											<h4><br/>¿Olvido su contraseña?</h4>
										</center>
									</a>
								</p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-9" style="text-align:center;">
				<img src="public/img/seg2.jpg" id="sd" style="width:95%; height:400px; border-radius:12px; "/>
			</div>
		</div>
		<!--fin centro-->

		<!--pie de pagina-->
		<div class="pie" style="max-height:65px; background-color:#37474F; width:100%">
			<h5>
				© Fondo para el Desarrollo Agrario Socialista
			</h5>
		</div>
		<!--pie de pagina-->
	</div>
	<!--fin cuerpo-->

	<?php
		include_once("_RecuperarClave.php");
	?>

	<script src="public/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="public/js/_core.js"></script>
	<script type="text/javascript" src="public/js/validaciones.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/clave_items.js"></script>
	<script src="public/js/login.js"></script>
	<?php
	// si existe la variable get msjAlerta Incluye el archivo JavaScript
	if(isset($_GET['msjAlerta'])) {
		?>
		<!-- Mensajes Emergentes -->
		<script src="public/js/alertas.js" type="application/javascript"></script>
		<script type="application/x-javascript">
		$(function() {
			// cuando el documento este listo llama la función fjMensajes que esta en el archivo jsp_Alertas.js
			fjMensajes("<?= $_GET["msjAlerta"]; ?>");
			// envía el valor que tiene msjAlerta(sinconsulta, registro, nocambio, etc)
		});
		</script>
		<?php
	} // cierre del condicional de isset
	?>
</body>
</html>
