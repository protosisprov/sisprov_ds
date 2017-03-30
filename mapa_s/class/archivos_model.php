<?php
include_once('../../../FDSoil/class/menu.model.php');

class archivos extends menu {
    
    //LISTAR LAS VARIABLES POR SECTOR
    function listar_variable_sector(){
    //echo $this->printQryFile('../../class/sql/mostrar/mostrar_variable_sector.sql', $_GET);die();
        return $this->exeQryFile('../../class/sql/listar/listar_variable_sector.sql', $_GET); 
    }
    
     //LISTAR LAS SUBCATEGORIAS POR SECTOR
    function listar_subcategoria_var(){
    //echo $this->printQryFile('../../class/sql/mostrar/mostrar_variable_sector.sql', $_GET);die();
        return $this->exeQryFile('../../class/sql/listar/listar_subcategoria_var.sql', $_GET); 
    }
    
    function listar_estados(){
//        echo $this->printQryFile("../../class/sql/listar/listar_estados.sql", $_GET);die();
        return $this->exeQryFile('../../class/sql/listar/listar_estados.sql', $_GET); 
    }  

    
    //*******************************
    
    //LISTAR LOS SECTORES
    function listar_sectores(){
        return $this->exeQryFile('../../class/sql/listar/listar_sectores.sql', $_GET); 
    }
        
}