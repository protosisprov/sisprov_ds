function inicio(){
    var obj=new app();
    id_sistema(obj.name);
}


function validar_formulario(){
        
    var respuesta = document.getElementById('id_respuesta').value
    var pregunta = document.getElementById('pregunta').value
    var id_user = document.getElementById('id_user').value
    var correo = document.getElementById('correo').value
    var id_clave = document.getElementById('id_clave').value
    var id_clave2 = document.getElementById('id_clave2').value
    var id_respuesta = document.getElementById('id_respuesta').value
    
    if ((respuesta != "") && (pregunta != "") && (id_user != "") && (correo != "") && (id_clave != "") && (id_clave2 != "") && (id_respuesta != "")) {
        if (id_clave===id_clave2) {
            send_reset();
        } else {
            alert("Contraseñas no coinciden");
        }
    }else{
        alert("Faltan Campos Claves");
    }
    
}
