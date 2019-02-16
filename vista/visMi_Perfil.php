<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Mi_Perfil";
	$liVista = "71";
?>


<div class="panel-heading">
	<h3 class="panel-title"> 	
		Mis datos personales
	</h3>
</div>

<div class="panel-body">			
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestListado">Datos Personales</a></li>
	</ul>
	
	<br>

	<div class="tab-content">	


		<div id="pestListado" class="tab-pane fade in active">
			<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" action="controlador/con<?=$vsVista;?>.php" role="form" class="form-horizontal" >
				<div class="row">

						<div class="form-group ui-front">
									
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre">* Primer Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
									if(isset($_SESSION['nombre']))
										echo $_SESSION['nombre'];
								?>" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxNombre2">* Segundo Nombre</label>
								<input id="ctxNombre2" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre2" type="text" size="20" required placeholder="Ingrese la Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido">* Primer Apellido</label>
								<input id="ctxApellido" class="valida_alfabetico form-control" maxlength="45" name="ctxApellido" type="text" size="20" required value="<?php
									if(isset($_SESSION['apellido']))
										echo $_SESSION['apellido'];
								?>" placeholder="Ingrese la Apellido" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="ctxApellido2">* Segundo Apellido</label>
								<input id="ctxApellido2" class="valida_alfabetico form-control" maxlength="45" name="ctxApellido2" type="text" size="20" required  placeholder="Ingrese la Apellido" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
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
									if(isset($_SESSION['sexo']))
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
									if(isset($_SESSION['correo']))
										echo $_SESSION['correo'];
								?>" placeholder="Ingrese el Correo" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono">* Telefono Movil</label>
								<input id="numTelefono" class="valida_numerico form-control" maxlength="45" name="numTelefono" type="text" size="20" required value="<?php
									if(isset($_SESSION['tel_mov']))
										echo $_SESSION['tel_mov'];
								?>" placeholder="Ingrese el Telefono Movil" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numTelefono2">* Telefono Fijo</label>
								<input id="numTelefono2" class="valida_numerico form-control" maxlength="45" name="numTelefono2" type="text" size="20" required placeholder="Ingrese el Telefono Fijo" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
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