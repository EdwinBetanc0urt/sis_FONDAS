
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

	//$('.calendario').datetimepicker();

	// función anónima que al cambiar un select asigna el valor al hidden que esta abajo de el
	$('select.dinamico' ).on('change' , function() {
		let vsId = $(this ).attr("id" ); // toma el id del select
		// toma la cadena desde la posición 3 hacia la derecha cmbEJEMPLO = EJEMPLO
		let vsClase = vsId.substr(3 ); // le quita las primeras 3 letras "cmb"

		// asigna el valor del select al hidden
		$("#hid" + vsClase ).val($(this ).val() );
		console.log(vsClase );
		console.log($("#hid" + vsClase ).val() );

		// para tomar el texto
		if ($("#hid " + vsClase + "Texto") ) {
			//let txt = $("#cmb" + vsClase + " option:selected").text();
			let txt = $("#cmb" + vsClase + " option:selected" ).html();
			$("#hid " + vsClase + "Texto" ).val(txt );
			//console.log(	txt );
		}
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
	}).then((result) => {
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
