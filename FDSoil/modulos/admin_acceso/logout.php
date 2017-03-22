<?php

	session_start();
        include_once('../../class/usuario.model.php');
        echo $app=$_SESSION['app'];
        $usuario=$_SESSION['id_usuario'];
        $obj=new usuario();
	session_unset();
	session_destroy();
        $obj->cerrarSession($usuario);
        
	header ("Location: ../../../".$app."/index.php");
?>
