

<aside>

	<!--inicio de cintillo-->
	<div class="header" style="width:100%;align:center;position:relative; background:#37474F;"  >
		<div style="width:100%;position:abosolute;height:90%">
			<img src="public/img/logofondas.png" id="logo" style="width:100%">
		</div>
	</div>
	<!--fin de cintillo-->

	
	<nav class="navbar navbar-inverse sidebar navbar-fixed-top" role="navigation">
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

		<div class="nav-side-menu">
	    	<div class="brand">
				<a class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="Tiempo que perdurara la sesion, pulse aqui para pausar el cronometro" onClick="fjDetenerCronometro();">
					<span id="minutos" >00 </span> : <span id="segundos">00</span>
					<span id="cronometro" style="display: none;"> / 00 </span>
				</a>	
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Cambiar el Tiempo de sesion" onClick="fjTiempoSesion();">
					<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
				</button>
	    	</div>
			<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
	  
	        <div class="menu-list">
	  
	            <ul id="menu-content" class="menu-content collapse out">
	   
					<li class="active">
						<a href="?form=Bienvenida.php">
							<i class="fa fa-dashboard fa-lg"></i> Inicio
							<i class="fa fa-dashboard fa-lg btn pull-right" style="margin-top:5px"></i>
						</a>
	                </li>

					<?php 
						include_once("controlador/conMenu.php");
					?>

					<li class="active" onclick='salir()'>
						<a >
							<i class="fa fa-sign-out fa-lg"></i> Salir
							<i class="fa fa-sign-out fa-lg btn pull-right" style="margin-top:5px"></i>
						</a>
	                </li>
	            </ul>
			</div>
		</div>
	</nav>
  
</aside>







