

var lsVista = "Cambiar_Respuestas";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor ) {
	let arrFormulario = $( "#form" + lsVista );
	var viCodigo = document.getElementById("numId");
	var vsNombre = document.getElementById("ctxNombre");
	var vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (vsNombre.value.trim() === "" && pvValor === "Guardar" ) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		}).then( ( result ) => {
			vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}


	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



$(function () {

	fjComboGeneral( "Pregunta" , "" , "Pregunta1" );

	fjComboGeneral( "Pregunta" , "" , "Pregunta2");

});




