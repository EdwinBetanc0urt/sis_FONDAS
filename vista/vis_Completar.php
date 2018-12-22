<?php


if (isset($_SESSION) && $_SESSION["sesion"] = "completar") {

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina de Inicio FONDAS</title>

	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8"/>
	<script type="text/javascript" src="public/jquery/jquery.js"></script>
	<link rel="stylesheet" href="public/sweetalert2/sweetalert2.min.css">
	<script src="public/sweetalert2/sweetalert2.min.js"></script>

	<link rel="stylesheet" href="public/css/menu.css">
	<link rel="stylesheet" href="public/css/w3.css">
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.css">

	<script type="text/javascript" src="public/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/completar_registro.js"></script>

<body>

	
	<!--inicio de cintillo-->
    <div class="header" style="width:100%;align:center;position:relative; background:#37474F;"  >
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
				
				<form id="formCompletarRegistro" name="formCompletarRegistro" method="POST" action="controlador/conCompletar.php" role="form" class="form-horizontal" >
					<div class="row">
						
						<div class="form-group ui-front">
									
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre">* Primer Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
									if( isset( $_SESSION['nombre'] ) )
										echo $_SESSION['nombre'];
								?>" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre2">* Segundo Nombre</label>
								<input id="ctxNombre2" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre2" type="text" size="20" placeholder="Ingrese la Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido">* Primer Apellido</label>
								<input id="ctxApellido" class="valida_alfabetico form-control" maxlength="45" name="ctxApellido" type="text" size="20" required value="<?php
									if( isset( $_SESSION['apellido'] ) )
										echo $_SESSION['apellido'];
								?>" placeholder="Ingrese la Apellido" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido2">* Segundo Apellido</label>
								<input id="ctxApellido2" class="valida_alfabetico form-control" maxlength="45" name="ctxApellido2" type="text" size="20"  placeholder="Ingrese la Apellido" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="cmbSexo">* Sexo</label>
								<select id='cmbSexo' name='cmbSexo' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;">
											<option value="">Selecciona Uno...</option>
											<option value="m">Masculino</option>
											<option value="f">Femeniino </option>
											<option value="i">Indefinido</option>
								</select>
								<input id="hidSexo" type="hidden" value="<?php
									if( isset( $_SESSION['sexo'] ) )
										echo $_SESSION['sexo']; ?>" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="cmbEdoCivil">* Estado Civil</label>
								<select id='cmbEdoCivil' name='cmbEdoCivil' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="EdoCivil al cual pertenece el municipio" size="1" style="width: 100%;">
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
								<input id="datFechaNac" class="valida_alfabetico form-control" maxlength="45" name="datFechaNac" type="date" size="20" required placeholder="Ingrese la Fecha de Nacimiento" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxCorreo">* Correo</label>
								<input id="ctxCorreo" class="valida_correo form-control" maxlength="45" name="ctxCorreo" type="text" size="20" required value="<?php
									if( isset( $_SESSION['correo'] ) )
										echo $_SESSION['correo'];
								?>" placeholder="Ingrese el Correo" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono">* Telefono Movil</label>
								<input id="numTelefono" class="valida_numerico form-control" maxlength="45" name="numTelefono" type="text" size="20" required value="<?php
									if( isset( $_SESSION['tel_mov'] ) )
										echo $_SESSION['tel_mov'];
								?>" placeholder="Ingrese el Telefono Movil" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono2">* Telefono Fijo</label>
								<input id="numTelefono2" class="valida_numerico form-control" maxlength="45" name="numTelefono2" type="text" size="20" placeholder="Ingrese el Telefono Fijo" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>	

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label for="ctxDireccion">* Dirección</label>
								<input id="ctxDireccion" class="valida_alfabetico form-control" maxlength="45" name="ctxDireccion" type="text" size="20" required placeholder="Ingrese la Dirección" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbEstado">* Estado</label>
								<select id='cmbEstado' name='cmbEstado' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidEstado" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbMunicipio">* Municipio</label>
								<select id='cmbMunicipio' name='cmbMunicipioo' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidMunicipio" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<label for="cmbParroquia">* Parroquia</label>
								<select id='cmbParroquia' name='cmbParroquia' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidParroquia" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta1">* Pregunta 1</label>
								<select id='cmbPregunta1' name='cmbPregunta1' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta1" type="hidden" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta1">* Respuesta 1</label>
								<input id="ctxRespuesta1" class=" form-control" maxlength="45" name="ctxRespuesta1" type="text" size="20" required placeholder="Ingrese la primera respuesta" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta2">* Pregunta 2</label>
								<select id='cmbPregunta2' name='cmbPregunta2' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta2" type="hidden" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta2">* Respuesta 2</label>
								<input id="ctxRespuesta2" class=" form-control" maxlength="45" name="ctxRespuesta2" type="text" size="20" required placeholder="Ingrese la segunda respuesta" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Nueva</label>
								<input id="pswClave" class=" form-control" maxlength="45" name="pswClave" type="password" size="20" required placeholder="Ingrese la Clave " data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave2">* Confirmar Clave Nueva</label>
								<input id="pswClave2" class=" form-control" maxlength="45" name="pswClave2" type="password" size="20" required placeholder="Confirme la clave " data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br />
								<input type="hidden" name="operacion" id="operacion" />
							</div>	

							<div class="col-xs-6 col-sm-8 col-md-6 col-lg-9">
								<button style="background:#37474F; color:#fff; width:200px; height:40px;" name='iniciar' value="Guardar" onclick="enviar( this.value );" >
									Guardar
								</button>
								<button style="background:#37474F; color:#fff; width:200px; height:40px;" onclick="salir();" >
									Cancelar
								</button>
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


<!--fin cuerpo-->
</body>
</html>

<?php

}

?>