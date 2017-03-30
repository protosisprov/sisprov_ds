<?php
session_start();
include_once("../../../FDSoil/class/bd_functions.class.php");

class onidex extends bd_functions {
    public function consultar($nac, $ci) {
        $sql = "select nacionalidad,cedula,nombre1,nombre2,apellido1,apellido2 from saime where nacionalidad = '$nac' AND cedula = '$ci'";
        $result = $this->exeQryStr($sql);
        $num_registros = $this->num_registros($result);
        if ($num_registros <= 0) 
            return array();
         else if ($num_registros > 0) 
            return $this->extraer_asociativo($result);
        else
            return null;
    }
}

?>
