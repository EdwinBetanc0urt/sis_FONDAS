<?php
if (isset($_SESSION) && $_SESSION["sesion"] = "sistema") {

	$form="Bienvenida";
	if(isset($_GET["form"])){
		$form = $_GET["form"];
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		$ruta = "";
		if(is_file("vista/_head.php")){
			require_once("vista/_head.php");
		}
		else{
			$ruta = "../";
			require_once("{$ruta}vista/_head.php");
		}
	?>
</head>
<body class="fond_perfil" >
	<header>
		<?php

			include_once("_menu.php");
			//include("_botones.php");
		?>
	</header>

	<!--contenido de la pagina-->
	<div class="main" style="margin-top:20px;">
		<!--contenido derecha-->
		<input type='hidden'  name='idhistorial' readonly="" value='<?php //echo($_SESSION['idhistorial']);?>' />
		<div id="miga_perfil"></div>
		<!--AQUI APARECERAN LOS FORMULARIOS-->
		<div id="listado_formularios" style="margin-top:1px;">
			<?php
				if(is_file("vista/vis".$form.".php")){
					include("vista/vis".$form.".php");
				}else{
					include("vista/visBienvenida.php");
				}
			?>

		</div>
	</div>
</body>
</html>
<?php
}
else {
	header("Content-Type: text/html; charset=utf-8");
	$ruta = "";
	if(is_file("controlador/conCerrar.php")){
		header("Location: controlador/conCerrar.php?getMotivoLogOut=AccesoIndevido");
	}
	else{
		$ruta = "../";
		header("Location: {$ruta}controlador/conCerrar.php?getMotivoLogOut=AccesoIndevido");
	}
}

?>
