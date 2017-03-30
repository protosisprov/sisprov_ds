<?php {
session_start();
header('Content-type: text/html; charset=utf-8');
include_once('../../packs/xtpl/xtemplate.class.php');
include_once('../../class/roles.model.php');
$obj = new rol();
$obj->validar_session($_SESSION);
$xtpl = new XTemplate('view.html');
$xtpl->assign('APP', $_SESSION['app']); 
$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
$xtpl->assign('USUARIO', $_SESSION['usuario']);
$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
$xtpl->assign('ULT', $_SESSION['ultimo']);
$xtpl->assign('ID_CBE', $_SESSION['cabeza']);
$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
$xtpl->assign('CEDULA', $_SESSION['cedula']);
$xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
$aId['id']=$_SESSION['id_rol'];
$xtpl->assign('MENU', $obj->menuMake($aId));
$result = $obj->rolList();
while ($row = $obj->extraer_arreglo($result)){
    $xtpl->assign('ID_ROW', $row[0]);
    $xtpl->assign('DESCRIPCION', $row[1]);
    $xtpl->parse('main.rows');
}
$xtpl->parse('main');
$xtpl->out('main');
}
?>
