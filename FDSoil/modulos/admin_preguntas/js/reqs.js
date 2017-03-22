function sendValPswdOld() {

    send_ajax('POST', "../../reqs/usuario/val_pswd_old.php", "responseValPswdOld", contruir_Valpsold());
}
function contruir_Valpsold() {

    var id_usuario = document.getElementById('id_usuario').value;
    var pass = document.getElementById('id_clave1').value;
    var clave = calcMD5(pass);

    var data = "usuario=" + id_usuario + "&clave=" + clave;
    //alert(data);
    return  data;
}
function responseValPswdOld(response) {
    //alert(response);
    if (response == 0) {
        document.getElementById('div_clave1').innerHTML = "La clave está errada..";
        //document.getElementById("id_clave1").focus();
    } else if (response == 1) {
        document.getElementById('div_clave1').innerHTML = "";
        //document.getElementById("id_clave2").focus();
    }
}
function send_change_pass() {

    send_ajax('POST', "../../reqs/usuario/change_contraseña.php", "response_change_pass", contruir_change_pass());
}
function contruir_change_pass() {

    var id_usuario = document.getElementById('id_usuario').value;
    
    var pass = document.getElementById('id_clave3').value;
    
    var clave = calcMD5(pass);

    var data = "usuario=" + id_usuario + "&clave=" + clave;
//    alert(data);
    return  data;
}
function response_change_pass(response) {
    //alert(response);
    if (response === 'A')
     {
        alert('EL REGISTRO FUÉ ACTUALIZADO CON ÉXITO');
        window.location.reload();
     }
    else if (response === 'Z')
    {
        alert('ERROR ACTUALIZANDO REGISTRO');
        window.location.reload();
    }
}
