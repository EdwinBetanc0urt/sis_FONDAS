<?php

/**
 * Vacaciones Venezuela
 *
 * @descripción: Vacaciones Venezuela - clase PHP para obtener los diferentes 
 * cálculos relacionados a vacaciones
 * @author: Edwin Betancourt <EdwinBetanc0urt@hotmail.com> 
 * @license: GNU GPL v3,  Licencia Pública General de GNU 3.
 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @category Librería.
 * @package: lib_Vacaciones.php.
 * @since: v0.3.
 * @version: 0.7.
 * @Fecha de Modificación: 11/Febrero/2019
 * @Fecha de Creación: 05/Marzo/2018

		Este programa es software libre, su uso, redistribución, y/o modificación
	debe ser bajo los términos de las licencias indicadas, la GNU Licencia Pública
	General (GPL) publicada por la Fundación de Software Libre(FSF) de la versión
	3 o cualquier versión posterior y la Creative Commons Atribución - Compartir
	Igual (CC BY-SA) de la versión 4.0 Internacional o cualquier versión posterior.

		Este software esta creado con propósitos generales que sean requeridos,
	siempre que este sujeto a las licencias indicadas, pero SIN NINGUNA GARANTÍA
	Y/O RESPONSABILIDAD que recaiga a los creadores, autores y/o desarrolladores,
	incluso sin la garantía implícita de COMERCIALIZACIÓN o IDONEIDAD PARA UN
	PROPÓSITO PARTICULAR. Cualquier MODIFICACIÓN, ADAPTACIÓN Y/O MEJORA	que se haga
	a partir de este código debe ser notificada y enviada a la fuente, comunidad
	o repositorio de donde fue obtenida, y/o a sus AUTORES.
 **/

/**
	Características:
		* calculo según la fecha de ingreso, los periodos de vacaciones.
		* calcula los años de antigüedad.
		* cantidad de días correspondientes de vacaciones
		* fecha de reincorporación tomando en cuenta los días no hábiles.
		  o no laborables y días festivos si existen.
		* Lista los periodos disponibles según los usados y el tipo de persona.

	Próximamente:
		* calculo de días de semana santa y carnaval para tomar en cuenta en días hábiles.
		* calculo de bonos según la antigüedad.
		* calculo de pagos correspondiente en las vacaciones.
		* vacaciones colectivas.

	Consideraciones:
		* CRBV, Constitución de la República Bolivariana de Venezuela 1999:
			Titulo III, Capitulo I articulo 90.
		* LOTTT, Ley Orgánica del Trabajo, los Trabajadores y las Trabajadoras:
			Titulo III, Capitulo IX
		* LCA, Ley de Carrera Administrativa:
			Titulo II, Capitulo I.
*/

class vacacion
{
	public $atrDiasVacaciones = 15; // días correspondientes de vacaciones según la LOTTT
	public $atrTipoPersona = "R"; // tipo de persona Regular o Funcionario

	/**
	 * @param string $psFechaIngreso Fecha de inicio en formato Y-m-d
	 * @param string $piMaxPeriodos máximo acumulado 2 periodos art 199 LOTTT y
	 *  1 o no acumulativo art 19 LCA
	 */
	function __construct($psFechaIngreso = "", $psTipoPersona = "R")
	{
		$this->atrFechaIngreso = trim($psFechaIngreso);
		$this->atrTipoPersona = trim($psTipoPersona);
		$this->setAsignarValores(); 
	} // cierre del constructor


	private function setAsignarValores()
	{
		if (strtoupper($this->atrTipoPersona) == "F") {
			$this->atrMaxPeriodo = 1;
			$this->atrPeriodo = 5; // cada 5 años
			$this->atrTipoPeriodo = "Quinquenio"; // cada 5 años
		}
		else {
			$this->atrMaxPeriodo = 2;
			$this->atrPeriodo = 1; // cada año
			$this->atrTipoPeriodo = "Año(s)"; // cada año
		}
	} // cierre de la función


	/**
	 * @param string $psFechaIngreso Fecha de inicio en formato Y-m-d
	 * @param string $psFechaPeriodo fecha del periodo a calcular la antigüedad Y-m-d
	 */
	static function getAntiguedad($psFechaIngreso, $psFechaPeriodo = "")
	{
		if (trim($psFechaPeriodo) == "") {
			$psFechaPeriodo = date("Y-m-d");
		}

		$objFecha_Ingreso = new DateTime($psFechaIngreso);
		$objFecha_Periodo = new DateTime($psFechaPeriodo);

		$objAnos = $objFecha_Periodo->diff($objFecha_Ingreso);
		$liAntiguedad = intval($objAnos->y);

		unset($objFecha_Ingreso, $objFecha_Periodo, $objAnos);

		return $liAntiguedad;
	} // cierre de la función


	/**
	 * VERIFICAR USO
	 * @param string $psFechaIngreso Fecha de inicio en formato Y-m-d
	 * @param string $psFechaPeriodo fecha del periodo a calcular la antigüedad Y-m-d
	 */
	function getAntiguedadPeriodo($psFechaIngreso = "", $psFechaPeriodo = "")
	{
		if (trim($psFechaIngreso) == "") {
			$psFechaIngreso = $this->atrFechaIngreso;
		}
		if (trim($psFechaPeriodo) == "") {
			$psFechaPeriodo = date("Y-m-d");
		}

		$objFecha_Ingreso = new DateTime($psFechaIngreso);
		$objFecha_Periodo = new DateTime($psFechaPeriodo);

		$objAnos = $objFecha_Periodo->diff($objFecha_Ingreso);
		$liAntiguedad = intval($objAnos->y);

		return $liAntiguedad;
	} // cierre de la función


	static public function getPeriodosAntiguedad($psFechaIngreso)
	{
		//$lsAno = substr($psFechaIngreso, 0, 4);
		$lsAno = self::getFechaFormato($psFechaIngreso, "amd", "a");
		$liAntiguedad = self::getAntiguedad($psFechaIngreso);

		$arrRetorno = array();
		if ($liAntiguedad > 0) {
			for ($liControl = 0; $liControl  <= $liAntiguedad; $liControl ++) { 
				$arrRetorno[$liControl] = $lsAno + $liControl;
			}
		}
		return $arrRetorno;
	} // cierre de la función


	static public function getDetalleDiasVacacionesPeriodo(
		$psFechaIngreso, $paPeriodos = array()
	)
	{
		$lsDia = self::getFechaFormato($psFechaIngreso, "amd", "d");
		$lsMes = self::getFechaFormato($psFechaIngreso, "amd", "m");

		if (! is_array($paPeriodos)) {
			// separa la palabra en cada quien y convierte el string en arreglo
			$paPeriodos = explode("-", $paPeriodos); 
		}

		$liCont = 1;
		$lsVacaciones = 0;
		$arrRetorno = array();
		if (count($paPeriodos) <= 0) {
			$liCont = -1;
		}
		foreach ($paPeriodos as $key => $value) {
			//$antiguedad = self::getAntiguedad($psFechaIngreso, ($value + 1) . "-" . $lsMes . "-" . $lsDia);
			$antiguedad = self::getAntiguedad($psFechaIngreso, ($value + 2) . "-" . $lsMes . "-" . $lsDia);

			$diasvacaciones = self::getDiasVacacionesAntiguedad($antiguedad);

			$arrRetorno["periodo"][$liCont]["anno"] = $value;
			$arrRetorno["periodo"][$liCont]["dias"] = $diasvacaciones;
			$arrRetorno["periodo"][$liCont]["antiguedad"] = $antiguedad;
			$arrRetorno["periodo"][$liCont]["periodos"] = $value . "-" . ($value + 1);

			//unset($objFecha_Periodo);
			$lsVacaciones = $lsVacaciones + $diasvacaciones;
			$liCont ++;
		}

		$arrRetorno["dias_vacaciones"] = $lsVacaciones;
		return $arrRetorno;
	} // cierre de la función


	/**
	 * La formula es 15 + (años de servicio -1)
	 * hasta llegar a 15 días hábiles (30 días de vacaciones en total)
	 */
	static public function getDiasVacacionesAntiguedad($piAntiguedad = "")
	{
		/*
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = self::getAntiguedad($this->atrFechaIngreso);
		}
		else
		*/
		$piAntiguedad = intval(trim($piAntiguedad));
		//$liDiasAntiguedad = $this->atrDiasVacaciones + ($piAntiguedad - 1);
		$liDiasAntiguedad = 15 + ($piAntiguedad - 1);
		if ($liDiasAntiguedad > 30) {
			$liDiasAntiguedad = 30;
		}
		return $liDiasAntiguedad;
	} // cierre de la función


	static function getDiasPorAntiguedad($antiguedad = 0 ) 
	{
		$diasVacaciones = "nada";
		switch ($antiguedad ) {
			
			case ($antiguedad == 1):
				$diasVacaciones = 15;
				break;
			
			case ($antiguedad == 2):
				$diasVacaciones = 16;
				break;
			
			case ($antiguedad == 3):
				$diasVacaciones = 17;
				break;
			
			case ($antiguedad == 4):
				$diasVacaciones = 18;
				break;

			// primer quinquenio de 5 años a 9 años
			case (($antiguedad >= 5) &&($antiguedad <= 9)):
				$diasVacaciones = 19;
				break;

			// segundo quinquenio de 10 años a 14 años
			case (($antiguedad >= 5) &&($antiguedad <= 9)):
				$diasVacaciones = 20;
				break;

			// tercer quinquenio 15 años
			case (($antiguedad >= 10) &&($antiguedad <= 15)):
				$diasVacaciones = 21;
				break;

			// mas de 16 años o mas
			case ($antiguedad >= 16):
				$diasVacaciones = 25;
				break;
		 	
			case ($antiguedad <= 0):
			//default:
				$diasVacaciones = 0;
				break;
		} // cierre del switch

		return $diasVacaciones;
	} // cierre de la función


	/**
	 * Calcula los días que corresponden según el tipo de persona
	 */
	public function getDiasVacaciones($psTipo = "")
	{
		if (trim($psTipo) == "") {
			$psTipo = $this->atrTipoPersona;
		}
		if (strtoupper(trim($psTipo)) == "R") {
			$liDiasAntiguedad = $this->getDiasVacacionesAntiguedad();
		}
		else {
			$liDiasAntiguedad = $this->getDiasVacacionesAntiguedadFuncionario();
		}
		return $liDiasAntiguedad;
	} //cierre de la función


	/**
	 * La formula es 15 + años de servicio 
	 */
	public function getDiasVacacionesBono($piAntiguedad = 0)
	{
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = self::getAntiguedad($this->atrFechaIngreso);
		}
		else
			$piAntiguedad = intval(trim($piAntiguedad));
		$liDiasBono = $this->$atrDiasVacaciones + $piAntiguedad;
		if ($liDiasBono > 30) {
			$liDiasBono = 30;
		}
		return $liDiasBono;
	} // cierre de la función


	public function getDiasVacacionesAntiguedadFuncionario($piAntiguedad = "")
	{
		/*
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = self::getAntiguedad($this->atrFechaIngreso);
		}
		else
		*/
		$piAntiguedad = intval(trim($piAntiguedad));
		$liDiasVacaciones = 0;
		switch ($piAntiguedad) {
			// primer quinquenio de 5 años a 9 años
			case ($piAntiguedad ==  5):
				$liDiasVacaciones = 19;
				break;
			// segundo quinquenio de 10 años a 14 años
			case ($piAntiguedad == 10):
				$liDiasVacaciones = 20;
				break;
			// tercer quinquenio 15 años
			case ($piAntiguedad == 15):
				$liDiasVacaciones = 21;
				break;
			// mas de 16 años o mas
			case ($piAntiguedad >= 16):
				$liDiasVacaciones = 25;
				break;
			case ($piAntiguedad <= 0):
			//default:
				$liDiasVacaciones = 0;
				break;
		} // cierre del switch

		return $liDiasVacaciones;
	} // cierre de la función


	public function getListarPeriodos($paPeriodosUsados = array())
	{
		if (! is_array($paPeriodosUsados)) {
			// separa la palabra en cada quien y convierte el string en arreglo
			if (strpos($paPeriodosUsados, "/"))
				$paPeriodosUsados = explode("/", $paPeriodosUsados);
			else
				$paPeriodosUsados = explode("-", $paPeriodosUsados);
		}

		$arrPeriodos = $this->getPeriodosAntiguedad($this->atrFechaIngreso);
		$arrComparado = array_diff($arrPeriodos, $paPeriodosUsados);
		$arrRetorno = array();
		if ($arrComparado) {
			$arrComparado = array_slice(
				array_diff(
					$arrPeriodos,
					$paPeriodosUsados
				),
				0,
				$this->atrMaxPeriodo
			);
			$liCont = 0;

			foreach ($arrComparado AS $key => $value) {
				if ($liCont > 0) 
					$value = $arrComparado[($liCont-1)] . "-" . $value;
					$arrRetorno[$liCont] = $value;
				$liCont++;
			}
		}
		return $arrRetorno;
	} // cierre de la función


	// Esta pequeña función me crea una fecha de entrega sin sábados ni domingos
	// ni días feriados el formato de fecha inicio es Y-m-d
	static public function getFechaFinal(
		$psFechainicio = "",
		$piDiasHabiles = 0,
		$paDiasferiados = array(),
		$paDiasNoHabiles = array(6,7)
	)
	{
		if (trim($psFechainicio) == "") {
			$psFechainicio = date("Y/m/d");
		}
		/*
		if (trim($piDiasHabiles) == 0) {
			$piDiasHabiles = $this->getDiasVacacionesAntiguedad();
		}
		*/
		//obtenemos la fecha de hoy, solo para usar como referencia al usuario  
		$fechaInicial =  strtotime($psFechainicio); 
		$piDiasHabiles = intval($piDiasHabiles);
		$FechaFinal = 0;
		//$Segundos = 24*60*60;
		$liSegundos = 0;

		//Creamos un for desde 0 hasta los días enviados 

		// enviar el día de que culminan las vacaciones 
		//for ($liDiaRecorrido = 0; $liDiaRecorrido < $piDiasHabiles; $liDiaRecorrido++) {
		// envía el día de que culminan las vacaciones un día hábil adicional para el reingreso
		for ($liDiaRecorrido = 0; $liDiaRecorrido <= $piDiasHabiles; $liDiaRecorrido++) {
			// Acumulamos la cantidad de segundos que tiene un día en cada vuelta del for
			$liSegundos = $liSegundos + 86400;  

			// Obtenemos el día de la fecha, aumentando el tiempo en N cantidad
			// de días 1 al 7, según la vuelta en la que estemos  
			//$diatranscurrido = date("Y-m-d",time() + $Segundos);
			//$diatranscurrido = date("Y-m-d", $fechaInicial + $Segundos);
			//$diaSemanatranscurrido = date("N", $fechaInicial + $Segundos);
			// Comparamos si estamos en sábado o domingo, si es así restamos una
			// vuelta al for, para brincarnos el o los días...
			// DOC: http://www.php.net/manual/es/function.date.php
			if (in_array(date("N", $fechaInicial + $liSegundos), $paDiasNoHabiles)) {
				$liDiaRecorrido--; 
			}
			// DOC: http://www.php.net/manual/es/function.date.php
			elseif (in_array(date('Y/m/d', $fechaInicial + $liSegundos), $paDiasferiados)) {
				$liDiaRecorrido--; 
			}
			else {
				// Si no es sábado o domingo, y el for termina y nos muestra la nueva fecha
				$FechaFinal = date("Y/m/d", $fechaInicial + $liSegundos);
			}
		}

		return $FechaFinal;
	} // cierre de la función


	/**
	 * Método getDiasHabiles
	 *
	 * Permite devolver un arreglo con los días hábiles
	 * entre el rango de fechas dado excluyendo los
	 * días feriados dados (Si existen)
	 *
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechafin Fecha de fin en formato Y-m-d
	 * @param array $paDiasferiados Arreglo de días feriados en formato Y-m-d
	 * @param array $paDiasNoLaboral Arreglo de días no laborables o  tomados como no hábiles,
	 * Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
	 * @return array $arrDiasHabiles Arreglo definitivo de días hábiles
	 */
	public function getCantidadDias($psFechainicio = "", $psFechafin)
	{
		if (trim($psFechainicio) == "") {
			$psFechainicio = date("Y-m-d");
		}

		$inicio = strtotime($psFechainicio);
		$fin = strtotime($psFechafin);
		$liDiferencia = $fin - $inicio;
		$diasFalt = ((($liDiferencia / 60) / 60) / 24);
		return ceil($diasFalt);
		//$liDias = date('Y-m-d', $liDiferencia);
		// return $liDias;
	} // cierre de la función


	/**
	 * Método getDiasHabiles
	 *
	 * Permite devolver un arreglo con los días hábiles
	 * entre el rango de fechas dado excluyendo los
	 * días feriados dados (Si existen)
	 *
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechafin Fecha de fin en formato Y-m-d
	 * @param array $paDiasferiados Arreglo de días feriados en formato Y-m-d
	 * @param array $paDiasNoLaboral Arreglo de días no laborables o  tomados como no hábiles,
	 * Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
	 * @return array $arrDiasHabiles Arreglo definitivo de días hábiles
	 */
	public function getDiasHabiles(
		$psFechainicio = "", $psFechafin, $paDiasferiados = array(),
		$paDiasNoLaboral = array(6,7)
	)
	{
		if (trim($psFechainicio) == "") {
			$psFechainicio = date("Y-m-d");
		}

		// Convirtiendo en timestamp las fechas
		$psFechainicio = strtotime($psFechainicio);
		$psFechafin = strtotime($psFechafin);
		// Incremento en 1 día
		//$liDia = 24*60*60; //86400 segundos
		$liDia = 86400; 

		// Arreglo de días hábiles, inicializacion
		$arrDiasHabiles = array();
		// Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 día
		for ($liDiaRecorrido = $psFechainicio; $liDiaRecorrido <= $psFechafin; $liDiaRecorrido += $liDia) {
			// Si el día indicado, no es sábado o domingo es hábil
			// DOC: http://www.php.net/manual/es/function.date.php
			if (! in_array(date('N', $liDiaRecorrido), $paDiasNoLaboral)) { 
				// Si no es un dia feriado entonces es habil
				if (! in_array(date('Y-m-d', $liDiaRecorrido), $paDiasferiados)) {
					array_push($arrDiasHabiles, date('Y-m-d', $liDiaRecorrido));
				}
			}
		}
		return $arrDiasHabiles;
	} // cierre de la función


	public function getSemanaSanta($psAno = "")
	{
		if ($psAno == "") {
			$psAno = intval(date("Y"));
		}
		return easter_days($psAno);
		// falta sumar esos días al 21 de marzo del año dado para obtener el día
		// en que cae domingo de pascua para carnaval a ese domingo se le restan
		// 47 días
	} // cierre de la función


	// parámetro del modelo FechaBD
	static public function getFechaFormato(
		$pmFecha = "", $pmFormatoE = "amd", $pmFormatoR = "dma"
	)
	{
		if ($pmFecha == "") {
			$pmFecha = date("d-m-Y");
		}

		switch ($pmFormatoE) {
			default:
			case 'dma':
				$lsDia = substr($pmFecha, 0, 2);
				$lsMes = substr($pmFecha, 3, 2);
				$lsAno = substr($pmFecha, 6, 4);
				break;

			case 'amd':
				$lsDia = substr($pmFecha, 8, 2);
				$lsMes = substr($pmFecha, 5, 2);
				$lsAno = substr($pmFecha, 0, 4);
				break;

			case 'mda':
				$lsDia = substr($pmFecha, 3, 2);
				$lsMes = substr($pmFecha, 0, 2);
				$lsAno = substr($pmFecha, 6, 4);
				break;
		}
		switch ($pmFormatoR) {
			default:
			case 'amd':
				// año - mes - día
				$lsFecha = $lsAno . "-" . $lsMes . "-" . $lsDia;
				break;
			case 'dma':
				// dia - mes - año
				$lsFecha = $lsDia . "-" . $lsMes . "-" . $lsAno;
				break;
			case 'mda':
				// mes - día - año
				$lsFecha = $lsMes . "-" . $lsDia . "-" . $lsAno;
				break;
			case 'dam':
				// mes - día - año
				$lsFecha = $lsDia . "-" . $lsAno . "-" . $lsMes;
				break;
			case 'adm':
				// mes - día - año
				$lsFecha = $lsAno . "-" . $lsDia . "-" . $lsMes;
				break;
			case 'mad':
				// mes - día - año
				$lsFecha = $lsMes . "-" . $lsAno . "-" . $lsDia;
				break;

			case 'am':
				// año - mes
				$lsFecha = $lsAno . "-" . $lsMes;
				break;
			case 'ad':
				// año - día
				$lsFecha = $lsAno . "-" . $lsDia;
				break;
			case 'ma':
				// mes - año
				$lsFecha = $lsMes . "-" . $lsAno;
				break;
			case 'md':
				// mes - día
				$lsFecha = $lsMes . "-" . $lsDia;
				break;
			case 'dm':
				// día - mes
				$lsFecha = $lsDia . "-" . $lsMes;
				break;
			case 'da':
				// día - año
				$lsFecha = $lsDia . "-" . $lsAno;
				break;
				
			case 'a':
				//año
				$lsFecha = $lsAno;
				break;
			case 'm':
				// mes
				$lsFecha = $lsMes;
				break;
			case 'd':
				// día
				$lsFecha = $lsDia;
				break;
		}
		return $lsFecha;
	} //cierre de la función


}


?>
