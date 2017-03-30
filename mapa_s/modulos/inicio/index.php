<?php
session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
    include_once('../../class/movilizacion_model.php');
    $xtpl = new XTemplate('view.html');
    $xtpl->assign('APP', $_SESSION['app']);
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('ROL', $_SESSION['id_rol']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('ULT', $_SESSION['ultimo']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $aId['id']=$_SESSION['id_rol'];
    echo ($aId['id']);

    switch ($aId['id']){
        case '1':
            header('Location:/mapa/modulos/variables');
 //           header('Location:/movilizacion/modulos/movilizacion');
            break;
        case '3':
            header('Location:/mapa/modulos/variables');
 //           header('Location:/movilizacion/modulos/movilizacion');
            break;
        case '4':
            header('Location:/mapa/modulos/mapa');
            break;
        default:
            header('Location:/mapa/modulos/adm_usuario');
            break;
    }