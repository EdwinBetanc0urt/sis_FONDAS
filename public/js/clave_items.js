
// define variables global
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

      fjValidarClave();

    }).focus(function() {
      $('.divItemsClave').show();
    }).blur(function() {
      $('.divItemsClave').hide();
    });
});



function fjValidarClave() {
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
