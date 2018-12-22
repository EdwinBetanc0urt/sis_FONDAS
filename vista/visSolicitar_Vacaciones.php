<?php

// existe y esta la variable de sesión rol
if ( isset( $_SESSION["sesion"] ) AND $_SESSION["sesion"] == "sistema" ) {
	$vsVista = "Solicitar_Vacaciones";
	$liVista = "10";
?>
        <script type="text/javascript">
            $(function () {

                //$("#numVacaciones").on( "change" , function() {

                //});
                $("#ctxFechaInicio").on("change",function() {
				    //alert(this.value);
			    	fjFechaFinal( this.value );
				});

                $("#numDiasHabiles").on("change",function() {
				    //alert(this.value);
				    lsFecha = $("#ctxFechaInicio").val().toString();
			    	fjFechaFinal( lsFecha );
				});
            });
        </script>

<div class="panel-heading">
	<h3 class="panel-title"> 	
		<button id="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
			<span class="glyphicon glyphicon-plus"></span>
			Nuevo
		</button>
		Mis Vacaciones
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
					<h2 class="modal-title">Solicitud de Vacaciones</h2>
				</div>

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group ui-front">
						
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="ctxNombre">* Solicitante</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" readonly value="<?php
									echo $_SESSION["nacionalidad"] . "-" . $_SESSION["cedula"] . ", " . $_SESSION["nombre"] . " " . $_SESSION["apellido"];
								?>" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />

								<input name="numId" id="numId" type="hidden" readonly onkeypress="return false" value="<?php 
									if( isset( $_GET["getId"] ) ) 
										echo $_GET["getId"]; ?>" />		
								<input name="numIdTrabajador" id="numIdTrabajador" type="hidden" readonly onkeypress="return false" value="<?= $_SESSION["idtrabajador"]; ?>" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFechaIngreso"> F. Ingreso </label>
								<input id="ctxFechaIngreso" class=" form-control" name="ctxFechaIngreso" type="text" readonly placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="Antiguedad"> Antigüedad </label>
								<input id="Antiguedad" class=" form-control" name="Antiguedad" type="text" readonly placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
								<input type="hidden" class="form-control" id="numAntiguedad" name="numAntiguedad" >
							</div>



							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<br />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="panel panel-default">
								  <!-- Default panel contents -->
								  <div class="panel-heading">Periodos de Vacaciones</div>
									  <div class="panel-body">
										
		       							<div class="form-inline" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div id="divPeriodos" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
												<label for="sinPeriodos">* NO PUEDE SOLICITAR VACAIONES YA QUE NO TIENE PERIODOS DE ANTIGUEDAD VENCIDOS</label>
											</div>

											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<label for="numDiasHabiles">* N. Días Hábiles</label>
												<input id="numDiasHabiles" class="valida_num_entero form-control" maxlength="1" max="2" min="1" name="numDiasHabiles" type="number" readonly data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFechaInicio">* Fecha de Inicio Vacacional</label>
								<input id="ctxFechaInicio" class="valida_alfabetico form-control calendario" maxlength="45" name="ctxFechaInicio" type="text" size="20" required placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="top" title="Campo Obligatorio" onchange="fjFechaFinal(this.value);" oninput="fjFechaFinal(this.value);" />
							</div>


							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFechaFin">* Fecha de Reincorporación</label>
								<input id="ctxFechaFin" class="form-control" name="ctxFechaFin" type="text" readonly placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Generado automaticamente" />
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