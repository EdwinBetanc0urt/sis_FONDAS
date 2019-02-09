<?php

/**
 * Clase para la conexión hacia el servidor de base de datos y métodos para la
 * consulta de los datos, y métodos globales para uso de las clases extendidas.
 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com>
 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @link https://creativecommons.org/licenses/by-sa/4.0/
 */

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

require_once("dato_system.php");

if (is_file("_core" . DS . "db_conexion.php")) {
	require_once("_core" . DS . "db_conexion.php");
}
else {
	require_once(".." . DS . "_core" . DS . "db_conexion.php");
}

if (is_file("_core" . DS . "config.php")) {
	require_once("_core" . DS . "config.php");
}
else {
	require_once(".." . DS . "_core" . DS . "config.php");
}

if(is_file("public" . DS . "lib_Agente.php")){
	require_once("public" . DS . "lib_Agente.php");
}
else{
	$ruta = "../";
	require_once(".." . DS . "public" . DS . "lib_Agente.php");
}

if(is_file("public" . DS . "lib_Cifrado.php")){
	require_once("public" . DS . "lib_Cifrado.php");
}
else{
	require_once(".." . DS . "public" . DS . "lib_Cifrado.php");
}


// Clase Abstracta para acceder al SMBD utilizando mysqli procedimental
class clsConexion {

	//private para que la variable/función solamente se pueda utilizar desde la misma clase que las define.
	private $atrServidor, $atrUsuario, $atrClave, $atrBaseDatos, $atrConexion, $atrLlaveMaestra;

	/**
	 * función constructor de la clase
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param string $psPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	protected function __construct($psPrivilegio = "") {
		$this->atrServidor = HOST; //atributo Servidor
		$this->atrUsuario = USER; //atributo Usuario
		$this->atrClave = PASSWORD; //atributo Clave
		$this->atrBaseDatos = BD;  //atributo Base de Datos
		$this->atrConexion = $this->faConectar(); //atributo de Conexión o link
	} // cierre de la función constructor


	/**
	 * funcion abstracta Conectar, mysqli conecta SMDB y BD
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	private function faConectar() {
		$vbConexion = mysqli_connect($this->atrServidor, $this->atrUsuario, $this->atrClave, $this->atrBaseDatos);
		if ($vbConexion) {
			if (! mysqli_set_charset($vbConexion, "utf8")){
				echo "<b>no se pudo cambiar el conjunto de caracteres</b> <hr>";
			}
			// header("Content-Type: text/html; charset=utf-8");
			return $vbConexion;
		}
		else {
			header("Content-Type: text/html; charset=utf-8");
			die ("
				<br /><br />
				<b>Error al Realizar la Conexión con el Servidor, </b>
				utilice el siguiente error y contacte al soporte técnico para la pronta solución:
				<br /><br />
				<hr /><li><b>" . mysqli_connect_error(). "</b></li>");
			return false;
		}
	} // cierre de la función


	/**
	 * función abstracta Desconectar, cierra la conexión actual
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param link, o enlace de conexión (tomado directamente del constructor)
	 * @return boolean, Dependiendo si se cerro o no la conexión actual con el servidor
	 */
	public function faDesconectar() {
		if (mysqli_close($this->atrConexion)) {
			//echo "<br><br><hr> <b>¡Base de Datos cerrada con exito!</b> <br><br> ";
			return true;
		}
		else {
			header("Content-Type: text/html;charset=utf-8");
			echo "<br /><br /><hr> <b>¡Error al intentar cerrar la Base de Datos!</b> <br><br> ";
			return false;
		}
	} // cierre de la función


	/**
	 * función abstracta Liberar Consulta, libera de la memoria del servidor los
 	 * resultados obtenidos
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object $pmConsulta, tupla o recordset (solo con SELECT)
	 */
	public function faLiberarConsulta($pmConsulta) {
		mysqli_free_result($pmConsulta);
	} // cierre de la función


	// función abstracta Ejecutar, ejecuta cualquier operación en la base de datos
	// parámetro del modelo SQL
	protected function faEjecutar($pmSQL) {
		//$this->faConectar();
		return mysqli_query($this->atrConexion, $pmSQL); // se ejecuta el query
	} // cierre de la función
	protected function faEjecutar2($pmSQL, $pmConsulta=false) {
		if (! $pmConsulta) {
			faEjecutar3($pmSQL);
		}
		//$this->faConectar();
		return mysqli_query($this->atrConexion, $pmSQL); // se ejecuta el query
	} // cierre de la función
	protected function faEjecutar3($pmSQL){
		$Usuario = $_SESSION['id'];
		$sql2="INSERT INTO tAuditoria(
				usuario, operacion, fecha_insertado
			)
			VALUES('{$Usuario}', '{$pmSQL}', CURRENT_TIMESTAMP())";
		//var_dump($sql2);
		return mysqli_query($this->atrConexion, $sql2); // se ejecuta el query
	}


	//funcion abstracta Verificar, verifica si las operaciones Inc,Con,Mod,Eli se ejecutan bien
	protected function faVerificar($RecordSet = "") {
		// si las columnas afectadas son mayores a cero, es decir 1 o mas
		if (mysqli_affected_rows($this->atrConexion) > 0)
			return true; //retorna verdadero
		else
			return false; //retorna falso si no se afecto ninguna columna
	} // cierre de la función


	/**
	 * función que envía y sanea los datos del controlador al constructor en
	 * conjunto con la función sanearFormulario que detectan cuando hay un arreglo
	 * y lo recorre para limpiarlo, es decir existe un arreglo multidimensional
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param array $pcForm, trae todo lo enviado de la vista mediante el arreglo global $_POST
	 * @return array $this->atrFormulario, arreglo agregado al constructor con todos los valores y quitando las primeras 3 letras de la clave
	 */
	public function setFormulario($pcForm) {
		foreach ($pcForm as $clave => $valor) {
			$clave_new = $clave ;

			if (is_array($pcForm[$clave])) {
				$this->atrFormulario[$clave_new] = $this->sanearSubFormulario($pcForm[$clave]);
			}
			else {
				//la clave es igual a ctxRuta sanea de forma diferente
				if ($clave == "pswClave" || $clave == "ctxRuta" || $clave == "ctxRespuesta"
					|| $clave == "ctxRespuesta1" || $clave == "ctxRespuesta2") {
					//sanea pero sin pasar a minúsculas ya que la ruta es sensible
					$this->atrFormulario[$clave] = htmlentities(
						addslashes(trim($valor))
					);
				}
				else {
					//la clave debe ser diferente a setBusqueda, ya que de lo contrario
					//se debe modificar todos los controladores y pasar el termino de
					//búsqueda como parámetro para el fmListarIndex de los modelos
					if ($valor == "" AND $clave != "setBusqueda") {
						$this->atrFormulario[$clave_new] = NULL;
					}
					else {
						$this->atrFormulario[$clave_new] = htmlentities(
							addslashes(trim($pcForm[$clave]))
						);
					}
				}
			}
		}
	} // cierre de la función
	public function sanearSubFormulario($pcForm) {
		$arrFormulario = array();
		foreach ($pcForm as $clave => $valor) {
			$clave_new = $clave ;

			if (is_array($pcForm[$clave])) {
				$arrFormulario[$clave_new] = $this->sanearSubFormulario($pcForm[$clave]);
			}
			else {
				if ($valor == "")
					$arrFormulario[$clave_new] = NULL;
				else
					$arrFormulario[$clave_new] = htmlentities(addslashes(trim($pcForm[$clave])));
			}
		}
		return $arrFormulario;
	} // cierre de la función


	/**
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	public function UltimoCodigo() {
		$sql= "SELECT MAX({$this->atrId}) AS id
				FROM {$this->atrTabla}  ; ";
		$tupla = $this->faEjecutar($sql); //Ejecuta la sentencia sql
		$arreglo = $this->getConsultaNumerico($tupla);
		$this->faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
		return $arreglo; //sino encuentra nada devuelve un cero
	}



	/*****************************************************************************
						FUNCIONES RELACIONADAS A CONSULTAS
	*****************************************************************************/

	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por nombre de indice y asociados por numero (o posición) de indice
	 */
	public function getConsultaArreglo($pmRecordSet) {
		return mysqli_fetch_array($pmRecordSet);
	} // cierre de la función


	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por por numero (o posición) de indice
	 */
	public function getConsultaNumerico($pmRecordSet) {
		return mysqli_fetch_row($pmRecordSet);
	} // cierre de la función


	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por nombre de indice
	 */
	public function getConsultaAsociativo($pmRecordSet) {
		return mysqli_fetch_assoc($pmRecordSet);
	} // cierre de la función


	/**
	 * función que devuelve los datos de una consulta en objeto
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return object, el parámetro convertido en un objeto (accede solamente al nombre del campo)
	 */
	public function faCambiarObjeto($pmRecordSet) {
		return mysqli_fetch_object($pmRecordSet);
	} // cierre de la función


	/**
	 * función que devuelve los el numero de columnas de una consulta
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object sql, $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return object sql integer, devuelve el numero total de filas en esa consulta
	 */
	public function getCuentaColumnas($pmRecordSet) {
		return mysqli_fetch_lengths($pmRecordSet);
	} // cierre de la función


	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * utilizada al hacer la paginacion de los listados
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return object el numero total de filas en esa consulta del parámetro enviado
	 */
	public function getNumeroFilas($pmRecordSet) {
		return mysqli_num_rows($pmRecordSet);
	} // cierre de la función



	/*****************************************************************************
						FUNCIONES RELACIONADAS A TRANSACCIONES
	*****************************************************************************/


	/**
	 * función abstracta Ultimo ID, funciona solo para las clave primaria INT y
	 * auto incrementable
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param string $pmSQL, Consulta del insert a extraer el numero de insersion
	 * @return integer del numero de insersion, si es 0 no se inserto nada
	 */
	//parametro modelo SQL
	public function faUltimoId($pmSql) {
		$this->faEjecutar($pmSql); // se ejecuta el query
		return mysqli_insert_id($this->atrConexion);  //obtiene el ultimo id, e inserta 1+
	} // cierre de la función


	//funcion abstracta Ultimo ID, funciona solo para las clave primaria INT y autoincrementables
	//parametro modelo SQL
	public function faUltimoId2($pmSql) {
		$pmSql .= " SELECT @@identity AS id ; ";
		$RecordSet = $this->faEjecutar($pmSql);
		//return mysqli_fetch_array($RecordSet); // se ejecuta el query
		return $pmSql; // se ejecuta el query
	} // cierre de la función


	/**
	 * funcion abstracta Transacción Inicio, indica el comienzo de la transacción
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	public function faTransaccionInicio() {
		$this->faEjecutar("START TRANSACTION;");
		//$this->fmEjecutar("BEGIN");
	} // cierre de la función


	/**
	 * funcion abstracta Transacción Fin, indica que la transacción culmino
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	public function faTransaccionFin() {
		$this->faEjecutar("COMMIT;");
	} // cierre de la función


	/**
	 * función abstracta Transacción Deshace. devuelve al estado anterior del
	 * inicio de la transacción cada cambio hecho
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	public function faTransaccionDeshace() {
		$this->faEjecutar("ROLLBACK;");
	} // cierre de la función


	/**
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param string $pmFecha, cadena de la fecha a convertir
	 * @param string $pmFormatoE, formato en el que se envió la fecha
	 * @param string $pmFormatoR, formato en el que se retornara la fecha
	 * @return string $lsFecha, fecha a convertida en el formato indicado
	 */
	public function faFechaFormato($pmFecha = "" , $pmFormatoE = "amd" , $pmFormatoR = "dma") {
		if ($pmFecha == "") {
			$lsActual = date("Y-m-d"); //fecha actual php para servidor
			//$lsActual="NOW()"; //fecha actual SQL para servidor

			$lsDiaSemanaN = date("N"); // día de la semana en números, 1 (lunes) a 7 (domingo)
			$lsDiaSemanaC = date("D"); // día de la semana en letras cortas, Mon a Sun
			$lsDiaSemanaL = date("l"); // día de la semana en letras largas, Sunday a Saturday

			$lsDia = date("d"); // día del mes, 01 a 31
			$lsDiaS = date("j"); // día del mes sin ceros delate, 1 a 31

			$lsMes = date("m"); // mes del año en números, 01 a 12
			$lsMesS = date("n"); // mes del año en números sin ceros, 1 a 12
			$lsMesC = date("M"); // mes del año en letras, Jan a Dec
			$lsMesL = date("F"); // mes del año en letras, January a December

			$lsAnoC = date("y"); // dos últimos dígitos del año, 16
			$lsAno = date("Y"); // año en cuatro dígitos, 2016
		}

		else {
			switch ($pmFormatoE) {
				default:
				case 'dma':
					$lsDia = substr($pmFecha , 0 , 2);
					$lsMes = substr($pmFecha , 3 , 2);
					$lsAno = substr($pmFecha , 6 , 4);
					break;

				case 'amd':
					$lsDia = substr($pmFecha , 8 , 2);
					$lsMes = substr($pmFecha , 5 , 2);
					$lsAno = substr($pmFecha , 0 , 4);
					break;

				case 'mda':
					$lsDia = substr($pmFecha , 3 , 2);
					$lsMes = substr($pmFecha , 0 , 2);
					$lsAno = substr($pmFecha , 6 , 4);
					break;
			}
		}

		switch ($pmFormatoR) {
			default:
			case 'amd':
				// año - mes - dia
				$lsFecha = $lsAno . "-" . $lsMes . "-" . $lsDia;
				break;

			case 'dma':
				// dia - mes - año
				$lsFecha = $lsDia . "-" . $lsMes . "-" . $lsAno;
				break;

			case 'mda':
				// mes - dia - año
				$lsFecha = $lsMes . "-" . $lsDia . "-" . $lsAno;
				break;


			case 'am':
				// año - mes
				$lsFecha = $lsAno . "-" . $lsMes;
				break;

			case 'ad':
				// año - dia
				$lsFecha = $lsAno . "-" . $lsDia;
				break;

			case 'ma':
				// mes - año
				$lsFecha = $lsMes . "-" . $lsAno;
				break;

			case 'md':
				// mes - dia
				$lsFecha = $lsMes . "-" . $lsDia;
				break;

			case 'dm':
				// dia - mes
				$lsFecha = $lsDia . "-" . $lsMes;
				break;

			case 'da':
				// dia - año
				$lsFecha = $lsDia . "-" . $lsAno;
				break;

			case 'dM':
				// dia - año
				$dia = date("d", strtotime(date("Y") . "-" . $lsMes . "-" . $lsDia));
				setlocale(LC_TIME, "ESP");
				$mes = strftime("%B", strtotime(date("Y") . "-" . $lsMes . "-" . $lsDia));
				$lsFecha = $dia . " de " . $mes;
				//$lsFecha =  strtotime($pmFecha);
				break;

		}
		return $lsFecha;
	} // cierre de la función

} // cierre de la clase



// Clase para imprimir en la consola del navegador
class console {

	// función estática se accede de la forma console::log($mensaje);
	public static function log($psMensaje = "PHP consola" , $psTipo = "log") {
		echo '
			<script type="text/javascript">
				console.' . $psTipo . '("' . json_encode($psMensaje) . '");
			</script>';
	} // cierre de la función

} // cierre de la clase


?>
