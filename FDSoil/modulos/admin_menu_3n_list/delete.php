<?php
session_start();
include_once('../../class/menu.model.php');
$obj = new menu();
$msj=$obj->menuNivel_3_RowDelete();
header("Location: ../../../FDSoil/modulos/admin_msj/index.php?msj=$msj&np=1");
?>
