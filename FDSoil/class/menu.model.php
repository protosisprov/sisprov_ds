<?php

include_once('../../../FDSoil/class/bd_functions.class.php');

class menu extends bd_functions {
    
    function menuStatusList() {
//        echo $this->printQryFile("../../../FDSoil/class/sql/menu/list_status_select.sql", null);die();
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/list_status_select.sql", null);
    }

    function menuNivel_0_list() {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n0_list_select.sql", null);
    }

    function menuNivel_0_rowEdit() {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n0_row_select.sql", $_POST);
    }

    function menuNivel_0_rowSave() {
//        echo $this->printQryFile("../../../FDSoil/class/sql/menu/n0_registro_pl.sql", $_POST);die();
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n0_registro_pl.sql", $_POST));
	return $row[0];
    }

    function menuNivel_0_rowDelete() {
	//echo $this->printQryFile("../../../FDSoil/class/sql/menu/n0_delete_pl.sql", $_POST);die();
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n0_delete_pl.sql", $_POST));
	return $row[0];
    }

    function menuNivel_0_combo() {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n0_combo_select.sql", null);
    }
    
    function menuNivel_0_idTitulo($aId) {
//        echo $this->printQryFile("../../../FDSoil/class/sql/menu/n0_id_titulo_select.sql", $aId);die();
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n0_id_titulo_select.sql", $aId);
    }

    function menuNivel_1_list_tabla($aId) {
        //echo $this->printQryFile("../../../FDSoil/class/sql/menu/n1_list_tabla_select.sql", $aId);die();
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n1_list_tabla_select.sql", $aId);
    }
    
    function menuNivel_1_rowEdit($aId) {
//        echo $this->printQryFile("../../../FDSoil/class/sql/menu/n1_row_select.sql", $aId);die();
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n1_row_select.sql", $aId);
    }
    
    function menuNivel_1_rowSave() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n1_registro_pl.sql", $_POST));
	return $row[0];
    }
    
    function menuNivel_1_rowDelete() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n1_delete_pl.sql", $_POST));
	return $row[0];
    }
    
    function menuNivel_1_list_combo($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n1_list_combo_select.sql", $aId);
    }
    
    function menuNivel_2_list_tabla($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n2_list_tabla_select.sql", $aId);
    }

    function menuNivel_1_idTitulo($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n1_id_titulo_select.sql", $aId);
    }
    
    function menuNivel_2_rowEdit($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n2_row_select.sql", $aId);
    }
    
    function menuNivel_2_rowSave() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n2_registro_pl.sql", $_POST));
	return $row[0];
    }
    
    function menuNivel_2_rowDelete() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n2_delete_pl.sql", $_POST));
	return $row[0];
    }
    
    function menuNivel_2_list_combo($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n2_list_combo_select.sql", $aId);
    }
    
    function menuNivel_3_list_tabla($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n3_list_tabla_select.sql", $aId);
    }
    
    function menuNivel_2_idTitulo($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n2_id_titulo_select.sql", $aId);
    }
    
    function menuNivel_3_rowEdit($aId) {
        return $this->exeQryFile("../../../FDSoil/class/sql/menu/n3_row_select.sql", $aId);
    }
    
    function menuNivel_3_rowSave() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n3_registro_pl.sql", $_POST));
	return $row[0];
    }
    
     function menuNivel_3_rowDelete() {
        $row = $this->extraer_arreglo($this->exeQryFile("../../../FDSoil/class/sql/menu/n3_delete_pl.sql", $_POST));
	return $row[0];
    }
    
    function menuNivel_0_optList() {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n0_opt_select.sql", null),'|',"%");
    }
    
    function menuNivel_1_optList() {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n1_opt_select.sql", null),'|',"%");
    }
    
    function menuNivel_2_optList() {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n2_opt_select.sql", null),'|',"%");
    }
    
    function menuNivel_3_optList() {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n3_opt_select.sql", null),'|',"%");
    }        
    
    function menuNivel_0_Crea($aId) {        
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n0_select.sql", $aId),'|',"%");
    }
    
    function menuNivel_1_Crea($aId) {        
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n1_select.sql", $aId),'|',"%");
    }
    
    function menuNivel_2_Crea($aId) {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n2_select.sql", $aId),'|',"%");
    }
    
    function menuNivel_3_Crea($aId) {
        return $this->resultToString($this->exeQryFile("../../../FDSoil/class/sql/menu/n3_select.sql", $aId),'|',"%");
    }
    
    function menuMake($aId) {        
        $strArray0=$this->menuNivel_0_Crea($aId);
        $strArray1=$this->menuNivel_1_Crea($aId);
        $strArray2=$this->menuNivel_2_Crea($aId);
        $strArray3=$this->menuNivel_3_Crea($aId);        
        $strArray0=substr($strArray0,0,strlen($strArray0));
        $strArray1=substr($strArray1,0,strlen($strArray1));
        $strArray2=substr($strArray2,0,strlen($strArray2));
        $strArray3=substr($strArray3,0,strlen($strArray3));        
        return $strArray0.'$'.$strArray1.'$'.$strArray2.'$'.$strArray3;
        
    }
    
    function menuOptMake() {        
        $strArray0=$this->menuNivel_0_optList();        
        $strArray1=$this->menuNivel_1_optList();
        $strArray2=$this->menuNivel_2_optList();
        $strArray3=$this->menuNivel_3_optList();        
        $strArray0=substr($strArray0,0,strlen($strArray0));
        $strArray1=substr($strArray1,0,strlen($strArray1));
        $strArray2=substr($strArray2,0,strlen($strArray2));
        $strArray3=substr($strArray3,0,strlen($strArray3));        
        return $strArray0.'$'.$strArray1.'$'.$strArray2.'$'.$strArray3;
    }
       
}

?>
