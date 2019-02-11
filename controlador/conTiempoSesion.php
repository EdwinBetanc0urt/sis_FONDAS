<?php


$gsClase = "TiempoSesion";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

//$Opcion = isset($_POST['vvOpcion']) ? $_POST['vvOpcion'] : NULL;

if (isset($_POST['vvOpcion']))
	$Opcion = $_POST['vvOpcion'] ;
else
	$Opcion = NULL;


switch($Opcion) {
	case NULL: //en caso de ser nulo se esta abriendo por URL y se debe sacar del sistema
		header("Location: ../../controlador/seguridad/ctr_LogOut.php?getMotivoLogOut=indevido"); //cierra la sesion
		break;
	case "ModificarAjax":
		fcModificarTiempoAjax();
		break;
}



function fcModificarTiempoAjax() {
	$objeto = new clsTiempoSesion();

	$objeto->atrTiempo = (intval($_POST["ctxTiempo"]) * 60) ; // lleva los minutos a segundos 
	if ($objeto->fmActualizarTiempo()) {

		$_SESSION['tiempo_sesion'] = ($objeto->atrTiempo); //actualiza la variable de sesion con el nuevo valor
		echo $_SESSION['tiempo_sesion'];
		//$valor = $_SESSION['InactivoMaximo'];
	}
	else {
		echo "no";
	}
	$objeto->faDesconectar(); //cierra la conexion
	unset($objeto); //destruye el objeto
	//return $valor;
}


?>