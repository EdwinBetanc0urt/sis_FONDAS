<?php
include_once('clsConexion.php');

class Reposo extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "treposo";
		$this->atrId = "idreposo";
        $this->atrNombre = "justificativo";
        $this->atrTipo_Reposo = "";
		$this->atrMotivo = "";
		$this->atrCantidad_Dias = "";
		$this->atrEstatus = "estatus";
		$this->atrFormulario = array();
	}

	function Aprobar()
	{
		$sql = "
			UPDATE {$this->atrTabla}
			set
				condicion = 'aprobado',
				observacion_aprobacion = '{$this->atrFormulario["observacion"]}',
				idtrabajador_rrhh = '{$_SESSION["idtrabajador"]}',
				fecha_aprobacion = CURRENT_TIMESTAMP
			where
				{$this->atrId} = '{$this->atrFormulario["idreposo"]}'";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}

	function Rechazar()
	{
		$sql = "
			UPDATE {$this->atrTabla}
			set
				condicion='rechazado'
				observacion_aprobacion = '{$this->atrFormulario["observacion"]}',
				idtrabajador_rrhh = '{$_SESSION["idtrabajador"]}',
				fecha_aprobacion = CURRENT_TIMESTAMP
			where
				{$this->atrId} = '{$this->atrFormulario["idreposo"]}'";

		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}

	/**
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar)
	{
		$sql = "SELECT
			Perm.*, Perm.condicion AS condicion_reposo, P.*, M.nombre AS motivo_reposo
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

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
	function fmListarIndexRevisado($psBuscar)
	{
		$sql = "SELECT
			Perm.*, Perm.condicion AS condicion_reposo, P.*, M.nombre AS motivo_reposo
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

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
	function fmListarIndexRechazado($psBuscar)
	{
		$sql = "SELECT
			Perm.*, Perm.condicion AS condicion_reposo, P.*, M.nombre AS motivo_reposo
			FROM $this->atrTabla AS Perm

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

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

	/**
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function listarReporteUnitario($identificacion)
	{
		$sql = "SELECT
				P.*, Perm.*, Perm.condicion AS condicion_reposo, M.nombre AS
				motivo_reposo, M.cantidad_dias, M.cantidad_tiempo,
				RH.nacionalidad AS nacionalidad_rh, RH.cedula AS cedula_rh,
				RH.nombre as nombre_rh, RH.apellido as apellido_rh,
				J.nacionalidad AS nacionalidad_jefe, J.cedula AS cedula_jefe,
				J.nombre as nombre_jefe, J.apellido as apellido_jefe
			FROM treposo AS Perm

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			INNER JOIN tdepartamento AS D
				ON D.iddepartamento = P.iddepartamento

			LEFT JOIN vpersona AS J
				ON D.idtrabajador = J.idtrabajador

			LEFT JOIN tdepartamento AS DRH
				ON DRH.iddepartamento = 1

			LEFT JOIN vpersona AS RH
				ON DRH.idtrabajador = RH.idtrabajador

			WHERE
				{$this->atrId} = '{$identificacion}'
			LIMIT 1 ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ($tupla) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	}

	//función.modelo.Listar Reporte
	//devuelve la consulta con los parametros de rango y ordenado que se le indiquen
	function listarReporte()
	{
		$arrFormulario = $this->atrFormulario;

		$sql = "SELECT
				P.*, Perm.*, Perm.condicion AS condicion_reposo, M.nombre AS
				motivo_reposo, M.cantidad_dias, M.cantidad_tiempo
			FROM treposo AS Perm

			INNER JOIN tmotivo_reposo AS M
				ON M.idmotivo_reposo = Perm.idmotivo_reposo

			INNER JOIN vpersona AS P
				ON Perm.idtrabajador = P.idtrabajador

			WHERE
				(fecha_inicio >= '{$arrFormulario["ctxFechaInicio"]}' AND
				fecha_inicio <=  '{$arrFormulario["ctxFechaFinal"]}') "; //selecciona todo de la tabla

		$sqlTipoRango = " "; //selecciona solo lo que esta dentro del rango
		if (array_key_exists("radRangoTipo", $arrFormulario)) {
			if ($arrFormulario['radRangoTipo'] == "fuera")
				$sqlTipoRango = " NOT "; //selecciona solo lo que esta fuera del rango
		}

		//define el rango a mostrar
		if (array_key_exists("radRango", $arrFormulario)) {
			switch ($arrFormulario['radRango']) {

				case 'trabajador': //no esta imprimiendo el final
					$sql .= " AND {$sqlTipoRango}
						Perm.idtrabajador = '{$arrFormulario["cmbTrabajador"]}' ";
					#dentro SELECT * FROM cedula WHERE (id_rol >= '3' AND id_rol <= '5')
					#fuera SELECT * FROM cedula WHERE NOT (id_rol >= '3' AND id_rol <= '5')
					break;

				case 'condicion':
					$sql .= "AND
						Perm.condicion $sqlTipoRango IN
						('{$arrFormulario["cmbCondicion"]}')	 ";
					break;
			}
		}
		//define el atributo en que se ordena y de que forma
		if (array_key_exists("cmbOrden", $arrFormulario))
			$sql .= " ORDER BY {$arrFormulario['cmbOrden']} {$arrFormulario['radOrden']} ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		return $tupla;
	} //cierre de la funcion

}

?>
