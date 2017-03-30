//------- ----- REGISTRO DE USUARIO -------- ---------
function send_guarda_usuario(){
    //alert('reqs/guarda/guardar_cuestionario.php');
    send_ajax('POST','../../reqs/guarda/guardar_usuario.php', 'response_guarda_usuario', construir_usuario());
}

function construir_usuario(){
    var text_ente=document.getElementById('text_ente').value;   
    var ente=document.getElementById('ente').value;   
    var cedula=document.getElementById('nac').value+document.getElementById('cedula').value;
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;
    var correo = document.getElementById('correo').value;
    var tele_celular = document.getElementById('tele_celular').value;
    var tele_local = document.getElementById('tele_local').value;
    var usuario_asig = document.getElementById('usuario_asig').value;
        
    var data = 'ente='+ente+'&text_ente='+text_ente+'&cedula='+cedula+'&nombre='+nombre+'&apellido='+apellido+'&correo='+correo+'&tele_celular='+tele_celular+'&tele_local='+tele_local
    +'&usuario_asig='+usuario_asig; 
   // alert(data); //die();
    return data;
}

function response_guarda_usuario(response){
//    alert(response);
    var mensaje='';
    
    if (response=== 'C'){
        mensaje='Usuario registrado exitosamente!';
    }else{
        mensaje='Existe un problema no fue registrado el usuario, ya que el mismo ya se encuentran registrado.';
    }
    
    alert(mensaje);
    window.location.reload();
}
//------- ----- MODIFICAR USUARIO -------- ---------
function send_modificar_usuario(){
    //alert('reqs/guarda/guardar_cuestionario.php');
    send_ajax('POST','../../reqs/guarda/modificar_usuario.php', 'response_modificar_usuario', construir_usuario_modificar());
}

function construir_usuario_modificar(){
    var text_ente=document.getElementById('text_ente_usuario').value;   
    var ente=document.getElementById('ente_usuario').value;   
    var cedula=document.getElementById('nac_usuario').value+document.getElementById('cedula_usuario').value;
    var nombre = document.getElementById('nombre_usuario').value;
    var apellido = document.getElementById('apellido_usuario').value;
    var correo = document.getElementById('correo_usuario').value;
    var tele_celular = document.getElementById('tele_celular_usuario').value;
    var tele_local = document.getElementById('tele_local_usuario').value;
    var id_usuario_ente = document.getElementById('id_usuario_ente').value;
        
    var data = 'ente='+ente+'&text_ente='+text_ente+'&cedula='+cedula+'&nombre='+nombre+'&apellido='+apellido+'&correo='+correo+'&tele_celular='+tele_celular+'&tele_local='+tele_local
    +'&id_usuario_ente='+id_usuario_ente; 
//    alert(data); //die();
    return data;
}

function response_modificar_usuario(response){
//    alert(response);
    var mensaje='';
    
    if (response=== 'C'){
        mensaje='Usuario modificado exitosamente!';
    }else{
        mensaje='Existe un problema no fue modificado el usuario.';
    }
    
    alert(mensaje);
    window.location.reload();
}


//------- -----BUSCAR USUARIO -------- ---------
function send_buscar_usuario_busqueda(){
    //alert('reqs/mostrar/buscar_usuario_busqueda.php');
    var cadena='';
    ordenar_b="order by cedula asc";
    var ente=document.getElementById('ente_b').value;
    var nac=document.getElementById('nac_b').value;
    var cedula=document.getElementById('cedula_b').value;
    var nombre=document.getElementById('nombre_b').value;
    var apellido=document.getElementById('apellido_b').value;
    var ordenar_b=document.getElementById('ordenar_b').value;
    
    if (ente){  cadena+= " and dependencia="+ente; }
    if (nac){    cadena+= " and cedula like '"+nac+"%'";    }
    if (cedula){    cadena+= " and cedula like '%"+cedula+"%'";    }
    if (nombre){    cadena+= " and nombre ilike '%"+nombre+"%'";    }
    if (apellido){  cadena+= " and apellido ilike '%"+apellido+"%'";    }
//    alert('../../reqs/mostrar/buscar_usuario_busqueda.php?cadena='+encodeURI(cadena)+'&ordenar_b='+ordenar_b);
    send_ajax('GET','../../reqs/mostrar/buscar_usuario_busqueda.php?cadena='+encodeURI(cadena)+'&ordenar_b='+ordenar_b, 'response_buscar_usuario_busqueda', null);
}

function response_buscar_usuario_busqueda(response){
//    alert(response);
    var mensaje='';
    if (response){ 
        document.getElementById('ex_usuario').value="TRUE";
        if (document.getElementById('ex_usuario').value==="TRUE"){
           mostra_div('','mensaje');
        }else{
           mostra_div('mensaje','muestra_usu_act#muestra_usu_d');
        }
        mostra_div('','no_exitoso');
        title_usuarios_act('muestra_usuario');
        llenar_usuarios_act('muestra_usuario',response);

    }else{
        mensaje='No existe conincidencia con el dato suministrado.';
        mostra_div('no_exitoso','');
        document.getElementById('no_exitoso').innerHTML=mensaje;
//        alert(mensaje);
    }
    
}

//ACCIONES SOBRE LOS USUARIOS

function send_acciones_usuario($valor,$id){
   //alert('reqs/guarda/guardar_cuestionario.php');
    send_ajax('POST','../../reqs/guarda/accion_usuario.php', 'response_accion_usuario', construir_accion_usuario($valor,$id));
}

function construir_accion_usuario($valor,$id){
    var data = 'accion='+$valor+'&id='+$id; 
//    alert(data); //die();
    return data;
}

function response_accion_usuario(response){
//    alert(response);
    var mensaje='';
    switch (response){
        case 'E':
            mensaje='Usuario fue desactivado de manera exitosa!';
        break;
        case 'R':
            mensaje='Contraseña del usuario reseteada de manera exitosa!';
        break;
        case 'A':
            mensaje='Usuario activado de manera exitosa!';
        break;
        default :
            mensaje='Existe un problema, ya que el mismo ya se encuentran registrado.';
    }
    
    alert(mensaje);
    window.location.reload();
}

// Descartar cuestionario
 
function send_buscar_usuario($id){
    //alert('reqs/guarda/guardar_cuestionario.php');
    send_ajax('POST','../../reqs/mostrar/buscar_usuario.php?id='+$id, 'response_buscar_usuario', null);
}
    
function response_buscar_usuario(response){
//    alert(response);
    var arreglo = response.split('#');
    var nac=arreglo[2].charAt(0);
    var ce= arreglo[2].substring(1);
    document.getElementById('nac_usuario').value=nac;   
    document.getElementById('cedula_usuario').value=ce;   
    document.getElementById('nombre_usuario').value=arreglo[3];   
    document.getElementById('apellido_usuario').value=arreglo[4];   
    document.getElementById('correo_usuario').value=arreglo[1];   
    document.getElementById('tele_celular_usuario').value=arreglo[5];   
    document.getElementById('tele_local_usuario').value=arreglo[6];     
    document.getElementById('ente_usuario').value=arreglo[7];     
    document.getElementById('id_usuario_ente').value=arreglo[8];     
}

function atras(){
    window.location.reload();
}