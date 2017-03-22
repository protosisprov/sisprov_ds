<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
include_once('../../../FDSoil/class/usuario.model.php');
$xtpl = new XTemplate('view.html');

$xtpl->assign('APP', $_SESSION['app']);
$xtpl->assign('INTERFAZ_1', 'block');
$xtpl->assign('INTERFAZ_2', 'none');
$xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));

$obj = new usuario(); 

$pregunta= $obj->listarPreguntaSeguridad();
while($row = $obj->extraer_arreglo($pregunta)){
    $xtpl->assign('descripcion', $row[1]); 
    $xtpl->parse('main.pregunta');
};

$xtpl->parse('main');
$xtpl->out('main');
?>