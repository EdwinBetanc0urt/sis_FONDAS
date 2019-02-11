<?php 

$gsClase = "Revisar_Reposos";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {
	case "AprobarReposos":
		fcAprobar();
		break;
	case "RechazarReposos":
		fcRechazar();
		break;

	case "ListaView":
		ListaRevisar_Reposos();
		break;

	case "ListaViewRevisado":
		ListapRepososRevisados();
		break;

	case "ListaViewEnCurso":
		ListaRepososEnCurso();
		break;
	case "ListaViewCulminado":
		ListaRepososCulminado();
		break;
	case "ListaViewRechazado":
		ListaRepososRechazados();
		break;
}


function fcAprobar() {
	global $gsClase;
	$objVacaciones = new Revisar_Reposos();
	$objVacaciones->setFormulario($_POST);
	var_dump($objVacaciones->Aprobar());/*
	if ($objVacaciones->Aprobar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=aprobado"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noaprobado"); //envía a la vista, con */
}

function fcRechazar() {
	global $gsClase;
	$objVacaciones = new Revisar_Reposos();
	$objVacaciones->setFormulario($_POST);
	if ($objVacaciones->Rechazar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=rechazado"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=norechazado"); //envía a la vista, con 
}



function ListaRevisar_Reposos() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Revisar_Reposos; //instancia la clase

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
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Trabajador  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Justificativo / Comprobante <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Motivo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Inicio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
							$vsHoraI = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaI = $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma");

							$vsHoraF = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaF = $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma");
							?>
							<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
								datos_registro='Seleccion
								|<?= $arrRegistro[$objeto->atrEstatus]; ?>
								|<?= $arrRegistro[$objeto->atrId]; ?>
								|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
								|<?= ucwords($arrRegistro["descripcion"]); ?>
								|<?= ucwords($arrRegistro["idmotivo"]); ?>
								|<?= ucwords($arrRegistro["Motivo"]); ?>
								|<?= ucwords($arrRegistro["idtipo_ausencia"]); ?>
								|<?= ucwords($arrRegistro["Tipo_Permiso"]); ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

								<td> <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . ", " . $arrRegistro["nombre"] . " " . $arrRegistro["apellido"]; ?> </td>
								<td> <?= $arrRegistro[$objeto->atrNombre]; ?> </td>
								<td> <?= $arrRegistro["idmotivo_permiso"] . " - " . $arrRegistro["motivo_permiso"]; ?> </td>
								<td> <?= $vsFechaI . " " . $vsHoraI; ?> </td>
								<td> <?= $vsFechaF . " " . $vsHoraF; ?> </td>
								<td> <?= $arrRegistro["condicion"]; ?> </td>
								<td><!--
									<button type="button" class="btn" onclick="fjVerVacacion(<?= $arrRegistro["idpermiso"] ?>)">
										Ver
									</button>-->
									<button type="button" class="btn" onclick="fjAprobar(<?= $arrRegistro['idpermiso'] ?>)">
										Aprobar
									</button>
									<button type="button" class="btn" onclick="fjRechazar(<?= $arrRegistro['idpermiso'] ?>)">
										Rechazar
									</button>
								</td>
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



function ListapPermisosRevisados() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Revisar_Reposos; //instancia la clase

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

	$rstRecordSet = $objeto->fmListarIndexRevisado(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Trabajador  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Justificativo / Comprobante <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Motivo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Inicio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
							$vsHoraI = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaI = $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma");

							$vsHoraF = date("h:i:s A", strtotime($arrRegistro["fecha_fin"]));
							$vsFechaF = $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma");
							?>
							<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
								datos_registro='Seleccion
								|<?= $arrRegistro[$objeto->atrEstatus]; ?>
								|<?= $arrRegistro[$objeto->atrId]; ?>
								|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
								|<?= ucwords($arrRegistro["descripcion"]); ?>
								|<?= ucwords($arrRegistro["idmotivo"]); ?>
								|<?= ucwords($arrRegistro["Motivo"]); ?>
								|<?= ucwords($arrRegistro["idtipo_ausencia"]); ?>
								|<?= ucwords($arrRegistro["Tipo_Permiso"]); ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

								<td> <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . ", " . $arrRegistro["nombre"] . " " . $arrRegistro["apellido"]; ?> </td>
								<td> <?= $arrRegistro[$objeto->atrNombre]; ?> </td>
								<td> <?= $arrRegistro["idmotivo_permiso"] . " - " . $arrRegistro["motivo_permiso"]; ?> </td>
								<td> <?= $vsFechaI . " " . $vsHoraI; ?> </td>
								<td> <?= $vsFechaF . " " . $vsHoraF; ?> </td>
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



function ListaPermisosEnCurso() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Revisar_Reposos; //instancia la clase

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

	$rstRecordSet = $objeto->fmListarIndexRechazado(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Trabajador  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Justificativo / Comprobante <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Motivo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Inicio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
							$vsHoraI = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaI = $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma");

							$vsHoraF = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaF = $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma");
							?>
							<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
								datos_registro='Seleccion
								|<?= $arrRegistro[$objeto->atrEstatus]; ?>
								|<?= $arrRegistro[$objeto->atrId]; ?>
								|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
								|<?= ucwords($arrRegistro["descripcion"]); ?>
								|<?= ucwords($arrRegistro["idmotivo"]); ?>
								|<?= ucwords($arrRegistro["Motivo"]); ?>
								|<?= ucwords($arrRegistro["idtipo_ausencia"]); ?>
								|<?= ucwords($arrRegistro["Tipo_Permiso"]); ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

								<td> <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . ", " . $arrRegistro["nombre"] . " " . $arrRegistro["apellido"]; ?> </td>
								<td> <?= $arrRegistro[$objeto->atrNombre]; ?> </td>
								<td> <?= $arrRegistro["idmotivo_permiso"] . " - " . $arrRegistro["motivo_permiso"]; ?> </td>
								<td> <?= $vsFechaI . " " . $vsHoraI; ?> </td>
								<td> <?= $vsFechaF . " " . $vsHoraF; ?> </td>
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



function ListaVacacionesCulminado() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Revisar_Reposos; //instancia la clase

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

	$rstRecordSet = $objeto->fmListarIndexRechazado(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Trabajador  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Justificativo / Comprobante <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Motivo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Inicio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
							$vsHoraI = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaI = $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma");

							$vsHoraF = date("h:i:s A", strtotime($arrRegistro["fecha_fin"]));
							$vsFechaF = $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma");
							?>
							<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
								datos_registro='Seleccion
								|<?= $arrRegistro[$objeto->atrEstatus]; ?>
								|<?= $arrRegistro[$objeto->atrId]; ?>
								|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
								|<?= ucwords($arrRegistro["descripcion"]); ?>
								|<?= ucwords($arrRegistro["idmotivo"]); ?>
								|<?= ucwords($arrRegistro["Motivo"]); ?>
								|<?= ucwords($arrRegistro["idtipo_ausencia"]); ?>
								|<?= ucwords($arrRegistro["Tipo_Permiso"]); ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

								<td> <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . ", " . $arrRegistro["nombre"] . " " . $arrRegistro["apellido"]; ?> </td>
								<td> <?= $arrRegistro[$objeto->atrNombre]; ?> </td>
								<td> <?= $arrRegistro["idmotivo_permiso"] . " - " . $arrRegistro["motivo_permiso"]; ?> </td>
								<td> <?= $vsFechaI . " " . $vsHoraI; ?> </td>
								<td> <?= $vsFechaF . " " . $vsHoraF; ?> </td>
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



function ListaPermisosRechazados() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Revisar_Reposos; //instancia la clase

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

	$rstRecordSet = $objeto->fmListarIndexRechazado(htmlentities(addslashes(trim(strtolower($_POST['setBusqueda'])))));

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo
		?>
			<div class='table-responsive'>
				<br><br>
				<table border='0' valign='center' class='table table-striped text-center table-hover' id="tabLista<?= $gsClase; ?>">
					<thead>
						<tr class='info'>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Trabajador  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
								Justificativo / Comprobante <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Motivo  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Inicio  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Fin  <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus  <span class='glyphicon glyphicon-sort'></span>
							</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
							$vsHoraI = date("h:i:s A", strtotime($arrRegistro["fecha_inicio"]));
							$vsFechaI = $objeto->faFechaFormato($arrRegistro["fecha_inicio"], "amd", "dma");

							$vsHoraF = date("h:i:s A", strtotime($arrRegistro["fecha_fin"]));
							$vsFechaF = $objeto->faFechaFormato($arrRegistro["fecha_fin"], "amd", "dma");
							?>
							<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
								datos_registro='Seleccion
								|<?= $arrRegistro[$objeto->atrEstatus]; ?>
								|<?= $arrRegistro[$objeto->atrId]; ?>
								|<?= ucwords($arrRegistro[$objeto->atrNombre]); ?>
								|<?= ucwords($arrRegistro["descripcion"]); ?>
								|<?= ucwords($arrRegistro["idmotivo"]); ?>
								|<?= ucwords($arrRegistro["Motivo"]); ?>
								|<?= ucwords($arrRegistro["idtipo_ausencia"]); ?>
								|<?= ucwords($arrRegistro["Tipo_Permiso"]); ?>' >
									<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->

								<td> <?= $arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"] . ", " . $arrRegistro["nombre"] . " " . $arrRegistro["apellido"]; ?> </td>
								<td> <?= $arrRegistro[$objeto->atrNombre]; ?> </td>
								<td> <?= $arrRegistro["idmotivo_permiso"] . " - " . $arrRegistro["motivo_permiso"]; ?> </td>
								<td> <?= $vsFechaI . " " . $vsHoraI; ?> </td>
								<td> <?= $vsFechaF . " " . $vsHoraF; ?> </td>
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

