<?php

/** 
 * Cifrar y Descifrar Valores
 *
 * @descripcion: Clase PHP para cifrar y descifrar datos 
 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com> 
 * @license: GNU GPL v3,  Licencia Pública General de GNU 3.
 * @license: CC BY-SA, Creative  Commons  Atribución  - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @category Librería 
 * @package: lib_Cifrado.php 
 * @since: v0.3
 * @version: 0.9
 * @Fecha de Modificación: 29/Julio/2018
 * @Fecha de Creación: 15/Marzo/2016

		Este programa es software libre, su uso, redistribución, y/o modificación
	debe ser bajo los términos de las licencias indicadas, la GNU Licencia Pública
	General (GPL) publicada por la Fundación de Software Libre(FSF) de la versión
	3 o cualquier versión posterior y la Creative Commons Atribución - Compartir
	Igual (CC BY-SA) de la versión 4.0 Internacional o cualquier versión posterior.

		Este software esta creado con propósitos generales que sean requeridos,
	siempre que este sujeto a las licencias indicadas, pero SIN NINGUNA GARANTÍA
	Y/O RESPONSABILIDAD que recaiga a los creadores, autores y/o desarrolladores,
	incluso sin la garantía implícita de COMERCIALIZACIÓN o IDONEIDAD PARA UN
	PROPÓSITO PARTICULAR. Cualquier MODIFICACIÓN, ADAPTACIÓN Y/O MEJORA	que se haga
	a partir de este código debe ser notificada y enviada a la fuente, comunidad
	o repositorio de donde fue obtenida, y/o a sus AUTORES.
 **/

/**
	Características:
		* Cifra un texto utilizando un algoritmo en combinación con una clave privada.
		* Descifra un texto utilizando un algoritmo siempre que el clave privada con
		  el que se cifró sea el mismo.
*/



class clsCifrado
{

	/**
	 * @desc nombre del usuario de la base de datos
	 * @var str $atrServidor
	 * @access private
	 */
	const csMETODO = "AES-256-CBC";

	/**
	 * @desc nombre del usuario de la base de datos
	 * @var str $atrServidor
	 * @access private
	 */
	const csHASH = "sha512";

	/**
	 * @desc nombre del usuario de la base de datos
	 * @var str $atrServidor
	 * @access private
	 */
	const csKEY = "*informatica$";

	/**
	 * @desc nombre del usuario de la base de datos
	 * @var str $atrTexto
	 * @access protected
	 */
	protected $atrTexto; //atributo.Texto.Encriptado

	/**
	 * @desc nombre del usuario de la base de datos
	 * @var str $atrKey
	 * @access public
	 */
	static private $atrKey;



	/**
	 * constructor de la clase
	 *
	 * @param string $psTexto, contiene la cadena de texto
	 * @param string $psKey, contiene la llave o clave para encriptado de esa clave
	 */
	function __construct($psTexto = "", $psKey = "")
	{
		$this->atrTexto = trim($psTexto); //elimina espacios al comienzo y final

		//debe usarse para descifrar la misma llave con la que se cifro ese texto
		if ($psKey != ""){
			self::$atrKey = trim($psKey); //asigna llave maestra de codificación enviada
		}

		//si no se indica el constructor se debe asignar una llave maestra o clave privada a atrKey
		else {
			//$this->atrKey = parent::faLLaveMaestra(); //asigna llave maestra de codificación predeterminada
			self::$atrKey = self::csKEY; //asigna llave maestra de codificación predeterminada
		}
	} //cierre de la función constructor



	/**
	 * Para un inicio de vector fácil, MD5 salto de nuevo
	 *
	 * @return string $vsVectorInicio
	 */
	static function _getIv()
	{
		//tamaño del vector de inicio
		$ivlen = openssl_cipher_iv_length(self::csMETODO);

		$vsVectorInicio = substr(
			md5(self::getSalto()),
			0,
			$ivlen
		);

		return $vsVectorInicio;
	} //cierre de la función



	/**
	 * Obtiene el salto del hash como clave
	 *
	 * @return string $vsKey
	 */
	static function getSalto()
	{
		if (self::$atrKey == "" OR self::$atrKey == NULL) {
			self::$atrKey = self::csKEY;
		}
		
		$vsKey = hash(
			self::csHASH, 
			self::$atrKey
		);

		return $vsKey;
	} //cierre de la función



	/**
	 * función estática Cifrar Asigna el parámetro al atributo TextoE convierte
	 * el texto enviado y lo encripta, utilizando la llave privada
	 *
	 * @param string, $psTexto
	 * @return string $vsTextoCifrado
	 */
	static function getCifrar($psTexto)
	{
		$vsTextCifrado = openssl_encrypt(
			$psTexto,
			self::csMETODO, 
			self::getSalto(), 
			OPENSSL_RAW_DATA, 
			self::_getIv()
		);

		//codifica con base 64 el texto cifrado
		$vsTextCifrado = base64_encode($vsTextCifrado);

		return $vsTextCifrado;
	} //cierre de la función



	/**
	 * función librería Encriptar Asigna el parámetro al atributo TextoE
	 *
	 * @param string, $psTexto
	 * @return string, convierte el texto enviado y lo encripta, utilizando la llave privada
	 */
	public function _getCifrar($psTexto = "")
	{
		if ($psTexto == ""){
			$psTexto = $this->atrTexto;
		}

		return self::getCifrar($psTexto);
	} //cierre de la función



	/**
	 * función librería Descifrar Asigna el parámetro al atributo TextoE
	 *
	 * @param string, $psTexto 
	 * @return string, convierte el texto enviado y lo descifra, usando el algoritmo de encriptado al inverso
	 */
	static function getDescifrar($psTexto)
	{
		//descodifica el texto cifrado de base 64.
		$vsTextDescifrado = base64_decode($psTexto, TRUE);

		//descifra el texto
		$vsTextDescifrado = openssl_decrypt(
			$vsTextDescifrado, 
			self::csMETODO, 
			self::getSalto(), 
			OPENSSL_RAW_DATA,
			self::_getIv()
		);

		//recorta los espacios en blanco desde el final.
		$vsTextDescifrado = rtrim(
			$vsTextDescifrado,
			'\0'
		);

		return $vsTextDescifrado;
	} //cierre de la función



	/**
	 * función librería Descifrar Asigna el parámetro al atributo TextoE
	 *
	 * @param string, $psTexto 
	 * @return string, convierte el texto enviado y lo Descifra, usando el algoritmo de encriptado al inverso
	 */
	public function _getDescifrar($psTexto = "")
	{
		if ($psTexto == ""){
			$psTexto = $this->atrTexto;
		}

		return self::getDescifrar($psTexto);
	} //cierre de la función



} //cierre de la clase



/*

//EJEMPLOS DE USOS


//1 - usando los métodos estáticos
$texto = "Texto que se quiere cifrar.";
echo clsCifrado::getDescifrar($texto);
//la salida seria algo como: JZw86xAyru8We++0Lp2jQvbJdNHLNidztfZ3T5rt1G8=

//echo "<hr>";

//2 - instanciando la clase
$texto2 = "JZw86xAyru8We++0Lp2jQvbJdNHLNidztfZ3T5rt1G8=";
$objCifrado = new clsCifrado($texto2);
echo $objCifrado->_getDescifrar();
//la salida seria algo como: Texto que se quiere cifrar.

//*/

?>
