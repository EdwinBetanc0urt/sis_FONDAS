<?php
/**
 * Metodo getDiasHabiles
 *
 * Permite devolver un arreglo con los dias habiles
 * entre el rango de fechas dado excluyendo los
 * dias feriados dados (Si existen)
 *
 * @param string $psFechainicio Fecha de inicio en formato Y-m-d
 * @param string $psFechafin Fecha de fin en formato Y-m-d
 * @param array $paDiasferiados Arreglo de dias feriados en formato Y-m-d
 * @param array $paDiasNoHabiles Arreglo de dias que no son tomados como habiles, Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
 * @return array $diashabiles Arreglo definitivo de dias habiles
 */
function getDiasHabiles($psFechainicio, $psFechafin, $paDiasferiados = array(), $paDiasNoHabiles = array(6,7)) {
        // Convirtiendo en timestamp las fechas
        $psFechainicio = strtotime($psFechainicio);
        $psFechafin = strtotime($psFechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $psFechainicio; $midia <= $psFechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (! in_array(date('N', $midia), $paDiasNoHabiles)) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (! in_array(date('Y-m-d', $midia), $paDiasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return $diashabiles;
}


function getDiasTranscurridos($psFechainicio, $psFechafin) {
        $datetime1 = date_create($psFechainicio);
        $datetime2 = date_create($psFechafin);
        $interval = date_diff($datetime1, $datetime2);
        return intval( $interval->format('%R%a') ); 
}


function dias_transcurridos($fecha_i,$fecha_f) {
        $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);             
        return $dias;
}


$arrDias = getDiasHabiles('2018-03-05', '2018-03-19', [ '2018-03-13' ]);
echo "<pre>";
var_dump( $arrDias );

var_dump( count($arrDias) );


var_dump( getDiasTranscurridos('2018-03-05', '2018-03-19') );

