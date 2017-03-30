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
	$xtpl->assign('USUARIO', $_SESSION['usuario']);	//$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']);
//        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('MENU', $obj->menuMake($aId));
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    	$result = $obj->menuNivel_0_list();
    	while ($row = $obj->extraer_arreglo($result)){
		$xtpl->assign('ID_ROW', $row[0]);
		$xtpl->assign('ORDEN', $row[1]);
	      	$xtpl->assign('OPCION', $row[2]);
	      	$xtpl->assign('RUTA', $row[3]);
	      	$xtpl->assign('STATUS', $row[4]);
	      	$xtpl->parse('main.rows');
    }
    $xtpl->parse('main');
    $xtpl->out('main');
}
?>
