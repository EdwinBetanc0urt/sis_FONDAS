<?php 

$gsClase = "Usuario";

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
		UltimoCodigoUsuario();
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
		ListaUsuario();
		break;

	case "Bloqueo":
		BloquearUsuario();
		break;
	case "Desbloqueo":
		DesbloquearUsuario();
		break;

}

// Funcion Ultimo Codigo de Parroquia
// utilizada por la funcion AJAX para colocar el ID automaticamente
function UltimoCodigoUsuario() {
	$objUsuario = new Usuario(); //instancia la clase
	$arrCodigo = $objUsuario->UltimoCodigo(); //obtiene el arreglo con el codigo
	echo $arrCodigo[0] + 1; //imprime el arreglo en la posicion cero y agrega 1
}


function registrar() {
	global $gsClase;
	$objUsuario = new Usuario();
	$objUsuario->setFormulario($_POST);
	//var_dump($objUsuario->Incluir());
	if ($objUsuario->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta*/
}



function BloquearUsuario() {
	global $gsClase;
	$objUsuario = new Usuario();
	$objUsuario->setFormulario($_POST);
	//var_dump($objUsuario->Modificar());/*
	if ($objUsuario->Bloquear()) {

		$arrRetorno = array('mensaje' => "cambio", "ver" => "no");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($arrRetorno); 
		//header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	}
	else {

		$arrRetorno = array('mensaje' => "nocambio", "ver" => "no");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($arrRetorno); 
		//header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
	}
}
function DesbloquearUsuario() {
	global $gsClase;
	$objUsuario = new Usuario();
	$objUsuario->setFormulario($_POST);
	//var_dump($objUsuario->Modificar());/*
	if ($objUsuario->Desbloquar()) {

		$arrRetorno = array('mensaje' => "cambio", "ver" => "no");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($arrRetorno); 
		//header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	}
	else {

		$arrRetorno = array('mensaje' => "nocambio", "ver" => "no");
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($arrRetorno); 
		//header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
	}
}




function cambiar() {
	global $gsClase;
	$objUsuario = new Usuario();
	$objUsuario->setFormulario($_POST);
	//var_dump($objUsuario->Modificar());/*
	if ($objUsuario->Modificar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
}


function borrar() {
	global $gsClase;
	$objUsuario = new Usuario();
	$objUsuario->setFormulario($_POST);
	if ($objUsuario->Eliminar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=elimino"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noelimino"); //envía a la vista, con 
}



function ListaUsuario() {
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Usuario; //instancia la clase

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
								Usuario <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "tipo")' >
								Nombre <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "tipo")' >
								Apellido <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "tipo")' >
								Tipo <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Estatus <span class='glyphicon glyphicon-sort'></span>
							</th>
							<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsClase; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
								Operaciones <span class='glyphicon glyphicon-sort'></span>
							</th>
						</tr>
					</thead>
					<tbody>
		<?php 
		while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) {
			?>
						<tr >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
							<td> <?= ucwords($arrRegistro[$objeto->atrNombre]); ?> </td>
							<td> <?= ucwords($arrRegistro["nombre"]); ?> </td>
							<td> <?= ucwords($arrRegistro["apellido"]); ?> </td>
							<td> <?= $arrRegistro["tipo_usuario"]; ?> </td>
							<td> <?= $arrRegistro["estatus_usuario"]; ?> </td>
							<td>
								<?php
									if ($arrRegistro[ "estatus_usuario" ] == "activo") {
										?>
										<button type="button" class="btn btn-danger" aria-label="Left Align" data-toggle='tooltip' data-placement='top'
											title='Bloquear el Usuario' onClick='bloquear(this.value);' value='<?= $arrRegistro["id_usuario"]; ?>' >
											<span class="fa fa-lock " aria-hidden="true"></span>
										</button>
										<?php
									}
									else {
										?>
										<button type="button" class="btn btn-success" aria-label="Left Align" data-toggle='tooltip' data-placement='top' title='Desbloquear el Usuario' onClick='desbloquear(this.value);' 
										value='<?= $arrRegistro["id_usuario"]; ?>' >
											<span class="fa fa-unlock" aria-hidden="true"></span>
										</button>
										<?php
									}
									?>
								<button type="button" class="btn btn-default" aria-label="Left Align" data-toggle='tooltip' data-placement='top' title='Imprimir acceso' onClick='veraccesos(this.value);' value='<?= $arrRegistro["id_usuario"]; ?>' >
									<span class="fa fa-print" aria-hidden="true"></span>
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



?>

