<?php

$gsClase = "Asistencia";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {
	case "marcar":
		marcar();
		break;
	case "consulta":
		consultaAsistencia();
		break;
    case "ListaView":
        ListaAsistencia();
        break;
}

function marcar()
{
	global $gsClase;
    $objBoton = new Asistencia();
	$objBoton->setFormulario($_POST);
	if ($objBoton->marcar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con
}

function consultaAsistencia()
{
    $objBoton = new Asistencia();
    $objBoton->setFormulario($_POST);
    $arrCosulta = $objBoton->consultar();
	if ($arrCosulta) {
        $arrRetorno = array(
            "mensaje" => "registromarcaje",
            "ver" => "no",
            "datos" => $arrCosulta
        );
    }
    else {
        $arrRetorno = array(
            "mensaje" => "noregistro",
            "ver" => "no",
            "datos" => array()
        );
    }
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
    header('Content-type: application/json');
    echo json_encode($arrRetorno);
}


function ListaAsistencia()
{
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Asistencia; //instancia la clase

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
		$objeto->atrOrden = htmlentities(trim(strtolower($_POST["setOrden"])));
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;
	$rstRecordSet = $objeto->fmListarIndex(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));
	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsive'>
			<br>
			<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
				<thead>
					<tr class='info'>
						<th>
							Fecha
							<span class='glyphicon glyphicon-sort-by-attributes'></span>
						</th>
						<th>
							Entrada 1 <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th>
							Salida 1  <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th>
							Entrada 2 <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th>
							Salida 2  <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th>
							Observacion  <span class='glyphicon glyphicon-sort'></span>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
				while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
					?>
                    <tr data-toggle='tooltip' data-placement='top'
                        title='Doble clic para detallar los datos y realizar alguna operación'>
							<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
						<td>
                            <?=  $objeto->faFechaFormato($arrRegistro["fecha_marcaje"], "amd", "dma") ?> </td>
						<td> <?= $arrRegistro["entrada1"]; ?> </td>
						<td> <?= $arrRegistro["salida1"]; ?> </td>
						<td> <?= $arrRegistro["entrada2"]; ?> </td>
						<td> <?= $arrRegistro["salida2"]; ?> </td>
						<td> <?= $arrRegistro["observacion"]; ?> </td>
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
                        <a rel="<?= $i; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", this.rel);' >
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
