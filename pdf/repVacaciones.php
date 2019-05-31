<?php

include_once( "../public/mpdf/mpdf.php");
include_once("../modelo/clsVacaciones.php");
include_once( "../public/lib_Vacaciones.php");

$objVacaciones = new Vacaciones();
$objVacaciones->setFormulario($_POST);
$rstConsulta = $objVacaciones->fmListarReporte();
$lFecha = date("d-m-Y");
$mpdf = new mPDF('utf-8', 'A4-L');

// Write some HTML code:
$vsHtml = "
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
        #table1 {
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
        }
    </style>

    <div class=''>
        <img src='../public/img/logofondas.png'  style='width:100%'>
    </div>
    <div class='opciones'>
        <div style='width:100%; text-align: center;'>
            <h3>Reporte de Vacaciones - {$lFecha}</h3>
        </div>
        <div class='opcion1'>
            <table id='table1'>
                <tr>
                    <td rowspan='2'>N°</td>
                    <td colspan='2' align='center'>TRABAJADOR</td>
                    <td colspan='2'>Vacaciones Acumuladas</td>
                    <td rowspan='2'>Condición </td>
                    <td rowspan='2' style='width:320px;' align='center'>ORSERVACIONES</td>
                </tr>

                <tr>

                    <td>Cédula</td>
                    <td style='width:270px;'>Nombre y Apellido</td>
                    <td>Periodo</td>
                    <td>Dias</td>
                </tr>";
        if ($rstConsulta) {
            while ($arrConsulta = $objVacaciones->getConsultaAsociativo($rstConsulta) ) {
                $vsPeriodos = $objVacaciones->getPeriodoUsado($arrConsulta["idvacacion"]);
                $vsHtml .= "
                    <tr>
                        <td>1</td>
                        <td> {$arrConsulta["nacionalidad"]} - {$arrConsulta["cedula"]} </td>
                        <td> {$arrConsulta["nombre"]} {$arrConsulta["apellido"]} </td>
                        <td> {$vsPeriodos} </td>
                        <td> {$arrConsulta["cantidad_dias"]} </td>
                        <td> {$arrConsulta["condicion_vacacion"]} </td>
                        <td> {$arrConsulta["observacion"]} </td>
                    </tr>";
            }
        }

$vsHtml .= "
            </table>
        </div>

    </div>
    <hr>
    <div class=''>
        Fondo de Desarrollo Agrario Socialista FONDAS
        Av. Circunvalacion Esquina Semaforo Carretera Nacional Via Payara. Al Lado De AgroPatria Acarigua.
        Municipio Paez  Edo. Portuguesa,Republica Bolivariana de Venezuela.
        Telefono: (0255-00000)
    </div>
";

$mpdf->SetHTMLFooter('<div style="text-align: right;">Pagína {PAGENO}/{nbpg}</div>');

$mpdf->WriteHTML($vsHtml);

// Output a PDF file directly to the browser
$mpdf->Output();

?>
