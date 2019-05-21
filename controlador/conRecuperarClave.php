<?php 

$gsClase = "RecuperarClave";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

$objeto = new RecuperarClave();
$objeto->setFormulario($_POST);

$arrConsulta_P1 = $objeto->Consultar();
$arrConsulta_P2 = $objeto->Consultar2();
if ($arrConsulta_P1 AND  $arrConsulta_P2) {
	if ($arrConsulta_P1['respuesta'] == $_POST["ctxRespuesta1"] AND $arrConsulta_P2['respuesta'] == $_POST["ctxRespuesta2"]) {
		
		$objeto->atrId = $arrConsulta_P1["id_usuario"];
		$rstClave = $objeto->fmConsultarClave();
		$rango = $objeto->getMaximoRangoClave();
		$crypClave = clsCifrado::getCifrar($_POST["pswClave"]);

		while ($arrClave = $objeto->getConsultaAsociativo($rstClave)) {
			if ($crypClave == $arrClave["clave"]) {
				header("Location: {$ruta}?accion=Login&msjAlerta=claverepetida{$rango}");
				return;
			}
			else {
				continue;
			}
		}
		$objeto->faLiberarConsulta($rstClave); //libera de la memoria el resultado asociado a la consulta

		if ($objeto->fmRecuperarClave())
			header("Location: {$ruta}?accion=Login&msjAlerta=claverecuperada");
		else
			header("Location: {$ruta}?accion=Login&msjAlerta=clavenocambio");
	}
	else {
		header("Location: {$ruta}?accion=Login&msjAlerta=respuestaincorrecta");
	}
}
else {
	header("Location: {$ruta}?accion=Login&msjAlerta=nousuario");
}

$objeto->faDesconectar(); //cierra la conexión
unset($objeto); //destruye el objeto*/

?>
