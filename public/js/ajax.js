/**
 * Llamadas Ajax
 * Open source under the BSD License.
 * Copyright © 2018 EdwinBetanc0urt <EdwinBetanc0urt@outlook.com>
 * All rights reserved.
 */
if (typeof jQuery === "undefined") {
    throw new Error("Las consultas y llamadas AJAX requieren jQuery, By EdwinBetanc0urt");
}

/**
 * funcion javascript Combo General
 * Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
 * sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos.
 * @param {string} psClase elemento php para abrir, ademas del id del elemento
 * select por defecto donde colocara el resultado.
 * @param {string} psDependiente elemento select o padre mediante el cual toma el
 * valor para filtrar los resultados a obtener.
 * @param {string} psDestino id del elemento select donde colocara los resutltados,
 * por defecto es el mismo de la clase.
 * @param {string} psSwitch caso en el switch que desplegara la funcion en el backend.
 * @author EdwinBetanc0urt
 */
function fjComboGeneral(psClase, psDependiente = "", psDestino = "", psSwitch = "ListaCombo") {
    let viDependiente = "";
    // abre el archivo controlador y envía por POST
    vsRuta = "controlador/con" + psClase + ".php";
    // si no tiene un código dependiente, padre o foráneo lo envía vació
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
            //console.log(resultado);
            if (resultado == false) {
                console.log("sin consultas de " + psClase);
            }
            else {
                cmbCombo = document.getElementById("cmb" + psClase);
                cmbCombo.options.length = 1; // limpia los option del select

                $("#cmb" + psClase)
                    .append(resultado) // agrega los nuevos option al select
                    .attr("disabled", false); // habilita el campo de estado
            }
        }
    );
}


$(function() {
    // función anónima que al cambiar un select asigna el valor al hidden que esta abajo de el
    //$('select > .dinamico').on('change', function() {
    $('select.dinamico').on('change', function() {
        let vsId = $(this).attr("id"); //toma el id del select
        //toma la cadena desde la posición 3 hacia la derecha cmbEJEMPLO = EJEMPLO
        let vsClase = vsId.substr(3); //le quita las primeras 3 letras "cmb"

        //asigna el valor del select al hidden
        $("#hid" + vsClase).val($(this).val());
        //console.log(vsClase);
        //console.log($("#hid" + vsClase).val());

        //para tomar el texto
        if ($("#hid " + vsClase + "Texto")) {
            //let txt = $("#cmb" + vsClase + " option:selected").text();
            let txt = $("#cmb" + vsClase + " option:selected").html();
            $("#hid " + vsClase + "Texto").val(txt);
            //console.log(txt);
        }
    });
});
