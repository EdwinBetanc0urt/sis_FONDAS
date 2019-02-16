<?php
	/*
	include_once("public/lib_Cifrado.php");
	$objCifrado = new clsCifrado(); //instancia la clase de Cifrado
	$texto = "26273412";
	$ENCRIPTADO = $objCifrado->flEncriptar($texto);
	var_dump($ENCRIPTADO);
	echo "<hr>";
	$desencriptado = $objCifrado->flDesencriptar($ENCRIPTADO);
	var_dump($desencriptado);
	// */
?>
<!--titulo formulario-->
<form action=''  name='formulario_maestro' method='POST'>
	<table width='100%' id='formulario_persona'>

	<?php
	include_once("modelo/clsUsuario.php");

	$objUsuario = new Usuario();
	
	//var_dump($_SESSION);
	?> 

	</table>

	<div style="text-align:center;">
		<img src="public/img/inicio.png" style='width:70%; height:15%;' >
	</div>
</form>