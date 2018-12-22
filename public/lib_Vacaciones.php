<?php

/**
 * Vacaciones Venezuela
 *
 * @descripcion: Vacaciones Venezuela - clase PHP para obtener los diferentes cálculos relacionados a vacaciones
 * @author: Edwin Betancourt <EdwinBetanc0urt@hotmail.com> 
 * @license: GNU GPL v3,  Licencia Pública General de GNU 3.
 * @license: CC BY-SA, Creative  Commons  Atribución  - CompartirIgual (CC BY-SA) 4.0 Internacional.
 * @category Librería.
 * @package: lib_Vacaciones.php.
 * @since: v0.3.
 * @version: 0.6.
 * @Fecha de Modificación: 04/Abril/2018
 * @Fecha de Creación: 05/Marzo/2018
 **/

/**
		ESTA LIBRERIA ESTÁ HECHA CON FINES ACADEMICOS, SU DISTRIBUCIÓN ES TOTALMENTE
	GRATUITA, BAJO LA LICENCIA GNU GPL v3 y CC BY-SA v4 Internacional, CUALQUIER,
	ADAPTACIÓN MODIFICACIÓN Y/O MEJORA QUE SE HAGA APARTIR DE ESTE CODIGO DEBE SER 
	NOTIFICADA Y ENVIADA A LA FUENTE, COMUNIDAD O REPOSITORIO DE LA CUAL FUE OBTENIDA
	Y/O A SUS CREADORES:
		* Edwin Betancourt	<EdwinBetanc0urt@hotmail.com>

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
	public $atrDiasVacaciones = 15; //días correspondientes de vacaciones según la LOTTT
	public $atrTipoPersona = "R"; //tipo de persona Regular o Funcionario

	/**
	 * @param string $psFechaIngreso Fecha de inicio en formato Y-m-d
	 * @param string $piMaxPeriodos máximo acumulado 2 periodos art 199 LOTTT y 1 o no acumulativo art 19 LCA
	 */
	function __construct($psFechaIngreso = "", $psTipoPersona = "R")
	{
		$this->atrFechaIngreso = trim($psFechaIngreso);
		$this->atrTipoPersona = trim($psTipoPersona);
		$this->setAsignarValores(); 
	} //cierre del constuctor



	private function setAsignarValores()
	{
		if (strtoupper($this->atrTipoPersona) == "F") {
			$this->atrMaxPeriodo = 1;
			$this->atrPeriodo = 5; //cada 5 años
			$this->atrTipoPeriodo = "Quinquenio"; //cada 5 años
		}
		else {
			$this->atrMaxPeriodo = 2;
			$this->atrPeriodo = 1; //cada año
			$this->atrTipoPeriodo = "Año(s)"; //cada año
		}
	}



	/**
	 * @param string $psFechaIngreso Fecha de inicio en formato Y-m-d
	 * @param string $psFechaPeriodo fecha del periodo a calcular la antiguedad Y-m-d
	 */
	function getAntiguedad($psFechaIngreso = "", $psFechaPeriodo = "") {
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
	}



	public function getPeriodosAntiguedad($psFechaIngreso = "")
	{
		if (trim($psFechaIngreso) == "") {
			$psFechaIngreso = $this->atrFechaIngreso;
		}
		//$lsAno = substr($psFechaIngreso, 0, 4);
		$lsAno = self::getFechaFormato($psFechaIngreso, "amd", "a");
		$liAntiguedad = $this->getAntiguedad($psFechaIngreso);

		$arrRetorno = array();
		if ($liAntiguedad > 0) {
			for ($liControl = 0; $liControl  <= $liAntiguedad ; $liControl ++) { 
				$arrRetorno[ $liControl ] = $lsAno + $liControl;
			}
		}
		return $arrRetorno;
	}



	public function getDetalleDiasVacacionesPeriodo($psFechaIngreso = "", $paPeriodos = array())
	{
		if ($psFechaIngreso == "") {
			$psFechaIngreso = $this->atrFechaIngreso;
		}
		if (! is_array($paPeriodos)) {
			//separa la palabra en cada guin y convierte el string en arreglo
			$paPeriodos = explode("-", $paPeriodos); 
		}
		//var_dump($paPeriodos[0]);

		$lsDia = self::getFechaFormato($psFechaIngreso, "amd", "d");
		$lsMes = self::getFechaFormato($psFechaIngreso, "amd", "m");
		/*
		$lsDia = substr($psFechaIngreso, 8, 2);
		$lsMes = substr($psFechaIngreso, 5, 2);
		$lsAno = substr($psFechaIngreso, 0, 4);
		*/
		$objFecha_Ingreso = new DateTime($psFechaIngreso);
		$liCont = 1;
		$lsVacaciones = 0;
		if (count($paPeriodos) <= 0) {
			$liCont = -1;
		}
		$arrRetorno = array();
		foreach ($paPeriodos as $key => $value) {

			$objFecha_Periodo = new DateTime($value . "-" . $lsMes . "-" . $lsDia);
			$annos = $objFecha_Periodo->diff($objFecha_Ingreso);
			$antiguedad =  $annos->y + 1 ;
			$diasvacaciones = $this->getDiasVacacionesAntiguedad($antiguedad);
			$lsVacaciones = $lsVacaciones + $diasvacaciones ;

			$arrRetorno["periodo"][$liCont]["anno"] = $value;
			$arrRetorno["periodo"][$liCont]["dias"] = $diasvacaciones;

			$liCont ++;
		}

		$arrRetorno["dias_vacaciones"] = $lsVacaciones;
		return $arrRetorno;
	}



	/*
	 * La formula es 15 + (años de servicio -1)
	 * hasta llegar a 15 dias habiles (30 dias de vacaciones en total)
	 */
	public function getDiasVacacionesAntiguedad($piAntiguedad = "")
	{
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = $this->getAntiguedad($this->atrFechaIngreso);
		}
		else
			$piAntiguedad = intval(trim($piAntiguedad));
		$liDiasAntiguedad = $this->atrDiasVacaciones + ($piAntiguedad - 1);
		/*
		if ($liDiasAntiguedad > 30) {
			$liDiasAntiguedad = 30;
		}
		*/
		return $liDiasAntiguedad;
	}



	/*
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
	}



	/*
	 * La formula es 15 + años de servicio 
	 */
	public function getDiasVacacionesBono($piAntiguedad = 0)
	{
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = $this->getAntiguedad($this->atrFechaIngreso);
		}
		else
			$piAntiguedad = intval(trim($piAntiguedad));
		$liDiasBono = $this->$atrDiasVacaciones + $piAntiguedad;
		if ($liDiasBono > 30) {
			$liDiasBono = 30;
		}
		return $liDiasBono;
	}



	public function getDiasVacacionesAntiguedadFuncionario($piAntiguedad = "")
	{
		if (trim($piAntiguedad) == "") {
			$piAntiguedad = $this->getAntiguedad($this->atrFechaIngreso);
		}
		else
			$piAntiguedad = intval(trim($piAntiguedad));
		$liDiasVacaciones = 0;
		switch ($piAntiguedad) {
		 	//primer quinquenio de 5 años a 9 años
			case ($piAntiguedad ==  5):
				$liDiasVacaciones = 19;
				break;
			//segundo quinquenio de 10 años a 14 años
			case ($piAntiguedad == 10):
				$liDiasVacaciones = 20;
				break;
			//tercer quinquenio 15 años
			case ($piAntiguedad == 15):
				$liDiasVacaciones = 21;
				break;
			//mas de 16 años o mas
			case ($piAntiguedad >= 16):
				$liDiasVacaciones = 25;
				break;
			case ($piAntiguedad <= 0):
		 	//default:
		 		$liDiasVacaciones = 0;
		 		break;
		} //cierre del switch

		return $liDiasVacaciones;
	}



	public function getListarPeriodos($paPeriodosUsados = array())
	{
		if (! is_array($paPeriodosUsados)) {
			//separa la palabra en cada guin y convierte el string en arreglo
			if (strpos($paPeriodosUsados, "/"))
				$paPeriodosUsados = explode("/", $paPeriodosUsados); 
			else
				$paPeriodosUsados = explode("-", $paPeriodosUsados); 
		}

		$arrPeriodos = $this->getPeriodosAntiguedad($this->atrFechaIngreso);
		$arrComparado = array_diff($arrPeriodos, $paPeriodosUsados);
		$arrRetorno = array();
		if ($arrComparado) {
			$arrComparado = array_slice(array_diff($arrPeriodos, $paPeriodosUsados), 0, $this->atrMaxPeriodo);
			$liCont = 0;

			foreach ($arrComparado AS $key => $value) {
				if ($liCont > 0) 
					$value = $arrComparado[ ($liCont-1) ] . "-" . $value;
					$arrRetorno[$liCont] = $value;
				$liCont++;
			}
		}
		return $arrRetorno;
	}



	//Esta pequeña función me crea una fecha de entrega sin sábados ni domingos ni días feriados
	public function getFechaFinal($psFechainicio = "", $piDiasHabiles = 0, $paDiasferiados = array(), $paDiasNoHabiles = array(6,7))
	{
		if (trim($psFechainicio) == "") {
			$psFechainicio = date("Y-m-d");
		}
		if (trim($piDiasHabiles) == 0) {
			$piDiasHabiles = $this->getDiasVacacionesAntiguedad();
		}

		$fechaInicial =  strtotime($psFechainicio); //obtenemos la fecha de hoy, solo para usar como referencia al usuario  
		//echo "$fechaInicial<hr>";
		$piDiasHabiles = intval($piDiasHabiles);
		$FechaFinal = 0;
		//$Segundos = 24*60*60;
		$liSegundos = 0;

		//Creamos un for desde 0 hasta los días enviados 

		//enviar el día de que culminan las vacaciones 
		//for ($liDiaRecorrido = 0; $liDiaRecorrido < $piDiasHabiles; $liDiaRecorrido++) {
		//envia el dia de que culminan las vacaciones un dia habil adicional para el reingreso
		for ($liDiaRecorrido = 0; $liDiaRecorrido <= $piDiasHabiles; $liDiaRecorrido++) {
			//Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for  
			$liSegundos = $liSegundos + 86400;  

			//Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias 1 al 7, segun la vuelta en la que estemos  
			//$diatranscurrido = date("Y-m-d",time() + $Segundos);
			//$diatranscurrido = date("Y-m-d", $fechaInicial + $Segundos);
			//$diaSemanatranscurrido = date("N", $fechaInicial + $Segundos);
			//Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...
			// DOC: http://www.php.net/manual/es/function.date.php
			if (in_array(date("N", $fechaInicial + $liSegundos), $paDiasNoHabiles)) { 
				$liDiaRecorrido--; 
			}
			// DOC: http://www.php.net/manual/es/function.date.php
			elseif (in_array(date('Y-m-d', $fechaInicial + $liSegundos), $paDiasferiados)) { 
				$liDiaRecorrido--; 
			}
			else {
				//Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha  
				$FechaFinal = date("Y-m-d", $fechaInicial + $liSegundos);  
			}  
			//echo "<br> $liDiaRecorrido ";
		}  
		//echo "la  fecha inicial es $psFechainicio y la final es $FechaFinal <br>";
		return $FechaFinal;
	}



	/**
	 * Metodo getDiasHabiles
	 *
	 * Permite devolver un arreglo con los dias habiles
	 * entre el rango de fechas dado excluyendo los
	 * dias feriados dados (Si existen)
	 *
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechafin Fecha de fin en formato Y-m-d
	 * @param array $paDiasferiados Arreglo de dias feriados en formato Y-m-d
	 * @param array $paDiasNoLaboral Arreglo de dias no laborables o  tomados como no habiles, 
	 * Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
	 * @return array $arrDiasHabiles Arreglo definitivo de dias habiles
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
	}



	/**
	 * Metodo getDiasHabiles
	 *
	 * Permite devolver un arreglo con los dias habiles
	 * entre el rango de fechas dado excluyendo los
	 * dias feriados dados (Si existen)
	 *
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
	 * @param string $psFechafin Fecha de fin en formato Y-m-d
	 * @param array $paDiasferiados Arreglo de dias feriados en formato Y-m-d
	 * @param array $paDiasNoLaboral Arreglo de dias no laborables o  tomados como no habiles, 
	 * Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
	 * @return array $arrDiasHabiles Arreglo definitivo de dias habiles
	 */
	public function getDiasHabiles($psFechainicio = "", $psFechafin, $paDiasferiados = array(), $paDiasNoLaboral = array(6,7))
	{
		if (trim($psFechainicio) == "") {
			$psFechainicio = date("Y-m-d");
		}

		// Convirtiendo en timestamp las fechas
		$psFechainicio = strtotime($psFechainicio);
		$psFechafin = strtotime($psFechafin);
		// Incremento en 1 dia
		//$liDia = 24*60*60; //86400 segundos
		$liDia = 86400; 

		// Arreglo de dias habiles, inicianlizacion
		$arrDiasHabiles = array();
		// Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
		for ($liDiaRecorrido = $psFechainicio; $liDiaRecorrido <= $psFechafin; $liDiaRecorrido += $liDia) {
			// Si el dia indicado, no es sabado o domingo es habil
			// DOC: http://www.php.net/manual/es/function.date.php
			if (! in_array(date('N', $liDiaRecorrido), $paDiasNoLaboral)) { 
				// Si no es un dia feriado entonces es habil
				if (! in_array(date('Y-m-d', $liDiaRecorrido), $paDiasferiados)) {
					array_push($arrDiasHabiles, date('Y-m-d', $liDiaRecorrido));
				}
			}
		}
		return $arrDiasHabiles;
	}


	public function getSemanaSanta($psAno = "")
	{
		if ($psAno == "") {
			$psAno = intval(date("Y"));
		}
		return easter_days($psAno);
		//falta sumar esos dias al 21 de marzo del año dado para obetenr el dia en que cae domingo de pascua
		//para carnavala ese domingo se le restan 47 dias
	}


	//parametro del modelo FechaBD
	static public function getFechaFormato($pmFecha = "", $pmFormatoE = "amd", $pmFormatoR = "dma")
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
			case 'dam':
				// mes - dia - año
				$lsFecha = $lsDia . "-" . $lsAno . "-" . $lsMes;
				break;
			case 'adm':
				// mes - dia - año
				$lsFecha = $lsAno . "-" . $lsDia . "-" . $lsMes;
				break;
			case 'mad':
				// mes - dia - año
				$lsFecha = $lsMes . "-" . $lsAno . "-" . $lsDia;
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
				
			case 'a':
				//año
				$lsFecha = $lsAno;
				break;
			case 'm':
				// mes
				$lsFecha = $lsMes;
				break;
			case 'd':
				// dia
				$lsFecha = $lsDia;
				break;
		}
		return $lsFecha;
	} //cierre de la función


}

/*
$objCalcula2 = new vacacion();
$resultado = $objCalcula2->getFechaFinal("2018-04-01", "13");
var_dump($resultado);
*/
?>

