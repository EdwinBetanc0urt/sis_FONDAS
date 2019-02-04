
// define variables globales
var claveLongitud = false, claveMinus = false, claveMayus = false,
  claveNumero = false, claveEspecial = false;

$(function() {
  // deshabilita el campo de clave de confirmación
  $("#pswClave2, .confirm-password").attr("disabled", true);

  $('#pswClaveN, .new-password')
    .keyup(function() {
      // set password variable
      var pswd = $(this).val();
      $('#claveLongitud, #claveMinuscula, #claveMayuscula, #claveNumero, #claveEspecial')
        .removeClass('valido')
        .addClass('invalido');

      // inicializa las variables
      claveLongitud = false, claveMinus = false, claveMayus = false,
        claveNumero = false, claveEspecial = false;

      //valida el tamaño de caracteres sea mínimo de 8
      if (pswd.length >= 8) {
        claveLongitud = true;
        $('#claveLongitud').removeClass('invalido').addClass('valido');
      }
      //valida si hay letra claveMinuscula
      if (pswd.match(/[a-z]/)) {
        claveMinus = true;
        $('#claveMinuscula').removeClass('invalido').addClass('valido');
      }
      //valida si hay letra Mayúscula
      if (pswd.match(/[A-Z]/)) {
        claveMayus = true;
        $('#claveMayuscula').removeClass('invalido').addClass('valido');
      }
      //valida que contenga claveNumeros
      if (pswd.match(/\d/)) {
        claveNumero = true;
        $('#claveNumero').removeClass('invalido').addClass('valido');
      }
      //valida que contenga caracteres claveEspeciales
      //if (pswd.match(/\W/)) {
      if (pswd.match(/[.+*\-_$]/)) {
        claveEspecial = true;
        $('#claveEspecial').removeClass('invalido').addClass('valido');
      }

      validarClave();

    }).focus(function() {
      $('.divItemsClave').show();
    }).blur(function() {
      $('.divItemsClave').hide();
    });
});


function validarClave() {
  var clave = $("#pswClaveN, .new-password"),
    clave2 = $("#pswClaveNConfirma, .confirm-password");

  if (claveMinus && claveLongitud && claveMayus && claveNumero && claveEspecial) {
    console.log("clave validada con éxito");
    clave2.removeAttr("disabled");
    return true;
  }
  clave.focus();
  clave2.attr("disabled", true); // deshabilita el campo de estado
  return false;
}


/**
 * ObtenerPreguntas, consulta las preguntas de seguridad que pertenecen al usuario.
 * @author Edwin Betanc0urt <EdwinBetanc0urt@outlook.com>
 * @param {string} nRequest, numero de pregunta, cualquier valor diferente a vació.
 */
function ObtenerPreguntas(nRequest = "") {
  $.ajax({
    method: "POST",
    url: "controlador/conCambiar_Clave.php",
    data: {
      idu: $("#hidUser").val(),
      operacion: "ConsultaPreguntas",
      nr: nRequest
    }
  })
  .done(function(arrRespuesta) {
    if (nRequest != "") {
      $("#textPregunta1").html(arrRespuesta.datos.pregunta);
      $("#hidPregunta1").val(arrRespuesta.datos.idpregunta);
    }
    else {
      $("#textPregunta2").html(arrRespuesta.datos.pregunta);
      $("#hidPregunta2").val(arrRespuesta.datos.idpregunta);
    }
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
    swal({
      title: 'Estatus: ' + textStatus,
      html: 'La petición realizada no ha sido procesada correctamente',
      type: 'error',
      showCloseButton: true,
      confirmButtonText: 'Ok',
      footer: '<b>Error http:</b> ' + errorThrown + " / " + jqXHR.status
    });
  });
} //cierre de la función
