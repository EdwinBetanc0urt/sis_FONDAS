<?php

$gsClase = "Cambiar_Clave";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {
	case "ConsultarClaveCaducada":
		fcBuscar();
		break;
	case 'Guardar':
		fcCambiarClave();
		break;
}
echo "<pre>";
var_dump($_POST);

function fcCambiarClave() {
	global $gsClase;
	$objeto = new CambiarClave();
	$objeto->setFormulario($_POST);
	$objeto->cambiarClave();
	/*
	$arreglo = $objeto->consultar(); //realiza una consulta
	//si existe un registro
	if ($arreglo) {
		//envía a la vista, con mensaje de la consulta
		header("Location: ../?form={$gsClase}" .
			"&msjAlerta=duplicado&getOpcion=" . $_POST["operacion"] .
			"&getId=" . $arreglo[ $objeto->atrId ] .
			"&getNombre=" . $arreglo[ $objeto->atrNombre ] .
			"&getEstatus=" . $arreglo[ $objeto->atrEstatus ]);
	} //cierre del condicional si el RecordSet es verdadero
	else {
		if ($objeto->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
			header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
		else
			header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta
	}
	*/
}



function fcBuscar() {
	$objeto = new CambiarClave();
	$objeto->setFormulario($_POST);
	$arrConsulta = $objeto->getRespuestas();
	if ($arrConsulta) {
		if ($arrConsulta["pregunta"]) {
			$arrRetorno = array(
				"mensaje" => "consulto",
				"ver" => "no",
				"datos" => array(
					"pregunta" => $arrConsulta["pregunta"],
					"idpregunta" => $arrConsulta["idpregunta"]
				)
			);
		}
		else {
			$arrRetorno = array(
				"mensaje" => "nousuario",
				"ver" => "no",
				"datos" => array(
					"pregunta" => "",
					"id_pregunta" => ""
				)
			);
		}
	} //cierre del condicional si el RecordSet es falso
	else {
		$arrRetorno = array(
			"mensaje" => "nousuario",
			"ver" => "no",
			"datos" => array(
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
