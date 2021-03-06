<?php
	/**
	 * Configuración global del proyecto, define las constantes del sistema,
	 * separadores de rutas según el sistema operativo, configuraciones de php
	 * según el entorno de desarrollo o producción para el manejo de posibles
	 * errores, habilitar los errores de log.
	 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com>
	 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
	 * @link https://creativecommons.org/licenses/by-sa/4.0/
	 */

	ini_set("expose_php", "off"); //Expone al mundo que PHP está instalado en el servidor

	// controla si el parser debería reconocer las etiquetas < ? ... ? >, además de < ?php ... ? >
	ini_set("short_open_tag", "on");

	// Localización español
	setlocale(LC_ALL, "es_VE.UTF-8", "es_VE", "spanish");

	date_default_timezone_set("America/Caracas");

	ini_set("default_charset", "utf-8");

	// define el separador de rutas en Windows \ y basados en Unix /
	defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

	defined("PATH") OR define("PATH", dirname(dirname(__FILE__)));

	// Cambiar a true o producción si queremos mostrar los errores
	defined("ENTORNO") OR define("ENTORNO", "desarrollo");

	defined("MEDIO") OR define("MEDIO", "offline");


	if (! defined("ERRORES")) {
		// no inicializadas o capturar errores en nombres de variables ...)
		define("ERRORES", E_ALL | E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	}
	// OCULTA todos los errores, para entorno de PRODUCCION
	if (ENTORNO == "produccion") {
		error_reporting(0); // Desactivar toda notificación y advertencia de error
		ini_set("display_errors", "off");
		ini_set("display_startup_errors", "off");
	}
	// MUESTRA todos los errores para entorno de DESARROLLO
	else {
		error_reporting(ERRORES);
		ini_set("display_errors", "On");
		//ini_set("display_errors", "1");
		ini_set("display_startup_errors", "On");
	}

	// indica al navegador que no exponga la cookie a las secuencias de comandos
	// del lado del cliente, como JavaScript
	// ini_set("session.cookie_httponly", 1);

	// solo utilice cookies para las sesiones y no permita el paso de ID de sesión
	// como un parámetro GET
	// ini_set("session.use_only_cookies", 1);

	ini_set("output_buffering", "On");

	ini_set("log_errors", "On");
	ini_set("error_log", "error_srv.log");

	// desactiva ciertas funciones internas de PHP por seguridad
	ini_set(
		"disable_functions", "curl_exec, curl_multi_exec, diskfreespace, " .
		"disk_free_space, exec, leak, passthru, parse_ini_file, popen, proc_open, " .
		"set_time_limit, shell_exec, show_source, phpinfo, system, tmpfile"
	);
	ini_set("disable_functions", "ini_set");

	//por defecto PHP/5.6.30 o su versión
	header("Server: " . ENTORNO);
	header("X-Powered-By: EdwinBetanc0urt <EdwinBetanc0urt@outlook.com>, entorno " . ENTORNO);

	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}

?>
