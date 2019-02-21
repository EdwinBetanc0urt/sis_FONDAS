<?php

$gsClase = "Acceso";
$modulo = "";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}
$gsIndex = "Location: ../?form={$gsClase}";

switch($_POST['operacion']) {
	/*
	case NULL: //en caso de ser nulo se esta abriendo por URL y se debe sacar del sistema
		header("Location: ../../control/seguridad/ctr_LogOut.php?getMotivoLogOut=indevido"); //cierra la sesion
		break;
	*/
	case "Agregar":
		//fcAgregarAcceso();
		//break;
	case "Cambiar":
		fcModificarAccesos();
		break;
	case "Eliminar":
		fcEliminarAcceso();
		break;
	case "ListaAcceso":
		fcListaAcceso();
		break;
	case "ListaConAcceso":
		fcListaAccesoRol();
		break;
	case "ListaSinAcceso":
		fcListaSinAccesoRol();
		break;
	case "ListaBotonConAcceso":
		fcListaBotonSi();
		break;
	case "ListaBotonSinAcceso":
		fcListaBotonNo();
		break;
	case "EliminaVista":
		fcEliminarVista();
		break;
}



//funcion.control.Registrar
function fcAgregarAcceso() {	
	global $gsIndex; // variable global que contiene la ubicación del header
	global $gsClase;
	$objeto = new Acceso(); //nuevo objeto o clase Accesos
	$objeto->setFormulario($_POST); //recibe los valores de la vista y los sanea
	//envía a la vista, con mensaje de la consulta
	if ($objeto->fmInsertar())
		header($gsIndex . "&msjAlerta=registro"); 
	else
		header($gsIndex . "&msjAlerta=noregistro"); 
	//var_dump($objeto->fmInsertar());

	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



//funcion.control.Modificar
function fcModificarAccesos() {	
	//echo "<pre>";
	global $gsIndex; // variable global que contiene la ubicación del header
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Acceso(); //nuevo objeto o clase Accesos
	//var_dump($_POST["chkBoton"]);
	$objeto->setFormulario($_POST); //recibe los valores de la vista y los sanea
	$objeto->setBotones($_POST["chkBoton"]); //recibe los valores de la vista y los sanea

	$objeto->fmEliminar();
	if ($objeto->fmInsertar()) {
		header($gsIndex . "&msjAlerta=cambio"); 
	}
	else
		header($gsIndex . "&msjAlerta=nocambio");
	//*/
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



//funcion.control.Modificar
function fcEliminarVista() {	
	echo "<pre>";
	global $gsIndex; // variable global que contiene la ubicación del header
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Acceso(); //nuevo objeto o clase Accesos

	$objeto->setFormulario($_POST); //recibe los valores de la vista y los sanea
	var_dump($objeto->atrFormulario);
	var_dump($objeto->fmEliminarVista()); /*
	if ($objeto->fmEliminarVista()) {
		header($gsIndex . "&msjAlerta=cambio"); 
	}
	else
		header($gsIndex . "&msjAlerta=nocambio");
	//*/
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



//funcion.control.Registrar
function fcEliminarAcceso() {	
	global $gsIndex; // variable global que contiene la ubicación del header
	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Acceso(); //nuevo objeto o clase Accesos
	$objeto->setFormulario($_POST); //recibe los valores de la vista y los sanea
	//envía a la vista, con mensaje de la consulta
	//var_dump($objeto->fmEliminar());
	if ($objeto->fmEliminar())
		header($gsIndex . "&getTipo_Usuario=" . $_POST["numTipo_Usuario"] . "&msjAlerta=quitoacceso"); 
	else
		header($gsIndex . "&getTipo_Usuario=" . $_POST["numTipo_Usuario"] . "&msjAlerta=nocambio"); 
	//var_dump($_POST);
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función




function fcListaAcceso() {

	global $gsClase; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Acceso;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	
	$objeto->atrId_Tipo_U = $_POST["setTipoUsuario"];
	$objeto->atrId_Modulo = $_POST["setModulo"];


	$rstRecordSet = $objeto->ListarVistas();

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo

		$arrVistaSi = array();
		$rstRecordSetAcceso = $objeto ->ListarAcceso();
		if ($rstRecordSetAcceso) {
			$i = 0;	
			while ($arrConsultaVista = $objeto->getConsultaAsociativo($rstRecordSetAcceso)) {
				$arrVistaSi[$i] = $arrConsultaVista["idvista"];
				$i++; 			
			}
			$objeto->faLiberarConsulta($rstRecordSetAcceso);
			unset($arrConsultaVista);
		}
		//var_dump($_POST);
		?>
		<div class='table-responsive'>
			<br>
			<table border='0' valign='center' class='table table-striped text-center table-hover'>
				<thead>
					<tr class='info'>
						<th > 
							Vista <span class='caret'></span> 
						</th>
						<th > 
							Botones <span class='caret'></span> 
						</th>
						<th > 
							ACCESOS
						</th>
					</tr>
				</thead>
				<tbody>
		<?php

		//$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet);
		while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)){	
 			?>		
				<tr >
					<td > 
						<?= $arrRegistro["idvista"]; ?> - <?= strtoupper($arrRegistro["nombre"]); ?>
						<input type="hidden" id="ctxIdVista<?= $arrRegistro["idvista"]; ?>" value="<?= $arrRegistro["idvista"]; ?>" />
						<input type="hidden" id="ctxNombreVista<?= $arrRegistro["idvista"]; ?>" value="<?= ucwords($arrRegistro["nombre"]); ?>" />
					</td>

					<td>
						<?php
							fcListaBotonSi($arrRegistro["idvista"]);
						?>
					</td>

					<td>
						<?php
			 				if (in_array($arrRegistro["idvista"], $arrVistaSi)) {
			 					?>
								<button type="button" class="btn btn-danger" aria-label="Left Align" data-toggle='tooltip' data-placement='top'
									title='Quitar el acceso total a esta pagina' onClick='fjQuitarVista(<?= $arrRegistro["idvista"]; ?>)' >
									<span class="fa fa-ban " aria-hidden="true"></span>
								</button>
						<?php
							}
							else {
								?>
								<button type="button" class="btn btn-danger" aria-label="Left Align" data-toggle='tooltip' data-placement='top'
									title='Quitar el acceso total a esta pagina' onClick='fjQuitarVista(<?= $arrRegistro["idvista"]; ?>)' >
									<span class="fa fa-ban " aria-hidden="true"></span>
								</button>
								<?php
							}
						?>
					</td>
				</tr>
			<?php
		}
		?>
			</tbody>
		</table>
		<script type="text/javascript">
			function() {
			    $('[data-toggle="tooltip"]').tooltip();
			}
		</script>
		<?php
		
		$objeto->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		echo "<br> <b>¡ No se ha encontrado ningún elemento, <a href='../../vista/general/vis_Intranet?accion=Vista#VentanaModal'>por favor registre una Vista !</a></b> <br><br>";
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
	
} //cierre de la función





function fcListaBotonSi($piVista = "") {
	global $gsClase, $Modulo; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new Acceso;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto

	$objeto->atrVista = $piVista ;
	$objeto->atrId_Tipo_U = $_POST["setTipoUsuario"];

	$rstRecordSet = $objeto->ListarBotonNo();
	if ($rstRecordSet) {

		$arrB = array();
		$rstBotonesSi = $objeto->ListarBotonSi();
		if ($rstBotonesSi) {
			//$arrBotonesSi = $objeto->getConsultaAsociativo($rstBotonesSi);
			$i = 0;	
			while ($arrBotonesSi = $objeto->getConsultaAsociativo($rstBotonesSi)) {
				$arrB[$i] = $arrBotonesSi["idboton"];
				$i++; 			
			} 

			$objeto->faLiberarConsulta($rstBotonesSi);
			unset($arrBotonesSi);
		}

		$arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet); //convierte el RecordSet en un arreglo

		?>
			<div class='table-responsiveEEE'>
				<br>
				<table border='0' valign='center' class='table table-stripedEEE text-center table-hoverEEE'>
					<thead>
						<tr class='bg_Azul'>
							<th > 
								Cod
							</th>
							<th > 
								Boton 
							</th>
							<th > 
								Accesa
							</th>
						</tr>
					</thead>
					<tbody>
		<?php
		do {		
			$vsSeleccionado = "";

			if (in_array($arrRegistro["idboton"], $arrB))
				$vsSeleccionado .= " checked='checked' ";
			?>

					<tr data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación' onclick='fjSeleccionFila(this);' datos_id='<?= $arrRegistro["idboton"]; ?>' >
							<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
							<td > <?= $arrRegistro["idboton"]; ?></td>
							<td> <?= ucwords($arrRegistro["boton"]); ?></td>
							<td >
								<input type='checkbox' value='<?= $arrRegistro["idboton"]; ?>' name='chkBoton[<?= $piVista; ?>][]' class='chkBotones' <?= $vsSeleccionado; ?> class='chkBotones' id='chkBoton_<?= $piVista; ?>_<?= $arrRegistro["idboton"]; ?>' />
							</td>
						</tr> 
			<?php
		}
		while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) ;
		?>
					</tbody>
				</table>
		<?php
		$objeto->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		echo "<br> <b>¡ No se ha encontrado ningún elemento, por favor registre un Boton!</a></b> <br><br>";
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
	
} //cierre de la función




/*
//destruye lo enviado
if (isset($_POST))
	unset($_POST); 

if (isset($_GET))
	unset($_GET);
*/
?>