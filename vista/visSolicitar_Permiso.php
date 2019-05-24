<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Solicitar_Permiso";
	$liVista = "23";
?>

<div class="panel-heading">
	<h3 class="panel-title">
		<button id="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
		<span class="glyphicon glyphicon-plus"></span>
		Nuevo
		</button>
		Solicitud de Permiso
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
					<h2 class="modal-title">Solicitud de Permiso</h2>
				</div>

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">

							<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
								<input name="numId" id="numId" type="hidden" readonly onkeypress="return false" value="<?php 
									if(isset($_GET["getId"])) 
										echo $_GET["getId"]; ?>" />

								<label for="ctxNombre">* Solicitante</label>
								<input id="ctxNombre" class="form-control" maxlength="45" type="text" size="20" readonly value="<?php
									echo $_SESSION["nacionalidad"] . "-" . $_SESSION["cedula"] . ", " . $_SESSION["nombre"] . " " . $_SESSION["apellido"];
								?>" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Generado automaticamente" />
	
								<input name="numIdTrabajador" id="numIdTrabajador" type="hidden" readonly onkeypress="return false" value="<?= $_SESSION["idtrabajador"]; ?>" />
							</div>

							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
								<label for="ctxFechaElaboracion">* Fecha de Elaboracion</label>
								<input id="ctxFechaElaboracion" class="form-control" name="ctxFechaElaboracion" type="text" readonly placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Generado automaticamente" value="<?= date("d-m-Y h:m");?>" />
							</div>
							
							<!--
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="supervisor">Supervisor</label>
								<input id="supervisor" class="form-control" type="text" readonly data-toggle="tooltip" data-placement="right" title="Generado automaticamente" />
								<input name="numIdSupervisor" id="numIdSupervisor" type="hidden" readonly onkeypress="return false" />
							</div>
							-->

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="cmbMotivo_Permiso">* Motivo de Permiso</label>
								<select id='cmbMotivo_Permiso' name='cmbMotivo_Permiso' class="dinamico form-control select2" data-toggle="tooltip" required  data-placement="right" title="Campo obligatorio" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidMotivo_Permiso" type="hidden" value="<?php
									if(isset($_GET['getMotivo_Permiso']))
										echo $_GET['getMotivo_Permiso']; ?>" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="ctxObservacion">* Justificaciones o Comprobante</label>
								<textarea cols="5" id="ctxObservacion" class="valida_alfabetico form-control" required maxlength="150" name="ctxObservacion" type="text" placeholder="Ingrese la Justificacion" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" ><?php
									if(isset($_GET['getObservacion']))
										echo $_GET['getObservacion'];
								?></textarea>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFechaInicio">* Inicio del Permiso</label>
								<input type="text" id="ctxFechaInicio" name="ctxFechaInicio"
									class="fecha_hora_datepicker form-control"
									maxlength="45" required placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="bottom"
									title="Campo Obligatorio, especifique la hora exacta" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFechaFin">* Reincorporación del Permiso</label>
								<input type="text" id="ctxFechaFin" class="form-control" name="ctxFechaFin"
								readonly placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Generado automaticamente" />
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
	header("location: ../control/seguridad/ctr_LogOut.php?getMotivoLogOut=sinlogin");
}

?>
