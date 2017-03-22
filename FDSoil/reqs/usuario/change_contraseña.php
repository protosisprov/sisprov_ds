<?php
    session_start();
    
    include_once('../../../FDSoil/class/usuario.model.php');
    
    $obj = new usuario();
    
    echo $obj->usuarioChangePswd($_POST);
    
    $_SESSION['dp']='../../../FDSoil/modulos/admin_inicio';
    
 /*  
 ** To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
