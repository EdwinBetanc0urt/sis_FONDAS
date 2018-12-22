<?php 

$gsClase = "RecuperarClave";

$ruta = "";
if(is_file("modelo/cls{$gsClase}.php")){
	require_once("modelo/cls{$gsClase}.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/cls{$gsClase}.php");
}




echo "<pre>";
$objCifrado = new clsCifrado();
//$_POST["pswClaveN"] = $objCifrado->flEncriptar( $_POST["pswClaveN"]  );
$objeto = new RecuperarClave();
$objeto->setFormulario( $_POST );

$arrConsulta_P1 = $objeto->Consultar();
$arrConsulta_P2 = $objeto->Consultar2();
//var_dump( $arrConsulta_P1 );
//var_dump( $arrConsulta_P2 );
if ( $arrConsulta_P1 AND  $arrConsulta_P2) {

	if ( $arrConsulta_P1['respuesta'] == $_POST["ctxRespuesta1"] AND $arrConsulta_P2['respuesta'] == $_POST["ctxRespuesta2"] ) {
		//echo "respuestas iguales";
		
		$objeto->atrId = $arrConsulta_P1["id_usuario"];
		$rstClave = $objeto->fmConsultarClave();

		$rango = $objeto->getMaximoRangoClave();

		$crypClave = $objCifrado->flEncriptar( $_POST["pswClave"] );

		while ( $arrClave = $objeto->getConsultaAsociativo( $rstClave ) ) {
			if ( $crypClave == $arrClave["clave"] ) {
				header( "Location: {$ruta}?accion=Login&msjAlerta=claverepetida{$rango}");
				echo "repetido";
				return;
			}
			else {
				echo "sin repetir";
				continue;
			}
		}
		$objeto->faLiberarConsulta( $rstClave ); //libera de la memoria el resultado asociado a la consulta

		//var_dump( $objeto->fmRecuperarClave() );
		
		if ( $objeto->fmRecuperarClave() )
			header( "Location: {$ruta}?accion=Login&msjAlerta=claverecuperada");
		else
			header( "Location: {$ruta}?accion=Login&msjAlerta=clavenocambio");
		
		
	}
	else {
		header( "Location: {$ruta}?accion=Login&msjAlerta=respuestaincorrecta");
		echo "respuestaincorrecta";
	}
}
else {
	header( "Location: {$ruta}?accion=Login&msjAlerta=nousuario");
	echo "nousuario";
}

unset( $objCifrado ); //destruye el objeto
$objeto->faDesconectar(); //cierra la conexión
unset( $objeto ); //destruye el objeto*/






?>

