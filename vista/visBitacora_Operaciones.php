<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Bitacora_Operaciones";
	$liVista = "43";
?>


<div class="panel-heading">
	<h3 class="panel-title">
		Botones para las vistas en el menú
	</h3>
</div>

<div class="panel-body">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestListado">Listado</a></li>
	</ul>
	<br>

	<?php
		//include_once("mod_". $_GET["accion"] . ".php");
	?>

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
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />	
								<label for="ctxNombre">* Usuario</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxOperacion">* Operacion</label>
								<input id="ctxOperacion" class="valida_alfabetico form-control" maxlength="45" name="ctxOperacion" type="text" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxFecha">* Fecha</label>
								<input id="ctxFecha" class=" form-control" maxlength="45" name="ctxFecha" type="text" placeholder="Ingrese la el icono que tendra (fuente awesome)" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="txaData">* Data</label>
                                <textarea id="txaData" class="form-control" rows="7"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
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
