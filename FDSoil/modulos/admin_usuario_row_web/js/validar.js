function inicio(){
    var obj=new app();
    id_sistema(obj.name);
    //ruta();
}

function val_envio(){
    
    var enviar = true;    
    
    if(!validar_campo('id_cedula', 'div_cedula', 'Debe llenar el Número de Cedula.')) enviar=false;
    if(!validar_campo('id_nombres', 'div_nombre', 'Debe llenar Nombre.')) enviar=false;
    if(!validar_campo('id_apellidos', 'div_apellido', 'Debe llenar Apellido.')) enviar=false;
    if(!validar_campo('id_correo', 'div_correo', 'Debe llenar Correo Electrónico.'))enviar=false;        
    if(!validar_campo('id_usuario', 'div_usuario', 'Debe llenar el Nombre de Usuario.')) enviar=false;
    if(!validar_campo('id_clave', 'div_clave', 'Debe ingresar la Clave.')) enviar=false;
    if(!validar_campo('id_clave2', 'div_clave2', 'Debe ingresar la confirmación de la Clave.')) enviar=false;
    if(!validar_combo('id_pregunta', 'div_pregunta', 'Debe selecionar una Pregunta de Seguridad.')) enviar=false;
    if(!validar_campo('id_respuesta', 'div_respuesta', 'Debe llenar la Respuesta a la Pregunta de Seguridad.')) enviar=false;
    
    if (document.getElementById('validar_correo').value==='false'){
        enviar = false;
        alert("Debe ingresar correctamente su correo eléctronico");
        document.getElementById('id_correo').focus();
    }
    
    if(enviar===true){
        enviar=confirm('\u00BFSeguro(a) que desea registrar su usuario en el sistema?');
    }
    if (enviar === true){
        send_verificar_userweb();
    }
}

function val_clave(id_destino){     
    clave=document.getElementById('id_clave');
    clave2=document.getElementById('id_clave2');
    if(clave.value !='' && clave2.value!=''){
        if (clave.value != clave2.value ){
            document.getElementById(id_destino).innerHTML='Las claves no coinciden.';
        }else{
            document.getElementById(id_destino).innerHTML='';
        }
    }else{
        document.getElementById(id_destino).innerHTML='';
    }
    if (validatePassWord(document.getElementById('id_clave').value)==false)
        //document.getElementById('div_clave').innerHTML='Debe estar conformada por letras, números, caracteres especiales y el largo debe ser de 6 a 10 dígitos';   
            document.getElementById('div_clave').innerHTML='Debe Confirmar su Contraseña ';
    else
        document.getElementById('div_clave').innerHTML='';   
}
function salir_registro(){
    var ruta = "../admin_acceso"
    window.location.href = ruta;
}
function crearnombreuser(){
    
    var nombre = document.getElementById('id_nombres').value;
        var na = nombre.substring(0,1);
    var apelli = document.getElementById('id_apellidos').value.split(' ');
    
    var nameuser = na+apelli[0];
    document.getElementById('id_usuario').value = nameuser.toLowerCase();
}
