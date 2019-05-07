<?php

//include("modelo/clsAcceso.php");

$objBoton = new Acceso();
$objBoton->atrIdTipoUsuario = $_SESSION['idtipo_usuario'];
$rstBoton = $objBoton->ListarBoton($liVista);

if($rstBoton) {	
	while($arrBoton = $objBoton->getConsultaAsociativo($rstBoton)){
		?>
			<button type="button" id="<?= ucwords(strtolower($arrBoton['nombre'])) ?>"
				class="btn btn-primary" onclick="enviar(this.value);" 
				value="<?= ucwords(strtolower($arrBoton['nombre'])) ?>"
				cod_boton="<?= $arrBoton['idboton'] ?>" >
					<span class="<?= $arrBoton['icono'] ?>" > </span>
					<?= $arrBoton['nombre']; ?>
			</button>
		<?php
	}

	$objBoton->faLiberarConsulta($rstBoton);
}

unset($objBoton);

?>
