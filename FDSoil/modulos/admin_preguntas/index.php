<?php 
	session_start();
	header('Content-type: text/html; charset=utf-8');
        include_once('../../../FDSoil/class/usuario.model.php');
        $obj = new usuario();
        $obj->validar_session();
       	include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
        $xtpl=new XTemplate('view.html');
        $xtpl->assign('APP', $_SESSION['app']);
	$xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
	$xtpl->assign('USUARIO', $_SESSION['usuario']);	//$xtpl->assign('ID_ROL', $_SESSION['id_rol']);
	$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
	$xtpl->assign('CEDULA', $_SESSION['cedula']);
        $xtpl->assign('ID_CBE', $_SESSION['cabeza']);
        $xtpl->assign('ULT', $_SESSION['ultimo']);
        $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
        $aId['id']=$_SESSION['id_rol'];
        $xtpl->assign('MENU', $obj->menuMake($aId));
        
        $result = $obj->listarPreguntaSeguridad();
        
        while ($row = $obj->extraer_registro($result)) {
            $xtpl->assign('ID_PREGUN', $row[0]);
            $xtpl->assign('DES_PREGUN', $row[1]);
            if ($row[2] == "t"){$sta = "true";}
            $xtpl->assign('STA_PREGUN', $sta);
            $xtpl->parse('main.row_preguntas');
        }



$xtpl->parse('main');
    	$xtpl->out('main');
?>
