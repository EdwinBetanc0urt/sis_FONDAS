<?php 

$gsClase = "Cambiar_Respuestas";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

$objeto = new CambiarRespuestas;
$objeto->setFormulario($_POST);

$rstClave = $objeto->fmConsultarClave();
$crypClave = clsCifrado::getCifrar($_POST["pswClave"]);
$arrClave = $objeto->getConsultaAsociativo($rstClave);

if ($crypClave == $arrClave["clave"]) {
	if ($objeto->InsertarRespuestas()) {
		echo "si cambio";
		header("Location: {$ruta}?form=Cambiar_Respuestas&msjAlerta=cambio");
	}
	else{
		echo "no cambio";
		header("Location: {$ruta}?form=Cambiar_Respuestas&msjAlerta=nocambio");
	}
}
else {
	echo "clave errada";
	header("Location: {$ruta}?form=Cambiar_Respuestas&msjAlerta=claveerrada");
}

$objeto->faLiberarConsulta($rstClave); //libera de la memoria el resultado asociado a la consulta
$objeto->faDesconectar(); //cierra la conexión
unset($objeto); //destruye el objeto*/

?>
