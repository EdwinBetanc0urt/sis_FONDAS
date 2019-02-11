<?php

include_once('clsConexion.php');

class Solicitar_Vacaciones extends clsConexion {

	// atributos de paginación
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); // instancia al constructor padre

		$this->atrTabla = "tvacacion";
		$this->atrId = "idvacacion";

		$this->atrFormulario = array();
	}


	function Incluir() {
		parent::faTransaccionInicio();
		$sql = "
			INSERT INTO {$this->atrTabla} 
				(idtrabajador, cantidad_dias, fecha_inicio, fecha_fin , condicion)
			VALUES (
				'{$this->atrFormulario["numIdTrabajador"]}',
				'{$this->atrFormulario["vacaciones"]["dias_vacaciones"]}',
				'{$this->atrFormulario["datFechaInicio"]}',
				'{$this->atrFormulario["datFechaFin"]}',
				'solicitado'
			); ";

		$vsId = parent::faUltimoId($sql); // ejecuta la sentencia y obtiene el ID 
		// var_dump($vsId);
		// verifica si se ejecuto bien
		if ($vsId > 0) {
			// verifica si se ejecuto bien
			if ($this->IncluirDetalle($vsId)){
				parent::faTransaccionFin();
				return true; // envía el id para insertar el usuario
			}
			else {
				parent::faTransaccionDeshace();
				return false; // envía el id para insertar el usuario
			}
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
	}

	function IncluirDetalle($piId ="") {
		$liError = 0;
		foreach ($this->atrFormulario["vacaciones"]["periodo"] as $key => $value) {
				
			$sql = "
				INSERT INTO tdetalle_vacacion 
					(idvacacion, periodo_usado, cant_dias_periodo)
				VALUES (
					'{$piId}',
					'{$value["anno"]}',
					'{$value["dias"]}'
				); ";
			$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
			if (! parent::faVerificar()) // verifica si se ejecuto bien
				$liError = $liError + 1;

		}
		if ($liError == 0) // verifica si se ejecuto bien
			return true;
		else
			return false;
	}


	function Modificar() {
		$sql = "
			update {$this->atrTabla}
			set
				nombre='{$this->descripcion},
				coddepartamento='{$this->departamento}'
			where
				codnivel='{$this->codigo}'";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		if (parent::faVerificar()) // verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function consultar() {
		$sql = "
			select * from {$this->atrTabla}
			where codnivel = '{$this->codigo}' ";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		// verifica si se ejecuto bien
		if (parent::faVerificar()) {
			$arreglo = parent::getConsultaArreglo($tupla); // convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); // libera de la memoria el resultado asociado a la consulta
			return $arreglo; // retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}


	function getFechaIngreso($psIdTrabajador) {
		$sql = "
			select fecha_ingreso from ttrabajador
			where idtrabajador = '{$psIdTrabajador}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		// verifica si se ejecuto bien
		if (parent::faVerificar()) {
			$arreglo = parent::getConsultaArreglo($tupla); // convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); // libera de la memoria el resultado asociado a la consulta
			return $arreglo[0]; // retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}


	function eliminar()	{
		$sql = "
			delete from {$this->atrTabla}
			where
				codnivel = '{$this->codigo}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	// función.nivel.Listar
	function Listar($psBuscar = "") {
		$sql = "
			SELECT *
			FROM  {$this->atrTabla} "; // selecciona todo el contenido de la tabla

		if ($psBuscar != "") {
			$sql .= "
				WHERE
					nombre LIKE '%{$psBuscar}%' ";
		}
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) // verifica si se ejecuto bien
			return $tupla; // envía el arreglo
		else
			return false;
	}


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el
	 * termino de búsqueda, paginación y orden
	 * @param string parámetro control Búsqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function listarPeriodos($psBuscar) {		
		$sql = "
			SELECT 
				D.periodo_usado

			FROM tvacacion AS V 

			INNER JOIN tdetalle_vacacion AS D 
				ON D.idvacacion = V.idvacacion 

			INNER JOIN ttrabajador AS T 
				ON T.idtrabajador = V.idtrabajador

			WHERE
				T.idtrabajador = {$psBuscar}

			ORDER BY D.periodo_usado DESC ;"; // selecciona todo de la tabla
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			$arrRetorno = array();
			while ($arrRegistro = parent::getConsultaNumerico($tupla)) {
				array_push($arrRetorno , $arrRegistro[0]);
			};
			parent::faLiberarConsulta($tupla	); // libera de la memoria el resultado asociado a la consulta
			return $arrRetorno; // retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return array();
	}


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parámetro control Búsqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex($psBuscar) {
		$sql = "
			SELECT 
				V.* , D.iddetalle_vacacion, D.periodo_usado, D.cant_dias_periodo 
			FROM tvacacion AS V 

			INNER JOIN tdetalle_vacacion AS D 
				ON D.idvacacion = V.idvacacion  

			WHERE
				V.idtrabajador = '{$_SESSION["idtrabajador"]}' "; // selecciona todo de la tabla
		
		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		// concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio} , {$this->atrItems} ; "; 
		
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}


 }

?>
