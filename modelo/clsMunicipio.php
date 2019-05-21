<?php
include_once('clsConexion.php');

class Municipio extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tmunicipio";
		$this->atrId = "idmunicipio";
		$this->atrNombre = "nombre";
		$this->atrEstatus = "estatus";
		
		$this->atrEstado = "";
		$this->atrFormulario = array();
	}


	function Incluir() {
		$sql = "
			INSERT INTO {$this->atrTabla} ({$this->atrNombre}, idestado) 
			VALUES (
				'{$this->atrFormulario["ctxNombre"]}',
				'{$this->atrFormulario["cmbEstado"]}'
			); ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function Modificar() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}',
				idestado = '{$this->atrFormulario["cmbEstado"]}'
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	function consultar() {
		$sql = "
			SELECT * FROM {$this->atrTabla}  
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' OR
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar()) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}



	function Eliminar()	{
		$sql = "
			DELETE FROM {$this->atrTabla}  
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	//funcion.nivel.Listar
	function Listar($psBuscar = "") {
		$sql = "
			SELECT * 
			FROM  {$this->atrTabla} "; //selecciona todo el contenido de la tabla

		if ($psBuscar != "") {
			$sql .= "
				WHERE
					idestado = '{$psBuscar}' ";
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar) {		
		$sql = "
			SELECT M.*, E.nombre AS estado
			FROM $this->atrTabla AS M

			INNER JOIN testado AS E
				ON E.idestado = M.idestado
			WHERE
				M.estatus = 'activo' AND
				(M.{$this->atrId} LIKE '%{$psBuscar}%' OR
				E.nombre LIKE '%{$psBuscar}%' OR
				M.nombre LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla

		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; "; 
		
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

}


?>
