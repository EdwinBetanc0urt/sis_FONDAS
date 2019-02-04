
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Pagina de Inicio FONDAS</title>

	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
	<link rel="stylesheet" href="public/css/menu.css">
	<link rel="stylesheet" href="public/css/w3.css">

	<script type="text/javascript" src="public/jquery/jquery.js"></script>
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
				<a href="?"  class="active">&nbsp;&nbsp;Inicio</a>
				<a href="?accion=Nosotros">&nbsp;&nbsp;Nosotros</a>
				<a href="?accion=Galeria">&nbsp;&nbsp;Galería</a>
				<a href="?accion=Contactanos">&nbsp;&nbsp;¿Donde Estamos?</a>
				<a href="?accion=Login" style="float:right; "><img src="public/img/usuario2.png" width="25" height="25"  font="">&nbsp;&nbsp;Intranet</a>
				<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="mymenu()">&#9776;</a>
			</div>
		<!--fin menu-->

		<!--centro-->
        <div class="row">
			<!--contenedor de imagen-->
            <div class="col-8" style="text-align:center;">

				<div class="slideshow-container">

					<div class="mySlides fade">
					  <div class="numbertext">1 / 3</div>
					  <img src="public/img/iniciodefodas.jpg" style="width:95%; height:400px; border-radius:12px;">
					</div>

					<div class="mySlides fade">
					  <div class="numbertext">2 / 3</div>
					  <img src="public/img/2222.png" style="width:95%; height:400px; border-radius:12px;">
					</div>

					<div class="mySlides fade">
					  <div class="numbertext">3 / 3</div>
					  <img src="public/img/00.png" style="width:95%; height:400px; border-radius:12px;">
					</div>
					<div style="text-align:center">
					  <span class="dot"></span>
					  <span class="dot"></span>
					  <span class="dot"></span>
					</div>

				</div>
	            <!--<img src="" id="imagen" style="width:95%; height:400px; border-radius:12px; ">-->
			</div>
			<!--fin contenedor de imagen-->

			<div  class="col-4 left  ">
           		<div class="row content" style="background:url('public/img/hhh.jpg');">
                    <div style="background:#37474F; height:100%;" class="w3-center">
						<h4 style="color:#fff">Noticias Actualidad..</h4>
					</div>
					<MARQUEE HEIGHT=340px DIRECTION=up SCROLLAMOUNT=5 behavior=scroll >
						<div class="w3-content w3-section" style="max-width:400px">

							<p>Fondas se suma al encadenamiento productivo de las casas de alimentación de
							Carabobo</p>
							<p style="align:center">
							<img src="public/img/caraboboalimentacion.jpg" style="width:100%; height:100%; border-radius:5px 5PX 12PX 12PX ; ">
							</p>


							<p> Presidente de Fondas</p>
							</p>inspeccionó Núcleo de Formación “Indio Rangel”</p>
							<p>
								<img src="public/img/1111.jpg" style="width:100%; height:80%; border-radius:5px 5PX 12PX 12PX ; ">
							</p>
							<p>
							Presentan propuesta agro-silvo-pastoril en Encuentro de la Semilla Autóctona</p>
							<p>
								<img src="public/img/semillacarabobo.jpg" style="width:100%; height:80%; border-radius:5px 5PX 12PX 12PX ; ">
							</p>
							<p>
							Comienza arrime de maíz blanco en Apure
							</p>
								<img src="public/img/arrimeapuremaiz.jpg" style="width:100%; height:80%; border-radius:5px 5PX 12PX 12PX ; ">
							</p>
						</div>
					</MARQUEE>

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
	<script type="text/javascript" src="public/js/_core.js"></script>
	<script>
	  /**imagenes*/
		var slideIndex = 0;
		showSlides();

		function showSlides() {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			var dots = document.getElementsByClassName("dot");
			for (i = 0; i < slides.length; i++) {
			   slides[i].style.display = "none";
			}
			slideIndex++;
			if (slideIndex > slides.length) {
        slideIndex = 1
      }
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" active", "");
			}
			slides[slideIndex-1].style.display = "block";
			dots[slideIndex-1].className += " active";
			setTimeout(showSlides, 5000); // Change image every 2 seconds
		}
	</script>
</body>
</html>
