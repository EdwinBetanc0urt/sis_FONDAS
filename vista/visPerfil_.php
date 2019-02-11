
<?php 

session_start();
if(empty($_GET["form"])){
		$form="Bienvenida";
	}
	else{
		$form = $_GET["form"];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>BIENVENIDO AL FONDAS</title>
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="public/css/estilos.css">
	<link rel="stylesheet" type="text/css" href="public/css/form.css">
	<link rel='stylesheet' type='text/css' href='public/css/responsive.css'>
	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
	<link rel="stylesheet" href="public/css/paginacion.css" type="text/css"></link>
	<link rel="stylesheet" href="public/librerias/jquery-ui.css" type="text/css"></link>	
	<link rel="stylesheet" href="public/css/w3.css">
		<link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">

	<script type="text/javascript" src="public/js/jquery.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/efect.js"></script>

	<link rel="stylesheet" href="public/sweetalert2/sweetalert2.min.css">
	<script src="public/sweetalert2/sweetalert2.min.js"></script>
	<!--.......................-->
	<!-- Librería Timepicker -->
	<script type="text/javascript" src="public/librerias/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="public/librerias/jquery/jquery-ui-timepicker.js"></script>
	<script src="public/js/parsley.min.js"></script>

	<script type="text/javascript" src="public/librerias/js/validaciones.js"></script>
  	<script type="text/javascript">
		$(document).ready(function(){
		    $('.minotificacion').click(function(){            
		        if ($('.minotificacion .notificacion-menu').is (':hidden'))
		            $('.minotificacion .notificacion-menu').show();
	            else
	                $('.notificacion-menu').hide();
		        return false;
		    });
		    $('body,html').click(function(){
		       $('.notificacion-menu').hide();
		    });
		});
		
		function nobackbutton(){
		   window.location.hash="no-back-button";
		   window.location.hash="Again-No-back-button" //chrome
		   window.onhashchange=function(){window.location.hash="no-back-button";}
		}
	</script>
</head>
<body class="fond_perfil"  onload="nobackbutton()" >
	<!--menu cintilo este sera fijo-->
		<!--inicio de cintillo-->
        <div class="header" style="width:100%;align:center;position:relative; background:#37474F;"  >
            <div style="width:100%;position:abosolute;height:90%">
	        		<img src="public/img/logofondas.png" id="logo" style="width:100%">
            </div>
        </div>
		<!--fin de cintillo-->
	<!--cierre del cintillo fijo-->

<!--contenido de la pagina-->
<div class="contenido limpiar" style="margin-top:20px;">
	<!--contenido izquierda-->
	
	<div class="contenido_izquierda">
		<ol class="menu_content">
			<!--<li class="seccion_perfil"><a href="?"><img src="public/img/tico.jpg"style='cursor:pointer;' ></a>		
			</li><br>-->
			<?php
             if(!$_SESSION['tipo_usuario'])	{
				 echo"<script>window.location='?'+location.hash;</script>";
				} 
				else {
					include("menu.php");
				    include("botones.php");
                }
            ?>		
			<li class="list_padre limpiar" onclick='salir()'><i class="fa fa-sign-out" aria-hidden="true"></i>
				Salir	
			</li>
		</ol>
		
	</div>

	<!--contenido derecha-->
	<div class="contenido_derecha limpiar">	
	<input type='hidden'  name='idhistorial' readonly="" value='<?php echo($_SESSION['idhistorial']);?>' />
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
</div>
<!--pie de pagina-->
	<div  >
        <h4 style="color:#fff;">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<pre style="background-color: #37474F; height:70px; text-align:center; color:#fff;">  © Fondo para el Desarrollo Agrario Socialista </pre>

        </h4>
    </div>
<!--pie de pagina-->

<?php if($msj){ ?>   <script>  swal('Error...', '<?php print($msj); ?>', 'error'); </script>   <?php  };  ?>

</body>
</html>
<script>
	function salir(){
		swal({   
			html: "¿Está seguro que quiere salir?",  
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55", 
			confirmButtonText: "Aceptar!",   
			cancelButtonText: "Cancelar!",   
			closeOnConfirm: false,  
        	showCloseButton: true,
			closeOnCancel: false
		}).then((result) => {
			if (result.value) {
				var id="<?php echo ($_SESSION['idhistorial']);?>";
				location.href="controlador/corCerrar.php?id=" + id;
			}
			else if (result.dismiss) {
				swal({
					html: "Espere en 5 segundos!",
					text: "¡Gracias por permanecer en la página! '<?php echo ($_SESSION['nombre']);?>'",
					timer: 5000,
					showConfirmButton: false
				});
			}
		});
	}
</script>