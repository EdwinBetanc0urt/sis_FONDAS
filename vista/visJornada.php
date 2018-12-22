<?php

// existe y esta la variable de sesión rol
if ( isset( $_SESSION["sesion"] ) AND $_SESSION["sesion"] == "sistema" ) {
	$vsVista = "Jornada";
	$liVista = "15";
?>


<div class="panel-heading">
	<h3 class="panel-title"> 	
		<button id="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
			<span class="glyphicon glyphicon-plus"></span>
			Nuevo
		</button>
		Jornada
	</h3>
</div>

<div class="panel-body">			
	<ul class="nav nav-tabs" id="myTab">
		<li class="active">
			<a data-toggle="tab" href="#pestListado">Listado</a>
		</li>
	</ul>
	
	<br>

	<div class="tab-content">	

		<div id="pestListado" class="tab-pane fade in active">
			<form action="" name="formLista<?= $vsVista; ?>" id="formLista<?= $vsVista; ?>" role="form" >
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

							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
								<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" value="<?php 
									if( isset( $_GET["getId"] ) ) 
										echo $_GET["getId"]; ?>" />
								<label for="ctxNombre">* Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
									if( isset( $_GET['getNombre'] ) )
										echo $_GET['getNombre'];
								?>" placeholder="Ej: Regular o normal " data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
								<br/>
							</div>

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<label for="numTurnos">* Nro Turnos</label>
								<input id="numTurnos" class="valida_num_entero form-control" maxlength="1" max="2" min="1" name="numTurnos" type="number" size="20" required value="<?php
									if( isset( $_GET['getTurnos'] ) )
										echo $_GET['getTurnos'];
								?>" placeholder="Ej: 2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
								<br/>
							</div>
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label>Primer Turno</label><br>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="ctxHoraEntrada1">* 1ra. Hora de Entrada</label>
									<input id="ctxHoraEntrada1" class="hora_pickatime valida_tiempo form-control col-xs-6 col-sm-6 col-md-6 col-lg-6" maxlength="100" name="ctxHoraEntrada1" type="text" required placeholder="Ej: 08:00pm" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" value="<?php
										if( isset( $_GET['getHoraEntrada1'] ) )
											echo $_GET['getHoraEntrada1'];
									?>" />
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="ctxHoraSalida1">* 1ra. Hora de Salida</label>
									<input id="ctxHoraSalida1" class="hora_pickatime valida_tiempo form-control" maxlength="100" name="ctxHoraSalida1" type="text" required placeholder="Ej: 12:00pm" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" value="<?php
									if( isset( $_GET['getHoraSalida1'] ) )
										echo $_GET['getHoraSalida1']; ?>" />
			
								</div>
								<br/>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br>
								<label>Segundo Turno</label><br>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="ctxHoraEntrada2">* 2da. Hora de Entrada</label>
									<input id="ctxHoraEntrada2" class="hora_pickatime valida_tiempo form-control col-xs-6 col-sm-6 col-md-6 col-lg-6" maxlength="100" name="ctxHoraEntrada2" type="text" placeholder="Ej: 01:00pm" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" value="<?php
										if( isset( $_GET['getHoraEntrada2'] ) )
											echo $_GET['getHoraEntrada2'];
									?>" />
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="ctxHoraSalida2">* 2da. Hora de Salida</label>
									<input id="ctxHoraSalida2" class="hora_pickatime valida_tiempo form-control" maxlength="100" name="ctxHoraSalida2" type="text" placeholder="Ej: 04:00pm" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" value="<?php
									if( isset( $_GET['getHoraSalida2'] ) )
										echo $_GET['getHoraSalida2']; ?>" />
			
								</div>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
								<br/>
								<label for="divListaDias">Dias Laborables de la Semana </label>
								<div id="divListaDias"></div>
								<br/>
							</div>
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br />
								<label for="ctxObservacion">* Observacion</label>
								<textarea cols="5" id="ctxObservacion" class="valida_alfabetico form-control" maxlength="100" name="ctxObservacion" type="text" placeholder="Ingrese la Observacion" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" ><?php
									if( isset( $_GET['getObservacion'] ) )
										echo $_GET['getObservacion'];
								?></textarea>
							</div>
						</div>
								
					</div>
				</div>
				<div class="modal-footer">
					<?php
						include_once( "_botones.php" );
					?>

				</div>
			</div>
		</div>
		<input type="hidden" name="hidEstatus" id="hidEstatus" value="<?php if( isset( $_GET['getEstatus'] ) ) echo $_GET['getEstatus']; ?>" />
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