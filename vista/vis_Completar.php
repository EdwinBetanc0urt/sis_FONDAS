<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "completar" AND
	isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>Pagina de Inicio FONDAS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
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
				Completar los datos para el REGISTRO
			</div>

			<div class="panel-body">
				<form id="formCompletarRegistro" name="formCompletarRegistro" method="POST"
					action="controlador/conCompletar.php" role="form" class="form-horizontal">
					<div class="row">

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre">* Primer Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45"
									name="ctxNombre" type="text" size="20" required value="<?php
									if(isset($_SESSION['nombre']))
										echo $_SESSION['nombre'];
									?>" placeholder="Ingrese la Descripción" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre2">Segundo Nombre</label>
								<input id="ctxNombre2" class="valida_alfabetico form-control"
									maxlength="45" name="ctxNombre2" type="text" size="20"
									placeholder="Ingrese la Nombre" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido">* Primer Apellido</label>
								<input id="ctxApellido" class="valida_alfabetico form-control"
									maxlength="45" name="ctxApellido" type="text" size="20" required
									value="<?php
									if(isset($_SESSION['apellido']))
										echo $_SESSION['apellido'];
									?>" placeholder="Ingrese la Apellido" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido2">Segundo Apellido</label>
								<input id="ctxApellido2" class="valida_alfabetico form-control"
									maxlength="45" name="ctxApellido2" type="text" size="20"
									placeholder="Ingrese la Apellido" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="cmbSexo">* Sexo</label>
								<select id='cmbSexo' name='cmbSexo' class="dinamico form-control select2"
									data-toggle="tooltip" data-placement="right"
									title="Estado al cual pertenece el municipio" size="1">
									<option value="">Selecciona Uno...</option>
									<option value="m">Masculino</option>
									<option value="f">Femenino </option>
									<option value="i">Indefinido</option>
								</select>
								<input id="hidSexo" type="hidden" value="<?php
									if(isset($_SESSION['sexo']))
										echo $_SESSION['sexo']; ?>" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="cmbEdoCivil">* Estado Civil</label>
								<select id='cmbEdoCivil' name='cmbEdoCivil' class="dinamico form-control select2"
									data-toggle="tooltip" data-placement="right"
									title="EdoCivil al cual pertenece el municipio" size="1">
									<option value="">Selecciona Uno...</option>
									<option value="s">Soltero</option>
									<option value="c">Casado</option>
									<option value="d">Divorciado</option>
									<option value="v">Viudo</option>
								</select>
								<input id="hibEdoCivil" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="datFechaNac">* Fecha de Nacimiento</label>
								<input id="datFechaNac" class="valida_alfabetico form-control"
									maxlength="45" name="datFechaNac" type="date" size="20" required
									placeholder="Ingrese la Fecha de Nacimiento" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxCorreo">* Correo</label>
								<input id="ctxCorreo" class="valida_correo form-control" maxlength="45"
								name="ctxCorreo" type="text" size="20" required value="<?php
									if(isset($_SESSION['correo']))
										echo $_SESSION['correo'];
									?>" placeholder="Ingrese el Correo" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono">* Teléfono Móvil</label>
								<input id="numTelefono" name="numTelefono" class="valida_numerico form-control"
									maxlength="45"	type="text" size="20" required value="<?php
									if(isset($_SESSION['tel_mov']))
										echo $_SESSION['tel_mov'];
									?>" placeholder="Ingrese el Telefono Movil" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono2">* Teléfono Fijo</label>
								<input id="numTelefono2" class="valida_numerico form-control"
									maxlength="45" name="numTelefono2" type="text" size="20"
									placeholder="Ingrese el Telefono Fijo" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label for="ctxDireccion">* Dirección</label>
								<input id="ctxDireccion" class="valida_alfabetico form-control"
									maxlength="45" name="ctxDireccion" type="text" size="20" required
									placeholder="Ingrese la Dirección" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbEstado">* Estado</label>
								<select id='cmbEstado' data-placement="right"
									class="dinamico form-control select2" data-toggle="tooltip"
									title="Estado al cual pertenece el municipio" size="1">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidEstado" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbMunicipio">* Municipio</label>
								<select id='cmbMunicipio' data-toggle="tooltip" size="1"
									class="dinamico form-control select2"
									data-placement="right" title="Estado al cual pertenece el municipio">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidMunicipio" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbParroquia">* Parroquia</label>
								<select id='cmbParroquia' name='cmbParroquia' class="dinamico form-control select2"
									data-toggle="tooltip" data-placement="right" size="1"
									title="Estado al cual pertenece el municipio">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidParroquia" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta1">* Pregunta 1</label>
								<select id='cmbPregunta1' name='cmbPregunta1' data-placement="right"
									class="dinamico form-control select2" data-toggle="tooltip"
									title="Seleccione una opción" size="1">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta1" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta1">* Respuesta 1</label>
								<input id="ctxRespuesta1" class=" form-control" maxlength="45"
									name="ctxRespuesta1" type="text" size="20" required data-toggle="tooltip"
									placeholder="Ingrese la primera respuesta" data-placement="right"
									title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta2">* Pregunta 2</label>
								<select id='cmbPregunta2' name='cmbPregunta2' data-placement="right"
									class="dinamico form-control select2" data-toggle="tooltip"
									title="Selecciona una opción" size="1">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta2" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta2">* Respuesta 2</label>
								<input id="ctxRespuesta2" class=" form-control" maxlength="45"
									name="ctxRespuesta2" type="text" size="20" required
									placeholder="Ingrese la segunda respuesta" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Nueva</label>
								<input id="pswClave" name="pswClave" type="password" maxlength="45"
									data-placement="right" title="Campo Obligatorio" />
								<div class="divItemsClave">
									<p id="claveMinuscula" class="invalido">
									</p>
									<p id="claveMayuscula" class="invalido">
										Al menos <strong>1 letra en MAYUSCULA(A-Z)</strong>
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
								<input id="pswClave2" name="pswClave2" type="password" maxlength="45"
									class="form-control" size="20" required placeholder="Confirme la clave"
									data-placement="right" title="Campo Obligatorio" data-toggle="tooltip" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<center>
									<button id="btnGuardar" name='iniciar' value="Guardar" onclick="enviar(this.value);"
										style="background:#37474F; color:#fff; width:200px; height:40px;">
										Guardar
									</button>
									<button id="btnSalir" onclick="salir();"
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
	<script type="text/javascript" src="public/js/validaciones.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/completar_registro.js"></script>
	<script type="text/javascript" src="public/js/clave_items.js"></script>
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
