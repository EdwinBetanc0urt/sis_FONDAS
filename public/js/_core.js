
$( function() {
  $('[data-toggle="tooltip"]').tooltip();

  $(".select2 , .combo_buscar , .select_dinamico, .dinamico ").select2({
    language: "es" ,
    theme: "bootstrap"
  });

  //$('.calendario').datetimepicker();

  //funcion anonima que al cambiar un select asigna el valor al hidden que esta abajo de el
  //$('select > .dinamico').on( 'change' , function() {
  $( 'select.dinamico' ).on( 'change' , function() {
    let vsId = $( this ).attr( "id" ); //toma el id del select
    //toma la cadena desde la posicion 3 hacia la derecha cmbEJEMPLO = EJEMPLO
    let vsClase = vsId.substr( 3 ); //le quita las primeras 3 letras "cmb"

    //asigna el valor del select al hidden
    $( "#hid" + vsClase ).val( $( this ).val() );
    console.log( vsClase );
    console.log( $( "#hid" + vsClase ).val() );

    //para tomar el texto
    if ( $("#hid " + vsClase + "Texto") ) {
      //let txt = $("#cmb" + vsClase + " option:selected").text();
      let txt = $( "#cmb" + vsClase + " option:selected" ).html();
      $("#hid " + vsClase + "Texto" ).val( txt );
      //console.log(  txt );
    }
  });
});
