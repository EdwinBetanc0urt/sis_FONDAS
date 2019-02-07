<?php

include_once('clsConexion.php');

class Acceso extends clsConexion {
	//atributos de la tabla y clase
	private $atrTablaV, $atrTablaB, $atrId_P, $atrClase;
	public $atrVista;


	/**
	 * constructor de la clase
	 * @param integer $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct( $piPrivilegio = 2 ) {
		parent::__construct( $piPrivilegio ); //instancia al constructor padre
		$this->atrTabla = "tacceso";
		$this->atrId = "idacceso";
		
		$this->atrFormulario = array();
		$this->atrBotones = array();

		$this->atrIdTipoUsuario = "";
		$this->atrIdModulo = "";

		$this->atrId_Tipo_U = ""; //atributo Id
		$this->atrId_Modulo = ""; //atributo Id

		$this->atrId = ""; //atributo Id
		$this->atrOrden = "";
		$this->atrTipoOrden = "";
	}


	function setBotones( $pcForm ) {
		$this->atrBotones = $pcForm;
	}


 	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarModulo( $psBusquedaModulo = "" ) {
		$sql = "
			SELECT M.nombre as modulo, M.idmodulo , M.icono
			FROM tmodulos AS M 
			INNER JOIN tvistas AS V 
				ON V.idmodulo = M.idmodulo 
			INNER JOIN tacceso AS A
				ON A.idvista = V.idvista
   
        	WHERE
       			A.idtipo_usuario = '{$this->atrIdTipoUsuario}'
			GROUP BY M.idmodulo 
			ORDER BY M.posicion ASC;";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}
 
	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarVista( $piModulo = "" ) {
		$sql = "
			SELECT V.idvista , V.nombre AS vista, V.url
			FROM tvistas	 AS V

			INNER JOIN tacceso AS A
			ON A.idvista = V.idvista

			WHERE
				A.idtipo_usuario = '{$this->atrIdTipoUsuario}' AND
				idmodulo = '$piModulo' 
				GROUP BY idvista
				ORDER BY orden; ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}
 
	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarBoton( $piVista = "") {
		$sql = "
			SELECT A.idacceso, B.nombre, B.idboton, B.icono, V.idvista , V.nombre AS vista, V.url
			FROM tvistas	 AS V

			INNER JOIN tacceso AS A
				ON A.idvista = V.idvista
			INNER JOIN tboton AS B
				ON B.idboton = A.idboton

			WHERE
				A.idtipo_usuario = '{$this->atrIdTipoUsuario}' AND
				V.idvista = '$piVista' 
				ORDER BY B.orden;";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}



	//funcion.modelo.Insertar
	function fmInsertar() {
		//parent::faTransaccionInicio();
		$liCont = 0; //contador de errores
		//var_dump( $this->atrFormulario["chkBoton"] );
		foreach ( $this->atrBotones as $lkey => $lvalor  ) {
			//var_dump( $lkey );
			foreach ( $lvalor as $key => $value) {
				$sql = "
					INSERT INTO {$this->atrTabla}	
						( idtipo_usuario , idboton, idvista  ) 
					VALUES 
						( '{$this->atrFormulario["cmbTipo_Usuario"]}' , '{$value}' , '{$lkey}' ) ; ";
				//echo "$sql";
				$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
				if ( !parent::faVerificar( $tupla ) ) //verifica si se ejecuto bien
					$liCont = $liCont + 1;
			//*/
			}
		}
		if ( $liCont > 0 ) {
			//parent::faTransaccionDeshace();
			return false;
		}
		else {
			//parent::faTransaccionFin();
			return true;
		}
	}



	//funcion.modelo.Eliminar
	function fmEliminar() {
		$sql = "
			DELETE A.*

				FROM tacceso AS A

				INNER JOIN tvistas AS V
				ON A.idvista = V.idvista

				INNER JOIN tmodulos AS M
				ON M.idmodulo = V.idmodulo

				WHERE
					M.idmodulo = '{$this->atrFormulario["cmbModulo"]}' AND
					A.idtipo_usuario = '{$this->atrFormulario["cmbTipo_Usuario"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) ) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
		//echo "$sql <hr>";
	}



	//funcion.modelo.Eliminar
	function fmEliminarVista() {
		$sql = "
			DELETE FROM tacceso
			
			WHERE
				idvista = '{$this->atrFormulario["setVista"]}' AND 
				idtipo_usuario = '{$this->atrFormulario["setTipoUsuario"]}' ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		echo $sql;
		if ( parent::faVerificar( $tupla ) ) //verifica si se ejecuto bien
			return $tupla; //envia el arreglo
		else
			return false;
		//echo "$sql <hr>";
	}



	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarConAcceso( $pcBusqueda = "" ) {
		$sql = "SELECT * 
				FROM vacceso
				WHERE
					idtipo_usuario = '{$this->atrId_Tipo_U}' 
					AND	vista LIKE '%{$pcBusqueda}%' 
				GROUP BY idvista";

		if ( $this->atrOrden != "" )
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";
		
		$this->atrTotalRegistros = parent::getNumeroFilas( parent::faEjecutar( $sql ) );
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio} , {$this->atrItems} ; "; 
		//echo "<pre>$sql";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}

	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarAcceso( $pcBusqueda = "" ) {
		$sql = "SELECT * 
				FROM vacceso
				WHERE
					idtipo_usuario = '{$this->atrId_Tipo_U}' AND
					idmodulo = '{$this->atrId_Modulo}' 
					AND	vista LIKE '%{$pcBusqueda}%' 
				GROUP BY idvista";

		if ( $this->atrOrden != "" )
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}
	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarVistas( $pcBusqueda = "" ) {
		$sql = "SELECT V.* , M.nombre AS modulo
				FROM tvistas AS V
				INNER JOIN tmodulos AS M
					ON M.idmodulo = V.idmodulo
				WHERE
					V.idmodulo = '{$this->atrId_Modulo}' 
					AND	V.nombre LIKE '%{$pcBusqueda}%' ";

		if ( $this->atrOrden != "" )
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}

	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarAccesoModulosUsuario( $piUsuario = "" ) {
		$sql = "SELECT idmodulo , modulo
				FROM vacceso AS V
				INNER JOIN tusuario AS U
					ON V.idtipo_usuario = U.idtipo_usuario
				WHERE
					U.id_usuario = '{$piUsuario}'
					GROUP BY idmodulo ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}
	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarAccesoVistasUsuario( $piUsuario = "" , $piModulo = "" ) {
		$sql = "SELECT V.* 
				FROM vacceso AS V
				INNER JOIN tusuario AS U
					ON V.idtipo_usuario = U.idtipo_usuario
				WHERE
					U.id_usuario = '{$piUsuario}' AND
					V.idmodulo = '{$piModulo}' 
				GROUP BY V.idvista";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}
	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarAccesoBotonessUsuario( $piUsuario = "", $piVista ="") {
		$sql = "SELECT V.* 
				FROM vacceso AS V
				INNER JOIN tusuario AS U
					ON V.idtipo_usuario = U.idtipo_usuario
				WHERE
					U.id_usuario = '{$piUsuario}' AND
					V.idvista = '{$piUsuario}' ";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}

	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarSinAcceso( $pcBusqueda = "" ) {
		$sql = "SELECT 
					V.idvista, V.nombre AS vista , M.idmodulo, M.nombre AS modulo
				FROM tvistas AS V , tmodulos AS M
				WHERE 
					V.idvista NOT IN ( 
						SELECT A.idvista
						FROM vacceso AS A
						WHERE 
							idtipo_usuario = '{$this->atrId_Tipo_U}'
					)  AND
					( V.nombre LIKE '%{$pcBusqueda}%' OR
					M.nombre LIKE '%{$pcBusqueda}%' ) AND
					M.idmodulo = V.idmodulo " ; //*/

		if ( $this->atrOrden != "" )
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas( parent::faEjecutar( $sql ) );
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);
		
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio} , {$this->atrItems} ; "; 
		//echo "$sql";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}



	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarBotonSi( $pcBusqueda = "" ) {
		
		$sql = "SELECT *

				FROM vacceso
				WHERE 
					idtipo_usuario = '{$this->atrId_Tipo_U}' AND
					idvista = '{$this->atrVista}' " ;

		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}



	//función.modelo.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function ListarBotonNo( $pcBusqueda = "" ) {
		$sql = "
			SELECT idboton, nombre AS boton 
			FROM tboton " ;
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		if ( parent::faVerificar( $tupla ) )
			return $tupla;
		else
			return false;
	}



	/**
	 * @param string $psVista Nombre o URL de la vista
	 * @return integer $arrVista[0] del codigo segun el nombre de la vista
	 */
	function fmConsultaCodigoVista( $psVista ) {
		$sql = "SELECT id_vista 
				FROM tconf_VISTA_m 
				WHERE 
					url_vista = '{$psVista}' 
				LIMIT 1 ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			$arrVista = parent::getConsultaArreglo( $tupla );
			parent::faLiberarConsulta( $tupla ); //libera de la memoria la consulta obtenida
			return $arrVista["id_vista"]; 
		}
		else
			return false;
	}



	/**
	 * @param integer $piRol el codigo del rol que se le consulta el acceso
	 * @param integer $piVista el codigo de la vista que se le consulta el acceso
	 * @return bool Si consiguio o no dentro de los registros accesos consultados
	 */
	function  fmConsultaAccesoVista( $piRol , $piVista ) {
		$sql = "SELECT id_vista 
				FROM vacceso 
				WHERE 
					idtipo_usuario = '{$piRol}' AND 
					id_vista = '{$piVista}'
				LIMIT 1 ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			parent::faLiberarConsulta( $tupla ); //libera de la memoria la consulta obtenida
			return true; 
		}
		else
			return false;
	}



	/**
	 * @param integer $piRol el codigo del rol que se le consulta el acceso
	 * @param integer $piVista el codigo de la vista que se le consulta el acceso
	 * @param integer $piBoton el codigo del boton que se le consulta el acceso
	 * @return bool Si consiguio o no dentro de los registros accesos consultados
	 */
	function  fmConsultaAccesoBoton( $piRol , $piVista , $piBoton ) {
		$sql = "SELECT id_vista 
				FROM vacceso 
				WHERE 
					idtipo_usuario = '{$piRol}' AND 
					id_vista = '{$piVista}' AND
					id_boton = '{$piBoton}'
				LIMIT 1 ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			parent::faLiberarConsulta( $tupla ); //libera de la memoria la consulta obtenida
			return true; 
		}
		else
			return false;
	}



	function fmVistaBotonRol( $piRol ) {
		$sql = "SELECT id_vista 
				FROM vacceso 
				WHERE idtipo_usuario='$piRol' 
				GROUP by id_vista ; ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			$arrRetorna = array();
			$arrBoton = array();
			$viCont = 0;
			//convierte el RecordSet en un arreglo
			while ( $arrConsulta = parent::getConsultaArreglo( $tupla ) ) {
				//var_dump( $arrConsulta);

				$code = $arrConsulta["id_vista"];
				$name = $arrConsulta["id_vista"];
				$arrRetorna["vista_" . $code] = $name; //a la posicion con el codigo se le asigna el valor del nombre
				$arrBoton = $this->fmBotonRol( $piRol , $code );
				$arrRetorna["boton_" . $code] = $arrBoton; //a la posicion con el codigo se le asigna el valor del nombre
				echo "$viCont";
				$viCont++;
			}
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}

	function fmVistasRol( $piRol ) {
		$sql = "SELECT id_vista , vista
				FROM vacceso 
				WHERE idtipo_usuario='$piRol' 
				GROUP by id_vista ; ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			$arrRetorna = array();
			$viCont = 0;
			//convierte el RecordSet en un arreglo
			while ( $arrConsulta = parent::getConsultaArreglo( $tupla ) ) {
				//var_dump( $arrConsulta);


				$code = $arrConsulta["id_vista"];
				$name = $arrConsulta["id_vista"];

				array_push($arrRetorna, array( $code => $name , "pera" => 2) );


				$arrRetorna["vista_" . $code] = $name; //a la posicion con el codigo se le asigna el valor del nombre
				echo "$viCont";
				$viCont++;
			}
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}


	function fmBotonRol( $piRol , $piVista ) {
		$sql = "SELECT id_boton , boton
				FROM vacceso 
				WHERE idtipo_usuario='$piRol' AND id_vista = '$piVista' ; ";
		//echo "$sql";
		$tupla = parent::faEjecutar( $sql ); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if ( parent::faVerificar( $tupla ) ) {
			$arrRetorna = array();
			//convierte el RecordSet en un arreglo
			while ( $arrConsulta = parent::getConsultaArreglo( $tupla ) ) {
				//var_dump( $arrConsulta);
				$name = $arrConsulta["boton"];
				$code = $arrConsulta["id_boton"];

				$arrRetorna[ $code] = $name; //a la posicion con el codigo se le asigna el valor del nombre
				//$arrAhora[ $arrConsulta["id_boton"] ] = $arrConsulta["id_boton"]
				//array_push($arrRetorna, array( $code => $name ) );
			}
			parent::faLiberarConsulta( $tupla ); //libera de la memoria el resultado asociado a la consulta
			//var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}



} //cierre de la clase

?>