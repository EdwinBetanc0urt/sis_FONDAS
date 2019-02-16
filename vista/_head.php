	<!--
		/**
		 * Agrega todos los archivos css y js para mantener un solo archivo global.
		 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com>
		 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
		 * @link https://creativecommons.org/licenses/by-sa/4.0/
		 */
	-->
	<title>Intranet FONDAS</title>
	<link rel="icon" type="image/png" href="public/img/icono.ico" />
	<meta charset="utf8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="public/font-awesome/css/fontawesome-all.min.css" />
	<link rel="stylesheet" type="text/css" href="public/font-awesome-4.3.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="public/css/menu_intranet.css" />
	<link rel="stylesheet" type="text/css" href="public/css/global.css" />
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="public/select2/dist/css/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="public/select2/dist/css/select2-bootstrap.min.css" />

	<link rel="stylesheet" href="public/jquery/jquery-ui/jquery-ui.min.css" />
	<script type="text/javascript" src="public/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="public/jquery/jquery-ui/jquery-ui.min.js"></script>

	<link rel="stylesheet" href="public/sweetalert2/sweetalert2.min.css" />

	<link rel="stylesheet" href="public/bootstrap-datetimepicker_Eonasdan/css/bootstrap-datetimepicker.min.css" />


	<script type="text/javascript" src="public/moment/min/moment.min.js">
		//! moment.js
		//! version : 2.20.1
		//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
		//! license : MIT
		//! momentjs.com
	</script>
	<script type="text/javascript" src="public/moment/min/locales.min.js"></script>

	<script type="text/javascript" src="public/bootstrap/js/bootstrap.js">
		/*!
		 * Bootstrap v3.3.7 (http://getbootstrap.com)
		 * Copyright 2011-2016 Twitter, Inc.
		 * Licensed under the MIT license
		 */
	</script>

	<script type="text/javascript" src="public/bootstrap-datetimepicker_Eonasdan/js/bootstrap-datetimepicker.min.js"></script>

	<script type="text/javascript" src="public/pickadate/compressed/picker.js">
		/*!
		 * pickadate.js v3.5.6, 2015/04/20
		 * By Amsul, http://amsul.ca
		 * Hosted on http://amsul.github.io/pickadate.js
		 * Licensed under MIT
		 */
	</script>
	<script type="text/javascript" src="public/pickadate/compressed/picker.date.js">
		/*!
		 * Date picker for pickadate.js v3.5.6
		 * http://amsul.github.io/pickadate.js/date.htm
		 */
	</script>
	<script type="text/javascript" src="public/pickadate/compressed/picker.time.js">
		/*!
		 * Time picker for pickadate.js v3.5.6
		 * http://amsul.github.io/pickadate.js/time.htm
		 */
	</script>
	<script type="text/javascript" src="public/pickadate/compressed/translations/es_ES.js"></script>

	<script type="text/javascript" src="public/select2/dist/js/select2.min.js">
		/*!
		 * Select2 4.0.5
		 * https://select2.github.io
		 *
		 * Released under the MIT license
		 * https://github.com/select2/select2/blob/master/LICENSE.md
		 */
	</script>
	<script type="text/javascript" src="public/select2/dist/js/i18n/es.js"></script>

	<script src="public/sweetalert2/sweetalert2.min.js">
		/*!
		 * sweetalert2 v7.8.2
		 * Released under the MIT License.
		 */
	</script>

	<script type="text/javascript" src="public/js/_core.js"></script>
	<script type="text/javascript" src="public/js/validaciones.js"></script>
	<script type="text/javascript" src="public/js/intranet.js"></script>
	<script type="text/javascript" src="<?= "public/js/" . strtolower($form) . ".js"; ?>"></script>
	
	<!--  Mensajes Emergentes -->
	<script src="public/js/alertas.js" type="application/javascript"></script>
	<?php
		// si existe la variable get msjAlerta Incluye el archivo JavaScript
		if (isset($_GET['msjAlerta'])) {
			?>
			<script type="application/x-javascript">
				$(function () {
					// cuando el documento este listo llama la función fjMensajes que esta en el archivo jsp_Alertas.js
					fjMensajes("<?= $_GET["msjAlerta"]; ?>");
					// envía el valor que tiene msjAlerta (sinconsulta, registro, nocambio, etc)
				});
			</script>
			<?php
		} //cierre del condicional de isset

		// si existe la variable get getOpcion
		if (isset($_GET['getOpcion'])) { 
			?>
			<script type='application/x-javascript'>
				// Script Utilizado solo en consultas
				// imprime código JavaScript y abre la ventana modal con id VentanaModal
				$(document).ready(function(){ // para versión 0.97.8 de materialize.js
					$("#VentanaModal").modal('show'); // para boostrap v3.3.7
					//$("#VentanaModal").modal('open'); // para versión 0.97.8 de materialize.js
					//$("#VentanaModal").openModal(); // para versión 0.97.3 de materialize.js
				});
			</script>
			<?php 
		}
	?>
	<script type="text/javascript">
		//cuando carga la ventana
		$(function() {
			fjIniciarCronometro("<?= $_SESSION['tiempo_sesion']; ?>");

			$('.fecha_hora').datepicker({
                format: 'LT'
            });

            /*$('.hora_pickatime').pickatime({
                format: 'h:i A',
                interval: 30
            });*/

            $('.hora_pickatime').datetimepicker({
                format: 'LT',
				locale: 'es'
            });

			$('.fecha_hora_datepicker').datetimepicker({
				format: 'DD-MM-YYYY HH:mm A',
				locale: 'es'
			});


		    $(".calendario").datetimepicker({
				//viewMode: 'months',
				//format: 'DD/MM', 
				format: 'DD-MM-YYYY', 
				//disabledHours: false,
				minDate: moment(),
				locale: "es"
		    });
			//fjHorasServidorCliente();
		});
		// mientras este haciendo escribiendo o cambiando algo de la pagina
		// reinicia el tiempo de inactividad
		$('body').on('keyup keypress keydown change', function(){
			//alert('El evento funciona!');
			fjDetenerCronometro();

			fjIniciarCronometro("<?= $_SESSION['tiempo_sesion']; ?>");
		});
	</script>
