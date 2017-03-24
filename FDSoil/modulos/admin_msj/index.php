<?php
session_start();
header('Content-Type: text/html;charset=utf-8');
include_once('../../packs/xtpl/xtemplate.class.php');
include_once('../../class/msj.model.php');
$obj = new msj();
$xtpl = new XTemplate('view.html');
$xtpl->assign('APP', $_SESSION['app']);
$xtpl->assign('ID_CBE', $_SESSION['cabeza']);
$xtpl->assign('NOMBRE_APELLIDO', $_SESSION['nombre_apellido']);
$xtpl->assign('ULT', $_SESSION['ultimo']);
$xtpl->assign('HEAD', file_get_contents('../../../FDSoil/vista/head.html'));
$msj = '';
//GHIJKLMNOPQ
if ($_GET['msj'] == 'A') //1
    $msj = 'EL REGISTRO FUÉ ACTUALIZADO CON ÉXITO';  
else if ($_GET['msj'] == 'B') //2
    $msj = 'EL REGISTRO FUÉ ELIMINADO CON ÉXITO';
else if ($_GET['msj'] == 'C') //3
    $msj = 'EL REGISTRO FUÉ AGREGADO CON ÉXITO';
else if ($_GET['msj'] == 'D') //4
    $msj = 'LA CONTRASEÑA FUE RESTABLECIDA CON ÉXITO, SERÁ ENVIADA A SU CORREO';
else if ($_GET['msj'] == 'E') //6
    $msj = 'CONTRASEÑA RESETEADA CON ÉXITO';
else if ($_GET['msj'] == 'F') //7
    $msj = 'SU CLAVE FUE CAMBIADA CON ÉXITO, DEBE VOLVER A INGRESAR AL SISTEMA';
else if ($_GET['msj'] == 'R') //96
    $msj = 'ERROR. EL ID SUMINISTRADO NO ÉXISTE';
else if ($_GET['msj'] == 'S') //85
    $msj = 'ERROR: CORREO EL ELECTRONICO YA ESTA REGISTRADO POR OTRO USUARIO';
else if ($_GET['msj'] == 'T') //98
    $msj = 'ERROR. EL REGISTRO ESTÁ REPETIDO';
else if ($_GET['msj'] == 'U') //94-97
    $msj = 'ERROR. HAY REGISTRO(S) ASOCIADO(S)';
else if ($_GET['msj'] == 'V') //93
    $msj = 'ERROR. RESPUESTA SECRETA INCORRECTA';
else if ($_GET['msj'] == 'W') //91
    $msj = 'ERROR CORREO NO ENVIADO. NOTIFIQUE AL ESPECIALISTA DEL SISTEMA';
else if ($_GET['msj'] == 'X') //90
    $msj = 'NO TIENE INFORMACIÓN ASOCIADA';
else if ($_GET['msj'] == 'Y') //86
    $msj = 'POR RAZONES DE SEGURIDAD DEBE CAMBIAR SU CLAVE';
else if ($_GET['msj'] == 'Z') //99
    $msj = 'ERROR DE EJECUCIÓN. NOTIFIQUE AL ESPECIALISTA DEL SISTEMA';
else if ($_GET['msj'] == '1') //99
    $msj = 'ERROR CAMPOS SIN SELECCIONAR O VACIOS VERIFIQUE';
else{ 
    $aId['id']=$_GET['msj'];
    $row=$obj->extraer_registro($obj->getMsj($aId));
    $msj=($row[0]!=null)?$row[0]:'ERROR DE EJECUCIÒN DESCONOCIDO';
    }
($obj->isThereThisKeyInTheArray($_SESSION,'messages'))?msgList($msj,$xtpl):msgOnly($msj,$xtpl);
if ($obj->isThereThisKeyInTheArray($_SESSION, 'dp')){
    echo $ndp=$_SESSION['dp'];
    unset($_SESSION['dp']);
}

else

$ndp=$_GET['np'];
$xtpl->assign('NUM_PAG', $ndp);
$xtpl->parse('main');
$xtpl->out('main');
function msgOnly($msj, $xtpl) {    
    $xtpl->assign('CLASS_TR','lospare');
    $xtpl->assign('TITLE', 'Mensaje(s)');
    $xtpl->assign('MSG', $msj);
    $xtpl->parse('main.row');
}
function msgList($titulo, $xtpl) {
    $xtpl->assign('TITLE', $titulo);
    $array = $_SESSION['messages'];
    $classTR='losnone';
    for ($i = 0; $i < count($array); $i++) {
        $xtpl->assign('CLASS_TR',$classTR);
        $xtpl->assign('MSG', $array[$i]);
        $xtpl->parse('main.row');
        $classTR=($classTR=='losnone')?'lospare':'losnone';
    }
    unset($_SESSION['messages']);
}
?>
