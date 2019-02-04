
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <title>Pagina de Inicio FONDAS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="public/img/icono.ico" />
  <link href="public/js/bower_components/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="public/css/estiloh.css" type="text/css" media="all">
  <link rel="stylesheet" href="public/css/menu.css">
  <link rel="stylesheet" href="public/css/w3.css">
  <link rel="stylesheet" href="public/css/galeria.css">
  <script type="text/javascript" src="public/jquery/jquery.js"></script>
</head>

<body
  <!--inicio de cintillo-->
  <div class="header" style="width:100%;align:center;position:relative; background:#37474F;"  >
    <div style="width:100%;position:abosolute;height:90%">
      <img src="public/img/logofondas.png"  style="width:100%">
    </div>
  </div>
  <!--fin de cintillo-->>

<!--inicio de cuerpo-->
<!--inicio de menu-->
<div style="padding:20px;position:absolute;background:url('public/img/detrasparrafo.jpg');height:500px;width:100%; ">
        <div class="topnav" id="myTopnav">
		  <a href="?">&nbsp;&nbsp;Inicio</a>
		  <a href="?accion=Nosotros">&nbsp;&nbsp;Nosotros</a>
		  <a href="?accion=Galeria" class="active">&nbsp;&nbsp;Galería</a>
		  <a href="?accion=Contactanos">&nbsp;&nbsp;¿Donde Estamos?</a>
		  <a href="?accion=Login" style="float:right; "><img src="public/img/usuario2.png" width="25" height="25"  font="">&nbsp;&nbsp;Intranet</a>
		  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="mymenu()">&#9776;</a>
		</div>
<!--fin menu-->
		<h4 style="color:#4D4D4D; font-weight: bold; text-align:center;" class="texto">Galeria</h4>
<div class="row">
	<div  class="col-12">
		<div class="column">
			<div class="card">
				<img src="public/img/page4_img1.jpg" style="width:100%;" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
				<div class="container">
					<button class="accordion"><span style="font-weight: bold;">Descripción</span></button>
					<div class="panel">
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p><p>incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>

				</div>
			</div>
		</div>
		<div class="column">
			<div class="card">
				<img src="public/img/6.jpg" style="width:100%" onclick="openModal();currentSlide(2)" class="hover-shadow cursor">
				<div class="container">
					<button class="accordion"><span style="font-weight: bold;">Descripción</span></button>
					<div class="panel">
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p><p>incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="column">
			<div class="card">
				<img src="public/img/images (5).jpg" style="width:100%" onclick="openModal();currentSlide(3)" class="hover-shadow cursor">
				<div class="container">
					<button class="accordion"><span style="font-weight: bold;">Descripción</span></button>
					<div class="panel">
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p><p>incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>

<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">

    <div class="mySlides">
      <div class="numbertext">1 / 3</div>
      <img src="public/img/6.jpg" style="width:100%">
    </div>

    <div class="mySlides">
      <div class="numbertext">2 / 3</div>
      <img src="public/img/images (1).jpg" style="width:100%">
    </div>

    <div class="mySlides">
      <div class="numbertext">3 / 3</div>
      <img src="public/img/images (5).jpg" style="width:100%">
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>

    <div class="column">
      <img class="demo cursor" src="public/img/images (1).jpg" style="width:100%" onclick="currentSlide(1)" alt="Fondo para el desarrollo agrario socialista">
    </div>
    <div class="column">
      <img class="demo cursor" src="public/img/6.jpg" style="width:100%" onclick="currentSlide(2)" alt="Fondas">
    </div>
    <div class="column">
      <img class="demo cursor" src="public/img/images (5).jpg.jpg" style="width:100%" onclick="currentSlide(3)" alt="Síguenos en Facebook">
    </div>
	</div>
	  </div>
 <!--pie de pagina-->
	<div class="pie" style="max-height:65px; background-color:#37474F; width:100%">
        <h5>
           © Fondo para el Desarrollo Agrario Socialista

        </h5>
    </div>
<!--pie de pagina-->
<script>
function mymenu() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}


function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("activa");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  }
}
</script>

</body>
</html>
