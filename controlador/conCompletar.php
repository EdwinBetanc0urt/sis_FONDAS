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
	global $gsClase;
	$objCompletar = new Completar();
	$objCompletar->setFormulario($_POST);
	if ($objCompletar->actualizar()) {
		require("{$ruta}controlador/conCerrar.php&getMotivoLogOut=datoscompletos");
		//header("Location: ../?form={$gsClase}&msjAlerta=datoscompletos"); //envía a la vista, con mensaje de la consulta
	}
	else
		header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta*/
}

?>
