<?php

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
	case "CambiarClave":
		cambiarClave();
		break;
}


function registrar() {
	global $gsClase;
	$objClaveCaducada = new CambiarClave();
	$objClaveCaducada->setFormulario($_POST);

	$arreglo = $objClaveCaducada->consultar(); //realiza una consulta
	//si existe un registro
	if ($arreglo) {
		//envía a la vista, con mensaje de la consulta
		header("Location: ../?form={$gsClase}" .
			"&msjAlerta=duplicado&getOpcion=" . $_POST["operacion"] .
			"&getId=" . $arreglo[ $objClaveCaducada->atrId ] .
			"&getNombre=" . $arreglo[ $objClaveCaducada->atrNombre ] .
			"&getEstatus=" . $arreglo[ $objClaveCaducada->atrEstatus ]);
	} //cierre del condicional si el RecordSet es verdadero
	else {
		if ($objClaveCaducada->Incluir()) //si el fmInsertar es verdadero, realiza las sentencias
			header("Location: ../?form={$gsClase}&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
		else
			header("Location: ../?form={$gsClase}&msjAlerta=noregistro"); //envía a la vista, con mensaje de la consulta*/
	}
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

/*
echo "<pre>";
$objCifrado = new clsCifrado();

$objeto = new CambiarClave();
$objeto->setFormulario( $_POST );

$arrConsulta_P1 = $objeto->Consultar();
$arrConsulta_P2 = $objeto->Consultar2();
//var_dump( $arrConsulta_P1 );
//var_dump( $arrConsulta_P2 );
if ( $arrConsulta_P1 AND  $arrConsulta_P2) {

	if ( $arrConsulta_P1['respuesta'] == $_POST["ctxRespuesta1"] AND $arrConsulta_P2['respuesta'] == $_POST["ctxRespuesta2"] ) {
		echo "respuestas iguales";
		
		$rstClave = $objeto->fmConsultarClave();

		$rango = $objeto->getMaximoRangoClave();

		$crypClave = $objCifrado->flEncriptar( $_POST["pswClave"] );

		while ( $arrClave = $objeto->getConsultaAsociativo( $rstClave ) ) {
			if ( $crypClave == $arrClave["clave"] ) {
				header( "Location: {$ruta}?form=Cambiar_Clave&msjAlerta=claverepetida{$rango}");
				echo "repetido";
				return;
			}
			else {
				echo "sin repetir";
				continue;
			}
		}
		$objeto->faLiberarConsulta( $rstClave ); //libera de la memoria el resultado asociado a la consulta

		//var_dump( $objeto->CambiarClave() );
		
		if ( $objeto->CambiarClave() )
			header( "Location: {$ruta}?form=Cambiar_Clave&msjAlerta=claverecuperada");
		else
			header( "Location: {$ruta}?form=Cambiar_Clave&msjAlerta=clavenocambio");
		
		
	}
	else {
		header( "Location: {$ruta}?form=Cambiar_Clave&msjAlerta=respuestaincorrecta");
		echo "respuestaincorrecta";
	}
}
else {
	header( "Location: {$ruta}?form=Cambiar_Clave&msjAlerta=nousuario");
	echo "nousuario";
}

unset( $objCifrado ); //destruye el objeto
$objeto->faDesconectar(); //cierra la conexión
unset( $objeto ); //destruye el objeto*/



?>

