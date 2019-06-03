<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Asistencia";
	$liVista = "20";
?>

<div class="panel-heading">
	<h3 class="panel-title"> 	
		<button id="btnNuevo" class="btn btn-primary" onclick="fjNuevoRegistro();">
			<span class="glyphicon glyphicon-plus"></span>
			Nuevo
		</button>
		Asistencia 
	</h3>
</div>

<div class="panel-body">			
	<ul class="nav nav-tabs" id="myTab">
		<li class="active" id="liListado">
			<a data-toggle="tab" href="#pestListado">Listado</a>
		</li>
		<li id="liDetalle">
			<a data-toggle="tab" href="#pestDetalle">Detalle</a>
		</li>
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

		<div id="pestDetalle" class="tab-pane ">

			<form method="POST" action="controlador/conAsistencia.php" name="form<?= $vsVista; ?>" id="form<?= $vsVista; ?>" role="form">

				<div class="panel panel-primary">

					<div class="panel-heading">
						<h3 class="panel-title"> Datos de Cabecera 
						</h3>
					</div>

					<div class="panel-body">
						
						<input type="hidden" name="numId" id="numId" value="222" />

						<div class="form-group">
							<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
								<label for="fecElaboracion" >Fecha Elaboración</label>
								<input id="fecElaboracion" name="fecElaboracion" type="text" class="form-control" data-toggle="tooltip" data-placement="right" title="Campo Opcional" value="<?php echo date('d-m-Y'); ?>" readonly />
								<input id="fecModifica" name="fecModifica" type="hidden" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
								<label for="horElaboracion" >Hora Elaboración</label>
								<input id="horElaboracion" name="horElaboracion" type="hi" class="form-control" data-toggle="tooltip" data-placement="right" title="Campo Opcional" value="<?php echo date('h:n:s'); ?>" readonly />
								<input id="horModifica" name="horModifica" type="hidden" class="form-control" value="<?php echo date('h:n:s'); ?>" readonly />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label for="ctxUsuario"> *Responsable </label>
								<input id="ctxUsuario" type="text" class="form-control" data-toggle="tooltip" data-placement="right" value="<?= $_SESSION["usuario"] . ", " . $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?>" readonly />
								<input type="hidden" id="numUsuario" name="numUsuario" value="<?= $_SESSION["id_usuario"] ?>" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="txaObservacion" >Observacion General</label>
								<textarea id="txaObservacion" name="txaObservacion" class="form-control" data-toggle="tooltip" data-placement="top" title="Observcion general como datos adicionales, es opcional"  ></textarea>
							</div>
						</div>
					</div>
				</div>

				<div id="txt" style="text-align:center;" ></div>
				<input id="ctxReloj" type="hidden" />

				<div class="panel panel-primary">

					<div class="panel-heading">
						<h3 class="panel-title"> Renglones </h3>
					</div>

					<div class="panel-body">
					
						<!-- aca se guardan separado por comas los articulos ya agregados para evitar que se repitan -->
						<input type="hidden" id="ctxCodigos" class="form-control" />

						<div class='table-responsive'>
							<table id="tabDetalle" border='0' valign='center' class='table table-striped text-center table-hover'>
								<thead>
									<tr class='info'>
										<th class="text-left" > 
											Trabajador
										</th>
										<th >
											Hora Entrada
										</th>
										<th > 
											Acciones
										</th>
									</tr>
									<tr align="center" id="trAgregarDetalle">
										<td >
											<input type="hidden" id="numIdTrabajador" maxlength='7' class="valida_num_entero"  />

											<input type="text" id="ctxNombreTrabajador" maxlength='7' class="form-control" placeholder="Ingrese el Trabajador" />
										</td>
										<td >
											<input type="text" id="ctxHoraEntrada" maxlength='7' class="form-control tiempo"  placeholder="Ingrese la hora de entrada" readonly />
										</td>
										<td>
											<button type="button" onclick="agregarDetalle()" class="btn btn-primary" value="add" name="addService">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
											<button type="button" onclick="fjDesplegarCatalogo()" class="btn btn-primary" >
												<span class="glyphicon glyphicon-search"></span>
											</button>
											<!-- abre la ventana modal con campos vacios recargando la vista -->
										</td>
									</tr>
								</thead>
								<tbody id="tabBodyDetalle" >
								</tbody>
							</table>
						</div>

					</div>
				</div>

				<center>
					<div class="col-xs-12">
						
						<button type="button" class="btn btn-info right" onclick="enviar(this.value);" value="incluir" >
							Guardar
						</button>
						<!--
						<div id="divBotonesC" class="col-xs-4">
							<button type='button' value='Reporte' id="btnReporte" 
								name="btnReporte" class="btn btn-info right"
								onClick='fjGenerar();' >
								<i class="fa fa-print"></i> 
								Generar PDF
							</button>
						</div>
						-->
						<div class="col-xs-4"> 
							<a id="btnCancelar"
							 class="btn btn-danger" name="btnCancelar" onClick='fjCancelar();'>
								<i class="fa fa-cancel"></i> Cancelar
							</a>
						</div>
					</div>
				</center>
				<input type="hidden" id="operacion" name="operacion" value="incluir">
				<input type="hidden" id="hidCondicion" name="hidCondicion">

			</form>
		</div>

	</div>
</div>



<div id="VentanaModal" class="modal fade modal-primary">
	<form id="formListaTrabajador" name="formListaTrabajador" role="form" class="form-horizontal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title"> Trabajadores </h2>
				</div>

				<div class="modal-body">

					<div class="row">
						<div class="form-group" >
							<div class="col-xs-7 col-sm-9 col-md-9 col-lg-9">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-search"></span>
									</span>
									<input type="search" id="ctxBusqueda" name="ctxBusqueda" 
									 oninput='fjMostrarLista("Trabajador", "", "", "", "ListaCatalogo", ["", $("#ctxCodigos").val()]);'
							 		 onkeyup='fjMostrarLista("Trabajador", "", "", "", "ListaCatalogo", ["", $("#ctxCodigos").val()]);' 
							 		 class="valida_buscar form-control" 
									 placeholder="Filtro de Busqueda" />
								</div>	
							</div>

							<div class="col-xs-5 col-sm-3 col-md-3 col-lg-3">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-list-alt"></span>
									</span>
									<input type="text" id="numIntems" name="numIntems" maxlength="4" 
									 value="10" onkeyup='fjMostrarLista("Trabajador", "", "", "", "ListaCatalogo", ["", $("#ctxCodigos").val()]);' required 
									 class="valida_num_entero form-control" placeholder="Items" />
								</div>	
							</div>
						</div>
					</div> <!-- cierre de div class row -->

					<!-- guarda el valor del atributo por donde va a ordenar -->
					<input type='hidden' name='hidOrden' id='hidOrden' />

					<!-- guarda el valor en la forma de ordenado si ASCendente o DESCendente -->
					<input type="hidden" id="hidTipoOrden" name="hidTipoOrden" />

					<!-- guarda el valor en la subpagina de a mostrar en la division de paginacion -->
					<input type='hidden' name='subPagina' id='subPagina' />
					
					<!-- Dentro se mostrara la tabla con el listado que genera el controlador -->
					<div id="divListado" class="divListado"></div> 
	
				</div>
			</div>
		</div>
		<input type="hidden" name="hidEstatus" id="hidEstatus" />
		<input type="hidden" name="vvOpcion" id="vvOpcion" />
	</form>
</div> <!-- Cierre de div VentanaModal -->


<?php
} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>
