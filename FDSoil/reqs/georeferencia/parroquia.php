<?php
include_once('../../class/reqs.model.php');
$obj= new reqs(); 
echo $obj->resultToString($obj->listarParroquia($_GET),'#',"%");
?>