<?php
session_start();
include_once('../../class/menu.model.php');
$obj= new menu(); 
echo $obj->resultToString($obj->menuNivel_3_list_tabla($_GET),'|',"¬");
?>
