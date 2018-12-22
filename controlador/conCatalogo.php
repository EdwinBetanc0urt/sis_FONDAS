<?php 

$gsClase = "Catalogo";

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
		UltimoCodigoCatalogo();
		break;

	case "Registrar":
		registrar();
		break;

	case "Modificar":
		cambiar();
		break;
		
	case "Eliminar":
		borrar();
		break;

	case "ListaVista":
		lista();
		break;

	case "ListaCombo":
		Combo();
		break;
	case "Autocompletar":
		Autocompletar();
		break;
}

// Funcion Ultimo Codigo de Parroquia
// utilizada por la funcion AJAX para colocar el ID automaticamente
function UltimoCodigoCatalogo() {
	$objCatalogo = new Catalogo(); //instancia la clase
	$arrCodigo = $objCatalogo->UltimoCodigo(); //obtiene el arreglo con el codigo
	echo $arrCodigo[0]+1; //imprime el arreglo en la posicion cero y agrega 1
}


function registrar() {
	global $gsClase;
	$objCatalogo = new Catalogo();
	$objCatalogo->setFormulario( $_POST);
	if ( $objCatalogo->Incluir() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=registro" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=noregistro" ); //envía a la vista, con mensaje de la consulta
}



function cambiar() {
	global $gsClase;
	$objCatalogo = new Catalogo();
	$objCatalogo->setFormulario($_POST);
	if ( $objEstado->modificar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}.php?msjAlerta=cambio" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form=_{$gsClase}.php?msjAlerta=nocambio" ); //envía a la vista, con 
}



function borrar() {
	global $gsClase;
	$objCatalogo = new Catalogo();
	$objCatalogo->setFormulario($_POST);
	if ( $objCatalogo->eliminar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}.php?msjAlerta=elimino" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}.php?msjAlerta=noelimino" ); //envía a la vista, con 
}




function lista() {
	global $gsClase;
	$objeto = new Catalogo; //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$rstRecordSet = $objeto->Listar();

	if ( $rstRecordSet ) {
		//$arrRegistro = $objeto->fCambiarAsociativo( $rstRecordSet ); //convierte el RecordSet en un arreglo
		//var_dump( $rstRecordSet);
		while( $row = $objeto->getConsultaAsociativo( $rstRecordSet ) ) {
			$data[] = $row;
		}

		$results = [
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"data" => $data 
		];

		header("Content-Type: application/json; charset=utf-8");
		echo json_encode($results);

		//si el total de registros es mayor al numero de items es que muestra debajo de la lista
		$objeto->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		header("Content-Type: text/html; charset=utf-8");
		echo "<br> <b>¡ No se ha encontrado ningún elemento, <a href='&getOpcion=Registrar#VentanaModal'>por favor registre una {$gsClase}!</a></b> <br><br>";
	}
	//$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



function Combo() {
    if ( isset( $_POST["hidCodigo"] ) )
        $pvCodigo =  htmlentities( trim ( addslashes( strtolower( $_POST["hidCodigo"] ) ) ) );
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Catalogo();
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


function Autocompletar() {
	$objeto = new Catalogo();
	$vsBuqueda = htmlentities( trim ( strtoupper( $_REQUEST["setBuscar"] ) ) );
	$arrRetorno = array();
	$rstRecordSet = $objeto->Listar( $vsBuqueda );

	if ( $rstRecordSet ) {
		$arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet );
		do {
			//echo json_encode( $arrRegistro );
			array_push($arrRetorno , $arrRegistro );
		}
		while ( $arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ) ) ;
	}

	//modifica encabezado http a json, para ayudar a los navegadores a manejar tu respuesta con naturalidad	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	/* Codifica el resultado del array en JSON. */
	echo json_encode( $arrRetorno );
}












?>

