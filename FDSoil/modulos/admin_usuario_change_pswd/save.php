<?php
    session_start();
    unset($_POST['clave1']);
    unset($_POST['clave2']);
    include_once('../../../FDSoil/class/usuario.model.php');
    $obj = new usuario();
    $msj=$obj->usuarioChangePswd();
    $_SESSION['dp']='../../../FDSoil/modulos/admin_inicio';
    header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj");    
?>
