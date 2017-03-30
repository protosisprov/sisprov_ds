<?php {
    session_start();
    header('content-type: text/html; charset: utf-8');
    include_once("../../reqs/seniat/buscar_razon_social.php");
    include_once("../../reqs/seniat/seniat.class.php");
    include_once('../../packs/xtpl/xtemplate.class.php');
    include_once('../../class/usuario.model.php');
    $xtpl = new XTemplate('view.html');
    $xtpl->assign('APP', $_SESSION['app']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $obj = new usuario();
    $result = $obj->listarPreguntaSeguridad();    
    while ($row = $obj->extraer_asociativo($result)) {
        $xtpl->assign('PREGUNTA', $row['descripcion']);
        $xtpl->parse('main.row');
    }    
    include_once("../../../".$_SESSION['app']."/config/rol.php");
    $xtpl->assign('ROL', $rol['id_rol']);
    $xtpl->assign('STATUS', $rol['id_status']);
    $xtpl->assign('LOGO_SY', $_SESSION['logo_sy']);
    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
