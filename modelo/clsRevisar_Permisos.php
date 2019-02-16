<?php
include_once('clsConexion.php');

class Revisar_Permisos extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tpermiso";
		$this->atrId = "idpermiso";
        $this->atrNombre = "justificativo";
        $this->atrTipo_Permiso = "";
		$this->atrMotivo = "";
		$this->atrCantidad_Dias = "";

		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}



	function Aprobar() {
		session_start();
		$sql = "
			UPDATE {$this->atrTabla}
			set
				condicion = 'revisado',
				observacion_revision = '{$this->atrFormulario["idpermiso"]}',
				idtrabajador_jefe = '{$_SESSION["idtrabajador"]}',
				fecha_revision = CURRENT_TIMESTAMP
			where
				{$this->atrId} = '{$this->atrFormulario["idpermiso"]}'";
		//echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}

	function Rechazar() {
		$sql = "
			UPDATE {$this->atrTabla}
			set
				condicion='rechazado',
				observacion_revision = '{$this->atrFormulario["idpermiso"]}',
				idtrabajador_jefe = '{$_SESSION["idtrabajador"]}',
				fecha_revision = CURRENT_TIMESTAMP
			where
				{$this->atrId} = '{$this->atrFormulario["idpermiso"]}'";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	//funcion.nivel.Listar
	function getTiempoMotivo($piMotivo = "") {
		$sql = "
			SELECT cantidad_tiempo, cantidad_dias
			FROM  tmotivo_permiso
			WHERE
				idmotivo_permiso = '{$piMotivo}'
			LIMIT 1;";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrConsulta; //envia el arreglo
		}
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
					nombre LIKE '%{$psBuscar}%' OR
					{$this->atrId} LIKE '%{$psBuscar}%' ;";
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
			SELECT Perm.*, P.*, M.nombre AS motivo_permiso
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_permiso AS M
				ON M.idmotivo_permiso = Perm.idmotivo_permiso

			WHERE
				Perm.estatus = 'activo' 
				AND Perm.condicion = 'solicitado'
				AND (Perm.{$this->atrId} LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
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


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexRevisado($psBuscar) {		
		$sql = "
			SELECT Perm.*, P.*, M.nombre AS motivo_permiso
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_permiso AS M
				ON M.idmotivo_permiso = Perm.idmotivo_permiso

			WHERE
				Perm.estatus = 'activo' 
				AND Perm.condicion = 'revisado'
				AND (Perm.{$this->atrId} LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
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
  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexRechazado($psBuscar) {		
		$sql = "
			SELECT Perm.*, P.*, M.nombre AS motivo_permiso
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_permiso AS M
				ON M.idmotivo_permiso = Perm.idmotivo_permiso

			WHERE
				Perm.estatus = 'activo' 
				AND Perm.condicion = 'rechazado'
				AND (Perm.{$this->atrId} LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
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
