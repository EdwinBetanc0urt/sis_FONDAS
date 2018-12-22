<?php
include_once('clsConexion.php');

class Asistencia extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tasistencia";
		$this->atrId = "idasistencia";
		$this->atrNombre = "nombre";
		$this->atrEstatus = "estatus";
		
		$this->atrDepartamento = "";
		$this->atrFormulario = array();
	}



	function Incluir() {
		session_start();
		parent::faTransaccionInicio();
		$sql = "
			INSERT INTO {$this->atrTabla} 
				(idtrabajador, fecha_elaboracion )
			VALUES ( 
				'{$_SESSION["idtrabajador"]}',
				CURRENT_TIMESTAMP
			); ";
		echo "$sql";
		$vsId = parent::faUltimoId( $sql ); //ejecuta la sentencia y obtiene el ID 
		//$this->IncluirDetalle( $vsId ); /*
		
		//verifica si se ejecuto bien
		if ( $vsId > 0 ) {
			//verifica si se ejecuto bien
			if ( $this->IncluirDetalle( $vsId ) ){
				parent::faTransaccionFin();
				return true; //envia el id para insertar el usuario
			}
			else {
				parent::faTransaccionDeshace();
				return false; //envia el id para insertar el usuario
			}
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
		//*/parent::faTransaccionDeshace();
	}

	function IncluirDetalle( $piId ="" ) {
		$liError = 0;
		$liContador = 0;
		foreach ($this->atrFormulario["detIdTrabajador"] as $key => $value) {
				
			$sql = "
				INSERT INTO tdetalle_asistencia 
					(idasistencia, idtrabajador, hora_entrada)
				VALUES ( 
					'{$piId}',
					'{$value}',
					'{$this->atrFormulario["detHoraEntrada"][$liContador]}'
				); ";
			//echo "$sql";
			$liContador = $liContador + 1;
			$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
			if (! parent::faVerificar() ) //verifica si se ejecuto bien
				$liError = $liError + 1;

		}
		if ( $liError == 0 ) //verifica si se ejecuto bien
			return true;
		else
			return false;
	}


	function Modificar() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}' ,
				descripcion = '{$this->atrFormulario["ctxDescripcion"]}' ,
				iddepartamento = '{$this->atrFormulario["cmbDepartamento"]}'
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
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
		if ( parent::faVerificar() ) {
			$arreglo = parent::getConsultaArreglo( $tupla ); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
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
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	//funcion.nivel.Listar
	function Listar( $psBuscar = "" ) {
		$sql = "
			SELECT * 
			FROM  {$this->atrTabla} 
			WHERE
				iddepartamento = '{$psBuscar}' ;";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) ) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}



  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndex( $psBuscar ) {		
		$sql = "
			SELECT Per.* , A.*
			FROM $this->atrTabla AS A

			INNER JOIN vpersona AS Per
				ON A.idtrabajador = Per.idtrabajador

			WHERE
				A.estatus = 'activo' AND
				( A.{$this->atrId} LIKE '%{$psBuscar}%' 
				OR Per.nombre LIKE '%{$psBuscar}%' 
				OR Per.apellido LIKE '%{$psBuscar}%' ) "; //selecciona todo de la tabla

		if ( $this->atrOrden != "" )
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas( parent::faEjecutar( $sql ) );
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio} , {$this->atrItems} ; "; 
		
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}

}


?>
