<?php session_start();
header('content-type: text/html; charset: utf-8');
include_once('../../class/mapa_model.php');
$obj = new mapa();
echo $obj->resultToString($obj->mostrar_desarrollo_parroquia($_GET),'#','¬');
?>
