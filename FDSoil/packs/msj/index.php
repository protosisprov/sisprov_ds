<?php
session_start();
header('Content-Type: text/html;charset=utf-8');
include_once('../xtpl/xtemplate.class.php');
include_once('../../class/functions.class.php');
$fun = new functions();
$xtpl = new XTemplate('view.html');


$msj = '';
if ($_GET['msj'] == 1) {
    $msj = 'EL REGISTRO FUÈ ACTUALIZADO CON ÈXITO';  
} 
else if ($_GET['msj'] == 2) {
    $msj = 'EL REGISTRO FUÈ ELIMINADO CON ÈXITO';
} 
else if ($_GET['msj'] == 3) {
    $msj = 'EL REGISTRO FUÈ AGREGADO CON ÈXITO';
} 
else if ($_GET['msj'] == 4) {
    $msj = 'LA CONTRASEÑA FUE RESTABLECIDA CON ÈXITO, SERA ENVIADA A SU CORREO A LA BREVEDAD POSIBLE';
}    
else if ($_GET['msj'] == 5) {
    $msj = 'LA SOLICITUD FUÉ REALIZADA CON ÉXITO';
}
else if ($_GET['msj'] == 85) {
    $msj = 'ERROR: CORREO EL ELECTRONICO YA ESTA REGISTRADO POR OTRO USUARIO';    
}
else if ($_GET['msj'] == 88) {
    $msj = 'ERROR: DEBE COMPLETAR LOS DATOS DEL REGISTRO DE LA EMPRESA';    
}
else if ($_GET['msj'] == 89) {
    $msj = 'ERROR: LA PETICIÓN FUÉ REALIZADA CON ANTERIORIDAD';    
}
else if ($_GET['msj'] == 90) {
    $msj = 'NO TIENE INFORMACIÓN ASOCIADA';
} 
else if ($_GET['msj'] == 91) {
    $msj = 'ERROR CORREO NO ENVIADO. NOTIFIQUE AL ESPECIALISTA DEL SISTEMA';    
} 
else if ($_GET['msj'] == 92) {
    $msj = 'ERROR. EL PROCESO NO SE PUEDE APLICAR EN TODOS LOS REGISTROS';      
} 
else if ($_GET['msj'] == 93) {
    $msj = 'ERROR. RESPUESTA SECRETA INCORRECTA';    
} 
else if ($_GET['msj'] == 94) {
    $msj = 'ERROR. REGISTRO(S) ASOCIADO(S)';
} 
else if ($_GET['msj'] == 95) {
    $msj = 'ERROR, EXISTEN REGISTRO REPETIDOS';
} 
else if ($_GET['msj'] == 96) {
    $msj = 'ERROR. EL ID SUMINISTRADO NO ÈXISTE';
} 
else if ($_GET['msj'] == 97) {
    $msj = 'ERROR. ESTE ELEMENTO TIENE REGISTROS ASOCIADOS';
} 
else if ($_GET['msj'] == 98) {
    $msj = 'ERROR. EL REGISTRO ESTÀ REPETIDO';
} 
else if ($_GET['msj'] == 99) {
    $msj = 'ERROR DE EJECUCIÒN. NOTIFIQUE AL ESPECIALISTA DEL SISTEMA';
}
else {
    $msj = 'ERROR DE EJECUCIÒN DESCONOCIDO.';
}
($fun->isThereThisKeyInTheArray($_SESSION, 'messages')) ? msgList($msj, $xtpl) : msgOnly($msj, $xtpl);
if ($fun->isThereThisKeyInTheArray($_SESSION, 'dp')){
    $ndp=$_SESSION['dp'];
    unset($_SESSION['dp']);
}
else
    $ndp=$_GET['np'];
$xtpl->assign('NUM_MSJ', 1);
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