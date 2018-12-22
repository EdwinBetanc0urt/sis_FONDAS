<?php
include_once('clsConexion.php');

class Vacaciones extends clsConexion {
	
	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre

		$this->atrTabla = "tvacacion";
		$this->atrId = "idvacacion";

		$this->atrFormulario = array();
	}


	function UltimoCodigo() {
		$sql= "SELECT MAX( {$this->atrId} ) AS id
				FROM {$this->atrTabla}  ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		$arreglo = parent::getConsultaNumerico( $tupla );
		parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
		return $arreglo; //sino encuentra nada devuelve un cero
	}


	function Incluir() {
		$sql = "
			INSERT INTO {$this->atrTabla} (nombre)
			values
				( '{$this->atrFormulario["ctxNombre"]}' ); ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function Aprobar() {
		$sql = "
			update {$this->atrTabla}
			set
				condicion='aprobado'
			where
				idvacacion='{$this->atrFormulario["idvacaciones"]}'";
				echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}
	function Rechazar() {
		$sql = "
			update {$this->atrTabla}
			set
				condicion='rechazado'
			where
				idvacacion='{$this->atrFormulario["idvacaciones"]}'";
				echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function consultar() {
		$sql = "
			select * from {$this->atrTabla}
			where codnivel = '{$this->codigo}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ( parent::faVerificar() ) {
			$arreglo = parent::faCambiarArreglo( $tupla ); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
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
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	//funcion.nivel.Listar
	function Listar( $psBuscar = "" ) {
		$sql = "
			SELECT *
			FROM  {$this->atrTabla} "; //selecciona todo el contenido de la tabla

		if ( $psBuscar != "" ) {
			$sql .= "
				WHERE
					nombre LIKE '%{$psBuscar}%' ";
		}
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
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.condicion = 'solicitado' "; //selecciona todo de la tabla
		
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


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexAprobado( $psBuscar ) {		
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.condicion = 'aprobado' AND
				V.fecha_inicio > DATE_FORMAT(NOW(),'%Y-%m-%d') AND
				V.fecha_fin > DATE_FORMAT(NOW(),'%Y-%m-%d') "; //selecciona todo de la tabla
		
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


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexEnCurso( $psBuscar ) {		
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.condicion = 'aprobado' AND
				V.fecha_inicio < DATE_FORMAT(NOW(),'%Y-%m-%d') AND
				V.fecha_fin > DATE_FORMAT(NOW(),'%Y-%m-%d') "; //selecciona todo de la tabla*/

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


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexCulminado( $psBuscar ) {		
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.condicion = 'aprobado' AND
				V.fecha_inicio < DATE_FORMAT(NOW(),'%Y-%m-%d') AND
				V.fecha_fin < DATE_FORMAT(NOW(),'%Y-%m-%d') "; //selecciona todo de la tabla
		
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


  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexRechazado( $psBuscar ) {		
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.condicion = 'rechazado' "; //selecciona todo de la tabla
		
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



  	/** 
	 * función modelo Listar Parámetros, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $psBuscar, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarReporte2( $piVacacion ) {		
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador 

			WHERE
				V.idvacacion = '{$piVacacion}' 
			LIMIT 1 "; 
		echo "$sql";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) ){
			$arreglo = parent::getConsultaArreglo( $tupla ); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}




	//función.modelo.Listar Reporte
	//devuelve la consulta con los parametros de rango y ordenado que se le indiquen
	function fmListarReporte( $piVacacion = "" ) {		
		$arrFormulario = $this->atrFormulario;
		$sql = "
			SELECT 
				V.*, P.*
			FROM tvacacion AS V 

			INNER JOIN vpersona AS P 
				ON P.idtrabajador = V.idtrabajador "; //selecciona todo de la tabla

		$sqlTipoRango = " "; //selecciona solo lo que esta dentro del rango
		if ( array_key_exists("radRangoTipo" , $arrFormulario) ) {
			if ( $arrFormulario['radRangoTipo'] == "fuera" )
				$sqlTipoRango = " NOT "; //selecciona solo lo que esta fuera del rango
		}

		//define el rango a mostrar
		if ( array_key_exists("radRango" , $arrFormulario) ) {
			switch ( $arrFormulario['radRango'] ) {

				case 'trabajador': //no esta imprimiendo el final
					$sql .= " WHERE {$sqlTipoRango}
						cedula = '{$arrFormulario["cmbTrabajador"]}' ";
					#dentro SELECT * FROM cedula WHERE (id_rol >= '3' AND id_rol <= '5')
					#fuera SELECT * FROM cedula WHERE NOT (id_rol >= '3' AND id_rol <= '5')
					break;
					
				case 'condicion':
					$sql .= "
						WHERE 
						condicion $sqlTipoRango IN
						('{$arrFormulario["cmbCondicion"]}')	 ";
					break;
					
				case 'fecha':
					$arrFormulario["ctxFechaInicio"] = parent::faFechaFormato($arrFormulario["ctxFechaInicio"], "dma", "amd");
					$arrFormulario["ctxFechaFinal"] = parent::faFechaFormato($arrFormulario["ctxFechaFinal"], "dma", "amd");
					$sql .= " 
						WHERE 
						( fecha_inicio $sqlTipoRango BETWEEN
						'{$arrFormulario["ctxFechaInicio"]}' 
						AND '{$arrFormulario["ctxFechaFinal"]}' ) ";
					break;
			}
		}

		//define el atributo en que se ordena y de que forma
		if ( array_key_exists("cmbOrden" , $arrFormulario) )
			$sql .= " ORDER BY {$arrFormulario['cmbOrden']} {$arrFormulario['radOrden']} ";

		var_dump($sql);

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql

		// var_dump($tupla);

		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	} //cierre de la funcion



	function getPeriodoUsado( $piVacacion ) {
		$sql = "
			SELECT GROUP_CONCAT(periodo_usado) AS periodos
	 		FROM tdetalle_vacacion 
	 		WHERE idvacacion = {$piVacacion}
	 		GROUP BY idvacacion 
	 		LIMIT 1";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ( parent::faVerificar() ) {
			$arreglo = parent::getConsultaArreglo( $tupla ); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			return $arreglo[0]; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}

 }
?>
