<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Acceso";
	$liVista = "10";

?>

<form id="form<?=$vsVista;?>" name="form<?=$vsVista;?>" method="POST" action="controlador/con<?=$vsVista;?>.php" role="form" class="form-horizontal" >

<div class="panel-heading">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3 class="panel-title">
			ACCESOS  DE  ROL  POR MODULO   
		</h3>
		<br>
	</div>

	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<select id='cmbTipo_Usuario' name='cmbTipo_Usuario' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Tipo de Usuario" size="1" style="width: 100%;" required>
			<option value="">Seleccione una Rol..</option>
		</select>
		<input id="hidTipo_Usuario" type="hidden" value="<?php
			if(isset($_GET['getTipo_Usuario']))
				echo $_GET['getTipo_Usuario']; ?>" />
		<br />
		<br />
	</div>	
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<select id='cmbModulo' name='cmbModulo' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Tipo de Usuario" size="1" style="width: 100%;" required>
			<option value="">Seleccione una Modulo..</option>
		</select>
		<input id="hidModulo" type="hidden" />
		<br />
		<br />
	</div>
</div>

<div class="panel-body">			
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#pestAcceso">Accesos X Modulo</a></li>
	</ul>
	<br />


	<div class="tab-content">	
		<div id="pestAcceso" class="tab-pane fade in active">
			<div class="row">
				<div class="form-group">

					<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<button type='button' id="btnAgregar" name="btnAgregar" class="btn btn-success" 
							onClick='fjEnviar(this.value);' value="Agregar">
							<i class="glyphicon glyphicon-eye-open"></i> 
							Asignar Accesos
						</button>
						<button type='button' id="btnQuitar" name="btnAgregar" class="btn btn-danger waves-light red darken-3" 
							onClick='fjQuitarVista(this.form.numId.value);'  data-toggle='tooltip' data-placement='top' title='Quitar el acceso total a esta pagina'>
							<i class='glyphicon glyphicon-eye-close'></i>
							Quitar Accesos
						</button>

					</div>
				</div>
			</div>

			<input type='hidden' name='operacion' id='operacion' />

			<div id="divListaAcceso" class="divListado">
				<br />
				<br/>
				<h3><b>Seleccione un Tipo de Usuario</b></h3>
			</div> <!-- Dentro se mostrara la tabla con el listado que genera el controladdor -->
		</div> <!-- cierre de pestaña listado de los que ya tiene acceso -->
	</div>
</div>

	</form>
<?php
} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../../controlador/seguridad/ctr_LogOut.php?getMotivoLogOut=sinlogin");
}
?>
