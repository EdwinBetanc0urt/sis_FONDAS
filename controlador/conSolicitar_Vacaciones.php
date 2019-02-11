<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

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


switch($_POST['operacion']) {

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
		echo vacacion::getAntiguedad($_SESSION["fecha_ingreso"]);
		break;
	case 'CalculaDias':
		CalcularDias();
		break;
	case 'FechaFin':
		FechaFin();
		break;
	case 'FechaIngreso':
		FechaIngreso();
		break;

}

function FechaFin() {
	$fechafin = vacacion::getFechaFinal($_POST["ctxFechaInicio"], trim($_POST["numDiasHabiles"]));
	$resultado = vacacion::getFechaFormato($fechafin, "amd", "dma");
	echo $resultado;
}


function CalcularDias() {

	//$resultado = $objCalcula->getDetalleDiasVacacionesPeriodo(
	$resultado = vacacion::getDetalleDiasVacacionesPeriodo(
		$_SESSION["fecha_ingreso"],
		$_POST["radPeriodo"]
	);

	//var_dump($resultado);
	echo $resultado["dias_vacaciones"];
}


function FechaIngreso() {
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$lsFechaIngreso = $objSolicitar_Vacaciones->getFechaIngreso($_SESSION["idtrabajador"]);
	$resultado = vacacion::getFechaFormato($lsFechaIngreso, "amd", "dma");
	echo $resultado;
}


function registrar() {
	global $gsClase;
	//session_start();
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();

	$arrVacaciones = vacacion::getDetalleDiasVacacionesPeriodo($_SESSION["fecha_ingreso"], $_POST["radPeriodo"]);

	$fecha_culmina = getFechaFinal($_POST["ctxFechaInicio"], $arrVacaciones["dias_vacaciones"]);

	$envio= array(
		"numIdTrabajador" => $_SESSION["idtrabajador"],
		"datFechaIngreso" => $_SESSION["fecha_ingreso"],
		"datFechaInicio" => $_POST["ctxFechaInicio"],
		"datFechaFin" => $fecha_culmina,
		"cantidad_periodos" => count(explode("-", $_POST["radPeriodo"])),
		"vacaciones" => $arrVacaciones
	);
	$objSolicitar_Vacaciones->setFormulario($envio);
	var_dump($envio);

	if ($objSolicitar_Vacaciones->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con */
}


function listarPeriodos()
{
	$objInstancia = new Solicitar_Vacaciones();
	$arrPeriodos = vacacion::getPeriodosAntiguedad(
		$_SESSION["fecha_ingreso"]
	);
	$arrConsulta = array();
	$arrConsulta = $objInstancia->listarPeriodos($_SESSION["idtrabajador"]);
	$arrComparado = array_diff($arrPeriodos, $arrConsulta);

	if ($arrComparado) {
		$arrComparado = array_slice(array_diff($arrPeriodos, $arrConsulta), 0, 2);
		$liCont = 0;

		foreach ($arrComparado AS $key => $value):
			if ($liCont > 0)
				$value = $arrComparado[ ($liCont-1) ] . "-" . $value;
			?>
				<option value="<?= $value ?>">
					Periodo <?= ($liCont + 1) . " - " . $value; ?>
				</option>
			<?php
			$liCont++;
		endforeach;
	}
	else {
		?>
		<option value="0">Sin periodos de antigüedad vencidos</option>
		<?php
	}
}


function cambiar() {
	global $gsClase;
	$objSolicitar_Vacaciones = new Solicitar_Vacaciones();
	$objSolicitar_Vacaciones->setFormulario($_POST);
	//var_dump($objSolicitar_Vacaciones->Modificar());/*
	if ($objSolicitar_Vacaciones->Modificar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
}


function Combo() {
    if (isset($_POST["hidCodigo"]))
        $pvCodigo =  htmlentities(trim (addslashes(strtolower($_POST["hidCodigo"]))));
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Solicitar_Vacaciones();
    $rstRecordSet = $objeto->Listar();
    //si hay un arreglo devuelto en la consulta
    header("Content-Type: text/html; charset=utf-8");
    if ($rstRecordSet) {
        $arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet);
        do {
            if(intval($pvCodigo) == intval($arrRegistro[$objeto->atrId])) 
                $lsSeleccionado = "selected='selected'";
            else
                $lsSeleccionado = "";
            ?>
            <option value="<?=$arrRegistro[$objeto->atrId] ?>" <?= $lsSeleccionado; ?> > 
                <?=$arrRegistro[$objeto->atrId]; ?> - <?= ucwords($arrRegistro["nombre"]); ?> 
            </option>
            <?php
        } 
        while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet));
    }
    //si no existe una consulta
    else {
        //imprime por lo MINIMO 2 option para que el js los separe en arreglo de lo contrario da error
        ?>
        <option value='' > Seleccione Alguno </option>
        <option value='0' > Sin Registros </option>
        <?php
    }
    unset($objeto); //destruye el objeto creado
}


function ListaSolicitar_Vacaciones() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Solicitar_Vacaciones; //instancia la clase

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if (isset($_POST["setItems"]))  {
		$vpItems = htmlentities(trim(addslashes(intval($_POST['setItems']))));
		if ($vpItems < 1) {
		 	$vpItems = 10; //muestra los items predeterminados
		}
	}
	$objeto->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado
	
	if (isset($_POST['subPagina']) AND $_POST['subPagina'] > 1) {
		$vpPaginaActual = htmlentities(trim(intval($_POST['subPagina'])));
	}
	else
		$vpPaginaActual = 1;

	//si existe el elemento oculto hidOrden le indica al modelo por cual atributo listara
	if (isset($_POST["setOrden"])) {
		$objeto->atrOrden =  htmlentities(trim (strtolower($_POST["setOrden"])));
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;

	$rstRecordSet = $objeto->fmListarIndex(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Periodo <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Cant. Dias  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fecha Incio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fecha Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Condicion  <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
		<?php 
		while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
			?>
						<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='Seleccion
							|<?= $arrRegistro["condicion"]; ?>
							|<?= $arrRegistro[$objeto->atrId]; ?>
							|<?= $arrRegistro["periodo_usado"]; ?>
							|<?= $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma"); ?>
							|<?= $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma"); ?>
							|<?= $arrRegistro["cant_dias_periodo"]; ?>' >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
							<td> <?= $arrRegistro["periodo_usado"]; ?> </td>
							<td> <?= $arrRegistro["cant_dias_periodo"]; ?> </td>
							<td> <?= $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma"); ?> </td>
							<td> <?= $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma"); ?> </td>
							<td> <?= $arrRegistro["condicion"]; ?> </td>
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
						<a aria-label="Previous" rel="1" onclick='fjMostrarLista("<?= $gsClase; ?>", this.rel);' >
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<?php
					for ($i = 1; $i <= $objeto->atrPaginaFinal; $i++)  {
						if ($i == $vpPaginaActual)
							$Activo = "active";
						else
							$Activo = "";
						?>
						<li class="<?= $Activo; ?> ">
							<a rel="<?= $i; ?>" onclick='console.log(this.rel); fjMostrarLista("<?= $gsClase; ?>", this.rel);' >
								<?= $i; ?>
							</a>
						</li>
						<?php
					}
					?>

					<li>
						<a aria-label="Next" rel="<?= ($objeto->atrPaginaFinal); ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", this.rel);' >
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>
		<?php
		$objeto->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		?>
		<br />
		<b>¡ No se ha encontrado ningún elemento, <a onclick="fjNuevoRegistro();" data-toggle='tooltip' data-placement='top' title="Click aqui para hacer un nuevo registro" >por favor haga un nuevo registro!</a></b> 
		<br /><br />
		<?php
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función


?>
