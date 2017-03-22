<?php 
    session_start();
    header ('Content-type: text/html; charset=utf-8');
    include_once('../../packs/xtpl/xtemplate.class.php');
    include_once('../../class/functions.class.php');
    
//    print_r($_SESSION);
    $obj=new functions();
    $xtpl=new XTemplate('view.html');
    /* -------- FUENTES DE CAPCHAT------------*/
    $xtpl->assign('CAP', 'captcha.php');
//        print_r($_GET);
    /* -------------------------------------- */
    if ($_SESSION['semaforo']=="") {
        $_SESSION['semaforo'] = 0;
    }
    
    if ($_GET['app']!="") {
        $_SESSION['app'] = $_GET['app'];
    }
    /* -------- FUENTES DE Asignacion------------*/
    $xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
    $msg='';
    $xtpl->assign('APP', $_SESSION['app']);
    if(empty($_GET['q'])){
        $msg='';
    }else if($_GET['q']==1){
        $msg='<div id="id_msj_error">Usuario o Clave Incorrectos</div>';
        $_SESSION['semaforo']++;
    }else if($_GET['q']==2){
        $msg='<div id="id_msj_error">El Usuario no está Activo. Comuniquese con un Administrador del Sistema</div>';
        $_SESSION['semaforo']++;
    }else if($_GET['q']==3){
        $msg='<div id="id_msj_error">El captcha no se ha escrito correctamente. Intentelo de nuevo</div>';
        $_SESSION['semaforo']++;
    }

    $xtpl->assign('MENSAJE', $msg);
    $xtpl->assign('LOGO', $_SESSION['logo']);
    $xtpl->assign('SEMAFORO', $_SESSION['semaforo']);
    $xtpl->parse('main');
    $xtpl->out('main');	
?>