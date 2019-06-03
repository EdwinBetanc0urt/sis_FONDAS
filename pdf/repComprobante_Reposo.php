<?php

include_once("../modelo/clsReposo.php");
include_once( "../public/mpdf/mpdf.php");

$objReposo = new Reposo();
$arrRegistro = $objReposo->listarReporteUnitario($_GET["id"]);

$cantidad_dias = 0;
if ($arrRegistro["cantidad_dias"] != NULL) {
    $cantidad_dias = $arrRegistro["cantidad_dias"];
}

$lFecha = date("d-m-Y");
$clase= "remunerado";

$mpdf = new mPDF('utf-8', 'A4');

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
        <img src='../public/img/logofondas.png' style='width:100%'>
    </div>
    <div class='opciones'>
        <div class='width:100%; text-align: center;'>
            <h2>REPOSO - {$lFecha}</h2>
        </div>
        <div class='opcion1'>
            <table id='table' >
                <tr>
                    <td colspan='2' align='center' style='width:450px; height:50px;'> <h4>Datos de Trabajador</h4></td>
                </tr>
                <tr>
                    <td>APELLIDOS Y NOMBRES: <br>"
                        . ucwords($arrRegistro["nombre"] . " " . $arrRegistro["apellido"]) .
                    "</td>
                    <td>CEDULA: "
                        . ucwords($arrRegistro["nacionalidad"] . "-" . $arrRegistro["cedula"]) .
                    "</td>
                </tr>
                <tr>
                    <td colspan='2'> DEPENDENCIA DE ADSCRIPCION: {$arrRegistro["departamento"]}</td>
                </tr>
                <tr>
                    <td colspan='2'> MOTIVO DEL PERMISO: {$arrRegistro["motivo_reposo"]} </td>
                </tr>
                <tr>
                <td>CONDICION: {$arrRegistro["condicion_reposo"]}</td>
                <td>COMPROBANTE: {$arrRegistro["justificativo"]}</td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <table id='table' >
                            <tr>
                                <td style='width:215px;' align='center' > <h4>CLASE DE PERMISO </h4> </td>
                                <td style='width:215px;' align='center'> <h4> DURACION </h4> </td>
                                <td style='width:215px;' align='center'> <h4> TIEMPO </h4> </td>
                            </tr>
                            <tr>
                                <td>  remunerado<input name='' id='' type='checkbox'> No remunerado<input name='' id='' type='checkbox'> </td>
                                <td>"
                                    . $objReposo->faFechaFormato($arrRegistro["fecha_inicio"]) . " - "
                                    . $objReposo->faFechaFormato($arrRegistro["fecha_fin"]) .
                                "</td>
                                <td>"
                                    . $cantidad_dias .
                                " dia(s)</td>
                            </tr>
                            <tr>
                                <td align='center'> <h4> SOLICITANTE </h4>  </td>
                                <td align='center'> <h4> SUPERVISOR </h4> </td>
                                <td align='center'> <h4> OFICINA R.R.H.H. </h4>  </td>
                            </tr>
                            <tr align='center'>
                                <td align='center'>
                                    <br><br><br>
                                    <hr>
                                    {$arrRegistro["nombre"]} {$arrRegistro["apellido"]} <br>
                                    {$arrRegistro["nacionalidad"]}-{$arrRegistro["cedula"]}
                                </td>
                                <td align='center'>
                                    <br><br><br>
                                    <hr>
                                    {$arrRegistro["nombre_jefe"]} {$arrRegistro["apellido_jefe"]} <br>
                                    {$arrRegistro["nacionalidad_jefe"]}-{$arrRegistro["cedula_jefe"]}
                                </td>
                                <td align='center'>
                                    <br><br><br>
                                    <hr>
                                    {$arrRegistro["nombre_rh"]} {$arrRegistro["apellido_rh"]} <br>
                                    {$arrRegistro["nacionalidad_rh"]}-{$arrRegistro["cedula_rh"]}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
");

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

// Output a PDF file directly to the browser
$mpdf->Output();
?>
