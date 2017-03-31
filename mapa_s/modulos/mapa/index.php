<?php
session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../../FDSoil/packs/xtpl/xtemplate.class.php');
    include_once('../../class/mapa_model.php');
    $xtpl = new XTemplate('view.html');
//    print_r($_SESSION);
//    $xtpl->assign('APP', $_SESSION['app']);
//    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
//    $xtpl->assign('ROL', $_SESSION['id_rol']);
//    $xtpl->assign('USUARIO', $_SESSION['usuario']);
//    $xtpl->assign('ULT', $_SESSION['ultimo']);
//    $xtpl->assign('DEPEN', $_SESSION['dependencia']);
//    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $aId['id']=1;
    $xtpl->assign('fecha', date('Y-m-d'));
    $xtpl->assign('fechaActual', date('d-m-Y'));
    $xtpl->assign('Year', date('Y'));

    $obj = new mapa(); // Se invoca la clase a ser utilizada.
    
    $xtpl->assign('MENU', $obj->menuMake($aId));
//    $obj->validar_session($_SESSION);    
    //echo $client = @$_SERVER['HTTP_CLIENT_IP'];
    //echo  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
//    $xtpl->assign('IP', $_SERVER['REMOTE_ADDR']);
//    $xtpl->assign('id_rol', $_SESSION['id_rol']);
    $xtpl->parse('main.idrol'); 

    $protocolizado_nivel_nacional= $obj->mostrar_protocolizado_nacional();
     while($row = $obj->extraer_arreglo($protocolizado_nivel_nacional)){
        $xtpl->assign('prot', $row[0]); 
        $xtpl->parse('main.prot');
    };
    
    $desarrollo_habitacional_nivel_nacional= $obj->mostrar_desarrollo_nacional();
     while($row = $obj->extraer_arreglo($desarrollo_habitacional_nivel_nacional)){
        $xtpl->assign('desa', $row[0]); 
         $id['id'] = $row[0];
        $xtpl->parse('main.desa');
    };
    
    $desarrollo_unidad_familiar_nivel_nacional= $obj->mostrar_unidad_familiar_nacional();
     while($row = $obj->extraer_arreglo($desarrollo_unidad_familiar_nivel_nacional)){
        $xtpl->assign('unh', $row[0]); 
        $xtpl->parse('main.unh');
    };
    
    $desarrollo_nivel_nacional= $obj->mostrar_conteo_desarrollo_nacional($id);
     while($row = $obj->extraer_arreglo($desarrollo_nivel_nacional)){
        $xtpl->assign('des_estado', $row[0]); 
        $xtpl->assign('des_conteo', $row[1]); 
        $xtpl->assign('des_por', $row[2]); 
        $xtpl->assign('des_idestado', $row[3]); 
        $xtpl->parse('main.conteo_desarrollo_nac');
    };

      
    $xtpl->parse('main');
    $xtpl->out('main');