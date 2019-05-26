<?php

include_once( "../public/mpdf/mpdf.php");
include_once("../modelo/clsVacaciones.php");
include_once( "../public/lib_Vacaciones.php");

$objVacaciones = new Vacaciones();
$objVacaciones->setFormulario($_POST);

$arrConsulta = $objVacaciones->fmListarReporte2($_GET["vacacicon"]);
$vsPeriodos = $objVacaciones->getPeriodoUsado($arrConsulta["idvacacion"]);

$objLibVacaciones = new vacacion($arrConsulta["fecha_ingreso"]);
$antiguedad = $objLibVacaciones->getAntiguedad($arrConsulta["fecha_ingreso"]);
$liCantidadDias = $objLibVacaciones->getCantidadDias($arrConsulta["fecha_inicio"], $arrConsulta["fecha_fin"]);
$solicitado= date("d/m/Y");
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
		#table {
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
        <div class='width:100%; text-align: center;'>
            <h2>Solicitud de Vacacion ----  fecha: $solicitado </h2>  
        </div>
        <div class='opcion1'>
            <table id='table'>
                <tr>
                    <td colspan='2'><h4>Apellidos y Nombres:</h4>{$arrConsulta["apellido"]} {$arrConsulta["nombre"]} </td>
                    <td> <h4> C.I.:</h4> {$arrConsulta["nacionalidad"]} - {$arrConsulta["cedula"]}</td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <table id='table' >
                            <tr>
                                <td style='width:352px;' align='center' > <h4>Dependencia Adscripcion  </h4> </td>
                                <td style='width:352px;' align='center'> <h4> Estado </h4> </td>
                                <td style='width:352px;' align='center'> <h4> Departamento </h4> </td>
                            </tr>
                            <tr>
                                <td align='center'>  Acarigua</td>
                                <td  align='center'>  {$arrConsulta["estado"]} </td>
                                <td align='center'> {$arrConsulta["departamento"]}  </td>
                            </tr>
                            <tr>
                            <td style='width:352px; ' align='center' > <h4> Funciones </h4> </td>
                                <td style='width:352px; ' align='center' > <h4>Fecha de Ingreso  </h4> </td>
                                <td style='width:352px;' align='center'> <h4> Antiguedad</h4> </td>
                            </tr>
                            <tr>
                                <td align='center'> {$arrConsulta["cargo"]}  </td>
                                <td align='center'> {$arrConsulta["fecha_ingreso"]} </td>
                                <td align='center'>  {$antiguedad} año(s) </td>
                            </tr>                 
                        </table>
                    </td>      
                </tr>
                <tr>
                    <td colspan='3'> 
                        <table id='table' >
                            <tr>
                                <td  style='width:352px;' align='center'> <h4> Periodo </h4>  </td>
                                <td style='width:352px;' align='center'> <h4> Vencimiento </h4> </td>
                                <td style='width:352px;' align='center'> <h4> Dias Hábiles </h4>  </td>
                            </tr>
                            <tr>
                                <td align='center'> {$vsPeriodos} </td>
                                <td align='center'>  </td>
                                <td align='center'> {$arrConsulta["cantidad_dias"]} </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <table id='table' >
                            <tr>
                                <td colspan='5' align='center'>
                                <h3>Notificacion fecha de Inicio de Vacaciones </h3>
                                </td>
                            </tr>
                            <tr>
                                <td style='width:210px;' align='center' > <h4>N° de Dias a Disfrutar </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Periodo a Disfrutar  </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Inicio </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Fin </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Regreso </h4> </td>
                            </tr>
                            <tr>
                                <td style='width:211px;' align='center'> {$arrConsulta["cantidad_dias"]} </td>
                                <td style='width:211px;' align='center'> {$vsPeriodos} </td>
                                <td style='width:211px;' align='center'> {$arrConsulta["fecha_inicio"]}  </td>
                                <td style='width:211px;' align='center'> {$arrConsulta["fecha_fin"]} </td>
                                <td style='width:211px;' align='center'> </td>
                            </tr>                        
                            <tr>
                                <td colspan='5' align='center'>
                                <h3><br> Aprobacion de Solicitud  </h3>
                                </td>
                            </tr>                            
                            <tr>
                                <td style='width:211px;' align='center' > <h4>Solicitud Procesado Por </h4> </td>
                                <td style='width:211px;' align='center'> <h4> Cargo </h4> </td>
                                <td style='width:211px;' align='center'> <h4> fecha </h4> </td>
                                <td style='width:211px;' align='center'> <h4> firma </h4> </td>
                                <td style='width:211px;' align='center' style='width:211px;'> <h4> Sello </h4> </td>
                            </tr>
                            <tr>
                                <td align='center'> CARLOS PINEDA </td>
                                <td align='center'>Coordinador Región-Portuguesa </td>
                                <td></td>
                                <td></td>
                                <td style='height:60px;'></td>
                            </tr>
                            <tr>
                            <tr>
                                <td align='center'> <h4>Procesado Por </h4> </td>
                                <td align='center'> <h4>Fecha   </h4> </td>
                                <td align='center'> <h4> Recivido por </h4> </td>
                                <td align='center'> <h4> Aprobado por</h4> </td>
                                <td align='center'> <h4> Sello </h4> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td style='height:60px;' >  </td>
                            </tr>
                        </table>
                    </td>
                </tr>
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

$mpdf->WriteHTML( $vsHtml);

// Output a PDF file directly to the browser
$mpdf->Output();

?>
