<?php 

$gsClase = "Modulo";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch( $_POST['operacion'] ) {

	case "UltimoCodigo":
		UltimoCodigoModulo();
		break;

	case "Registrar":
		registrar();
		break;

	case "Modificar":
		cambiar();
		break;
		
	case "Borrar":
		borrar();
		break;

	case "ListaView":
		ListaModulo();
		break;

	case "ListaCombo":
		Combo();
		break;

}

// Funcion Ultimo Codigo de Parroquia
// utilizada por la funcion AJAX para colocar el ID automaticamente
function UltimoCodigoModulo() {
	$objModulo = new Modulo(); //instancia la clase
	$arrCodigo = $objModulo->UltimoCodigo(); //obtiene el arreglo con el codigo
	echo $arrCodigo[0] + 1; //imprime el arreglo en la posicion cero y agrega 1
}



function registrar() {
	global $gsClase;

	$objeto = new Modulo();
	$objeto->setFormulario( $_POST);

	$arreglo = $objeto->consultar(); //realiza una consulta
	//si existe un registro
	if ( $arreglo ) {
		//envía a la vista, con mensaje de la consulta
		header( "Location: ../?form={$gsClase}" .
			"&msjAlerta=duplicado&getOpcion=" . $_POST["operacion"] .
			"&getId=" . $arreglo[ $objeto->atrId ] .
			"&getNombre=" . $arreglo[ $objeto->atrNombre ] .
			"&getIcono=" . $arreglo[ "icono" ] .
			"&getPosicion=" . $arreglo[ "posicion" ] .
			"&getEstatus=" . $arreglo[ $objeto->atrEstatus ] );  
	} //cierre del condicional si el RecordSet es verdadero
	else {
		if ( $objeto->Incluir() ) //si el fmInsertar es verdadero, realiza las sentencias
			header( "Location: ../?form={$gsClase}&msjAlerta=registro" ); //envía a la vista, con mensaje de la consulta
		else
			header( "Location: ../?form={$gsClase}&msjAlerta=noregistro" ); //envía a la vista, con mensaje de la consulta*/
	}
}



function cambiar() {
	global $gsClase;
	$objModulo = new Modulo();
	$objModulo->setFormulario($_POST);
	//var_dump( $objModulo->Modificar() );/*
	if ( $objModulo->Modificar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=cambio" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=nocambio" ); //envía a la vista, con */
}



function borrar() {
	global $gsClase;
	$objModulo = new Modulo();
	$objModulo->setFormulario($_POST);
	if ( $objModulo->Eliminar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=elimino" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=noelimino" ); //envía a la vista, con 
}



function Combo() {
    if ( isset( $_POST["hidCodigo"] ) )
        $pvCodigo =  htmlentities( trim ( addslashes( strtolower( $_POST["hidCodigo"] ) ) ) );
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Modulo();
    $rstRecordSet = $objeto->Listar();
    //si hay un arreglo devuelto en la consulta
    header("Content-Type: text/html; charset=utf-8");
    if ( $rstRecordSet ) {
        $arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet );
        do {
            if( intval( $pvCodigo ) == intval( $arrRegistro[$objeto->atrId] ) ) 
                $lsSeleccionado = "selected='selected'";
            else
                $lsSeleccionado = "";
            ?>
            <option value="<?=$arrRegistro[$objeto->atrId] ?>" <?= $lsSeleccionado; ?> > 
                <?=$arrRegistro[$objeto->atrId]; ?> - <?= ucwords( $arrRegistro["nombre"] ); ?> 
            </option>
            <?php
        } 
        while ( $arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ) );
    }
    //si no existe una consulta
    else {
        //imprime por lo MINIMO 2 option para que el js los separe en arreglo de lo contrario da error
        ?>
        <option value='' > Seleccione Alguno </option>
        <option value='0' > Sin Registros </option>
        <?php
    }
    unset( $objeto ); //destruye el objeto creado
}



function ListaModulo() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Modulo; //instancia la clase

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
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrId; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrId; ?>" )' >
								Cod
								<span class='glyphicon glyphicon-sort-by-attributes'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrNombre; ?>" )' >
								Descripción <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
		<?php 
		while ($arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ) ) {
			?>
						<tr onclick='fjSeleccionarRegistro( this );' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='Seleccion
							|<?= $arrRegistro[ $objeto->atrEstatus ]; ?>
							|<?= $arrRegistro[ $objeto->atrId ]; ?>
							|<?= ucwords( $arrRegistro[ $objeto->atrNombre ] ); ?>
							|<?= $arrRegistro[ "icono" ]; ?>
							|<?= $arrRegistro[ "posicion" ]; ?>' >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

							<td> <?= $arrRegistro[ $objeto->atrId ]; ?> </td>
							<td> <?= ucwords( $arrRegistro[ $objeto->atrNombre ] ); ?> </td>
							<td> <?= $arrRegistro[ $objeto->atrEstatus ]; ?> </td>
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

