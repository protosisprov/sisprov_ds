function send_cedula( nac, num){
    send_ajax('GET', "../../reqs/saime/buscar_ci.php?nac="+nac+"&num="+num, 'response_cedula', null,null);
}
function response_cedula(response){   
   
    var arreglo = response.split(',');
    document.getElementById("id_nombres").value = arreglo[1].replace(/^\s*|\s*$/g,"");	
    document.getElementById("id_apellidos").value = arreglo[0].replace(/^\s*|\s*$/g,"");
}
function send_usuario(usu){
    send_ajax('GET', "../../reqs/usuario/disponibilidad.php?usuario="+usu, 'response_usuario', null,null);
}
function response_usuario(response){   
    if(response=='t') {
        document.getElementById("div_usuario").innerHTML ="";
    }else if(response=='f'){
        document.getElementById("div_usuario").innerHTML ="Este nombre ya esta siendo usado por otra persona ";   
        document.getElementById("id_usuario").focus();
    }    
}
function send_guarda_userweb(){
    //alert('../../reqs/guardaDat/guardaPlan.php');
    document.getElementById('img_guardando').style.visibility ="visible";
    send_ajax('POST','../../reqs/usuario/guarda_userweb.php','respondeuserweb', contruiruserweb());
}

function contruiruserweb(){
    var nacio       = document.getElementById('id_nacionalidad').value;
    var id_rol      = document.getElementById('id_rol').value;
    var id_status   = document.getElementById('id_status').value;
    var cedula      = nacio + document.getElementById('id_cedula').value;
    var nombre      = document.getElementById('id_nombres').value;
    var apellido    = document.getElementById('id_apellidos').value;
    var correo      = document.getElementById('id_correo').value;
    var celular     = document.getElementById('id_celular').value;
    var telefono1   = document.getElementById('id_telefono1').value;
    var telefono2   = document.getElementById('id_telefono2').value;
    if (telefono2 == "") telefono2 = 0;
    var usuario     = document.getElementById('id_usuario').value;
    var clave       = document.getElementById('id_clave2').value;
    var pregunta_seguridad  = document.getElementById('id_pregunta').value;
    var respuesta_seguridad  = document.getElementById('id_respuesta').value;
    
    var data = 'usuario='+usuario+'&correo='+correo+'&cedula='+cedula+'&clave='+clave+
               '&nombre='+nombre+'&apellido='+apellido+'&celular='+celular+
               '&telefono1='+telefono1+'&telefono2='+telefono2+'&id_rol='+id_rol+
               '&id_status='+id_status+'&pregunta_seguridad='+pregunta_seguridad+
               '&respuesta_seguridad='+respuesta_seguridad;
    //alert(data);
    return data;
}
function respondeuserweb(response){
//alert(response);
    if (response == 'C'){
        var usuario=document.getElementById('id_usuario').value;
        document.getElementById('img_guardando').style.visibility = 'hidden';
        alert('Registro Guardado Con Éxito. \n       Usuario asignado:'+ usuario);
//        window.location.replace("../admin_acceso/");
//        window.location.reload();
        
        var ruta = "../admin_acceso"
    window.location.href = ruta;
    }
    else 
    {
        alert('Error: El número de cédula ingresado ya se encuentra registrado en el sistema');
        window.location.reload();
    }
}


function send_verificar_userweb(){
    //alert('../../reqs/guardaDat/guardaPlan.php');
    document.getElementById('img_guardando').style.visibility ="visible";
    send_ajax('POST','../../reqs/usuario/verificar_userweb.php','responde_verificaruserweb', contruirverificarweb());
}

function contruirverificarweb(){
    var usuario = document.getElementById('id_usuario').value;
    
    var data = 'usuario='+usuario;
    //alert(data);
    return data;
}

function responde_verificaruserweb(response){
    //alert(response);
    var valor="1";
    if (response == 't'){
        document.getElementById('img_guardando').style.visibility = 'hidden';
        var usuario=document.getElementById('id_usuario');
        usuario.value=usuario.value+valor;
//        window.location.replace("../admin_acceso/");
        send_verificar_userweb();
    }
    else 
    {
        send_guarda_userweb();
    }
}