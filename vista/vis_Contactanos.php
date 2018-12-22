
<!DOCTYPE html>
<html>
<head>
    <title>Pagina de Inicio FONDAS</title>

	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8"/>
	<script type="text/javascript" src="public/jquery/jquery.js"></script>
	<script src="public/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="public/css/menu.css">
	<link rel="stylesheet" href="public/dist/sweetalert.css">
	<link rel="stylesheet" href="public/css/w3.css">
	<style>
		.fa {
		  padding: 20px;
		  font-size: 30px;
		  width: 50px;
		  text-align: center;
		  text-decoration: none;
		  margin: 5px 2px;
		}

		.fa:hover {
			opacity: 0.7;
		}
		.fa-facebook {
		  background: #3B5998;
		  color: white;
		}
		.fa-twitter {
		  background: #55ACEE;
		  color: white;
		}
		.fa-instagram {
		  background: #125688;
		  color: white;
		}
	</style>

</head>
<body>
<!--inicio de cuerpo-->

		<!--inicio de cintillo-->
        <div class="header" style="width:100%;align:center;position:relative; background:#37474F;"  >
            <div style="width:100%;position:abosolute;height:90%">
	        		<img src="public/img/logofondas.png" id="logo" style="width:100%">
            </div>
        </div>
		<!--fin de cintillo-->

<!--inicio de menu-->
<div style="padding:20px;position:absolute;background:url('public/img/detrasparrafo.jpg');height:500px;width:100%; ">
		<div class="topnav" id="myTopnav">
		  <a href="?" >&nbsp;&nbsp;Inicio</a>
		  <a href="?accion=Nosotros">&nbsp;&nbsp;Nosotros</a>
		  <a href="?accion=Galeria">&nbsp;&nbsp;Galería</a>
		  <a href="?accion=Contactanos" class="active">&nbsp;&nbsp;¿Donde Estamos?</a>
		  <a href="?accion=Login" style="float:right; "><img src="public/img/usuario2.png" width="25" height="25"  font="">&nbsp;&nbsp;Intranet</a>
		  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="mymenu()">&#9776;</a>
		</div>
<!--fin menu-->

<!--centro-->
        <div class="row">
		
        <div class="col-9" style="text-align:center;">
            <img src="public/img/croquis.png" id="sd" style="width:90%; height:300px; border-radius:12px; ">
        </div>
		<div  class="col-3 left  ">    
            
			<div class="row content">
                <a href="#" class="fa fa-facebook"></a>
				<a href="#" class="fa fa-instagram"></a>
				<a href="#" class="fa fa-twitter"></a>
			</div>
		</div>


        </div>
<!--fin centro-->

<!--pie de pagina-->
	<div class="pie" style="max-height:65px; background-color:#37474F; width:100%">
        <h5>
			© Fondo para el Desarrollo Agrario Socialista

        </h5>
    </div>
<!--pie de pagina-->


</div>
<!--fin cuerpo-->
</body>
<?php if($msj){ ?>   <script>  swal('', '<?php print($msj); ?>', 'error'); </script>   <?php  };  ?>
</html>
<script>
function mymenu() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

 </script>