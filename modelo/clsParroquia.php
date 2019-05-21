<?php
include_once('clsConexion.php');

class Parroquia extends clsConexion {

	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;
	public $atrMunicipio;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tparroquia";
		$this->atrId = "idparroquia";
		$this->atrNombre = "nombre";
		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}


	function UltimoCodigo() {
		$sql= "SELECT MAX({$this->atrId}) AS id
				FROM {$this->atrTabla}  ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		$arreglo = parent::getConsultaNumerico($tupla);
		parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
		return $arreglo; //sino encuentra nada devuelve un cero
	}


	function Incluir() {
		$sql = "
			INSERT INTO {$this->atrTabla} 
				(nombre, idmunicipio) 
			values 
				('{$this->atrFormulario["ctxNombre"]}', '{$this->atrFormulario["cmbMunicipio"]}'); ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function Modificar() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}',
				idmunicipio = '{$this->atrFormulario["cmbMunicipio"]}'
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql, false); //Ejecuta la sentencia sql
		if (parent::faVerificar()) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	function consultar() {
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
			DELETE FROM {$this->atrTabla}  
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
					idmunicipio = '{$psBuscar}' ";
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}


	//función.modelo.Listar Estados
	//utilizado con los combos
	function ListarParroquias() {
		$sql = "SELECT $this->atrId, parroquia 
				FROM $this->atrTabla
				WHERE 
					estatus_parroquia = 'activo' AND 
					municipio_fk = '{$this->atrMunicipio}' ; ";
		//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			return $tupla; //retorna el arreglo creado
		}
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
			SELECT P.*, M.nombre AS municipio, E.idestado, E.nombre AS estado
			FROM $this->atrTabla AS P

			INNER JOIN tmunicipio AS M
				ON P.idmunicipio = M.idmunicipio

			INNER JOIN testado AS E
				ON E.idestado = M.idestado
			WHERE
				P.estatus = 'activo' AND
				(P.{$this->atrId} LIKE '%{$psBuscar}%' OR
				P.nombre LIKE '%{$psBuscar}%' OR
				M.nombre LIKE '%{$psBuscar}%') "; //selecciona todo de la tabla

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
