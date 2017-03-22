<?php session_start();

if ($_POST['semaforo'] > 1) {
    if ($_SESSION['tmptxt'] == $_POST['captcha']) {
        goto salto;
    } else {
        header("Location:index.php?q=3");
        die;
    }
}

salto:
    include_once('../../class/usuario.model.php');

    $obj = new usuario();

    $arrayLogin = $obj->tipoLogin();

    $Post['usuario'] = $arrayLogin['usuario'];

    $Post['campo'] = $arrayLogin['campo'];

    $Post['clave'] = md5($_POST['clave']);

    $result = $obj->validarAcceso($Post);

    if ($row = $obj->extraer_arreglo($result)) {
//        $obj->seeArray($row);die();
        if ($row['id_status'] == 1) {
            $obj->inicioSession($row);
//            echo ("../../../" . $_SESSION['app'] . $_SESSION['ruta']);die();
            header("Location:../../../" . $_SESSION['app'] . $_SESSION['ruta']);
        } else
            header("Location:index.php?q=2");
    } else {
        header("Location:index.php?q=1");
    }
?>