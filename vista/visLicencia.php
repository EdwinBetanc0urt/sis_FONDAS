<?php

// existe y esta la variable de sesión rol
if(isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
	$vsVista = "Licencia";
	$liVista = "13";
?>
			
<section class="formulario">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Licencia</h3>
		</div>
		<div class="panel-body" align="center">			
			<iframe src="public/manuales/Licencia.pdf" style="width:700px; height:600px;" frameborder="0"> </iframe>
		</div>
	</div>
</section>

<?php
} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: ../controlador/conCerrar.php?getMotivoLogOut=sinlogin");
}

?>
