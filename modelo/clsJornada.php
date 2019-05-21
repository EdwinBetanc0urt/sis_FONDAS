<?php
include_once('clsConexion.php');

class Jornada extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tjornada";
		$this->atrId = "idjornada";
		$this->atrNombre = "nombre";
		$this->atrEstatus = "estatus";
		$this->atrInicio = "hora_inicio";
		$this->atrFin = "hora_fin";
		$this->atrObservacion = "observacion";
		
		$this->atrFormulario = array();
	}


	function Incluir() {
		parent::faTransaccionInicio();
		$sql = "
			INSERT INTO {$this->atrTabla}
				({$this->atrNombre}, cant_turnos, hora_inicio,
				hora_fin, hora_inicio2, hora_fin2, observacion) 
			VALUES (
				'{$this->atrFormulario["ctxNombre"]}',
				'{$this->atrFormulario["numTurnos"]}',
				'" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraEntrada1"])) . "',
				'" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraSalida1"])) . "',
				'" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraEntrada2"])) . "',
				'" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraSalida2"])) . "',
				'{$this->atrFormulario["ctxObservacion"]}'
			); ";

		echo "$sql";
		$viId = parent::faUltimoId($sql); //Ejecuta la sentencia sql
		$liContError = 0;
		if ($viId > 0) {
			foreach($this->atrFormulario["chkDia"] as $key => $value) {
				$sql = "
					INSERT INTO 
						tdetalle_jornada (idjornada, iddia_semana)
					VALUES
						({$viId}, {$value});";
				$tupla = parent::faEjecutar($sql, false);
				if (! parent::faVerificar()) {
					$liContError = $liContError + 1;
				}
			}
		}

		if ($liContError == 0) {
			parent::faTransaccionFin();
			return true;
		}
		else {
			parent::faTransaccionDeshace();
			return false;

		}
	}



	function Modificar() {
		parent::faTransaccionInicio();
		$sql = "
			UPDATE {$this->atrTabla}
			SET
				{$this->atrNombre} ='{$this->atrFormulario["ctxNombre"]}',
				cant_turnos = '{$this->atrFormulario["numTurnos"]}',
				hora_inicio = '" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraEntrada1"])) . "',
				hora_fin = '" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraSalida1"])) . "',
				hora_inicio2 = '" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraEntrada2"])) . "',
				hora_fin2 = '" . date("H:i:s", strtotime($this->atrFormulario["ctxHoraSalida2"])) . "',
				observacion = '{$this->atrFormulario["ctxObservacion"]}'
			WHERE
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		echo "$sql";
		$liContError = 0;
		$tupla = parent::faEjecutar($sql, false);
		if (parent::faVerificar()) {
			$sql = "
				DELETE FROM tdetalle_jornada
				WHERE
					{$this->atrId} = '{$this->atrFormulario["numId"]}'";
			$tupla = parent::faEjecutar($sql, false);
			if (parent::faVerificar()) {
				foreach($this->atrFormulario["chkDia"] as $key => $value) {
					$sql = "
						INSERT INTO 
							tdetalle_jornada (idjornada, iddia_semana)
						VALUES
							({$this->atrFormulario["numId"]}, {$value});";
					$tupla = parent::faEjecutar($sql, false);
					if (! parent::faVerificar()) {
						$liContError = $liContError + 1;
					}
				}
			}
			else
				$liContError == 1;
		}
		else
			$liContError == 1;

		if ($liContError == 0) {
			parent::faTransaccionFin();
			return true;
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
	}

	function consultar()
	{
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
			UPDATE {$this->atrTabla} 
			SET
				{$this->atrEstatus} = 'inactivo'
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
					nombre LIKE '%{$psBuscar}%' OR
					{$this->atrId} LIKE '%{$psBuscar}%' ;";
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}

	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarDiasLaborados($piJornada = "") {
		$sql = "
			SELECT *
			FROM tdetalle_jornada
			WHERE 
				idjornada = '{$piJornada}' 
				AND estatus='activo' ";
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
	function fmListarIndex($psBuscar) {		
		$sql = "
			SELECT * 
			FROM $this->atrTabla

			WHERE
				estatus = 'activo' AND
				({$this->atrId} LIKE '%{$psBuscar}%' OR
				nombre LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla
		
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

	function fmListarDias() {
		$sql = "
			SELECT * FROM tdia_semana

			LIMIT 7";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

}


?>
