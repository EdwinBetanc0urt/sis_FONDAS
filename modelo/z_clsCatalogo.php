<?php
include_once('clsConexion.php');

class Catalogo extends clsConexion {

	function __construct() {
		parent::__construct(); //instancia al constructor padre
		
		$this->atrTabla = "trenglon_ausencia";
		$this->atrId = "idrenglon";
		
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


	function Modificar() {
		$sql = "
			update {$this->atrTabla}  
			set 
				nombre='{$this->descripcion},
				coddepartamento='{$this->departamento}' 
			where 
				codnivel='{$this->codigo}'";
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

  
 }
?>
