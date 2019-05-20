<?php
/**
		ESTA LIBRERIA ESTÁ HECHA CON FINES ACADEMICOS, SU DISTRIBUCIÓN ES TOTALMENTE
	GRATUITA, BAJO LA LICENCIA GNU GPL v3 y CC BY-SA v4 Internacional, CUALQUIER,
	ADAPTACIÓN MODIFICACIÓN Y/O MEJORA QUE SE HAGA APARTIR DE ESTE CODIGO DEBE SER 
	NOTIFICADA Y ENVIADA A LA FUENTE, COMUNIDAD O REPOSITORIO DE LA CUAL FUE OBTENIDA
	Y/O A SUS CREADORES:
		* Edwin Betancourt 	EdwinBetanc0urt@hotmail.com
 		* Diego Chavez 		DJChvz18@gmail.com

		Características:
			* Obtiene el nombre del Dispositivo del que se accede.
			* Obtiene la Dirección IP versión 4 del que se accede.
			* Calcula la Dirección Física MAC mediante la IP v4.
			* Obtiene el nombre y versión del Navegador Web.
			* Obtiene el nombre y versión del Sistema Operativo.
*/

/** 
 * Agente Usuario, Datos del cliente Web
 *
 * @descripcion: Agente_User - clase PHP para obtener los datos del PC cliente 
 * @author: Edwin Betancourt <EdwinBetanc0urt@hotmail.com> 
 * @author: Diego Chavez <DJChvz18@gmail.com> 
 * @license: GNU GPL v3,  Licencia Pública General de GNU 3.
 * @license: CC BY-SA, Creative  Commons  Atribución  - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @category Librería.
 * @package: lib_Agente.php.
 * @since: v0.4.
 * @version: 0.5.
 * @Fecha de Modificacion: 02/Abril/2018
 * @Fecha de Creacion: 22/Enero/2017
 **/
class clsAgente
{

	//opera debe estar de primero ya que contiene variantes de chrome y safari
	public $arrNavegadores = array(
		'Opera' => 'opera',
		'Opera Mini' => 'opera mini',
		'Opera Mobile' => 'opera mobi',
		'Opera' => 'opr',

		'Microsoft Edge' => 'edge',
		'Microsoft Internet Explorer < 8-' => 'msie',
		'Microsoft Internet Explorer > 9+' => 'trident',
		'Microsoft Internet Explorer Mobile' => 'iemobile',

		'Mozilla Firefox' => 'firefox',
		'Google Chrome' => 'chrome',
		'Apple Safari' => 'safari',

		'Netscape' => 'netscape',
		'Chromium' => 'chromium'
	);

	public $arrOS_MS = array(
		'Microsoft Windows 10' => 'windows nt 10.0+',
		'Microsoft Windows 8.1' => 'windows nt 6.3+',
		'Microsoft Windows 8' => 'windows nt 6.2+',
		'Microsoft Windows 7' => 'windows nt 6.1+',
		'Microsoft Windows Vista' => 'windows nt 6.0+',
		'Microsoft Windows XP' => 'windows nt 5.1+',

		'Microsoft Windows 2000' => 'windows nt 5.0',
		'Microsoft Windows ME' => 'windows me',
		'Microsoft Windows ME' => 'win 9x 4.90',
		'Microsoft Windows 98' => 'win98',
		'Microsoft Windows 95' => 'win95',
		'Microsoft Windows NT 4.0' => 'winnt4.0',
		'Microsoft Windows 95' => 'win95',
		'Microsoft Windows Phone' => 'windows phone',
		'Microsoft Windows CE' => 'windows ce',

		'Microsoft Windows 2003 Server' => 'windows nt 5.2+',

		'Microsoft Windows' => 'windows otros'		
	);//Falta Miscrosoft 2012 y 2008 server

	public $arrOS_Apple = array(
		'iPhone' => 'iphone',
		'iPad' => 'ipad',
		'iPod' => 'ipod',
		'Mac OS X' => 'ppc',
		'Mac OS X' => 'cfnetwork+',
		'Mac OS X' => 'mac os x',
		'Mac otros' => 'macintosh'
	);

	public $arrOS_Otros = array(
		'Android' => 'android',
		'AIX' => 'aix',
		'BlackBerry' => 'blackBerry',
		'BeOS' => 'beos',
		
		'GNU/Linux Debian' => 'debian',
		'Elementary OS' => 'elementary os',
		'Free BSD' => 'freebsd',
		'GNU/Linux Fedora' => 'fedora',
		'Gentoo' => 'gentoo',
		'IRIX' => 'irix',
		'GNU/Linux Kubuntu' => 'kubuntu',

		'GNU/Linux Ubuntu' => 'ubuntu',
		'Slackware' => 'slackware',
		'GNU/Linux Mint' => 'linux mint',
		'OpenBSD' => 'openbsd',
		'NetBSD' => 'NetBSD',
		'Firefox OS' => 'Mobile',

		'GNU/Linux' => 'linux',

		'Nintendo' => 'nintendo',
		'Sony PlayStation 3' => 'playstation 3',
		'Sony PlayStation Portable' => 'psp',
		'Sony PlayStation Portable' => 'playstation portable',
		'OS/2' => 'os/2',

		'SunOS' => 'sunos',
		'Symbian' => 'symbian',
		'webOS' => 'webos'
	); //Falta CHROME OS



	function __construct()
	{
		$this->atrAgente_U = strtolower($_SERVER['HTTP_USER_AGENT']);
	} //cierre del constructor



	/**
	 * DIDPOSITIVO REMOTO
	 */
	function getNombreServidor()
	{
		return gethostname();
	} //cierre de la funcion




	/**
	 * Obtiene el nombre del host mediante la IP 
	 * @param string $psIP, de la IP Adress
	 * @return string nombre del Dispositivo Remoto
	 */
	function getNombreCliente($psIP = "")
	{
		if ($psIP == "") {
			$psIP = $this->getIPv4();
		}
		elseif (isset($_SERVER["REMOTE_ADDR"])) {
			$psIP = $_SERVER["REMOTE_ADDR"];
		}
		return gethostbyaddr($psIP);
	} //cierre de la funcion



	function getSistemaOperativo()
	{
		//Microsoft
		if (strpos($this->atrAgente_U, 'win') !== FALSE) {
			$arrSO = $this->arrOS_MS; //arreglo Sistema Operativo = arreglo Miscrosoft
		}
		//Apple
		elseif (strpos($this->atrAgente_U, 'ip') !== FALSE || strpos($this->atrAgente_U, 'mac') !== FALSE) {
		//elseif (strpos($this->atrAgente_U, 'mac') !== FALSE)
			$arrSO = $this->arrOS_Apple; //arreglo Sistema Operativo = arreglo Apple
		}
		//Otras Plataformas
		else {
			$arrSO = $this->arrOS_Otros; //arreglo Sistema Operativo = arreglo Otros
		}

		foreach($arrSO as $arrSistemas => $patron) {
			//if (eregi($patron, $this->atrAgente_U)) {
			if (preg_match("/".$patron."/i", $this->atrAgente_U, $arrCoincidencia)) {
				return $arrSistemas;
			}
		}
		return 'Sistema Operativo desconocido';
	} //cierre de la funcion



	/**
	 * Calcula y devuelve la MAC Adress a traves de la IP recibida u obtenida
	 * @param string $psIP, de la IP Adress para calcular la MAC Adress
	 * @return string $spLine o bool de la MAC Adress o Direccion Fisica
	 */
	function getMAC_Address($psIP = "")
	{
		// This code is under the GNU Public Licence
		// Written by michael_stankiewicz {don't spam} at yahoo {no spam} dot com
		// Tested only on linux, please report bugs

		// WARNING: the commands 'which' and 'arp' should be executable
		// by the apache user; on most linux boxes the default configuration
		// should work fine

		// Get the arp executable path
		$location = `which arp`;
		// Execute the arp command and store the output in $arpTable
		$arpTable = `arp -a`;
		// Split the output so every line is an entry of the $arpSplitted array
		$arpSplitted = explode("\\n", $arpTable);

		// Get the remote ip address (the ip address of the client, the browser)
		if ($psIP == "")
			$remoteIp = getenv('REMOTE_ADDR');
		else
			$remoteIp = $psIP;

		// Cicle the array to find the match with the remote ip address
		foreach ($arpSplitted as $value) {
			// Split every arp line, this is done in case the format of the arp
			// command output is a bit different than expected
			$valueSplitted = explode(" ", $value);
			foreach ($valueSplitted as $spLine) {
				if (preg_match("/$remoteIp/", $spLine)) {
					$ipFound = true;
				}
				// The ip address has been found, now rescan all the string
				// to get the mac address
				if (isset($ipFound)) {
					// Rescan all the string, in case the mac address, in the string
					// returned by arp, comes before the ip address
					// (you know, Murphy's laws)
					reset($valueSplitted);
					foreach ($valueSplitted as $spLine) {
						if (preg_match("/[0-9a-f][0-9a-f][:-]".
							"[0-9a-f][0-9a-f][:-]".
							"[0-9a-f][0-9a-f][:-]".
							"[0-9a-f][0-9a-f][:-]".
							"[0-9a-f][0-9a-f][:-]".
							"[0-9a-f][0-9a-f]/i", $spLine)) {
							return $spLine;
						}
					}
				}
				$ipFound = false;
			}
		}
		return false;
	} //cierre de la funcion


	function getNavegador()
	{
		$vsNavegadorCompleto  = "desconocido";
		$vsNavegadorCorto = "desconocido";
		foreach($this->arrNavegadores as $vsClave => $vsValor) {
			//if (eregi($vsValor, $this->atrAgente_U)) {
			//if (preg_match($vsValor, $this->atrAgente_U)) {
			if (preg_match("/".$vsValor."/i", $this->atrAgente_U)) {
				$vsNavegadorCompleto = $vsClave;
				$vsNavegadorCorto = $vsValor;
				break;
			}
		}

		// finalmente obtener el número de versión correcta
		$vsConocido = array('Version', $vsNavegadorCorto, 'other');
		$vsPatron = '#(?<browser>' . join('|', $vsConocido) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	
		if (!preg_match_all($vsPatron, $this->atrAgente_U, $arrCoincidencia)) {
			//no tenemos ningún número coincidente
			//genera el arreglo $arrCoincidencia
			// continue;
		}
	
		// ver cuántos tenemos
		//$i = count($arrCoincidencia['browser']);
		//if ($i != 1) {
		if (count($arrCoincidencia['browser']) != 1) {
			//tendremos dos ya que no estamos usando el argumento 'other' todavía
			//ver si la versión es antes o después del nombre
			if (strripos($this->atrAgente_U, "Version") < strripos($this->atrAgente_U, $vsNavegadorCorto)) {
				$version = $arrCoincidencia['version'][0];
			}
			else {
				$version = $arrCoincidencia['version'][1];
			}
		}

		else {
			$version= $arrCoincidencia['version'][0];
		}

		// verifica si tenemos un número
		if ($version == null || $version == "") {
			$version = "?";
		}

		$arrNavegador = array(
			'navegador' => $vsNavegadorCompleto,
			'navegador_corto' => $vsNavegadorCorto,
			'version' => $version,
			'navegador_version' => $vsNavegadorCompleto . " v" . $version
		);
		return $arrNavegador;
	} //cierre de la funcion



	function getIPv4()
	{
		if (isset($_SERVER)) {

			if (isset($_SERVER["HTTP_CLIENT_IP"])) {
				return $_SERVER["HTTP_CLIENT_IP"]; //IP origen en conexiones compartidas y Varnish
			}

			elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				return $_SERVER["HTTP_X_FORWARDED_FOR"]; //IP origen haciendo uso de proxy
			}

			elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
				return $_SERVER["HTTP_X_FORWARDED"];
			}

			elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
				return $_SERVER["HTTP_FORWARDED_FOR"];
			}

			elseif (isset($_SERVER["HTTP_FORWARDED"])) {
				return $_SERVER["HTTP_FORWARDED"];
			}

			else {
				return $_SERVER["REMOTE_ADDR"];
			}
		}	

		else {
			if (isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])) {
				return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
			}
			else {
				return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
			}
		}
	} //cierre de la funcion


	function getIPv4_2()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] :
				((!empty($_ENV['REMOTE_ADDR'])) ? $_ENV['REMOTE_ADDR'] :
					"unknown");
			// los proxys van añadiendo al final de esta cabecera
			// las direcciones ip que van "ocultando". Para localizar la ip real
			// del usuario se comienza a mirar por el principio hasta encontrar
			// una dirección ip que no sea del rango privado. En caso de no
			// encontrarse ninguna se toma como valor el REMOTE_ADDR

			$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries)) {
				$entry = trim($entry);
				if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) {
					// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array(
					'/^0\./',
					'/^127\.0\.0\.1/',
					'/^192\.168\..*/',
					'/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
					'/^10\..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip) {
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else {
			$client_ip =
				(!empty($_SERVER['REMOTE_ADDR'])) ?
				$_SERVER['REMOTE_ADDR']
				:
				((!empty($_ENV['REMOTE_ADDR'])) ?
					$_ENV['REMOTE_ADDR']
					:
					"unknown");
		}

		return $client_ip;
	} //cierre de la funcion

} //cierre de la clase

?>
