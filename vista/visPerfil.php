<?php

// existe y esta la variable de sesión rol
if ( isset( $_SESSION["sesion"] ) AND $_SESSION["sesion"] == "sistema" ) {
	$vsVista = "Estado";
	$liVista = "10";
?>


<div class="panel-heading">
	<h3 class="panel-title"> 	
		<button id="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
			<span class="glyphicon glyphicon-plus"></span>
			Nuevo
		</button>
		Estados de venezuela
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


	<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" action="controlador/con<?=$vsVista;?>.php" role="form" class="form-horizontal" >

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group ui-front">

							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
								<label for="numId">* Código</label>
								<input name="numId" id="numId" type="number" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" value="<?php 
									if( isset( $_GET["getId"] ) ) 
										echo $_GET["getId"]; ?>" />								
							</div>
						
							<div class="col-xs-6 col-sm-8 col-md-9 col-lg-9">
								<label for="ctxNombre">* Nombre</label>
								<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
									if( isset( $_GET['getNombre'] ) )
										echo $_GET['getNombre'];
								?>" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
						</div>

								
					</div>
				</div>

		<input type="hidden" name="hidEstatus" id="hidEstatus" value="<?php if( isset( $_GET['getEstatus'] ) ) echo $_GET['getEstatus']; ?>" />
		<input type="hidden" name="operacion" id="operacion" />
	</form>


<?php



} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>