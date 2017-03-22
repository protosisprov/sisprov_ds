<?php {
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include_once('../../packs/xtpl/xtemplate.class.php');
        include_once('../../class/usuario.model.php');
	$obj = new usuario();
	$obj->validar_session($_SESSION);
	$xtpl = new XTemplate('view.html');
        $xtpl->assign('APP', $_SESSION['app']);
	$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
	$xtpl->assign('USUARIO', $_SESSION['usuario']);	
        //$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']);
        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('MENU', $obj->menuMake($aId));
        
        $result = $obj->rolList();    
    while ($row = $obj->extraer_registro($result)) {
        $xtpl->assign('ID_ROL_USUARIO', $row[0]);
        $xtpl->assign('DES_ROL_USUARIO', $row[1]);
        if (isset($_POST['id'])) $xtpl->assign('VAL_ROL_USUARIO', ($userRow['id_rol'] == $row[0]) ? 'selected' : '');
        $xtpl->parse('main.row_rol');
    }      
    $result = $obj->listarPreguntaSeguridad();    
    while ($row = $obj->extraer_asociativo($result)) {
//        $obj->seeArray($row);
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
    $result = $obj->usuarioList();
    	while ($row = $obj->extraer_registro($result)){
		$xtpl->assign('ID_USUARIO', $row[0]);
		$xtpl->assign('CEDULA', $row[1]);
                $xtpl->assign('NOMBRE', $row[2]);
	      	$xtpl->assign('APELLIDO', $row[3]);
	      	$xtpl->assign('USUARIO', $row[4]);
	      	$xtpl->assign('CORREO', $row[5]);
                $xtpl->assign('PERFIL', $row[6]);
                $xtpl->assign('STATUS', $row[7]);
          	$xtpl->parse('main.rows');
    }
    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
