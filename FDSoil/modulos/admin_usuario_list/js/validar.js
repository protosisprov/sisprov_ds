function inicio(strArrayMenu) {
    menu(strArrayMenu);
    var obj=new app();
    id_sistema(obj.name);
    jQryTableRefresh('tablaRows');
}

function toogle(a,b,c)
{
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
}

function toogle_cerrar(a,b,c)
{
  document.getElementById(b).style.display=a;
  document.getElementById(c).style.display=a;
  window.location.reload();
}

function val_envio(){

   var enviar = true;    
    if(!validar_campo('id_cedula', 'div_cedula', 'Debe llenar el Número de Cedula.')) enviar=false;
    if(!validar_campo('id_nombres', 'div_nombre', 'Debe llenar Nombre.')) enviar=false;
    if(!validar_campo('id_apellidos', 'div_apellido', 'Debe llenar Apellido.')) enviar=false;
    if(!validar_campo('id_correo', 'div_correo', 'Debe llenar Correo Electrónico.'))enviar=false;
    if(!validar_campo('id_celular', 'div_celular', 'Debe ingresar el numero de Celular.')) enviar=false;
    if(!validar_campo('id_telefono1', 'div_telefono1', 'Debe ingresar el numero de Telefono Local.')) enviar=false;
    if(!validar_campo('id_usuario', 'div_usuario', 'Debe llenar el Nombre de Usuario.')) enviar=false;
    if(!validar_campo('id_clave', 'div_clave', 'Debe ingresar la Clave.')) enviar=false;
    if(!validar_campo('id_clave2', 'div_clave2', 'Debe ingresar la confirmación de la Clave.')) enviar=false;
    if(!validar_compo('id_pregunta', 'div_pregunta', 'Debe selecionar una Pregunta de Seguridad.')) enviar=false;
    if(!validar_campo('id_respuesta', 'div_respuesta', 'Debe llenar la Respuesta a la Pregunta de Seguridad.')) enviar=false;
   
    if (enviar==true) document.forms[0].submit();    
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
        document.getElementById('div_clave').innerHTML='Debe estar conformada por letras, números, caracteres especiales y el largo debe ser de 6 a 10 dígitos';   
    else
        document.getElementById('div_clave').innerHTML='';   
}