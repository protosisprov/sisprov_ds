//URL
var http = location.protocol;
var slashes = http.concat("//");
var baseUrl = slashes.concat(window.location.hostname);
if (baseUrl.indexOf('.protocolizacion.org.ve') == -1) {
    var pathArray = window.location.pathname.split('/');
    var ruta = '/' + pathArray[1]; // 

    baseUrl = $(location).attr('href').replace($(location).attr('pathname'), ruta);


}

function conMayusculas(field) {
    field.value = field.value.toUpperCase()
}

$(document).ready(function () {
    valor = parseInt(0);
    $('.a').each(function () {
        valor = valor + 1;
    });

    cantcheck = parseInt(0);
    id = parseInt(2);
    SalarioGrupoFamiliar = parseInt(0);
    for (a = 1; a <= valor; a++) {
        par = a % 2;
        if (par != 0) {
            if ($('#opciones_' + a).is(':checked')) {
                SalarioGrupoFamiliar = parseFloat(SalarioGrupoFamiliar) + parseFloat($('#opciones_' + a).val());

            } else {
                SalarioGrupoFamiliar = parseFloat(SalarioGrupoFamiliar) + parseFloat($('#opciones_' + id).val());
            }
            id = id + 2;
        }
    }

    if ($('#opciones').is(':checked')) {
        SalarioGrupoFamiliar = parseFloat(SalarioGrupoFamiliar) + parseFloat($('#opciones').val());
        SalarioGrupoFamiliar = SalarioGrupoFamiliar.toFixed(2);
    } else {
        SalarioGrupoFamiliar = parseFloat(SalarioGrupoFamiliar) + parseFloat($('#opciones_0').val());
        SalarioGrupoFamiliar = SalarioGrupoFamiliar.toFixed(2); //coloca dos decimales al resultado
    }



    $.ajax({
        url: baseUrl + "/CalculoAnalisisCredito/Ajax/TipoInterresAplicable",
        async: true,
        type: 'POST',
        data: 'SalarioFamiliar=' + SalarioGrupoFamiliar,
        dataType: 'json',
        success: function (datos) {
            $('#AnalisisCredito_tasa_interes_id').val(datos);
//            $('#total').val(SalarioGrupoFamiliar);
        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
        }
    })
});
//



/*
 * 
 * verificar calculo
 * 
 *  */
/*
 * FUNCTION QUE RECALCULA LA TAZA DE INTERE4S APLICABLE SEGUN TABLA DEL SUELDO
 */


/*
 * 
 */
function CalcularAnalisis() {
    var fuenteFinanciamineto = $('#Desarrollo_fuente_financiamiento_id').val();
    var programa = $('#Desarrollo_programa_id').val();
    var montoInical = $('#AnalisisCredito_monto_inicial').val();
    var montoVivienda = $('#AnalisisCredito_costo_vivienda').val();
    var ingreso = $('#ingreso').val();
    var idUnidadFamiliar = $('#AnalisisCredito_unidad_familiar_id').val();
//    if ($('#opciones_2').is(':checked')) {
//        var valorSalario = $('#opciones_2').val();
//    } else {
//        var valorSalario = $('#opciones_1').val();
//
//    }
    var valorSalario = $('#total').val();
    
    if ($('#reconocimiento').is(':checked')) {
        var damnificado = '1';
    } else {
        var damnificado = '0';
    }
    if ($('#cuota_extraordinarias').is(':checked')) {
        var cuotasExtras = 'true';
    } else {
        var cuotasExtras = 'false';
    }

    var tasaInteres = $('#AnalisisCredito_tasa_interes_id').val();
    var plazoCredito = $('#AnalisisCredito_plazo_credito_ano').val();
    var fechaProtocolizacion = $('#AnalisisCredito_fecha_protocolizacion').val();


    if (fuenteFinanciamineto == '') {
        bootbox.alert('Indique la Fuente de Financiamiento.');
        return false;
    }
    if (programa == '') {
        bootbox.alert('Indique el Programa.');
        return false;
    }

    if (montoVivienda == '0.00' || montoVivienda == '') {
        bootbox.alert('El monto de la Vivienda debe ser mayor a cero (0).');
        return false;
    }
    if (valorSalario == '0' || valorSalario == '') {
        bootbox.alert('El Total Ingresos debe ser mayor a cero (0).');
        return false;
    }
//    if (montoInical == '0' || montoInical == '') {
//        bootbox.alert('Indique un Monto Inicial.');
//        return false;
//    }
    if (plazoCredito == '') {
        bootbox.alert('Indique el Plazo del Crédito.');
        return false;
    }
    if (fechaProtocolizacion == '') {
        bootbox.alert('Indique la Fecha de la Protocolización.');
        return false;
    }

    $.ajax({
        url: baseUrl + "/CalculoAnalisisCredito/Ajax/CalculoTasaAmortizacion",
        async: true,
        type: 'POST',
        data: 'fuenteFinanciamineto=' + fuenteFinanciamineto + '&programa=' + programa + '&montoInical=' + montoInical + '&montoVivienda=' + montoVivienda + '&idUnidadFamiliar=' + idUnidadFamiliar +
                '&valorSalario=' + valorSalario + '&tasaInteres=' + tasaInteres + '&plazoCredito=' + plazoCredito + '&fechaProtocolizacion=' + fechaProtocolizacion + '&damnificado=' + damnificado + '&cuotasExtras=' + cuotasExtras + '&flat=' + flat,
        dataType: 'json',
        success: function (datos) {
            diferencia = datos.diferenciaPago;
            
            
            
            if (parseFloat(datos.cantidadDisponible) < parseFloat(montoVivienda)) {
                $('#guardar-analisis').hide();
                $('#error1').show();
                $('#sms1').html('Su máxima disponibilidad de pago es: <b>Bs. ' + datos.cantidadDisponible + '</b>' + ', Por lo tanto no cubre el monto de la vivienda.');
            } else {
                $('#sms1').html('Posse capacidad de pago.');
                $('#error1').show();
                $('#guardar-analisis').show();
            }
            if (fuenteFinanciamineto == 3) {
                $('#sumilador_id').fadeIn("slow");
                $('.subsidiocorre').show();
                $('.subsidiomax').show();
                $('.diferenciapago').show();
                $('.montorestante').show();
                $('.reconocimiento').show();
                $('.comision').hide();
                $('#coutafinancieramaxima').val(datos.coutaFinanciamientoMaxima);
                $('#plazomeses').val(datos.plazoMeses);
                $('#capacidadpago').val(datos.capacidadPago);
                $('#subsidiocorrespond').val(datos.subsidioCorreponde);
                $('#subsidiomaximo').val(datos.subsidioMaximo);
                $('#diferenciapago').val(datos.diferenciaPago);
                $('#montorestante').val(datos.restaCostoAsudsidiar);
                $('#reconocimientoviperdida').val(datos.reconocimientoViviendaPerdida);
                $('#creditorequerido').val(datos.creditoRequerido);
                $('#coutainicialfongar').val(datos.coutaInicialFongar);
                $('#coutafinancrequerida').val(datos.montoCoutaFinaciera);
                $('#tasafongar').val(datos.tasaFongar);
                $('#fondogarantia').val(datos.fondoGarantiaMensual);
                $('#cuotatotalmensual').val(datos.coutaMensualPagar);
                $('#maximacoutafinanciera').val(datos.maxCoutaFinan);
                if (cuotasExtras == 'true') {
                    $('#cuotas_extra').show();
                    $('#cuotaExtrasEspecial').val(datos.cuotaExtraEspecial);
                    $('#capacidadPagoExtra').val(datos.capacidadPagoExtra);
                    $('#fondogarantiasemestral').val(datos.fondoGarantiaCExtra);
                    $('#cuotatotalsemestral').val(datos.cuotaTotal);
                    $('.subsidio').hide();
                } else {
                    $('#cuotas_extra').hide();
                }
//                if (datos.h != '') {
//                    $('#error').show();

//                }

            } else if (fuenteFinanciamineto == 2) { // FAOV
                $('#sumilador_id').fadeIn("slow");
//                alert(datos.h);

                $('.montorestante').hide();
                $('.subsidiomax').hide();
                $('.reconocimiento').hide();
                $('.subsidiocorre').hide();
                $('.comision').show();
                $('#coutafinancieramaxima').val(datos.coutaFinanciamientoMaxima);
                $('#plazomeses').val(datos.plazoMeses);
                $('#capacidadpago').val(datos.capacidadPago);
                $('#diferenciapago').val(datos.diferenciaPago);
                $('#creditorequerido').val(datos.creditoRequerido);
                $('#coutainicialfongar').val(datos.coutaInicialFongar);
                $('#coutafinancrequerida').val(datos.montoCoutaFinaciera);
                $('#tasafongar').val(datos.tasaFongar);
                $('#fondogarantia').val(datos.fondoGarantiaMensual);
                $('#cuotatotalmensual').val(datos.coutaMensualPagar);
                $('#maximacoutafinanciera').val(datos.maxCoutaFinan);
                $('#comisionFlat').val(datos.comisionFlat);
                if (cuotasExtras == 'true') {
                    $('#cuotas_extra').show();
                    $('#capacidadPagoExtra').val(datos.capacidadPagoExtra);
                    $('#cuotaExtrasEspecial').val(datos.maxCuotafina);
                    $('#fondogarantiasemestral').val(datos.fondoGarantiaCExtra);
                    $('#cuotatotalsemestral').val(datos.totalSemestral);
                    $('#subsidioDHPvp').val(datos.subsidioDHPvp);
                    $('#subsidioDHRequerido').val(datos.subsidioRequerido);
                    $('#diferenciapagoCE').val(datos.diferenciaPago);
                    $('#montoCoutaFinanExtra').val(datos.montoCoutaFinanExtra);
                    $('.subsidio').show();
                    if (datos.h == '') {
                        $('#error').hide();
                    } else {
                        $('#sms').html(datos.h);
                        $('#error').show();
                    }
                } else {
                    $('#error').hide();
                    $('#sms').html(datos.h);
                    $('#cuotas_extra').hide();

                }
            }
        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
        }
    })
}


function CuotasExtras() {
    if ($('.cuotas').is(":checked")) {
        $('#cuotas_extra').fadeIn("slow");
    } else {
        $('#cuotas_extra').hide();
        $('#hola').hide();
    }
}
function MostrarFlat() {
    if ($('.flat').is(":checked")) {
        $('#flatt').fadeIn("slow");
    } else {
        $('#flatt').hide();
    }
}
        



function   AsignacionAnalista(asignado, caso, checked) {
//alert(checked);return false;
    if (caso == 308) {

        var checked = $('#tempcensovalidadofaovfaspGrid').yiiGridView.getChecked('tempcensovalidadofaovfaspGrid', 'check_analista');
    }
//    else if (caso == 2){
//    var checked = $('#beneficiario-grid').yiiGridView.getChecked('beneficiario-grid', 'check_analista_doc_uni');
//        
//    }
    else if (caso == 309) {
        var checked = $('#unidad-habitacional-grid').yiiGridView.getChecked('unidad-habitacional-grid', 'check_analista_doc_multi');

    }
    var count = checked.length;

//    console.log(asignado);

    if (asignado == '') {
        bootbox.alert("Debe indicar un analista asignado para continuar");
        return false;
    }

    if (asignado == 'SELECCIONE') {
        bootbox.alert("Debe indicar un analista asignado para continuar");
        return false;
    }

    if (count == 0) {
        bootbox.alert('Por favor seleccione los beneficiarios a los que desea asignar');
        return false;
    }
    if (count > 0 && confirm('Ha seleccionado  ' + count + ' beneficiarios.  ¿Está seguro de fijar los beneficiarios indicados al analista?')) {
        $('.loaderr').fadeIn('slow');
        $.ajax({
            url: baseUrl + "/Asignaciones/AsignarAnalista",
            async: true,
            type: 'POST',
            data: 'asignado=' + asignado + '&caso=' + caso + '&checked=' + checked,
            dataType: 'json',
            success: function (data) {
                if (data == 308) {

                    $('#tempcensovalidadofaovfaspGrid').yiiGridView('update', {//Actualización automatica griewView
                        data: $(this).serialize()
                    });

                    bootbox.alert("Beneficiario(s) Asignado(s)");
                    $('.loaderr').fadeOut('slow');
                    return false;

                } else if (data == 309) {

                    $('#unidad-habitacional-grid').yiiGridView('update', {//Actualización automatica griewView
                        data: $(this).serialize()
                    });

                    bootbox.alert("Unidades Multifamiliares Asignada(s)");
                    $('.loaderr').fadeOut('slow');
                    return false;
                }
                else if (data == 3) {

                    bootbox.alert("Beneficiario ya fue asignado a un analista");
                    $('.loaderr').fadeOut('slow');
                    return false;
                }


            },
            error: function (data) {
                bootbox.alert('Ocurrio un error');
                $('.loaderr').fadeOut('slow');
            }
        })
    }
}

function EnviarDocumentacion(id) {

    if (confirm('¿Esta seguro de enviar este caso a Documentación?')) {
              $('.loaderr').fadeOut('slow');
        $.ajax({
            url: baseUrl + "/AnalisisCredito/EnviarDocumentacion",
            type: 'POST',
            data: 'id=' + id,
            async: true,
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    bootbox.alert('Su caso ha sido enviado a Documentacion');
                    return false;
                } else if (data == 3) {
                    alert('Debe realizar un analisis de credito para  enviar a documentacion');
                }
            },
               error: function (data) {
                bootbox.alert('Ocurrio un error');
                $('.loaderr').fadeOut('slow');
            }
        })
        $('#tempcensovalidadofaovfaspGrid').yiiGridView('update', {//ActualizaciÃ³n automatica griewView
            data: $(this).serialize()
        });
        return false;
    }

}
