function enviar_usuario(){
    var vacio = "Este campo se encuentra vacio";
    var enviar = true;
        if (document.getElementById('text_ente').value!==''){
           if(!validar_campo('text_ente', 'msnj_ente', vacio)) enviar=false;
        }else{
           if(!validar_campo('ente', 'msnj_ente', vacio)) enviar=false; 
        }
        if(!validar_campo('cedula', 'msnj_cedula', vacio)) enviar=false;
        if(!validar_campo('nombre', 'msnj_nombre', vacio)) enviar=false;
        if(!validar_campo('apellido', 'msnj_apellido', vacio)) enviar=false;
        if(!validar_campo('correo', 'msnj_correo', vacio)) enviar=false;
        if(!validar_campo('tele_celular', 'msnj_tele_celular', vacio)) enviar=false;
        if(!validar_campo('tele_local', 'msnj_tele_local', vacio)) enviar=false;
        if(!validar_campo('usuario_asig', 'msnj_usuario_asig', vacio)) enviar=false;
        
    if(enviar===true){
        enviar=confirm('\u00BFSeguro(a) que desea guardar la información suministrada?');
    }
    if(enviar===true){
       send_guarda_usuario();
    }
}

function modificar_usuario(){
    var vacio = "Este campo se encuentra vacio";
    var enviar = true;
        if (document.getElementById('text_ente_usuario').value!==''){
           if(!validar_campo('text_ente_usuario', 'msnj_ente_u', vacio)) enviar=false;
        }else{
           if(!validar_campo('ente_usuario', 'msnj_ente_u', vacio)) enviar=false; 
        }
        if(!validar_campo('cedula_usuario', 'msnj_cedula_u', vacio)) enviar=false;
        if(!validar_campo('nombre_usuario', 'msnj_nombre_u', vacio)) enviar=false;
        if(!validar_campo('apellido_usuario', 'msnj_apellido_u', vacio)) enviar=false;
        if(!validar_campo('correo_usuario', 'msnj_correo_u', vacio)) enviar=false;
        if(!validar_campo('tele_celular_usuario', 'msnj_tele_celular_u', vacio)) enviar=false;
        if(!validar_campo('tele_local_usuario', 'msnj_tele_local_u', vacio)) enviar=false;
        
    if(enviar===true){
        enviar=confirm('\u00BFSeguro(a) que desea guardar la información suministrada?');
    }
    if(enviar===true){
       send_modificar_usuario();
    }
}