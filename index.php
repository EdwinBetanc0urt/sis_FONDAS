<?php
	/**
	 * Index dieccionador de vistas y paginas, para ocultar las rutas de las
	 * carpetas y archivos, ademas de contener configuración global
	 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com>
	 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
	 * @link https://creativecommons.org/licenses/by-sa/4.0/
	 */

	//define el separador de rutas en Windows \ y basados en Unix /
	defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

	//constantes y configuraciones del sistema
	require_once("_core" . DS . "config.php");

	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}

	$miurl = "index";
	if(isset($_GET["accion"]) AND trim($_GET["accion"]) != ""){
		$miurl = $_GET["accion"];
	}

	if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista" . DS . "visIntranet.php");
	}
	else if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "completar" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista" . DS . "vis_Completar.php");
	}
	else if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "caducado" AND
		isset($_SESSION["sistema"]) AND $_SESSION["sistema"] == "fondas") {
		require_once("vista" . DS . "vis_ClaveCaducada.php");
	}
	else {
		if (is_file("vista" . DS . "vis_{$miurl}.php")) {
			require_once("vista" . DS . "vis_{$miurl}.php");
		}
		else {
			require_once("vista" . DS . "vis_index.php");
		}
	}
?>
