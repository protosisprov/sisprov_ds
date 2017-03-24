<?php
include_once("onidex.class.php");
$obj = new onidex('saime');
$row = $obj->consultar($_GET['nac'], $_GET['num']);
echo $row["apellido1"].(($row["apellido2"]!=null)?" ".$row["apellido2"]:"").", ". $row["nombre1"].(($row["nombre2"]!=null)?" ".$row["nombre2"]:"");
?>





