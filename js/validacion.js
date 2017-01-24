
//URL
var http = location.protocol;
var slashes = http.concat("//");
var baseUrl = slashes.concat(window.location.hostname);
if (baseUrl.indexOf('.protocolizacion.org.ve') == -1) {
    var pathArray = window.location.pathname.split('/');
    var ruta = '/' + pathArray[1]; //
    
      baseUrl = $(location).attr('href').replace($(location).attr('pathname'), ruta);

  // baseUrl = $(location).attr('href').replace($(location).attr('pathname'), ruta) + '/protocolizacion';
}
 


function conMayusculas(field) {
    field.value = field.value.toUpperCase()
}
function Terreno() {
    if ($('.titularidad').is(":checked")) {
        $('.fecha').show('fade');
        $('.col2').show('fade');
        
    } else {
        $('#Desarrollo_fecha_transferencia').val('');
        $('#Desarrollo_ente_titular_terreno_id').val('');
//        $('#matricula').bootstrapSwitch('state', true);
        $('.fecha').hide('fade');
        $('.col1').hide('fade');
        $('.col2').hide('fade');
    }
}
function Matricula() {
    
    if ($('.matri').is(":checked")) {
        $('.col1').show('fade');
        $('.col2').hide('fade');
    } else {
        
        $('.col1').hide('fade');
        $('.col2').show('fade');
        
    }
}
/*
 *
 * FUNCION QUE BUSCA EN SAIME Y EN PERSONA POR NUMERO DE CEDULA Y NACIONALIDAD
 */
function buscarPersonaOficina(nacionalidad, cedula) {
    $('#Oficina_primer_nombre').val('');
    $('#Oficina_persona_id_jefe').val('');
    $('#Oficina_segundo_nombre').val('');
    $('#Oficina_primer_apellido').val('');
    $('#Oficina_segundo_apellido').val('');
    $('#Oficina_fechaNac').val('');
    $('#Oficina_primer_nombre').attr('readonly', true);
    $('#Oficina_segundo_nombre').attr('readonly', true);
    $('#Oficina_primer_apellido').attr('readonly', true);
    $('#Oficina_segundo_apellido').attr('readonly', true);
    $('#iconLoding').show();
    if (nacionalidad == '') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }
    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarEncargadoOficina",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {
            if (datos == 1 || datos == 2) {
                $('#iconLoding').hide();
                $('#Oficina_primer_nombre').val('');
                $('#Oficina_persona_id_jefe').val('');
                $('#Oficina_segundo_nombre').val('');
                $('#Oficina_primer_apellido').val('');
                $('#Oficina_segundo_apellido').val('');
                $('#Oficina_fechaNac').val('');
                if (datos == 1) {
                    $('#Oficina_cedula').val('');
                    $('#Oficina_nacionalidad').val('');
                    bootbox.alert('Esta persona ya se encuentra asignada a una Oficina.');
                    return false;
                } else if (datos == 2) {
                    $('#iconLoding').hide();
                    $('#Oficina_persona_id_jefe').val('');
                    $('#Oficina_primer_nombre').attr('readonly', false);
                    $('#Oficina_segundo_nombre').attr('readonly', false);
                    $('#Oficina_primer_apellido').attr('readonly', false);
                    $('#Oficina_segundo_apellido').attr('readonly', false);
                }
            } else {
                $('#Oficina_primer_nombre').val(datos.PRIMERNOMBRE);
                $('#Oficina_persona_id_jefe').val(datos.ID);
                $('#Oficina_segundo_nombre').val(datos.SEGUNDONOMBRE);
                $('#Oficina_primer_apellido').val(datos.PRIMERAPELLIDO);
                $('#Oficina_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
                $('#Oficina_fechaNac').val(datos.FECHANACIMIENTO);
                $('#iconLoding').hide();
            }
        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
            $('#Vivienda_construccion_mt2').numeric();
        }
    })
}

/*
 * FUNCION PARA BUSCAR EN PERSONA Y EN SAIME EL BENEFICIARIO ACTUAL
 * PARA REASIGNACION DE VIVIENDA
 */
function buscarBenefAnterior(nacionalidad, cedula) {

    $('#ReasignacionVivienda_segundo_nombreActual').val('');
    $('#ReasignacionVivienda_primer_apellidoActual').val('')
    $('#ReasignacionVivienda_segundo_apellidoActual').val('');
    $('#ReasignacionVivienda_fecha_nacimientoActual').val('');
    $('#ReasignacionVivienda_sexoActual').val('');
    $('#ReasignacionVivienda_estado_civilActual').val('');
    $('#ReasignacionVivienda_telf_habitacionActual').val('');
    $('#ReasignacionVivienda_telf_celularActual').val('');
    $('#ReasignacionVivienda_correo_electronicoActual').val('');
    $('#iconLoding').show();
    if (nacionalidad == '') {
        bootbox.alert('Verifique que la nacionalidad no esté vacio');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esté vacio');
        return false;
    }
    $.ajax({
        url: baseUrl + "/ValidacionJs/buscarBeneficiarioAnterior",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {
            if (datos == 2) {
                //  No Existe en Saime habilito todos los campos para que se llenen a pedal
                /*  ------  Bloqueo campos    ------- */
                $('#iconLoding').hide();
                $('#ReasignacionVivienda_primer_nombreActual').attr('readonly', false);
                $('#ReasignacionVivienda_primer_nombreActual').val('');

                $('#ReasignacionVivienda_segundo_nombreActual').attr('readonly', false);
                $('#ReasignacionVivienda_segundo_nombreActual').val('');

                $('#ReasignacionVivienda_primer_apellidoActual').attr('readonly', false);
                $('#ReasignacionVivienda_primer_apellidoActual').val('');

                $('#ReasignacionVivienda_segundo_apellidoActual').attr('readonly', false);
                $('#ReasignacionVivienda_segundo_apellidoActual').val('');

                $('#ReasignacionVivienda_fecha_nacimientoActual').attr('readonly', false);
                $('#ReasignacionVivienda_fecha_nacimientoActual').val('');

                $('#ReasignacionVivienda_sexoActual').attr('disabled', false);
                $('#ReasignacionVivienda_sexoActual').val('');

                $('#ReasignacionVivienda_estado_civilActual').attr('readonly', false);
                $('#ReasignacionVivienda_estado_civilActual').val('');

                $('#ReasignacionVivienda_telf_habitacionActual').attr('readonly', false);
                $('#ReasignacionVivienda_telf_habitacionActual').val('');

                $('#ReasignacionVivienda_telf_celularActual').attr('readonly', false);
                $('#ReasignacionVivienda_telf_celularActual').val('');

                $('#ReasignacionVivienda_correo_electronicoActual').attr('readonly', false);
                $('#ReasignacionVivienda_correo_electronicoActual').val('');

                /*   -------------------------------- */

            } else if (datos == 3) {
                $('#iconLoding').hide();
                $('#ReasignacionVivienda_nacionalidad').val('');
                $('#ReasignacionVivienda_cedula').val('');
                $('#ReasignacionVivienda_primer_nombreActual').val('');
                $('#ReasignacionVivienda_segundo_nombreActual').val('');
                $('#ReasignacionVivienda_primer_apellidoActual').val('')
                $('#ReasignacionVivienda_segundo_apellidoActual').val('');
                $('#ReasignacionVivienda_fecha_nacimientoActual').val('');
                $('#ReasignacionVivienda_sexoActual').val('');
                $('#ReasignacionVivienda_estado_civilActual').val('');
                $('#ReasignacionVivienda_telf_habitacionActual').val('');
                $('#ReasignacionVivienda_telf_celularActual').val('');
                $('#ReasignacionVivienda_correo_electronicoActual').val('');
                bootbox.alert('Beneficiario Se encuentra Asignado a una vivienda !');
                return false;

            } else if (datos.PROCEDENCIA == 2) {
                if (datos.PRIMERNOMBRE == null) {
                    $('#ReasignacionVivienda_primer_nombreActual').attr('readonly', false);
                    $('#ReasignacionVivienda_primer_nombreActual').val('');

                } else {
                    $('#ReasignacionVivienda_primer_nombreActual').val(datos.PRIMERNOMBRE);
                    $('#ReasignacionVivienda_primer_nombreActual').attr('readonly', true);
                }

                if (datos.SEGUNDONOMBRE == null) {
                    $('#ReasignacionVivienda_segundo_nombreActual').attr('readonly', false);
                    $('#ReasignacionVivienda_segundo_nombreActual').val('');


                } else {
                    $('#ReasignacionVivienda_segundo_nombreActual').val(datos.SEGUNDONOMBRE);
                    $('#ReasignacionVivienda_segundo_nombreActual').attr('readonly', true);
                }

                if (datos.PRIMERAPELLIDO == null) {
                    $('#ReasignacionVivienda_primer_apellidoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_primer_apellidoActual').val('');
                } else {
                    $('#ReasignacionVivienda_primer_apellidoActual').val(datos.PRIMERAPELLIDO);
                    $('#ReasignacionVivienda_primer_apellidoActual').attr('readonly', true);
                }

                if (datos.SEGUNDOAPELLIDO == null) {
                    $('#ReasignacionVivienda_segundo_apellidoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_segundo_apellidoActual').val('');
                } else {
                    $('#ReasignacionVivienda_segundo_apellidoActual').val(datos.SEGUNDOAPELLIDO);
                    $('#ReasignacionVivienda_segundo_apellidoActual').attr('readonly', true);
                }

                if (datos.FECHANACIMIENTO == null) {
                    $('#ReasignacionVivienda_fecha_nacimientoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_fecha_nacimientoActual').val('');
                } else {
                    $('#ReasignacionVivienda_fecha_nacimientoActual').val(datos.FECHANACIMIENTO);
                    $('#ReasignacionVivienda_fecha_nacimientoActual').attr('readonly', true);
                }

                //  habilito los campos que se llenan en persona
                $('#ReasignacionVivienda_sexoActual').attr('readonly', false);
                $('#ReasignacionVivienda_sexoActual').attr('disabled', false);

                $('#ReasignacionVivienda_estado_civilActual').attr('disabled', false);
                $('#ReasignacionVivienda_estado_civilActual').attr('readonly', false);
                $('#ReasignacionVivienda_estado_civilActual').val('');

                $('#ReasignacionVivienda_telf_habitacionActual').attr('readonly', false);
                $('#ReasignacionVivienda_telf_habitacionActual').val('');

                $('#ReasignacionVivienda_telf_celularActual').attr('readonly', false);
                $('#ReasignacionVivienda_telf_celularActual').val('');

                $('#ReasignacionVivienda_correo_electronicoActual').attr('readonly', false);
                $('#ReasignacionVivienda_correo_electronicoActual').val('');
                $('#iconLoding').hide();

            } else if (datos.PROCEDENCIA == 1) {
                // Datos de la variable proceden de Persona si algun campo esta en blanco de puede actualizar solo una vez
                $('#ReasignacionVivienda_primer_nombreActual').val(datos.PRIMERNOMBRE);
                $('#ReasignacionVivienda_segundo_nombreActual').val(datos.SEGUNDONOMBRE);
                $('#ReasignacionVivienda_primer_apellidoActual').val(datos.PRIMERAPELLIDO);
                $('#ReasignacionVivienda_segundo_apellidoActual').val(datos.SEGUNDOAPELLIDO);
                $('#ReasignacionVivienda_persona_id').val(datos.ID);

                if (datos.FECHANACIMIENTO == null) {
                    $('#ReasignacionVivienda_fecha_nacimientoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_fecha_nacimientoActual').val('');
                } else {
                    $('#ReasignacionVivienda_fecha_nacimientoActual').val(datos.FECHANACIMIENTO);
                    $('#ReasignacionVivienda_fecha_nacimientoActual').attr('readonly', true);
                }


                if (datos.SEXO == null) {
                    $('#ReasignacionVivienda_sexoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_sexoActual').attr('disabled', false);
                    $('#ReasignacionVivienda_sexoActual').val('');
                } else {
                    if (datos.SEXO == 'Femenino') {
                        $('#ReasignacionVivienda_sexoActual').val(1);
                    } else {
                        $('#ReasignacionVivienda_sexoActual').val(2);
                    }
                    $('#ReasignacionVivienda_sexoActual').attr('disabled', false);
                    $('#ReasignacionVivienda_sexoActual').attr('readonly', false);
                }

                if (datos.EDO_CIVIL == null) {
                    $('#ReasignacionVivienda_estado_civilActual').attr('readonly', false);
                    $('#ReasignacionVivienda_estado_civilActual').val('');
                    $('#ReasignacionVivienda_estado_civilActual').attr('disabled', false);
                } else {
                    $('#ReasignacionVivienda_estado_civilActual').val(datos.EDO_CIVIL);
                    $('#ReasignacionVivienda_estado_civilActual').attr('readonly', true);
                }

                if (datos.CODIGO_HAB == null) {
                    $('#ReasignacionVivienda_telf_habitacionActual').attr('readonly', false);
                    $('#ReasignacionVivienda_telf_habitacionActual').val('');
                } else {
                    $('#ReasignacionVivienda_telf_habitacionActual').val(datos.CODIGO_HAB + datos.TELEFONOHAB);
                    $('#ReasignacionVivienda_telf_habitacionActual').attr('readonly', false);
                }

                if (datos.CODIGO_HAB == null) {
                    $('#ReasignacionVivienda_telf_celularActual').attr('readonly', false);
                    $('#ReasignacionVivienda_telf_celularActual').val('');
                } else {
                    $('#ReasignacionVivienda_telf_celularActual').val(datos.CODIGO_HAB + datos.TELEFONOMOVIL);
                    $('#ReasignacionVivienda_telf_celularActual').attr('readonly', false);
                }



                if (datos.CORREO_PRINCIPAL == null) {
                    $('#ReasignacionVivienda_correo_electronicoActual').attr('readonly', false);
                    $('#ReasignacionVivienda_correo_electronicoActual').val('');
                } else {
                    $('#ReasignacionVivienda_correo_electronicoActual').val(datos.CORREO_PRINCIPAL);
                    $('#ReasignacionVivienda_correo_electronicoActual').attr('readonly', false);
                }
                $('#iconLoding').hide();

            } // fin If principal


        },
        error: function (datos) {
            bootbox.alert('CEDULA NO ES VALIDA VERIFIQUE');
        }

    });
}

function buscarPersonaAbogado(nacionalidad, cedula) {
    $('#Abogados_persona_id').val('');
    $('#Abogados_primer_nombre').val('');
    $('#Abogados_segundo_nombre').val('')
    $('#Abogados_primer_apellido').val('');
    $('#Abogados_segundo_apellido').val('');
    $('#Abogados_fecha_nac').val('');
    $('#Abogados_primer_nombre').attr('readonly', true);
    $('#Abogados_segundo_nombre').attr('readonly', true);
    $('#Abogados_primer_apellido').attr('readonly', true);
    $('#Abogados_segundo_apellido').attr('readonly', true);

    $('#iconLoding').show();

    if (nacionalidad == 'SELECCIONE') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }
    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonaAbogado",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {

            if (datos == 1) {
                $('#iconLoding').hide();
                $('#Abogados_persona_id').val('');
                $('#Abogados_primer_nombre').val('');
                $('#Abogados_segundo_nombre').val('');
                $('#Abogados_primer_apellido').val('');
                $('#Abogados_segundo_apellido').val('');
                $('#Abogados_fecha_nac').val('');
                bootbox.alert('La Persona ya se encuentra registrada como Abogado.');
            } else if (datos == 2) {
                $('#iconLoding').hide();
                $('#Abogados_persona_id').val('');
                $('#Abogados_primer_nombre').attr('readonly', false);
                $('#Abogados_segundo_nombre').attr('readonly', false);
                $('#Abogados_primer_apellido').attr('readonly', false);
                $('#Abogados_segundo_apellido').attr('readonly', false);
                $('#Abogados_fecha_nac').val('');
                bootbox.alert('La Persona no se encuentra registrada en el Saime.');
            } else {
                $('#Abogados_persona_id').val(datos.ID);
                $('#Abogados_primer_nombre').val(datos.PRIMERNOMBRE);
                $('#Abogados_segundo_nombre').val(datos.SEGUNDONOMBRE);
                $('#Abogados_primer_apellido').val(datos.PRIMERAPELLIDO);
                $('#Abogados_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
                $('#Abogados_fecha_nac').val(datos.FECHANACIMIENTO);
                $('#iconLoding').hide();
            }

        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
        }
    })
}



/* --------------------------------------------- */


function buscarPersonaBeneficiarioTemp(nacionalidad, cedula) {
    $('#BeneficiarioTemporal_primer_apellido').attr('readonly', true);
    $('#BeneficiarioTemporal_primer_apellido').val('');
    $('#BeneficiarioTemporal_segundo_apellido').attr('readonly', true);
    $('#BeneficiarioTemporal_segundo_apellido').val('');

    $('#BeneficiarioTemporal_primer_nombre').attr('readonly', true);
    $('#BeneficiarioTemporal_primer_nombre').val('');

    $('#BeneficiarioTemporal_segundo_nombre').attr('readonly', true);
    $('#BeneficiarioTemporal_segundo_nombre').val('');

    $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', true);
    $('#BeneficiarioTemporal_fecha_nacimiento').val('');

    $('#BeneficiarioTemporal_sexo').attr('disabled', true);
    $('#BeneficiarioTemporal_sexo').val('');

    $('#BeneficiarioTemporal_estado_civil').attr('readonly', true);
    $('#BeneficiarioTemporal_estado_civil').val('');

    $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', true);
    $('#BeneficiarioTemporal_telf_habitacion').val('');

    $('#BeneficiarioTemporal_telf_celular').attr('readonly', true);
    $('#BeneficiarioTemporal_telf_celular').val('');

    $('#BeneficiarioTemporal_correo_electronico').attr('readonly', true);
    $('#BeneficiarioTemporal_correo_electronico').val('');


    $('#iconLoding').show();
    if (nacionalidad == 'SELECCIONE') {
        $('#iconLoding').hide();
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        $('#iconLoding').hide();
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }


    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonasBeneficiarioTemp",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {


            if (datos == 2) {
                //  No Existe en Saime habilito todos los campos para que se llenen a pedal

                /*  ------  Bloqueo campos    ------- */
                $('#iconLoding').hide();
                $('#BeneficiarioTemporal_primer_apellido').attr('readonly', false);
                $('#BeneficiarioTemporal_primer_apellido').val('');

                $('#BeneficiarioTemporal_segundo_apellido').attr('readonly', false);
                $('#BeneficiarioTemporal_segundo_apellido').val('');

                $('#BeneficiarioTemporal_primer_nombre').attr('readonly', false);
                $('#BeneficiarioTemporal_primer_nombre').val('');

                $('#BeneficiarioTemporal_segundo_nombre').attr('readonly', false);
                $('#BeneficiarioTemporal_segundo_nombre').val('');

                $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', false);
                $('#BeneficiarioTemporal_fecha_nacimiento').val('');

                $('#BeneficiarioTemporal_sexo').attr('readonly', false);
                $('#BeneficiarioTemporal_sexo').attr('disabled', false);
                $('#BeneficiarioTemporal_sexo').val('');

                $('#BeneficiarioTemporal_estado_civil').attr('readonly', false);
                $('#BeneficiarioTemporal_estado_civil').attr('disabled', false);
                $('#BeneficiarioTemporal_estado_civil').val('');

                $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', false);
                $('#BeneficiarioTemporal_telf_habitacion').val('');

                $('#BeneficiarioTemporal_telf_celular').attr('readonly', false);
                $('#BeneficiarioTemporal_telf_celular').val('');

                $('#BeneficiarioTemporal_correo_electronico').attr('readonly', false);
                $('#BeneficiarioTemporal_correo_electronico').val('');

                /*   -------------------------------- */

            } else if (datos == 3) {
                $('#iconLoding').hide();
                bootbox.alert('Beneficiario Se encuentra Registrado !');
                // $('#BeneficiarioTemporal_cedula').val('');
                return false;

            } else if (datos.PROCEDENCIA == 2) {
                //  Datos de la variable proceden de Saime
                // alert('entrooo');
                $('#iconLoding').hide();
                if (datos.PRIMERNOMBRE == null) {
                    $('#BeneficiarioTemporal_primer_nombre').attr('readonly', false);
                    $('#BeneficiarioTemporal_primer_nombre').val('');
                } else {
                    $('#BeneficiarioTemporal_primer_nombre').val(datos.PRIMERNOMBRE);
                    $('#BeneficiarioTemporal_primer_nombre').attr('readonly', true);
                }

                if (datos.SEGUNDONOMBRE == null) {
                    $('#BeneficiarioTemporal_segundo_nombre').attr('readonly', false);
                    $('#BeneficiarioTemporal_segundo_nombre').val('');
                } else {
                    $('#BeneficiarioTemporal_segundo_nombre').val(datos.SEGUNDONOMBRE);
                    $('#BeneficiarioTemporal_segundo_nombre').attr('readonly', true);
                }

                if (datos.PRIMERAPELLIDO == null) {
                    $('#BeneficiarioTemporal_primer_apellido').attr('readonly', false);
                    $('#BeneficiarioTemporal_primer_apellido').val('');
                } else {
                    $('#BeneficiarioTemporal_primer_apellido').val(datos.PRIMERAPELLIDO);
                    $('#BeneficiarioTemporal_primer_apellido').attr('readonly', true);
                }

                if (datos.SEGUNDOAPELLIDO == null) {
                    $('#BeneficiarioTemporal_segundo_apellido').attr('readonly', false);
                    $('#BeneficiarioTemporal_segundo_apellido').val('');
                } else {
                    $('#BeneficiarioTemporal_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
                    $('#BeneficiarioTemporal_segundo_apellido').attr('readonly', true);
                }

                if (datos.FECHANACIMIENTO == null) {
                    $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', false);
                    $('#BeneficiarioTemporal_fecha_nacimiento').val('');
                } else {
                    $('#BeneficiarioTemporal_fecha_nacimiento').val(datos.FECHANACIMIENTO);
                    $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', true);
                }

                //  habilito los campos que se llenan en persona
                $('#BeneficiarioTemporal_sexo').attr('readonly', false);
                $('#BeneficiarioTemporal_sexo').attr('disabled', false);

                $('#BeneficiarioTemporal_estado_civil').attr('disabled', false);
                $('#BeneficiarioTemporal_estado_civil').attr('readonly', false);
                $('#BeneficiarioTemporal_estado_civil').val('');

                $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', false);
                $('#BeneficiarioTemporal_telf_habitacion').val('');

                $('#BeneficiarioTemporal_telf_celular').attr('readonly', false);
                $('#BeneficiarioTemporal_telf_celular').val('');

                $('#BeneficiarioTemporal_correo_electronico').attr('readonly', false);
                $('#BeneficiarioTemporal_correo_electronico').val('');

            } else if (datos.PROCEDENCIA == 1) {
                // Datos de la variable proceden de Persona si algun campo esta en blanco de puede actualizar solo una vez
                $('#iconLoding').hide();
                $('#BeneficiarioTemporal_primer_nombre').val(datos.PRIMERNOMBRE);
                $('#BeneficiarioTemporal_segundo_nombre').val(datos.SEGUNDONOMBRE);
                $('#BeneficiarioTemporal_primer_apellido').val(datos.PRIMERAPELLIDO);
                $('#BeneficiarioTemporal_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
                $('#BeneficiarioTemporal_persona_id').val(datos.ID);
                if (datos.FECHANACIMIENTO == null) {
                    $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', false);
                    $('#BeneficiarioTemporal_fecha_nacimiento').val('');
                } else {
                    $('#BeneficiarioTemporal_fecha_nacimiento').val(datos.FECHANACIMIENTO);
                    $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', true);
                }
                if (datos.SEXO == null) {
                    $('#BeneficiarioTemporal_sexo').attr('readonly', false);
                    $('#BeneficiarioTemporal_sexo').attr('disabled', false);
                    $('#BeneficiarioTemporal_sexo').val('');
                } else {
                    if (datos.SEXO == 'Femenino') {
                        $('#BeneficiarioTemporal_sexo').val(1);
                    } else {
                        $('#BeneficiarioTemporal_sexo').val(2);
                    }
                    $('#BeneficiarioTemporal_sexo').attr('disabled', false);
                    $('#BeneficiarioTemporal_sexo').attr('readonly', false);
                }
                if (datos.EDO_CIVIL == null) {
                    $('#BeneficiarioTemporal_estado_civil').attr('readonly', false);
                    $('#BeneficiarioTemporal_estado_civil').val('');
                    $('#BeneficiarioTemporal_estado_civil').attr('disabled', false);
                } else {
                    $('#BeneficiarioTemporal_estado_civil').val(datos.EDO_CIVIL);
                    $('#BeneficiarioTemporal_estado_civil').attr('readonly', true);
                }
                if (datos.CODIGO_HAB == null) {
                    $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', false);
                    $('#BeneficiarioTemporal_telf_habitacion').val('');
                } else {
                    $('#BeneficiarioTemporal_telf_habitacion').val(datos.CODIGO_HAB + datos.TELEFONOHAB);
                    $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', true);
                }
                if (datos.CODIGO_HAB == null) {
                    $('#BeneficiarioTemporal_telf_celular').attr('readonly', false);
                    $('#BeneficiarioTemporal_telf_celular').val('');
                } else {
                    $('#BeneficiarioTemporal_telf_celular').val(datos.CODIGO_HAB + datos.TELEFONOMOVIL);
                    $('#BeneficiarioTemporal_telf_celular').attr('readonly', true);
                }
                if (datos.CORREO_PRINCIPAL == null) {
                    $('#BeneficiarioTemporal_correo_electronico').attr('readonly', false);
                    $('#BeneficiarioTemporal_correo_electronico').val('');
                } else {
                    $('#BeneficiarioTemporal_correo_electronico').val(datos.CORREO_PRINCIPAL);
                    $('#BeneficiarioTemporal_correo_electronico').attr('readonly', true);
                }
            } // fin If principal
        },
        error: function (datos) {
            $('#iconLoding').hide();
            bootbox.alert('CEDULA NO ES VALIDA VERIFIQUE');
        }
    })


}

/*  +++++++++++++++++++++++++++++++++++++++++++++ */


/* -------------------Para Update  ---------------- */


function buscarPersonaBeneficiarioTemp2(nacionalidad, cedula) {

    if (nacionalidad == 'SELECCIONE') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }


    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonasBeneficiario",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {

            // alert(datos);
            $('#BeneficiarioTemporal_cedula').attr('readonly', true);
            $('#BeneficiarioTemporal_nacionalidad').attr('disabled', true);

            $('#BeneficiarioTemporal_primer_nombre').val(datos.persona.PRIMERNOMBRE);
            $('#BeneficiarioTemporal_primer_nombre').attr('readonly', false);


            $('#BeneficiarioTemporal_segundo_nombre').val(datos.persona.SEGUNDONOMBRE);
            $('#BeneficiarioTemporal_segundo_nombre').attr('readonly', false);


            $('#BeneficiarioTemporal_primer_apellido').val(datos.persona.PRIMERAPELLIDO);
            $('#BeneficiarioTemporal_primer_apellido').attr('readonly', false);


            $('#BeneficiarioTemporal_segundo_apellido').val(datos.persona.SEGUNDOAPELLIDO);
            $('#BeneficiarioTemporal_segundo_apellido').attr('readonly', false);


            $('#BeneficiarioTemporal_fecha_nacimiento').val(datos.persona.FECHANACIMIENTO);
            $('#BeneficiarioTemporal_fecha_nacimiento').attr('readonly', false);


            //  habilito los campos que se llenan en persona
            if (datos.SEXO == null) {
                $('#BeneficiarioTemporal_sexo').attr('readonly', false);
                $('#BeneficiarioTemporal_sexo').attr('disabled', false);
                $('#BeneficiarioTemporal_sexo').val('');
            } else {
                if (datos.SEXO == 'Femenino') {
                    $('#BeneficiarioTemporal_sexo').val(1);
                } else {
                    $('#BeneficiarioTemporal_sexo').val(2);
                }
                $('#BeneficiarioTemporal_sexo').attr('disabled', false);
                $('#BeneficiarioTemporal_sexo').attr('readonly', false);
            }

            $('#BeneficiarioTemporal_estado_civil').attr('disabled', false);
            $('#BeneficiarioTemporal_estado_civil').attr('readonly', false);
            $('#BeneficiarioTemporal_estado_civil').val('');

            $('#BeneficiarioTemporal_telf_habitacion').attr('readonly', false);
            $('#BeneficiarioTemporal_telf_habitacion').val(datos.persona.TELEFONOHAB);

            $('#BeneficiarioTemporal_telf_celular').attr('readonly', false);
            $('#BeneficiarioTemporal_telf_celular').val(datos.persona.TELEFONOMOVIL);

            $('#BeneficiarioTemporal_correo_electronico').attr('readonly', false);
            $('#BeneficiarioTemporal_correo_electronico').val(datos.persona.CORREO);


            /*  ------------------ */

            /*   $('#Beneficiario_estado').val(datos.desarrollo.estado);
             $('#Beneficiario_municipio').val(datos.desarrollo.municipio);
             $('#Beneficiario_parroquia').val(datos.desarrollo.parroquia_id);
             $('#Beneficiario_nombre_desarrollo').val(datos.desarrollo.nombre);*/
//            $('#Desarrollo_urban_barrio').val(datos.desarrollo.urban_barrio);
//            $('#Desarrollo_av_call_esq_carr').val(datos.desarrollo.av_call_esq_carr);
//            $('#Desarrollo_zona').val(datos.desarrollo.zona);
            /*$('#Desarrollo_lote_terreno_mt2').val(datos.desarrollo.lote_terreno_mt2);
             $('#Beneficiario_nomb_edif').val(datos.desarrollo.nomb_edif);
             $('#Beneficiario_piso').val(datos.desarrollo.nro_piso);
             $('#Beneficiario_numero_vivienda').val(datos.desarrollo.nro_vivienda);
             $('#Beneficiario_tipo_vivienda').val(datos.desarrollo.tipo_vivienda_id);
             $('#Beneficiario_beneficiario_temporal_id').val(datos.desarrollo.Temp); */

            /*  ----------------- */


//            }
        },
        error: function (datos) {
            bootbox.alert('CEDULA NO ES VALIDA VERIFIQUE');
        }
    })


}

/*  +++++++++++++++++++++++++++++++++++++++++++++ */

/*  /////////////////  PARA CENSO ////////////////////// */
function buscarBeneficiarioTemporal(nacionalidad, cedula) {

    if (nacionalidad == '') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }

    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }

    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonasBeneficiario",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {
            /* ++++   solo verifico en Persona  ++++  */
//alert(datos.persona.CODIGO_MOVIL);
            if (datos != 2) {
                //datos de beneficiario temporal
                $('#Beneficiario_primer_nombre').val(datos.persona.PRIMERNOMBRE);
                $('#Beneficiario_segundo_nombre').val(datos.persona.SEGUNDONOMBRE);
                $('#Beneficiario_primer_apellido').val(datos.persona.PRIMERAPELLIDO);
                $('#Beneficiario_segundo_apellido').val(datos.persona.SEGUNDOAPELLIDO);
                $('#Beneficiario_fecha_nacimiento').val(datos.persona.FECHANACIMIENTO);
//                $('#Beneficiario_sexo').val(datos.persona.SEXO);
//                $('#Beneficiario_estado_civil').val(datos.persona.EDOCIVIL);

                if (datos.persona.EDOCIVIL == null) {
                    $('#Beneficiario_sexo').attr('readonly', false);
                    $('#Beneficiario_sexo').attr('disabled', false);
                    $('#Beneficiario_sexo').val('');
                } else {
                    if (datos.persona.EDOCIVIL == 'Soltero(a)') {
                        $('#Beneficiario_estado_civil').val(163);

                    } else if (datos.persona.EDOCIVIL == 'Casado(a)') {
                        $('#Beneficiario_estado_civil').val(164);

                    } else if (datos.persona.EDOCIVIL == 'Divorciado(a)') {
                        $('#Beneficiario_estado_civil').val(165);

                    } else if (datos.persona.EDOCIVIL == 'Viudo(a)') {
                        $('#Beneficiario_estado_civil').val(166);
                    }
                    $('#Beneficiario_estado_civil').attr('disabled', false);
                    $('#Beneficiario_estado_civil').attr('readonly', false);
                }


                if (datos.persona.SEXO == null) {
                    $('#Beneficiario_sexo').attr('readonly', false);
                    $('#Beneficiario_sexo').attr('disabled', false);
                    $('#Beneficiario_sexo').val('');
                } else {
                    if (datos.persona.SEXO == 'Femenino') {
                        $('#Beneficiario_sexo').val(1);
                    } else {
                        $('#Beneficiario_sexo').val(2);
                    }
                    $('#Beneficiario_sexo').attr('disabled', false);
                    $('#Beneficiario_sexo').attr('readonly', false);
                }


                if (datos.persona.CODIGO_MOVIL == null) {
                    $('#Beneficiario_telf_celular').val('');
                } else {
                    $('#Beneficiario_telf_celular').val(datos.persona.CODIGO_MOVIL + datos.persona.TELEFONOMOVIL);
                }
                if (datos.persona.CODIGO_HAB == null) {
                    $('#Beneficiario_telf_habitacion').val('');
                } else {
                    $('#Beneficiario_telf_habitacion').val(datos.persona.CODIGO_HAB + datos.persona.TELEFONOHAB);
                }
                $('#Beneficiario_correo_electronico').val(datos.persona.CORREO);
                //datos de desarrollo
                $('#Beneficiario_estado').val(datos.desarrollo.estado);
                $('#Beneficiario_municipio').val(datos.desarrollo.municipio);
                $('#Beneficiario_parroquia').val(datos.desarrollo.parroquia_id);
                $('#Beneficiario_nombre_desarrollo').val(datos.desarrollo.nombre);
                $('#Desarrollo_urban_barrio').val(datos.desarrollo.urban_barrio);
                $('#Desarrollo_av_call_esq_carr').val(datos.desarrollo.av_call_esq_carr);
                $('#Desarrollo_zona').val(datos.desarrollo.zona);
                $('#Desarrollo_lote_terreno_mt2').val(datos.desarrollo.lote_terreno_mt2);
                $('#Beneficiario_nomb_edif').val(datos.desarrollo.nomb_edif);
                $('#Beneficiario_piso').val(datos.desarrollo.nro_piso);
                $('#Beneficiario_numero_vivienda').val(datos.desarrollo.nro_vivienda);
                $('#Beneficiario_tipo_vivienda').val(datos.desarrollo.tipo_vivienda_id);
                $('#Beneficiario_beneficiario_temporal_id').val(datos.desarrollo.Temp);
                $('#Vivienda_construccion_mt2').val(datos.desarrollo.construccion_mt2);

            } else {

                bootbox.alert('Disculpe.Esta persona no se encuentra Adjudicada a una vivienda');

            }
        }

    });


}

/* ////////////////////////////////////////////// */


//function buscarPersonaBeneficiario(nacionalidad, cedula) {
//
//    if (nacionalidad == 'SELECCIONE') {
//        bootbox.alert('Verifique que la nacionalidad no esten vacios');
//        return false;
//    }
//    if (cedula == '') {
//        bootbox.alert('Verifique que la cédula no esten vacios');
//        return false;
//    }
//
//
//    $.ajax({
//        url: baseUrl + "/ValidacionJs/BuscarPersonasBeneficiario",
//        async: true,
//        type: 'POST',
//        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
//        dataType: 'json',
//        success: function (datos) {
//
//            //  alert(datos);
//
////            if (datos == 1) {
////                bootbox.alert('Debe Completar el campo Cédula');
////            } else {
////
//
//            $('#Beneficiario_primer_nombre').val(datos.PRIMERNOMBRE);
//            $('#Beneficiario_segundo_nombre').val(datos.SEGUNDONOMBRE);
//            $('#Beneficiario_primer_apellido').val(datos.PRIMERAPELLIDO);
//            $('#Beneficiario_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
//            $('#Beneficiario_fecha_nacimiento').val(datos.FECHANACIMIENTO);
//
//            if (datos.SEXO == null) {
//                $('#Beneficiario_sexo').attr('readonly', false);
//            } else {
//                $('#Beneficiario_sexo').val(datos.SEXO);
//                $('#Beneficiario_sexo').attr('readonly', true);
//            }
//
//            if (datos.EDO_CIVIL == null) {
//                $('#Beneficiario_estado_civil').attr('readonly', false);
//            } else {
//                $('#Beneficiario_estado_civil').val(datos.EDO_CIVIL);
//                $('#Beneficiario_estado_civil').attr('readonly', true);
//            }
//
//            if (datos.TELEFONO_HAB == null) {
//                $('#Beneficiario_telf_habitacion').attr('readonly', false);
//            } else {
//                $('#Beneficiario_telf_habitacion').val(datos.TELEFONO_HAB);
//                $('#Beneficiario_telf_habitacion').attr('readonly', true);
//            }
//            if (datos.TELEFONO_MOVIL == null) {
//                $('#Beneficiario_telf_celular').attr('readonly', false);
//            } else {
//                $('#Beneficiario_telf_celular').val(datos.TELEFONO_MOVIL);
//                $('#Beneficiario_telf_celular').attr('readonly', true);
//            }
//
//            if (datos.CORREO == null) {
//                $('#Beneficiario_correo_electronico').attr('readonly', false);
//            } else {
//                $('#Beneficiario_correo_electronico').val(datos.CORREO_PRINCIPAL);
//                $('#Beneficiario_correo_electronico').attr('readonly', true);
//            }
//
//
//
////            }
//        },
//        error: function (datos) {
//            bootbox.alert('CEDULA NO ES VALIDA VERIFIQUE');
//        }
//    })
//
//
//}




/*  -------------------------------------------- */


function buscarPersonaAsignacionCenso(nacionalidad, cedula, id_desarrollo) {
//    alert(id_desarrollo);
//    return false;
    $('#iconLoding').show();
    $('#AsignacionCenso_persona_id').val('');
    $('#AsignacionCenso_primer_nombre').val('');
    $('#AsignacionCenso_segundo_nombre').val('');
    $('#AsignacionCenso_primer_apellido').val('');
    $('#AsignacionCenso_segundo_apellido').val('');
    $('#AsignacionCenso_fecha_nac').val('');
    $('#AsignacionCenso_primer_nombre').attr('readonly', true);
    $('#AsignacionCenso_segundo_nombre').attr('readonly', true);
    $('#AsignacionCenso_primer_apellido').attr('readonly', true);
    $('#AsignacionCenso_segundo_apellido').attr('readonly', true);

    if (nacionalidad == 'SELECCIONE') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }
    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonaAsignacionCenso",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula + '&id_desarrollo=' + id_desarrollo,
        dataType: 'json',
        success: function (datos) {


            if (datos == 1) {
                $('#iconLoding').hide();
                $('#AsignacionCenso_persona_id').val('');
                $('#AsignacionCenso_primer_nombre').val('');
                $('#AsignacionCenso_segundo_nombre').val('');
                $('#AsignacionCenso_primer_apellido').val('');
                $('#AsignacionCenso_segundo_apellido').val('');
                $('#AsignacionCenso_fecha_nac').val('');
                bootbox.alert('Disculpe, esta Persona ya fue Asignada aun censo dentro del desarrollo seleccionado.');
            } else
            if (datos == 2) {
                $('#iconLoding').hide();
                $('#AsignacionCenso_persona_id').val('');
                $('#AsignacionCenso_primer_nombre').attr('readonly', false);
                $('#AsignacionCenso_segundo_nombre').attr('readonly', false);
                $('#AsignacionCenso_primer_apellido').attr('readonly', false);
                $('#AsignacionCenso_segundo_apellido').attr('readonly', false);
                $('#AsignacionCenso_fecha_nac').val('');
                bootbox.alert('La Persona no se encuentra registrada en el Saime.');
            } else {
                $('#AsignacionCenso_persona_id').val(datos.ID);
                $('#AsignacionCenso_primer_nombre').val(datos.PRIMERNOMBRE);
                $('#AsignacionCenso_segundo_nombre').val(datos.SEGUNDONOMBRE);
                $('#AsignacionCenso_primer_apellido').val(datos.PRIMERAPELLIDO);
                $('#AsignacionCenso_segundo_apellido').val(datos.SEGUNDOAPELLIDO);
                $('#AsignacionCenso_fecha_nac').val(datos.FECHANACIMIENTO);
                $('#iconLoding').hide();
            }

        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
        }
    })
}


/* -------------------------------------------------------*/

function buscarPersonaFamiliar(nacionalidad, cedula) {
    $('#GrupoFamiliar_primer_nombre').val('');
    $('#GrupoFamiliar_segundor_nombre').val('');
    $('#GrupoFamiliar_persona_id').val('');
    $('#GrupoFamiliar_primer_apellido').val('');
    $('#GrupoFamiliar_segundo_apellido').val('');
    $('#GrupoFamiliar_tipo_persona_faov').val('');
    $('#GrupoFamiliar_gen_parentesco_id').val('');
    $('#GrupoFamiliar_fecha_nacimiento_menor').val('');
    $('#GrupoFamiliar_fecha_nacimiento_menor').val('');
    $('#GrupoFamiliar_primer_nombre').attr('readonly', true);
    $('#GrupoFamiliar_segundo_nombre').attr('readonly', true);
    $('#GrupoFamiliar_persona_id').attr('readonly', true);
    $('#GrupoFamiliar_primer_apellido').attr('readonly', true);
    $('#GrupoFamiliar_segundo_apellido').attr('readonly', true);
    $('#GrupoFamiliar_fecha_nacimiento').attr('readonly', true);
    $('#GrupoFamiliar_ingreso_mensual_faov').attr('readonly', true);
    $('#GrupoFamiliar_gen_parentesco_id').attr('disabled', true);
    if (nacionalidad == '') {
        bootbox.alert('Verifique que la nacionalidad no esten vacios');
        return false;
    }
    if (cedula == '') {
        bootbox.alert('Verifique que la cédula no esten vacios');
        return false;
    }
    $('#iconLoding').show();
    $.ajax({
        url: baseUrl + "/ValidacionJs/BuscarPersonasFamiliar",
        async: true,
        type: 'POST',
        data: 'nacionalidad=' + nacionalidad + '&cedula=' + cedula,
        dataType: 'json',
        success: function (datos) {

            if (datos == 1) {
                $('#iconLoding').hide();
                $('#GrupoFamiliar_primer_nombre').val('');
                $('#GrupoFamiliar_segundo_nombre').val('');
                $('#GrupoFamiliar_persona_id').val('');
                $('#GrupoFamiliar_primer_apellido').val('');
                $('#GrupoFamiliar_segundo_apellido').val('');
                $('#GrupoFamiliar_fecha_nacimiento').val('');
                $('#GrupoFamiliar_cedula').val('');
                $('#GrupoFamiliar_ingreso_mensual_faov').val('');
                $('#GrupoFamiliar_fecha_nacimiento_menor').val('');
                $('#fecha_menor').hide();
                bootbox.alert('La Persona ya se encuentra asignada a un grupo Familiar.');
            } else if (datos == 2) {
                $('#iconLoding').hide();
                $('#GrupoFamiliar_primer_nombre').val('');
//                $('#GrupoFamiliar_cedula').val('');
                $('#GrupoFamiliar_segundo_nombre').val('');
                $('#GrupoFamiliar_persona_id').val('');
                $('#GrupoFamiliar_primer_apellido').val('');
                $('#GrupoFamiliar_segundo_apellido').val('');
                $('#GrupoFamiliar_fecha_nacimiento').val('');
                $('#fecha_menor').show();
                $('#GrupoFamiliar_ingreso_mensual_faov').val('');
                $('#GrupoFamiliar_primer_nombre').attr('readonly', false);
                $('#GrupoFamiliar_cedula').attr('readonly', false);
                $('#GrupoFamiliar_segundo_nombre').attr('readonly', false);
                $('#GrupoFamiliar_persona_id').attr('readonly', false);
                $('#GrupoFamiliar_primer_apellido').attr('readonly', false);
                $('#GrupoFamiliar_segundo_apellido').attr('readonly', false);
                $('#GrupoFamiliar_fecha_nacimiento').attr('readonly', false);
                $('#GrupoFamiliar_ingreso_mensual_faov').attr('readonly', false);
                $('#GrupoFamiliar_gen_parentesco_id').attr('disabled', false);
//                bootbox.alert('La Persona no se encuentra registrada en el Saime.');
            } else {
                $('#GrupoFamiliar_gen_parentesco_id').attr('disabled', false);
                $('#GrupoFamiliar_persona_id').val(datos.persona.ID);
                $('#GrupoFamiliar_primer_nombre').val(datos.persona.PRIMERNOMBRE);
                $('#GrupoFamiliar_segundo_nombre').val(datos.persona.SEGUNDONOMBRE);
                $('#GrupoFamiliar_primer_apellido').val(datos.persona.PRIMERAPELLIDO);
                $('#GrupoFamiliar_segundo_apellido').val(datos.persona.SEGUNDOAPELLIDO);
                $('#GrupoFamiliar_fecha_nacimiento').val(datos.persona.FECHANACIMIENTO);
                $('#GrupoFamiliar_ingreso_mensual_faov').val(datos.faov);
                $('#GrupoFamiliar_fecha_nacimiento_menor').val('');
                $('#fecha_menor').hide();
                $('#iconLoding').hide();
            }
        },
        error: function (datos) {
            bootbox.alert('Ocurrio un error');
        }
    })
}

/*
 * FUNCTION QUE VALIDA CANTIDAD DE PERENTEZCO
 */

function Parentesco(valor) {

    if ($('#Familiar_cedula_familiar').val() == '') {
        bootbox.alert('Ingrese un número de cédula!');
        $('#Familiar_parentesco').val('');
        return false;
    }

    contadorPadre = parseInt(0);
    contadorConyuge = parseInt(0);
    contadorMadre = parseInt(0);
    contadorSuegro = parseInt(0);
    contadorAbuelo = parseInt(0);
    $('#listado_familiar tr').each(function () {
        var parentesco = $(this).find('td:eq(6)').html();
        if (parentesco == 'PADRE') {
            contadorPadre++
        }
        if (parentesco == 'CONYUGE') {
            contadorConyuge++
        }
        if (parentesco == 'MADRE') {
            contadorMadre++
        }
        if (parentesco == 'SUEGRO(A)') {
            contadorSuegro++
        }
        if (parentesco == 'ABUELO(A)') {
            contadorAbuelo++
        }
    });


    if (valor == 'C') {
        if (contadorConyuge > 0) {
            bootbox.alert('Usted ya tiene registrado un Conyuge.');
            $('#Familiar_parentesco').val('');
            return false;
        }
    } else if (valor == 'M') {
        if (contadorMadre > 0) {
            bootbox.alert('Usted ya tiene registrado a su Madre.');
            $('#Familiar_parentesco').val('');
            return false;
        }
    } else if (valor == 'P') {
        if (contadorPadre > 0) {
            bootbox.alert('Usted ya tiene registrado a su Padre.');
            $('#Familiar_parentesco').val('');
            return false;
        }
    } else if (valor == 'S') {
        if (contadorSuegro >= 2) {
            bootbox.alert('Usted ya posee asociado dos Suegros.');
            $('#Familiar_parentesco').val('');
            return false;
        }
    } else if (valor == 'A') {
        if (contadorAbuelo >= 4) {
            bootbox.alert('Usted ya posee asociado cuatro Abuelos.');
            $('#Familiar_parentesco').val('');
            return false;
        }
    }

}

function Viviendas(habitacional, tipo_vivienda, piso, vivienda) {

    if (habitacional == '') {
        bootbox.alert('Verifique que el tipo de vivienda no puede ser vacio.');
        return false;
    }
//    if (vivienda == '') {
//        bootbox.alert('Verifique que la vivienda no esten vacios');
//        return false;
//    }

//    if (piso == '') {
//        bootbox.alert('Verifique que la piso no esten vacios');
//        return false;
//    }

    $.ajax({
        url: baseUrl + "/ValidacionJs/NroVivienda",
        async: true,
        type: 'POST',
        data: 'habitacional=' + habitacional + '&tipo_vivienda=' + tipo_vivienda + '&piso=' + piso + '&vivienda=' + vivienda,
        dataType: 'json',
        success: function (datos) {
            /* ++++   solo verifico en Persona  ++++  */

            if (datos == 1) {
                $('#Vivienda_construccion_mt2').attr('readonly', false);
                $('#Vivienda_construccion_mt2').attr('disabled', false);
                $('#Vivienda_construccion_mt2').val('00.00');
                $('#Vivienda_nro_habitaciones').attr('readonly', false);
                $('#Vivienda_nro_habitaciones').attr('disabled', false);
                $('#Vivienda_nro_banos').attr('readonly', false);
                $('#Vivienda_nro_banos_auxiliar').attr('readonly', false);
                $('#Vivienda_nro_banos').attr('disabled', false);
                $('#Vivienda_coordenadas').attr('readonly', false);
                $('#Vivienda_coordenadas').attr('disabled', false);
                $('#Vivienda_lindero_norte').attr('readonly', false);
                $('#Vivienda_lindero_norte').attr('disabled', false);
                $('#Vivienda_lindero_sur').attr('readonly', false);
                $('#Vivienda_lindero_sur').attr('disabled', false);
                $('#Vivienda_lindero_este').attr('readonly', false);
                $('#Vivienda_lindero_este').attr('disabled', false);
                $('#Vivienda_lindero_oeste').attr('readonly', false);
                $('#Vivienda_lindero_oeste').attr('disabled', false);
                $('#Vivienda_nro_estacionamientos').attr('readonly', false);
                $('#Vivienda_nro_estacionamientos').attr('disabled', false);
                $('#Vivienda_descripcion_estac').attr('readonly', false);
                $('#Vivienda_descripcion_estac').attr('disabled', false);
                $('#Vivienda_precio_vivienda').attr('readonly', false);
                $('#Vivienda_precio_vivienda').attr('disabled', false);

            } else if (datos == 2) {
                $('#Vivienda_construccion_mt2').attr('readonly', true);
                $('#Vivienda_nro_habitaciones').attr('readonly', true);
                $('#Vivienda_coordenadas').attr('readonly', true);
                $('#Vivienda_nro_banos').attr('readonly', true);
                $('#Vivienda_lindero_norte').attr('readonly', true);
                $('#Vivienda_lindero_sur').attr('readonly', true);
                $('#Vivienda_lindero_este').attr('readonly', true);
                $('#Vivienda_lindero_oeste').attr('readonly', true);
                $('#Vivienda_nro_estacionamientos').attr('readonly', true);
                $('#Vivienda_descripcion_estac').attr('readonly', true);
                $('#Vivienda_precio_vivienda').attr('readonly', true);
                $('#Vivienda_nro_banos_auxiliar').attr('readonly', true);

                $('#Vivienda_lindero_sur').val('');
                $('#Vivienda_nro_banos_auxiliar').val('');
                $('#Vivienda_construccion_mt2').val('');
                $('#Vivienda_nro_habitaciones').val('');
                $('#Vivienda_nro_banos').val('');
                $('#Vivienda_coordenadas').val('');
                $('#Vivienda_lindero_norte').val('');
                $('#Vivienda_lindero_este').val('');
                $('#Vivienda_lindero_oeste').val('');
                $('#Vivienda_nro_estacionamientos').val('');
                $('#Vivienda_descripcion_estac').val('');
                $('#Vivienda_precio_vivienda').val('');
                $('#Vivienda_nro_vivienda').val('');

                bootbox.alert('Disculpe este número de vivienda ya se encuentra registrado');
                return false;

//                $('#Vivienda_construccion_mt2').attr('readonly', true);
//                $('#Vivienda_construccion_mt2').attr('disabled', true);


            }
        }

    });

}


function emailCheck(emailStr, emailid) {
    var checkTLD = 1;
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|gob|arpa|biz|aero|name|coop|info|pro|museum|COM|NET|ORG|EDU|INT|MIL|GOV|GOB|ARPA|BIZ|AERO|NAME|COOP|INFO|PRO|MUSEUM)$/;
    var emailPat = /^(.+)@(.+)$/;
    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    var validChars = "\[^\\s" + specialChars + "\]";
    var quotedUser = "(\"[^\"]*\")";
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
    var atom = validChars + '+';
    var word = "(" + atom + "|" + quotedUser + ")";
    var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
    var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
    var matchArray = emailStr.match(emailPat);
    if (matchArray == null) {

        bootbox.alert("El Formato del Correo Electronico es Incorrecto.\n \n\
                        El formato Correcto es: Usuario@Servidor.Dominio");
        /* -***********    *************- */
        var datos = String($('#' + emailid).select2("val"));
        var arredato = datos.split(',');
        var dato_final = [];
        if (arredato.length - 1) {
            for (var cont = 0; cont < arredato.length - 1; cont++)
                dato_final[cont] = arredato[cont];
        } else
            dato_final = "";
        $('#' + emailid).select2("val", dato_final);
        /* -****************************- */


        return false;
    }
    var user = matchArray[1];
    var domain = matchArray[2];
    for (i = 0; i < user.length; i++) {
        if (user.charCodeAt(i) > 127) {
            bootbox.alert("El nombre de usuario contiene caracteres inv\u00e1lidos.");
            /* -***********    *************- */
            var datos = String($('#' + emailid).select2("val"));
            var arredato = datos.split(',');
            var dato_final = [];
            if (arredato.length - 1) {
                for (var cont = 0; cont < arredato.length - 1; cont++)
                    dato_final[cont] = arredato[cont];
            } else
                dato_final = "";
            $('#' + emailid).select2("val", dato_final);
            /* -****************************- */
            return false;
        }
    }
    for (i = 0; i < domain.length; i++) {
        if (domain.charCodeAt(i) > 127) {
            bootbox.alert("El nombre de dominio contiene caracteres inv\u00e1lidos.");
            /* -***********    *************- */
            var datos = String($('#' + emailid).select2("val"));
            var arredato = datos.split(',');
            var dato_final = [];
            if (arredato.length - 1) {
                for (var cont = 0; cont < arredato.length - 1; cont++)
                    dato_final[cont] = arredato[cont];
            } else
                dato_final = "";
            $('#' + emailid).select2("val", dato_final);
            /* -****************************- */
            return false;
        }
    }
    if (user.match(userPat) == null) {
        bootbox.alert("           El Formato del Correo Electronico es Incorrecto\n \n\
       El formato Correcto es Usuario@Servidor.Dominio");
        /* * -***********    *************- */
        var datos = String($('#' + emailid).select2("val"));
        var arredato = datos.split(',');
        var dato_final = [];
        if (arredato.length - 1) {
            for (var cont = 0; cont < arredato.length - 1; cont++)
                dato_final[cont] = arredato[cont];
        } else
            dato_final = "";
        $('#' + emailid).select2("val", dato_final);
        /* -****************************- */
        return false;
    }
    var IPArray = domain.match(ipDomainPat);
    if (IPArray != null) {
        for (var i = 1; i <= 4; i++) {
            if (IPArray[i] > 255) {
                bootbox.alert("La direcci\u00f3n IP es inv\u00e1lida!");
                /* -***********    *************- */
                var datos = String($('#' + emailid).select2("val"));
                var arredato = datos.split(',');
                var dato_final = [];
                if (arredato.length - 1) {
                    for (var cont = 0; cont < arredato.length - 1; cont++)
                        dato_final[cont] = arredato[cont];
                } else
                    dato_final = "";
                $('#' + emailid).select2("val", dato_final);
                /* -****************************- */
                return false;
            }
        }
        return true;
    }
    var atomPat = new RegExp("^" + atom + "$");
    var domArr = domain.split(".");
    var len = domArr.length;
    for (i = 0; i < len; i++) {
        if (domArr[i].search(atomPat) == -1) {
            alert("El nombre de dominio no parece ser v\u00e1lido.");
            /* -***********    *************- */
            var datos = String($('#' + emailid).select2("val"));
            var arredato = datos.split(',');
            var dato_final = [];
            if (arredato.length - 1) {
                for (var cont = 0; cont < arredato.length - 1; cont++)
                    dato_final[cont] = arredato[cont];
            } else
                dato_final = "";
            $('#' + emailid).select2("val", dato_final);
            /* -****************************- */

            return false;
        }
    }
    if (checkTLD && domArr[domArr.length - 1].length != 2 &&
            domArr[domArr.length - 1].search(knownDomsPat) == -1) {
        alert("La direcci\u00f3n debe terminar en un dominio conocido\no c\u00f3digo de pa\u00eds de dos letras.");
        /* -***********    *************- */
        var datos = String($('#' + emailid).select2("val"));
        var arredato = datos.split(',');
        var dato_final = [];
        if (arredato.length - 1) {
            for (var cont = 0; cont < arredato.length - 1; cont++)
                dato_final[cont] = arredato[cont];
        } else
            dato_final = "";
        $('#' + emailid).select2("val", dato_final);
        /* -****************************- */
        return false;
    }
    if (len < 2) {
        alert("Esta direcci\u00f3n no tiene un nombre de host!");
        /* -***********    *************- */
        var datos = String($('#' + emailid).select2("val"));
        var arredato = datos.split(',');
        var dato_final = [];
        if (arredato.length - 1) {
            for (var cont = 0; cont < arredato.length - 1; cont++)
                dato_final[cont] = arredato[cont];
        } else
            dato_final = "";
        $('#' + emailid).select2("val", dato_final);
        /* -****************************- */
        return false;
    }
    return true;
}

/*
 * funcion que precarga dependiendo del parenteco el
 * tipo de persona faov sea COSOLICITANTE /ACEPTANTE
 */
function aceptante(id) {
    parentesco = $('#GrupoFamiliar_gen_parentesco_id').val();
    if ($('#GrupoFamiliar_ingreso_mensual').val() == '') {
        bootbox.alert('Declare un ingreso mensual.');
        return false;
    }
    if (parentesco == 155 || parentesco == 161) {  //155=CONYUGUE - 161=CONCUBINO(A)
        if (total_tems = $('#GrupoFamiliar_tipo_persona_faov').find('option').length == 2) {
            $("#GrupoFamiliar_tipo_persona_faov").append("<option value='236'>ACEPTANTE</option>");

        }
        $('#GrupoFamiliar_tipo_persona_faov').attr('disabled', true);
        if ($('#GrupoFamiliar_ingreso_mensual').val() == 0) {
            $('#GrupoFamiliar_tipo_persona_faov').val('236');   // ACEPTANTE
        } else {
            $('#GrupoFamiliar_tipo_persona_faov').val('235');   // COSOLICITANTE
        }
    } else {
        $("#GrupoFamiliar_tipo_persona_faov option[value='236']").remove();
        $('#GrupoFamiliar_tipo_persona_faov').attr('disabled', false);
    }
}


/*
 * funcion que precarga los datos correspondiente al select que se haga
 *  en condicion de trabajo en beneficiario
 */
function condiciontra() {
    trabajo = $('#Beneficiario_condicion_trabajo_id').val();
    if (trabajo == '111' || trabajo == '116') {
        var html = "<option value=''>SELECCIONE</option><option value='107'>SUELDO</option><option value='108'>HONORARIOS</option>";
        $('#Beneficiario_fuente_ingreso_id').html(html);
        var html2 = "<option value=''>SELECCIONE</option><option value='134'>INFORMAL</option><option value='133'>FORMAL</option>";
        $('#Beneficiario_sector_trabajo_id').html(html2);
        $('.relacion').show();
    } else {
        var html = "<option value=''>SELECCIONE</option><option value='106'>RENTA</option><option value='104'>PENSIÓN</option><option value='105'>HERENCIA</option><option value='103'>NINGUNA</option>";
        $('#Beneficiario_fuente_ingreso_id').html(html);
        var html2 = "<option value=''>SELECCIONE</option><option value='135'>NO TRABAJA</option>";
        $('#Beneficiario_sector_trabajo_id').html(html2);
        $('.relacion').hide();
    }

}

/*funcion que permite regresar hacia la vista anterior para el bonto del ver detalle
 *de Censo socioeconomico
 */
function goBack() {
    window.history.back();
}
/*funcion que permite regresar hacia la vista anterior para el bonto del ver detalle
 *de Censo socioeconomico
 */
function goBackTwo() {
    window.history.back();
    window.history.back();
}

/*
 * funcion que permite el precargado de datos del grupo familiar al momento de
 * modificar el grupo familiar
 */
function aceptanteupdate(id) {
    parentesco = $('#gen_parentesco_id').val();

    if ($('#ingreso_mensual').val() == '') {
        bootbox.alert('Declare un ingreso mensual.');
        return false;
    }
    if (parentesco == 155 || parentesco == 161) {
        if (total_tems = $('#tipo_persona_faov').find('option').length == 2) {
            $("#tipo_persona_faov").append("<option value='236'>ACEPTANTE</option>");

        }
        $('#tipo_persona_faov').attr('disabled', true);
        if ($('#ingreso_mensual').val() == 0) {
            $('#tipo_persona_faov').val('236');   // ACEPTANTE
        } else {
            $('#tipo_persona_faov').val('235');   // COSOLICITANTE
        }
    } else {
        $("#tipo_persona_faov option[value='236']").remove();
        $('#tipo_persona_faov').attr('disabled', false);
    }
}

function CambiarEstatusDocumento(codigo, actor, caso) {

//    alert(codigo);return false;
//    alert(baseUrl);return false;

    $.ajax({
        url: baseUrl + "/Documentacion/CambioEstatusDocumento",
        type: 'POST',
        data: 'codigo=' + codigo + '&actor=' + actor + '&caso=' + caso,
        async: true,
        dataType: 'json',
        success: function (data) {


            if (caso == 1) {//ESTATUS VALIDADO POR BANAVIH (MULTIFAMILIAR)
                if (confirm('¿Esta seguro de enviar validado este caso a SAREN? ')) {

                    if (data == 1) {
                        bootbox.alert("Validado con éxito, enviado a SAREN");
//                return false;
                        $('#unidad-habitacional-grid').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });

                        return false;
                    } else if (data == 2) {
                        bootbox.alert("El documento tiene una corrección por parte de Saren. Por favor corrija el documento antes de enviar como (Validado) a Saren");
                        return false;

                    }
                }

            } else if (caso == 2) {//ESTATUS VALIDADO POR SAREN (MULTIFAMILIAR)

                if (confirm('¿Esta seguro de enviar validado este caso a BANAVIH? ')) {

                    if (data == 1) {
                        bootbox.alert("Validado con éxito, enviado a BANAVIH");
//                return false;
                        $('#unidad-habitacional-grid-2').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });

                        return false;
                    } else if (data == 2) {
                        bootbox.alert("El documento posee una corrección por parte de Saren");
                        return false;

                    }
                }

            } else if (caso == 3) {//ESTATUS VALIDADO POR BANAVIH (UNIFAMILIAR)


                if (confirm('¿Esta seguro de enviar validado este caso a SAREN? ')) {

                    if (data == 1) {
                        bootbox.alert("Validado con éxito, enviado a SAREN");
//                return false;
                        $('#beneficiario-grid').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });

                        return false;
                    } else if (data == 2) {
                        bootbox.alert("El documento tiene una corrección por parte de Saren. Por favor corrija el documento antes de enviar como (Validado) a Saren");
                        return false;

                    }
                }

            } else if (caso == 4) {//ESTATUS VALIDADO POR SAREN (UNIFAMILIAR)

                if (confirm('¿Esta seguro de enviar validado este caso a BANAVIH? ')) {

                    if (data == 1) {
                        bootbox.alert("Validado con éxito, enviado a BANAVIH");
//                return false;
                        $('#beneficiario-grid-2').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });
                        return false;

                    } else if (data == 2) {
                        bootbox.alert("El documento posee una corrección por parte de Saren");
                        return false;

                    }
                }

            } else if (caso == 5) {

                if (confirm('¿Esta seguro de devolver este caso a BANAVIH? ')) {

                    if (data == 1) {
                        bootbox.alert("Este caso a sido devuelto a BANAVIH");//ESTATUS DEVUELTO POR SAREN (UNIFAMILIAR)
//                return false;
                        $('#beneficiario-grid-2').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });
                        return false;

                    } else if (data == 2) {
                        bootbox.alert("Por favor haga una observación en el documento antes de enviarlo como (Devuelto) a Banavih");
                        return false;

                    }
                }

            } else if (caso == 6) {

                if (confirm('¿Esta seguro de devolver este caso a BANAVIH? ')) {

                    if (data == 1) {
                        bootbox.alert("Este caso a sido devuelto a BANAVIH");//ESTATUS DEVUELTO POR SAREN (MULTIFAMILIAR)
//                return false;
                        $('#unidad-habitacional-grid-2').yiiGridView('update', {//Actualización automatica griewView
                            data: $(this).serialize()
                        });
                        return false;

                    } else if (data == 2) {
                        bootbox.alert("Por favor haga una observación en el documento antes de enviarlo como (Devuelto) a Banavih");
                        return false;

                    }
                }
//                else if (data == 2) {
//                    bootbox.alert("Por favor indique una observación");
//                    return false;
//
//                }

            }
        },
        error: function (data) {
            alert('error');

        }
    })


}
