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