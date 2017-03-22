var intento = 0;
function send_pregunta(){
    var inicial = document.getElementById('id_inicial').value;
    var complemento = document.getElementById('id_cedula').value;
    var correo = document.getElementById('id_correo').value;
    var cedula = inicial+complemento;
   
    if(complemento != "" && correo != "" ){
     
        send_ajax('GET','../../reqs/seguridad/pregunta_usuario.php?cedula='+cedula+'&correo='+correo+'', 'response_validacion', null);   
    }else{
        alert("Por favor complete todo los campos");
    } 
}

function response_validacion(response){
  
    if(response){
        document.getElementById('interfaz_2').style.display = 'block';
        document.getElementById('interfaz_1').style.display = 'none';
        document.getElementById('id_pregunta').value = response;
        document.getElementById('id_respuesta').focus();
    }else{
        alert("la informacion del usuario no existe");
    }
}
/***************************************************************************************************************/
function send_reset() {
    //   alert('../../reqs/guarda/guardar_demoras.php');
    send_ajax('POST','recover.php', 'response_send_reset', construir_reset());
}

function construir_reset() {
    var correo = document.getElementById('correo').value
    var id_user = document.getElementById('id_user').value
    var pregunta = document.getElementById('pregunta').value
    var clave = document.getElementById('id_clave').value
    var respuesta = document.getElementById('id_respuesta').value
    
    var data = 'correo='+correo+'&id_user='+id_user+'&pregunta='+pregunta+
    '&clave='+clave+'&respuesta='+respuesta;
   // alert(data);
    return data;
}

function response_send_reset(response){
//    alert (response);return;
    if (response === 'C'){
//        document.getElementById('img_guardando').style.visibility = 'hidden';
        alert('Registro Guardado Con Exito');
        window.location.href = "../admin_acceso/";
    }else{
        intento++;
        alert('Error, Datos Incorrectos');
        if (intento==3) {
            window.location.reload();
        }
    }
}