<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "caducado" AND
	isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Pagina de Inicio FONDAS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="public/font-awesome-4.3.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="public/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="public/css/menu.css">
	<link rel="stylesheet" href="public/css/w3.css">
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="public/select2/dist/css/select2-bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/clave_items.css">
	<script type="text/javascript" src="public/jquery/jquery.js"></script>
	<script type="text/javascript" src="public/bootstrap/js/bootstrap.js"></script>
</head>
<body>
	<!--inicio de cintillo-->
	<div class="header" style="width:100%;align:center;position:relative; background:#37474F;"	>
		<div style="width:100%;position:abosolute;height:90%">
			<img src="public/img/logofondas.png" id="logo" style="width:100%">
		</div>
	</div>
	<!--fin de cintillo-->
	<!--centro-->
	<div class="container">

		<div class="panel panel-default">
			<div class="panel-heading">
				Cambiar Contraseña
			</div>

			<div class="panel-body">
				<form id="formCambiarClave" name="formCambiarClave" method="POST"
					action="controlador/conCambiar_Clave.php" role="form" class="form-horizontal">
					<div class="row">

						<div class="form-group ui-front">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="ctxNombre">Usuario </label>
								<br>
								<h1>
									<?php
										echo $_SESSION['nacionalidad'] . " - " . $_SESSION['cedula'] . ", " . $_SESSION['nombre'] . " " . $_SESSION['apellido'];
									?>
								</h1>
								<input type="hidden" id="hidUser" name="idu"
									value="<?= $_SESSION['id_usuario'] ?>" />
							</div>
						</div>
						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="textPregunta1">Pregunta 1</label>
								<br><p id="textPregunta1"></p>
								<input id="hidPregunta1" name="hidPregunta1" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta1">* Respuesta 1</label>
								<input id="ctxRespuesta1" class=" form-control" maxlength="45"
									name="ctxRespuesta1" type="text" required data-toggle="tooltip"
									placeholder="Ingrese la primera respuesta" data-placement="right"
									title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta2">Pregunta 2</label>
								<br><p id="textPregunta2"></p>
								<input id="hidPregunta2" name="hidPregunta2" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta2">* Respuesta 2</label>
								<input id="ctxRespuesta2" class=" form-control" maxlength="45"
									name="ctxRespuesta2" type="text" required
									placeholder="Ingrese la segunda respuesta" data-toggle="tooltip"
									data-placement="top" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Nueva</label>
								<input id="pswClave" name="pswClave" type="password" maxlength="45"
									class="form-control new-password" required placeholder="Ingrese la Clave"
									data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
								<div class="divItemsClave">
									<p id="claveMinuscula" class="invalido">
										Al menos <strong>1 letra en minúscula (a-z)</strong>
									</p>
									<p id="claveMayuscula" class="invalido">
										Al menos <strong>1 letra en MAYUSCULA (A-Z)</strong>
									</p>
									<p id="claveNumero" class="invalido">
										Al menos <strong>1 numero (0-9)</strong>
									</p>
									<p id="claveEspecial" class="invalido">
										Al menos <strong>1 carácter especial (_.-+*$)</strong>
									</p>
									<p id="claveLongitud" class="invalido">
										Longitud min. de <strong>8 caracteres</strong>
									</p>
								</div>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave2">* Confirmar Clave Nueva</label>
								<input id="pswClave2" type="password" maxlength="45" required
									class="form-control confirm-password" placeholder="Confirme la clave"
									data-placement="top" title="Campo Obligatorio" data-toggle="tooltip" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<center>
									<button type="button" id="btnGuardar" name='iniciar'
										value="Guardar" onclick="enviar(this.value);"
										style="background:#37474F; color:#fff; width:200px; height:40px;">
										Guardar
									</button>
									<button type="button" id="btnSalir" onclick="salir();"
										style="background:#37474F; color:#fff; width:200px; height:40px;"	>
										Cancelar
									</button>
								</center>
								<input type="hidden" name="operacion" id="operacion" />
							</div>
						</div>
					</div>
				</form>
			</div>
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

	<script type="text/javascript" src="public/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="public/select2/dist/js/select2.min.js"></script>
	<script type="text/javascript" src="public/select2/dist/js/i18n/es.js"></script>
	<script type="text/javascript" src="public/js/_core.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/clave_items.js"></script>
	<script type="text/javascript" src="public/js/cambiar_clave.js"></script>
<!--fin cuerpo-->
</body>
</html>

<?php
} //cierra el condicional de sesión

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}
?>
