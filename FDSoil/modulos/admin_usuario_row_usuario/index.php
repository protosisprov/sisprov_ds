<?php {
    session_start();
    header('content-type: text/html; charset: utf-8');
    include_once('../../packs/xtpl/xtemplate.class.php');
    $xtpl = new XTemplate('view.html');
    include_once('../../../FDSoil/class/usuario.model.php');
    $obj = new usuario();
    $obj->validar_session($_SESSION);
    $xtpl->assign('APP', $_SESSION['app']);    
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);	//$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('CEDULA', $_SESSION['cedula']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $aId['id']=$_SESSION['id_rol'];
    $xtpl->assign('MENU', $obj->menuMake($aId)); 
    $xtpl->assign('ID', $_SESSION['id_usuario']);
    $xtpl->assign('INSER_EDIT',1); 
    $aId['id']=$_SESSION['id_usuario'];
    $result = $obj->usuarioRow( $aId);
    $userRow=$obj->extraer_asociativo($result);    
    $xtpl->assign('ID_USUARIO',$userRow['id']);
    $xtpl->assign('USUARIO_USUARIO',$userRow['usuario']);
    $xtpl->assign('CORREO_USUARIO',$userRow['correo']);
    $xtpl->assign('CEDULA_USUARIO',$userRow['cedula']);
    $xtpl->assign('NOMBRE_USUARIO',$userRow['nombre']);
    $xtpl->assign('APELLIDO_USUARIO',$userRow['apellido']);
    $xtpl->assign('CELULAR_USUARIO',$userRow['celular']);
    $xtpl->assign('TELEFONO1_USUARIO',$userRow['telefono1']);
    $xtpl->assign('TELEFONO2_USUARIO',$userRow['telefono2']);
    $xtpl->assign('ID_ROL_USUARIO',$userRow['id_rol']);
    $xtpl->assign('ID_STATUS_USUARIO',$userRow['id_status']);
    $xtpl->assign('PREGUNTA_SEGURIDAD_USUARIO',$userRow['pregunta_seguridad']);
    $xtpl->assign('RESPUESTA_SEGURIDAD_USUARIO',$userRow['respuesta_seguridad']);
    
    $result = $obj->listarPreguntaSeguridad();    
    while ($row = $obj->extraer_asociativo($result)) {
        $xtpl->assign('PREGUNTA', $row['descripcion']);
        if (isset($_SESSION['id_usuario'])) $xtpl->assign('PREGUNTA_SELECTED', ($userRow['pregunta_seguridad'] == $row['descripcion']) ? 'selected' : '');
        $xtpl->parse('main.row');
    }
    
    
    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
