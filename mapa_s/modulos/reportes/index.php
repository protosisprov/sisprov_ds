<?php
session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
    include_once('../../class/unidad_model.php');
    $xtpl = new XTemplate('view.html');
    $xtpl->assign('APP', $_SESSION['app']);
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('ULT', $_SESSION['ultimo']);
    $aId['id']=$_SESSION['id_rol'];
    $obj = new unidad(); // Se invoca la clase a ser utilizada.
    $xtpl->assign('MENU', $obj->menuMake($aId));
    $obj->validar_session($_SESSION);    
    
    //Nuevas funciones para validar el listado de las unidades
    /*----------------LISTADO UNIDADES REGISTRADAS----------------*/

        
    $xtpl->parse('main');
    $xtpl->out('main');
?>