<?php
session_start();
include_once('../../../FDSoil/class/roles.model.php');
$obj = new rol();
$msj = $obj->rolRegister();
header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj&np=2");
?>