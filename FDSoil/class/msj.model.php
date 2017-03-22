<?php

include_once('menu.model.php');

class msj extends menu {

    function getMsj($aId) {
        //echo $this->printQryFile("../../../FDSoil/class/sql/msj/get_msj_select.sql", $aId);
        return $this->exeQryFile("../../../FDSoil/class/sql/msj/get_msj_select.sql", $aId);
    }  
    
    function listar_MsjDB() {
        return $this->exeQryFile("../../../FDSoil/class/sql/msj/select_msj_db.sql", null);
    }
    
    function select_MsjDB($Post) {
        //echo $this->printQryFile("../../class/sql/select_msj.sql", $Post);die();
        return $this->exeQryFile("../../../FDSoil/class/sql/msj/select_msj.sql", $Post);
    }
       
}

?>
