<?php 
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
        include_once('../../../FDSoil/class/menu.model.php');
        $xtpl=new XTemplate('view.html');
	$obj = new menu();
        $xtpl->assign('APP', $_SESSION['app']);
	$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
	$xtpl->assign('USUARIO', $_SESSION['usuario']);
	//$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']);
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
        $xtpl->assign('MENU', $obj->menuMake($aId));
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        $Idm['id']=$_POST['id_n0'];
        $rowOpt_0=$obj->extraer_arreglo($obj->menuNivel_0_idTitulo($Idm));
        $xtpl->assign('ID_OPCION_0', $rowOpt_0[0]);
        $xtpl->assign('DES_OPCION_0', $rowOpt_0[1]);
        if(!empty($_POST['id'])){$aId['id']=$_POST['id'];}else{$aId['id']=0;}
        $rowOpt = $obj->extraer_arreglo($obj->menuNivel_1_RowEdit($aId));
        $xtpl->assign('ID_ROW', $rowOpt[0]);
        $xtpl->assign('ORDEN', $rowOpt[1]);
        $xtpl->assign('OPCION', $rowOpt[2]);
        $xtpl->assign('RUTA', $rowOpt[3]);
                
    	$result = $obj->menuStatusList();
	while ($row = $obj->extraer_arreglo($result)) {
        	$xtpl->assign('ID_STATUS', $row[0]);
	        $xtpl->assign('DES_STATUS', $row[1]);
		if (!empty($_POST)) $xtpl->assign('SELECTED_STATUS', ($rowOpt[4] == $row[1]) ? 'selected' : '');
		$xtpl->parse('main.status');
	}	
        
    	$xtpl->parse('main');
    	$xtpl->out('main');
?>
