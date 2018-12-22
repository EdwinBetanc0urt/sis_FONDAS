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



switch( $_POST["operacion"] ) {

	case "Guardar":
		Cambiar();
		break;

}


function Cambiar() {
	echo "<pre>";
	global $gsClase;
	$objCompletar = new Completar();
	$objCompletar->setFormulario( $_POST);
	//$objCompletar->actualizar();
	if ( $objCompletar->actualizar() ) //si el fmInsertar es verdadero, realiza las sentencias
		header( "Location: ../?form={$gsClase}&msjAlerta=datoscompletos" ); //envía a la vista, con mensaje de la consulta
	else
		header( "Location: ../?form={$gsClase}&msjAlerta=noregistro" ); //envía a la vista, con mensaje de la consulta*/

}





?>

