<?php
session_start();
include_once('../../../FDSoil/class/usuario.model.php');
$obj = new usuario();
$resp=$obj->usuarioResetKey();
header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$resp&np=1");
?>

