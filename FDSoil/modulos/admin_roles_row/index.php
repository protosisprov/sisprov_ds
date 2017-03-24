<?php 
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include_once('../../packs/xtpl/xtemplate.class.php');
        include_once('../../class/roles.model.php');
        $xtpl=new XTemplate('view.html');
        $xtpl->assign('APP', $_SESSION['app']);
	$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
	$xtpl->assign('USUARIO', $_SESSION['usuario']);
	$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']); 
	$obj = new rol();  
	$obj->validar_session($_SESSION);
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('MENU', $obj->menuMake($aId));
        $xtpl->assign('OPT_MENU', $obj->menuOptMake()); 
        $xtpl->assign('ID', (isset($_POST['id']))?$_POST['id']:0);
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        $rowRol=$obj->rolRow();
        $xtpl->assign('ROL_NAME', $rowRol[0]); 
	$xtpl->assign('ROL_OPT', $obj->rolOpt());  
	$result = $obj->menuStatusList();
	while ($row = $obj->extraer_arreglo($result)) {
        	$xtpl->assign('ID_STATUS', $row[0]);
	        $xtpl->assign('DES_STATUS', $row[1]);
		if (!empty($_POST)) $xtpl->assign('SELECTED_STATUS', ($rowRol[1] == $row[0]) ? 'selected' : '');
		$xtpl->parse('main.status');
	}
    	$xtpl->parse('main');
    	$xtpl->out('main');
?>
