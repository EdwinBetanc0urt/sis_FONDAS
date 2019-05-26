<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Bitacora_Acceso";
	$liVista = "16";
?>

<div class="panel-heading">
	<h3 class="panel-title"> 	
		Usuarios del sistema
	</h3>
</div>

<div class="panel-body">			
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestListado">Listado</a></li>
	</ul>
	
	<br>

	<div class="tab-content">	


		<div id="pestListado" class="tab-pane fade in active">

			<form action="" name="formLista<?= $vsVista; ?>" id="formLista<?= $vsVista; ?>" role="form">
				<div class="row">
					<div class="form-group" >
						<div class="col-xs-10">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-search"></span>
								</span>
								<input type="search" id="ctxBusqueda" name="ctxBusqueda" 
								oninput="fjMostrarLista('<?= $vsVista; ?>');"
								onkeyup="fjMostrarLista('<?= $vsVista; ?>');" 
								class="valida_buscar form-control" 
								placeholder="Filtro de Busqueda" data-toggle="tooltip" data-placement="top" title="Terminos para buscar coincidencias en los registros" />
							</div>	
						</div>
	
						<div class="col-xs-2">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-list-alt"></span>
								</span>
								<input type="number" id="numItems" name="numItems" maxlength="4" 
								value="10" onkeyup="fjMostrarLista('<?= $vsVista; ?>');" required
								class="valida_num_entero form-control" placeholder="Items" data-toggle="tooltip" data-placement="top" title="Cantidad de items a mostrar en el listado" />
							</div>	
						</div>
					</div>
				</div>

				<!-- guarda el valor del atributo por donde va a ordenar -->
				<input type='hidden' name='hidOrden' id='hidOrden' />

				<!-- guarda el valor en la forma de ordenado si ASCendente o DESCendente -->
				<input type="hidden" id="hidTipoOrden" name="hidTipoOrden" />

				<!-- guarda el valor en la sub-pagina de a mostrar en la división de paginación -->
				<input type='hidden' name='subPagina' id='subPagina' />
								
				<div id="divListado" class="divListado"></div> <!-- Dentro se mostrara la tabla con el listado que genera el controlador -->
			</form>
		</div>
	</div>
</div>


<div id="VentanaModal" class="modal fade modal-primary">
	<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" action="controlador/con<?=$vsVista;?>.php" role="form" class="form-horizontal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title"><?=$vsVista;?></h2>
				</div>

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group ui-front">

							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="numId">* Código</label>
								<input name="numId" id="numId" type="number" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" value="<?php 
									if(isset($_GET["getId"])) 
										echo $_GET["getId"]; ?>" />								
							</div>


							<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
								<label for="cmbNacionalidad">* Nacionalidad</label>
								<select id='cmbNacionalidad' name='cmbNacionalidad' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Nacionaidad" size="1" style="width: 100%;">
									<option value="v">V - Venezolano</option>
									<option value="e">E - Extranjero</option>
								</select>
								<input id="hidNacionalidad" type="hidden" value="<?php
									if(isset($_GET['getNacionalidad']))
										echo $_GET['getNacionalidad']; ?>" />
							</div>
						
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="numCi">* C.I. (Usuario)</label>
								<input id="numCi" class="valida_num_entero form-control" maxlength="45" name="numCi" type="number" size="20" required value="<?php
									if(isset($_GET['getCI']))
										echo $_GET['getCI'];
								?>" placeholder="Ingrese el numero de identificacion" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
								<label for="ctxNombre">* Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
									if(isset($_GET['getNombre']))
										echo $_GET['getNombre'];
								?>" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
								<label for="ctxApellido">* Apellido</label>
								<input id="ctxApellido" class="valida_alfabetico form-control" maxlength="45" name="ctxApellido" type="text" size="20" required value="<?php
									if(isset($_GET['getApellido']))
										echo $_GET['getApellido'];
								?>" placeholder="Ingrese el Apellido" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
								<label for="cmbSexo">* Sexo</label>
								<select id='cmbSexo' name='cmbSexo' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
									<option value="m">Masculino</option>
									<option value="f">Femeniino </option>
									<option value="i">Indefinido</option>
								</select>
								<input id="hidSexo" type="hidden" value="<?php
									if(isset($_GET['getSexo']))
										echo $_GET['getSexo']; ?>" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
								<label for="ctxCorreo"> Correo</label>
								<input id="ctxCorreo" class="valida_correo form-control" maxlength="255" name="ctxCorreo" type="email" size="20" value="<?php
									if(isset($_GET['getCorreo']))
										echo $_GET['getCorreo'];
								?>" placeholder="Ingrese el Correo" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
								<label for="numTelefono">* Telefono Movil</label>
								<input id="numTelefono" class="valida_num_telefono form-control" maxlength="45" name="numTelefono" type="text" size="20" required value="<?php
									if(isset($_GET['getTeleMovil']))
										echo $_GET['getTeleMovil'];
								?>" placeholder="Ingrese el Telefono Movil" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
								<label for="cmbTipo_Usuario">* Tipo de Usuario</label>
								<select id='cmbTipo_Usuario' name='cmbTipo_Usuario' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Nacionaidad" size="1" style="width: 100%;" required>
									<option value="">Seleccione una opción..</option>
								</select>
								<input id="hidTipo_Usuario" type="hidden" value="<?php
									if(isset($_GET['getTipo_Usuario']))
										echo $_GET['getTipo_Usuario']; ?>" />
							</div>

							<div class="col-xs-6 col-sm-4 col-md-4">
								<label for="chxTrabaja">¿Es Trabajador?</label>
								<div class="input-group">
										NO
										<label class="switch">
											<input id="chxTrabaja" name="chxTrabaja" required="" value="no" type="checkbox">
											<div class="slider round"></div>
										</label>
										SI
								</div>
							</div>

							
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="divIngreso">
								<label for="datFechaIngreso">* Fecha de Ingreso</label>
								<input type="date" id="datFechaIngreso" class="valida_alfabetico form-control" maxlength="45" name="datFechaIngreso"  size="20" value="<?php
									if(isset($_GET['getFechaIngre']))
										echo $_GET['getFechaIngre'];
								?>" placeholder="Ingrese La Fecha de Ingreso" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>



							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4" id="divDepartamento">
								<label for="cmbDepartamento">* Departamento</label>
								<select id='cmbDepartamento' name='cmbDepartamento' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Departamento" size="1" style="width: 100%;">
									<option value="">Seleccione una opción..</option>
								</select>
								<input id="hidDepartamento" type="hidden" value="<?php
									if(isset($_GET['getDepartamento']))
										echo $_GET['getDepartamento']; ?>" />
							</div>


							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4" id="divCargo">
								<label for="cmbCargo">* Cargo</label>
								<select id='cmbCargo' name='cmbCargo' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Cargo" size="1" style="width: 100%;">
									<option value="">Seleccione una opción..</option>
								</select>
								<input id="hidCargo" type="hidden" value="<?php
									if(isset($_GET['getCargo']))
										echo $_GET['getCargo']; ?>" />
							</div>
							
					
						</div>

								
					</div>
				</div>
				<div class="modal-footer">
					<?php
						include_once("_botones.php");
					?>

				</div>
			</div>
		</div>
		<input type="hidden" name="hidEstatus" id="hidEstatus" value="<?php if(isset($_GET['getEstatus'])) echo $_GET['getEstatus']; ?>" />
		<input type="hidden" name="operacion" id="operacion" />
	</form>
</div>

<?php
} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>
