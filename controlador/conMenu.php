<?php

include("modelo/clsAcceso.php");

$objMenu = new Acceso();
$objMenu->atrIdTipoUsuario = $_SESSION['idtipo_usuario'];
$rstModulo = $objMenu->ListarModulo( );

if ( $rstModulo ) {

	while ( $arrModulo = $objMenu->getConsultaArreglo( $rstModulo ) ) {
		?>
		<li data-toggle="collapse" data-target="#<?= $arrModulo["modulo"]; ?>" class="collapsed">
			<a >
				<i class="<?= $arrModulo["icono"]; ?>"> </i>
				<?= strtoupper( $arrModulo["modulo"] ); ?>
				<span class="arrow"></span>
			</a>
		</li>
		<ul class="sub-menu collapse" id="<?= $arrModulo["modulo"]; ?>">
			<?php
			$rstVista = $objMenu->ListarVista( $arrModulo["idmodulo"] );
			if ( $rstVista ) {
				$arrVista = $objMenu->getConsultaArreglo( $rstVista );
				do {
					?>
					<li >
						<a href='?form=<?= $arrVista["url"]; ?>' > 
							<?= ucwords( $arrVista["vista"] ); ?> 
						</a>
					</li>
					<?php
				}
				while ( $arrVista = $objMenu->getConsultaArreglo( $rstVista ) );
				$objMenu->faLiberarConsulta( $rstVista );
			}
			?>
		</ul>
		<?php
	}

	$objMenu->faLiberarConsulta( $rstModulo );
}

unset( $objMenu );
?>

