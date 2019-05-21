<?php
include_once('clsConexion.php');

class Login extends clsConexion {

	public $id_usuario, $idpersona, $usuario, $clave, $pre1, $resp1, $pre2, $resp2;
	public $tipo, $idhistorial;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		$this->atrId = "";
		$this->atrUsuario = ""; //alias o login
		$this->atrClave = "";
	}

	//función para recibir y sanear los datos del controlador
	//Usado por el controlador del Login
	function setUsuario($pcUsuario)
	{
		$this->atrUsuario = htmlentities(trim(strtolower($pcUsuario)));
	}

	//función para recibir y sanear los datos del controlador
	//Usado por el controlador del Login
	function setClave($pcClave)
	{
		$this->atrClave = htmlentities(trim(strtolower($pcClave)));
	}

	function Bitacora($piId_Usuario)
	{
		$id = false;
		$objAgente = new clsAgente();
		$arrNavegador = $objAgente->getNavegador();
		$NavegadorWeb = $arrNavegador['navegador_version'];
		$sql = "
			INSERT INTO
				tbitacora (
					fecha, so, navegador, ip,
					usuario_aplicacion
				)
				VALUES (
					CURRENT_TIMESTAMP(), '{$objAgente->getSistemaOperativo()}',
					'{$NavegadorWeb}', '{$objAgente->getIPv4()}',
					'{$piId_Usuario}'
				) ; ";
		unset($objAgente);
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla))
			return $tupla; //retorna el id de la sesión
		else
			return false;
	} //cierre de la función

	//funcion.modelo.Consultar
	function ConsultarUsuario()
	{
		$sql = "SELECT * FROM tusuario
				WHERE usuario = '{$this->atrUsuario}'
				LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}

	//funcion.modelo.Consultar
	function ConsultarClave($pcId)
	{
		$sql = "SELECT * FROM thistorial_clave
				WHERE
					id_usuario = '{$pcId}'
				ORDER BY idhistorial DESC
				LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent:: faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}

	/**
	 * Busca los datos de una persona
	 * @param integer $piId_Persona, clave foránea en usuario que debe ser igual a la clave principal en persona
	 */
	function fmConsultarPersona($piId_Persona)
	{
		$sql = "SELECT  P.*, U.idtipo_usuario
			FROM vpersona AS P

			LEFT JOIN tusuario AS U
				ON P.id_usuario = U.id_usuario

			WHERE
				P.id_usuario = '{$piId_Persona}'
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}

	function fmContadorIntentos()
	{
		$sql = "SELECT intento_fallido
			FROM tusuario
			WHERE usuario = '{$this->atrUsuario}'
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla)) {
			$arrIntento = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrIntento[0];
		}
		else
			return 3;
	}

	function fmIntentoErroneo()
	{
		$sql = "
			UPDATE
				tusuario
			SET
				intento_fallido = intento_fallido + 1
			WHERE
				usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql, false);
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

	function fmReiniciaIntento()
	{
		$sql = "
			UPDATE
				tusuario
			SET
				intento_fallido = 0
			WHERE
				usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql, false);
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

	function fmBloqueoUsuario()
	{
		$sql = "
			UPDATE
				tusuario
			SET
				estatus = '0'
			WHERE
				usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql, false);
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

	// se debe crear un método ya que el usuario de conexión de esta clase no 
	// tiene acceso a la tabla de configuración
	function getDiasCaducidad()
	{
		$sql = "
			SELECT dias_vence_clave
			FROM tconfiguracion

			ORDER BY idconfiguracion ASC
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		// verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla); // libera de la memoria el resultado asociado a la consulta
			return $arrConsulta[0]; // por defecto incluido en la bd es 90 días o 3 meses
		}
		else
			return 91; // retorna un valor por defecto
	} // cierre de la función

	public function traer_codigo()
	{
		return parent::ejecutar("SELECT MAX(id_usuario) AS id_usuario  FROM tusuario");
	}

	public function traer_codigos()
	{
		return parent::ejecutar("SELECT MAX(idhistorial) AS idhistorial  FROM thistorial_clave");
	}

	 public function historial($id)
	 {
 		return parent::ejecutar('SELECT idhistorial, id_usuario,DATE_FORMAT(ultima_actividad,  "%d-%m-%Y %h:%i:%S") AS fecha FROM  thistorial_clave WHERE
 			idhistorial='.$id.' ORDER BY ultima_actividad DESC LIMIT 0,5');
	}

}

?>
