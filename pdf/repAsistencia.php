<?php

require("../modelo/clsAsistencia.php");

$objeto = new Asistencia();

$objeto->setFormulario($_POST);
$rstConsulta = $objeto->listarReporte();

$lFecha = date("d/m/Y");
$desde = $objeto->faFechaFormato($_POST["ctxFechaInicio"]);
$hasta = $objeto->faFechaFormato($_POST["ctxFechaFinal"]);

// Write some HTML code:
$htmlBody = "
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
        <div style='width:100%; text-align: center;'>
            <h3>CONTROL DE ASISTENCIA DIARIA {$lFecha}</h3>
            Desde: {$desde}, Hasta: {$hasta}
        </div>
        <div class='opcion1'>
            <table id='table'>
                <tr>
                    <td rowspan='2'>N°</td>
                    <td colspan='2'>TRABAJADOR</td>
                    <td rowspan='2'>FECHA</td>
                    <td colspan='2'>MAÑANA</td>
                    <td colspan='2'>TARDE</td>
                    <td rowspan='2' style='width:320px;'>ORSERVACION</td>
                </tr>
                <tr>
                    <td>Cedula</td>
                    <td style='width:270px;'>Nombre y Apellido</td>
                    <td>Entrada</td>
                    <td>Salida</td>
                    <td>Entrada</td>
                    <td>Salida</td>
                </tr>";

                if ($rstConsulta) {
                    $contador = 0;
                    while ($arrConsulta = $objeto->getConsultaAsociativo($rstConsulta) ) {
                        $contador++;
                        $htmlBody .= "
                        <tr>
                            <td>{$contador}</td>
                            <td> {$arrConsulta["nacionalidad"]} - {$arrConsulta["cedula"]} </td>
                            <td> {$arrConsulta["nombre"]} {$arrConsulta["apellido"]} </td>
                            <td>
                                {$objeto->faFechaFormato($arrConsulta["fecha_marcaje"])}
                            </td>
                            <td> {$arrConsulta["entrada1"]} </td>
                            <td> {$arrConsulta["salida1"]} </td>
                            <td> {$arrConsulta["entrada2"]} </td>
                            <td> {$arrConsulta["salida2"]} </td>
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

$htmlBody .= "
            </table>
        </div>
    </div>
";

$htmlFooter = '
    <hr>
    <div>
        Fondo de Desarrollo Agrario Socialista FONDAS
        Av. Circunvalacion Esquina Semaforo Carretera Nacional Via Payara. Al Lado De AgroPatria Acarigua.
        Municipio Paez  Edo. Portuguesa,República Bolivariana de Venezuela.
        Telefono: (0255-00000)
    </div>
    <div style="text-align: right;">Pagína {PAGENO}/{nbpg}</div>
';

include("../public/mpdf/mpdf.php");
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->SetHTMLFooter($htmlFooter);
$mpdf->WriteHTML($htmlBody);
// Output a PDF file directly to the browser
$mpdf->Output();

?>
