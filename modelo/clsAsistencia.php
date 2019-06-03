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
}

?>
