<?php 

$gsClase = "Auditoria";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch( $_POST['operacion'] ) {

	case "ListaView":
		ListaAuditoria();
		break;

}


function ListaAuditoria() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Auditoria; //instancia la clase

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if ( isset( $_POST["setItems"] ) )  {
		$vpItems = htmlentities( trim( addslashes( intval( $_POST['setItems'] ) ) ) ) ;
		if ( $vpItems < 1 ) {
		 	$vpItems = 10 ; //muestra los items predeterminados
		}
	}
	$objeto->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado
	
	if ( isset( $_POST['subPagina'] ) AND $_POST['subPagina'] > 1 ) {
		$vpPaginaActual = htmlentities( trim( intval( $_POST['subPagina'] ) ) ) ;
	}
	else
		$vpPaginaActual = 1 ;

	//si existe el elemento oculto hidOrden le indica al modelo por cual atributo listara
	if ( isset( $_POST["setOrden"] ) ) {
		$objeto->atrOrden =  htmlentities( trim ( strtolower( $_POST["setOrden"] ) ) );
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset( $_POST['setTipoOrden'] ) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ( $vpPaginaActual -1 ) * $objeto->atrItems;

	$rstRecordSet = $objeto->fmListarIndex( htmlentities( addslashes( trim( strtolower( $_POST['setBusqueda'] ) ) ) ) );

	header( "Content-Type: text/html; charset=utf-8" );
	if ( $rstRecordSet ) {
		//$arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrId; ?>" )' >
								Cod <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrNombre; ?>" )' >
								Usuario <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "tipo")' >
								Operación <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "tipo")' >
								Fecha <span class='glyphicon glyphicon-sort'></span>
							</th>
							
							
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ) ) {
						?>
						<tr >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
							<td> <?= $arrRegistro[ $objeto->atrId ]; ?> </td>
							<td> <?= ucwords( $arrRegistro[ "fecha" ] ); ?> </td>
							<td> 
								<?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["usuario"] . ", " . ucwords( $arrRegistro[ "nombre" ] . " " . $arrRegistro[ "apellido" ] ); ?> 
							</td>
							<td> <?= $arrRegistro[ "operacion" ]; ?> </td>
							
							
						</tr>
						<?php
					}
					?>
					</tbody>
				</table> 
			</div>
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<li>
							<a aria-label="Previous" rel="1" onclick='fjMostrarLista( "<?= $gsClase; ?>" , this.rel );' >
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php
						for ( $i = 1; $i <= $objeto->atrPaginaFinal; $i++ )  {
							if ( $i == $vpPaginaActual )
								$Activo = "active";
							else
								$Activo = "";
							?>
							<li class="<?= $Activo; ?> ">
								<a rel="<?= $i; ?>" onclick='console.log( this.rel ); fjMostrarLista( "<?= $gsClase; ?>" , this.rel );' >
									<?= $i; ?>
								</a>
							</li>
							<?php
						}
						?>

						<li>
							<a aria-label="Next" rel="<?= ( $objeto->atrPaginaFinal ); ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , this.rel );' >
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
		<?php
		$objeto->faLiberarConsulta( $rstRecordSet ); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		?>
		<br />
		<b>¡ No se ha encontrado ningún elemento, <a onclick="fjNuevoRegistro();" data-toggle='tooltip' data-placement='top' title="Click aqui para hacer un nuevo registro" >por favor haga un nuevo registro!</a></b> 
		<br /><br />
		<?php
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset( $objeto ); //destruye el objeto
} //cierre de la función



?>

