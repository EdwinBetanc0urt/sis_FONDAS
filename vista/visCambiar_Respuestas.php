<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Cambiar_Respuestas";
	$liVista = "71";
?>


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
			<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" action="controlador/con<?=$vsVista;?>.php" role="form" class="form-horizontal" >
				<div class="row">

						<div class="form-group ui-front">
							
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Actual</label>
								<input id="pswClave" class=" form-control" maxlength="45" name="pswClave" type="password" size="20" required placeholder="Ingrese la Clave " data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>									

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br />
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
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br />
								<input type="hidden" name="operacion" id="operacion" />
							</div>	

							<div class="col-xs-6 col-sm-8 col-md-6 col-lg-9">
								<button style="background:#37474F; color:#fff; width:200px; height:40px;" name='iniciar' value="Guardar" onclick="enviar(this.value);" >
									Guardar
								</button>
							</div>	
						</div>	
				</div>

				<!-- guarda el valor en la sub-pagina de a mostrar en la división de paginación -->
				<input type='hidden' name='idpersona' id='idpersona' value="<?php
					if(isset($_SESSION["idpersona"]))
						echo $_SESSION["idpersona"]; ?>" />
			</form>
		</div>


	</div>
</div>



<?php



} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>