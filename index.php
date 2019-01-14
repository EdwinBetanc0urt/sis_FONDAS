<?php

	ini_set("expose_php", "off"); //Expone al mundo que PHP está instalado en el servidor

	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}

	//OCULTA todos los errores, para entorno de PRODUCCION
	error_reporting(E_ALL); //E_ALL muestra todos los errores y  0 los desactiva
	ini_set("display_errors", "On");

	/*
	$miurl = "index";
	if ($_GET['accion']) {
		$miurl = $_GET['accion'];
	}
	*/
	date_default_timezone_set("America/Caracas");
	ini_set('default_charset', 'utf-8');


	$miurl = "index";
	if(isset($_GET["accion"]) AND trim($_GET["accion"]) != ""){
		$miurl = $_GET["accion"];
	}

	if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista/visIntranet.php");
	}
	else if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "completar" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista/vis_Completar.php");
	}
	else if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "caducado" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista/vis_ClaveCaducada.php");
	}
	else {
		require_once("vista/vis_{$miurl}.php");
	}
?>
