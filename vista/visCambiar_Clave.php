<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema" AND
	isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
	$vsVista = "Cambiar_Clave";
	$liVista = "27";
?>
<link rel="stylesheet" type="text/css" href="public/css/clave_items.css">

<div class="panel-heading">
	<h3 class="panel-title">
		Cambiar clave de acceso
	</h3>
</div>

<div class="panel-body">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestListado">Datos de Usuario</a></li>
	</ul>
	<br>

	<div class="tab-content">
		<div id="pestListado" class="tab-pane fade in active">
			<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" role="form"
				action="controlador/con<?=$vsVista;?>.php" class="form-horizontal" >
				<div class="row">

					<div class="form-group ui-front">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="textPregunta1">* Pregunta 1</label>
							<div id="textPregunta1"></div>
							<input id="hidPregunta1" name="hidPregunta1" type="text" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="ctxRespuesta1">* Respuesta 1</label>
							<input type="text" id="ctxRespuesta1" name="ctxRespuesta1" required
								class="form-control" maxlength="45" title="Campo Obligatorio"
								data-toggle="tooltip" data-placement="right"
								placeholder="Ingrese la primera respuesta" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="textPregunta2">* Pregunta 2</label>
							<div id="textPregunta2"></div>
							<input id="hidPregunta2" name="hidPregunta2" type="text" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="ctxRespuesta2">* Respuesta 2</label>
							<input  type="text" id="ctxRespuesta2" name="ctxRespuesta2" required
								class="form-control" maxlength="45" data-toggle="tooltip"
								placeholder="Ingrese la segunda respuesta"  data-placement="right"
								title="Campo Obligatorio" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="pswClave">* Ingresar Clave Nueva</label>
							<input id="pswClave" name="pswClave" type="password" required
								maxlength="45" class="form-control valida_clave new-password"
								placeholder="Ingrese la Clave" data-toggle="tooltip"
								data-placement="right" title="Campo Obligatorio" />
							<div class="divItemsClave">
								<p id="claveMinuscula" class="invalido">
									Al menos <strong>1 letra en minúscula (a-z)</strong>
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
							<input id="pswClave2" type="password" required
								maxlength="45"  class="form-control confirm-password"
								placeholder="Confirme la clave" data-placement="right"
								data-toggle="tooltip" title="Campo Obligatorio" />
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<br />
							<input type="hidden" name="operacion" id="operacion" value="CambiarClave" />
						</div>

						<div class="col-xs-6 col-sm-8 col-md-6 col-lg-9">
							<button name='iniciar' value="Guardar" onclick="enviar(this.value);"
								style="background:#37474F; color:#fff; width:200px; height:40px;">
								Guardar
							</button>
						</div>
					</div>
				</div>

				<input type='hidden' name='idpersona' id='idpersona' value="<?php
					if (isset($_SESSION["idpersona"]))
						echo $_SESSION["idpersona"]; ?>" />
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="public/js/clave_items.js"></script>

<?php
} //cierra el condicional de sesión

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>
