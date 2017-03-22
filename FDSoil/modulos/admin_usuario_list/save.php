<?php {
    session_start();
    header('content-type: text/html; charset: utf-8');

    $Post['id'] = $_POST['id_usuario'];
    $Post['cedula'] = $_POST['nacionalidad'] . $_POST['cedula'];
    $Post['nombre'] = $_POST['nombres'];
    $Post['apellido'] = $_POST['apellidos'];
    $Post['correo'] = $_POST['correo'];
    $Post['celular'] = $_POST['celular'];
    $Post['telefono1'] = $_POST['telefono1'];
    $Post['telefono2'] = $_POST['telefono2'];
    $Post['usuario'] = $_POST['usuario'];
    $Post['clave']=($_POST['clave']!='')?md5($_POST['clave']):'';
    $Post['pregunta_seguridad'] = $_POST['pregunta_seguridad'];
    $Post['respuesta_seguridad'] = $_POST['respuesta_seguridad'];
    $Post['id_rol'] =  $_POST['rol_usuario'];
    $Post['id_status'] = $_POST['status']; 
    
    
    
    
    include_once("../../class/usuario.model.php");
    $obj = new usuario();
    //$obj->seeArray($_POST);
    $msj = $obj->registrarUsuario($Post);

    header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj&np=2");
    
}
?>

