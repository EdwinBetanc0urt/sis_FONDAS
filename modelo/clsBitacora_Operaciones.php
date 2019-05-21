<?php
include_once('clsConexion.php');

class Bitacora_Operaciones extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tauditoria";
		$this->atrId = "idauditoria";		
		$this->atrFormulario = array();
	}

  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar)
	{		
		$sql = "SELECT * 
			FROM $this->atrTabla AS a
            
            INNER JOIN vpersona AS p
                ON p.id_usuario = a.idusuario
			WHERE
				({$this->atrId} LIKE '%{$psBuscar}%' OR
				nombre LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";
        echo $sql;
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
