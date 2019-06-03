<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Supervisar_Asistencias";
	$liVista = "42";
?>

<div class="panel-heading">
	<h3 class="panel-title">
		Supervision de Asistencias del Departamento
	</h3>
	<br>

</div>

<div class="panel-body">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active">
			<a data-toggle="tab" href="#pestAsistencia">Asistencia</a>
		</li>
		<li>
			<a data-toggle="tab" href="#pestInasistencia">Inasistencia</a>
		</li>
	</ul>
	<br>

	<div class="tab-content">
		<div id="pestAsistencia" class="tab-pane fade in active">
			<form name="formLista<?= $vsVista ?>" id="formLista<?= $vsVista ?>" role="form">
				<div class="row">
					<div class="form-group" >
						<div class="col-xs-10">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-search"></span>
								</span>
								<input type="search" id="ctxBusqueda" name="ctxBusqueda"
								oninput="fjMostrarLista('<?= $vsVista ?>');"
								onkeyup="fjMostrarLista('<?= $vsVista ?>');"
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
								value="10" onkeyup="fjMostrarLista('<?= $vsVista ?>');" required
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

		<div id="pestInasistencia" class="tab-pane fade">
			<form name="formListaInasistencia" id="formListaformListaInasistencia" role="form">
				<div class="row">
					<div class="form-group" >
						<div class="col-xs-10">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-search"></span>
								</span>
								<input type="search" id="ctxBusqueda" name="ctxBusqueda"
								oninput="fjMostrarLista('formListaInasistencia', '', '', '', 'listaInasistente');"
								onkeyup="fjMostrarLista('formListaInasistencia', '', '', '', 'listaInasistente');"
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
								value="10" onkeyup="fjMostrarLista('formListaInasistencia', '', '', '', 'listaInasistente');" required
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
	<form id="form<?=$vsVista?>" name="form<?=$vsVista?>" method="POST" action="controlador/con<?=$vsVista?>.php" role="form" class="form-horizontal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title">Supervisar Asistencias</h2>
				</div>

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group ui-front">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<input name="numId" id="numId" type="hidden"
									readonly onkeypress="return false" />

								<label for="ctxNombre">* Trabajador</label>
								<input type="text" id="ctxNombre" name="ctxNombre"
									class="form-control" readonly />
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="ctxEntrada1">Entrada 1</label>
								<input type="text" id="ctxEntrada1" name="ctxEntrada1"
									class="form-control hora_pickatime" maxlength="45" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<label for="ctxNota1">Nota 1</label>
								<input type="text" id="ctxNota1" name="ctxNota1"
									class="form-control" maxlength="45"
									data-toggle="tooltip" data-placement="right"
									title="Ingrese una nota en relacion a la hora de marcaje" />
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="ctxSalida1">Salida 1</label>
								<input type="text" id="ctxSalida1" name="ctxSalida1"
									class="form-control hora_pickatime" maxlength="45"
									data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<label for="ctxNota2">Nota 2</label>
								<input type="text" id="ctxNota2" name="ctxNota2"
									class="form-control" maxlength="45"
									data-toggle="tooltip" data-placement="right"
									title="Ingrese una nota en relacion a la hora de marcaje" />
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="ctxEntrada2">Entrada 2</label>
								<input type="text" id="ctxEntrada2" name="ctxEntrada2"
									class="form-control hora_pickatime" maxlength="45"
									data-toggle="tooltip" data-placement="right"
									title="Campo Obligatorio" />
							</div>
							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<label for="ctxNota3">Nota 3</label>
								<input type="text" id="ctxNota3" name="ctxNota3"
									class="form-control" maxlength="45"
									data-toggle="tooltip" data-placement="right"
									title="Ingrese una nota en relacion a la hora de marcaje" />
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="ctxSalida2">Salida 2</label>
								<input type="text" id="ctxSalida2" name="ctxSalida2"
									class="form-control hora_pickatime" maxlength="45"
									data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<label for="ctxNota4">Nota 4</label>
								<input type="text" id="ctxNota4" name="ctxNota4"
									class="form-control" maxlength="45"
									data-toggle="tooltip" data-placement="right"
									title="Ingrese una nota en relacion a la hora de marcaje" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="ctxObservacion" >* Observación</label>
								<textarea id="ctxObservacion" name="ctxObservacion"
									class="form-control" rows="2"
									data-toggle="tooltip" data-placement="right"
									title="Observacion general, estara visible para el trabajador"
									maxlength="255"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnMarcar" class="btn btn-primary"
						onclick="enviar();" value="ajustar">
						<span class="fa fa-pencil"></span>
						Ajustar Asistencia
					</button>
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
