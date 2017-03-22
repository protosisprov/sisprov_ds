function inicio(){
    if (validateTheBrowser()){ 
        var obj=new app();
        id_sistema(obj.name, obj.enterow, obj.carpeta);
        id_acceso(obj.email,obj.telefon,obj.webUserRow);
        
        var app_s= document.getElementById('app_w');
        
        if (app_s.value==='censo_vivienda'){
            document.getElementById('censo').style.display='block';
            document.getElementById('defecto').style.display='none';
        }
        
        cuenta_semaforo();
        loginType(obj.loginType);   
        loginOptOnOff();
        webUserRow(obj.webUserRow);
    }
    else{
        window.location = "../../../FDSoil/modulos/admin_update_the_browser";
    }
}

function cuenta_semaforo() {
    var semaforo = document.getElementById('semaforo').value;
    if (semaforo < 2) {
        document.getElementById('div_captcha').style.display = "none";
    } else {
        document.getElementById('div_captcha').style.display = "block";
    }
}

function loginType(vector){
    document.getElementById('id_opcion').value=vector[0];
    document.getElementById('id_login_type').style.display=vector[1];
}

function acceso_route(){
    var obj=new app();
    window.location.href=obj.strRoute;
}

function webUserRow(vector){
    document.getElementById('div_webUserRow').style.display = vector[0];
    document.getElementById('id_register').style.display = vector[1];
    document.getElementById('id_recover_password').style.display = vector[2];
}

function validarForm() {
    var respond = false;
    var idCombo=document.getElementById('id_opcion');
    var idRif=document.getElementById('id_rif2');
    var idCedula=document.getElementById('id_cedula');
    var idEmail=document.getElementById('id_correo');
    var idUsuario=document.getElementById('id_user');    
    var idError = document.getElementById('id_msj_error');
    var idClave = document.getElementById('id_clave');
    if (idCombo.value == 1)
        if (idRif.value == '')
            idError.innerHTML = 'Debe insertar Número de Rif';
        else if (idClave.value == '')
            idError.innerHTML = 'Debe insertar Contraseña';
        else
            respond = true;
    else if (idCombo.value == 2)
        if (idCedula.value == '')
            idError.innerHTML = 'Debe insertar Cédula';
        else if (idClave.value == '')
            idError.innerHTML = 'Debe insertar Contraseña';
        else
            respond = true;
    else if (idCombo.value == 3)
        if (idEmail.value == '')
            idError.innerHTML = 'Debe insertar Correo';
        else if (idClave.value == '')
            idError.innerHTML = 'Debe insertar Contraseña';
        else
            respond = true;
    else if (idCombo.value == 4)
        if (idUsuario.value == '')
            idError.innerHTML = 'Debe insertar Usuario';
        else if (idClave.value == '')
            idError.innerHTML = 'Debe insertar Contraseña';
        else
            respond = true;
    if (respond)
        
        document.forms[0].submit();
    else
        return respond;
}

function loginOptOnOff(){ 
    if (document.getElementById('div_login').style.display ='none')
        document.getElementById('div_login').style.display ='block';   
    if (document.getElementById('id_opcion').value==0){  
        document.getElementById('div_rif').style.display = 'none';
        document.getElementById('div_ced').style.display = 'none';
        document.getElementById('div_mail').style.display = 'none';
        document.getElementById('div_user_name').style.display ='none';
        document.getElementById('div_login').style.display ='none'; 
    } 
    else if (document.getElementById('id_opcion').value==1){  
        document.getElementById('div_rif').style.display = 'block';
        document.getElementById('div_ced').style.display = 'none';
        document.getElementById('div_mail').style.display = 'none';
        document.getElementById('div_user_name').style.display ='none';
    }
    else if (document.getElementById('id_opcion').value==2){
        document.getElementById('div_rif').style.display = 'none';
        document.getElementById('div_ced').style.display = 'block';
        document.getElementById('div_mail').style.display = 'none';
        document.getElementById('div_user_name').style.display ='none';
    }
    else if (document.getElementById('id_opcion').value==3){
        document.getElementById('div_rif').style.display = 'none';
        document.getElementById('div_ced').style.display = 'none';
        document.getElementById('div_mail').style.display = 'block';
        document.getElementById('div_user_name').style.display ='none';
    }
    else if (document.getElementById('id_opcion').value==4){
        document.getElementById('div_rif').style.display = 'none';
        document.getElementById('div_ced').style.display = 'none';
        document.getElementById('div_mail').style.display = 'none';
        document.getElementById('div_user_name').style.display ='block';
    }
}

function accesoEnter(cod,e){    
    if(cod!='' && pressTheEnterKey(e))                
        validarForm();    
} 
