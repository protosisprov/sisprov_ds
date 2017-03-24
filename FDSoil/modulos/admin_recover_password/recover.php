<?php
session_start();
header('Content-type: text/html; charset=utf-8');
//include_once('../../../FDSoil/packs/email/send_email.php');
include_once('../../../FDSoil/class/usuario.model.php');
$obj = new usuario();

echo $obj->resetContrasenia($_POST);
/*$Post['cedula'] = $_POST['inicial'] . $_POST['cedula'];
$Post['correo'] = $_POST['correo'];
$Post['respuesta'] = $_POST['respuesta'];
$nueva_clave=$obj->randomString(8,true,true,true,true); 
$resultado = $obj->consultarUsuario($Post);
while ($row = $obj->extraer_arreglo($resultado)) {

    if ($row[6] == $Post['respuesta']) {
        $nombre=$row[3] . " " . $row[4];
        $usuario=$row[0];
        $email_destino=$Post['correo'];
        $tipo_mensaje='msj_recuperacion';
        $Post['clave'] = md5($nueva_clave);
        $Post['id']=$row[7];
        $obj->recoverPassWord($Post);
        
        correo_enviar($nombre,$usuario,$nueva_clave,$email_destino,$tipo_mensaje);
        //header("Location: ../../../FDSoil/packs/msj/index.php?msj=4&np=2");
        header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=D&np=2");
    }else{
        //header("Location: ../../../FDSoil/packs/msj/index.php?msj=93&np=2");
        header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=V&np=2");
    }
}*/
?>
