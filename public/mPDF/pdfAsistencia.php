<?php

$cedula= 84603098;
$nombre= 'River Henry Mayta Escobar';
$entrada= date(" h:m a");
$salida= date(" h:m a");
$entrada1= date(" h:m a");
$salida1= date(" h:m a");
$observacion= 'llego tarde ';
$lFecha=date("d/m/Y  ");
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
    <div class=''>
        <img src='img/logofondas.png'  style='width:100%'>
    </div>
    <div class='opciones'>
        <div style='width:100%; text-align: center;'>
            <h3>CONTROL DE ASISTENCIA DIARIA </h3>
            $lFecha
        </div>
        <div class='opcion1'>
            <table id='table'>
                <tr>
                    <td>N°</td>
                    <td colspan='2'>TRABAJADOR</td>
                    <td colspan='2'>MAÑANA</td>
                    <td colspan='2'>TARDE</td>
                    <td style='width:320px;'>ORSERVACIONES</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Cedula</td>
                    <td style='width:270px;'>Nombre y Apellido</td>
                    <td>Entrada</td>
                    <td>Salida</td>
                    <td>Entrada</td>
                    <td>Salida</td>
                    <td>Observacion</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>$cedula</td>
                    <td>$nombre</td>
                    <td>$entrada</td>
                    <td>$salida</td>
                    <td>$entrada1</td>
                    <td>$salida1</td>
                    <td>$observacion</td>
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
");

// Output a PDF file directly to the browser
$mpdf->Output();
