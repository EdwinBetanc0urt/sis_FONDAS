<?php

	ini_set("expose_php", "off"); //Expone al mundo que PHP está instalado en el servidor

	session_start();


	
		//OCULTA todos los errores, para entorno de PRODUCCION
		error_reporting(0);
		ini_set("display_errors", "off");

/*
	$miurl = "index";
	if ( $_GET['accion'] ) {
		$miurl = $_GET['accion'];
	}

	*/
	date_default_timezone_set("America/Caracas");
	ini_set('default_charset', 'utf-8');

	

	$miurl = "index";
	if( isset( $_GET['accion'] ) ){
		$miurl = $_GET['accion'];
	}

	if ( isset( $_SESSION["sistema"] ) AND $_SESSION["sistema"] == "fondas" ) {
		require_once("vista/visIntranet.php");
	}
	else {
		require_once("vista/vis_{$miurl}.php");
	}

	/*
	if( !isset($_SESSION[''])){
		require_once("vista/vis".$miurl.".php");
	}else{
		require_once("vista/visPerfil.php");
	}*/
?>

