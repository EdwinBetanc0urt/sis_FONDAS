<?php
include_once('clsPersona.php');

class Bitacora_Acceso extends Persona {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tbitacora";
		$this->atrId = "idbitacora";
		$this->atrNombre = "so";
		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}

  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar)
	{		
		$sql = "
			SELECT B.*, U.id_usuario, U.usuario, T.idtipo_usuario, T.nombre AS tipo_usuario,
				P.nombre, P.apellido, P.nacionalidad

			FROM {$this->atrTabla} AS B

			INNER JOIN tusuario AS U
				ON U.id_usuario = B.usuario_aplicacion

			INNER JOIN tpersonas AS P
				ON U.idpersona = P.idpersona

			INNER JOIN ttipo_usuario AS T
				ON T.idtipo_usuario = U.idtipo_usuario
			WHERE
				({$this->atrId} LIKE '%{$psBuscar}%' OR
				{$this->atrNombre} LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
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
