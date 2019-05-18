
$(function() {
	// inicia la función para los mensajes de ayuda de bootstrap
	if ($.isFunction($.fn.tooltip)) {
		$('[data-toggle="tooltip"]').tooltip();
	}
	// inicia la función para búsquedas en los select
	if ($.isFunction($.fn.select2)) {
		$(".select2, .combo_buscar, .select_dinamico, .combo_dinamico")
		.select2({
			language: "es",
			theme: "bootstrap"
		});
		//.css("width", "100%");
	}

	// función anónima que al cambiar un select asigna el valor al hidden que esta abajo de el
	//$('select > .dinamico').on('change', function() {
	$('select.dinamico').on('change', function() {
		let vsId = $(this).attr("id"); //toma el id del select
		//$(this).css("width", "100%"); //agrega el ancho del 100%
		//toma la cadena desde la posición 3 hacia la derecha cmbEJEMPLO = EJEMPLO
		let vsComponente = vsId.substr(3); //le quita las primeras 3 letras "cmb"

		//asigna el valor del select al hidden
		$("#hid" + vsComponente).val($(this).val());
		// console.log(vsComponente);
		//console.log($("#hid" + vsComponente).val());

		//para tomar el texto
		if ($("#hid " + vsComponente + "Texto")) {
			//let txt = $("#cmb" + vsComponente + " option:selected").text();
			let txt = $("#cmb" + vsComponente + " option:selected").html();
			$("#hid " + vsComponente + "Texto").val(txt);
			//console.log(txt);
		}
	});

	$('.hora_pickatime').datetimepicker({
		format: 'LT',
		locale: 'es'
		// format: 'h:i A',
		// interval: 30
	});

	$(".fecha_pickatime, .calendario").datetimepicker({
		//viewMode: 'months',
		//format: 'DD/MM', 
		format: 'DD-MM-YYYY', 
		//disabledHours: false,
		minDate: moment(),
		locale: "es"
	});

	$('.fecha_hora_datepicker').datetimepicker({
		format: 'DD-MM-YYYY HH:mm A',
		locale: 'es'
	});

});


function mymenu() {
	var x = document.getElementById("myTopnav");
	if (x.className === "topnav") {
		x.className += " responsive";
	}
	else {
		x.className = "topnav";
	}
}


function salir(psRuta = ""){
	swal({
		html: "¿Está seguro que quiere salir?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Aceptar!",
		cancelButtonText: "Cancelar!",
		showCloseButton: true
	})
	.then((result) => {
		if (result.value) {
			location.href= psRuta + "controlador/conCerrar.php";
		}
		else if (result.dismiss) {
			swal({
				html: "Espere en 5 segundos!",
				text: "¡Gracias por permanecer en la página!",
				timer: 5000,
				showConfirmButton: false
			});
		}
	});
}

/**
 * Get date and time from client in a object value
 * @param {string} type Type value of return
 * @returns {object|string} 
 */
function clientDateTime(type = "") {
	let months = [
		{
			number: "01",
			letter: "Enero"
		},
		{
			number: "02",
			letter: "Febrero"
		},
		{
			number: "03",
			letter: "Marzo"
		},
		{
			number: "04",
			letter: "Abril"
		},
		{
			number: "05",
			letter: "Mayo"
		},
		{
			number: "06",
			letter: "Junio"
		},
		{
			number: "07",
			letter: "Julio"
		},
		{
			number: "08",
			letter: "Agosto"
		},
		{
			number: "09",
			letter: "Septiembre"
		},
		{
			number: 10,
			letter: "Octubre"
		},
		{
			number: 11,
			letter: "Noviembre"
		},
		{
			number: 12,
			letter: "Diciembre"
		}
	];

    //se obtiene la fecha actual del dispositivo CLIENTE
	let objFecha = new Date(); //instancia un objeto
    let datFecha = objFecha.getFullYear() + "-" + months[objFecha.getMonth()].number + "-" + objFecha.getDate();
    let timHora = objFecha.getHours() + ":" + objFecha.getMinutes() + ":" + objFecha.getSeconds();
	let dateTime = {
		date: datFecha,
		time: timHora
	};

	if (type.toLowerCase() == "t") {
		return dateTime.time;
	}
	else if (type.toLowerCase() == "d") {
		return dateTime.date;
	}
	return dateTime
}
