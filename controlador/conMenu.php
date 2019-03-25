<?php

include("modelo/clsAcceso.php");

$objMenu = new Acceso();
$objMenu->atrIdTipoUsuario = $_SESSION['idtipo_usuario'];
$rstModulo = $objMenu->ListarModulo();

if ($rstModulo) {
	while ($arrModulo = $objMenu->getConsultaArreglo($rstModulo)) {
		?>
		<li data-toggle="collapse" data-target="#<?= $arrModulo["modulo"] ?>" class="collapsed">
			<a >
				<i class="<?= $arrModulo["icono"] ?>"> </i>
				<?= strtoupper($arrModulo["modulo"]) ?>
				<span class="arrow"></span>
			</a>
		</li>
		<ul class="sub-menu collapse" id="<?= $arrModulo["modulo"] ?>">
			<?php
			$rstVista = $objMenu->ListarVista($arrModulo["idmodulo"]);
			if ($rstVista) {
				while ($arrVista = $objMenu->getConsultaArreglo($rstVista)) {
					?>
					<li onclick="window.location='?form=<?= $arrVista["url"] ?>'">
						<a> 
							<?= ucwords($arrVista["vista"]) ?> 
						</a>
					</li>
					<?php
				}
				$objMenu->faLiberarConsulta($rstVista);
			}
			?>
		</ul>
		<?php
	}
	$objMenu->faLiberarConsulta($rstModulo);
}

unset($objMenu);
?>
