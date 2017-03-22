<?php
session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
    include_once('../../class/usuarios_model.php');
    $xtpl = new XTemplate('view.html');
//    print_r($_SESSION);
    $xtpl->assign('APP', $_SESSION['app']);
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('ROL', $_SESSION['id_rol']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('ULT', $_SESSION['ultimo']);
//    $xtpl->assign('DEPEN', $_SESSION['dependencia']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $aId['id']=$_SESSION['id_rol'];
    $xtpl->assign('fecha', date('Y-m-d'));
    $xtpl->assign('fechaActual', date('d-m-Y'));
    $xtpl->assign('Year', date('Y'));

    $obj = new usuario(); // Se invoca la clase a ser utilizada.
    $xtpl->assign('MENU', $obj->menuMake($aId));
    $obj->validar_session($_SESSION);    
    //echo $client = @$_SERVER['HTTP_CLIENT_IP'];
    //echo  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $xtpl->assign('IP', $_SERVER['REMOTE_ADDR']);
    
    //Verificacion de usuarios desactivados
    $usua_desact= $obj->mostrar_usuarios_desactivos();
    $i=1;
    while($row = $obj->extraer_arreglo($usua_desact)){
        $xtpl->assign('muestra', $i++); 
        $xtpl->assign('id', $row[0]); 
        $xtpl->assign('nombre', $row[1]); 
        $xtpl->assign('cedula', $row[2]); 
        $xtpl->assign('usuario', $row[3]); 
        $xtpl->assign('correo', $row[4]); 
        $xtpl->assign('num', $row[5]); 
        $xtpl->assign('ente', $row[6]); 
        $xtpl->assign('ex_usuariod', "TRUE"); 
        $xtpl->parse('main.desac_usuario');
    };
    
    $entes= $obj->listar_entes();
        while($row = $obj->extraer_arreglo($entes)){
            $xtpl->assign('id', $row[0]); 
            $xtpl->assign('nombre', $row[1]); 
            $xtpl->parse('main.entes');
            $xtpl->parse('main.entes1');
        };
        
    $xtpl->assign('id_rol', $_SESSION['id_rol']);
    $xtpl->parse('main.idrol'); 
       
    $xtpl->parse('main');
    $xtpl->out('main');