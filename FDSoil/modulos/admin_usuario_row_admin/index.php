<?php {
    session_start();
    header('content-type: text/html; charset: utf-8');
    //include_once("../../reqs/seniat/buscar_razon_social.php");
    //include_once("../../reqs/seniat/seniat.class.php");
    include_once('../../packs/xtpl/xtemplate.class.php');
    $xtpl = new XTemplate('view.html');
    include_once('../../../FDSoil/class/usuario.model.php');
    $obj = new usuario();
    $obj->validar_session($_SESSION);
    $xtpl->assign('APP', $_SESSION['app']);    
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('CEDULA', $_SESSION['cedula']);    
    $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
    $xtpl->assign('ULT', $_SESSION['ultimo']);
    $aId['id']=$_SESSION['id_rol'];
    $xtpl->assign('MENU', $obj->menuMake($aId)); 
    if (empty($_POST['id'])){
        $_POST['id']= 0;
        $xtpl->assign('ID', $_POST['id']);
    }
    $xtpl->assign('INSER_EDIT',(isset($_POST['id']))?1:0);
    $result = $obj->usuarioRow($_POST);
    $userRow= $obj->extraer_asociativo($result);
//    $obj->seeArray($result);
    $xtpl->assign('ID_USUARIO',$userRow['id']);
    $xtpl->assign('USUARIO_USUARIO',$userRow['usuario']);
    $xtpl->assign('CORREO_USUARIO',$userRow['correo']);
    $xtpl->assign('CEDULA_USUARIO',$userRow['ced']);
    $xtpl->assign('NOMBRE_USUARIO',$userRow['nombre']);
    $xtpl->assign('APELLIDO_USUARIO',$userRow['apellido']);
    $xtpl->assign('CELULAR_USUARIO',$userRow['celular']);
    $xtpl->assign('TELEFONO1_USUARIO',$userRow['telefono1']);
    $xtpl->assign('TELEFONO2_USUARIO',$userRow['telefono2']);
    $xtpl->assign('ID_ROL_USUARIO',$userRow['id_rol']);
    $xtpl->assign('ID_STATUS_USUARIO',$userRow['id_status']);
    $xtpl->assign('ID_DIRECCION',$userRow['dependencia']);
    $xtpl->assign('PREGUNTA_SEGURIDAD_USUARIO',$userRow['pregunta_seguridad']);
    $xtpl->assign('RESPUESTA_SEGURIDAD_USUARIO',$userRow['respuesta_seguridad']);    
    
    $result = $obj->rolList();    
    while ($row = $obj->extraer_registro($result)) {
//        $obj->seeArray($row);
        $xtpl->assign('ID_ROL_USUARIO', $row[0]);
        $xtpl->assign('DES_ROL_USUARIO', $row[1]);
        if (isset($_POST['id'])) $xtpl->assign('VAL_ROL_USUARIO', ($userRow['id_rol'] == $row[0]) ? 'selected' : '');
        $xtpl->parse('main.row_rol');
    }      
    $result = $obj->listarPreguntaSeguridad();    
    while ($row = $obj->extraer_asociativo($result)) {
        $xtpl->assign('PREGUNTA', $row['descripcion']);
        if (isset($_POST['id'])) $xtpl->assign('PREGUNTA_SELECTED', ($userRow['pregunta_seguridad'] == $row['descripcion']) ? 'selected' : '');
        $xtpl->parse('main.row');
    }     
    $result = $obj->menuStatusList();     
    while ($row = $obj->extraer_registro($result)) {
        $xtpl->assign('ID_STATUS', $row[0]);
        $xtpl->assign('DES_STATUS', $row[1]);
        if (isset($_POST['id'])) $xtpl->assign('VAL_STATUS', ($userRow['id_status'] == $row[0]) ? 'selected' : '');
        $xtpl->parse('main.row_status');
    }

    $result = $obj->listar_direccion();
    while ($row = $obj->extraer_asociativo($result)){
        $xtpl->assign('ID_DIRECCION', $row['id_oficina']); 
        $xtpl->assign('NOMBRE_DIRECCION', $row['nombre']); 
//        echo "prueba-->>>".$userRow['dependencia']. "==" .$row['id_oficina']."<br>";
        if (isset($_POST['id'])) $xtpl->assign('ID_DIRECCION', ($userRow['dependencia'] == $row['id_oficina']) ? 'selected' : '');
        $xtpl->parse('main.oficina');
    }

    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
