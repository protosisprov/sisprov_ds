<?php

include_once('msj.model.php');

class rol extends msj {

    function rolList() {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/roles/list_select.sql", null);
    }

    function rolOptNivel_0() {
       return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/opt_0_select.sql", $_POST),'|',"%");
    }

    function rolOptNivel_1() {
       return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/opt_1_select.sql", $_POST),'|',"%");
    }

    function rolOptNivel_2() {
       return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/opt_2_select.sql", $_POST),'|',"%");
    }

    function rolOptNivel_3() {
       return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/opt_3_select.sql", $_POST),'|',"%");
    }

    function rolOpt() {
	$strArray0=$this->rolOptNivel_0();
	$strArray1=$this->rolOptNivel_1();
	$strArray2=$this->rolOptNivel_2();
	$strArray3=$this->rolOptNivel_3();
	$strArray0=substr($strArray0,0,strlen($strArray0));
	$strArray1=substr($strArray1,0,strlen($strArray1));
	$strArray2=substr($strArray2,0,strlen($strArray2));
	$strArray3=substr($strArray3,0,strlen($strArray3));
        return $strArray0.'$'.$strArray1.'$'.$strArray2.'$'.$strArray3;
        
    }
    function rolRow(){
        //echo $this->printQryFile("../../../FDSoil/class/sql/menu/roles/row_select.sql", $_POST);
	return $this->extraer_registro($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/row_select.sql", $_POST));
    }

    function rolRegister(){
	$row = $this->extraer_registro($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/row_register.sql", $_POST));
        return $row[0];        
    }
    
     function rolDelete(){
	$row = $this->extraer_registro($this->exeQryFile("../../../FDSoil/class/sql/menu/roles/row_delete.sql", $_POST));
        return $row[0];        
    }
    
}

?>
