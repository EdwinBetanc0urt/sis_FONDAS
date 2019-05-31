<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Rep_Reposo";
	$liVista = "36";
?>

<div class="panel-heading">
	<h3 class="panel-title">
		Reporte de Reposo
	</h3>
</div>

<div class="panel-body">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestReporte">Reporte</a></li>
	</ul>
	<br>

	<div class="tab-content">
		<div id="pestReporte" class="tab-pane fade in active">
			<form name="form<?= $vsVista; ?>" id="form<?= $vsVista; ?>" action="pdf/RepReposo.php" role="form" method="POST" target="_blank" >
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Metodo de Ordenado</h3>
					</div>
					<div class="panel-body">
						<div class="row">

							<div class="form-group" >
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="cmbOrden">Ordenar Por</label>
									<!-- COMBO  O LISTA DESPLEGABLE -->
									<select name='cmbOrden' id='cmbOrden' class="form-control">
										<option value="cedula" selected="selected"> Cedula de Trabajador </option>
										<option value="nombre"> Nombre y Apellido del Trabajador </option>
									</select>
								</div>

								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label>Mostrar De Forma</label><br>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<div class="input-group">
											<span class="input-group-addon">
												<input checked='checked' name="radOrden" id="radOrdenA" type="radio" value="ASC">
											</span>
											<input type="text" class="form-control" value="Ascendente" readonly="readonly">
										</div><!-- /input-group -->
									</div><!-- /.col-lg-6 -->

									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<div class="input-group">
											<span class="input-group-addon">
												<input  name="radOrden" id="radOrdenD" type="radio" value="DESC">
											</span>
											<input type="text" class="form-control" value="Descendente" readonly="readonly">
										</div><!-- /input-group -->
									</div><!-- /.col-lg-6 -->
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Rangos a Mostrar</h3>
					</div>
					<div class="panel-body">


					<div class="form-group">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
										<label for="ctxFechaInicio" class="control-label">
											Fechas a Seleccionar
										</label>
				    			</div><!-- /input-group -->
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<label for="ctxFechaInicio" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2"> Desde </label>
				      				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
				      					<input type="date" id="ctxFechaInicio" name="ctxFechaInicio" maxlength="10" required class="form-control">
				      				</div>
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<label for="ctxFechaFinal" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Hasta</label>
				      				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
				      					<input type="date" id="ctxFechaFinal" name="ctxFechaFinal" maxlength="10" required class="form-control">
				      				</div>
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->
						</div>

						<div class="form-group">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input type="radio" name="radRangoTipo" id="radRangoTipoT" value="todo" checked="checked">
				      				</span>
				      				<input type="text" class="form-control" value="Todos los Registros" readonly="readonly">
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input type="radio" name="radRangoTipo" id="radRangoTipoD" value="dentro">
				      				</span>
				      				<input type="text" class="form-control" value="Registros Dentro del Rango" readonly="readonly">
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input  type="radio" name="radRangoTipo" id="radRangoTipoF" value="fuera">
				      				</span>
				      				<input type="text" class="form-control" value="Registros Fuera del Rango" readonly="readonly">
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->
						</div>
						<br><br>

						<div class="form-group">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input type="radio" name="radRango" id="radRangoEstatus" value="condicion">
				      				</span>
				      				<input type="text" class="form-control" value="Rango por Estatus" readonly="readonly">
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->

							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<div class="input-group">
				    				<div class="col-xs-4">
										<label for="cmbCondicion" class="control-label">Desde</label>
									</div>
									<div class="col-xs-8">
										<select name='cmbCondicion' id='cmbCondicion' class="form-control" style="width: 100%">
											<option value="solicitado" selected="selected"> Solicitado </option>
											<option value="revisado"> Revisado </option>
											<option value="aprobado"> Aprobado </option>
											<option value="rechazado"> Rechazado </option>
										</select>
				    				</div>
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->
						</div>
						<br><br>

						<div class="form-group">
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input type="radio" name="radRango" id="radRangoTrabajador" value="trabajador">
				      				</span>
				      				<input type="text" class="form-control" value="Rango por Trabajador" readonly="readonly">
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->

							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 form-inline">
				    			<div class="input-group">
				      				<label for="cmbTrabajador" class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3"> Trabajador</label>
									<!-- COMBO  O LISTA DESPLEGABLE -->
									<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
										<select id='cmbTrabajador' name='cmbTrabajador' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Estado al cual pertenece el municipio" size="1" style="width: 100%;" required>

											<option value="" > Seleccione Una opcion </option>
										</select>
										<input type="hidden" id="hidTrabajador">
									</div>
				    			</div><!-- /input-group -->
				  			</div><!-- /.col-lg-6 -->
						</div>
					</div>
				</div>

				<center>
					<?php
						include_once("_botones.php");
					?>
					<input type="hidden" name="operacion" id="operacion" />
				</center>
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
