<?php
include_once('clsPersona.php');

class Usuario extends Persona {

	//atributos de paginacion
	public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual, $atrPaginaFinal, $atrOrden, $atrTipoOrden ;

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "tusuario";
		$this->atrId = "id_usuario";
		$this->atrNombre = "usuario";
		$this->atrEstatus = "estatus";
		
		$this->atrFormulario = array();
	}



	//funcion.modelo.Insertar
	function Incluir() {

		parent::faTransaccionInicio();
		$vsId = NULL ;
		$arrPersona = parent::ConsultarPersona( $this->atrFormulario["cmbNacionalidad"] , $this->atrFormulario["numCi"] );
		if ( $arrPersona ) {
			$vsId = $arrPersona["idpersona"];
		}
		else {
			$sql = "
				INSERT INTO tpersonas
					( nacionalidad , cedula , nombre , apellido , tel_mov , correo ) 
				VALUES ( 
					'{$this->atrFormulario["cmbNacionalidad"]}' ,
					'{$this->atrFormulario["numCi"]}' ,
					'{$this->atrFormulario["ctxNombre"]}' ,
					'{$this->atrFormulario["ctxApellido"]}' ,
					'{$this->atrFormulario["numTelefono"]}' ,
					'{$this->atrFormulario["ctxCorreo"]}' 
				); ";
			$vsId = parent::faUltimoId( $sql ); //ejecuta la sentencia y obtiene el ID 
		}

		//verifica si se ejecuto bien
		if ( $vsId > 0 ) {
			//verifica si se ejecuto bien
			if ( $this->atrFormulario["chxTrabaja"] == "si" )
				$estatus2 = $this->InsertarTrabajador( $vsId );

			$estatus = $this->InsertarUsuario( $vsId );

			if ( $estatus == true ){
				parent::faTransaccionFin();
				return true; //envia el id para insertar el usuario
			}
			elseif ( is_string( $estatus ) ) {
				parent::faTransaccionDeshace();
				return $estatus; //envia el id para insertar el usuario
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
	}


	//funcion.modelo.Insertar
	function InsertarTrabajador( $piIdPersona ) {
		$vsId = NULL ;

		$arrUsuario = $this->BuscarTrabajador( $this->atrFormulario["numCi"] );
		if ( $arrUsuario ) {
			return "ya existe un tranajador";
		}
		else {
			$sql = "
				INSERT INTO {$this->atrTabla} 
					( fecha_ingreso , idcargo , idpersona ) 
				VALUES ( 
					'{$this->atrFormulario["datFechaIngreso"]}' ,
					'{$this->atrFormulario["cmbCargo"]}' ,
					'{$piIdPersona}'  
				); ";
			$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
			if ( parent::faVerificar() ) //verifica si se ejecuto bien
				return $tupla;
			else
				return false;
		}
	}
	//funcion.modelo.Insertar
	function InsertarUsuario( $piIdPersona ) {
		$vsId = NULL ;

		$arrUsuario = $this->BuscarUsuario( $this->atrFormulario["numCi"] );
		if ( $arrUsuario ) {
			return "ya existe un usuario";
		}
		else {
			$sql = "
				INSERT INTO tusuario 
					( usuario , idpersona , idtipo_usuario, estatus )
				VALUES
					( '{$this->atrFormulario["numCi"]}' , 
					'{$piIdPersona}' ,
					'{$this->atrFormulario["cmbTipo_Usuario"]}' ,
					'completar' ) ; ";
			$vsId = parent::faUltimoId( $sql ); //ejecuta la sentencia y obtiene el ID 
		}
		if ( $vsId > 0 ) //verifica si se ejecuto bien
			return $this->fmInsertarClave( $vsId ); //envia el id para insertar la clave
		else
			return false;
	}


	//funcion.modelo.Insertar
	function fmInsertarClave( $piIdUsuario ) {

		$objCifrado = new clsCifrado(); //instancia el objeto de cifrado
		//nacionalidad, guion, documento. Ejemplo. V-12345678
		$clave_encriptada = $objCifrado->flEncriptar( $this->atrFormulario["cmbNacionalidad"] . "-" . $this->atrFormulario["numCi"] );
		unset( $objCifrado );

		$sql = "INSERT INTO thistorial_clave
					( clave , fecha_creacion , estatus , id_usuario )
				VALUES
					( '{$clave_encriptada}' ,  CURRENT_DATE , '3' , '{$piIdUsuario}' ) ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql

		if ( parent::faVerificar( $tupla ) ) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
	}


	function Modificar() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}' 
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function Desbloquar() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				estatus = 'activo' 
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numUsuario"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}


	function Bloquear() {
		$sql = "
			UPDATE {$this->atrTabla}  
			SET 
				estatus = 'bloqueado' 
			WHERE 
				{$this->atrId} = '{$this->atrFormulario["numUsuario"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar() ) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	function consultar() {
		$sql = "
			SELECT * FROM {$this->atrTabla}  
			WHERE {$this->atrId} = '{$this->atrFormulario["numId"]}' ";
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




	function BuscarUsuario( $piCi ) {
		$sql = "
			SELECT * FROM {$this->atrTabla}  
			WHERE 
				usuario = {$piCi} ";
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
			FROM  {$this->atrTabla} "; //selecciona todo el contenido de la tabla

		if ( $psBuscar != "" ) {
			$sql .= "
				WHERE
					{$this->atrNombre} LIKE '%{$psBuscar}%' OR
					{$this->atrId} LIKE '%{$psBuscar}%' ;";
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
