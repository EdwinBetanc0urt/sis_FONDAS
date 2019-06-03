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

function consultaAsistencia() {
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

?>
