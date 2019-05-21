<?php
	/*
	include_once("public/lib_Cifrado.php");
	$texto = "26273412";
	$ENCRIPTADO = clsCifrado::getCifrar($texto);
	var_dump($ENCRIPTADO);
	echo "<hr>";
	$desencriptado = clsCifrado::getDescifrar($ENCRIPTADO);
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
