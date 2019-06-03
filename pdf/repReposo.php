<?php

include_once("../modelo/clsReposo.php");
include_once( "../public/mpdf/mpdf.php");

$objReposo = new Reposo();
$objReposo->setFormulario($_POST);
$fechaI = $objReposo->faFechaFormato($_POST["ctxFechaInicio"]);
$fechaF = $objReposo->faFechaFormato($_POST["ctxFechaFinal"]);

$rstConsulta = $objReposo->listarReporte();

$cedula= 84603098;
$nombre= 'River Henry Mayta Escobar';
$motivo= date(" h:m a");
$cantidadD= date(" h:m a");

$mpdf = new mPDF('utf-8', 'A4-L');

// Write some HTML code:
$vsHtml = "";
$vsHtml .= "
    <style>
        .opciones {
            overflow:hidden;
            text-align: center;
            margin:auto;
            background:#fff;
            //border:5px solid #ccc;
        }
        .opcion {
            display:inline-table;
            border:px solid #ccc;
            padding:15px;
            height:100px;
            width:100px;
            margin:3px;
        }
        .opcion1 {
            display:inline-table;
            //border:5px solid #ccc;
            padding:15px;
            height:100px;
            width:100%;
            margin:3px;
        }
        #table {
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
        }
    </style>
    <div>
        <img src='../public/img/logofondas.png'  style='width:100%'>
    </div>
    <div class='opciones'>
        <div class='width:100%; text-align: center;'>
            <h2>Reposos </h2> $fechaI - $fechaF </h2>
        </div>
        <div class='opcion1'>
            <table id='table' >
                <tr>
                    <td align='center'><h4>N°</h4></td>
                    <td style='width:;' align='center'><h4>Cedula</h4></td>
                    <td style='width:;' align='center'><h4>Trabajador</h4></td>
                    <td style='width:;' align='center'><h4>Fecha Inicio</h4></td>
                    <td style='width:;' align='center'><h4>Fecha fin</h4></td>
                    <td style='width:;' align='center'><h4>Motivo</h4></td>
                    <td style='width:;' align='center'><h4>Duración</h4></td>
                    <td style='width:;' align='center'><h4>Estatus</h4></td>
                    <td style='width:;' align='center'><h4>Observacion</h4></td>
                </tr>";

        if ($rstConsulta) {
            while ($arrConsulta = $objReposo->getConsultaAsociativo($rstConsulta) ) {
                $cantidad_dias = "";
                if ($arrConsulta["cantidad_dias"] != NULL) {
                    $cantidad_dias = $arrConsulta["cantidad_dias"] . " dia(s)";
                }

                $cantidad_minutos = "";
                if ($arrConsulta["cantidad_tiempo"] != NULL) {
                    $horas = floor($arrConsulta["cantidad_tiempo"] / 3600);
                    $minutos = floor(($arrConsulta["cantidad_tiempo"] - ($horas * 3600)) / 60);
                    $cantidad_minutos = "{$horas}:{$minutos} hora(s)";
                }
                $separador = "";
                if ($cantidad_dias != "") {
                    $separador = ", ";
                }

                $vsHtml .= "
                <tr>
                    <td> {$arrConsulta["idreposo"]} </td>
                    <td> {$arrConsulta["nacionalidad"]} - {$arrConsulta["cedula"]} </td>
                    <td> {$arrConsulta["nombre"]} {$arrConsulta["apellido"]} </td>
                    <td> " . $objReposo->faFechaFormato($arrConsulta["fecha_inicio"]) . "</td>
                    <td> " . $objReposo->faFechaFormato($arrConsulta["fecha_fin"]) . "</td>
                    <td> {$arrConsulta["motivo_reposo"]} </td>

                    <td> {$cantidad_dias} {$separador} {$cantidad_minutos} </td>
                    <td> {$arrConsulta["condicion_reposo"]} </td>
                    <td> {$arrConsulta["observacion"]} </td>
                </tr>";
            }
        }
        else {
            $vsHtml .= "
            <tr>
                <td> SIN REGISTROS </td>
            </tr>";
        }

$vsHtml .= "
            </table>
        </div>
    </div>
";

$mpdf->SetHTMLFooter('
    <hr>
    <div>
        Fondo de Desarrollo Agrario Socialista FONDAS
        Av. Circunvalacion Esquina Semaforo Carretera Nacional Via Payara. Al Lado De AgroPatria Acarigua.
        Municipio Paez  Edo. Portuguesa,República Bolivariana de Venezuela.
        Telefono: (0255-00000)
    </div>
    <div style="text-align: right;">Pagína {PAGENO}/{nbpg}</div>
');

$mpdf->WriteHTML($vsHtml);

// Output a PDF file directly to the browser
$mpdf->Output();
