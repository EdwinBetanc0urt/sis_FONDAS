<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

$gsClase = "Cambiar_Clave";

$ruta = "";
if (is_file("modelo/cls{$gsClase}.php")) {
	require_once("modelo/cls{$gsClase}.php");
}
else {
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {
	case "ConsultaPreguntas":
		obtenerPreguntas();
		break;
	case "RecuperarClave":
	case "CambiarClave":
		changeClave();
		break;
}


function changeClave() {
	global $gsClase;
	$objeto = new CambiarClave();
	$objeto->setFormulario($_POST);
	$mensaje = $objeto->cambiarClave();

	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
	header("Location: conCerrar.php?getMotivoLogOut=$mensaje");
}


function obtenerPreguntas() {
	$objeto = new CambiarClave();
	$objeto->setFormulario($_POST);
	$arrConsulta = $objeto->getPreguntas();
	if ($arrConsulta) {
		$arrRetorno = array(
			"mensaje" => "consulto",
			"ver" => "no",
			"datos" => array(
				"idusuario" => $arrConsulta["id_usuario"],
				"pregunta" => $arrConsulta["pregunta"],
				"idpregunta" => $arrConsulta["idpregunta"]
			)
		);
	} //cierre del condicional si el RecordSet es falso
	else {
		$arrRetorno = array(
			"mensaje" => "noconsulto",
			"ver" => "no",
			"datos" => array(
				"idusuario" => "",
				"pregunta" => "",
				"id_pregunta" => ""
			)
		);
	}

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



?>
