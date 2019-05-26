<?php
include_once('clsConexion.php');

class Ingresar_Reposo extends clsConexion {

	//atributos de paginación
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre	
		$this->atrTabla = "treposo";
		$this->atrId = "idreposo";
        $this->atrNombre = "justificacitvo";
        $this->atrTipo_Reposo = "";
		$this->atrMotivo = "";
		$this->atrCantidad_Dias = "";
		$this->atrEstatus = "estatus";
		$this->atrFormulario = array();
	}

	function Incluir()
	{
		$sql = "
			INSERT INTO {$this->atrTabla}
				({$this->atrNombre}, idtrabajador, idmotivo_reposo, 
				fecha_inicio, fecha_fin) 
			VALUES (
				'{$this->atrFormulario["ctxObservacion"]}',
				'{$this->atrFormulario["numIdTrabajador"]}',
				'{$this->atrFormulario["cmbMotivo_Reposo"]}',
				'{$this->atrFormulario["ctxFechaInicio"]}',
				'{$this->atrFormulario["ctxFechaFin"]}'
			); ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		return $tupla;
	}

	function Modificar()
	{
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				{$this->atrNombre} = '{$this->atrFormulario["ctxObservacion"]}',
				idtrabajador = '{$this->atrFormulario["ctxDescripcion"]}',
				 
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		return $tupla;
	}

	function consultar()
	{
		$sql = "
			SELECT * FROM {$this->atrTabla}  
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' OR
				{$this->atrNombre} = '{$this->atrFormulario["ctxObservacion"]}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ($tupla) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	}

	function Eliminar()
	{
		$sql = "
			DELETE FROM {$this->atrTabla}  
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		return $tupla;
	}

	//funcion.nivel.Listar
	function getTiempoMotivo($piMotivo = "")
	{
		$sql = "
			SELECT cantidad_tiempo, cantidad_dias
			FROM  tmotivo_reposo
			WHERE
				idmotivo_reposo = '{$piMotivo}'
			LIMIT 1;";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ($tupla) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrConsulta; //envia el arreglo
		}
		return false;
	}

	//funcion.nivel.Listar
	function Listar($psBuscar = "")
	{
		$sql = "
			SELECT * 
			FROM  {$this->atrTabla} "; //selecciona todo el contenido de la tabla

		if ($psBuscar != "") {
			$sql .= "
				WHERE
					nombre LIKE '%{$psBuscar}%' OR
					{$this->atrId} LIKE '%{$psBuscar}%' ;";
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		return $tupla; //envia el arreglo
	}

	/**
	 * función modelo Listar Parámetros, consulta en la base de datos según el
	 * termino de búsqueda, paginación y orden
	 * @param string parámetro control Búsqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar)
	{
		$sql = "
			SELECT Perm.*, P.*, M.nombre AS motivo_reposo
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

			WHERE
				Perm.estatus = 'activo' AND
				(Perm.{$this->atrId} LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; "; 
		
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		return $tupla;
	}

}

?>
