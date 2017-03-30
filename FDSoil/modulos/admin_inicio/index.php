<?php {
    session_start();
    header('Content-type: text/html; charset=utf-8');
    include_once('../../packs/xtpl/xtemplate.class.php');
    include_once('../../../FDSoil/class/usuario.model.php');
    $obj = new usuario();
    $obj->validar_session();
    $obj->validarClaveUsuario();
    $xtpl = new XTemplate('view.html');
    $xtpl->assign('ID_USUARIO', $_SESSION['id_usuario']);
    $xtpl->assign('USUARIO', $_SESSION['usuario']);
    $xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
    $xtpl->assign('CEDULA', $_SESSION['cedula']);
    $xtpl->assign('APP', $_SESSION['app']);
    $aId['id']=$_SESSION['id_rol'];
    $xtpl->assign('MENU', $obj->menuMake($aId));
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $xtpl->rparse('main');
    $xtpl->out('main');
    
    ///***************Registro de los usuarios en la tabla de auditoria**********
//        $usuario = $obj->listar_datos_indicadores($id);
//        $valor=1;
//        while($row = $obj->extraer_arreglo($datos_indicador)){
//           // $obj->seeArray($row);die();
//            $xtpl->assign('VAL', 1); 
//            $xtpl->assign('NUM', $valor++); 
//            $xtpl->assign('ID', $row['idindi']); 
//            $xtpl->assign('DESC', $row['descripcion_tipoindicador']);    
//            $xtpl->assign('NOM', $row['nombre']);    
//            $xtpl->assign('META', $row['metas']);    
//            $xtpl->assign('TIPOIND', $row['id_tipoindicador']);    
//            $xtpl->assign('UNIME', $row['unidadmed']);    
//            $xtpl->assign('FREC', $row['descripcion_frecuencia']);    
//            $xtpl->assign('IDFREC', $row['id_frecuencia']);    
//            $xtpl->assign('FORMU', $row['descripcionformula']);    
//            $xtpl->assign('ORDEOPE', $row['orden_operador']);    
//            $xtpl->parse('main.inf_indicadores');
//        }  
        
}
?>
