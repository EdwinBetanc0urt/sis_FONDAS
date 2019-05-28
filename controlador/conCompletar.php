<?php 

$gsClase = "Completar";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST["operacion"]) {
	case "Guardar":
		Cambiar();
		break;
}

function Cambiar() {
	global $gsClase, $ruta;
	$objCompletar = new Completar();
	$objCompletar->setFormulario($_POST);
	if ($objCompletar->actualizar()) {
		header("Location: {$ruta}controlador/conCerrar.php?getMotivoLogOut=datoscompletos");
	}
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta*/
}

?>
