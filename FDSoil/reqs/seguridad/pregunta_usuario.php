<?php
session_start();
include_once('../../../FDSoil/class/usuario.model.php');
$obj= new usuario();
echo $obj->preguntaSecreta($_GET);
?>