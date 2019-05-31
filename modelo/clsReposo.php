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

}

?>
