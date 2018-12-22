<?php 


$gsClase = "Solicitar_Vacaciones";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}
if(is_file("public/lib_Vacaciones.php")){
	require_once("public/lib_Vacaciones.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}public/lib_Vacaciones.php");
}

session_start();

$objCalcula = new vacacion( $_SESSION["fecha_ingreso"] );

switch( $_POST['operacion'] ) {

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
		ListaSolicitar_Vacaciones();
		break;

	case "ListaCombo":
		Combo();
		break;

	case "ListaPeriodo":
		listarPeriodos();
		break;

	case 'Antiguedad':
		Antiguedad();
		break;
	case 'CalculaDias':
		$resultado = $objCalcula->getDetalleDiasVacacionesPeriodo( $_SESSION["fecha_ingreso"], $_POST["radPeriodo"] );
		echo $resultado["dias_vacaciones"];
		break;
	case 'FechaFin':
		FechaFin();
		break;
	case 'FechaIngreso':
		FechaIngreso();
		break;

}

function FechaFin() {
	//print_r( $_POST );
	$objCalcula2 = new vacacion( $_SESSION["fecha_ingreso"] );
	$fecha_inicio = vacacion::getFechaFormato( $_POST["ctxFechaInicio"], "dma", "amd");
	$fechafin = $objCalcula2->getFechaFinal( $fecha_inicio , trim( $_POST["numDiasHabiles"]) );
	$resultado = vacacion::getFechaFormato( $fechafin, "amd", "dma");
	echo $resultado;
}



function FechaIngreso() {
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$lsFechaIngreso = $objSolicitar_Vacaciones->getFechaIngreso( $_SESSION["idtrabajador"]);
	$resultado = vacacion::getFechaFormato( $lsFechaIngreso, "amd", "dma");
	echo $resultado;
}

function Antiguedad() {
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$lsFechaIngreso = $objSolicitar_Vacaciones->getFechaIngreso( $_SESSION["idtrabajador"]);
	$resultado = vacacion::getAntiguedad($lsFechaIngreso);
	echo $resultado;
}



function registrar() {
	global $gsClase;
	//session_start();
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();

	$fecha_inicio = $objSolicitar_Vacaciones->faFechaFormato( $_POST["ctxFechaInicio"] , "dma" , "amd" );
	$arrPeriodos = explode("-" , $_POST["radPeriodo"]); //separa la palabra en cada espacio y convierte la búsqueda en arreglo

	$arrVacaciones = getDiasDeVacaciones( $_SESSION["fecha_ingreso"] , $arrPeriodos);

	$diasp2 = getDiasDeVacaciones( $_SESSION["fecha_ingreso"] , $arrPeriodos);

	$fecha_culmina = getFechaFinal( $fecha_inicio , $arrVacaciones["dias_vacaciones"] );

	$envio= array(
		"numIdTrabajador" => $_SESSION["idtrabajador"],
		"datFechaIngreso" => $_SESSION["fecha_ingreso"],
		"datFechaInicio" => $fecha_inicio ,
		"datFechaFin" => $fecha_culmina,
		"cantidad_periodos" => count( $arrPeriodos ) ,
		"vacaciones" => $arrVacaciones
	);
	$objSolicitar_Vacaciones->setFormulario( $envio );
	var_dump( $envio );

	if ( $objSolicitar_Vacaciones->Incluir() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=registro" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=registro" ); //envía a la vista, con */
}



function getDiasDeVacaciones( $psFechaIngreso, $paPeriodos = array() ) {

	$lsDia = substr( $psFechaIngreso , 8 , 2 );
	$lsMes = substr( $psFechaIngreso , 5 , 2 );
	$lsAno = substr( $psFechaIngreso , 0 , 4 );

	$objFecha_Ingreso = new DateTime( $psFechaIngreso );
	$liCont = 1;
	$lsVacaciones = 0;
	if ( count( $paPeriodos ) <= 0 ) {
		$liCont = -1;
	}
	$arrRetorno = array();
	foreach ($paPeriodos as $key => $value) {

		$objFecha_Periodo = new DateTime( $value . "-" . $lsMes . "-" . $lsDia );
		$annos = $objFecha_Periodo->diff($objFecha_Ingreso);
		$antiguedad =  $annos->y + 1 ;
		$diasvacaciones = getDiasPorAntiguedad( $antiguedad );
		$lsVacaciones = $lsVacaciones + $diasvacaciones ;

		$arrRetorno["periodo"][$liCont]["anno"] = $value;
		$arrRetorno["periodo"][$liCont]["dias"] = $diasvacaciones;

		$liCont ++;
	}

	$arrRetorno["dias_vacaciones"] = $lsVacaciones;
	return $arrRetorno;
}


function listarPeriodos() {
	//session_start();

	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	
	$arrPeriodos = getPeriodosAntiguedad( $objSolicitar_Vacaciones->getFechaIngreso( $_SESSION["idtrabajador"]) );
	$arrConsulta = $objSolicitar_Vacaciones->listarPeriodos( $_SESSION["idtrabajador"] );
	
	$arrComparado = array_diff( $arrPeriodos , $arrConsulta );

	if ( $arrComparado) {
		$arrComparado = array_slice( array_diff( $arrPeriodos , $arrConsulta ), 0, 2);
		$liCont = 0;

		foreach ( $arrComparado AS $key => $value ): 
			if ( $liCont > 0 ) 
				$value = $arrComparado[ ($liCont-1) ] . "-" . $value;
			?>

			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<label for="periodo<?= $liCont; ?>">* Periodo <?= $liCont + 1; ?></label>
				<div class="input-group" id="periodo<?= $liCont; ?>">
			
					<span class="input-group-addon">
						<input type="radio" aria-label="..." name="radPeriodo" value="<?= $value; ?>" onclick="fjCalculaDias(this.value);
			    	fjFechaFinal( $('#ctxFechaInicio').val().toString() );" class="periodos" />
					</span>
					<input type="text" class="form-control" aria-label="..." value="<?= $value; ?>" readonly />
				</div><!-- /input-group -->
			</div>

			<?php 
			$liCont++;
		endforeach;
	}
	else { 
		?>
		<label for="sinPeriodos">* NO PUEDE SOLICITAR VACAIONES YA QUE NO TIENE PERIODOS DE ANTIGUEDAD VENCIDOS</label>
		<?php
	}

	
}




function getPeriodosAntiguedad( $psFechaIngreso) {

	$lsAno = substr( $psFechaIngreso , 0 , 4 );
	$objFecha_Ingreso = new DateTime( $psFechaIngreso );

	$arrRetorno = array();

	$objFecha_Periodo = new DateTime( date("Y-m-d") );

	$annos = $objFecha_Periodo->diff($objFecha_Ingreso);
	$antiguedad =  $annos->y ;

	//echo "$antiguedad";

	for ($liControl = 0; $liControl  <= $antiguedad ; $liControl ++) { 
		$arrRetorno[ $liControl ] = $lsAno + $liControl;
	}

	return $arrRetorno;
}



/**
 * Metodo getDiasHabiles
 *
 * Permite devolver un arreglo con los dias habiles
 * entre el rango de fechas dado excluyendo los
 * dias feriados dados (Si existen)
 *
 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
 * @param string $piDiasHabiles Cantidad de dias habiles, este sera util para crear el for 
 * @param string $psFechafin Fecha de fin en formato Y-m-d
 * @param array $paDiasferiados Arreglo de dias feriados en formato Y-m-d
 * @param array $paDiasNoHabiles Arreglo de dias que no son tomados como habiles, Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
 * @return array $diashabiles Arreglo definitivo de dias habiles
 */
function getFechaFinal( $psFechainicio, $piDiasHabiles, $paDiasferiados = array(), $paDiasNoHabiles = array(6,7) ) {
	//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos  
	$fechaInicial = date("Y-m-d" , strtotime($psFechainicio) ); //obtenemos la fecha de hoy, solo para usar como referencia al usuario  
	$FechaFinal = 0;
	//$Segundos = 24*60*60;
	$Segundos = 0;

	//Creamos un for desde 0 hasta 3  
	for ($i = 0; $i < $piDiasHabiles; $i++ ) {
		//Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for  
		$Segundos = $Segundos + 86400;  

		//Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias, segun la vuelta en la que estemos  
		$diatranscurrido = date("N",time() + $Segundos);  

		//Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...  
		if (in_array( $diatranscurrido, $paDiasNoHabiles )) { // DOC: http://www.php.net/manual/es/function.date.php
			$i--; 
		}
		elseif ( in_array(date('Y-m-d', time() + $Segundos ), $paDiasferiados ) ) { // DOC: http://www.php.net/manual/es/function.date.php
			$i--; 
		}
		else {
			//Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha  
			$FechaFinal = date("Y-m-d", time() + $Segundos);  
		}
	}  
	return $FechaFinal;
}



/**
 * Metodo getDiasHabiles
 *
 * Permite devolver un arreglo con los dias habiles
 * entre el rango de fechas dado excluyendo los
 * dias feriados dados (Si existen)
 *
 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
 * @param string $psFechafin Fecha de fin en formato Y-m-d
 * @param array $paDiasferiados Arreglo de dias feriados en formato Y-m-d
 * @param array $paDiasNoHabiles Arreglo de dias que no son tomados como habiles, Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
 * @return array $diashabiles Arreglo definitivo de dias habiles
 */
function getDiasHabiles($psFechainicio, $psFechafin, $paDiasferiados = array(), $paDiasNoHabiles = array(6,7)) {
	// Convirtiendo en timestamp las fechas
	$psFechainicio = strtotime($psFechainicio);
	$psFechafin = strtotime($psFechafin);
   
	// Incremento en 1 dia
	$diainc = 24*60*60;
   
	// Arreglo de dias habiles, inicianlizacion
	$diashabiles = array();
   
	// Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
	for ($midia = $psFechainicio; $midia <= $psFechafin; $midia += $diainc) {
		// Si el dia indicado, no es sabado o domingo es habil
		if (! in_array(date('N', $midia), $paDiasNoHabiles)) { // DOC: http://www.php.net/manual/es/function.date.php
			// Si no es un dia feriado entonces es habil
			if (! in_array(date('Y-m-d', $midia), $paDiasferiados)) {
				array_push($diashabiles, date('Y-m-d', $midia));
			}
		}
	}

	return $diashabiles;
}



function getDiasPorAntiguedad( $antiguedad = 0 ) {
	$diasVacaciones = "nada";
	switch ( $antiguedad ) {
		
		case ($antiguedad == 1):
			$diasVacaciones = 15;
			break;
		
		case ($antiguedad == 2):
			$diasVacaciones = 16;
			break;
		
		case ($antiguedad == 3):
			$diasVacaciones = 17;
			break;
		
		case ($antiguedad == 4):
			$diasVacaciones = 18;
			break;

	 	//primer quinquenio de 5 años a 9 años
		case (($antiguedad >= 5) &&($antiguedad <= 9)):
			$diasVacaciones = 19;
			break;

		//segundo quinquenio de 10 años a 14 años
		case (($antiguedad >= 5) &&($antiguedad <= 9)):
			$diasVacaciones = 20;
			break;

		//tercer quinquenio 15 años
		case (($antiguedad >= 10) &&($antiguedad <= 15)):
			$diasVacaciones = 21;
			break;

		//mas de 16 años o mas
		case ($antiguedad >= 16):
			$diasVacaciones = 25;
			break;
	 	
		case ($antiguedad <= 0):
	 	//default:
	 		$diasVacaciones = 0;
	 		break;
	} //cierre del switch

	return $diasVacaciones;
}



function cambiar() {
	global $gsClase;
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$objSolicitar_Vacaciones->setFormulario($_POST);
	//var_dump( $objSolicitar_Vacaciones->Modificar() );/*
	if ( $objSolicitar_Vacaciones->Modificar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=cambio" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=nocambio" ); //envía a la vista, con */
}



function borrar() {
	global $gsClase;
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$objSolicitar_Vacaciones->setFormulario($_POST);
	if ( $objSolicitar_Vacaciones->Eliminar() ) //si el fmInsertar es verdadero, realiza las sentencias
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
    $objeto = new Solicitar_Vacaciones();
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



function ListaSolicitar_Vacaciones() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Solicitar_Vacaciones; //instancia la clase

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
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrNombre; ?>" )' >
								Periodo <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrEstatus; ?>")' >
								Cant. Dias  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrEstatus; ?>")' >
								Fecha Incio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrEstatus; ?>")' >
								Fecha Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista( "<?= $gsClase; ?>" , "<?= $vpPaginaActual; ?>" , "<?= $objeto->atrEstatus; ?>")' >
								Condicion  <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
		<?php 
		while ($arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ) ) {
			?>
						<tr onclick='fjSeleccionarRegistro( this );' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='Seleccion
							|<?= $arrRegistro[ "condicion" ]; ?>
							|<?= $arrRegistro[ $objeto->atrId ]; ?>
							|<?= $arrRegistro[ "periodo_usado" ]; ?>
							|<?= $objeto->faFechaFormato( $arrRegistro[ "fecha_inicio" ], "amd" , "dma" ); ?>
							|<?= $objeto->faFechaFormato( $arrRegistro[ "fecha_fin" ], "amd" , "dma" ); ?>
							|<?= $arrRegistro[ "cant_dias_periodo" ]; ?>' >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
							<td> <?= $arrRegistro[ "periodo_usado" ] ; ?> </td>
							<td> <?= $arrRegistro[ "cant_dias_periodo" ]; ?> </td>
							<td> <?= $objeto->faFechaFormato( $arrRegistro[ "fecha_inicio" ], "amd" , "dma" ); ?> </td>
							<td> <?= $objeto->faFechaFormato( $arrRegistro[ "fecha_fin" ], "amd" , "dma" ); ?> </td>
							<td> <?= $arrRegistro[ "condicion" ]; ?> </td>
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

