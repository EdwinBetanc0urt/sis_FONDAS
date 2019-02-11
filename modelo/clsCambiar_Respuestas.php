<?php

session_start();

include_once('clsConexion.php');

class CambiarRespuestas extends clsConexion {

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
	function __construct($piPrivilegio = 3) {
		parent::__construct($piPrivilegio); //instancia al constructor padre
		$this->atrTabla = "tusuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase
		
		$this->atrUsuario = ""; //alias o login (comunmente cedula)
		$this->atrClave = "";
		$this->atrFormulario = array();
	}



	public function setFormulario($pcForm) {
		foreach ($pcForm as $clave => $valor) {
			//$clave_new = substr($clave, 3);
			$clave_new = $clave ;

			if(is_array($pcForm[$clave])) {
				$this->atrFormulario[$clave_new] = $this->sanearFormulario($pcForm[$clave]);
			}

			else {
				if ($valor == "")
					$this->atrFormulario[$clave_new] = "NULL";
				else {
					$valor = htmlentities($valor, ENT_QUOTES | ENT_HTML5, "UTF-8");
					$this->atrFormulario[$clave_new] = trim($valor);
				}
			}
		}
	}
	public function sanearFormulario($pcForm) {
		$arrFormulario = array();
		foreach ($pcForm as $clave => $valor) {
			//$clave_new = substr($clave, 3);
			$clave_new = $clave ;
			if(is_array($pcForm[$clave])) 
				$arrFormulario = $this->sanearFormulario($pcForm[$clave]);
			
			else {
				if ($valor == "")
					$arrFormulario[$clave_new] = "NULL";
				else {
					$valor = htmlentities($valor, ENT_QUOTES | ENT_HTML5, "UTF-8");
					$arrFormulario[$clave_new] = trim($valor);
				}
			}
		}
		return $arrFormulario;
	}

	//funcion.modelo.Insertar
	function InsertarRespuestas() {
		//$respuesta_encriptada = "" ;
		$liError = 0 ;
		//$objCifrado = new clsCifrado(); //instancia el objeto de cifrado
		
		//ciclo del 1 al 5 que son los name que exiten en la vista (ctxRespuesta1-5 y cmbPregunta1-5)
		for ($i = 1 ; $i <= 2 ; $i++) {

			//$respuesta_encriptada = $objCifrado->flEncriptar($this->atrFormulario["ctxRespuesta" . $i]);
			$sql = "INSERT INTO trespuesta
						(nombre, id_usuario, idpregunta)
					VALUES
						('{$this->atrFormulario["ctxRespuesta" . $i]}',
						'{$_SESSION["id_usuario"]}',
						'" . $this->atrFormulario["cmbPregunta" . $i] . "') ; ";
			$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
			if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
				continue; //continua el ciclo for
			else
				$liError = $liError + 1;
		}
		//unset($objCifrado); //destruye el objeto de creado
		if ($liError == 0) {
			echo "si pregunta";
			return true;
		}
		else
			return false;
	}



	//funcion utilizada para cambiar clave, consulta una matriz con
	//el historial de las ultimas claves segun el rango establecido
	function fmConsultarClave() {
		$sql = "
			SELECT * 
			FROM thistorial_clave
				
			WHERE 
				id_usuario = '{$_SESSION["id_usuario"]}'
				
			ORDER BY 
				idhistorial DESC
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			return $tupla; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return $sql;
	}


} //cierre de la clase

?>