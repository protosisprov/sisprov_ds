<?php

include_once("seniat.class.php");
$seniat = new seniat();
$id = $_GET['rif'];

if ($id) {
    $rif = $seniat->rif($id);
    $array = explode('(',utf8_encode(substr($rif, (strlen($id) + 1), strlen($rif))));
    echo $rif_corto=$array[0];    
}
?>
