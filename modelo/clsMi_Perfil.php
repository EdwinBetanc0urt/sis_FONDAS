<?php

include_once('clsPersona.php');

class Mi_Perfil extends Persona {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tpersonas";
		$this->atrId = "idpersona";
		$this->atrNombre = "nombre";
		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}

	function Modificar()
	{
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
				idparroquia = '{$this->atrFormulario["cmbParroquia"]}'
			WHERE
				idpersona = '{$_SESSION["idpersona"]}'; ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}

	function consultar()
	{		
		$sql = "
			SELECT * FROM vpersona
			WHERE 
				idpersona = '{$_SESSION["idpersona"]}'
			LIMIT 1 "; //selecciona todo de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

}

?>
