<?php
session_start();
include_once('../../class/menu.model.php');
$obj= new menu(); 
echo $obj->resultToString($obj->menuNivel_2_list_tabla($_GET),'|',"¬");
?>
