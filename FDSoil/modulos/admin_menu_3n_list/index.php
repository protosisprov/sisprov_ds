<?php {
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include_once('../../packs/xtpl/xtemplate.class.php');
        include_once('../../class/menu.model.php');
	$obj = new menu();
	$obj->validar_session($_SESSION);
	$xtpl = new XTemplate('view.html');
        $xtpl->assign('APP', $_SESSION['app']);
	$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
	$xtpl->assign('USUARIO', $_SESSION['usuario']);//$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']);
        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('MENU', $obj->menuMake($aId));
	$result = $obj->menuNivel_0_combo();
	while ($row = $obj->extraer_arreglo($result)) {
        	$xtpl->assign('ID_MENU_0', $row[0]);
	        $xtpl->assign('DES_MENU_0', $row[1]);		
		$xtpl->parse('main.menu_0');
	}    	
    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
