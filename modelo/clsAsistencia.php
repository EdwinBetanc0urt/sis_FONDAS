<?php
include_once('clsConexion.php');

class Asistencia extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tmarcaje_asistencia";
		$this->atrId = "idmarcaje_asistencia";
		$this->atrNombre = date("Y-m-d");
		$this->atrEstatus = "estatus";
		$this->atrDepartamento = "";
		$this->atrFormulario = array();
    }

    function marcar()
    {
        $tipo = substr($this->atrFormulario["campo"], 0, -1);
        if ($tipo == "salida") {
            return $this->actualizar();
        }
        if ($this->consultar()){
            return $this->actualizar();
        }
        return $this->insertar();
    }

    function insertar()
    {
        $sql = "INSERT INTO
            {$this->atrTabla} (
                idtrabajador,
                fecha_marcaje,
                {$this->atrFormulario["campo"]}
            )
            VALUES (
                '{$_SESSION["idtrabajador"]}',
                '{$this->atrNombre}',
                '{$this->atrFormulario["ctxTiempoMarcaje"]}'
            )";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
        return $tupla;
    }

    function actualizar()
    {
        $sql = "UPDATE
            {$this->atrTabla}
            SET
                {$this->atrFormulario["campo"]} = '{$this->atrFormulario["ctxTiempoMarcaje"]}'
            WHERE
                idtrabajador = '{$_SESSION["idtrabajador"]}'
                AND fecha_marcaje = '{$this->atrNombre}'";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
        return $tupla;
    }

    function consultar()
    {
        $sql = "SELECT *
            FROM {$this->atrTabla}
            WHERE
                idtrabajador = '{$_SESSION["idtrabajador"]}'
                AND fecha_marcaje = '{$this->atrNombre}'";
        $tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
        if ($tupla) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
        }
        return $tupla;
    }

    /**
     * función modelo Listar Parámetros, consulta en la base de datos según el
     * termino de búsqueda, paginación y orden
     * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
     * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
     */
    function fmListarIndex($psBuscar)
    {
        $fecha = parent::faFechaFormato($psBuscar);
        $sql = "SELECT
                A.*, S.observacion_general, P.*
            FROM $this->atrTabla  AS A

            INNER JOIN vpersona AS P
                ON P.idtrabajador = A.idtrabajador

            LEFT JOIN tajuste_asistencia AS S
                ON A.idmarcaje_asistencia = S.idmarcaje_asistencia

            WHERE
                P.idtrabajador = '{$_SESSION["idtrabajador"]}' "; //selecciona todo de la tabla

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
