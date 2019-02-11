<?php

include("modelo/clsAcceso.php");

$objMenu = new Acceso();
$objMenu->atrIdTipoUsuario = $_SESSION['idtipo_usuario'];
$rstModulo = $objMenu->ListarModulo();

if ($rstModulo) {
	$arrModulo = $objMenu->getConsultaArreglo($rstModulo);

	$liCont = 1;
	do {
		?>

		<li class="item-submenu" menu="<?= $liCont++; ?>">
			<a href="#">
				<span class="<?= $arrModulo["icono"]; ?> icon-menu"></span>
				<?= $arrModulo["modulo"]; ?>
			</a>
			<ul class="submenu" id="<?= $arrModulo["modulo"]; ?>">
				<li class="title-menu">
					<span class="<?= $arrModulo["icono"]; ?> icon-menu"></span>
					<?= $arrModulo["modulo"]; ?>
				</li>
				<li class="go-back">Atras</li>
				<?php
				$rstVista = $objMenu->ListarVista($arrModulo["idmodulo"]);
				if ($rstVista) {
					$arrVista = $objMenu->getConsultaArreglo($rstVista);
					do {
						?>
						<li >
							<a href='?form=<?= $arrVista["url"]; ?>' > 
								<?= ucwords($arrVista["vista"]); ?> 
							</a>
						</li>
						<?php
					}
					while ($arrVista = $objMenu->getConsultaArreglo($rstVista));
					$objMenu->faLiberarConsulta($rstVista);
				}
				?>
			</ul>
		</li>
		<?php
	}
	while ($arrModulo = $objMenu->getConsultaArreglo($rstModulo));

	$objMenu->faLiberarConsulta($rstModulo);
}

unset($objMenu);
?>

