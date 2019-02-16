<?php 

$gsClase = "Trabajador";

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
		UltimoCodigoTrabajador();
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

	case "ListaView":
		ListaTrabajador();
		break;

	case "ListaCombo":
		Combo();
		break;
	case "ListaComboTrabajadorDepartamento":
		ComboTrabajadorDepartamento();
		break;

	case "ListaCatalogo":
		fcListaCatalogo();
		break;
}

// Funcion Ultimo Codigo de Parroquia
// utilizada por la funcion AJAX para colocar el ID automaticamente
function UltimoCodigoTrabajador() {
	$objEstado = new Trabajador(); //instancia la clase
	$arrCodigo = $objEstado->UltimoCodigo(); //obtiene el arreglo con el codigo
	echo $arrCodigo[0]+1; //imprime el arreglo en la posicion cero y agrega 1
}


function registrar() {
	echo "<pre>";
	global $gsClase;
	$objEstado = new Trabajador();
	$objEstado->setFormulario($_POST);
	//var_dump($_POST);
	//var_dump($objEstado->Incluir());
	if ($objEstado->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta */
}



function cambiar() {
	global $gsClase;
	$objEstado = new Trabajador();
	$objEstado->setFormulario($_POST);
	if ($objEstado->modificar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con 
}



function borrar() {
	global $gsClase;
	$objEstado = new Trabajador();
	$objEstado->setFormulario($_POST);
	if ($objEstado->eliminar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=elimino"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noelimino"); //envía a la vista, con 
}



function Combo() {
    if (isset($_POST["hidCodigo"]))
        $pvCodigo =  htmlentities(trim (addslashes(strtolower($_POST["hidCodigo"]))));
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Trabajador();
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
            <option value="<?=$arrRegistro["idtrabajador"] ?>" <?= $lsSeleccionado; ?> > 
                <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . " " . ucwords($arrRegistro["nombre"] . " " . $arrRegistro["apellido"]); ?> 
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



function ComboTrabajadorDepartamento() {
    if (isset($_POST["hidCodigo"]))
        $pvCodigo =  htmlentities(trim (addslashes(strtolower($_POST["hidCodigo"]))));
    else
        $pvCodigo = "";
    $lsSeleccionado = "";
    $objeto = new Trabajador();
    $rstRecordSet = $objeto->ListarTrabajadorDepartamento($_POST["hidCodPadre"]);
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
            <option value="<?=$arrRegistro["idtrabajador"] ?>" <?= $lsSeleccionado; ?> > 
                <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . " " . ucwords($arrRegistro["nombre"] . " " . $arrRegistro["apellido"]); ?> 
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



function ListaTrabajador() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Trabajador; //instancia la clase

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
								Cedula <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Nombre <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "tipo")' >
								Apellido  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Cargo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Departamento  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet) ;
					do {
						?>
						<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='Seleccion
							|<?= $arrRegistro[$objeto->atrEstatus]; ?>
							|<?= $arrRegistro[$objeto->atrId]; ?>
							|<?= $arrRegistro["nacionalidad"]; ?>
							|<?= $arrRegistro["cedula"]; ?>
							|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
							|<?= ucwords($arrRegistro["apellido"]); ?>
							|<?= $arrRegistro["tel_mov"]; ?>
							|<?= $arrRegistro["correo"]; ?>
							|<?= $arrRegistro["fecha_ingreso"]; ?>
							|<?= $arrRegistro["idtipo_usuario"]; ?>
							|<?= ucwords($arrRegistro["tipo_usuario"]); ?>
							|<?= $arrRegistro["iddepartamento"]; ?>
							|<?= ucwords($arrRegistro["departamento"]); ?>
							|<?= $arrRegistro["idcargo"]; ?>
							|<?= ucwords($arrRegistro["cargo"]); ?>
							|<?= $arrRegistro["idjornada"]; ?>
							|<?= ucwords($arrRegistro["jornada"]); ?>' >
							<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

							<td> <?= $arrRegistro["nacionalidad"] . " - " . $arrRegistro["cedula"]; ?> </td>
							<td> <?= ucwords($arrRegistro[$objeto->atrNombre]); ?> </td>
							<td> <?= ucwords($arrRegistro["apellido"]); ?> </td>
							<td> <?= ucwords($arrRegistro["cargo"]); ?> </td>
							<td> <?= ucwords($arrRegistro["departamento"]); ?> </td>
							<td> <?= $arrRegistro[$objeto->atrEstatus]; ?> </td>
						</tr>
						<?php
					}while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet));
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



function fcListaCatalogo() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Trabajador; //instancia la clase

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if (isset($_POST["setItems"]))  {
		$vpItems = htmlentities(trim ($_POST['setItems'])) ;
		if ($vpItems < 1) {
		 	$vpItems = 10 ; //muestra los items predeterminados
		}
	}
	$objeto->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	
	//por defecto muesta la primera pagina del resultado
	$vpPaginaActual = 1 ;
	if (isset($_POST['subPagina']) AND $_POST['subPagina'] > 1) {
		$vpPaginaActual = htmlentities(trim ($_POST['subPagina'])) ;
	}

	//si existe el elemento oculto hidOrden le indica al modelo por cual atributo listara
	if (isset($_POST["setOrden"])) {
		$objeto->atrOrden =  htmlentities(trim (strtolower($_POST["setOrden"])));
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;

	$objeto->atrExcluidos = $_POST['setOpcional'][1];

	$rstRecordSet = $objeto ->ListarCatalogo(htmlentities(trim(strtolower($_POST['setBusqueda']))), $_POST['setOpcional'][0], $_POST['setOpcional'][1]);

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//var_dump($_POST["setOpcional"]);
		$arrExluido = "0, " . $_POST['setOpcional'][1]; //si no esta una separacion o esta un campo vacio da error con la paginacion
		$arrDatos = "[" . $_POST['setOpcional'][0] . ", " . $arrExluido . "]";
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table text '>
					<thead>
						<tr class='info'>
							<th onclick='fjMostrarLista("<?= $gsClase; ?>", "", "id_det_articulo", "", "ListaCatalogo", <?= $arrDatos; ?>)' >
								Cedula   <span class='caret'></span>
							</th>

							<th onclick='fjMostrarLista("<?= $gsClase; ?>", "", "articulo", "", "ListaCatalogo", <?= $arrDatos; ?>)' >
								Nombre y Apellido <span class='caret'></span>
							</th>

							<th onclick='fjMostrarLista("<?= $gsClase; ?>", "", "cantidad_articulo", "", "ListaCatalogo", <?= $arrDatos; ?>)' >
								Estatus <span class='caret'></span>
							</th>

						</tr>
					</thead>
					<tbody>
					<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
						?>
							<tr onclick='fjSeleccionarTrabajador(this);' data-toggle='tooltip' data-placement='top' title='Haga clic para seleccionar el articulo'
								datos_registro='Seleccion|<?= $arrRegistro["estatus"]; ?>|<?= $arrRegistro["idpersona"]; ?>|<?= $arrRegistro["nacionalidad"]; ?>|<?= $arrRegistro["cedula"]; ?>|<?= $arrRegistro["nombre"]; ?>|<?= $arrRegistro["apellido"]; ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

									<td> <?= $arrRegistro["nacionalidad"] . " - " . $arrRegistro["cedula"]; ?> </td>
									<td> <?= ucwords($arrRegistro["nombre"]); ?> <?= $arrRegistro["apellido"]; ?> </td>
									<td> <?= $arrRegistro["estatus"]; ?> </td>
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
		echo "<br> <b>¡ No se ha encontrado ningún elemento!</b> <br><br>";
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función


?>
