<?php


include_once( "../public/mpdf/mpdf.php");
include_once( "../modelo/clsAcceso.php");


$objeto = new Acceso();
$mpdf = new mPDF('utf-8', 'LETTER');

//header('Content-type: application/pdf');


$rstRecordSet = $objeto->ListarAccesoModulosUsuario( $_GET["usuario"]);

//var_dump( $rstRecordSet );
$htmlBody = '
    <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../public/jquery/jquery-ui/jquery-ui.css">
    <script type="text/javascript" src="../public/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../public/bootstrap/js/bootstrap.js"></script>
';


if ( $rstRecordSet ) {
    //$arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet ); //convierte el RecordSet en un arreglo
    $htmlBody .= "
        <div class=''>
            <img src='../public/img/logofondas.png'  style='width:100%'>
        </div>
        <div class='width:100%; text-align: center;'>
            <h2>Perfil de Acceso </h2>  
        </div>
        ";
    
        while ( $arrRegistro = $objeto->getConsultaAsociativo( $rstRecordSet) ){    
            $htmlBody .= "
                <h4> Modulo: {$arrRegistro['idmodulo']} - {$arrRegistro["modulo"]} </h4>
                <hr>
                <div class='table-responsive' >
                    <table class='table hover' bgcolor='black' border='1' bgcolor='#000'>
                        <thead>
                            <tr>
                                <td>
                                    vista
                                </td>
                                <td>
                                    botones
                                </td>
                            </tr>
                        </thead>
                        <tbody>    
            ";
    

            $rstRecordSetVista = $objeto->ListarAccesoVistasUsuario( $_GET["usuario"] , $arrRegistro["idmodulo"]);
            while ( $arrRegistroVista = $objeto->getConsultaAsociativo( $rstRecordSetVista) ){    
                $htmlBody .= "
                            <tr>
                                <td> {$arrRegistroVista["vista"]}
                            </tr>
                 ";
            } 
            $htmlBody .= " 
                        </tbody>
                    </table>
                </div>
                <br /><br /> 
            ";

        }
    
    $objeto->faLiberarConsulta( $rstRecordSet ); //libera de la memoria el resultado asociado a la consulta
}

else {
    $htmlBody = "<br> <b>¡ No se ha encontrado ningún elemento, aigne los accesos a este tipo de usuario!</a></b> <br><br>";
}
$objeto->faDesconectar(); //cierra la conexión
unset($objeto); //destruye el objeto

//echo $htmlBody;


// Write some HTML code:
$mpdf->WriteHTML( $htmlBody );

// Output a PDF file directly to the browser
$mpdf->Output();

?>