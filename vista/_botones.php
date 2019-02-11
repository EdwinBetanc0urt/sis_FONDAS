<?php

//include("modelo/clsAcceso.php");

$objBoton = new Acceso();
$objBoton->atrIdTipoUsuario = $_SESSION['idtipo_usuario'];
$rstBoton = $objBoton->ListarBoton($liVista);

if($rstBoton) {
	$arrBoton = $objBoton->getConsultaAsociativo($rstBoton);
	
	do {
		?>
			<button id="<?= ucwords(strtolower($arrBoton['nombre'])); ?>" class="btn btn-primary" value="<?= ucwords(strtolower($arrBoton['nombre'])); ?>" onclick="enviar(this.value);" cod_boton="<?= $arrBoton['idboton']; ?>" type="button" >
				<span class="<?= $arrBoton['icono']; ?>" > </span>
				<?= $arrBoton['nombre']; ?>
			</button>
		<?php
	}
	while($arrBoton = $objBoton->getConsultaAsociativo($rstBoton));

	$objBoton->faLiberarConsulta($rstBoton);
}

unset($objBoton);


?>
