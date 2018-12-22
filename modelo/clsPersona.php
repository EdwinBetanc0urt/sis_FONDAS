<?php
include_once('clsConexion.php');

class Persona extends clsConexion {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tpersonas";
		$this->atrId = "idpersona";
		$this->atrNombre = "usuario";
		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}


	function IncluirPersona() {
		$sql = "
			INSERT INTO {$this->atrTabla} 
				( nacionalidad , cedula , nombre , apellido , telefono , correo ) 
			VALUES ( 
				'{$this->atrFormulario["cmbNacionalidad"]}' ,
				'{$this->atrFormulario["numCi"]}' ,
				'{$this->atrFormulario["ctxNombre"]}' ,
				'{$this->atrFormulario["ctxApellido"]}' ,
				'{$this->atrFormulario["numTelefono"]}' ,
				'{$this->atrFormulario["ctxCorreo"]}' 
			); ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	function BuscarTrabajador( $piCi ) {
		$sql = "
			SELECT * FROM ttrabajador
			WHERE 
				idpersona = (
					SELECT idpersona 
					FROM tpersonas
					WHERE
						cedula = '{$piCi}'
				)";
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


	function BuscarUsuario( $piCi ) {
		$sql = "
			SELECT * FROM {$this->atrTabla}  
			WHERE 
				usuario = {$piCi} ";
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



	function ConsultarPersona( $psNacionalidad , $piDocumento ) {
		$sql = "SELECT * FROM tpersonas
				WHERE 
					cedula = '$piDocumento' AND
					nacionalidad = '$psNacionalidad'
				LIMIT 1 ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if ( parent::faVerificar( $tupla ) ) {
			$arrConsulta = parent::getConsultaArreglo( $tupla ); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			return $arrConsulta; //sino encuentra nada devuelve un cero en el arreglo
		}
		else
			return false;
	}


	function ListaSoloTrabajador( $psBusqueda = '' ) {
		$sql = "SELECT 
					Per.tipo_id_fk , Per.identificacion_persona , 
					Per.pri_nombre , Per.seg_nombre , Per.pri_apellido , Per.seg_apellido , 
					I.caracter_tipo_id AS nacionalidad 
				FROM 
					$this->atrTabla AS Per

				INNER JOIN tcTipo_ID AS I
					ON Per.tipo_id_fk = I.id_tipo_id 

				WHERE
					Per.id_persona NOT IN ( SELECT persona_fk FROM tsUsuario )
					AND	( Per.identificacion_persona LIKE '%$psBusqueda%'  ) ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			return $tupla;
		}
		else
			return false;
	}



	function ListaSoloUsuario( $psBusqueda = '' ) {
		$sql = "SELECT 
					Per.nacionalidad , Per.cedula , 
					Per.pri_nombre , Per.seg_nombre , Per.pri_apellido , Per.seg_apellido
				FROM 
					$this->atrTabla AS Per 

				WHERE
					Per.id_persona NOT IN ( 
						SELECT idpersona FROM ttrabajador 
					)
					AND	( Per.cedula LIKE '%$psBusqueda%'  ) ; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			return $tupla;
		}
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
			SELECT *
			FROM vpersona

			WHERE
				( {$this->atrId} LIKE '%{$psBuscar}%' OR
				{$this->atrNombre} LIKE '%{$psBuscar}%' ) "; //selecciona todo de la tabla
		
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
