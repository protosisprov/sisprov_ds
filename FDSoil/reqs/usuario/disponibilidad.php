<?php
session_start();
include_once('../../class/usuario.model.php');
$obj= new usuario(); 
echo $obj->comprobarDisponibilidad($_GET);
?>