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
$cargo= "Administarcion de area legal";
$fechaIngreso= date("d/m/Y ");
$antiguedad="2";
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

    <div class=''>
        <img src='img/logofondas.png'  style='width:100%'>
    </div>
    <div class='opciones'>
        <div class='width:100%; text-align: center;'>
            <h2>Solicitud de Vacacion ----  fecha: $fechaF </h2>  
        </div>
        <div class='opcion1'>
            <table id='table'>
                
                <tr>
                    <td colspan='2'><h4>Apellidos y Nombres:</h4>$nombre  </td>
                    <td>Cédula: $cedula</td>
                </tr>
                <tr>
                    <td colspan='3'>
                    <table id='table'>
                    <tr>
                        <td style='width:352px; 'align='center' > <h4>Dependencia Adscripcion  </h4> </td>
                        <td style='width:352px; ' align='center'> <h4> Estado</h4> </td>
                        <td style='width:352px; ' align='center'> <h4> Funciones </h4> </td>
                    </tr>
                    <tr>
                        <td  >  $departamento</td>
                        <td  >  Portuguesa -- Acarigua</td>
                        <td >  $cargo</td>
                    </tr>
                    
                </table>                    
                    
                    </td>
                    
                </tr>
                <tr>
                    <td colspan='3'> 
                        <table id='table' >
                            <tr>
                                <td style='width:352px; ' align='center' > <h4>Fecha de Ingreso  </h4> </td>
                                <td style='width:352px;' align='center'> <h4> Antiguedad</h4> </td>
                                <td style='width:352px;' align='center'> <h4> TIEMPO </h4> </td>
                            </tr>
                            <tr>
                                <td> $fechaIngreso </td>
                                <td>  $antiguedad años </td>
                                <td>  $tiempo dias</td>
                            </tr>
                            <tr>
                                <td  align='center'> <h4> Periodo </h4>  </td>
                                <td  align='center'> <h4> Vencimiento </h4> </td>
                                <td align='center'> <h4> Dias Habiles </h4>  </td>
                            </tr>
                            <tr>
                                <td> a </td>
                                <td> $fechaI </td>
                                <td> $dias_habiles </td>
                            </tr>
                        </table>
                    
                    
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <table  id='table'>

                            <tr>
                                <td style='width:210px;' align='center' > <h4>N° de Dias a Disfrutar </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Periodo a Disfrutar  </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Inicio </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Fin </h4> </td>
                                <td style='width:210px;' align='center'> <h4> Regreso </h4> </td>
                            </tr>
                            <tr>
                                <td style='width:211px;' >  </td>
                                <td style='width:211px;' >  2017 </td>
                                <td style='width:211px;' >  </td>
                                <td style='width:211px;' >  </td>
                                <td style='width:211px;' > </td>
                            </tr>                        

                            <tr>
                                <td style='width:211px;' align='center' > <h4>Solicitud Procesado Por </h4> </td>
                                <td style='width:211px;' align='center'> <h4> Cargo </h4> </td>
                                <td style='width:211px;' align='center'> <h4> fecha </h4> </td>
                                <td style='width:211px;' align='center'> <h4> firma </h4> </td>
                                <td style='width:211px;' align='center' style='width:211px;'> <h4> Sello </h4> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td>  </td>
                                <td style='height:60px;' >  </td>
                            </tr>
                            <tr>
                            <tr>
                                <td align='center' > <h4>Procesado Por </h4> </td>
                                <td align='center'> <h4>Fecha   </h4> </td>
                                <td align='center'> <h4> Recivido por </h4> </td>
                                <td align='center'> <h4> Aprobado por</h4> </td>
                                <td  align='center'> <h4> Sello </h4> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td>  </td>
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
");

// Output a PDF file directly to the browser
$mpdf->Output();
