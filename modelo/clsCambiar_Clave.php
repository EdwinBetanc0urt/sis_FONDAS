<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

include_once('clsConexion.php');

class CambiarClave extends clsConexion {

	//variables de la tabla y clase
	private $atrTabla, $atrId_T, $atrClase;
	//atributos principales
	public $atrId, $atrNombre, $atrEstatus;
	//atributos que utiliza
	private $atrUsuario, $atrClave;


	/**
	 * constructor de la clase
	 * @param integer $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 3) {
		parent::__construct($piPrivilegio); //instancia al constructor padre
		$this->atrTabla = "tusuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase

		$this->atrUsuario = ""; //alias o login (comúnmente cédula)
		$this->atrClave = "";
		$this->atrFormulario = array();
	}



	function getClaveMax($idUsuario) {
		$sql = "
			SELECT MAX(idhistorial) AS clave_max
			FROM thistorial_clave
			Where
				id_usuario = '{$idUsuario}'; ";
		$claveMax = parent::getConsultaArreglo(parent::faEjecutar($sql));
		return $claveMax["clave_max"];
	}



	function fmCambiarClave() {
		parent::faTransaccionInicio();
		$objCifrado = new clsCifrado();
		$crypClave = $objCifrado->flEncriptar($this->atrFormulario["pswClave"]);
		unset($objCifrado);

		$sql = "UPDATE thistorial_clave
				SET
					estatus = '0'
				WHERE
					id_usuario = '{$_SESSION["id_usuario"]}' AND
					idhistorial = '{$this->getClaveMax()}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) { //verifica si se ejecuto bien
			$sql = "INSERT INTO thistorial_clave
						(clave, estatus, id_usuario)
					VALUES
						('{$crypClave}', 1 , '{$_SESSION["id_usuario"]}') ; ";
			$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
			if (parent::faVerificar($tupla)) { //verifica si se ejecuto bien
				parent::faTransaccionFin();
				return $tupla;
			}
			else {
				parent::faTransaccionDeshace();
				return false;
			}
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
	}



	function ConsultarRespuestas($idUsuario, $idPregunta) {
		$arrForm = $this->atrFormulario;
		$sql = "
			SELECT
				P.idpregunta, P.nombre AS pregunta,
				R.idrespuesta, R.nombre AS respuesta
			FROM
				tpregunta AS P, trespuesta AS R
			WHERE
				R.idpregunta = P.idpregunta AND
				(R.id_usuario = '{$idUsuario}' AND
				R.idpregunta = '{$idPregunta}')
			ORDER BY R.idrespuesta DESC
			LIMIT 1";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrConsulta["respuesta"]; //envía el arreglo
		}
		else
			return false;
	}



	function verificarRespuestas($idUsuario, $idPregunta1, $idPregunta2) {
		if ($this->ConsultarRespuestas($idUsuario, $idPregunta1) == $this->atrFormulario["ctxRespuesta1"]) {
			return true;
		}
		else {
			return false;
		}
		if ($this->ConsultarRespuestas($idUsuario, $idPregunta2) == $this->atrFormulario["ctxRespuesta2"]) {
			return true;
		}
		else {
			return false;
		}
	}



	//función utilizada para cambiar clave, consulta una matriz con
	//el historial de las ultimas claves según el rango establecido
	function fmConsultarClave($idUsuario) {
		$viRango = $this->getMaximoRangoClave();
		$sql = "
			SELECT *
			FROM thistorial_clave

			WHERE
				id_usuario = '{$idUsuario}'

			ORDER BY
				idhistorial DESC
			LIMIT $viRango; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			return $tupla; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}



	function cambiarClave(){
		$usuario = "";
		$mensaje = false;
		if (isset($_SESSION["id_usuario"])) {
			$usuario = $_SESSION["id_usuario"];
		}
		if (isset($this->atrFormulario["idu"])) {
			$usuario = $this->atrFormulario["idu"];
		}
		$rstClave = $this->fmConsultarClave($usuario);
		$rango = $this->getMaximoRangoClave();
		$crypClave = clsCifrado::getCifrar($_POST["pswClave"]);

		while ($arrClave = parent::getConsultaAsociativo($rstClave)) {
			if ($crypClave == $arrClave["clave"]) {
				$mensaje = "claverepetida" . $rango;
				return $mensaje;
			}
			else
				continue;
		}
		if ($this->fmCambiarClave())
			$mensaje = "clavecambio";
		else
			$mensaje = "clavenocambio";

		$this->faLiberarConsulta($rstClave); // libera de la memoria la consulta
		unset($rango, $crypClave);
	}



	function getPreguntas() {
		$sql = "
			SELECT U.id_usuario, P.nombre AS pregunta, P.idpregunta

			FROM
				tusuario AS U

			LEFT JOIN trespuesta as R
				ON R.id_usuario = U.id_usuario

			LEFT JOIN tpregunta AS P
				ON P.idpregunta = R.idpregunta


			WHERE
				U.id_usuario = '{$this->atrFormulario["idu"]}'

			ORDER BY
				P.idpregunta

			DESC

			LIMIT 1 ";
		if (isset($this->atrFormulario["nr"]) && $this->atrFormulario["nr"] != '') {
			$sql .= ", 1";
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}


	//función que selecciona el rango de claves para comparar y que no sean repetidas de forma seguida
	//se debe crear un objeto ya que el usuario de conexiona de esta clase no tiene acceso a la tabla de configuración
	function getMaximoRangoClave()  {
		return 5; //envia el valor guardado en la bd o uno por defecto que tiene la función
	}



} //cierre de la clase

?>
