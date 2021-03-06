<?php
include_once('clsConexion.php');

class RecuperarClave extends clsConexion {

	//variables de la tabla y clase
	private $atrTabla, $atrId_T, $atrClase;
	//atributos principales
	public $atrId, $atrNombre, $atrEstatus;
	//atributos que utiliza
	private $atrUsuario, $atrClave;


	/**
	 * constructor de la clase
	 * @param ineger $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 3)
	{
		parent::__construct($piPrivilegio); //instancia al constructor padre
		$this->atrTabla = "tusuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase
		$this->atrUsuario = ""; //alias o login (comunmente cedula)
		$this->atrClave = "";
		$this->atrFormulario = array();
	}

	function fmRecuperarClave()
	{
		parent::faTransaccionInicio();
		$crypClave = clsCifrado::getCifrar($this->atrFormulario["pswClave"]);

		$sql = "SELECT MAX(idhistorial) AS clave_max
				FROM thistorial_clave
				Where id_usuario = '{$this->atrId}' ; ";
		$arrClaveMax = parent::getConsultaArreglo(parent::faEjecutar($sql));

		$sql = "UPDATE thistorial_clave
				SET  estatus = '0'
				WHERE
					id_usuario = '{$this->atrId}' AND
					idhistorial = '{$arrClaveMax["clave_max"]}' ; ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) { //verifica si se ejecuto bien
			$sql = "INSERT INTO thistorial_clave
						(clave, estatus, id_usuario)
					VALUES
						('{$crypClave}', 1, '{$this->atrId}') ; ";
			$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
			if ($tupla) { //verifica si se ejecuto bien
				parent::faTransaccionFin();
				return $tupla;
			}
			parent::faTransaccionDeshace();
			return false;
		}
		parent::faTransaccionDeshace();
		return false;
	}

	function Consultar()
	{
		$arrForm = $this->atrFormulario;
		$sql = "
			SELECT
				U.id_usuario, U.usuario,  P.idpregunta,
				P.nombre AS pregunta, R.idrespuesta, R.nombre AS respuesta
			FROM
				tusuario AS U, tpregunta AS P, trespuesta AS R
			WHERE
				(R.id_usuario = U.id_usuario AND
				R.idpregunta = P.idpregunta) AND
				(U.usuario = '{$arrForm['ctxUsuario']}' AND
				R.idpregunta = '{$arrForm['cmbPregunta']}') ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ($tupla) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrConsulta; //envia el arreglo
		}
		return $tupla;
	}

	function Consultar2()
	{
		$arrForm = $this->atrFormulario;
		$sql = "
			SELECT
				U.usuario, U.id_usuario, P.idpregunta,
				P.nombre AS pregunta, R.idrespuesta, R.nombre AS respuesta
			FROM
				tusuario AS U, tpregunta AS P, trespuesta AS R
			WHERE
				(R.id_usuario = U.id_usuario AND
				R.idpregunta = P.idpregunta) AND
				(U.usuario = '{$arrForm['ctxUsuario']}' AND
				R.idpregunta = '{$arrForm['cmbPregunta2']}') ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ($tupla) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrConsulta; //envia el arreglo
		}
		return $tupla;
	}

	//funcion utilizada para cambiar clave, consulta una matriz con
	//el historial de las ultimas claves segun el rango establecido
	function fmConsultarClave()
	{
		$viRango = $this->getMaximoRangoClave();
		$sql = "
			SELECT *
			FROM thistorial_clave

			WHERE
				id_usuario = {$this->atrId}

			ORDER BY
				idhistorial DESC
			LIMIT $viRango ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ($tupla) {
			return $tupla; //retorna los datos obtenidos de la bd en un arreglo
		}
		return $tupla;
	}

	//funcion que selecciona el rango de claves para comparar y que no sean repetidas de forma seguida
	//se debe crear un objeto ya que el usuario de conexion de esta clase no tiene acceso a la tabla de configuracion
	function getMaximoRangoClave()
	{
		return 5; //envia el valor guardado en la bd o uno por defecto que tiene la funcion
	}

} //cierre de la clase

?>
