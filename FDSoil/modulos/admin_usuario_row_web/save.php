<?php {
    session_start();
    header('content-type: text/html; charset: utf-8');
    $Post['cedula'] = $_POST['nacionalidad'] . $_POST['cedula'];
    $Post['nombre'] = $_POST['nombres'];
    $Post['apellido'] = $_POST['apellidos'];
    $Post['correo'] = $_POST['correo'];
    $Post['celular'] = $_POST['celular'];
    $Post['telefono1'] = $_POST['telefono1'];
    $Post['telefono2'] = $_POST['telefono2'];
    $Post['usuario'] = $_POST['usuario'];
    $Post['clave'] = md5($_POST['clave']);
    $Post['clave_simple'] = $_POST['clave'];
    $Post['pregunta_seguridad'] = $_POST['pregunta_seguridad'];
    $Post['respuesta_seguridad'] = $_POST['respuesta_seguridad'];
    include_once("../../../".$_SESSION['app']."/config/rol.php");
    $Post['id_rol'] = $rol['id_rol'];
    $Post['id_status'] = $rol['id_status']; 
    print_r($_POST); die;
    include_once("../../class/usuario.model.php");
    $obj = new usuario();
    $msj = $obj->registrarUsuarioWeb($Post);
    header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj&np=2");
}
?>
