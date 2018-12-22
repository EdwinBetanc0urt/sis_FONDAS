/*
 * Llamadas Ajax
 * Open source under the BSD License.
 * Copyright © 2018 EdwinBetanc0urt <EdwinBetanc0urt@outlook.com>
 * All rights reserved.
*/


if (typeof jQuery === "undefined") {
    throw new Error("Las consultas y llamadas AJAX requieren jQuery, By EdwinBetanc0urt");
}



//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjComboGeneral(psClase, psDependiente = "", psDestino = "", psSwitch = "ListaCombo") {

    let viDependiente = "";
    //abre el archivo controlador y envia por POST
    vsRuta = "controlador/con" + psClase + ".php";
    //si no tiene un codigo dependiente, padre o foraneo lo envia vacio
    if (psDependiente != "") {
        if ($("#hid" + psDependiente).length > 0)
            viDependiente = parseInt($("#hid" + psDependiente).val());
        else
            viDependiente = psDependiente
        console.log("El padre o matriz es " + psDependiente); 
    }

    if (psDestino != "") {
        psClase =  psDestino;
        console.log("nuevo destino " + psClase);
    }

    $.post(vsRuta, {
            hidCodPadre:  viDependiente,
            operacion: psSwitch,
            hidCodigo: $("#hid" + psClase).val() 
        },
        function(resultado) {
            if (resultado == false)
                console.log("sin consultas de " + psClase);
            else {

                cmbCombo = document.getElementById("cmb" + psClase);
                $("#cmb" + psClase).attr("disabled", false); //habilita el campo de estado

                cmbCombo.options.length = 1; //limpia los option del select
                //cmbCombo.options.length = 1; //limpia los option del select
                $("#cmb" + psClase).append(resultado); //agrega los nuevos option al select

                console.log(resultado);
            }
        }
   );
}
$(function() {
    //funcion anonima que al cambiar un select asigna el valor al hidden que esta abajo de el
    //$('select > .dinamico').on('change', function() {
    $('select.dinamico').on('change', function() {
        let vsId = $(this).attr("id"); //toma el id del select
        //toma la cadena desde la posicion 3 hacia la derecha cmbEJEMPLO = EJEMPLO
        let vsClase = vsId.substr(3); //le quita las primeras 3 letras "cmb"
        
        //asigna el valor del select al hidden
        $("#hid" + vsClase).val($(this).val());
        console.log(vsClase);
        console.log($("#hid" + vsClase).val());

        //para tomar el texto
        if ($("#hid " + vsClase + "Texto")) {
            //let txt = $("#cmb" + vsClase + " option:selected").text();
            let txt = $("#cmb" + vsClase + " option:selected").html();
            $("#hid " + vsClase + "Texto").val(txt);
            //console.log( txt);
        }
    });
});