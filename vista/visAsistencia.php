<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Asistencia";
	$liVista = "20";
?>

<div class="panel-heading">
	<h3 class="panel-title">
		Asistencia
	</h3>
</div>

<div class="panel-body">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active" id="liActual">
			<a data-toggle="tab" href="#pestMarcaje">Marcaje del Dia</a>
		</li>
		<li id="liListado">
			<a data-toggle="tab" href="#pestListado">Listado</a>
		</li>
	</ul>
	<br>

	<div class="tab-content">
		<div id="pestMarcaje" class="tab-pane fade in active">
			<form name="form<?= $vsVista; ?>" id="form<?= $vsVista; ?>" method="POST"
				action="controlador/con<?=$vsVista;?>.php" role="form">
				<div class="row">

					<div class="form-group">
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<label for="ctxTrabajador">* Trabajador</label>
							<br>
							<?php
								echo $_SESSION["nacionalidad"] . "-" . $_SESSION["cedula"] .
									", " . $_SESSION["nombre"] . " " . $_SESSION["apellido"];
							?>
							<input type="hidden" id="numTrabajador" name="numTrabajador"
								value="<?= $_SESSION["idtrabajador"] ?>" />
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<label for="ctxFecha">* Fecha Actual de Marcaje</label>
							<input type="text" id="ctxFecha" readonly maxlength="45"
								class="form-control" value="<?= date("d/m/Y") ?>" />
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<label for="ctxTiempoMarcaje">* Hora Actual de Marcaje</label>
							<input type="text" id="ctxTiempoMarcaje" name="ctxTiempoMarcaje"
								class="form-control" readonly maxlength="45" />
							<input type="hidden" id="hidHora">
							<input type="hidden" id="hidMinuto">
							<!-- <div id="divReloj" style="text-align:center;" ></div> -->
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<button type="button" id="btnMarcar" class="btn btn-primary"
								onclick="enviar();" value="marcar">
								<span class="glyphicon glyphicon-plus"></span>
								Marcar Asistencia
							</button>
						</div>
					</div>

					<div class="form-group">
						<br><br>
					</div>

                    <div class="form-group">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3S">
                            <div class="input-group">
                                <span class="input-group-addon">
									<input type="checkbox" id="chkEntrada1" name="chkEntrada1"
									 aria-label="aria-label" class="chkDia">
                                </span>
                                <input type="text" class="form-control" value="Entrada 1" readonly />
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3S">
                            <div class="input-group">
                                <span class="input-group-addon">
									<input type="checkbox" id="chkSalida1" name="chkSalida1"
									 aria-label="aria-label" class="chkDia">
                                </span>
                                <input type="text" class="form-control" value="Salida 1" readonly />
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3S">
                            <div class="input-group">
                                <span class="input-group-addon">
									<input type="checkbox" id="chkEntrada2" name="chkEntrada2"
									 aria-label="aria-label" class="chkDia">
                                </span>
                                <input type="text" class="form-control" value="Entrada 2" readonly />
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3S">
                            <div class="input-group">
                                <span class="input-group-addon">
									<input type="checkbox" id="chkSalida2" name="chkSalida2"
									 aria-label="aria-label" class="chkDia">
                                </span>
                                <input type="text" class="form-control" value="Salida 2" readonly />
                            </div>
                        </div>
					</div>
				</div>

				<!-- guarda el valor en la sub-pagina de a mostrar en la división de paginación -->
				<input type='hidden' name='subPagina' id='subPagina' />
				<input type='hidden' name='operacion' id='operacion' />
				<input type='hidden' name='campo' id='campo' />

			</form>
        </div>

		<div id="pestListado" class="tab-pane fade">
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

<?php
} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>
