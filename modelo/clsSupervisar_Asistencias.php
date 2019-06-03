<?php
include_once('clsConexion.php');

class Supervisar_Asistencia extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tmarcaje_asistencia";
		$this->atrId = "idpersona";
		$this->atrNombre = "usuario";
		$this->atrEstatus = "estatus";
		$this->atrFormulario = array();
	}

	function modificar() {
		$sql ="UPDATE
			tmarcaje_asistencia
			SET
				entrada1 = '{$this->atrFormulario["ctxEntrada1"]}',
				nota1 = '{$this->atrFormulario["ctxNota1"]}',
				salida1 = '{$this->atrFormulario["ctxSalida1"]}',
				nota2 = '{$this->atrFormulario["ctxNota2"]}',
				entrada2 = '{$this->atrFormulario["ctxEntrada2"]}',
				nota3 = '{$this->atrFormulario["ctxNota3"]}',
				salida2 = '{$this->atrFormulario["ctxSalida2"]}',
				nota4 = '{$this->atrFormulario["ctxNota4"]}',
				observacion = '{$this->atrFormulario["ctxObservacion"]}',
				idsupervisor = '{$_SESSION["idtrabajador"]}'
			WHERE
				idmarcaje_asistencia = '{$this->atrFormulario["numId"]}'";

		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		return $tupla;
	}

	/**
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar)
	{
		$sql = "SELECT
			A.*, P.*
				FROM tmarcaje_asistencia AS A

		INNER JOIN vpersona AS P
			ON P.idtrabajador = A.idtrabajador "; //selecciona todo de la tabla

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
