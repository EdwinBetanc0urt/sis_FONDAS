<?php

include_once('clsConexion.php');

class clsTiempoSesion extends clsConexion {
	//variables de la tabla y clase
	private $atrTabla, $atrId_P;
	//atributos que utiliza
	public $atrTiempo;

	/**
	 * constructor de la clase
	 * @param integer $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 2)
	{
		parent::__construct($piPrivilegio); //instancia al constructor padre
		$this->atrTabla = "tusuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase
		
		$this->atrTiempo = "";	
	}

	//funcion.modelo.Actualizar
	function fmActualizarTiempo()
	{
		$sql = "UPDATE {$this->atrTabla}
				SET 
					tiempo_sesion = '{$this->atrTiempo}'
				WHERE 
					usuario = '{$_SESSION["usuario"]}' ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}

} //cierre de la clase

?>
