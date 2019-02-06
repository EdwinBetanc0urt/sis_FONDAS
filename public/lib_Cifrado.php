<?php

/** 
 * Encritar y Desencriptar Valores
 *
 * @descripcion: Encriptador - clase PHP para cifrar y desifrar datos 
 * @author: Edwin Betancourt <EdwinBetanc0urt@hotmail.com> 
 * @author: Diego Chavez <DJChvz18@gmail.com> 
 * @license: GNU GPL v3,  Licencia Pública General de GNU 3.
 * @license: CC BY-SA, Creative  Commons  Atribución  - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @category Librería 
 * @package: lib_Cifrado.php 
 * @since: v0.3
 * @version: 0.8
 * @Fecha de Modificacion: 02/Abril/2017
 * @Fecha de Creacion: 15/Marzo/2016
 **/


/**
		ESTA LIBRERIA ESTÁ HECHA CON FINES ACADEMICOS, SU DISTRIBUCIÓN ES TOTALMENTE
	GRATUITA, BAJO LA LICENCIA GNU GPL v3 y CC BY-SA v4 Internacional, CUALQUIER,
	ADAPTACIÓN MODIFICACIÓN Y/O MEJORA QUE SE HAGA APARTIR DE ESTE CODIGO DEBE SER 
	NOTIFICADA Y ENVIADA A LA FUENTE, COMUNIDAD O REPOSITORIO DE LA CUAL FUE OBTENIDA
	Y/O A SUS CREADORES:
		* Edwin Betancourt 	EdwinBetanc0urt@hotmail.com
 		* Diego Chavez 		DJChvz18@gmail.com

		Características:
			* Encripta un texto utilizando un algoritmo en combinación con una key privada.
			* Desencripta un texto utilizando un algoritmo siempre que el key privada con
			  el que se encripto sea el mismo.
*/



// Archivo obligatorio que a su vez hace un llamado a una key privada
//require_once("../../modelo/general/cls_Conexion.php");

class clsCifrado /*extends clsConexion */
{

	private $atrKey; //atributo.Key privada
	protected $atrTexto; //atributo.Texto.Encriptado
	const csKEY = "informatica";


	/**
	 * //constructor de la clase
	 * @param string $psTexto, contiene la cadena de texto
	 * @param string $psKey, contiene la llave o key para encriptado de esa clave
	 */
	function __construct($psTexto = "", $psKey = "")
	{
		//llamado al constructor padre, parametro de tipo de privilegio
		//que incluye el archivo con el hash de encriptado
		//$this->clsConexion(2); 

		$this->atrTexto = trim($psTexto); //elimina espacios al comienzo y final

		//debe usarse para desencriptar la misma llave con la que se encripto ese texto
		if ($psKey != "")
			$this->atrKey = trim($psKey); //asigna llave maestra de codificacion enviada
		//si no se indica el constructor se debe asignar una llave maestra o key privada a atrKey
		else {
			//$this->atrKey = parent::faLLaveMaestra(); //asigna llave maestra de codificacion predeterminada
			$this->atrKey = self::flKeyPrivada(); //asigna llave maestra de codificacion predeterminada
		}
	} //cierre del constructor



	/**
	 * @return string $vsKey, contiene el texto que asigna al atributo $this->atrKey la llave de enciptacion/desencriptacion
	 */
	private function flKeyPrivada() 
	{
		//Archivo hace un llamado a una key privada
		$vsKey = "informatica";
		return $vsKey;
	}



	/**
	 * Asigna el parametro al atributo Texto, $atrTexto
	 * @param string $psTexto, contiene el texto que asigna al atributo
	 */
	public function setDato($psTexto)
	{
		$this->atrTexto = trim($psTexto); //asigna el valor del parametro al atriburo de texto desencriptado
	}



	/**
	 * funcion libreria Encriptar
	 * Asigna el parametro al atributo TextoE
	 * @param string, $psTexto
	 * @return string, convierte el texto enviado y lo encripta, utilizando la llave privada
	 */
	public function flEncriptar($psTexto)
	{
		$this->atrTexto = trim($psTexto); //elimina espacios al comienzo y final
		$texto_encriptado = base64_encode(
			mcrypt_encrypt(
				MCRYPT_RIJNDAEL_256,
				md5(
					$this->atrKey
				),
				$this->atrTexto,
				MCRYPT_MODE_CBC,
				md5(
					md5(
						$this->atrKey
					)
				)
			)
		);
		return $texto_encriptado; //Devuelve el $texto encriptado
	}


	/**
	 * función estática Cifrar Asigna el parámetro al atributo TextoE convierte
	 * el texto enviado y lo encripta, utilizando la llave privada
	 *
	 * @param string, $psTexto
	 * @return string $vsTextoCifrado
	 */
	static function getCifrar($psTexto)
	{
		$Texto = trim($psTexto); //elimina espacios al comienzo y final
		$vsTextCifrado = base64_encode(
			mcrypt_encrypt(
				MCRYPT_RIJNDAEL_256,
				md5(
					self::csKEY
				),
				$Texto,
				MCRYPT_MODE_CBC,
				md5(
					md5(
						self::csKEY
					)
				)
			)
		);
		return $vsTextCifrado; //Devuelve el $texto encriptado
	} //cierre de la función
 

	/**
	 * función estática Cifrar Asigna el parámetro al atributo TextoE convierte
	 * el texto enviado y lo encripta, utilizando la llave privada
	 *
	 * @param string, $psTexto
	 * @return string $vsTextoCifrado
	 */
	static function getDescifrar($psTexto)
	{
		$Texto = trim($psTexto); //elimina espacios al comienzo y final
		$vsTextDescifrado = rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_256,
				md5(
					self::csKEY
				),
				base64_decode(
					$Texto
				),
				MCRYPT_MODE_CBC,
				md5(
					md5(
						self::csKEY
					)
				)
			),
			"\0"
		);
		return $vsTextDescifrado;  //Devuelve el $texto desencriptado

		//var_dump(self::flKeyPrivada());
		$Texto = trim($psTexto); //elimina espacios al comienzo y final
		$vsTextCifrado = base64_encode(
			mcrypt_encrypt(
				MCRYPT_RIJNDAEL_256,
				md5(
					self::csKEY
				),
				$Texto,
				MCRYPT_MODE_CBC,
				md5(
					md5(
						self::csKEY
					)
				)
			)
		);
		return $vsTextCifrado; //Devuelve el $texto encriptado
	} //cierre de la función


	/**
	 * funcion libreria Desencriptar 
	 * Asigna el parametro al atributo TextoE
	 * @param string, $psTexto 
	 * @return string, convierte el texto enviado y lo desencripta, usando el algoritmo de encriptado al inverso
	 */
	public function flDesencriptar($psTexto)
	{
		$this->atrTexto = trim($psTexto); //elimina espacios al comienzo y final
		$texto_desencriptado = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->atrKey), base64_decode($this->atrTexto), MCRYPT_MODE_CBC, md5(md5($this->atrKey))), "\0");
		return $texto_desencriptado;  //Devuelve el $texto desencriptado
	}



	/**
	 * Asigna el parametro al atributo TextoE
	 * @return string, convierte el texto encriptado a uno desencriptado
	 */
	public function getDesencriptado()
	{
		return $this->flDesencriptar($this->atrTexto); //devuelve el valor desencriptado
	}



	/**
	 * Asigna el parametro al atributo TextoE
	 * @return string, convierte el texto desencriptado a uno encriptado
	 */
	public function getEncriptado()
	{
		return $this->flEncriptar($this->atrTexto); //devuelve el valor encriptado
	}

} //cierre de la clase



define('METHOD','AES-256-CBC');
define('SECRET_KEY','$CARLOS@2016');
define('SECRET_IV','101712');
class SED
{
	public static function encryption($string)
	{
		$output=FALSE;
		$key=hash('sha256', SECRET_KEY);
		$iv=substr(hash('sha256', SECRET_IV), 0, 16);
		$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output=base64_encode($output);
		return $output;
	} //cierre de la funcion

	public static function decryption($string)
	{
		$key=hash('sha256', SECRET_KEY);
		$iv=substr(hash('sha256', SECRET_IV), 0, 16);
		$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	} //cierre de la funcion

} //cierre de la calse



?>
