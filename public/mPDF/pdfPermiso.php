<?php

$cedula= 84603098;
$nombre= 'River Henry Mayta Escobar';
$departamento= "Finanzas";
$supervisor= "Juan Suarez";
$jefeRh= "Victor Mijica";
$motivo= "Capacitacion ";
$condicion= "Aprobado";
$justificativo= "documento adjunto del permiso";
$tiempo= 10;
$clase= "remunerado";
$fechaI=date("d/m/Y ");
$fechaF=date("d/m/Y ");
include_once( "mpdf.php");
$mpdf = new mPDF('c', 'A4');

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
        <div class='width:100%; text-align: center;'>
            <h2>Solicitud de Permiso </h2>  
        </div>
        <div class='opcion1'>
            <table id='table' >
                <tr>   
                    <td colspan='2' align='center' style='width:450px; height:50px;'> <h4>Datos de Trabajador</h4></td>
                </tr>
                <tr>
                    <td>APELLIDOS Y NOMBRES: $nombre </td>
                    <td>CEDULA: $cedula</td>
                </tr>
                <tr>
                    <td colspan='2'> DEPENDENCIA DE ADSCRIPCION: $departamento</td>
                </tr>
                <tr>
                    <td colspan='2'> JEFE DE DEPARTAMENTO: $supervisor</td>
                </tr>
                <tr>
                    <td colspan='2'> MOTIVO DEL PERMISO: $motivo</td>
                </tr>
                <tr>
                    <td>CONDICION: $condicion</td>
                    <td>COMPROBANTE: $justificativo</td>
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
                                <td>  $fechaI--$fechaF</td>
                                <td>  $tiempo dias</td>
                            </tr>
                            <tr>
                                <td align='center'> <h4> SOLICITANTE </h4>  </td>
                                <td align='center'> <h4> SUPERVISOR </h4> </td>
                                <td align='center'> <h4> OFICINA R.R.H.H. </h4>  </td>
                            </tr>
                            <tr>
                                <td style='height:60px;' >  </td>
                                <td  >  </td>
                                <td  >  </td>
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
        Municipio Paez  Edo. Portuguesa,Rep�blica Bolivariana de Venezuela.
        Telefono: (0255-00000) 
    </div>
");

// Output a PDF file directly to the browser
$mpdf->Output();
?>