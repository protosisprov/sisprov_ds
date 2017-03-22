//*********************

//MOSTRAR LAS OFICINAS POR ESTADO
function send_mostar_oficinas_estados(){
    var estado=document.getElementById('nombre_estado').value;
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_ajax('GET','../../reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado, 'response_oficinas_estados', null);
}

function response_oficinas_estados(response){
        if (response){
            title_table('oficinas','Num#Nombre');
            llenar_variable('oficinas',response);
        }
}
//MOSTRAR LOS DESARROLLOS POR ESTADO
function send_mostar_desarrollo(){
    var estado=document.getElementById('nombre_estado').value;
     send_mostar_desarrollo_parroquia();
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_ajax('GET','../../reqs/mostrar/mostrar_desarrollo_estado__.php?estado='+estado, 'response_desarrollo_estados', null);
}

function response_desarrollo_estados(response){
        if (response){
            document.getElementById('cant_desarrollo').innerHTML="("+response+") Desarrollos Habitacionales ";
        }
        else{
            document.getElementById('mensaje_desarrollo').innerHTML="NO EXISTEN DESARROLLOS REGISTRADOS";
        }
}

//MOSTRAR LOS DESARROLLOS POR PARROQUIA
function send_mostar_desarrollo_parroquia(){
    var estado=document.getElementById('nombre_estado').value;
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_mostar_unidades_familiares();
    send_ajax('GET','../../reqs/mostrar/mostrar_desarrollo_parroquia__.php?estado='+estado, 'response_desarrollo_parroquia', null);
}

function response_desarrollo_parroquia(response){
        if (response){
            title_table('desarrollo_p','Num#Municipio#Parroquia#Desarrollos');
            llenar_variable('desarrollo_p',response);
        }
        else{
            document.getElementById('mensaje_desarrollo').innerHTML="NO EXISTEN DESARROLLOS REGISTRADOS";
        }
}

//MOSTRAR LOS UNIDADES FAMILIARES
function send_mostar_unidades_familiares(){
    var estado=document.getElementById('nombre_estado').value;
    send_mostar_familias_beneficiadas();
    send_ajax('GET','../../reqs/mostrar/mostrar_unidades_familiares__.php?estado='+estado, 'response_unidades_familiares', null);
}

function response_unidades_familiares(response){
        if (response){
//            title_table('unidades_f','Cant.Unidad Familiar#Cant.Vivienda');
//            llenar_variable_sin_conteo('unidades_f',response);
            var campos= response.split('#');  
            if (campos[0]==0){
                for (var i = 1; i <= 3; i++) {
                    campos[i]=0;
                } 
            }
            document.getElementById('cant_unidades').innerHTML="("+campos[0]+") Unidades Familiares  ("+campos[1]+") Viviendas";
            document.getElementById('cant_censada').innerHTML="("+campos[2]+") Viviendas Censadas";
            document.getElementById('cant_adjudicado').innerHTML="("+campos[3]+") Viviendas por Adjudicar";
        }
        else{
            document.getElementById('mensaje_unidades_familiares').innerHTML="NO EXISTEN DESARROLLOS REGISTRADOS";
        }
}


//MOSTRAR FAMILIAS
function send_mostar_familias_beneficiadas(){
    var estado=document.getElementById('nombre_estado').value;
//        alert('reqs/mostrar/mostrar_familias_beneficiadas__.php?estado='+estado);
        send_mostar_personas_beneficiadas();
//    send_mostar_documento_protocolizado();
    send_ajax('GET','../../reqs/mostrar/mostrar_familias_beneficiadas__.php?estado='+estado, 'response_familias_beneficiadas', null);
}

function response_familias_beneficiadas(response){
        if (response){           
            document.getElementById('cant_familia').innerHTML="("+response+") Familias Beneficadas ";
//            send_mostar_personas_beneficiadas();
        }
        else{
            document.getElementById('cant_familia').innerHTML="NO EXISTEN DESARROLLOS REGISTRADOS";
        }
}

//MOSTRAR PERSONA
function send_mostar_personas_beneficiadas(){
    var estado=document.getElementById('nombre_estado').value;
//        alert('reqs/mostrar/mostrar_familias_beneficiadas__.php?estado='+estado);
    send_mostar_documento_protocolizado();
    send_ajax('GET','../../reqs/mostrar/mostrar_personas_beneficiadas__.php?estado='+estado, 'response_persona_beneficiadas', null);
}

function response_persona_beneficiadas(response){
        if (response){           
            document.getElementById('cant_persona').innerHTML="("+response+") Total de Beneficiarios ";
//            send_mostar_personas_beneficiadas();
        }
        else{
            document.getElementById('cant_persona').innerHTML="NO EXISTEN BENEFICIARIOS REGISTRADOS";
        }
}//mostrar_personas_beneficiadas

//DOCUMENTOS PROTOCOLIZADOS
function send_mostar_documento_protocolizado(){
    var estado=document.getElementById('nombre_estado').value;
    send_mostar_oficinas_estados();
    send_ajax('GET','../../reqs/mostrar/mostrar_documentos_protocolizado__.php?estado='+estado, 'response_documento_protocolizado', null);
}

function response_documento_protocolizado(response){
        if (response){           
            document.getElementById('cant_protocolizado').innerHTML="("+response+") Documentos Protocolizados ";
//            send_mostar_personas_beneficiadas();
        }
        else{
            document.getElementById('cant_protocolizado').innerHTML="NO EXISTEN DOCUMENTOS PROTOCOLIZADOS";
        }
}

function imprimir_pdf(){
    var estado=document.getElementById('nombre_estado').value;
    
//    window.open("../../reportes/reporte_resumen?est="+estado,'_blank','');
    window.open("../../reportes/reporte_resumen/demoras.php?estado="+estado,'_blank','');
}
//*********************
