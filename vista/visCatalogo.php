<?php

// existe y esta la variable de sesión rol
if ( isset( $_SESSION["sesion"] ) AND $_SESSION["sesion"] == "sistema" ) {
	$vsVista = "catalogo";
	$liVista = "20";
?>


<div class="panel-heading">
	<h3 class="panel-title"> 	
		<button id="btnNuevo" class="btn btn-primary" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
			<span class="glyphicon glyphicon-plus"></span>
			Nuevo
		</button>
		catálogo 
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
			<table id="tabLista"  cellpadding="0" cellspacing="0" border="0" class="table display cell-border row-border stripe hover" width="100%">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Descripcion</th>
						<th>Estatus</th>
					</tr>
				</thead>
			</table>
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
								?>" placeholder="Ingrese el nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
								<label for="cmbTipoAusencia">* Tipo de Ausencia</label>
								<select id='cmbTipoAusencia' name='TipoAusencia' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Seleccione tipo Ausencia" size="1" style="width: 100%;">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hibTipoTramite" type="hidden" value="<?php
									if( isset( $_GET['getTipoAusencia'] ) )
										echo $_GET['getTipoAusencia']; ?>" />
							</div>
							<div class="col-xs-6 col-sm-8 col-md-9 col-lg-6">
								<label for="ctxDuracion">* Duración</label>
								<input id="ctxDuracion" class="valida_alfabetico form-control" maxlength="45" name="ctxDuracion" type="text" size="20" required value="<?php
									if( isset( $_GET['getDuracion'] ) )
										echo $_GET['getDuracion'];
								?>" placeholder="Ingrese la Duración" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
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