<?php

session_start();

include_once('clsConexion.php');

class CambiarClave extends clsConexion {

	//variables de la tabla y clase
	private $atrTabla , $atrId_T , $atrClase;
	//atributos principales
	public $atrId , $atrNombre , $atrEstatus;
	//atributos que utiliza
	private $atrUsuario , $atrClave;


	/**
	 * constructor de la clase
	 * @param ineger $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct( $piPrivilegio = 3 ) {
		parent::__construct( $piPrivilegio ); //instancia al constructor padre
		$this->atrTabla = "tusuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase
		
		$this->atrUsuario = ""; //alias o login (comunmente cedula)
		$this->atrClave = "";
		$this->atrFormulario = array();
	}



	public function setFormulario( $pcForm ) {
		foreach ( $pcForm as $clave => $valor ) {
			//$clave_new = substr( $clave , 3 );
			$clave_new = $clave ;

			if( is_array( $pcForm[$clave] ) ) {
				$this->atrFormulario[$clave_new] = $this->sanearFormulario( $pcForm[$clave] );
			}

			else {
				if ( $valor == "" )
					$this->atrFormulario[$clave_new] = "NULL";
				else {
					$valor = htmlentities( $valor , ENT_QUOTES | ENT_HTML5 , "UTF-8" );
					$this->atrFormulario[$clave_new] = trim( $valor );
				}
			}
		}
	}
	public function sanearFormulario( $pcForm ) {
		$arrFormulario = array();
		foreach ( $pcForm as $clave => $valor ) {
			//$clave_new = substr( $clave , 3 );
			$clave_new = $clave ;
			if( is_array( $pcForm[$clave] ) ) 
				$arrFormulario = $this->sanearFormulario( $pcForm[$clave] );
			
			else {
				if ( $valor == "" )
					$arrFormulario[$clave_new] = "NULL";
				else {
					$valor = htmlentities( $valor , ENT_QUOTES | ENT_HTML5 , "UTF-8" );
					$arrFormulario[$clave_new] = trim( $valor );
				}
			}
		}
		return $arrFormulario;
	}



	function CambiarClave() {
		parent::faTransaccionInicio();
		$objCifrado = new clsCifrado();
		$crypClave = $objCifrado->flEncriptar( $this->atrFormulario["pswClave"] );
		unset( $objCifrado );

		$sql = "SELECT MAX( idhistorial ) AS clave_max
				FROM thistorial_clave 
				Where id_usuario = '{$_SESSION["id_usuario"]}' ; ";
		$arrClaveMax = parent::getConsultaArreglo( parent::faEjecutar( $sql ) ); 

		$sql = "UPDATE thistorial_clave
				SET  estatus = '0'
				WHERE
					id_usuario = '{$_SESSION["id_usuario"]}' AND
					idhistorial = '{$arrClaveMax["clave_max"]}' ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) ) { //verifica si se ejecuto bien
			$sql = "INSERT INTO thistorial_clave
						( clave , estatus , id_usuario )
					VALUES
						( '{$crypClave}' , 1  , '{$_SESSION["id_usuario"]}' ) ; ";
			$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
			if ( parent::faVerificar( $tupla ) ) { //verifica si se ejecuto bien
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



	function Consultar() {
		$arrForm = $this->atrFormulario;
		$sql = "
			SELECT 
				P.idpregunta , P.nombre AS pregunta , 
				R.idrespuesta , R.nombre AS respuesta
			FROM 
				tpregunta AS P , trespuesta AS R
			WHERE
				R.idpregunta = P.idpregunta AND
				( R.id_usuario = '{$_SESSION["id_usuario"]}' AND 
				R.idpregunta = '{$arrForm['cmbPregunta1']}' ) 
			ORDER BY R.idrespuesta DESC ";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ( parent::faVerificar( $tupla ) ) {
			$arrConsulta = parent::getConsultaArreglo( $tupla );
			parent::faLiberarConsulta( $tupla );
			return $arrConsulta; //envia el arreglo
		}
		else
			return false;
	}
	function Consultar2() {
		$arrForm = $this->atrFormulario;
		$sql = "
			SELECT 
				P.idpregunta , P.nombre AS pregunta , 
				R.idrespuesta , R.nombre AS respuesta
			FROM 
				tpregunta AS P , trespuesta AS R
			WHERE
				R.idpregunta = P.idpregunta AND
				( R.id_usuario = '{$_SESSION["id_usuario"]}' AND 
				R.idpregunta = '{$arrForm['cmbPregunta2']}' )
			ORDER BY R.idrespuesta DESC ";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ( parent::faVerificar( $tupla ) ) {
			$arrConsulta = parent::getConsultaArreglo( $tupla );
			parent::faLiberarConsulta( $tupla );
			return $arrConsulta; //envia el arreglo
		}
		else
			return false;
	}



	//funcion utilizada para cambiar clave, consulta una matriz con
	//el historial de las ultimas claves segun el rango establecido
	function fmConsultarClave() {
		$viRango = $this->getMaximoRangoClave();
		$sql = "
			SELECT * 
			FROM thistorial_clave
				
			WHERE 
				id_usuario = '{$_SESSION["id_usuario"]}'
				
			ORDER BY 
				idhistorial DESC
			LIMIT $viRango ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			return $tupla; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return $sql;
	}



	//funcion que selecciona el rango de claves para comparar y que no sean repetidas de forma seguida
	//se debe crear un objeto ya que el usuario de conexion de esta clase no tiene acceso a la tabla de configuracion
	function getMaximoRangoClave()  {
		return 5; //envia el valor guardado en la bd o uno por defecto que tiene la funcion 
	}



} //cierre de la clase

?>