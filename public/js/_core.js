
$( function() {
  $('[data-toggle="tooltip"]').tooltip();

  $(".select2 , .combo_buscar , .select_dinamico, .dinamico ").select2({
    language: "es" ,
    theme: "bootstrap"
  });
  //inicia la función para búsquedas en los select
	if ($.isFunction($.fn.select2)) {
		$(".select2, .combo_buscar, .select_dinamico, .combo_dinamico")
		.select2({
			language: "es",
			theme: "bootstrap"
		});
		//.css("width", "100%");
	}
  //$('.calendario').datetimepicker();

  //función anónima que al cambiar un select asigna el valor al hidden que esta abajo de el
	//$('select > .dinamico').on('change', function() {
	$('select.dinamico').on('change', function() {
		let vsId = $(this).attr("id"); //toma el id del select
		//$(this).css("width", "100%"); //agrega el ancho del 100%
		//toma la cadena desde la posición 3 hacia la derecha cmbEJEMPLO = EJEMPLO
		let vsComponente = vsId.substr(3); //le quita las primeras 3 letras "cmb"

		//asigna el valor del select al hidden
		$("#hid" + vsComponente).val($(this).val());
		// console.log(vsComponente);
		console.log($("#hid" + vsComponente).val());

		//para tomar el texto
		if ($("#hid " + vsComponente + "Texto")) {
			//let txt = $("#cmb" + vsComponente + " option:selected").text();
			let txt = $("#cmb" + vsComponente + " option:selected").html();
			$("#hid " + vsComponente + "Texto").val(txt);
			//console.log(txt);
		}
	});
});
