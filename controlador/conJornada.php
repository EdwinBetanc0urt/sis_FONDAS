<?php 

$gsClase = "Jornada";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {

	case "UltimoCodigo":
		UltimoCodigoJornada();
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
		ListaJornada();
		break;

	case "ListaDias":
		ListaDias();
		break;

	case "ListaCombo":
		Combo();
		break;

}

// Funcion Ultimo Codigo de Parroquia
// utilizada por la funcion AJAX para colocar el ID automaticamente
function UltimoCodigoJornada() {
	$objJornada = new Jornada(); //instancia la clase
	$arrCodigo = $objJornada->UltimoCodigo(); //obtiene el arreglo con el codigo
	echo $arrCodigo[0] + 1; //imprime el arreglo en la posicion cero y agrega 1
}



function registrar() {
	global $gsClase;
	$objJornada = new Jornada();
	$objJornada->setFormulario($_POST);

	//$objJornada->Incluir(); /*
	if ($objJornada->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta */
	/*
	var_dump($_POST["ctxHoraEntrada1"]);
	var_dump(date("H:i:s", strtotime($_POST["ctxHoraEntrada1"])));
	var_dump($objJornada->atrFormulario["ctxHoraEntrada1"]);
	var_dump(date("H:i:s", strtotime($objJornada->atrFormulario["ctxHoraEntrada1"])));
	*/
}



function cambiar() {
	global $gsClase;
	$objJornada = new Jornada();
	$objJornada->setFormulario($_POST);
	//var_dump($objJornada->Modificar());/*
	if ($objJornada->Modificar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
}



function borrar() {
	global $gsClase;
	$objJornada = new Jornada();
	$objJornada->setFormulario($_POST);
	if ($objJornada->Eliminar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=elimino"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noelimino"); //envía a la vista, con */
}



function Combo() {
    if (isset($_POST["hidCodigo"]))
        $pvCodigo =  htmlentities(trim (addslashes(strtolower($_POST["hidCodigo"]))));
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Jornada();
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

function ListaDias(){
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objJornada = new Jornada; //instancia la clase
	$rstRecordSet = $objJornada->fmListarDias();

	$arrDiasLaborados = array();
	if (isset($_POST["numId"]) AND $_POST["numId"]) {
		$rstDiaSemana = $objJornada->ListarDiasLaborados($_POST["numId"]);
		if ($rstDiaSemana) {
			$i = 0;	
			while ($arrDiaSemana = $objJornada->getConsultaAsociativo($rstDiaSemana)) {
				$arrDiasLaborados[$i] = $arrDiaSemana["iddia_semana"];
				$i++; 			
			}
			$objJornada->faLiberarConsulta($rstDiaSemana);
			unset($arrDiaSemana);
			//echo "<pre>";
			//var_dump($arrDiasLaborados);
			//echo "</pre>";
		}
	}

	while ($arrRegistro = $objJornada->getConsultaAsociativo($rstRecordSet)) {
		$vsSeleccionado = "";

		if (in_array($arrRegistro["iddia_semana"], $arrDiasLaborados))
			$vsSeleccionado .= " checked='checked' ";
		?>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="input-group">
			<span class="input-group-addon">
				<input type="checkbox" name="chkDia[]" value="<?=$arrRegistro["iddia_semana"];?>" aria-label="aria-label" <?= $vsSeleccionado; ?> class="chkDia">
			</span>
		     <input type="text" class="form-control" value="<?=$arrRegistro["iddia_semana"] . " - " . ucwords($arrRegistro["nombre"]);?>" readonly />
		</div>
	</div>
		<?php
	}
}



function ListaJornada() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Jornada; //instancia la clase

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if (isset($_POST["setItems"]))  {
		$vpItems = htmlentities(trim(addslashes(intval($_POST['setItems'])))) ;
		if ($vpItems < 1) {
		 	$vpItems = 10 ; //muestra los items predeterminados
		}
	}
	$objeto->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado
	
	if (isset($_POST['subPagina']) AND $_POST['subPagina'] > 1) {
		$vpPaginaActual = htmlentities(trim(intval($_POST['subPagina']))) ;
	}
	else
		$vpPaginaActual = 1 ;

	//si existe el elemento oculto hidOrden le indica al modelo por cual atributo listara
	if (isset($_POST["setOrden"])) {
		$objeto->atrOrden =  htmlentities(trim (strtolower($_POST["setOrden"])));
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;

	$rstRecordSet = $objeto->fmListarIndex(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	//header("Content-Type: text/html; charset=utf-8");
	header("Content-Type: text/html; charset=UTF-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrId; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrId; ?>")' >
								Cod
								<span class='glyphicon glyphicon-sort-by-attributes'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Descripción <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
						?>
						<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='Seleccion
							|<?= $arrRegistro[$objeto->atrEstatus]; ?>
							|<?= $arrRegistro[$objeto->atrId]; ?>
							|<?= ucwords(html_entity_decode($arrRegistro[$objeto->atrNombre])); ?>
							|<?= $arrRegistro["cant_turnos"]; ?>
							|<?= date("h:i A", strtotime($arrRegistro["hora_inicio"])); ?>
							|<?= date("h:i A", strtotime($arrRegistro["hora_fin"])); ?>
							|<?= date("h:i A", strtotime($arrRegistro["hora_inicio2"])); ?>
							|<?= date("h:i A", strtotime($arrRegistro["hora_fin2"])); ?>
							|<?= ucwords(html_entity_decode($arrRegistro["observacion"])); ?>' >

							<td> <?= $arrRegistro[$objeto->atrId]; ?> </td>
							<td> <?= ucwords(html_entity_decode($arrRegistro[$objeto->atrNombre])); ?> </td>
							<td> <?= $arrRegistro[$objeto->atrEstatus]; ?> </td>
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

