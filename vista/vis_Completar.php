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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Pagina de Inicio FONDAS</title>

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
				Completar los datos para el REGISTRO
			</div>

			<div class="panel-body">
				<form id="formCompletarRegistro" name="formCompletarRegistro"
					method="POST" action="controlador/conCompletar.php" role="form"
					class="form-horizontal" autocomplete="off">
					<div class="row">

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre">* Primer Nombre</label>
								<input type="text" id="ctxNombre" name="ctxNombre"
									class="valida_alfabetico form-control"
									maxlength="45" required data-toggle="tooltip"
									value="<?php
									if(isset($_SESSION['nombre']))
										echo $_SESSION['nombre'];
									?>" placeholder="Ingrese la Descripción"
									data-placement="right"
									title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre2">Segundo Nombre</label>
								<input type="text" id="ctxNombre2" name="ctxNombre2"
									class="valida_alfabetico form-control" maxlength="45"
									placeholder="Ingrese la Nombre" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido">* Primer Apellido</label>
								<input type="text" id="ctxApellido" name="ctxApellido"
									class="valida_alfabetico form-control" required
									maxlength="45" data-toggle="tooltip"
									value="<?php
									if(isset($_SESSION['apellido']))
										echo $_SESSION['apellido'];
									?>" placeholder="Ingrese la Apellido"
									data-placement="right"
									title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido2">Segundo Apellido</label>
								<input type="text" id="ctxApellido2" name="ctxApellido2"
									class="valida_alfabetico form-control" maxlength="45"
									placeholder="Ingrese la Apellido" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="cmbSexo">* Sexo</label>
								<select id='cmbSexo' name='cmbSexo' required
									class="dinamico form-control select2" size="1"
									data-toggle="tooltip" data-placement="right"
									title="Estado al cual pertenece el municipio">
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
								<select id='cmbEdoCivil' name='cmbEdoCivil' required
									class="dinamico form-control select2" size="1"
									data-toggle="tooltip" data-placement="right"
									title="EdoCivil al cual pertenece el municipio">
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
								<input type="date" id="datFechaNac" name="datFechaNac"
									class="valida_alfabetico form-control" required
									maxlength="45" placeholder="Ingrese la Fecha de Nacimiento"
									data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxCorreo">Correo</label>
								<input type="text" id="ctxCorreo" name="ctxCorreo"
									class="valida_correo form-control"
									maxlength="45" data-toggle="tooltip"
									value="<?php
									if(isset($_SESSION['correo']))
										echo $_SESSION['correo'];
									?>" placeholder="Ingrese el Correo"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono">* Teléfono Móvil</label>
								<input type="text" id="numTelefono" name="numTelefono"
									class="valida_numerico form-control" required
									value="<?php
									if(isset($_SESSION['tel_mov']))
										echo $_SESSION['tel_mov'];
									?>" placeholder="Ingrese el Telefono Movil"
									maxlength="45" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono2">Teléfono Fijo</label>
								<input type="text" id="numTelefono2" name="numTelefono2"
									class="valida_numerico form-control" maxlength="45"
									placeholder="Ingrese el Telefono Fijo" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label for="ctxDireccion">* Dirección</label>
								<input type="text" id="ctxDireccion" name="ctxDireccion"
									class="valida_alfabetico form-control"
									maxlength="45" required data-toggle="tooltip"
									placeholder="Ingrese la Dirección"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbEstado">* Estado</label>
								<select id="cmbEstado" size="1" required
									data-placement="right" data-toggle="tooltip"
									class="dinamico form-control select2"
									title="Estado al cual pertenece el municipio">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidEstado" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbMunicipio">* Municipio</label>
								<select id='cmbMunicipio' data-toggle="tooltip"
									class="dinamico form-control select2" size="1"
									data-placement="right" required
									title="Estado al cual pertenece el municipio">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidMunicipio" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbParroquia">* Parroquia</label>
								<select id='cmbParroquia' name='cmbParroquia'
									class="dinamico form-control select2" size="1"
									data-toggle="tooltip" data-placement="right"
									title="Estado al cual pertenece el municipio"
									required>
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidParroquia" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta1">* Pregunta 1</label>
								<select id='cmbPregunta1' name='cmbPregunta1'
									data-placement="right" data-toggle="tooltip"
									class="dinamico form-control select2"
									title="Seleccione una opción" size="1"
									required>
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta1" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta1">* Respuesta 1</label>
								<input type="text" id="ctxRespuesta1" name="ctxRespuesta1"
									class=" form-control" maxlength="45" required
									 data-toggle="tooltip" data-placement="right"
									placeholder="Ingrese la primera respuesta"
									title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta2">* Pregunta 2</label>
								<select id='cmbPregunta2' name='cmbPregunta2'
									data-placement="right" data-toggle="tooltip"
									class="dinamico form-control select2"
									title="Selecciona una opción" size="1"
									required>
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta2" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta2">* Respuesta 2</label>
								<input type="text" id="ctxRespuesta2" name="ctxRespuesta2"
									class="form-control" maxlength="45" required
									placeholder="Ingrese la segunda respuesta" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

						<div class="form-group ui-front">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Nueva</label>
								<input id="pswClave" name="pswClave" type="password"
									class="form-control new-password  valida_clave"
									data-toggle="tooltip" placeholder="Ingrese la Clave"
									data-placement="right" title="Campo Obligatorio"
									maxlength="45" required />
								<div class="divItemsClave">
									<p id="claveMinuscula" class="invalido">
										Al menos <b>1 letra en minúscula (a-z)</b>
									</p>
									<p id="claveMayuscula" class="invalido">
										Al menos <b>1 letra en MAYUSCULA(A-Z)</b>
									</p>
									<p id="claveNumero" class="invalido">
										Al menos <b>1 numero (0-9)</b>
									</p>
									<p id="claveEspecial" class="invalido">
										Al menos <b>1 carácter especial (_.-+*$)</b>
									</p>
									<p id="claveLongitud" class="invalido">
										Longitud min. de <b>8 caracteres</b>
									</p>
								</div>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave2">* Confirmar Clave Nueva</label>
								<input type="password" id="pswClave2" maxlength="45"
									class="form-control confirm-password valida_clave" 
									required placeholder="Confirme la clave"
									data-placement="right" title="Campo Obligatorio" 
									ata-toggle="tooltip" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<center>
									<button type="button" id="btnGuardar"
										value="Guardar" onclick="enviar();"
										style="background:#37474F; color:#fff; width:200px; height:40px;">
										Guardar
									</button>
									<button type="button" id="btnSalir" onclick="salir();"
										style="background:#37474F; color:#fff; width:200px; height:40px;">
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
} // cierra el condicional de sesión

// no esta logueado y trata de entrar sin autenticar
else {
	header("location: controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}
?>
