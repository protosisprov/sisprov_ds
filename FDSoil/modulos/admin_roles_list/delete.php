<?php
session_start();
include_once('../../../FDSoil/class/roles.model.php');
$obj = new rol();
$msj = $obj->rolDelete();
header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj&np=1");
?>