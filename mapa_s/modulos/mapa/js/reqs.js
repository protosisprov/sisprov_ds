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
      send_mostar_select_municipio();
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
//***********************Nuevas Funciones*******************************
//COLOCAR EL MUNICIPIO
function send_mostar_select_municipio(){
    var estado=document.getElementById('nombre_estado').value;
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_ajax('GET','../../reqs/mostrar/mostrar_select_municipio__.php?estado='+estado, 'response_select_municipio', null);
}

function response_select_municipio(response){
    if (response){
        var mun_desarrollo = document.getElementById('municipio_desarrollo');
        var arreglo = new Array();
        arreglo = response.split('¬');
        llenarCombo(mun_desarrollo,arreglo,'#',0,'--TODOS---');
    }
}

function send_mostar_select_parroquia(){
    var municipio=document.getElementById('municipio_desarrollo').value;
    var parro_desarrollo=document.getElementById('parroquia_desarrollo');
    vaciarCombo(parro_desarrollo);        
    send_mostar_desarrollo_parroquia();
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_ajax('GET','../../reqs/mostrar/mostrar_select_parroquia__.php?municipio='+municipio, 'response_select_parroquia', null);
}

//COLOCAR LA PARROQUIA
function response_select_parroquia(response){ 
     var parro_desarrollo=document.getElementById('parroquia_desarrollo');
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
        var arreglo = new Array();
        arreglo = response.split('¬');
        llenarCombo(parro_desarrollo,arreglo,'#',0,'--TODOS--');
}



//MOSTRAR LOS DESARROLLOS POR PARROQUIA
function send_mostar_desarrollo_parroquia(){
    var estado=document.getElementById('nombre_estado').value;
    var parroquia=document.getElementById('parroquia_desarrollo').value;
    var municipio=document.getElementById('municipio_desarrollo').value;
    var cadena="";
    if (parroquia>0){
        cadena+=" and cod_parroquia ="+parroquia;
    }
    if(municipio>0){
         cadena+=" and cod_municipio ="+municipio;
    }
//    alert('reqs/mostrar/mostrar_oficinas_estado__.php?estado='+estado);
    send_mostar_unidades_familiares();
    send_ajax('GET','../../reqs/mostrar/mostrar_desarrollo_parroquia__.php?estado='+estado+'&cadena='+cadena, 'response_desarrollo_parroquia', null);
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
            var datos_button="";
            var datos_button1="";
            
            document.getElementById('cant_unidades').innerHTML="("+campos[0]+") Unidades Familiares  ("+campos[1]+") Viviendas";
            //Verificamos si existen datos

            if (campos[2]>0){
                datos_button="<buton class='btn btn-success' style='margin-left: 53%' onclick='imprimir_pdf(2)'>Ver Listado</buton>";
            }
            
            document.getElementById('cant_censada').innerHTML="("+campos[2]+") Viviendas Censadas  "+datos_button;
            
//            if (campos[3]>0){
//                datos_button1="<buton class='btn btn-success' style='margin-left: 51%' onclick='imprimir_pdf(1)'>Ver Listado</buton>";
//            }
            
            document.getElementById('cant_adjudicado').innerHTML="("+campos[3]+") Viviendas por Adjudicar" +datos_button1;;
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
//            document.getElementById('cant_familia').innerHTML="("+response+") Familias Beneficadas <buton class='btn btn-success' style='margin-left: 52%' onclick='imprimir_pdf()'>Ver Listado</buton>";
            document.getElementById('cant_familia').innerHTML="("+response+") Familias Beneficadas";
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
//            document.getElementById('cant_persona').innerHTML="("+response+") Total de Beneficiarios <buton class='btn btn-success' style='margin-left: 52%' onclick='imprimir_pdf()'>Ver Listado</buton>";
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

function imprimir_pdf(valor){
    var estado=document.getElementById('nombre_estado').value;
    var archivo='';
//    window.open("../../reportes/reporte_resumen?est="+estado,'_blank','');
    switch (valor){
        case 1: 
            archivo="relacion_desarrollos.php";
        break;
        case 2: 
            archivo="viviendas_censadas.php";
        break;
        case 3: 
            archivo="detalles_desarrollos.php";
        break;
    }
    window.open("../../reportes/reporte_resumen/"+archivo+"?estado="+estado,'_blank','');
}
function imprimir_pdf_prin(valor,estado){
//    alert(estado);
    var archivo='';
//    window.open("../../reportes/reporte_resumen?est="+estado,'_blank','');
    switch (valor){
        case 1: 
            archivo="relacion_desarrollos.php";
        break;
        case 2: 
            archivo="viviendas_censadas.php";
        break;
        case 3: 
            archivo="detalles_desarrollos.php";
        break;
    }
    window.open("../../reportes/reporte_resumen/"+archivo+"?estado="+estado,'_blank','');
}
//*********************
