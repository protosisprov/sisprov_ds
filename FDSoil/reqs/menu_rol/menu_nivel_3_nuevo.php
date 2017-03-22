<?php

session_start();
include_once('../../class/menu.model.php');
$obj = new menu();
$msj=$obj->menuNivel_3_RowSave();
echo $msj;

?>