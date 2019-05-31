<?php

$cedula= 84603098;
$nombre= 'River Henry Mayta Escobar';
$fechaI= date(" h:m a");
$fechaF= date(" h:m a");
$motivo= date(" h:m a");
$cantidadD= date(" h:m a");
$estatus= 'llego tarde ';
$fechaI=date("d/m/Y ");
$fechaF=date("d/m/Y ");
include_once( "mpdf.php");

$mpdf = new mPDF('utf-8', 'A4-L');

// Write some HTML code:
$mpdf->WriteHTML("
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
            <h2>Ausencias </h2> $fechaI -- $fechaF </h2>
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
                </tr>
                <tr>
                    <td>1</td>
                    <td>$cedula</td>
                    <td>$nombre</td>
                    <td>$fechaI</td>
                    <td>$fechaI</td>
                    <td>Capacitacion en el exterior</td>
                    <td>5 dias</td>
                    <td>de permiso</td>
                    <td>presento todo los repaldos necesario para el permiso</td>
                </tr>
            </table>
        </div>

    </div>
    <hr>
    <div class=''>
        Fondo de Desarrollo Agrario Socialista FONDAS
        Av. Circunvalacion Esquina Semaforo Carretera Nacional Via Payara. Al Lado De AgroPatria Acarigua.
        Municipio Paez  Edo. Portuguesa,República Bolivariana de Venezuela.
        Telefono: (0255-00000)
    </div>
");

// Output a PDF file directly to the browser
$mpdf->Output();
