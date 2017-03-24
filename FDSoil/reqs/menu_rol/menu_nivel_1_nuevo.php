<?php

session_start();
include_once('../../class/menu.model.php');
$obj = new menu();
$msj=$obj->menuNivel_1_rowSave();
echo $msj;

?>