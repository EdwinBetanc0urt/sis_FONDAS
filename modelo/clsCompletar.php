<?php
include_once('clsConexion.php');

class Completar extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tpersonas";
		$this->atrDepartamento = "";
		$this->atrFormulario = array();
	}

	//funcion.modelo.Insertar
	function actualizar()
	{
		parent::faTransaccionInicio();
		$sql = "
			UPDATE 
				{$this->atrTabla} 
			SET
				nombre = '{$this->atrFormulario["ctxNombre"]}',
				seg_nombre = '{$this->atrFormulario["ctxNombre2"]}',
				apellido = '{$this->atrFormulario["ctxApellido"]}',
				seg_apellido = '{$this->atrFormulario["ctxApellido2"]}',
				sexo = '{$this->atrFormulario["cmbSexo"]}',
				edo_civil = '{$this->atrFormulario["cmbEdoCivil"]}',
				fecha_naci = '{$this->atrFormulario["datFechaNac"]}',
				direccion = '{$this->atrFormulario["ctxDireccion"]}',
				tel_mov = '{$this->atrFormulario["numTelefono"]}',
				tel_fijo = '{$this->atrFormulario["numTelefono2"]}',
				correo = '{$this->atrFormulario["ctxCorreo"]}',
				idparroquia = '{$this->atrFormulario["cmbParroquia"]}',
				estatus = 'activo'
			WHERE
				idpersona = '{$_SESSION["idpersona"]}'; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ($tupla) { 
			//verifica si se ejecuto bien
			if ($this->CambiarUsuario($_SESSION["idpersona"])){
				parent::faTransaccionFin();
				return true; //envia el id para insertar el usuario
			}
		}
		parent::faTransaccionDeshace();
		return false;
	}

	//funcion.modelo.Insertar
	function CambiarUsuario($piIdPersona)
	{
		$sql = "
			UPDATE tusuario 
			SET
				estatus = 'activo',
				ultima_actividad = CURRENT_DATE,
				intento_fallido = '0'
			WHERE
				id_usuario = '{$_SESSION["id_usuario"]}' ";	
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ($tupla) {
			return $this->InsertarClave($_SESSION["id_usuario"]); 
		}
		return false;
	}

	//funcion.modelo.Insertar
	function InsertarClave($piIdUsuario)
	{
		//nacionalidad, guion, documento. Ejemplo. V-12345678
		$clave_encriptada = clsCifrado::getCifrar($this->atrFormulario["pswClave"]);
		$sql = "INSERT INTO thistorial_clave
					(clave, fecha_creacion, estatus, id_usuario)
				VALUES
					('{$clave_encriptada}',  CURRENT_DATE, 'activo', '{$piIdUsuario}') ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ($tupla) {
			return $this->InsertarRespuestas($_SESSION["id_usuario"]); //envia el arreglo
		}
		return false;
	}

	//funcion.modelo.Insertar
	function InsertarRespuestas()
	{
		//$respuesta_encriptada = "" ;
		$liError = 0 ;
		//ciclo del 1 al 5 que son los name que exiten en la vista (ctxRespuesta1-5 y cmbPregunta1-5)
		for ($i = 1 ; $i <= 2 ; $i++) {
			//$respuesta_encriptada = clsCifrado::getCifrar(
			//	$this->atrFormulario["ctxRespuesta" . $i]
			//);
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
		if ($liError == 0) {
			return true;
		}
		return false;
	}

}

?>
