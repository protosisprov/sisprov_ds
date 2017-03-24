<?php {
    
    session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../packs/xtpl/xtemplate.class.php');
    include_once('../../../FDSoil/class/usuario.model.php');
    $obj = new usuario();
    $obj->validar_session();
    $obj->validarClaveUsuario();
    $xtpl = new XTemplate('view.html');
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('CEDULA', $_SESSION['cedula']);
    
    $xtpl->assign('APP', $_SESSION['app']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $aId['id']=$_SESSION['id_rol'];
    $xtpl->assign('MENU', $obj->menuMake($aId));
    
    
    $msj = $obj->listar_MsjDB();

    while ($row = $obj->extraer_registro($msj)) {

        $xtpl->assign('ID_ROW', $row[0]);
        $xtpl->assign('DESCRIPCION', $row[1]);
        $xtpl->parse('main.ciclo_msj');
    }


    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
