<?php 

$gsClase = "Mi_Perfil";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}

switch($_POST['operacion']) {

	case "Guardar":
		cambiar();
		break;

	case "Consultar":
		consulta();
		break;

}



function consulta() {
	global $gsClase;

	$objeto = new Mi_Perfil();
	$objeto->setFormulario($_POST);

	$arreglo = $objeto->consultar(); //realiza una consulta
	//si existe un registro
	if ($arreglo) {
		$arreglo = $objeto->getConsultaAsociativo($arreglo);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($arreglo); 
	} //cierre del condicional si el RecordSet es verdadero
}



function cambiar() {
	global $gsClase;
	$objMunicipio = new Mi_Perfil();
	$objMunicipio->setFormulario($_POST);
	//var_dump($objMunicipio->Modificar());/*
	if ($objMunicipio->Modificar()) //si el fmInsertar es verdadero, realiza las sentencias
		header("Location: ../?form={$gsClase}&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
	else
		header("Location: ../?form={$gsClase}&msjAlerta=nocambio"); //envía a la vista, con */
}








?>

